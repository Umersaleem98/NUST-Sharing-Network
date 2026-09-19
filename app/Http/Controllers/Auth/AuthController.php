<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display login form
    |--------------------------------------------------------------------------
    */

    public function showLoginForm(): View
    {
        return view('pages.auth.login');
    }
    
    public function showRegistrationForm(): View
    {
        return view('pages.auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | Process login request
    |--------------------------------------------------------------------------
    */

    public function login(
        Request $request
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Login validation
        |--------------------------------------------------------------------------
        */

        $validationRules = [
            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'donor',
                    'beneficiary',
                ]),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
            ],

            'remember' => [
                'nullable',
                'boolean',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | Qalam ID is required only for beneficiaries
        |--------------------------------------------------------------------------
        */

        if ($request->input('role') === 'beneficiary') {
            $validationRules['qalam_id'] = [
                'required',
                'string',
                'max:100',
            ];
        }

        $validated = $request->validate(
            $validationRules,
            [
                'role.required' =>
                    'Please select your account role.',

                'role.in' =>
                    'The selected role is invalid.',

                'email.required' =>
                    'Please enter your email address.',

                'email.email' =>
                    'Please enter a valid email address.',

                'password.required' =>
                    'Please enter your password.',

                'qalam_id.required' =>
                    'Qalam ID is required for beneficiary login.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Find user using email and selected role
        |--------------------------------------------------------------------------
        */

        $userQuery = User::query()
            ->where('email', $validated['email'])
            ->where('role', $validated['role']);

        /*
        |--------------------------------------------------------------------------
        | Check Qalam ID for beneficiary
        |--------------------------------------------------------------------------
        */

        if ($validated['role'] === 'beneficiary') {
            $userQuery->where(
                'qalam_id',
                $validated['qalam_id']
            );
        }

        $user = $userQuery->first();

        /*
        |--------------------------------------------------------------------------
        | Verify user and password
        |--------------------------------------------------------------------------
        |
        | Account status is checked only after verifying the password. This
        | prevents unauthorized people from checking another user's status.
        |
        */

        if (
            ! $user
            || ! Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'login' =>
                        'The provided login information is incorrect.',
                ])
                ->withInput(
                    $request->except([
                        'password',
                        'remember',
                    ])
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent suspended users from logging in
        |--------------------------------------------------------------------------
        */

        if ($user->account_status === 'suspended') {
            Log::warning(
                'Suspended user attempted to log in.',
                [
                    'user_id' => $user->id,
                    'role' => $user->role,
                    'ip_address' => $request->ip(),
                ]
            );

            return back()
                ->withErrors([
                    'login' =>
                        'Your account has been suspended. Please contact the administrator.',
                ])
                ->with(
                    'account_status',
                    'suspended'
                )
                ->withInput(
                    $request->except([
                        'password',
                        'remember',
                    ])
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent blocked users from logging in
        |--------------------------------------------------------------------------
        */

        if ($user->account_status === 'blocked') {
            Log::warning(
                'Blocked user attempted to log in.',
                [
                    'user_id' => $user->id,
                    'role' => $user->role,
                    'ip_address' => $request->ip(),
                ]
            );

            return back()
                ->withErrors([
                    'login' =>
                        'Your account has been blocked. Please contact the administrator.',
                ])
                ->with(
                    'account_status',
                    'blocked'
                )
                ->withInput(
                    $request->except([
                        'password',
                        'remember',
                    ])
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Reject any unknown account status
        |--------------------------------------------------------------------------
        */

        if ($user->account_status !== 'active') {
            Log::warning(
                'User with an invalid account status attempted to log in.',
                [
                    'user_id' => $user->id,
                    'account_status' =>
                        $user->account_status,

                    'ip_address' => $request->ip(),
                ]
            );

            return back()
                ->withErrors([
                    'login' =>
                        'Your account is currently unavailable. Please contact the administrator.',
                ])
                ->withInput(
                    $request->except([
                        'password',
                        'remember',
                    ])
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Donors must verify their email address before login
        |--------------------------------------------------------------------------
        */

        if (
            $user->role === 'donor'
            && ! $user->hasVerifiedEmail()
        ) {
            return redirect()
                ->route('verification.notice')
                ->with('email', $user->email)
                ->with(
                    'status',
                    'Please verify your email address before signing in.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Log in active user
        |--------------------------------------------------------------------------
        */

        Auth::login(
            $user,
            $request->boolean('remember')
        );

        /*
        | Regenerate the session ID to prevent session fixation.
        */

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Redirect authenticated user
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->intended(route('dashboard'))
            ->with(
                'success',
                'Welcome back, ' . $user->name . '!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Log out user
    |--------------------------------------------------------------------------
    */

    public function register(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => 'donor',
            'qalam_id' => null,
            'password' => Hash::make($validated['password']),
            'account_status' => 'active',
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()
            ->route('verification.notice')
            ->with('email', $user->email)
            ->with(
                'status',
                'Your donor account has been created. We sent a verification link to your email address.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Display email verification notice
    |--------------------------------------------------------------------------
    */

    public function showEmailVerificationNotice(): View
    {
        return view('pages.auth.verify-email');
    }

    /*
    |--------------------------------------------------------------------------
    | Verify donor email, log the donor in, and redirect to dashboard
    |--------------------------------------------------------------------------
    */

    public function verifyEmail(
        Request $request,
        int $id,
        string $hash
    ): RedirectResponse {
        $user = User::query()
            ->where('id', $id)
            ->where('role', 'donor')
            ->firstOrFail();

        if (
            ! hash_equals(
                (string) $hash,
                sha1($user->getEmailForVerification())
            )
        ) {
            abort(403, 'This email verification link is invalid.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Your email address has been verified successfully. Welcome, '
                    . $user->name . '!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Resend donor email verification link
    |--------------------------------------------------------------------------
    */

    public function resendEmailVerification(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],
        ]);

        $user = User::query()
            ->where('email', $validated['email'])
            ->where('role', 'donor')
            ->first();

        if (! $user) {
            return back()
                ->withErrors([
                    'email' => 'No donor account was found with this email address.',
                ])
                ->withInput();
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Your email address is already verified. You can sign in now.'
                );
        }

        $user->sendEmailVerificationNotification();

        return back()
            ->with('email', $user->email)
            ->with(
                'status',
                'A new verification link has been sent to your email address.'
            );
    }



    /*
    |--------------------------------------------------------------------------
    | Display Forgot Password Form
    |--------------------------------------------------------------------------
    */

    public function showForgotPasswordForm(): View
    {
        return view(
            'pages.auth.forgotpassword'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Send Password Reset Link
    |--------------------------------------------------------------------------
    */

    public function sendPasswordResetLink(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate(
            [
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'exists:users,email',
                ],
            ],
            [
                'email.required' =>
                    'Please enter your registered email address.',

                'email.email' =>
                    'Please enter a valid email address.',

                'email.exists' =>
                    'No account was found with this email address.',
            ]
        );


        $status = Password::sendResetLink([
            'email' => $validated['email'],
        ]);


        if ($status === Password::RESET_LINK_SENT) {
            return back()
                ->with(
                    'status',
                    'A secure password reset link has been sent to your email address.'
                )
                ->with(
                    'email',
                    $validated['email']
                );
        }


        return back()
            ->withErrors([
                'email' => __($status),
            ])
            ->withInput(
                $request->only('email')
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Display Reset Password Form
    |--------------------------------------------------------------------------
    */

    public function showResetPasswordForm(
        Request $request,
        string $token
    ): View {
        return view(
            'pages.auth.resetpassword',
            [
                'token' => $token,
                'email' => $request->query('email'),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    */

    public function resetPassword(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate(
            [
                'token' => [
                    'required',
                    'string',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'exists:users,email',
                ],

                'password' => [
                    'required',
                    'confirmed',
                    PasswordRule::min(8)
                        ->max(64)
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                ],

                'password_confirmation' => [
                    'required',
                    'string',
                ],
            ],
            [
                'token.required' =>
                    'The password reset token is missing.',

                'email.required' =>
                    'Please enter your registered email address.',

                'email.email' =>
                    'Please enter a valid email address.',

                'email.exists' =>
                    'No account was found with this email address.',

                'password.required' =>
                    'Please enter your new password.',

                'password.confirmed' =>
                    'The password confirmation does not match.',

                'password_confirmation.required' =>
                    'Please confirm your new password.',
            ]
        );


        $status = Password::reset(
            [
                'email' =>
                    $validated['email'],

                'password' =>
                    $validated['password'],

                'password_confirmation' =>
                    $validated['password_confirmation'],

                'token' =>
                    $validated['token'],
            ],
            function (
                User $user,
                string $password
            ): void {
                $user->forceFill([
                    'password' =>
                        Hash::make($password),
                ]);

                $user->setRememberToken(
                    Str::random(60)
                );

                $user->save();

                event(
                    new PasswordReset($user)
                );
            }
        );


        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Your password has been reset successfully. You can now sign in with your new password.'
                );
        }


        return back()
            ->withErrors([
                'email' => __($status),
            ])
            ->withInput(
                $request->only('email')
            );
    }


    public function logout(
        Request $request
    ): RedirectResponse {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }
}

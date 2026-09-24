<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Page
    |--------------------------------------------------------------------------
    */

    public function loginPage()
    {
        return view('pages.auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate(
            [
                'role' => [
                    'required',
                    'in:admin,donor,beneficiary',
                ],

                'email' => [
                    'required',
                    'email',
                ],

                'password' => [
                    'required',
                    'string',
                ],
            ],
            [
                'role.required' =>
                    'Please select your account type.',

                'role.in' =>
                    'Please select a valid account type.',

                'email.required' =>
                    'Email address is required.',

                'email.email' =>
                    'Please enter a valid email address.',

                'password.required' =>
                    'Password is required.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Beneficiary Qalam Validation
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'beneficiary') {

            $request->validate(
                [
                    'qalam_id' => [
                        'required',
                        'regex:/^\d+$/',
                    ],
                ],
                [
                    'qalam_id.required' =>
                        'Qalam ID is required for beneficiary login.',

                    'qalam_id.regex' =>
                        'Qalam ID must contain numbers only.',
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Find User
        |--------------------------------------------------------------------------
        */

        $user = User::where(
            'email',
            strtolower(
                trim(
                    $request->email
                )
            )
        )
            ->where(
                'role',
                $request->role
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | User Not Found
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            return back()
                ->withErrors([
                    'email' =>
                        'No account was found with the selected role and email address.',
                ])
                ->withInput(
                    $request->only([
                        'role',
                        'email',
                        'qalam_id',
                    ])
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Beneficiary Qalam ID Check
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'beneficiary') {

            if (
                (string) $user->qalam_id !==
                trim($request->qalam_id)
            ) {

                return back()
                    ->withErrors([
                        'qalam_id' =>
                            'The provided Qalam ID is incorrect.',
                    ])
                    ->withInput(
                        $request->only([
                            'role',
                            'email',
                            'qalam_id',
                        ])
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Password Check
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $request->password,
                $user->password
            )
        ) {

            return back()
                ->withErrors([
                    'password' =>
                        'The provided password is incorrect.',
                ])
                ->withInput(
                    $request->only([
                        'role',
                        'email',
                        'qalam_id',
                    ])
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Profile Status Check
        |--------------------------------------------------------------------------
        |
        | Only users with profile_status = active may login.
        |--------------------------------------------------------------------------
        */

        $statusError =
            $this->profileStatusError(
                $user
            );


        if ($statusError) {

            return back()
                ->withErrors([
                    'email' =>
                        $statusError,
                ])
                ->withInput(
                    $request->only([
                        'role',
                        'email',
                        'qalam_id',
                    ])
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Email Verification Check
        |--------------------------------------------------------------------------
        */

        if (
            is_null(
                $user->email_verified_at
            )
        ) {

            $request->session()->put(
                'pending_verification_user_id',
                $user->id
            );


            $request->session()->put(
                'verification_email',
                $user->email
            );


            $request->session()->put(
                'pending_remember',
                $request->boolean(
                    'remember'
                )
            );


            return redirect()
                ->route(
                    'verification.notice'
                )
                ->with(
                    'warning',
                    'Your email address is not verified. Please verify your email before logging in.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Login User
        |--------------------------------------------------------------------------
        */

        Auth::login(
            $user,
            $request->boolean(
                'remember'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request
            ->session()
            ->regenerate();


        /*
        |--------------------------------------------------------------------------
        | One Dashboard For All Roles
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Welcome back, ' .
                $user->name .
                '.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Registration Page
    |--------------------------------------------------------------------------
    */

    public function registerPage()
    {
        return view(
            'pages.auth.register'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'role' => [
                    'required',
                    'in:donor,beneficiary',
                ],

                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8),
                ],
            ],
            [
                'name.required' =>
                    'Full name is required.',

                'email.required' =>
                    'Email address is required.',

                'email.email' =>
                    'Please enter a valid email address.',

                'email.unique' =>
                    'This email address is already registered.',

                'role.required' =>
                    'Please select an account type.',

                'role.in' =>
                    'Please select a valid account type.',

                'password.required' =>
                    'Password is required.',

                'password.confirmed' =>
                    'Password confirmation does not match.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Beneficiary Qalam Validation
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'beneficiary') {

            $request->validate(
                [
                    'qalam_id' => [
                        'required',
                        'regex:/^\d+$/',
                        'max:30',
                        'unique:users,qalam_id',
                    ],
                ],
                [
                    'qalam_id.required' =>
                        'Qalam ID is required for beneficiaries.',

                    'qalam_id.regex' =>
                        'Qalam ID must contain numbers only.',

                    'qalam_id.unique' =>
                        'This Qalam ID is already registered.',
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' =>
                trim(
                    $request->name
                ),

            'email' =>
                strtolower(
                    trim(
                        $request->email
                    )
                ),

            'qalam_id' =>
                $request->role === 'beneficiary'
                    ? trim(
                        $request->qalam_id
                    )
                    : null,

            'password' =>
                Hash::make(
                    $request->password
                ),

            'role' =>
                $request->role,

            /*
            |--------------------------------------------------------------------------
            | Default Profile Status
            |--------------------------------------------------------------------------
            */

            'profile_status' =>
                'active',

            'email_verified_at' =>
                null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Verification Token
        |--------------------------------------------------------------------------
        */

        $plainToken =
            Str::random(64);


        /*
        |--------------------------------------------------------------------------
        | Save Token Hash
        |--------------------------------------------------------------------------
        */

        $user->update([
            'email_verification_token' =>
                hash(
                    'sha256',
                    $plainToken
                ),

            'email_verification_token_expires_at' =>
                now()->addMinutes(60),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Send Verification Email
        |--------------------------------------------------------------------------
        */

        $user->notify(
            new VerifyEmailNotification(
                $plainToken
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Verification Session
        |--------------------------------------------------------------------------
        */

        $request->session()->put(
            'pending_verification_user_id',
            $user->id
        );


        $request->session()->put(
            'verification_email',
            $user->email
        );


        $request->session()->put(
            'pending_remember',
            false
        );


        /*
        |--------------------------------------------------------------------------
        | Verification Page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'verification.notice'
            )
            ->with(
                'success',
                'Your account has been created successfully. A verification email has been sent to ' .
                $user->email .
                '.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Verification Notice
    |--------------------------------------------------------------------------
    */

    public function verificationNotice(
        Request $request
    ) {
        $userId =
            $request
                ->session()
                ->get(
                    'pending_verification_user_id'
                );


        /*
        |--------------------------------------------------------------------------
        | Verification Session Missing
        |--------------------------------------------------------------------------
        */

        if (!$userId) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'Please login to continue email verification.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Find User
        |--------------------------------------------------------------------------
        */

        $user =
            User::find(
                $userId
            );


        /*
        |--------------------------------------------------------------------------
        | User Not Found
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            $this->clearVerificationSession(
                $request
            );


            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'User account could not be found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Profile Status Check
        |--------------------------------------------------------------------------
        */

        $statusError =
            $this->profileStatusError(
                $user
            );


        if ($statusError) {

            $this->clearVerificationSession(
                $request
            );


            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        $statusError,
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Already Verified
        |--------------------------------------------------------------------------
        */

        if (
            !is_null(
                $user->email_verified_at
            )
        ) {

            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Your email address is already verified. Please login.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Verification Page
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.auth.email.verification-notice'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Verify Email
    |--------------------------------------------------------------------------
    */

    public function verifyEmail(
        Request $request,
        User $user,
        string $token
    ) {
        /*
        |--------------------------------------------------------------------------
        | Profile Status Check
        |--------------------------------------------------------------------------
        */

        $statusError =
            $this->profileStatusError(
                $user
            );


        if ($statusError) {

            $this->clearVerificationSession(
                $request
            );


            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        $statusError,
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Already Verified
        |--------------------------------------------------------------------------
        */

        if (
            !is_null(
                $user->email_verified_at
            )
        ) {

            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Your email address is already verified. Please login.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Verification Token Exists
        |--------------------------------------------------------------------------
        */

        if (
            is_null(
                $user->email_verification_token
            )
        ) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'The verification link is invalid.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Hash Verification Token
        |--------------------------------------------------------------------------
        */

        $hashedToken =
            hash(
                'sha256',
                $token
            );


        /*
        |--------------------------------------------------------------------------
        | Verification Token Match
        |--------------------------------------------------------------------------
        */

        if (
            !hash_equals(
                $user->email_verification_token,
                $hashedToken
            )
        ) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'The verification link is invalid.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Expiration Check
        |--------------------------------------------------------------------------
        */

        if (
            is_null(
                $user
                    ->email_verification_token_expires_at
            )
            ||
            now()->greaterThan(
                $user
                    ->email_verification_token_expires_at
            )
        ) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'The verification link has expired. Please login and request a new verification email.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Verify User
        |--------------------------------------------------------------------------
        */

        $user->update([
            'email_verified_at' =>
                now(),

            'email_verification_token' =>
                null,

            'email_verification_token_expires_at' =>
                null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Refresh User
        |--------------------------------------------------------------------------
        */

        $user->refresh();


        /*
        |--------------------------------------------------------------------------
        | Final Profile Status Check
        |--------------------------------------------------------------------------
        |
        | Prevent login if the administrator changed the status while
        | the verification process was taking place.
        |--------------------------------------------------------------------------
        */

        $statusError =
            $this->profileStatusError(
                $user
            );


        if ($statusError) {

            $this->clearVerificationSession(
                $request
            );


            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        $statusError,
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Remember Login
        |--------------------------------------------------------------------------
        */

        $remember =
            $request
                ->session()
                ->get(
                    'pending_remember',
                    false
                );


        /*
        |--------------------------------------------------------------------------
        | Login Verified User
        |--------------------------------------------------------------------------
        */

        Auth::login(
            $user,
            $remember
        );


        /*
        |--------------------------------------------------------------------------
        | Clear Verification Session
        |--------------------------------------------------------------------------
        */

        $this->clearVerificationSession(
            $request
        );


        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request
            ->session()
            ->regenerate();


        /*
        |--------------------------------------------------------------------------
        | One Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Your email address has been verified successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Resend Verification
    |--------------------------------------------------------------------------
    */

    public function resendVerification(
        Request $request
    ) {
        /*
        |--------------------------------------------------------------------------
        | Get Pending User
        |--------------------------------------------------------------------------
        */

        $userId =
            $request
                ->session()
                ->get(
                    'pending_verification_user_id'
                );


        if (!$userId) {

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'Please login again to continue.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Find User
        |--------------------------------------------------------------------------
        */

        $user =
            User::find(
                $userId
            );


        /*
        |--------------------------------------------------------------------------
        | User Not Found
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            $this->clearVerificationSession(
                $request
            );


            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        'User account could not be found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Profile Status Check
        |--------------------------------------------------------------------------
        */

        $statusError =
            $this->profileStatusError(
                $user
            );


        if ($statusError) {

            $this->clearVerificationSession(
                $request
            );


            return redirect()
                ->route('login')
                ->withErrors([
                    'email' =>
                        $statusError,
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Already Verified
        |--------------------------------------------------------------------------
        */

        if (
            !is_null(
                $user->email_verified_at
            )
        ) {

            $this->clearVerificationSession(
                $request
            );


            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Your email address is already verified.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Generate New Token
        |--------------------------------------------------------------------------
        */

        $plainToken =
            Str::random(64);


        /*
        |--------------------------------------------------------------------------
        | Store New Token
        |--------------------------------------------------------------------------
        */

        $user->update([
            'email_verification_token' =>
                hash(
                    'sha256',
                    $plainToken
                ),

            'email_verification_token_expires_at' =>
                now()->addMinutes(60),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Send Verification Email
        |--------------------------------------------------------------------------
        */

        $user->notify(
            new VerifyEmailNotification(
                $plainToken
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return back()
            ->with(
                'success',
                'A new verification email has been sent to ' .
                $user->email .
                '.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(
        Request $request
    ) {
        /*
        |--------------------------------------------------------------------------
        | Logout User
        |--------------------------------------------------------------------------
        */

        Auth::logout();


        /*
        |--------------------------------------------------------------------------
        | Invalidate Session
        |--------------------------------------------------------------------------
        */

        $request
            ->session()
            ->invalidate();


        /*
        |--------------------------------------------------------------------------
        | Regenerate CSRF Token
        |--------------------------------------------------------------------------
        */

        $request
            ->session()
            ->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | Login Page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Profile Status Error
    |--------------------------------------------------------------------------
    |
    | Only active accounts are allowed to authenticate.
    |--------------------------------------------------------------------------
    */

    private function profileStatusError(
        User $user
    ): ?string {
        /*
        |--------------------------------------------------------------------------
        | Suspended
        |--------------------------------------------------------------------------
        */

        if (
            $user->profile_status ===
            'suspended'
        ) {

            return
                'Your account has been suspended. Please contact the administrator for assistance.';
        }


        /*
        |--------------------------------------------------------------------------
        | Blocked
        |--------------------------------------------------------------------------
        */

        if (
            $user->profile_status ===
            'blocked'
        ) {

            return
                'Your account has been blocked. Please contact the administrator for assistance.';
        }


        /*
        |--------------------------------------------------------------------------
        | Invalid / Unknown Status
        |--------------------------------------------------------------------------
        */

        if (
            $user->profile_status !==
            'active'
        ) {

            return
                'Your account is currently unavailable. Please contact the administrator for assistance.';
        }


        /*
        |--------------------------------------------------------------------------
        | Active
        |--------------------------------------------------------------------------
        */

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Clear Verification Session
    |--------------------------------------------------------------------------
    */

    private function clearVerificationSession(
        Request $request
    ): void {
        $request
            ->session()
            ->forget([
                'pending_verification_user_id',
                'verification_email',
                'pending_remember',
            ]);
    }
}
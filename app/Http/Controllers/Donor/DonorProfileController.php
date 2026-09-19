<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class DonorProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Donor Profile
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        $user = Auth::user();

        abort_if(! $user || $user->role !== 'donor', 403);

        $user->load('donorProfile');

        $profileFields = [
            $user->name,
            $user->email,
            $user->phone,
            $user->image,
            $user->donorProfile?->organization,
            $user->donorProfile?->designation,
            $user->donorProfile?->country,
            $user->donorProfile?->address,
        ];

        $completedFields = collect($profileFields)
            ->filter(fn ($value) => filled($value))
            ->count();

        $profileCompletion = (int) round(
            ($completedFields / count($profileFields)) * 100
        );

        return view(
            'pages.donor.profile.index',
            compact('user', 'profileCompletion')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update Donor Profile
    |--------------------------------------------------------------------------
    */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        abort_if(! $user || $user->role !== 'donor', 403);

        $validated = $request->validate(
            [
                'phone' => [
                    'nullable',
                    'string',
                    'max:20',
                ],

                'organization' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'designation' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'country' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'address' => [
                    'nullable',
                    'string',
                    'max:500',
                ],

                'image' => [
                    'nullable',
                    'file',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:200',
                ],

                'current_password' => [
                    'nullable',
                    'string',
                    'required_with:password',
                ],

                'password' => [
                    'nullable',
                    'required_with:password_confirmation',
                    'string',
                    'min:8',
                    'max:255',
                    'confirmed',
                ],

                'password_confirmation' => [
                    'nullable',
                    'required_with:password',
                    'string',
                    'min:8',
                    'max:255',
                ],
            ],
            [
                'image.image' =>
                    'The selected profile file must be a valid image.',

                'image.mimes' =>
                    'The profile image must be a JPG, JPEG, PNG or WebP file.',

                'image.max' =>
                    'The profile image must not be larger than 200 KB.',

                'current_password.required_with' =>
                    'Please enter your current password before setting a new password.',

                'password.required_with' =>
                    'Please enter a new password.',

                'password.min' =>
                    'The new password must be at least 8 characters.',

                'password.confirmed' =>
                    'The new password and confirmation do not match.',

                'password_confirmation.required_with' =>
                    'Please confirm your new password.',
            ]
        );

        if (
            ! empty($validated['password'])
            && ! Hash::check(
                (string) ($validated['current_password'] ?? ''),
                $user->password
            )
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'current_password' =>
                        'The current password you entered is incorrect.',
                ]);
        }

        $uploadPath = public_path('admins/asset/profilephoto');
        $oldImageName = $user->image;
        $newImageName = null;

        try {
            if ($request->hasFile('image')) {
                File::ensureDirectoryExists(
                    $uploadPath,
                    0755,
                    true
                );

                if (! is_writable($uploadPath)) {
                    throw new \RuntimeException(
                        'Profile image directory is not writable: '.$uploadPath
                    );
                }

                $image = $request->file('image');

                if (! $image || ! $image->isValid()) {
                    throw new \RuntimeException(
                        'The uploaded profile image is not valid.'
                    );
                }

                $extension = strtolower(
                    $image->extension()
                    ?: $image->getClientOriginalExtension()
                );

                if ($extension === 'jpeg') {
                    $extension = 'jpg';
                }

                $newImageName =
                    'donor-'
                    .$user->id
                    .'-'
                    .Str::uuid()
                    .'.'
                    .$extension;

                $image->move(
                    $uploadPath,
                    $newImageName
                );
            }

            DB::transaction(
                function () use (
                    $user,
                    $validated,
                    $newImageName
                ): void {
                    $user->phone =
                        $validated['phone'] ?? null;

                    if ($newImageName) {
                        $user->image = $newImageName;
                    }

                    if (! empty($validated['password'])) {
                        $user->password = Hash::make(
                            $validated['password']
                        );
                    }

                    $user->save();

                    $user->donorProfile()->updateOrCreate(
                        [
                            'user_id' => $user->id,
                        ],
                        [
                            'organization' =>
                                $validated['organization'] ?? null,

                            'designation' =>
                                $validated['designation'] ?? null,

                            'country' =>
                                $validated['country'] ?? null,

                            'address' =>
                                $validated['address'] ?? null,
                        ]
                    );
                }
            );

            if (
                $newImageName
                && $oldImageName
                && $oldImageName !== $newImageName
            ) {
                $oldImagePath =
                    $uploadPath.DIRECTORY_SEPARATOR.$oldImageName;

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            return back()->with(
                'success',
                'Profile updated successfully.'
            );
        } catch (Throwable $exception) {
            if ($newImageName) {
                $newImagePath =
                    $uploadPath.DIRECTORY_SEPARATOR.$newImageName;

                if (File::exists($newImagePath)) {
                    File::delete($newImagePath);
                }
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Your profile could not be updated. Please try again.'
                );
        }
    }
}

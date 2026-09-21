<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

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

        abort_if(
            ! $user || $user->role !== 'donor',
            403
        );

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
            ->filter()
            ->count();

        $profileCompletion = (int) round(
            ($completedFields / count($profileFields)) * 100
        );

        return view(
            'pages.donor.profile.index',
            compact(
                'user',
                'profileCompletion'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Donor Profile
    |--------------------------------------------------------------------------
    */

    public function update(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Get Authenticated Donor
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'donor',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

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
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:200',
                ],

                'current_password' => [
                    'nullable',
                    'required_with:password',
                    'string',
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
                    'The profile image must be JPG, JPEG, PNG or WebP.',

                'image.max' =>
                    'The profile image must not exceed 200 KB.',

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


        /*
        |--------------------------------------------------------------------------
        | Verify Current Password
        |--------------------------------------------------------------------------
        */

        if (
            ! empty($validated['password'])
            && ! Hash::check(
                $validated['current_password'] ?? '',
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


        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        |
        | Image location:
        |
        | public/admins/asset/profilephoto/
        |
        */

        $oldImage = $user->image;

        if ($request->hasFile('image')) {

            $uploadPath = public_path(
                'admins/asset/profilephoto'
            );

            File::ensureDirectoryExists(
                $uploadPath
            );

            $image = $request->file('image');

            $extension = strtolower(
                $image->getClientOriginalExtension()
            );

            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }

            $imageName =
                'donor-'
                . $user->id
                . '-'
                . Str::uuid()
                . '.'
                . $extension;

            $image->move(
                $uploadPath,
                $imageName
            );

            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if ($oldImage) {

                $oldImagePath = public_path(
                    'admins/asset/profilephoto/'
                    . basename($oldImage)
                );

                if (File::exists($oldImagePath)) {

                    File::delete($oldImagePath);
                }
            }

            $user->image = $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->phone = ! empty($validated['phone'])
            ? trim($validated['phone'])
            : null;


        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['password'])) {

            $user->password = Hash::make(
                $validated['password']
            );
        }


        $user->save();


        /*
        |--------------------------------------------------------------------------
        | Update Donor Profile
        |--------------------------------------------------------------------------
        */

        $user->donorProfile()->updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'organization' =>
                    ! empty($validated['organization'])
                        ? trim($validated['organization'])
                        : null,

                'designation' =>
                    ! empty($validated['designation'])
                        ? trim($validated['designation'])
                        : null,

                'country' =>
                    ! empty($validated['country'])
                        ? trim($validated['country'])
                        : null,

                'address' =>
                    ! empty($validated['address'])
                        ? trim($validated['address'])
                        : null,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Profile updated successfully.'
        );
    }
}
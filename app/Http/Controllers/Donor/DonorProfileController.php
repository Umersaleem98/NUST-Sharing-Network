<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\DonorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class DonorProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    public function show()
    {
        $user = Auth::user();


        $profile = DonorProfile::firstOrCreate(
            [
                'user_id' => $user->id,
            ]
        );


        return view(
            'pages.donor.profile.show',
            compact(
                'user',
                'profile'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Profile
    |--------------------------------------------------------------------------
    */

    public function edit()
    {
        $user = Auth::user();


        $profile = DonorProfile::firstOrCreate(
            [
                'user_id' => $user->id,
            ]
        );


        return view(
            'pages.donor.profile.edit',
            compact(
                'user',
                'profile'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $user = Auth::user();


        $profile = DonorProfile::firstOrCreate(
            [
                'user_id' => $user->id,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'users',
                    'email'
                )->ignore(
                    $user->id
                ),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
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

            /*
            |--------------------------------------------------------------------------
            | Country Type
            |--------------------------------------------------------------------------
            */

            'country_type' => [
                'required',

                Rule::in([
                    'pakistan',
                    'other',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | Pakistan Location
            |--------------------------------------------------------------------------
            */

            'pakistan_state' => [
                'required_if:country_type,pakistan',
                'nullable',
                'string',
                'max:255',
            ],

            'pakistan_city' => [
                'required_if:country_type,pakistan',
                'nullable',
                'string',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Other Country
            |--------------------------------------------------------------------------
            */

            'manual_country' => [
                'required_if:country_type,other',
                'nullable',
                'string',
                'max:255',
            ],

            'manual_state' => [
                'required_if:country_type,other',
                'nullable',
                'string',
                'max:255',
            ],

            'manual_city' => [
                'required_if:country_type,other',
                'nullable',
                'string',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Profile Image
            |--------------------------------------------------------------------------
            */

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Detect Email Change
        |--------------------------------------------------------------------------
        */

        $oldEmail =
            $user->email;

        $newEmail =
            strtolower(
                trim(
                    $request->email
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->name =
            trim(
                $request->name
            );

        $user->email =
            $newEmail;


        /*
        |--------------------------------------------------------------------------
        | Reset Verification When Email Changes
        |--------------------------------------------------------------------------
        */

        if ($oldEmail !== $newEmail) {

            $user->email_verified_at =
                null;

            $user->email_verification_token =
                null;

            $user->email_verification_token_expires_at =
                null;
        }


        $user->save();


        /*
        |--------------------------------------------------------------------------
        | Location
        |--------------------------------------------------------------------------
        */

        if ($request->country_type === 'pakistan') {

            $country =
                'Pakistan';

            $state =
                trim(
                    $request->pakistan_state
                );

            $city =
                trim(
                    $request->pakistan_city
                );

        } else {

            $country =
                trim(
                    $request->manual_country
                );

            $state =
                trim(
                    $request->manual_state
                );

            $city =
                trim(
                    $request->manual_city
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Profile
        |--------------------------------------------------------------------------
        */

        $profile->phone =
            $request->phone;

        $profile->organization =
            $request->organization;

        $profile->designation =
            $request->designation;

        $profile->country =
            $country;

        $profile->state =
            $state;

        $profile->city =
            $city;


        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_image')) {

            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if ($profile->profile_image) {

                $oldImagePath =
                    public_path(
                        'donors/images/profiles/'
                        .$profile->profile_image
                    );


                if (
                    File::exists(
                        $oldImagePath
                    )
                ) {

                    File::delete(
                        $oldImagePath
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Destination
            |--------------------------------------------------------------------------
            */

            $destinationPath =
                public_path(
                    'donors/images/profiles'
                );


            if (!File::exists($destinationPath)) {

                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true
                );
            }


            /*
            |--------------------------------------------------------------------------
            | New File Name
            |--------------------------------------------------------------------------
            */

            $image =
                $request->file(
                    'profile_image'
                );


            $imageName =
                time()
                .'_'
                .Str::random(12)
                .'.'
                .$image->getClientOriginalExtension();


            /*
            |--------------------------------------------------------------------------
            | Upload
            |--------------------------------------------------------------------------
            */

            $image->move(
                $destinationPath,
                $imageName
            );


            $profile->profile_image =
                $imageName;
        }


        $profile->save();


        return redirect()
            ->route('donor.profile.show')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }
}
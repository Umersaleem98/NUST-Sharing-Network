<?php

namespace App\Http\Controllers\Beneficiary;

use App\Http\Controllers\Controller;
use App\Models\BeneficiaryProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BeneficiaryProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = Auth::user();


        $profile = BeneficiaryProfile::firstOrCreate([
            'user_id' => $user->id,
        ]);


        return view(
            'pages.beneficiary.profile.index',
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


        $profile = BeneficiaryProfile::firstOrCreate([
            'user_id' => $user->id,
        ]);


        return view(
            'pages.beneficiary.profile.edit',
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


        $profile = BeneficiaryProfile::firstOrCreate([
            'user_id' => $user->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | Personal
            |--------------------------------------------------------------------------
            */

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'gender' => [
                'nullable',

                Rule::in([
                    'male',
                    'female',
                    'other',
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | Academic
            |--------------------------------------------------------------------------
            */

            'institution' => [
                'nullable',
                'string',
                'max:255',
            ],

            'degree' => [
                'nullable',

                Rule::in([
                    'UG',
                    'PG',
                    'PhD',
                ]),
            ],

            'enrollment_year' => [
                'nullable',
                'integer',
                'digits:4',
                'min:2000',
                'max:2100',
            ],

            'graduation_year' => [
                'nullable',
                'integer',
                'digits:4',
                'min:2000',
                'max:2100',
                'gte:enrollment_year',
            ],


            /*
            |--------------------------------------------------------------------------
            | Family / Financial
            |--------------------------------------------------------------------------
            */

            'father_status' => [
                'nullable',

                Rule::in([
                    'alive',
                    'deceased',
                    'not_applicable',
                ]),
            ],

            'guardian_profession' => [
                'nullable',
                'string',
                'max:255',
            ],

            'monthly_income' => [
                'nullable',
                'numeric',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'province' => [
                'nullable',

                Rule::in([
                    'Punjab',
                    'Sindh',
                    'Khyber Pakhtunkhwa',
                    'Balochistan',
                    'Islamabad Capital Territory',
                    'Gilgit-Baltistan',
                    'Azad Jammu and Kashmir',
                ]),
            ],

            'domicile' => [
                'nullable',
                'string',
                'max:255',
            ],

            'home_address' => [
                'nullable',
                'string',
                'max:2000',
            ],


            /*
            |--------------------------------------------------------------------------
            | Image
            |--------------------------------------------------------------------------
            */

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'graduation_year.gte' =>
                'Graduation year must be greater than or equal to enrollment year.',

            'profile_image.max' =>
                'Profile image must not exceed 2 MB.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Email
        |--------------------------------------------------------------------------
        */

        $oldEmail =
            strtolower(
                trim(
                    $user->email
                )
            );


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
        | Reset Verification If Email Changed
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
        | Update Beneficiary Profile
        |--------------------------------------------------------------------------
        */

        $profile->phone =
            $request->phone;


        $profile->gender =
            $request->gender;


        $profile->institution =
            $request->institution;


        $profile->degree =
            $request->degree;


        $profile->enrollment_year =
            $request->enrollment_year;


        $profile->graduation_year =
            $request->graduation_year;


        $profile->father_status =
            $request->father_status;


        $profile->guardian_profession =
            $request->guardian_profession;


        $profile->monthly_income =
            $request->monthly_income;


        $profile->province =
            $request->province;


        $profile->domicile =
            $request->domicile;


        $profile->home_address =
            $request->home_address;


        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_image')) {

            /*
            |--------------------------------------------------------------------------
            | Delete Previous Image
            |--------------------------------------------------------------------------
            */

            if ($profile->profile_image) {

                $oldImagePath =
                    public_path(
                        'beneficiaries/images/profiles/'
                        .$profile->profile_image
                    );


                if (File::exists($oldImagePath)) {

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
                    'beneficiaries/images/profiles'
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
            | Image Name
            |--------------------------------------------------------------------------
            */

            $image =
                $request->file(
                    'profile_image'
                );


            $imageName =
                time()
                .'_beneficiary_'
                .Str::random(12)
                .'.'
                .$image->getClientOriginalExtension();


            /*
            |--------------------------------------------------------------------------
            | Move
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
            ->route(
                'beneficiary.profile.index'
            )
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }
}
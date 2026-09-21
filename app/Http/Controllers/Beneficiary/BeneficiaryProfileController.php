<?php

namespace App\Http\Controllers\Beneficiary;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BeneficiaryProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Beneficiary Profile
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'beneficiary',
            403
        );

        $user->load('beneficiaryProfile');

        return view(
            'pages.beneficiary.profile.index',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Beneficiary Profile
    |--------------------------------------------------------------------------
    */

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        abort_if(
            ! $user || $user->role !== 'beneficiary',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
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
                    Rule::unique('users', 'email')
                        ->ignore($user->id),
                ],

                'phone' => [
                    'nullable',
                    'string',
                    'max:20',
                ],

                'gender' => [
                    'required',
                    Rule::in([
                        'male',
                        'female',
                        'other',
                    ]),
                ],

                'institution' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'degree_level' => [
                    'required',
                    Rule::in([
                        'UG',
                        'PG',
                        'PhD',
                    ]),
                ],

                'degree_program' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'department' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'semester' => [
                    'nullable',
                    'string',
                    'max:50',
                ],

                'cgpa' => [
                    'nullable',
                    'numeric',
                    'min:0',
                    'max:4',
                ],

                'enrollment_year' => [
                    'required',
                    'integer',
                    'min:2000',
                    'max:2100',
                ],

                'father_status' => [
                    'required',
                    'string',
                    'max:255',
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

                'province' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'domicile' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'home_address' => [
                    'required',
                    'string',
                    'max:1000',
                ],

                'image' => [
                    'nullable',
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
                'email.unique' =>
                    'A user with this email address already exists.',

                'gender.required' =>
                    'Please select your gender.',

                'gender.in' =>
                    'Please select a valid gender.',

                'institution.required' =>
                    'Please enter your institution.',

                'degree_level.required' =>
                    'Please select your degree level.',

                'degree_level.in' =>
                    'Please select a valid degree level.',

                'enrollment_year.required' =>
                    'Please enter your enrollment year.',

                'father_status.required' =>
                    'Please enter your father status.',

                'province.required' =>
                    'Please select your province.',

                'home_address.required' =>
                    'Please enter your home address.',

                'image.image' =>
                    'The profile photo must be a valid image.',

                'image.mimes' =>
                    'The profile photo must be JPG, JPEG, PNG or WebP.',

                'image.max' =>
                    'The profile photo must not exceed 200 KB.',

                'current_password.required_with' =>
                    'Please enter your current password before changing your password.',

                'password.required_with' =>
                    'Please enter your new password.',

                'password.min' =>
                    'The new password must contain at least 8 characters.',

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
                ->withInput(
                    $request->except([
                        'current_password',
                        'password',
                        'password_confirmation',
                        'image',
                    ])
                )
                ->withErrors([
                    'current_password' =>
                        'The current password you entered is incorrect.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Graduation Year
        |--------------------------------------------------------------------------
        */

        $degreeDuration = match ($validated['degree_level']) {
            'UG' => 4,
            'PG' => 2,
            'PhD' => 2,
            default => 0,
        };

        $graduationYear =
            (int) $validated['enrollment_year']
            + $degreeDuration;


        /*
        |--------------------------------------------------------------------------
        | Profile Image
        |--------------------------------------------------------------------------
        |
        | Physical location:
        |
        | public/admins/asset/profilephoto/
        |
        | Database:
        |
        | beneficiary-5-uuid.jpg
        |
        */

        $oldImageName = $user->image
            ? basename($user->image)
            : null;

        $newImageName = null;


        if ($request->hasFile('image')) {

            $uploadPath = public_path(
                'admins/asset/profilephoto'
            );


            /*
            |--------------------------------------------------------------------------
            | Create Directory If Missing
            |--------------------------------------------------------------------------
            */

            File::ensureDirectoryExists(
                $uploadPath,
                0775,
                true
            );


            /*
            |--------------------------------------------------------------------------
            | Prepare Image
            |--------------------------------------------------------------------------
            */

            $image = $request->file('image');

            $extension = strtolower(
                $image->getClientOriginalExtension()
            );

            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }


            $newImageName =
                'beneficiary-'
                . $user->id
                . '-'
                . Str::uuid()
                . '.'
                . $extension;


            /*
            |--------------------------------------------------------------------------
            | Upload Image
            |--------------------------------------------------------------------------
            */

            $image->move(
                $uploadPath,
                $newImageName
            );


            /*
            |--------------------------------------------------------------------------
            | Update User Image
            |--------------------------------------------------------------------------
            */

            $user->image = $newImageName;
        }


        /*
        |--------------------------------------------------------------------------
        | Update User Information
        |--------------------------------------------------------------------------
        */

        $user->name =
            trim($validated['name']);

        $user->email =
            strtolower(
                trim($validated['email'])
            );

        $user->phone =
            ! empty($validated['phone'])
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


        /*
        |--------------------------------------------------------------------------
        | Save User
        |--------------------------------------------------------------------------
        */

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | Update Beneficiary Profile
        |--------------------------------------------------------------------------
        */

        $user->beneficiaryProfile()->updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'gender' =>
                    $validated['gender'],

                'institution' =>
                    trim($validated['institution']),

                'degree_level' =>
                    $validated['degree_level'],

                'degree_program' =>
                    ! empty($validated['degree_program'])
                        ? trim($validated['degree_program'])
                        : null,

                'department' =>
                    ! empty($validated['department'])
                        ? trim($validated['department'])
                        : null,

                'semester' =>
                    ! empty($validated['semester'])
                        ? trim($validated['semester'])
                        : null,

                'cgpa' =>
                    $validated['cgpa'] ?? null,

                'enrollment_year' =>
                    $validated['enrollment_year'],

                'graduation_year' =>
                    $graduationYear,

                'father_status' =>
                    trim($validated['father_status']),

                'guardian_profession' =>
                    ! empty($validated['guardian_profession'])
                        ? trim($validated['guardian_profession'])
                        : null,

                'monthly_income' =>
                    $validated['monthly_income'] ?? null,

                'province' =>
                    trim($validated['province']),

                'domicile' =>
                    ! empty($validated['domicile'])
                        ? trim($validated['domicile'])
                        : null,

                'home_address' =>
                    trim($validated['home_address']),
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Old Image
        |--------------------------------------------------------------------------
        |
        | Delete only after the new image and database information
        | have been saved successfully.
        |
        */

        if (
            $newImageName
            && $oldImageName
            && $oldImageName !== $newImageName
        ) {

            $oldImagePath = public_path(
                'admins/asset/profilephoto/'
                . $oldImageName
            );

            if (File::exists($oldImagePath)) {

                File::delete($oldImagePath);
            }
        }


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
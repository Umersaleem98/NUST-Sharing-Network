<?php

namespace App\Http\Controllers\Beneficiary;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

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
                'email.unique' =>
                    'A user with this email address already exists.',

                'gender.required' =>
                    'Please select your gender.',

                'degree_level.required' =>
                    'Please select your degree level.',

                'enrollment_year.required' =>
                    'Please enter your enrollment year.',

                'image.image' =>
                    'The profile photo must be a valid image.',

                'image.mimes' =>
                    'The profile photo must be JPG, JPEG, PNG or WebP.',

                'image.max' =>
                    'The profile photo must not exceed 200 KB.',

                'current_password.required_with' =>
                    'Current password is required when changing your password.',

                'password.required_with' =>
                    'Please enter the new password.',

                'password.min' =>
                    'The new password must be at least 8 characters.',

                'password.confirmed' =>
                    'The new password confirmation does not match.',

                'password_confirmation.required_with' =>
                    'Please confirm the new password.',
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
                ->withErrors([
                    'current_password' =>
                        'Current password is incorrect.',
                ])
                ->withInput(
                    $request->except([
                        'current_password',
                        'password',
                        'password_confirmation',
                        'image',
                    ])
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Graduation Year
        |--------------------------------------------------------------------------
        */
        $degreeDuration = match (
            $validated['degree_level']
        ) {
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
        | Image Setup
        |--------------------------------------------------------------------------
        */
        $uploadPath =
            public_path('admins/asset/profilephoto');

        $oldImageName =
            $user->image;

        $newImageName =
            null;

        $transactionStarted =
            false;


        try {
            /*
            |--------------------------------------------------------------------------
            | Upload New Profile Image
            |--------------------------------------------------------------------------
            */
            if ($request->hasFile('image')) {
                File::ensureDirectoryExists(
                    $uploadPath,
                    0775,
                    true
                );

                if (! is_writable($uploadPath)) {
                    throw new \RuntimeException(
                        'Profile image directory is not writable: '
                        . $uploadPath
                    );
                }

                $image =
                    $request->file('image');

                $extension =
                    strtolower(
                        $image->extension()
                        ?: $image->getClientOriginalExtension()
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

                $image->move(
                    $uploadPath,
                    $newImageName
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Database Update
            |--------------------------------------------------------------------------
            */
            DB::beginTransaction();

            $transactionStarted =
                true;


            $user->name =
                trim($validated['name']);

            $user->email =
                trim($validated['email']);

            $user->phone =
                ! empty($validated['phone'])
                    ? trim($validated['phone'])
                    : null;


            if ($newImageName) {
                $user->image =
                    $newImageName;
            }


            if (! empty($validated['password'])) {
                $user->password =
                    Hash::make(
                        $validated['password']
                    );
            }


            $user->save();


            $user
                ->beneficiaryProfile()
                ->updateOrCreate(
                    [
                        'user_id' =>
                            $user->id,
                    ],
                    [
                        'gender' =>
                            $validated['gender'],

                        'institution' =>
                            $validated['institution'],

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
                            $validated['cgpa']
                            ?? null,

                        'enrollment_year' =>
                            $validated['enrollment_year'],

                        'graduation_year' =>
                            $graduationYear,

                        'father_status' =>
                            $validated['father_status'],

                        'guardian_profession' =>
                            ! empty($validated['guardian_profession'])
                                ? trim($validated['guardian_profession'])
                                : null,

                        'monthly_income' =>
                            $validated['monthly_income']
                            ?? null,

                        'province' =>
                            $validated['province'],

                        'domicile' =>
                            ! empty($validated['domicile'])
                                ? trim($validated['domicile'])
                                : null,

                        'home_address' =>
                            trim($validated['home_address']),
                    ]
                );


            DB::commit();

            $transactionStarted =
                false;


            /*
            |--------------------------------------------------------------------------
            | Delete Previous Image After Successful Update
            |--------------------------------------------------------------------------
            */
            if (
                $newImageName
                && $oldImageName
                && $oldImageName !== $newImageName
            ) {
                $oldImagePath =
                    $uploadPath
                    . DIRECTORY_SEPARATOR
                    . basename($oldImageName);

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }


            return back()->with(
                'success',
                'Profile updated successfully.'
            );

        } catch (Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | Roll Back Database
            |--------------------------------------------------------------------------
            */
            if ($transactionStarted) {
                DB::rollBack();
            }


            /*
            |--------------------------------------------------------------------------
            | Delete Newly Uploaded Image If Update Failed
            |--------------------------------------------------------------------------
            */
            if ($newImageName) {
                $newImagePath =
                    $uploadPath
                    . DIRECTORY_SEPARATOR
                    . $newImageName;

                if (File::exists($newImagePath)) {
                    File::delete($newImagePath);
                }
            }


            report($exception);


            return back()
                ->withInput(
                    $request->except([
                        'current_password',
                        'password',
                        'password_confirmation',
                        'image',
                    ])
                )
                ->with(
                    'error',
                    'Profile could not be updated. Please try again.'
                );
        }
    }
}

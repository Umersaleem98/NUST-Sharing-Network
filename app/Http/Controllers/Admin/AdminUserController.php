<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SelectedUsersExport;
use App\Exports\UsersImportTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Users List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = trim(
            (string) $request->search
        );

        $role =
            $request->role;

        $profileStatus =
            $request->profile_status;


        $users = User::query()

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->when(
                $search,
                function ($query) use ($search) {

                    $query->where(
                        function ($subQuery) use ($search) {

                            $subQuery
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'qalam_id',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )


            /*
            |--------------------------------------------------------------------------
            | Role Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                in_array(
                    $role,
                    [
                        'admin',
                        'donor',
                        'beneficiary',
                    ],
                    true
                ),
                function ($query) use ($role) {

                    $query->where(
                        'role',
                        $role
                    );
                }
            )


            /*
            |--------------------------------------------------------------------------
            | Profile Status Filter
            |--------------------------------------------------------------------------
            */

            ->when(
                in_array(
                    $profileStatus,
                    [
                        'active',
                        'suspended',
                        'blocked',
                    ],
                    true
                ),
                function ($query) use ($profileStatus) {

                    $query->where(
                        'profile_status',
                        $profileStatus
                    );
                }
            )


            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'pages.admins.users.index',
            compact('users')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store User
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
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
                'unique:users,email',
            ],

            'role' => [
                'required',

                Rule::in([
                    'admin',
                    'donor',
                    'beneficiary',
                ]),
            ],

            'profile_status' => [
                'required',

                Rule::in([
                    'active',
                    'suspended',
                    'blocked',
                ]),
            ],

            'qalam_id' => [
                Rule::requiredIf(
                    $request->role === 'beneficiary'
                ),

                'nullable',
                'regex:/^\d+$/',
                'max:30',
                'unique:users,qalam_id',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ], [
            'email.unique' =>
                'This email address already exists.',

            'qalam_id.required' =>
                'Qalam ID is required for beneficiary.',

            'qalam_id.regex' =>
                'Qalam ID must contain numbers only.',

            'qalam_id.unique' =>
                'This Qalam ID already exists.',

            'password.required' =>
                'Password is required.',

            'password.min' =>
                'Password must contain at least 8 characters.',
        ]);


        User::create([
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

            'profile_status' =>
                $request->profile_status,

            'email_verified_at' =>
                null,
        ]);


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit User
    |--------------------------------------------------------------------------
    */

    public function edit(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Protect Current Admin
        |--------------------------------------------------------------------------
        */

        if ($user->id === Auth::id()) {

            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'You cannot edit your own administrator account.'
                );
        }


        return view(
            'pages.admins.users.edit',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update User
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        User $user
    ) {
        /*
        |--------------------------------------------------------------------------
        | Protect Current Admin
        |--------------------------------------------------------------------------
        */

        if ($user->id === Auth::id()) {

            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'You cannot modify your own administrator account.'
                );
        }


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

            'role' => [
                'required',

                Rule::in([
                    'admin',
                    'donor',
                    'beneficiary',
                ]),
            ],

            'profile_status' => [
                'required',

                Rule::in([
                    'active',
                    'suspended',
                    'blocked',
                ]),
            ],

            'qalam_id' => [
                Rule::requiredIf(
                    $request->role === 'beneficiary'
                ),

                'nullable',
                'regex:/^\d+$/',
                'max:30',

                Rule::unique(
                    'users',
                    'qalam_id'
                )->ignore(
                    $user->id
                ),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
            ],
        ], [
            'email.unique' =>
                'This email address already exists.',

            'qalam_id.required' =>
                'Qalam ID is required for beneficiary.',

            'qalam_id.regex' =>
                'Qalam ID must contain numbers only.',

            'qalam_id.unique' =>
                'This Qalam ID already exists.',

            'password.min' =>
                'Password must contain at least 8 characters.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Basic Information
        |--------------------------------------------------------------------------
        */

        $user->name =
            trim(
                $request->name
            );


        $user->email =
            strtolower(
                trim(
                    $request->email
                )
            );


        $user->role =
            $request->role;


        /*
        |--------------------------------------------------------------------------
        | Profile Status
        |--------------------------------------------------------------------------
        */

        $user->profile_status =
            $request->profile_status;


        /*
        |--------------------------------------------------------------------------
        | Qalam ID
        |--------------------------------------------------------------------------
        */

        $user->qalam_id =
            $request->role === 'beneficiary'
                ? trim(
                    $request->qalam_id
                )
                : null;


        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {

            $user->password =
                Hash::make(
                    $request->password
                );
        }


        $user->save();


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete User
    |--------------------------------------------------------------------------
    */

    public function destroy(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Protect Current Admin
        |--------------------------------------------------------------------------
        */

        if ($user->id === Auth::id()) {

            return back()->with(
                'error',
                'You cannot delete your own administrator account.'
            );
        }


        $user->delete();


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Selected Users
    |--------------------------------------------------------------------------
    */

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'user_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'user_ids.*' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ], [
            'user_ids.required' =>
                'Please select at least one user.',

            'user_ids.min' =>
                'Please select at least one user.',
        ]);


        $userIds = collect(
            $request->user_ids
        )
            ->map(function ($id) {

                return (int) $id;

            })
            ->unique();


        /*
        |--------------------------------------------------------------------------
        | Check Current User
        |--------------------------------------------------------------------------
        */

        $currentUserSelected =
            $userIds->contains(
                Auth::id()
            );


        /*
        |--------------------------------------------------------------------------
        | Remove Current Admin
        |--------------------------------------------------------------------------
        */

        $userIds = $userIds->reject(
            function ($id) {

                return $id === Auth::id();

            }
        );


        if ($userIds->isEmpty()) {

            return back()->with(
                'error',
                'Your own administrator account is protected and cannot be deleted.'
            );
        }


        $deletedCount = User::whereIn(
            'id',
            $userIds
        )->delete();


        $message =
            "{$deletedCount} user(s) deleted successfully.";


        if ($currentUserSelected) {

            $message .=
                ' Your own administrator account was skipped.';
        }


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                $message
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Export Selected Users
    |--------------------------------------------------------------------------
    */

    public function exportSelected(Request $request)
    {
        $request->validate([
            'user_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'user_ids.*' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ]);


        $users = User::whereIn(
            'id',
            $request->user_ids
        )
            ->orderBy('id')
            ->get();


        return Excel::download(
            new SelectedUsersExport(
                $users
            ),
            'selected-users-'
            .now()->format('Y-m-d-His')
            .'.xlsx'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Import Users
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ], [
            'file.required' =>
                'Please select an Excel file.',

            'file.mimes' =>
                'Only XLSX, XLS and CSV files are allowed.',

            'file.max' =>
                'Excel file must not exceed 10 MB.',
        ]);


        $import =
            new UsersImport();


        Excel::import(
            $import,
            $request->file('file')
        );


        return redirect()
            ->route('admin.users.index')
            ->with(
                'import_result',
                [
                    'imported' =>
                        $import->importedCount,

                    'duplicates' =>
                        $import->duplicateCount,

                    'failed' =>
                        $import->failedCount,

                    'duplicate_messages' =>
                        $import->duplicateMessages,

                    'failed_messages' =>
                        $import->failedMessages,
                ]
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Download Import Template
    |--------------------------------------------------------------------------
    */

    public function downloadTemplate()
    {
        return Excel::download(
            new UsersImportTemplateExport(),
            'users-import-template.xlsx'
        );
    }
}
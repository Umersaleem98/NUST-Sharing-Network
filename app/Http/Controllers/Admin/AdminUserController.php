<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Exports\UsersSelectedExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class AdminUserController extends Controller
{
    /**
     * Display users.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', Rule::in([10, 20, 50, 100])],
            'role' => ['nullable', Rule::in(['admin', 'donor', 'beneficiary'])],
            'status' => ['nullable', Rule::in(['active', 'suspended', 'blocked'])],
        ]);

        $perPage = (int) ($validated['per_page'] ?? 20);
        $search = trim($validated['search'] ?? '');
        $role = $validated['role'] ?? null;
        $status = $validated['status'] ?? null;

        $query = User::query()->with([
            'statusChangedBy',
            'beneficiaryProfile',
            'donorProfile',
        ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('qalam_id', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%")
                    ->orWhere('account_status', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        if ($status) {
            $query->where('account_status', $status);
        }

        $users = $query->latest()->paginate($perPage)->withQueryString();

        $roleCounts = [
            'all' => User::count(),
            'beneficiary' => User::where('role', 'beneficiary')->count(),
            'donor' => User::where('role', 'donor')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];

        $statusCounts = [
            'all' => User::count(),
            'active' => User::where('account_status', 'active')->count(),
            'suspended' => User::where('account_status', 'suspended')->count(),
            'blocked' => User::where('account_status', 'blocked')->count(),
        ];

        return view('pages.admin.users.index', compact(
            'users',
            'perPage',
            'search',
            'role',
            'status',
            'roleCounts',
            'statusCounts'
        ));
    }

    /**
     * Show create user page.
     */
    public function create()
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        return view('pages.admin.users.create');
    }

    /**
     * Store a new user.
     */
    public function store(Request $request): RedirectResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone' => ['nullable', 'string', 'max:20'],
            'qalam_id' => [
                'required_if:role,beneficiary',
                'nullable',
                'string',
                'max:100',
                Rule::unique('users', 'qalam_id'),
            ],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'donor', 'beneficiary'])],
            'image' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200',
            ],
        ], [
            'email.unique' => 'A user with this email address already exists.',
            'qalam_id.unique' => 'A user with this Qalam ID already exists.',
            'qalam_id.required_if' => 'Qalam ID is required for beneficiary users.',
            'password.confirmed' => 'The password confirmation does not match.',
            'image.max' => 'The profile image cannot exceed 200 KB.',
            'image.mimes' => 'The profile image must be JPG, JPEG, PNG or WebP.',
            'role.in' => 'Please select a valid user role.',
        ]);

        $imageName = null;
        $uploadDirectory = public_path('admins/asset/profilephoto');

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                if (! $image->isValid()) {
                    return back()->withInput()->with('error', 'The selected profile image is not valid.');
                }

                File::ensureDirectoryExists($uploadDirectory, 0755, true);

                if (! File::isWritable($uploadDirectory)) {
                    throw new \RuntimeException(
                        'Profile image directory is not writable: ' . $uploadDirectory
                    );
                }

                $extension = strtolower($image->extension() ?: $image->getClientOriginalExtension());
                $extension = $extension === 'jpeg' ? 'jpg' : $extension;
                $imageName = 'user-' . Str::uuid() . '.' . $extension;
                $image->move($uploadDirectory, $imageName);
            }

            User::create([
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'phone' => filled($validated['phone'] ?? null) ? trim($validated['phone']) : null,
                'qalam_id' => $validated['role'] === 'beneficiary'
                    ? (filled($validated['qalam_id'] ?? null) ? trim($validated['qalam_id']) : null)
                    : null,
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'image' => $imageName,
                'account_status' => 'active',
                'status_reason' => null,
                'status_changed_at' => now(),
                'status_changed_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.user.index')
                ->with('success', 'User created successfully.');
        } catch (Throwable $exception) {
            if ($imageName) {
                $uploadedImage = $uploadDirectory . DIRECTORY_SEPARATOR . basename($imageName);

                if (File::exists($uploadedImage)) {
                    File::delete($uploadedImage);
                }
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'The user could not be created. Please check the server log.');
        }
    }

    /**
     * Show edit user page.
     */
    public function edit(int $id)
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        $user = User::with('beneficiaryProfile')->findOrFail($id);
        $profileImageUrl = null;

        if (! empty($user->image)) {
            $imageName = basename($user->image);
            $imagePath = public_path('admins/asset/profilephoto/' . $imageName);

            if (File::exists($imagePath)) {
                $profileImageUrl = asset('admins/asset/profilephoto/' . $imageName);
            }
        }

        return view('pages.admin.users.edit', compact('user', 'profileImageUrl'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        $user = User::with('beneficiaryProfile')->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in(['admin', 'donor', 'beneficiary'])],
            'qalam_id' => [
                'required_if:role,beneficiary',
                'nullable',
                'string',
                'max:100',
                Rule::unique('users', 'qalam_id')->ignore($user->id),
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
            'image' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200',
            ],

            // Beneficiary profile
            'gender' => ['required_if:role,beneficiary', 'nullable', Rule::in(['male', 'female', 'other'])],
            'institution' => ['required_if:role,beneficiary', 'nullable', 'string', 'max:255'],
            'degree_level' => ['required_if:role,beneficiary', 'nullable', Rule::in(['UG', 'PG', 'PhD'])],
            'degree_program' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'semester' => ['nullable', 'string', 'max:50'],
            'cgpa' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'enrollment_year' => ['required_if:role,beneficiary', 'nullable', 'integer', 'min:2000', 'max:2100'],
            'graduation_year' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'father_status' => ['required_if:role,beneficiary', 'nullable', 'string', 'max:255'],
            'guardian_profession' => ['nullable', 'string', 'max:255'],
            'monthly_income' => ['nullable', 'numeric', 'min:0'],
            'province' => ['required_if:role,beneficiary', 'nullable', 'string', 'max:255'],
            'domicile' => ['nullable', 'string', 'max:255'],
            'home_address' => ['required_if:role,beneficiary', 'nullable', 'string', 'max:1000'],
        ], [
            'email.unique' => 'A user with this email address already exists.',
            'qalam_id.unique' => 'A user with this Qalam ID already exists.',
            'qalam_id.required_if' => 'Qalam ID is required for beneficiary users.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.required_with' => 'Please enter the new password when confirming a password.',
            'password_confirmation.required_with' => 'Please confirm the new password.',
            'image.max' => 'The profile image cannot exceed 200 KB.',
            'image.mimes' => 'The profile image must be JPG, JPEG, PNG or WebP.',
            'gender.required_if' => 'Gender is required for beneficiary users.',
            'institution.required_if' => 'Institution is required for beneficiary users.',
            'degree_level.required_if' => 'Degree level is required for beneficiary users.',
            'enrollment_year.required_if' => 'Enrollment year is required for beneficiary users.',
            'father_status.required_if' => 'Father status is required for beneficiary users.',
            'province.required_if' => 'Province is required for beneficiary users.',
            'home_address.required_if' => 'Home address is required for beneficiary users.',
        ]);

        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()
                ->withInput()
                ->with('error', 'You cannot remove your own administrator role.');
        }

        $graduationYear = null;

        if ($validated['role'] === 'beneficiary') {
            $degreeDuration = match ($validated['degree_level'] ?? null) {
                'UG' => 4,
                'PG' => 2,
                'PhD' => 2,
                default => 0,
            };

            if (! empty($validated['enrollment_year']) && $degreeDuration > 0) {
                $graduationYear = (int) $validated['enrollment_year'] + $degreeDuration;
            }
        }

        $uploadDirectory = public_path('admins/asset/profilephoto');
        $oldImageName = $user->image ? basename($user->image) : null;
        $newImageName = null;

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                if (! $image->isValid()) {
                    return back()->withInput()->with('error', 'The selected profile image is not valid.');
                }

                File::ensureDirectoryExists($uploadDirectory, 0755, true);

                if (! File::isWritable($uploadDirectory)) {
                    throw new \RuntimeException(
                        'Profile image directory is not writable: ' . $uploadDirectory
                    );
                }

                $extension = strtolower($image->extension() ?: $image->getClientOriginalExtension());
                $extension = $extension === 'jpeg' ? 'jpg' : $extension;
                $newImageName = 'user-' . Str::uuid() . '.' . $extension;
                $image->move($uploadDirectory, $newImageName);
            }

            DB::beginTransaction();

            $user->name = trim($validated['name']);
            $user->email = strtolower(trim($validated['email']));
            $user->phone = filled($validated['phone'] ?? null) ? trim($validated['phone']) : null;
            $user->role = $validated['role'];
            $user->qalam_id = $validated['role'] === 'beneficiary'
                ? (filled($validated['qalam_id'] ?? null) ? trim($validated['qalam_id']) : null)
                : null;

            if ($newImageName) {
                $user->image = $newImageName;
            }

            if (! empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            if ($validated['role'] === 'beneficiary') {
                $user->beneficiaryProfile()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'gender' => $validated['gender'] ?? null,
                        'institution' => $validated['institution'] ?? null,
                        'degree_level' => $validated['degree_level'] ?? null,
                        'degree_program' => $validated['degree_program'] ?? null,
                        'department' => $validated['department'] ?? null,
                        'semester' => $validated['semester'] ?? null,
                        'cgpa' => $validated['cgpa'] ?? null,
                        'enrollment_year' => $validated['enrollment_year'] ?? null,
                        'graduation_year' => $graduationYear,
                        'father_status' => $validated['father_status'] ?? null,
                        'guardian_profession' => $validated['guardian_profession'] ?? null,
                        'monthly_income' => $validated['monthly_income'] ?? null,
                        'province' => $validated['province'] ?? null,
                        'domicile' => $validated['domicile'] ?? null,
                        'home_address' => $validated['home_address'] ?? null,
                    ]
                );
            }

            DB::commit();

            if ($newImageName && $oldImageName) {
                $oldImagePath = $uploadDirectory . DIRECTORY_SEPARATOR . $oldImageName;

                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            return redirect()
                ->route('admin.user.index')
                ->with('success', 'User updated successfully.');
        } catch (Throwable $exception) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            if ($newImageName) {
                $newImagePath = $uploadDirectory . DIRECTORY_SEPARATOR . basename($newImageName);

                if (File::exists($newImagePath)) {
                    File::delete($newImagePath);
                }
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'The user could not be updated. Please check the server log.');
        }
    }

    /**
     * Update user account status.
     */
    public function updateAccountStatus(Request $request, User $user): RedirectResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own account status.');
        }

        if ($user->isAdmin()) {
            return back()->with('error', 'Another administrator account cannot be suspended or blocked.');
        }

        $validated = $request->validate([
            'account_status' => ['required', Rule::in(['active', 'suspended', 'blocked'])],
            'status_reason' => [
                Rule::requiredIf(in_array($request->input('account_status'), ['suspended', 'blocked'], true)),
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'account_status.required' => 'Please select an account status.',
            'account_status.in' => 'The selected account status is invalid.',
            'status_reason.required' => 'A reason is required when suspending or blocking a user.',
            'status_reason.max' => 'The status reason cannot exceed 1000 characters.',
        ]);

        try {
            DB::beginTransaction();

            $newStatus = $validated['account_status'];

            $user->update([
                'account_status' => $newStatus,
                'status_reason' => $newStatus === 'active'
                    ? null
                    : trim($validated['status_reason']),
                'status_changed_at' => now(),
                'status_changed_by' => auth()->id(),
            ]);

            if (
                in_array($newStatus, ['suspended', 'blocked'], true)
                && config('session.driver') === 'database'
                && Schema::hasTable('sessions')
                && Schema::hasColumn('sessions', 'user_id')
            ) {
                DB::table('sessions')->where('user_id', $user->id)->delete();
            }

            DB::commit();

            $message = match ($newStatus) {
                'active' => "{$user->name}'s account has been activated.",
                'suspended' => "{$user->name}'s account has been suspended.",
                'blocked' => "{$user->name}'s account has been blocked.",
            };

            return back()->with('success', $message);
        } catch (Throwable $exception) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            report($exception);

            return back()->with('error', 'The account status could not be updated.');
        }
    }

    /**
     * Delete one user.
     */
    public function destroy(int $id): RedirectResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $userIds = collect([$user->id]);
        $imageName = $user->image ? basename($user->image) : null;

        try {
            DB::beginTransaction();

            if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
                DB::table('sessions')->whereIn('user_id', $userIds)->delete();
            }

            if (Schema::hasColumn('users', 'status_changed_by')) {
                User::query()
                    ->whereIn('status_changed_by', $userIds)
                    ->update(['status_changed_by' => null]);
            }

            if (Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'notifiable_id')) {
                $notificationQuery = DB::table('notifications')->whereIn('notifiable_id', $userIds);

                if (Schema::hasColumn('notifications', 'notifiable_type')) {
                    $notificationQuery->whereIn('notifiable_type', [User::class, 'App\\Models\\User']);
                }

                $notificationQuery->delete();
            }

            if (Schema::hasTable('personal_access_tokens') && Schema::hasColumn('personal_access_tokens', 'tokenable_id')) {
                $tokenQuery = DB::table('personal_access_tokens')->whereIn('tokenable_id', $userIds);

                if (Schema::hasColumn('personal_access_tokens', 'tokenable_type')) {
                    $tokenQuery->whereIn('tokenable_type', [User::class, 'App\\Models\\User']);
                }

                $tokenQuery->delete();
            }

            $productIds = collect();

            if (
                Schema::hasTable('products')
                && Schema::hasColumn('products', 'user_id')
                && Schema::hasColumn('products', 'id')
            ) {
                $productIds = DB::table('products')->whereIn('user_id', $userIds)->pluck('id');
            }

            if (Schema::hasTable('product_requests')) {
                $requestQuery = DB::table('product_requests');
                $hasFilter = false;

                $requestQuery->where(function ($q) use ($userIds, $productIds, &$hasFilter) {
                    foreach (['donor_id', 'beneficiary_id', 'user_id'] as $column) {
                        if (Schema::hasColumn('product_requests', $column)) {
                            if (! $hasFilter) {
                                $q->whereIn($column, $userIds);
                                $hasFilter = true;
                            } else {
                                $q->orWhereIn($column, $userIds);
                            }
                        }
                    }

                    if ($productIds->isNotEmpty() && Schema::hasColumn('product_requests', 'product_id')) {
                        if (! $hasFilter) {
                            $q->whereIn('product_id', $productIds);
                            $hasFilter = true;
                        } else {
                            $q->orWhereIn('product_id', $productIds);
                        }
                    }
                });

                if ($hasFilter) {
                    $requestQuery->delete();
                }
            }

            foreach ([
                'beneficiary_profiles' => ['user_id'],
                'donor_profiles' => ['user_id'],
                'donor_term_acceptances' => ['donor_id', 'user_id'],
            ] as $table => $possibleColumns) {
                if (! Schema::hasTable($table)) {
                    continue;
                }

                $availableColumns = [];

                foreach ($possibleColumns as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        $availableColumns[] = $column;
                    }
                }

                if ($availableColumns === []) {
                    continue;
                }

                DB::table($table)->where(function ($q) use ($availableColumns, $userIds) {
                    foreach ($availableColumns as $index => $column) {
                        $index === 0
                            ? $q->whereIn($column, $userIds)
                            : $q->orWhereIn($column, $userIds);
                    }
                })->delete();
            }

            if (Schema::hasTable('products') && Schema::hasColumn('products', 'user_id')) {
                DB::table('products')->whereIn('user_id', $userIds)->delete();
            }

            $user->delete();

            DB::commit();

            if ($imageName) {
                $imagePath = public_path('admins/asset/profilephoto/' . $imageName);

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            return redirect()
                ->route('admin.user.index')
                ->with('success', 'User deleted successfully.');
        } catch (Throwable $exception) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            report($exception);

            return back()->with(
                'error',
                'The user could not be deleted. Please check the Laravel log for a related-record constraint.'
            );
        }
    }

    /**
     * Delete selected users.
     */
    public function deleteSelected(Request $request): RedirectResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:users,id'],
        ], [
            'ids.required' => 'Please select at least one user.',
            'ids.min' => 'Please select at least one user.',
            'ids.*.exists' => 'One of the selected users does not exist.',
        ]);

        $requestedIds = collect($validated['ids'])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $userIds = $requestedIds
            ->reject(fn (int $id) => $id === auth()->id())
            ->values();

        if ($userIds->isEmpty()) {
            return back()->with(
                'error',
                'No deletable users were selected. Your own account cannot be deleted.'
            );
        }

        $users = User::query()->whereIn('id', $userIds)->get();

        if ($users->isEmpty()) {
            return back()->with('error', 'No matching users were found to delete.');
        }

        $imageNames = $users->pluck('image')->filter()->map(fn ($name) => basename($name))->values();
        $deletedCount = $users->count();
        $skippedOwnAccount = $requestedIds->contains(auth()->id());

        try {
            DB::beginTransaction();

            if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
                DB::table('sessions')->whereIn('user_id', $userIds)->delete();
            }

            if (Schema::hasColumn('users', 'status_changed_by')) {
                User::query()
                    ->whereIn('status_changed_by', $userIds)
                    ->update(['status_changed_by' => null]);
            }

            if (Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'notifiable_id')) {
                $notificationQuery = DB::table('notifications')->whereIn('notifiable_id', $userIds);

                if (Schema::hasColumn('notifications', 'notifiable_type')) {
                    $notificationQuery->whereIn('notifiable_type', [User::class, 'App\\Models\\User']);
                }

                $notificationQuery->delete();
            }

            if (Schema::hasTable('personal_access_tokens') && Schema::hasColumn('personal_access_tokens', 'tokenable_id')) {
                $tokenQuery = DB::table('personal_access_tokens')->whereIn('tokenable_id', $userIds);

                if (Schema::hasColumn('personal_access_tokens', 'tokenable_type')) {
                    $tokenQuery->whereIn('tokenable_type', [User::class, 'App\\Models\\User']);
                }

                $tokenQuery->delete();
            }

            $productIds = collect();

            if (
                Schema::hasTable('products')
                && Schema::hasColumn('products', 'user_id')
                && Schema::hasColumn('products', 'id')
            ) {
                $productIds = DB::table('products')->whereIn('user_id', $userIds)->pluck('id');
            }

            if (Schema::hasTable('product_requests')) {
                $requestQuery = DB::table('product_requests');
                $hasFilter = false;

                $requestQuery->where(function ($q) use ($userIds, $productIds, &$hasFilter) {
                    foreach (['donor_id', 'beneficiary_id', 'user_id'] as $column) {
                        if (Schema::hasColumn('product_requests', $column)) {
                            if (! $hasFilter) {
                                $q->whereIn($column, $userIds);
                                $hasFilter = true;
                            } else {
                                $q->orWhereIn($column, $userIds);
                            }
                        }
                    }

                    if ($productIds->isNotEmpty() && Schema::hasColumn('product_requests', 'product_id')) {
                        if (! $hasFilter) {
                            $q->whereIn('product_id', $productIds);
                            $hasFilter = true;
                        } else {
                            $q->orWhereIn('product_id', $productIds);
                        }
                    }
                });

                if ($hasFilter) {
                    $requestQuery->delete();
                }
            }

            foreach ([
                'beneficiary_profiles' => ['user_id'],
                'donor_profiles' => ['user_id'],
                'donor_term_acceptances' => ['donor_id', 'user_id'],
            ] as $table => $possibleColumns) {
                if (! Schema::hasTable($table)) {
                    continue;
                }

                $availableColumns = [];

                foreach ($possibleColumns as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        $availableColumns[] = $column;
                    }
                }

                if ($availableColumns === []) {
                    continue;
                }

                DB::table($table)->where(function ($q) use ($availableColumns, $userIds) {
                    foreach ($availableColumns as $index => $column) {
                        $index === 0
                            ? $q->whereIn($column, $userIds)
                            : $q->orWhereIn($column, $userIds);
                    }
                })->delete();
            }

            if (Schema::hasTable('products') && Schema::hasColumn('products', 'user_id')) {
                DB::table('products')->whereIn('user_id', $userIds)->delete();
            }

            User::query()->whereIn('id', $userIds)->delete();

            DB::commit();

            foreach ($imageNames as $imageName) {
                $imagePath = public_path('admins/asset/profilephoto/' . $imageName);

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $message = "{$deletedCount} user(s) deleted successfully.";

            if ($skippedOwnAccount) {
                $message .= ' Your own account was skipped.';
            }

            return redirect()
                ->route('admin.user.index')
                ->with('success', $message);
        } catch (Throwable $exception) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            report($exception);

            return back()->with(
                'error',
                'The selected users could not be deleted. Please check the Laravel log for a related-record constraint.'
            );
        }
    }

    /**
     * Preview Excel/CSV user import.
     */
    public function preview(Request $request): RedirectResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        try {
            $sheets = Excel::toCollection(null, $request->file('file'));
            $sheet = $sheets->first();
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'file' => 'The spreadsheet could not be read. Please use a valid XLSX, XLS, or CSV file.',
            ]);
        }

        if (! $sheet || $sheet->isEmpty()) {
            return back()->withErrors(['file' => 'The selected spreadsheet is empty.']);
        }

        $headings = collect($sheet->first())
            ->map(fn ($heading) => Str::of((string) $heading)
                ->trim()
                ->lower()
                ->replace(' ', '_')
                ->value())
            ->all();

        $requiredHeadings = [
            'name',
            'email',
            'phone',
            'password',
            'role',
            'qalam_id',
            'account_status',
            'status_reason',
        ];

        foreach ($requiredHeadings as $requiredHeading) {
            if (! in_array($requiredHeading, $headings, true)) {
                return back()->withErrors([
                    'file' => "Missing Excel heading: {$requiredHeading}.",
                ]);
            }
        }

        $cleanRows = [];
        $duplicates = [];
        $invalidRows = [];
        $seenEmails = [];
        $seenQalamIds = [];
        $dataRows = $sheet->slice(1)->values();

        foreach ($dataRows as $index => $row) {
            $excelRow = $index + 2;
            $row = collect($headings)
                ->combine(collect($row)->pad(count($headings), null))
                ->all();

            $name = filled($row['name'] ?? null) ? trim((string) $row['name']) : null;
            $email = filled($row['email'] ?? null) ? Str::lower(trim((string) $row['email'])) : null;
            $phone = filled($row['phone'] ?? null) ? trim((string) $row['phone']) : null;
            $password = filled($row['password'] ?? null) ? trim((string) $row['password']) : null;
            $role = Str::lower(filled($row['role'] ?? null) ? trim((string) $row['role']) : 'beneficiary');
            $qalamId = filled($row['qalam_id'] ?? null) ? Str::upper(trim((string) $row['qalam_id'])) : null;
            $accountStatus = Str::lower(
                filled($row['account_status'] ?? null)
                    ? trim((string) $row['account_status'])
                    : 'active'
            );
            $statusReason = filled($row['status_reason'] ?? null)
                ? trim((string) $row['status_reason'])
                : null;

            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => $password,
                'role' => $role,
                'qalam_id' => $qalamId,
                'account_status' => $accountStatus,
                'status_reason' => $statusReason,
            ];

            if (
                blank($name)
                && blank($email)
                && blank($phone)
                && blank($password)
                && blank($qalamId)
                && blank($statusReason)
            ) {
                continue;
            }

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email:rfc', 'max:255'],
                'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
                'password' => ['nullable', 'string', 'min:8', 'max:100'],
                'role' => ['required', Rule::in(['admin', 'donor', 'beneficiary'])],
                'qalam_id' => ['required_if:role,beneficiary', 'nullable', 'string', 'max:100'],
                'account_status' => ['required', Rule::in(['active', 'suspended', 'blocked'])],
                'status_reason' => ['nullable', 'string', 'max:1000'],
            ]);

            if ($validator->fails()) {
                $invalidRows[] = [
                    'row' => $excelRow,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'errors' => $validator->errors()->all(),
                ];

                continue;
            }

            if ($data['role'] !== 'beneficiary') {
                $data['qalam_id'] = null;
            }

            $reasons = [];

            if (isset($seenEmails[$data['email']])) {
                $reasons[] = "Email duplicates Excel row {$seenEmails[$data['email']]}.";
            } elseif (User::where('email', $data['email'])->exists()) {
                $reasons[] = 'Email already exists in the users table.';
            }

            if ($data['qalam_id']) {
                if (isset($seenQalamIds[$data['qalam_id']])) {
                    $reasons[] = "Qalam ID duplicates Excel row {$seenQalamIds[$data['qalam_id']]}.";
                } elseif (User::where('qalam_id', $data['qalam_id'])->exists()) {
                    $reasons[] = 'Qalam ID already exists in the users table.';
                }
            }

            if ($reasons !== []) {
                $duplicates[] = [
                    'row' => $excelRow,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'qalam_id' => $data['qalam_id'],
                    'reasons' => $reasons,
                ];

                continue;
            }

            $seenEmails[$data['email']] = $excelRow;

            if ($data['qalam_id']) {
                $seenQalamIds[$data['qalam_id']] = $excelRow;
            }

            $cleanRows[] = $data;
        }

        $token = (string) Str::uuid();

        session()->put('pending_user_import', [
            'token' => $token,
            'rows' => $cleanRows,
            'created_at' => now()->timestamp,
        ]);

        return back()->with('import_preview', [
            'token' => $token,
            'total' => count($cleanRows) + count($duplicates) + count($invalidRows),
            'clean_count' => count($cleanRows),
            'duplicates' => $duplicates,
            'invalid' => $invalidRows,
        ]);
    }

    /**
     * Confirm Excel/CSV user import.
     */
    public function confirm(Request $request): RedirectResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        $request->validate([
            'import_token' => ['required', 'uuid'],
        ]);

        $pendingImport = session('pending_user_import');
        $requestToken = $request->string('import_token')->toString();

        if (
            ! $pendingImport
            || ! isset($pendingImport['token'])
            || ! hash_equals($pendingImport['token'], $requestToken)
        ) {
            return redirect()
                ->route('admin.user.index')
                ->withErrors(['file' => 'The import preview expired. Please upload the file again.']);
        }

        if (($pendingImport['created_at'] ?? 0) < now()->subMinutes(30)->timestamp) {
            session()->forget('pending_user_import');

            return redirect()
                ->route('admin.user.index')
                ->withErrors([
                    'file' => 'The import preview expired after 30 minutes. Please upload the file again.',
                ]);
        }

        $inserted = 0;
        $raceDuplicates = 0;

        try {
            DB::beginTransaction();

            foreach ($pendingImport['rows'] as $data) {
                $duplicateQuery = User::query()->where('email', $data['email']);

                if (filled($data['qalam_id'])) {
                    $duplicateQuery->orWhere('qalam_id', $data['qalam_id']);
                }

                if ($duplicateQuery->lockForUpdate()->exists()) {
                    $raceDuplicates++;
                    continue;
                }

                $plainPassword = filled($data['password'])
                    ? $data['password']
                    : Str::password(12);

                User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($plainPassword),
                    'image' => null,
                    'role' => $data['role'],
                    'qalam_id' => $data['qalam_id'],
                    'account_status' => $data['account_status'],
                    'status_reason' => $data['status_reason'],
                    'status_changed_at' => $data['account_status'] === 'active' ? null : now(),
                    'status_changed_by' => auth()->id(),
                ]);

                $inserted++;
            }

            DB::commit();
        } catch (Throwable $exception) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            report($exception);

            return redirect()
                ->route('admin.user.index')
                ->withErrors(['file' => 'The user import failed. Please check the Laravel log.']);
        }

        session()->forget('pending_user_import');

        $message = "{$inserted} users imported successfully.";

        if ($raceDuplicates > 0) {
            $message .= " {$raceDuplicates} newly detected duplicate rows were skipped.";
        }

        return redirect()
            ->route('admin.user.index')
            ->with('success', $message);
    }

    /**
     * Cancel pending user import.
     */
    public function cancel(): RedirectResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        session()->forget('pending_user_import');

        return redirect()
            ->route('admin.user.index')
            ->with('info', 'User import was cancelled.');
    }

    /**
     * Export all users.
     */
    public function exportUsers(): BinaryFileResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    /**
     * Export selected users.
     */
    public function exportSelected(Request $request): BinaryFileResponse|RedirectResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:users,id'],
        ], [
            'ids.required' => 'Please select at least one user.',
            'ids.min' => 'Please select at least one user.',
        ]);

        return Excel::download(
            new UsersSelectedExport($validated['ids']),
            'selected_users.xlsx'
        );
    }
}

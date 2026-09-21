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

class AdminUserController extends Controller
{
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

        $query = User::with([
            'statusChangedBy',
            'beneficiaryProfile',
            'donorProfile',
        ]);

        if ($search !== '') {
            $query->whereAny(
                ['name', 'email', 'phone', 'qalam_id', 'role', 'account_status'],
                'like',
                "%{$search}%"
            );
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

    public function create()
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        return view('pages.admin.users.create');
    }

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
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:200'],
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

        if ($request->hasFile('image')) {
            $uploadDirectory = public_path('admins/asset/profilephoto');
            File::ensureDirectoryExists($uploadDirectory);

            $image = $request->file('image');
            $extension = strtolower($image->getClientOriginalExtension());
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
    }

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
            'password' => ['nullable', 'string', 'min:8', 'max:255', 'confirmed'],
            'password_confirmation' => ['nullable', 'string', 'min:8', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:200'],

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

        $oldImageName = $user->image ? basename($user->image) : null;
        $newImageName = null;

        if ($request->hasFile('image')) {
            $uploadDirectory = public_path('admins/asset/profilephoto');
            File::ensureDirectoryExists($uploadDirectory);

            $image = $request->file('image');
            $extension = strtolower($image->getClientOriginalExtension());
            $extension = $extension === 'jpeg' ? 'jpg' : $extension;

            $newImageName = 'user-' . Str::uuid() . '.' . $extension;
            $image->move($uploadDirectory, $newImageName);

            $user->image = $newImageName;
        }

        $user->name = trim($validated['name']);
        $user->email = strtolower(trim($validated['email']));
        $user->phone = filled($validated['phone'] ?? null) ? trim($validated['phone']) : null;
        $user->role = $validated['role'];
        $user->qalam_id = $validated['role'] === 'beneficiary'
            ? (filled($validated['qalam_id'] ?? null) ? trim($validated['qalam_id']) : null)
            : null;

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

        if ($newImageName && $oldImageName) {
            $oldImagePath = public_path('admins/asset/profilephoto/' . $oldImageName);

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'User updated successfully.');
    }

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

        $message = match ($newStatus) {
            'active' => "{$user->name}'s account has been activated.",
            'suspended' => "{$user->name}'s account has been suspended.",
            'blocked' => "{$user->name}'s account has been blocked.",
        };

        return back()->with('success', $message);
    }

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

        $userId = $user->id;
        $imageName = $user->image ? basename($user->image) : null;

        if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
            DB::table('sessions')->where('user_id', $userId)->delete();
        }

        if (Schema::hasColumn('users', 'status_changed_by')) {
            User::where('status_changed_by', $userId)
                ->update(['status_changed_by' => null]);
        }

        if (Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'notifiable_id')) {
            $notifications = DB::table('notifications')->where('notifiable_id', $userId);

            if (Schema::hasColumn('notifications', 'notifiable_type')) {
                $notifications->whereIn('notifiable_type', [User::class, 'App\\Models\\User']);
            }

            $notifications->delete();
        }

        if (Schema::hasTable('personal_access_tokens') && Schema::hasColumn('personal_access_tokens', 'tokenable_id')) {
            $tokens = DB::table('personal_access_tokens')->where('tokenable_id', $userId);

            if (Schema::hasColumn('personal_access_tokens', 'tokenable_type')) {
                $tokens->whereIn('tokenable_type', [User::class, 'App\\Models\\User']);
            }

            $tokens->delete();
        }

        $productIds = collect();

        if (
            Schema::hasTable('products')
            && Schema::hasColumn('products', 'user_id')
            && Schema::hasColumn('products', 'id')
        ) {
            $productIds = DB::table('products')
                ->where('user_id', $userId)
                ->pluck('id');
        }

        if (Schema::hasTable('product_requests')) {
            if (Schema::hasColumn('product_requests', 'donor_id')) {
                DB::table('product_requests')->where('donor_id', $userId)->delete();
            }

            if (Schema::hasColumn('product_requests', 'beneficiary_id')) {
                DB::table('product_requests')->where('beneficiary_id', $userId)->delete();
            }

            if (Schema::hasColumn('product_requests', 'user_id')) {
                DB::table('product_requests')->where('user_id', $userId)->delete();
            }

            if ($productIds->isNotEmpty() && Schema::hasColumn('product_requests', 'product_id')) {
                DB::table('product_requests')->whereIn('product_id', $productIds)->delete();
            }
        }

        if (Schema::hasTable('beneficiary_profiles') && Schema::hasColumn('beneficiary_profiles', 'user_id')) {
            DB::table('beneficiary_profiles')->where('user_id', $userId)->delete();
        }

        if (Schema::hasTable('donor_profiles') && Schema::hasColumn('donor_profiles', 'user_id')) {
            DB::table('donor_profiles')->where('user_id', $userId)->delete();
        }

        if (Schema::hasTable('donor_term_acceptances')) {
            if (Schema::hasColumn('donor_term_acceptances', 'donor_id')) {
                DB::table('donor_term_acceptances')->where('donor_id', $userId)->delete();
            }

            if (Schema::hasColumn('donor_term_acceptances', 'user_id')) {
                DB::table('donor_term_acceptances')->where('user_id', $userId)->delete();
            }
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'user_id')) {
            DB::table('products')->where('user_id', $userId)->delete();
        }

        $user->delete();

        if ($imageName) {
            $imagePath = public_path('admins/asset/profilephoto/' . $imageName);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'User deleted successfully.');
    }

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

        $requestedIds = [];

        foreach ($validated['ids'] as $id) {
            $id = (int) $id;

            if (! in_array($id, $requestedIds, true)) {
                $requestedIds[] = $id;
            }
        }

        $userIds = [];

        foreach ($requestedIds as $id) {
            if ($id !== auth()->id()) {
                $userIds[] = $id;
            }
        }

        if (empty($userIds)) {
            return back()->with(
                'error',
                'No deletable users were selected. Your own account cannot be deleted.'
            );
        }

        $users = User::whereIn('id', $userIds)->get();

        if ($users->isEmpty()) {
            return back()->with('error', 'No matching users were found to delete.');
        }

        $imageNames = [];

        foreach ($users as $user) {
            if ($user->image) {
                $imageNames[] = basename($user->image);
            }
        }

        $deletedCount = $users->count();
        $skippedOwnAccount = in_array(auth()->id(), $requestedIds, true);

        if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
            DB::table('sessions')->whereIn('user_id', $userIds)->delete();
        }

        if (Schema::hasColumn('users', 'status_changed_by')) {
            User::whereIn('status_changed_by', $userIds)
                ->update(['status_changed_by' => null]);
        }

        if (Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'notifiable_id')) {
            $notifications = DB::table('notifications')->whereIn('notifiable_id', $userIds);

            if (Schema::hasColumn('notifications', 'notifiable_type')) {
                $notifications->whereIn('notifiable_type', [User::class, 'App\\Models\\User']);
            }

            $notifications->delete();
        }

        if (Schema::hasTable('personal_access_tokens') && Schema::hasColumn('personal_access_tokens', 'tokenable_id')) {
            $tokens = DB::table('personal_access_tokens')->whereIn('tokenable_id', $userIds);

            if (Schema::hasColumn('personal_access_tokens', 'tokenable_type')) {
                $tokens->whereIn('tokenable_type', [User::class, 'App\\Models\\User']);
            }

            $tokens->delete();
        }

        $productIds = collect();

        if (
            Schema::hasTable('products')
            && Schema::hasColumn('products', 'user_id')
            && Schema::hasColumn('products', 'id')
        ) {
            $productIds = DB::table('products')
                ->whereIn('user_id', $userIds)
                ->pluck('id');
        }

        if (Schema::hasTable('product_requests')) {
            if (Schema::hasColumn('product_requests', 'donor_id')) {
                DB::table('product_requests')->whereIn('donor_id', $userIds)->delete();
            }

            if (Schema::hasColumn('product_requests', 'beneficiary_id')) {
                DB::table('product_requests')->whereIn('beneficiary_id', $userIds)->delete();
            }

            if (Schema::hasColumn('product_requests', 'user_id')) {
                DB::table('product_requests')->whereIn('user_id', $userIds)->delete();
            }

            if ($productIds->isNotEmpty() && Schema::hasColumn('product_requests', 'product_id')) {
                DB::table('product_requests')->whereIn('product_id', $productIds)->delete();
            }
        }

        if (Schema::hasTable('beneficiary_profiles') && Schema::hasColumn('beneficiary_profiles', 'user_id')) {
            DB::table('beneficiary_profiles')->whereIn('user_id', $userIds)->delete();
        }

        if (Schema::hasTable('donor_profiles') && Schema::hasColumn('donor_profiles', 'user_id')) {
            DB::table('donor_profiles')->whereIn('user_id', $userIds)->delete();
        }

        if (Schema::hasTable('donor_term_acceptances')) {
            if (Schema::hasColumn('donor_term_acceptances', 'donor_id')) {
                DB::table('donor_term_acceptances')->whereIn('donor_id', $userIds)->delete();
            }

            if (Schema::hasColumn('donor_term_acceptances', 'user_id')) {
                DB::table('donor_term_acceptances')->whereIn('user_id', $userIds)->delete();
            }
        }

        if (Schema::hasTable('products') && Schema::hasColumn('products', 'user_id')) {
            DB::table('products')->whereIn('user_id', $userIds)->delete();
        }

        User::whereIn('id', $userIds)->delete();

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
    }

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

        $sheets = Excel::toCollection(null, $request->file('file'));
        $sheet = $sheets->first();

        if (! $sheet || $sheet->isEmpty()) {
            return back()->withErrors([
                'file' => 'The selected spreadsheet is empty.',
            ]);
        }

        $headings = [];

        foreach ($sheet->first() as $heading) {
            $headings[] = Str::of((string) $heading)
                ->trim()
                ->lower()
                ->replace(' ', '_')
                ->value();
        }

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
            $rowValues = collect($row)->pad(count($headings), null)->all();
            $rowData = [];

            foreach ($headings as $headingIndex => $heading) {
                $rowData[$heading] = $rowValues[$headingIndex] ?? null;
            }

            $name = filled($rowData['name'] ?? null) ? trim((string) $rowData['name']) : null;
            $email = filled($rowData['email'] ?? null) ? Str::lower(trim((string) $rowData['email'])) : null;
            $phone = filled($rowData['phone'] ?? null) ? trim((string) $rowData['phone']) : null;
            $password = filled($rowData['password'] ?? null) ? trim((string) $rowData['password']) : null;
            $role = Str::lower(filled($rowData['role'] ?? null) ? trim((string) $rowData['role']) : 'beneficiary');
            $qalamId = filled($rowData['qalam_id'] ?? null) ? Str::upper(trim((string) $rowData['qalam_id'])) : null;
            $accountStatus = Str::lower(
                filled($rowData['account_status'] ?? null)
                    ? trim((string) $rowData['account_status'])
                    : 'active'
            );
            $statusReason = filled($rowData['status_reason'] ?? null)
                ? trim((string) $rowData['status_reason'])
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

            if (! empty($reasons)) {
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
                ->withErrors([
                    'file' => 'The import preview expired. Please upload the file again.',
                ]);
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

        foreach ($pendingImport['rows'] as $data) {
            $duplicateExists = User::where('email', $data['email'])->exists();

            if (! $duplicateExists && filled($data['qalam_id'])) {
                $duplicateExists = User::where('qalam_id', $data['qalam_id'])->exists();
            }

            if ($duplicateExists) {
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

        session()->forget('pending_user_import');

        $message = "{$inserted} users imported successfully.";

        if ($raceDuplicates > 0) {
            $message .= " {$raceDuplicates} newly detected duplicate rows were skipped.";
        }

        return redirect()
            ->route('admin.user.index')
            ->with('success', $message);
    }

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

    public function exportUsers(): BinaryFileResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->isAdmin(),
            403,
            'Only administrators can perform this action.'
        );

        return Excel::download(
            new UsersExport(),
            'users.xlsx'
        );
    }

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

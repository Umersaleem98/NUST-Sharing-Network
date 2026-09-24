@include('layouts.admins.head')
<title>User Management</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')

    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}

            <div class="row mb-4">

                <div class="col-lg-6">

                    <h3 class="mb-1">
                        User Management
                    </h3>

                    <p class="text-muted mb-0">
                        Manage admins, donors and beneficiaries.
                    </p>

                </div>


                <div
                    class="col-lg-6 text-lg-right mt-3 mt-lg-0"
                >

                    <button
                        type="button"
                        class="btn btn-success"
                        data-toggle="modal"
                        data-target="#importUsersModal"
                    >

                        <i class="fa fa-file-excel-o mr-1"></i>

                        Import Users

                    </button>


                    <button
                        type="button"
                        class="btn btn-primary"
                        data-toggle="modal"
                        data-target="#createUserModal"
                    >

                        <i class="fa fa-plus mr-1"></i>

                        Add User

                    </button>

                </div>

            </div>


            {{-- =========================================================
                SUCCESS MESSAGE
            ========================================================== --}}

            @if(session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                >

                    <i class="fa fa-check-circle mr-1"></i>

                    {{ session('success') }}


                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >

                        <span>
                            &times;
                        </span>

                    </button>

                </div>

            @endif


            {{-- =========================================================
                ERROR MESSAGE
            ========================================================== --}}

            @if(session('error'))

                <div
                    class="alert alert-danger alert-dismissible fade show"
                >

                    <i class="fa fa-exclamation-circle mr-1"></i>

                    {{ session('error') }}


                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >

                        <span>
                            &times;
                        </span>

                    </button>

                </div>

            @endif


            {{-- =========================================================
                VALIDATION ERRORS
            ========================================================== --}}

            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Please correct the following:
                    </strong>


                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =========================================================
                IMPORT RESULTS
            ========================================================== --}}

            @if(session('import_result'))

                @php

                    $result =
                        session('import_result');

                @endphp


                <div class="card mb-4">

                    <div class="card-body">

                        <h5 class="mb-3">
                            Import Summary
                        </h5>


                        <div class="row text-center">


                            <div class="col-md-4">

                                <div class="alert alert-success">

                                    <h3 class="mb-1">

                                        {{ $result['imported'] }}

                                    </h3>

                                    Imported

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="alert alert-warning">

                                    <h3 class="mb-1">

                                        {{ $result['duplicates'] }}

                                    </h3>

                                    Duplicates

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="alert alert-danger">

                                    <h3 class="mb-1">

                                        {{ $result['failed'] }}

                                    </h3>

                                    Invalid

                                </div>

                            </div>

                        </div>


                        @if(!empty($result['duplicate_messages']))

                            <div class="alert alert-warning">

                                <strong>
                                    Duplicate Rows
                                </strong>


                                <ul class="mb-0 mt-2">

                                    @foreach(
                                        $result['duplicate_messages']
                                        as $message
                                    )

                                        <li>
                                            {{ $message }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        @if(!empty($result['failed_messages']))

                            <div class="alert alert-danger mb-0">

                                <strong>
                                    Invalid Rows
                                </strong>


                                <ul class="mb-0 mt-2">

                                    @foreach(
                                        $result['failed_messages']
                                        as $message
                                    )

                                        <li>
                                            {{ $message }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif

                    </div>

                </div>

            @endif


            {{-- =========================================================
                SEARCH & FILTER
            ========================================================== --}}

            <div class="card mb-4">

                <div class="card-body">

                    <form
                        method="GET"
                        action="{{ route('admin.users.index') }}"
                    >

                        <div class="row align-items-end">


                            {{-- Search --}}

                            <div class="col-lg-4">

                                <div class="form-group mb-lg-0">

                                    <label>
                                        Search User
                                    </label>

                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        class="form-control"
                                        placeholder="Name, email or Qalam ID..."
                                    >

                                </div>

                            </div>


                            {{-- Role --}}

                            <div class="col-lg-2">

                                <div class="form-group mb-lg-0">

                                    <label>
                                        Role
                                    </label>

                                    <select
                                        name="role"
                                        class="form-control"
                                    >

                                        <option value="">
                                            All Roles
                                        </option>


                                        <option
                                            value="admin"
                                            {{ request('role') === 'admin' ? 'selected' : '' }}
                                        >
                                            Admin
                                        </option>


                                        <option
                                            value="donor"
                                            {{ request('role') === 'donor' ? 'selected' : '' }}
                                        >
                                            Donor
                                        </option>


                                        <option
                                            value="beneficiary"
                                            {{ request('role') === 'beneficiary' ? 'selected' : '' }}
                                        >
                                            Beneficiary
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Profile Status --}}

                            <div class="col-lg-3">

                                <div class="form-group mb-lg-0">

                                    <label>
                                        Profile Status
                                    </label>

                                    <select
                                        name="profile_status"
                                        class="form-control"
                                    >

                                        <option value="">
                                            All Statuses
                                        </option>


                                        <option
                                            value="active"
                                            {{ request('profile_status') === 'active' ? 'selected' : '' }}
                                        >
                                            Active
                                        </option>


                                        <option
                                            value="suspended"
                                            {{ request('profile_status') === 'suspended' ? 'selected' : '' }}
                                        >
                                            Suspended
                                        </option>


                                        <option
                                            value="blocked"
                                            {{ request('profile_status') === 'blocked' ? 'selected' : '' }}
                                        >
                                            Blocked
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Buttons --}}

                            <div class="col-lg-3">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa fa-search"></i>

                                    Search

                                </button>


                                <a
                                    href="{{ route('admin.users.index') }}"
                                    class="btn btn-secondary"
                                >
                                    Reset
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- =========================================================
                USER TABLE
            ========================================================== --}}

            <div class="card">

                <div class="card-body">


                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center mb-3"
                    >

                        <div>

                            <h4 class="card-title mb-1">
                                Users
                            </h4>


                            <small class="text-muted">

                                Total Users:

                                <strong>
                                    {{ $users->total() }}
                                </strong>

                            </small>

                        </div>


                        {{-- Bulk Actions --}}

                        <div class="mt-2 mt-md-0">


                            <span
                                class="badge badge-info mr-2"
                                id="selectedCount"
                            >
                                0 Selected
                            </span>


                            <button
                                type="button"
                                id="exportSelectedButton"
                                class="btn btn-sm btn-success"
                                disabled
                            >

                                <i class="fa fa-file-excel-o mr-1"></i>

                                Export Selected

                            </button>


                            <button
                                type="button"
                                id="deleteSelectedButton"
                                class="btn btn-sm btn-danger"
                                disabled
                            >

                                <i class="fa fa-trash mr-1"></i>

                                Delete Selected

                            </button>

                        </div>

                    </div>


                    <div class="table-responsive">

                        <table
                            class="table table-hover table-bordered"
                        >

                            <thead class="thead-light">

                            <tr>

                                <th
                                    width="40"
                                    class="text-center"
                                >

                                    <input
                                        type="checkbox"
                                        id="selectAllUsers"
                                    >

                                </th>


                                <th>
                                    #
                                </th>


                                <th>
                                    Name
                                </th>


                                <th>
                                    Email
                                </th>


                                <th>
                                    Qalam ID
                                </th>


                                <th>
                                    Role
                                </th>


                                <th>
                                    Profile Status
                                </th>


                                <th>
                                    Verification
                                </th>


                                <th>
                                    Created
                                </th>


                                <th
                                    width="160"
                                    class="text-center"
                                >
                                    Actions
                                </th>

                            </tr>

                            </thead>


                            <tbody>

                            @forelse($users as $user)

                                @php

                                    $isCurrentUser =
                                        auth()->id() ===
                                        $user->id;

                                @endphp


                                <tr>


                                    {{-- Checkbox --}}

                                    <td class="text-center">

                                        <input
                                            type="checkbox"
                                            value="{{ $user->id }}"
                                            class="user-checkbox"
                                        >

                                    </td>


                                    {{-- Number --}}

                                    <td>

                                        {{ $users->firstItem() + $loop->index }}

                                    </td>


                                    {{-- Name --}}

                                    <td>

                                        <strong>

                                            {{ $user->name }}

                                        </strong>


                                        @if($isCurrentUser)

                                            <span class="badge badge-info">
                                                You
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Email --}}

                                    <td>

                                        {{ $user->email }}

                                    </td>


                                    {{-- Qalam ID --}}

                                    <td>

                                        @if($user->role === 'beneficiary')

                                            {{ $user->qalam_id }}

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Role --}}

                                    <td>

                                        @if($user->role === 'admin')

                                            <span class="badge badge-danger">
                                                Admin
                                            </span>

                                        @elseif($user->role === 'donor')

                                            <span class="badge badge-success">
                                                Donor
                                            </span>

                                        @else

                                            <span class="badge badge-primary">
                                                Beneficiary
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Profile Status --}}

                                    <td>

                                        @if($user->profile_status === 'active')

                                            <span class="badge badge-success">

                                                <i class="fa fa-check-circle"></i>

                                                Active

                                            </span>


                                        @elseif($user->profile_status === 'suspended')

                                            <span class="badge badge-warning">

                                                <i class="fa fa-pause-circle"></i>

                                                Suspended

                                            </span>


                                        @else

                                            <span class="badge badge-danger">

                                                <i class="fa fa-ban"></i>

                                                Blocked

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Email Verification --}}

                                    <td>

                                        @if($user->email_verified_at)

                                            <span class="badge badge-success">

                                                <i class="fa fa-check-circle"></i>

                                                Verified

                                            </span>

                                        @else

                                            <span class="badge badge-warning">

                                                Pending

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Created --}}

                                    <td>

                                        {{ $user->created_at?->format('d M Y') }}

                                    </td>


                                    {{-- Actions --}}

                                    <td class="text-center">


                                        {{-- View --}}

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-info"
                                            data-toggle="modal"
                                            data-target="#viewUser{{ $user->id }}"
                                            title="View"
                                        >

                                            <i class="fa fa-eye"></i>

                                        </button>


                                        @if(!$isCurrentUser)


                                            {{-- Edit --}}

                                            <a
                                                href="{{ route('admin.users.edit', $user) }}"
                                                class="btn btn-sm btn-warning"
                                                title="Edit"
                                            >

                                                <i class="fa fa-edit"></i>

                                            </a>


                                            {{-- Delete --}}

                                            <form
                                                action="{{ route('admin.users.destroy', $user) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete {{ addslashes($user->name) }}?');"
                                            >

                                                @csrf

                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete"
                                                >

                                                    <i class="fa fa-trash"></i>

                                                </button>

                                            </form>


                                        @else

                                            <span
                                                class="badge badge-secondary"
                                                title="Current account is protected"
                                            >
                                                Protected
                                            </span>

                                        @endif

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="10"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="fa fa-users fa-3x text-muted mb-3"
                                        ></i>


                                        <h5>
                                            No Users Found
                                        </h5>


                                        <p class="text-muted mb-0">
                                            No users match your current filters.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- Pagination --}}

                    <div class="mt-4">

                        {{ $users->links() }}

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        VIEW USER MODALS
    ========================================================== --}}

    @foreach($users as $user)

        <div
            class="modal fade"
            id="viewUser{{ $user->id }}"
            tabindex="-1"
            role="dialog"
        >

            <div
                class="modal-dialog modal-dialog-centered"
                role="document"
            >

                <div class="modal-content">


                    <div
                        class="modal-header"
                        style="
                            background: #00558c;
                            color: white;
                        "
                    >

                        <h5 class="modal-title text-white">
                            User Profile
                        </h5>


                        <button
                            type="button"
                            class="close text-white"
                            data-dismiss="modal"
                        >

                            <span>
                                &times;
                            </span>

                        </button>

                    </div>


                    <div class="modal-body p-4">


                        <div class="text-center mb-4">

                            <div
                                class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                style="
                                    width: 80px;
                                    height: 80px;
                                    font-size: 30px;
                                    font-weight: 600;
                                "
                            >

                                {{ strtoupper(
                                    substr(
                                        $user->name,
                                        0,
                                        1
                                    )
                                ) }}

                            </div>


                            <h4 class="mt-3 mb-1">

                                {{ $user->name }}

                            </h4>


                            <span class="badge badge-primary">

                                {{ ucfirst($user->role) }}

                            </span>

                        </div>


                        <table class="table table-bordered">


                            <tr>

                                <th width="40%">
                                    User ID
                                </th>

                                <td>
                                    {{ $user->id }}
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Name
                                </th>

                                <td>
                                    {{ $user->name }}
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Email
                                </th>

                                <td>
                                    {{ $user->email }}
                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Qalam ID
                                </th>

                                <td>

                                    {{ $user->qalam_id ?? 'Not Applicable' }}

                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Role
                                </th>

                                <td>

                                    {{ ucfirst($user->role) }}

                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Profile Status
                                </th>

                                <td>

                                    @if($user->profile_status === 'active')

                                        <span class="badge badge-success">
                                            Active
                                        </span>


                                    @elseif($user->profile_status === 'suspended')

                                        <span class="badge badge-warning">
                                            Suspended
                                        </span>


                                    @else

                                        <span class="badge badge-danger">
                                            Blocked
                                        </span>

                                    @endif

                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Email Verification
                                </th>

                                <td>

                                    @if($user->email_verified_at)

                                        <span class="text-success">

                                            <i class="fa fa-check-circle"></i>

                                            Verified

                                        </span>

                                    @else

                                        <span class="text-warning">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                            </tr>


                            @if($user->email_verified_at)

                                <tr>

                                    <th>
                                        Verified At
                                    </th>

                                    <td>

                                        {{ $user->email_verified_at->format('d M Y h:i A') }}

                                    </td>

                                </tr>

                            @endif


                            <tr>

                                <th>
                                    Created At
                                </th>

                                <td>

                                    {{ $user->created_at?->format('d M Y h:i A') }}

                                </td>

                            </tr>


                            <tr>

                                <th>
                                    Updated At
                                </th>

                                <td>

                                    {{ $user->updated_at?->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        </table>

                    </div>


                    <div class="modal-footer">


                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>


                        @if(auth()->id() !== $user->id)

                            <a
                                href="{{ route('admin.users.edit', $user) }}"
                                class="btn btn-primary"
                            >

                                <i class="fa fa-edit mr-1"></i>

                                Edit User

                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    @endforeach


    {{-- =========================================================
        CREATE USER MODAL
    ========================================================== --}}

    <div
        class="modal fade"
        id="createUserModal"
        tabindex="-1"
        role="dialog"
    >

        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
        >

            <div class="modal-content">


                <form
                    action="{{ route('admin.users.store') }}"
                    method="POST"
                >

                    @csrf


                    <div
                        class="modal-header"
                        style="
                            background: #00558c;
                            color: white;
                        "
                    >

                        <h5 class="modal-title text-white">
                            Create User
                        </h5>


                        <button
                            type="button"
                            class="close text-white"
                            data-dismiss="modal"
                        >

                            <span>
                                &times;
                            </span>

                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="row">


                            {{-- Name --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Full Name
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name') }}"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- Email --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email') }}"
                                        required
                                    >

                                </div>

                            </div>


                            {{-- Role --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Role
                                    </label>

                                    <select
                                        name="role"
                                        id="createRole"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            Select Role
                                        </option>


                                        <option value="admin">
                                            Admin
                                        </option>


                                        <option value="donor">
                                            Donor
                                        </option>


                                        <option value="beneficiary">
                                            Beneficiary
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Profile Status --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Profile Status
                                    </label>

                                    <select
                                        name="profile_status"
                                        class="form-control"
                                        required
                                    >

                                        <option value="active">
                                            Active
                                        </option>


                                        <option value="suspended">
                                            Suspended
                                        </option>


                                        <option value="blocked">
                                            Blocked
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Qalam ID --}}

                            <div
                                class="col-md-6"
                                id="createQalamWrapper"
                                style="display:none;"
                            >

                                <div class="form-group">

                                    <label>
                                        Qalam ID
                                    </label>

                                    <input
                                        type="text"
                                        name="qalam_id"
                                        id="createQalam"
                                        class="form-control"
                                        inputmode="numeric"
                                        placeholder="Numbers only"
                                    >

                                </div>

                            </div>


                            {{-- Password --}}

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        minlength="8"
                                        required
                                    >

                                    <small class="text-muted">
                                        Minimum 8 characters.
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">


                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Cancel
                        </button>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="fa fa-plus mr-1"></i>

                            Create User

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
        IMPORT MODAL
    ========================================================== --}}

    <div
        class="modal fade"
        id="importUsersModal"
        tabindex="-1"
        role="dialog"
    >

        <div
            class="modal-dialog modal-dialog-centered"
            role="document"
        >

            <div class="modal-content">


                <form
                    action="{{ route('admin.users.import') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf


                    <div
                        class="modal-header"
                        style="
                            background: #28a745;
                            color: white;
                        "
                    >

                        <h5 class="modal-title text-white">

                            <i class="fa fa-file-excel-o mr-1"></i>

                            Import Users

                        </h5>


                        <button
                            type="button"
                            class="close text-white"
                            data-dismiss="modal"
                        >

                            <span>
                                &times;
                            </span>

                        </button>

                    </div>


                    <div class="modal-body">


                        <div class="alert alert-info">

                            <strong>
                                Required Columns
                            </strong>

                            <br><br>

                            <code>name</code>,

                            <code>email</code>,

                            <code>qalam_id</code>,

                            <code>role</code>,

                            <code>password</code>,

                            <code>profile_status</code>

                        </div>


                        <a
                            href="{{ route('admin.users.import.template') }}"
                            class="btn btn-outline-success btn-block mb-3"
                        >

                            <i class="fa fa-download mr-1"></i>

                            Download Excel Template

                        </a>


                        <div class="form-group">

                            <label>
                                Excel File
                            </label>

                            <input
                                type="file"
                                name="file"
                                class="form-control"
                                accept=".xlsx,.xls,.csv"
                                required
                            >

                        </div>


                        <div class="bg-light p-3 rounded">

                            <small class="text-muted">

                                • Beneficiary requires Qalam ID.

                                <br>

                                • Admin and Donor do not require Qalam ID.

                                <br>

                                • Password must be at least 8 characters.

                                <br>

                                • Profile status must be active, suspended or blocked.

                                <br>

                                • Duplicate email and Qalam ID records are skipped.

                            </small>

                        </div>

                    </div>


                    <div class="modal-footer">


                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Cancel
                        </button>


                        <button
                            type="submit"
                            class="btn btn-success"
                        >

                            <i class="fa fa-upload mr-1"></i>

                            Import Users

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
        HIDDEN EXPORT SELECTED FORM
    ========================================================== --}}

    <form
        id="exportSelectedForm"
        action="{{ route('admin.users.export.selected') }}"
        method="POST"
        style="display:none;"
    >

        @csrf

        <div id="exportSelectedInputs"></div>

    </form>


    {{-- =========================================================
        HIDDEN DELETE SELECTED FORM
    ========================================================== --}}

    <form
        id="deleteSelectedForm"
        action="{{ route('admin.users.bulk.destroy') }}"
        method="POST"
        style="display:none;"
    >

        @csrf

        @method('DELETE')

        <div id="deleteSelectedInputs"></div>

    </form>

</div>


@include('layouts.admins.script')


<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | Create User - Qalam Field
    |--------------------------------------------------------------------------
    */

    $('#createRole').on(
        'change',
        function () {

            if (
                $(this).val() ===
                'beneficiary'
            ) {

                $('#createQalamWrapper')
                    .slideDown();


                $('#createQalam')
                    .prop(
                        'required',
                        true
                    );

            } else {

                $('#createQalamWrapper')
                    .slideUp();


                $('#createQalam')
                    .prop(
                        'required',
                        false
                    )
                    .val('');

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Select All
    |--------------------------------------------------------------------------
    */

    $('#selectAllUsers').on(
        'change',
        function () {

            $('.user-checkbox')
                .prop(
                    'checked',
                    $(this).prop('checked')
                );


            updateBulkButtons();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Individual Checkbox
    |--------------------------------------------------------------------------
    */

    $('.user-checkbox').on(
        'change',
        function () {

            let total =
                $('.user-checkbox').length;


            let selected =
                $('.user-checkbox:checked').length;


            $('#selectAllUsers')
                .prop(
                    'checked',
                    total > 0 &&
                    total === selected
                );


            updateBulkButtons();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Bulk Button State
    |--------------------------------------------------------------------------
    */

    function updateBulkButtons()
    {
        let selected =
            $('.user-checkbox:checked').length;


        $('#selectedCount')
            .text(
                selected + ' Selected'
            );


        $('#exportSelectedButton')
            .prop(
                'disabled',
                selected === 0
            );


        $('#deleteSelectedButton')
            .prop(
                'disabled',
                selected === 0
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Export Selected
    |--------------------------------------------------------------------------
    */

    $('#exportSelectedButton').on(
        'click',
        function () {

            let selectedUsers =
                $('.user-checkbox:checked');


            if (selectedUsers.length === 0) {

                alert(
                    'Please select at least one user.'
                );

                return;
            }


            $('#exportSelectedInputs')
                .empty();


            selectedUsers.each(
                function () {

                    $('#exportSelectedInputs')
                        .append(

                            $('<input>')
                                .attr(
                                    'type',
                                    'hidden'
                                )
                                .attr(
                                    'name',
                                    'user_ids[]'
                                )
                                .val(
                                    $(this).val()
                                )

                        );

                }
            );


            $('#exportSelectedForm')
                .submit();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Delete Selected
    |--------------------------------------------------------------------------
    */

    $('#deleteSelectedButton').on(
        'click',
        function () {

            let selectedUsers =
                $('.user-checkbox:checked');


            if (selectedUsers.length === 0) {

                alert(
                    'Please select at least one user.'
                );

                return;
            }


            if (
                !confirm(
                    'Are you sure you want to delete '
                    + selectedUsers.length +
                    ' selected user(s)?'
                )
            ) {

                return;
            }


            $('#deleteSelectedInputs')
                .empty();


            selectedUsers.each(
                function () {

                    $('#deleteSelectedInputs')
                        .append(

                            $('<input>')
                                .attr(
                                    'type',
                                    'hidden'
                                )
                                .attr(
                                    'name',
                                    'user_ids[]'
                                )
                                .val(
                                    $(this).val()
                                )

                        );

                }
            );


            $('#deleteSelectedForm')
                .submit();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Initial State
    |--------------------------------------------------------------------------
    */

    updateBulkButtons();

});

</script>

</body>
</html>
@include('layouts.admin.head')

<title>Create User</title>


<style>

    .create-user-wrapper {
        width: 100%;
        max-width: 1500px;
        margin-inline: auto;
    }


    .create-user-card {
        border: 1px solid #e8edf3 !important;
    }


    .create-section-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 44px;
        height: 44px;

        border-radius: 50%;

        flex-shrink: 0;
    }


    .profile-preview {
        width: 120px;
        height: 120px;

        object-fit: cover;
    }


    .password-strength-info {
        padding: 12px 14px;

        border-radius: 10px;

        background: #f8fafc;

        border: 1px solid #e8edf3;

        font-size: .78rem;
    }


    .role-information {
        display: none;

        padding: 12px 14px;

        border-radius: 10px;

        border: 1px solid #e8edf3;

        background: #f8fafc;
    }


    .role-information.active {
        display: block;
    }


    @media (max-width: 767.98px) {

        .nsn-content {
            padding: 1rem !important;
        }

    }

</style>


<body>


    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}
    @include('layouts.admin.sidebar')


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
    <div class="nsn-main">


        @include('layouts.admin.header')


        <main class="nsn-content">


            <div class="create-user-wrapper">


                {{-- =================================================
                    PAGE HEADER
                ================================================== --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">


                    <div>

                        <h3 class="fw-bold text-dark mb-1">

                            Create User

                        </h3>


                        <p class="text-secondary small mb-0">

                            Create a new administrator, donor or beneficiary account.

                        </p>

                    </div>


                    <a
                        href="{{ route('admin.user.index') }}"
                        class="btn btn-light border d-flex align-items-center gap-2"
                    >

                        <i class="bi bi-arrow-left"></i>

                        <span>
                            Back to Users
                        </span>

                    </a>


                </div>



                {{-- =================================================
                    BREADCRUMB
                ================================================== --}}
                <nav
                    aria-label="breadcrumb"
                    class="mb-4"
                >


                    <ol class="breadcrumb small mb-0">


                        <li class="breadcrumb-item">

                            <a
                                href="{{ route('dashboard') }}"
                                class="text-decoration-none"
                            >

                                <i class="bi bi-house-door me-1"></i>

                                Dashboard

                            </a>

                        </li>


                        <li class="breadcrumb-item">

                            <a
                                href="{{ route('admin.user.index') }}"
                                class="text-decoration-none"
                            >

                                Users

                            </a>

                        </li>


                        <li
                            class="breadcrumb-item active"
                            aria-current="page"
                        >

                            Create User

                        </li>


                    </ol>


                </nav>



                {{-- =================================================
                    ALERT
                ================================================== --}}
                @include('layouts.admin.alert')



                {{-- =================================================
                    VALIDATION ERRORS
                ================================================== --}}
                @if ($errors->any())


                    <div class="alert alert-danger alert-dismissible fade show">


                        <div class="d-flex gap-2">


                            <i class="bi bi-exclamation-triangle-fill mt-1"></i>


                            <div>


                                <strong>
                                    Please correct the following errors:
                                </strong>


                                <ul class="mb-0 mt-2">

                                    @foreach ($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>


                            </div>


                        </div>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                        ></button>


                    </div>


                @endif



                {{-- =================================================
                    CREATE FORM
                ================================================== --}}
                <form
                    method="POST"
                    action="{{ route('admin.user.store') }}"
                    enctype="multipart/form-data"
                    id="createUserForm"
                >

                    @csrf


                    <div class="row g-4">


                        {{-- =================================================
                            LEFT SIDE
                        ================================================== --}}
                        <div class="col-12 col-xl-8">


                            {{-- =============================================
                                ACCOUNT INFORMATION
                            ============================================== --}}
                            <div class="create-user-card card border-0 shadow-sm rounded-4 overflow-hidden mb-4">


                                <div class="card-header bg-white border-bottom px-4 py-3">


                                    <div class="d-flex align-items-center gap-3">


                                        <span class="create-section-icon bg-primary-subtle text-primary">

                                            <i class="bi bi-person-plus fs-5"></i>

                                        </span>


                                        <div>

                                            <h5 class="fw-semibold text-dark mb-1">

                                                Account Information

                                            </h5>


                                            <p class="text-secondary small mb-0">

                                                Enter the user's personal and login information.

                                            </p>

                                        </div>


                                    </div>


                                </div>



                                <div class="card-body p-4">


                                    <div class="row g-4">


                                        {{-- =================================
                                            NAME
                                        ================================== --}}
                                        <div class="col-12 col-md-6">


                                            <label
                                                for="userName"
                                                class="form-label fw-semibold"
                                            >

                                                Full Name

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <div class="input-group">


                                                <span class="input-group-text bg-light">

                                                    <i class="bi bi-person"></i>

                                                </span>


                                                <input
                                                    type="text"
                                                    id="userName"
                                                    name="name"
                                                    value="{{ old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Enter full name"
                                                    autocomplete="name"
                                                    required
                                                    autofocus
                                                >


                                                @error('name')

                                                    <div class="invalid-feedback">

                                                        {{ $message }}

                                                    </div>

                                                @enderror


                                            </div>


                                        </div>



                                        {{-- =================================
                                            EMAIL
                                        ================================== --}}
                                        <div class="col-12 col-md-6">


                                            <label
                                                for="userEmail"
                                                class="form-label fw-semibold"
                                            >

                                                Email Address

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <div class="input-group">


                                                <span class="input-group-text bg-light">

                                                    <i class="bi bi-envelope"></i>

                                                </span>


                                                <input
                                                    type="email"
                                                    id="userEmail"
                                                    name="email"
                                                    value="{{ old('email') }}"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="Enter email address"
                                                    autocomplete="email"
                                                    required
                                                >


                                                @error('email')

                                                    <div class="invalid-feedback">

                                                        {{ $message }}

                                                    </div>

                                                @enderror


                                            </div>


                                        </div>



                                        {{-- =================================
                                            PHONE
                                        ================================== --}}
                                        <div class="col-12 col-md-6">


                                            <label
                                                for="userPhone"
                                                class="form-label fw-semibold"
                                            >

                                                Phone Number

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <div class="input-group">


                                                <span class="input-group-text bg-light">

                                                    <i class="bi bi-telephone"></i>

                                                </span>


                                                <input
                                                    type="tel"
                                                    id="userPhone"
                                                    name="phone"
                                                    value="{{ old('phone') }}"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    placeholder="For example: 03001234567"
                                                    autocomplete="tel"
                                                    required
                                                >


                                                @error('phone')

                                                    <div class="invalid-feedback">

                                                        {{ $message }}

                                                    </div>

                                                @enderror


                                            </div>


                                        </div>



                                        {{-- =================================
                                            ROLE
                                        ================================== --}}
                                        <div class="col-12 col-md-6">


                                            <label
                                                for="role"
                                                class="form-label fw-semibold"
                                            >

                                                User Role

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <select
                                                name="role"
                                                id="role"
                                                class="form-select @error('role') is-invalid @enderror"
                                                required
                                            >


                                                <option value="">

                                                    Select role

                                                </option>


                                                <option
                                                    value="admin"
                                                    @selected(
                                                        old('role') === 'admin'
                                                    )
                                                >

                                                    Admin

                                                </option>


                                                <option
                                                    value="beneficiary"
                                                    @selected(
                                                        old('role') === 'beneficiary'
                                                    )
                                                >

                                                    Beneficiary

                                                </option>


                                                <option
                                                    value="donor"
                                                    @selected(
                                                        old('role') === 'donor'
                                                    )
                                                >

                                                    Donor

                                                </option>


                                            </select>


                                            @error('role')

                                                <div class="invalid-feedback">

                                                    {{ $message }}

                                                </div>

                                            @enderror


                                            <div class="form-text">

                                                The selected role controls portal permissions.

                                            </div>


                                        </div>



                                        {{-- =================================
                                            QALAM ID
                                        ================================== --}}
                                        <div
                                            class="col-12 col-md-6 d-none"
                                            id="qalamIdWrapper"
                                        >


                                            <label
                                                for="qalam_id"
                                                class="form-label fw-semibold"
                                            >

                                                Qalam ID

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <div class="input-group">


                                                <span class="input-group-text bg-light">

                                                    <i class="bi bi-person-badge"></i>

                                                </span>


                                                <input
                                                    type="text"
                                                    name="qalam_id"
                                                    id="qalam_id"
                                                    value="{{ old('qalam_id') }}"
                                                    class="form-control @error('qalam_id') is-invalid @enderror"
                                                    placeholder="Enter beneficiary Qalam ID"
                                                >


                                                @error('qalam_id')

                                                    <div class="invalid-feedback">

                                                        {{ $message }}

                                                    </div>

                                                @enderror


                                            </div>


                                            <div class="form-text">

                                                Required only for beneficiary accounts.

                                            </div>


                                        </div>



                                        {{-- =================================
                                            ACCOUNT STATUS
                                        ================================== --}}
                                        <div class="col-12 col-md-6">


                                            <label
                                                for="account_status"
                                                class="form-label fw-semibold"
                                            >

                                                Account Status

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <select
                                                name="account_status"
                                                id="account_status"
                                                class="form-select @error('account_status') is-invalid @enderror"
                                                required
                                            >


                                                <option
                                                    value="active"
                                                    @selected(
                                                        old(
                                                            'account_status',
                                                            'active'
                                                        ) === 'active'
                                                    )
                                                >

                                                    Active — Allow system access

                                                </option>


                                                <option
                                                    value="suspended"
                                                    @selected(
                                                        old('account_status')
                                                        === 'suspended'
                                                    )
                                                >

                                                    Suspended — Temporarily disable access

                                                </option>


                                                <option
                                                    value="blocked"
                                                    @selected(
                                                        old('account_status')
                                                        === 'blocked'
                                                    )
                                                >

                                                    Blocked — Deny system access

                                                </option>


                                            </select>


                                            @error('account_status')

                                                <div class="invalid-feedback">

                                                    {{ $message }}

                                                </div>

                                            @enderror


                                        </div>


                                    </div>


                                </div>


                            </div>



                            {{-- =============================================
                                SECURITY INFORMATION
                            ============================================== --}}
                            <div class="create-user-card card border-0 shadow-sm rounded-4 overflow-hidden">


                                <div class="card-header bg-white border-bottom px-4 py-3">


                                    <div class="d-flex align-items-center gap-3">


                                        <span class="create-section-icon bg-warning-subtle text-warning-emphasis">

                                            <i class="bi bi-shield-lock fs-5"></i>

                                        </span>


                                        <div>


                                            <h5 class="fw-semibold text-dark mb-1">

                                                Security Information

                                            </h5>


                                            <p class="text-secondary small mb-0">

                                                Create and confirm the user's login password.

                                            </p>


                                        </div>


                                    </div>


                                </div>



                                <div class="card-body p-4">


                                    <div class="row g-4">


                                        {{-- =================================
                                            PASSWORD
                                        ================================== --}}
                                        <div class="col-12 col-md-6">


                                            <label
                                                for="userPassword"
                                                class="form-label fw-semibold"
                                            >

                                                Password

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <div class="input-group">


                                                <span class="input-group-text bg-light">

                                                    <i class="bi bi-lock"></i>

                                                </span>


                                                <input
                                                    type="password"
                                                    id="userPassword"
                                                    name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Enter password"
                                                    autocomplete="new-password"
                                                    minlength="8"
                                                    required
                                                >


                                                <button
                                                    type="button"
                                                    id="togglePassword"
                                                    class="btn btn-outline-secondary"
                                                    aria-label="Show or hide password"
                                                >

                                                    <i
                                                        id="passwordIcon"
                                                        class="bi bi-eye"
                                                    ></i>

                                                </button>


                                                @error('password')

                                                    <div class="invalid-feedback">

                                                        {{ $message }}

                                                    </div>

                                                @enderror


                                            </div>


                                        </div>



                                        {{-- =================================
                                            CONFIRM PASSWORD
                                            THIS FIXES YOUR ERROR
                                        ================================== --}}
                                        <div class="col-12 col-md-6">


                                            <label
                                                for="passwordConfirmation"
                                                class="form-label fw-semibold"
                                            >

                                                Confirm Password

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <div class="input-group">


                                                <span class="input-group-text bg-light">

                                                    <i class="bi bi-lock-fill"></i>

                                                </span>


                                                <input
                                                    type="password"
                                                    id="passwordConfirmation"
                                                    name="password_confirmation"
                                                    class="form-control"
                                                    placeholder="Re-enter password"
                                                    autocomplete="new-password"
                                                    minlength="8"
                                                    required
                                                >


                                                <button
                                                    type="button"
                                                    id="togglePasswordConfirmation"
                                                    class="btn btn-outline-secondary"
                                                    aria-label="Show or hide password confirmation"
                                                >

                                                    <i
                                                        id="passwordConfirmationIcon"
                                                        class="bi bi-eye"
                                                    ></i>

                                                </button>


                                            </div>


                                            <div
                                                id="passwordMatchMessage"
                                                class="form-text"
                                            >

                                                Re-enter the same password for confirmation.

                                            </div>


                                        </div>



                                        <div class="col-12">


                                            <div class="password-strength-info">


                                                <div class="fw-semibold text-dark mb-2">

                                                    <i class="bi bi-info-circle text-primary me-1"></i>

                                                    Password Requirements

                                                </div>


                                                <div class="row g-2 small text-secondary">


                                                    <div class="col-12 col-md-6">

                                                        <i class="bi bi-check2 me-1"></i>

                                                        At least 8 characters

                                                    </div>


                                                    <div class="col-12 col-md-6">

                                                        <i class="bi bi-check2 me-1"></i>

                                                        Password and confirmation must match

                                                    </div>


                                                </div>


                                            </div>


                                        </div>


                                    </div>


                                </div>


                            </div>


                        </div>



                        {{-- =================================================
                            RIGHT SIDE
                        ================================================== --}}
                        <div class="col-12 col-xl-4">


                            <div
                                class="position-sticky"
                                style="top:20px;"
                            >


                                {{-- =========================================
                                    PROFILE PHOTO
                                ========================================== --}}
                                <div class="create-user-card card border-0 shadow-sm rounded-4 overflow-hidden mb-4">


                                    <div class="card-header bg-white border-bottom px-4 py-3">


                                        <h5 class="fw-semibold text-dark mb-1">

                                            Profile Photo

                                        </h5>


                                        <p class="text-secondary small mb-0">

                                            Upload an optional profile image.

                                        </p>


                                    </div>



                                    <div class="card-body p-4">


                                        <div class="text-center mb-4">


                                            <span
                                                id="defaultAvatar"
                                                class="profile-preview d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold fs-2"
                                            >

                                                <i class="bi bi-person"></i>

                                            </span>


                                            <img
                                                id="imagePreview"
                                                src=""
                                                alt="Profile preview"
                                                class="profile-preview rounded-circle border border-3 d-none"
                                            >


                                        </div>



                                        <label
                                            for="profileImage"
                                            class="form-label fw-semibold"
                                        >

                                            Select Image

                                        </label>


                                        <input
                                            type="file"
                                            id="profileImage"
                                            name="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                        >


                                        @error('image')

                                            <div class="invalid-feedback">

                                                {{ $message }}

                                            </div>

                                        @enderror


                                        <div class="form-text">

                                            JPG, JPEG, PNG or WebP. Maximum 2 MB.

                                        </div>


                                    </div>


                                </div>



                                {{-- =========================================
                                    ROLE INFORMATION
                                ========================================== --}}
                                <div class="create-user-card card border-0 shadow-sm rounded-4">


                                    <div class="card-header bg-white border-bottom px-4 py-3">


                                        <h5 class="fw-semibold text-dark mb-1">

                                            Role Information

                                        </h5>


                                        <p class="text-secondary small mb-0">

                                            Access depends on the selected role.

                                        </p>


                                    </div>



                                    <div class="card-body p-4">


                                        <div
                                            id="roleDefaultInfo"
                                            class="role-information active"
                                        >

                                            <div class="d-flex gap-3">


                                                <i class="bi bi-person-gear text-secondary fs-4"></i>


                                                <div>


                                                    <strong class="d-block mb-1">

                                                        Select a Role

                                                    </strong>


                                                    <small class="text-secondary">

                                                        Choose Admin, Beneficiary or Donor to view role information.

                                                    </small>


                                                </div>


                                            </div>


                                        </div>



                                        <div
                                            id="roleAdminInfo"
                                            class="role-information"
                                        >


                                            <div class="d-flex gap-3">


                                                <i class="bi bi-shield-check text-success fs-4"></i>


                                                <div>


                                                    <strong class="d-block mb-1">

                                                        Administrator

                                                    </strong>


                                                    <small class="text-secondary">

                                                        Can manage users, requests, products, categories and administrative operations.

                                                    </small>


                                                </div>


                                            </div>


                                        </div>



                                        <div
                                            id="roleBeneficiaryInfo"
                                            class="role-information"
                                        >


                                            <div class="d-flex gap-3">


                                                <i class="bi bi-mortarboard text-info fs-4"></i>


                                                <div>


                                                    <strong class="d-block mb-1">

                                                        Beneficiary

                                                    </strong>


                                                    <small class="text-secondary">

                                                        Can complete a student profile and submit product requests. Qalam ID is required.

                                                    </small>


                                                </div>


                                            </div>


                                        </div>



                                        <div
                                            id="roleDonorInfo"
                                            class="role-information"
                                        >


                                            <div class="d-flex gap-3">


                                                <i class="bi bi-heart text-primary fs-4"></i>


                                                <div>


                                                    <strong class="d-block mb-1">

                                                        Donor

                                                    </strong>


                                                    <small class="text-secondary">

                                                        Can complete a donor profile, list products and respond to approved beneficiary requests.

                                                    </small>


                                                </div>


                                            </div>


                                        </div>


                                    </div>


                                </div>


                            </div>


                        </div>



                        {{-- =================================================
                            ACTIONS
                        ================================================== --}}
                        <div class="col-12">


                            <div class="create-user-card card border-0 shadow-sm rounded-4">


                                <div class="card-body px-4 py-3">


                                    <div class="d-flex flex-column-reverse flex-sm-row align-items-sm-center justify-content-between gap-3">


                                        <p class="text-secondary small mb-0">

                                            <i class="bi bi-info-circle me-1"></i>

                                            Fields marked with an asterisk are required.

                                        </p>


                                        <div class="d-flex flex-column-reverse flex-sm-row gap-2">


                                            <a
                                                href="{{ route('admin.user.index') }}"
                                                class="btn btn-light border"
                                            >

                                                <i class="bi bi-x-circle me-1"></i>

                                                Cancel

                                            </a>


                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                                id="saveUserButton"
                                            >

                                                <i class="bi bi-person-check me-1"></i>

                                                Save User

                                            </button>


                                        </div>


                                    </div>


                                </div>


                            </div>


                        </div>


                    </div>


                </form>


            </div>


        </main>


    </div>



    @include('layouts.admin.script')



    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {


                /*
                |--------------------------------------------------------------------------
                | Elements
                |--------------------------------------------------------------------------
                */

                const roleSelect =
                    document.getElementById(
                        'role'
                    );


                const qalamWrapper =
                    document.getElementById(
                        'qalamIdWrapper'
                    );


                const qalamInput =
                    document.getElementById(
                        'qalam_id'
                    );


                const passwordInput =
                    document.getElementById(
                        'userPassword'
                    );


                const passwordConfirmation =
                    document.getElementById(
                        'passwordConfirmation'
                    );


                const togglePassword =
                    document.getElementById(
                        'togglePassword'
                    );


                const togglePasswordConfirmation =
                    document.getElementById(
                        'togglePasswordConfirmation'
                    );


                const passwordIcon =
                    document.getElementById(
                        'passwordIcon'
                    );


                const passwordConfirmationIcon =
                    document.getElementById(
                        'passwordConfirmationIcon'
                    );


                const passwordMatchMessage =
                    document.getElementById(
                        'passwordMatchMessage'
                    );


                const profileImage =
                    document.getElementById(
                        'profileImage'
                    );


                const imagePreview =
                    document.getElementById(
                        'imagePreview'
                    );


                const defaultAvatar =
                    document.getElementById(
                        'defaultAvatar'
                    );


                const createUserForm =
                    document.getElementById(
                        'createUserForm'
                    );


                const saveUserButton =
                    document.getElementById(
                        'saveUserButton'
                    );


                /*
                |--------------------------------------------------------------------------
                | Role Information
                |--------------------------------------------------------------------------
                */

                const roleDefaultInfo =
                    document.getElementById(
                        'roleDefaultInfo'
                    );


                const roleAdminInfo =
                    document.getElementById(
                        'roleAdminInfo'
                    );


                const roleBeneficiaryInfo =
                    document.getElementById(
                        'roleBeneficiaryInfo'
                    );


                const roleDonorInfo =
                    document.getElementById(
                        'roleDonorInfo'
                    );



                function hideRoleInformation() {

                    [
                        roleDefaultInfo,
                        roleAdminInfo,
                        roleBeneficiaryInfo,
                        roleDonorInfo
                    ]
                    .forEach(
                        function (element) {

                            if (element) {
                                element.classList.remove(
                                    'active'
                                );
                            }
                        }
                    );
                }



                function updateRoleFields() {

                    if (
                        !roleSelect
                    ) {
                        return;
                    }


                    const role =
                        roleSelect.value;


                    /*
                    |--------------------------------------------------------------------------
                    | Qalam ID
                    |--------------------------------------------------------------------------
                    */

                    if (
                        qalamWrapper
                        &&
                        qalamInput
                    ) {

                        if (
                            role ===
                            'beneficiary'
                        ) {

                            qalamWrapper.classList.remove(
                                'd-none'
                            );

                            qalamInput.setAttribute(
                                'required',
                                'required'
                            );

                        } else {

                            qalamWrapper.classList.add(
                                'd-none'
                            );

                            qalamInput.removeAttribute(
                                'required'
                            );

                            /*
                             * Only clear it when the user actively changes away
                             * from beneficiary.
                             */

                            if (
                                role
                                &&
                                role !== 'beneficiary'
                            ) {

                                qalamInput.value =
                                    '';
                            }
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Role Information Card
                    |--------------------------------------------------------------------------
                    */

                    hideRoleInformation();


                    if (
                        role === 'admin'
                        &&
                        roleAdminInfo
                    ) {

                        roleAdminInfo.classList.add(
                            'active'
                        );

                    } else if (
                        role === 'beneficiary'
                        &&
                        roleBeneficiaryInfo
                    ) {

                        roleBeneficiaryInfo.classList.add(
                            'active'
                        );

                    } else if (
                        role === 'donor'
                        &&
                        roleDonorInfo
                    ) {

                        roleDonorInfo.classList.add(
                            'active'
                        );

                    } else if (
                        roleDefaultInfo
                    ) {

                        roleDefaultInfo.classList.add(
                            'active'
                        );
                    }
                }



                if (
                    roleSelect
                ) {

                    roleSelect.addEventListener(
                        'change',
                        updateRoleFields
                    );


                    updateRoleFields();
                }



                /*
                |--------------------------------------------------------------------------
                | Password Visibility
                |--------------------------------------------------------------------------
                */

                if (
                    togglePassword
                    &&
                    passwordInput
                    &&
                    passwordIcon
                ) {

                    togglePassword.addEventListener(
                        'click',
                        function () {

                            const isHidden =
                                passwordInput.type ===
                                'password';


                            passwordInput.type =
                                isHidden
                                    ? 'text'
                                    : 'password';


                            passwordIcon.classList.toggle(
                                'bi-eye',
                                !isHidden
                            );


                            passwordIcon.classList.toggle(
                                'bi-eye-slash',
                                isHidden
                            );
                        }
                    );
                }



                if (
                    togglePasswordConfirmation
                    &&
                    passwordConfirmation
                    &&
                    passwordConfirmationIcon
                ) {

                    togglePasswordConfirmation
                        .addEventListener(
                            'click',
                            function () {

                                const isHidden =
                                    passwordConfirmation.type ===
                                    'password';


                                passwordConfirmation.type =
                                    isHidden
                                        ? 'text'
                                        : 'password';


                                passwordConfirmationIcon
                                    .classList.toggle(
                                        'bi-eye',
                                        !isHidden
                                    );


                                passwordConfirmationIcon
                                    .classList.toggle(
                                        'bi-eye-slash',
                                        isHidden
                                    );
                            }
                        );
                }



                /*
                |--------------------------------------------------------------------------
                | Password Match
                |--------------------------------------------------------------------------
                */

                function checkPasswordMatch() {

                    if (
                        !passwordInput
                        ||
                        !passwordConfirmation
                        ||
                        !passwordMatchMessage
                    ) {
                        return;
                    }


                    if (
                        passwordConfirmation.value ===
                        ''
                    ) {

                        passwordConfirmation.classList.remove(
                            'is-valid',
                            'is-invalid'
                        );


                        passwordMatchMessage.className =
                            'form-text';


                        passwordMatchMessage.textContent =
                            'Re-enter the same password for confirmation.';


                        return;
                    }


                    const matches =
                        passwordInput.value ===
                        passwordConfirmation.value;


                    passwordConfirmation.classList.toggle(
                        'is-valid',
                        matches
                    );


                    passwordConfirmation.classList.toggle(
                        'is-invalid',
                        !matches
                    );


                    if (
                        matches
                    ) {

                        passwordMatchMessage.className =
                            'form-text text-success';


                        passwordMatchMessage.innerHTML =
                            '<i class="bi bi-check-circle me-1"></i>Passwords match.';

                    } else {

                        passwordMatchMessage.className =
                            'form-text text-danger';


                        passwordMatchMessage.innerHTML =
                            '<i class="bi bi-x-circle me-1"></i>Passwords do not match.';
                    }
                }



                if (
                    passwordInput
                ) {

                    passwordInput.addEventListener(
                        'input',
                        checkPasswordMatch
                    );
                }


                if (
                    passwordConfirmation
                ) {

                    passwordConfirmation.addEventListener(
                        'input',
                        checkPasswordMatch
                    );
                }



                /*
                |--------------------------------------------------------------------------
                | Image Preview
                |--------------------------------------------------------------------------
                */

                if (
                    profileImage
                    &&
                    imagePreview
                    &&
                    defaultAvatar
                ) {

                    profileImage.addEventListener(
                        'change',
                        function () {

                            const selectedFile =
                                this.files[0];


                            if (
                                !selectedFile
                            ) {

                                imagePreview.src =
                                    '';

                                imagePreview.classList.add(
                                    'd-none'
                                );

                                defaultAvatar.classList.remove(
                                    'd-none'
                                );

                                return;
                            }


                            const validTypes = [
                                'image/jpeg',
                                'image/png',
                                'image/webp'
                            ];


                            if (
                                !validTypes.includes(
                                    selectedFile.type
                                )
                            ) {

                                this.value =
                                    '';


                                imagePreview.src =
                                    '';


                                imagePreview.classList.add(
                                    'd-none'
                                );


                                defaultAvatar.classList.remove(
                                    'd-none'
                                );


                                alert(
                                    'Please select a JPG, PNG or WebP image.'
                                );

                                return;
                            }


                            if (
                                selectedFile.size >
                                2 * 1024 * 1024
                            ) {

                                this.value =
                                    '';


                                alert(
                                    'Image size must not exceed 2 MB.'
                                );

                                return;
                            }


                            const reader =
                                new FileReader();


                            reader.addEventListener(
                                'load',
                                function (event) {

                                    imagePreview.src =
                                        event.target.result;


                                    imagePreview.classList.remove(
                                        'd-none'
                                    );


                                    defaultAvatar.classList.add(
                                        'd-none'
                                    );
                                }
                            );


                            reader.readAsDataURL(
                                selectedFile
                            );
                        }
                    );
                }



                /*
                |--------------------------------------------------------------------------
                | Form Submit Validation
                |--------------------------------------------------------------------------
                */

                if (
                    createUserForm
                ) {

                    createUserForm.addEventListener(
                        'submit',
                        function (event) {


                            /*
                            |--------------------------------------------------------------------------
                            | Password Match
                            |--------------------------------------------------------------------------
                            */

                            if (
                                passwordInput
                                &&
                                passwordConfirmation
                                &&
                                passwordInput.value !==
                                passwordConfirmation.value
                            ) {

                                event.preventDefault();


                                passwordConfirmation.classList.add(
                                    'is-invalid'
                                );


                                passwordConfirmation.focus();


                                alert(
                                    'Password and confirmation password must match.'
                                );


                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Beneficiary Qalam ID
                            |--------------------------------------------------------------------------
                            */

                            if (
                                roleSelect
                                &&
                                roleSelect.value ===
                                'beneficiary'
                                &&
                                qalamInput
                                &&
                                !qalamInput.value.trim()
                            ) {

                                event.preventDefault();


                                qalamInput.focus();


                                alert(
                                    'Qalam ID is required for beneficiary accounts.'
                                );


                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Prevent Double Submission
                            |--------------------------------------------------------------------------
                            */

                            if (
                                saveUserButton
                            ) {

                                saveUserButton.disabled =
                                    true;


                                saveUserButton.innerHTML =
                                    '<span class="spinner-border spinner-border-sm me-2"></span>Creating User...';
                            }
                        }
                    );
                }


            }
        );

    </script>


</body>
@include('layouts.admin.head')

<title>Update User</title>

<body>

    @php
        $beneficiaryProfile = $user->beneficiaryProfile;
    @endphp


    {{-- Sidebar --}}
    @include('layouts.admin.sidebar')


    <div class="nsn-main">

        {{-- Topbar --}}
        @include('layouts.admin.header')


        <main class="nsn-content">


            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

                <div>

                    <h3 class="fw-bold text-dark mb-1">
                        Update User
                    </h3>

                    <p class="text-secondary small mb-0">
                        Update account information, beneficiary details,
                        password and profile photo.
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


            {{-- =========================================================
                BREADCRUMB
            ========================================================== --}}
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
                        Update User
                    </li>

                </ol>

            </nav>


            @include('layouts.admin.alert')


            {{-- =========================================================
                VALIDATION ERRORS
            ========================================================== --}}
            @if ($errors->any())

                <div
                    class="alert alert-danger alert-dismissible fade show mb-4"
                    role="alert"
                >

                    <div class="d-flex gap-3">

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        <div>

                            <h6 class="fw-semibold mb-2">
                                Please correct the following errors:
                            </h6>

                            <ul class="mb-0 ps-3">

                                @foreach ($errors->all() as $error)

                                    <li class="small">
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
                        aria-label="Close"
                    ></button>

                </div>

            @endif


            <div class="row justify-content-center">

                <div class="col-12 col-xl-11">


                    <form
                        method="POST"
                        action="{{ route('admin.user.update', $user->id) }}"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        @method('PUT')


                        <div class="row g-4">


                            {{-- =================================================
                                LEFT SIDE
                            ================================================== --}}
                            <div class="col-12 col-xl-8">


                                {{-- =============================================
                                    ACCOUNT INFORMATION
                                ============================================== --}}
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                                    <div class="card-header bg-white border-bottom px-4 py-3">

                                        <div class="d-flex align-items-center gap-3">

                                            <span
                                                class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary"
                                                style="width:46px;height:46px;"
                                            >
                                                <i class="bi bi-person-gear fs-5"></i>
                                            </span>


                                            <div>

                                                <h5 class="fw-semibold text-dark mb-1">
                                                    Account Information
                                                </h5>

                                                <p class="text-secondary small mb-0">
                                                    Editing
                                                    <strong>
                                                        {{ $user->name }}
                                                    </strong>
                                                </p>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="card-body p-4">

                                        <div class="row g-4">


                                            {{-- Name --}}
                                            <div class="col-12 col-md-6">

                                                <label
                                                    for="userName"
                                                    class="form-label fw-semibold"
                                                >
                                                    Full Name
                                                    <span class="text-danger">*</span>
                                                </label>


                                                <div class="input-group">

                                                    <span class="input-group-text bg-light">

                                                        <i class="bi bi-person"></i>

                                                    </span>


                                                    <input
                                                        type="text"
                                                        id="userName"
                                                        name="name"
                                                        value="{{ old('name', $user->name) }}"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        required
                                                    >

                                                    @error('name')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>

                                            </div>


                                            {{-- Email --}}
                                            <div class="col-12 col-md-6">

                                                <label
                                                    for="userEmail"
                                                    class="form-label fw-semibold"
                                                >
                                                    Email Address
                                                    <span class="text-danger">*</span>
                                                </label>


                                                <div class="input-group">

                                                    <span class="input-group-text bg-light">

                                                        <i class="bi bi-envelope"></i>

                                                    </span>


                                                    <input
                                                        type="email"
                                                        id="userEmail"
                                                        name="email"
                                                        value="{{ old('email', $user->email) }}"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        required
                                                    >

                                                    @error('email')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>

                                            </div>


                                            {{-- Phone --}}
                                            <div class="col-12 col-md-6">

                                                <label
                                                    for="userPhone"
                                                    class="form-label fw-semibold"
                                                >
                                                    Phone Number
                                                </label>


                                                <div class="input-group">

                                                    <span class="input-group-text bg-light">

                                                        <i class="bi bi-telephone"></i>

                                                    </span>


                                                    <input
                                                        type="tel"
                                                        id="userPhone"
                                                        name="phone"
                                                        value="{{ old('phone', $user->phone) }}"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        placeholder="03001234567"
                                                    >

                                                    @error('phone')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>

                                            </div>


                                            {{-- Role --}}
                                            <div class="col-12 col-md-6">

                                                <label
                                                    for="role"
                                                    class="form-label fw-semibold"
                                                >
                                                    User Role
                                                    <span class="text-danger">*</span>
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
                                                            old('role', $user->role) === 'admin'
                                                        )
                                                    >
                                                        Admin
                                                    </option>


                                                    <option
                                                        value="beneficiary"
                                                        @selected(
                                                            old('role', $user->role) === 'beneficiary'
                                                        )
                                                    >
                                                        Beneficiary
                                                    </option>


                                                    <option
                                                        value="donor"
                                                        @selected(
                                                            old('role', $user->role) === 'donor'
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

                                            </div>


                                            {{-- Qalam ID --}}
                                            <div
                                                class="col-12 col-md-6"
                                                id="qalamIdWrapper"
                                            >

                                                <label
                                                    for="qalam_id"
                                                    class="form-label fw-semibold"
                                                >
                                                    Qalam ID
                                                    <span class="text-danger">*</span>
                                                </label>


                                                <div class="input-group">

                                                    <span class="input-group-text bg-light">

                                                        <i class="bi bi-person-badge"></i>

                                                    </span>


                                                    <input
                                                        type="text"
                                                        id="qalam_id"
                                                        name="qalam_id"
                                                        value="{{ old('qalam_id', $user->qalam_id) }}"
                                                        class="form-control @error('qalam_id') is-invalid @enderror"
                                                        placeholder="Enter Qalam ID"
                                                    >

                                                    @error('qalam_id')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>


                                                <div class="form-text">
                                                    Required only for beneficiaries.
                                                </div>

                                            </div>


                                            {{-- Password --}}
                                            <div class="col-12 col-md-6">

                                                <label
                                                    for="userPassword"
                                                    class="form-label fw-semibold"
                                                >
                                                    New Password
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
                                                        placeholder="Leave empty to keep current password"
                                                    >


                                                    <button
                                                        type="button"
                                                        id="togglePassword"
                                                        class="btn btn-outline-secondary"
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


                                            {{-- Password Confirmation --}}
                                            <div class="col-12 col-md-6">

                                                <label
                                                    for="passwordConfirmation"
                                                    class="form-label fw-semibold"
                                                >
                                                    Confirm New Password
                                                </label>


                                                <div class="input-group">

                                                    <span class="input-group-text bg-light">

                                                        <i class="bi bi-shield-lock"></i>

                                                    </span>


                                                    <input
                                                        type="password"
                                                        id="passwordConfirmation"
                                                        name="password_confirmation"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        placeholder="Confirm new password"
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


                                                    @error('password_confirmation')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>

                                            </div>


                                            <div class="col-12 mt-2">

                                                <div class="form-text">

                                                    Leave both password fields empty
                                                    to keep the current password.

                                                </div>

                                            </div>


                                        </div>

                                    </div>

                                </div>



                                {{-- =============================================
                                    BENEFICIARY PROFILE
                                ============================================== --}}
                                <div
                                    id="beneficiaryProfileWrapper"
                                    class="beneficiary-profile-wrapper"
                                >


                                    {{-- Personal Information --}}
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center rounded-circle bg-info-subtle text-info-emphasis"
                                                    style="width:46px;height:46px;"
                                                >
                                                    <i class="bi bi-person-vcard fs-5"></i>
                                                </span>


                                                <div>

                                                    <h5 class="fw-semibold text-dark mb-1">
                                                        Beneficiary Personal Information
                                                    </h5>

                                                    <p class="text-secondary small mb-0">
                                                        Student's personal information.
                                                    </p>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="card-body p-4">

                                            <div class="row g-4">


                                                {{-- Gender --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="gender"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Gender
                                                        <span class="text-danger">*</span>
                                                    </label>


                                                    <select
                                                        name="gender"
                                                        id="gender"
                                                        class="form-select @error('gender') is-invalid @enderror"
                                                    >

                                                        <option value="">
                                                            Select gender
                                                        </option>


                                                        <option
                                                            value="male"
                                                            @selected(
                                                                old(
                                                                    'gender',
                                                                    $beneficiaryProfile?->gender
                                                                ) === 'male'
                                                            )
                                                        >
                                                            Male
                                                        </option>


                                                        <option
                                                            value="female"
                                                            @selected(
                                                                old(
                                                                    'gender',
                                                                    $beneficiaryProfile?->gender
                                                                ) === 'female'
                                                            )
                                                        >
                                                            Female
                                                        </option>


                                                        <option
                                                            value="other"
                                                            @selected(
                                                                old(
                                                                    'gender',
                                                                    $beneficiaryProfile?->gender
                                                                ) === 'other'
                                                            )
                                                        >
                                                            Other
                                                        </option>

                                                    </select>


                                                    @error('gender')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>


                                            </div>

                                        </div>

                                    </div>



                                    {{-- Academic --}}
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success-subtle text-success"
                                                    style="width:46px;height:46px;"
                                                >
                                                    <i class="bi bi-mortarboard fs-5"></i>
                                                </span>


                                                <div>

                                                    <h5 class="fw-semibold text-dark mb-1">
                                                        Academic Information
                                                    </h5>

                                                    <p class="text-secondary small mb-0">
                                                        Student's institution, degree and academic progress.
                                                    </p>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="card-body p-4">

                                            <div class="row g-4">


                                                {{-- Institution --}}
                                                <div class="col-12">

                                                    <label
                                                        for="institution"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Institution
                                                        <span class="text-danger">*</span>
                                                    </label>


                                                    <select
                                                        name="institution"
                                                        id="institution"
                                                        class="form-select @error('institution') is-invalid @enderror"
                                                    >

                                                        <option value="">
                                                            Select institution
                                                        </option>


                                                        @foreach ([
                                                            'SEECS',
                                                            'SMME',
                                                            'SCME',
                                                            'NBS',
                                                            'SADA',
                                                            'SNS',
                                                            'ASAB',
                                                            'S3H',
                                                            'CEME',
                                                            'MCS',
                                                            'CAE',
                                                            'PNEC',
                                                            'NBC'
                                                        ] as $institutionName)

                                                            <option
                                                                value="{{ $institutionName }}"
                                                                @selected(
                                                                    old(
                                                                        'institution',
                                                                        $beneficiaryProfile?->institution
                                                                    ) === $institutionName
                                                                )
                                                            >
                                                                {{ $institutionName }}
                                                            </option>

                                                        @endforeach

                                                    </select>


                                                    @error('institution')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>



                                                {{-- Degree Level --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="degreeLevel"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Degree Level
                                                        <span class="text-danger">*</span>
                                                    </label>


                                                    <select
                                                        name="degree_level"
                                                        id="degreeLevel"
                                                        class="form-select @error('degree_level') is-invalid @enderror"
                                                    >

                                                        <option value="">
                                                            Select degree level
                                                        </option>


                                                        <option
                                                            value="UG"
                                                            @selected(
                                                                old(
                                                                    'degree_level',
                                                                    $beneficiaryProfile?->degree_level
                                                                ) === 'UG'
                                                            )
                                                        >
                                                            Undergraduate (UG)
                                                        </option>


                                                        <option
                                                            value="PG"
                                                            @selected(
                                                                old(
                                                                    'degree_level',
                                                                    $beneficiaryProfile?->degree_level
                                                                ) === 'PG'
                                                            )
                                                        >
                                                            Postgraduate (PG)
                                                        </option>


                                                        <option
                                                            value="PhD"
                                                            @selected(
                                                                old(
                                                                    'degree_level',
                                                                    $beneficiaryProfile?->degree_level
                                                                ) === 'PhD'
                                                            )
                                                        >
                                                            PhD
                                                        </option>

                                                    </select>


                                                    @error('degree_level')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>



                                                {{-- Degree Program --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="degreeProgram"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Degree Program
                                                    </label>


                                                    <input
                                                        type="text"
                                                        name="degree_program"
                                                        id="degreeProgram"
                                                        value="{{ old('degree_program', $beneficiaryProfile?->degree_program) }}"
                                                        class="form-control @error('degree_program') is-invalid @enderror"
                                                        placeholder="BS Computer Science"
                                                    >


                                                    @error('degree_program')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>



                                                {{-- Department --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="department"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Department
                                                    </label>


                                                    <input
                                                        type="text"
                                                        name="department"
                                                        id="department"
                                                        value="{{ old('department', $beneficiaryProfile?->department) }}"
                                                        class="form-control @error('department') is-invalid @enderror"
                                                        placeholder="Enter department"
                                                    >


                                                    @error('department')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>



                                                {{-- Semester --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="semester"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Current Semester
                                                    </label>


                                                    <input
                                                        type="text"
                                                        name="semester"
                                                        id="semester"
                                                        value="{{ old('semester', $beneficiaryProfile?->semester) }}"
                                                        class="form-control @error('semester') is-invalid @enderror"
                                                        placeholder="For example: 6"
                                                    >


                                                    @error('semester')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>



                                                {{-- CGPA --}}
                                                <div class="col-12">

                                                    <label
                                                        for="cgpa"
                                                        class="form-label fw-semibold"
                                                    >
                                                        CGPA
                                                    </label>


                                                    <div class="input-group">

                                                        <input
                                                            type="number"
                                                            name="cgpa"
                                                            id="cgpa"
                                                            value="{{ old('cgpa', $beneficiaryProfile?->cgpa) }}"
                                                            class="form-control @error('cgpa') is-invalid @enderror"
                                                            min="0"
                                                            max="4"
                                                            step="0.01"
                                                            placeholder="3.45"
                                                        >

                                                        <span class="input-group-text bg-light">
                                                            / 4.00
                                                        </span>


                                                        @error('cgpa')

                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>

                                                        @enderror

                                                    </div>

                                                </div>



                                                {{-- Enrollment --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="enrollmentYear"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Enrollment Year
                                                        <span class="text-danger">*</span>
                                                    </label>


                                                    <input
                                                        type="number"
                                                        name="enrollment_year"
                                                        id="enrollmentYear"
                                                        value="{{ old('enrollment_year', $beneficiaryProfile?->enrollment_year) }}"
                                                        class="form-control @error('enrollment_year') is-invalid @enderror"
                                                        min="2000"
                                                        max="2100"
                                                    >


                                                    @error('enrollment_year')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>



                                                {{-- Graduation --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="graduationYear"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Expected Graduation Year
                                                    </label>


                                                    <input
                                                        type="number"
                                                        name="graduation_year"
                                                        id="graduationYear"
                                                        value="{{ old('graduation_year', $beneficiaryProfile?->graduation_year) }}"
                                                        class="form-control bg-light @error('graduation_year') is-invalid @enderror"
                                                        readonly
                                                    >


                                                    <div
                                                        id="degreeDurationMessage"
                                                        class="form-text"
                                                    >
                                                        Calculated automatically from degree level.
                                                    </div>

                                                </div>


                                            </div>

                                        </div>

                                    </div>



                                    {{-- Family --}}
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center rounded-circle bg-info-subtle text-info-emphasis"
                                                    style="width:46px;height:46px;"
                                                >
                                                    <i class="bi bi-people fs-5"></i>
                                                </span>


                                                <div>

                                                    <h5 class="fw-semibold text-dark mb-1">
                                                        Family & Financial Information
                                                    </h5>

                                                    <p class="text-secondary small mb-0">
                                                        Guardian and household financial information.
                                                    </p>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="card-body p-4">

                                            <div class="row g-4">


                                                {{-- Father --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="fatherStatus"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Father Status
                                                        <span class="text-danger">*</span>
                                                    </label>


                                                    <select
                                                        name="father_status"
                                                        id="fatherStatus"
                                                        class="form-select @error('father_status') is-invalid @enderror"
                                                    >

                                                        <option value="">
                                                            Select status
                                                        </option>


                                                        <option
                                                            value="Alive"
                                                            @selected(
                                                                old(
                                                                    'father_status',
                                                                    $beneficiaryProfile?->father_status
                                                                ) === 'Alive'
                                                            )
                                                        >
                                                            Alive
                                                        </option>


                                                        <option
                                                            value="Deceased"
                                                            @selected(
                                                                old(
                                                                    'father_status',
                                                                    $beneficiaryProfile?->father_status
                                                                ) === 'Deceased'
                                                            )
                                                        >
                                                            Deceased
                                                        </option>

                                                    </select>


                                                    @error('father_status')

                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>

                                                    @enderror

                                                </div>



                                                {{-- Guardian --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="guardianProfession"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Guardian Profession
                                                    </label>


                                                    <input
                                                        type="text"
                                                        name="guardian_profession"
                                                        id="guardianProfession"
                                                        value="{{ old('guardian_profession', $beneficiaryProfile?->guardian_profession) }}"
                                                        class="form-control @error('guardian_profession') is-invalid @enderror"
                                                    >

                                                </div>



                                                {{-- Income --}}
                                                <div class="col-12">

                                                    <label
                                                        for="monthlyIncome"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Monthly Household Income
                                                    </label>


                                                    <div class="input-group">

                                                        <span class="input-group-text bg-light">
                                                            PKR
                                                        </span>


                                                        <input
                                                            type="number"
                                                            name="monthly_income"
                                                            id="monthlyIncome"
                                                            value="{{ old('monthly_income', $beneficiaryProfile?->monthly_income) }}"
                                                            class="form-control @error('monthly_income') is-invalid @enderror"
                                                            min="0"
                                                            step="0.01"
                                                        >

                                                    </div>

                                                </div>


                                            </div>

                                        </div>

                                    </div>



                                    {{-- Location --}}
                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning-subtle text-warning-emphasis"
                                                    style="width:46px;height:46px;"
                                                >
                                                    <i class="bi bi-geo-alt fs-5"></i>
                                                </span>


                                                <div>

                                                    <h5 class="fw-semibold text-dark mb-1">
                                                        Location Information
                                                    </h5>

                                                    <p class="text-secondary small mb-0">
                                                        Student domicile and permanent address.
                                                    </p>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="card-body p-4">

                                            <div class="row g-4">


                                                {{-- Province --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="province"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Province / Territory
                                                        <span class="text-danger">*</span>
                                                    </label>


                                                    <select
                                                        name="province"
                                                        id="province"
                                                        class="form-select @error('province') is-invalid @enderror"
                                                    >

                                                        <option value="">
                                                            Select province
                                                        </option>


                                                        @foreach ([
                                                            'Punjab',
                                                            'Sindh',
                                                            'Khyber Pakhtunkhwa',
                                                            'Balochistan',
                                                            'Gilgit Baltistan',
                                                            'Azad Jammu & Kashmir',
                                                            'Islamabad Capital Territory'
                                                        ] as $provinceName)

                                                            <option
                                                                value="{{ $provinceName }}"
                                                                @selected(
                                                                    old(
                                                                        'province',
                                                                        $beneficiaryProfile?->province
                                                                    ) === $provinceName
                                                                )
                                                            >
                                                                {{ $provinceName }}
                                                            </option>

                                                        @endforeach

                                                    </select>

                                                </div>



                                                {{-- Domicile --}}
                                                <div class="col-12 col-md-6">

                                                    <label
                                                        for="domicile"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Domicile
                                                    </label>


                                                    <select
                                                        name="domicile"
                                                        id="domicile"
                                                        class="form-select @error('domicile') is-invalid @enderror"
                                                        data-selected-domicile="{{ old('domicile', $beneficiaryProfile?->domicile) }}"
                                                    >

                                                        <option value="">
                                                            Select province first
                                                        </option>

                                                    </select>

                                                </div>



                                                {{-- Address --}}
                                                <div class="col-12">

                                                    <label
                                                        for="homeAddress"
                                                        class="form-label fw-semibold"
                                                    >
                                                        Home Address
                                                        <span class="text-danger">*</span>
                                                    </label>


                                                    <textarea
                                                        name="home_address"
                                                        id="homeAddress"
                                                        rows="4"
                                                        class="form-control @error('home_address') is-invalid @enderror"
                                                        placeholder="Enter permanent home address"
                                                    >{{ old('home_address', $beneficiaryProfile?->home_address) }}</textarea>

                                                </div>


                                            </div>

                                        </div>

                                    </div>


                                </div>

                            </div>



                            {{-- =================================================
                                RIGHT SIDE - PROFILE IMAGE
                            ================================================== --}}
                            <div class="col-12 col-xl-4">

                                <div
                                    class="card border-0 shadow-sm rounded-4 overflow-hidden"
                                    style="position: sticky; top: 20px;"
                                >

                                    <div class="card-header bg-white border-bottom px-4 py-3">

                                        <h5 class="fw-semibold text-dark mb-1">
                                            Profile Photo
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            View or replace current profile image.
                                        </p>

                                    </div>


                                    <div class="card-body p-4">


                                        <div class="text-center mb-4">


                                            @if ($profileImageUrl)

                                                <img
                                                    id="imagePreview"
                                                    src="{{ $profileImageUrl }}"
                                                    alt="{{ $user->name }}"
                                                    width="130"
                                                    height="130"
                                                    class="rounded-circle border border-3 object-fit-cover"
                                                >


                                                <span
                                                    id="defaultAvatar"
                                                    class="d-none align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold fs-2"
                                                    style="width:130px;height:130px;"
                                                >
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>

                                            @else

                                                <img
                                                    id="imagePreview"
                                                    src=""
                                                    width="130"
                                                    height="130"
                                                    class="rounded-circle border border-3 object-fit-cover d-none"
                                                    alt="Preview"
                                                >


                                                <span
                                                    id="defaultAvatar"
                                                    class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold fs-2"
                                                    style="width:130px;height:130px;"
                                                >
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </span>

                                            @endif


                                            <h5 class="fw-semibold mt-3 mb-1">
                                                {{ $user->name }}
                                            </h5>


                                            <span class="badge rounded-pill bg-primary-subtle text-primary text-capitalize px-3 py-2">
                                                {{ $user->role }}
                                            </span>

                                        </div>



                                        <label
                                            for="profileImage"
                                            class="form-label fw-semibold"
                                        >
                                            Replace Profile Photo
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
                                            JPG, JPEG, PNG or WebP only. Maximum file size: 200 KB.
                                        </div>



                                        <div class="border rounded-3 overflow-hidden mt-4">


                                            <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                                <span class="text-secondary small">
                                                    User ID
                                                </span>

                                                <strong class="small">
                                                    #{{ $user->id }}
                                                </strong>

                                            </div>


                                            <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                                <span class="text-secondary small">
                                                    Qalam ID
                                                </span>

                                                <strong class="small">
                                                    {{ $user->qalam_id ?? 'N/A' }}
                                                </strong>

                                            </div>


                                            @if ($beneficiaryProfile)

                                                <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                                    <span class="text-secondary small">
                                                        Institution
                                                    </span>

                                                    <strong class="small">
                                                        {{ $beneficiaryProfile->institution ?? 'N/A' }}
                                                    </strong>

                                                </div>


                                                <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                                    <span class="text-secondary small">
                                                        Degree
                                                    </span>

                                                    <strong class="small">
                                                        {{ $beneficiaryProfile->degree_level ?? 'N/A' }}
                                                    </strong>

                                                </div>


                                                <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                                    <span class="text-secondary small">
                                                        CGPA
                                                    </span>

                                                    <strong class="small">
                                                        {{ $beneficiaryProfile->cgpa ?? 'N/A' }}
                                                    </strong>

                                                </div>

                                            @endif


                                            <div class="d-flex justify-content-between gap-3 p-3">

                                                <span class="text-secondary small">
                                                    Joined
                                                </span>

                                                <strong class="small">
                                                    {{ optional($user->created_at)->format('d M Y') }}
                                                </strong>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            {{-- =================================================
                                ACTIONS
                            ================================================== --}}
                            <div class="col-12">

                                <div class="card border-0 shadow-sm rounded-4">

                                    <div class="card-body px-4 py-3">

                                        <div class="d-flex flex-column-reverse flex-sm-row align-items-sm-center justify-content-between gap-3">


                                            <p class="text-secondary small mb-0">

                                                <i class="bi bi-info-circle me-1"></i>

                                                Review all information before saving.

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
                                                    class="btn btn-primary px-4"
                                                >
                                                    <i class="bi bi-check2-circle me-1"></i>

                                                    Update User
                                                </button>


                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                        </div>

                    </form>

                </div>

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
                | Fields
                |--------------------------------------------------------------------------
                */

                const roleSelect =
                    document.getElementById('role');

                const qalamWrapper =
                    document.getElementById(
                        'qalamIdWrapper'
                    );

                const qalamInput =
                    document.getElementById(
                        'qalam_id'
                    );

                const beneficiaryWrapper =
                    document.getElementById(
                        'beneficiaryProfileWrapper'
                    );


                /*
                |--------------------------------------------------------------------------
                | Beneficiary Required Fields
                |--------------------------------------------------------------------------
                */

                const beneficiaryRequiredFields = [

                    document.getElementById(
                        'gender'
                    ),

                    document.getElementById(
                        'institution'
                    ),

                    document.getElementById(
                        'degreeLevel'
                    ),

                    document.getElementById(
                        'enrollmentYear'
                    ),

                    document.getElementById(
                        'fatherStatus'
                    ),

                    document.getElementById(
                        'province'
                    ),

                    document.getElementById(
                        'homeAddress'
                    ),
                ];


                /*
                |--------------------------------------------------------------------------
                | Toggle Beneficiary Fields
                |--------------------------------------------------------------------------
                */

                function toggleBeneficiaryFields() {

                    if (
                        !roleSelect
                    ) {
                        return;
                    }


                    const isBeneficiary =
                        roleSelect.value ===
                        'beneficiary';


                    /*
                    |--------------------------------------------------------------------------
                    | Qalam
                    |--------------------------------------------------------------------------
                    */

                    if (
                        qalamWrapper
                    ) {

                        qalamWrapper
                            .classList
                            .toggle(
                                'd-none',
                                !isBeneficiary
                            );
                    }


                    if (
                        qalamInput
                    ) {

                        if (
                            isBeneficiary
                        ) {

                            qalamInput
                                .setAttribute(
                                    'required',
                                    'required'
                                );

                        } else {

                            qalamInput
                                .removeAttribute(
                                    'required'
                                );
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Profile Section
                    |--------------------------------------------------------------------------
                    */

                    if (
                        beneficiaryWrapper
                    ) {

                        beneficiaryWrapper
                            .classList
                            .toggle(
                                'd-none',
                                !isBeneficiary
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Required fields
                    |--------------------------------------------------------------------------
                    */

                    beneficiaryRequiredFields
                        .forEach(
                            function (
                                field
                            ) {

                                if (
                                    !field
                                ) {
                                    return;
                                }


                                if (
                                    isBeneficiary
                                ) {

                                    field
                                        .setAttribute(
                                            'required',
                                            'required'
                                        );

                                } else {

                                    field
                                        .removeAttribute(
                                            'required'
                                        );
                                }
                            }
                        );
                }


                if (
                    roleSelect
                ) {

                    roleSelect
                        .addEventListener(
                            'change',
                            toggleBeneficiaryFields
                        );


                    toggleBeneficiaryFields();
                }



                /*
                |--------------------------------------------------------------------------
                | Degree Graduation Calculation
                |--------------------------------------------------------------------------
                */

                const degreeLevel =
                    document.getElementById(
                        'degreeLevel'
                    );

                const enrollmentYear =
                    document.getElementById(
                        'enrollmentYear'
                    );

                const graduationYear =
                    document.getElementById(
                        'graduationYear'
                    );

                const durationMessage =
                    document.getElementById(
                        'degreeDurationMessage'
                    );


                const degreeDurations = {

                    UG: 4,

                    PG: 2,

                    PhD: 2,
                };


                function calculateGraduationYear() {

                    if (
                        !degreeLevel
                        || !enrollmentYear
                        || !graduationYear
                    ) {
                        return;
                    }


                    const level =
                        degreeLevel.value;


                    const enrollment =
                        parseInt(
                            enrollmentYear.value
                        );


                    const duration =
                        degreeDurations[
                            level
                        ];


                    if (
                        !level
                        || !duration
                    ) {

                        graduationYear.value =
                            '';

                        if (
                            durationMessage
                        ) {

                            durationMessage
                                .textContent =
                                'Select degree level and enrollment year.';
                        }

                        return;
                    }


                    if (
                        !enrollment
                    ) {

                        graduationYear.value =
                            '';

                        if (
                            durationMessage
                        ) {

                            durationMessage
                                .textContent =
                                `${level} duration is ${duration} years.`;
                        }

                        return;
                    }


                    const calculated =
                        enrollment
                        + duration;


                    graduationYear.value =
                        calculated;


                    if (
                        durationMessage
                    ) {

                        durationMessage
                            .textContent =
                            `${level}: ${enrollment} - ${calculated} (${duration} years)`;
                    }
                }


                if (
                    degreeLevel
                ) {

                    degreeLevel
                        .addEventListener(
                            'change',
                            calculateGraduationYear
                        );
                }


                if (
                    enrollmentYear
                ) {

                    enrollmentYear
                        .addEventListener(
                            'input',
                            calculateGraduationYear
                        );
                }


                calculateGraduationYear();



                /*
                |--------------------------------------------------------------------------
                | Province / Domicile
                |--------------------------------------------------------------------------
                */

                const provinceField =
                    document.getElementById(
                        'province'
                    );

                const domicileField =
                    document.getElementById(
                        'domicile'
                    );


                const domicileOptions = {

                    'Punjab': [
                        'Attock',
                        'Bahawalnagar',
                        'Bahawalpur',
                        'Bhakkar',
                        'Chakwal',
                        'Chiniot',
                        'Dera Ghazi Khan',
                        'Faisalabad',
                        'Gujranwala',
                        'Gujrat',
                        'Hafizabad',
                        'Jhang',
                        'Jhelum',
                        'Kasur',
                        'Khanewal',
                        'Khushab',
                        'Kot Addu',
                        'Lahore',
                        'Layyah',
                        'Lodhran',
                        'Mandi Bahauddin',
                        'Mianwali',
                        'Multan',
                        'Murree',
                        'Muzaffargarh',
                        'Nankana Sahib',
                        'Narowal',
                        'Okara',
                        'Pakpattan',
                        'Rahim Yar Khan',
                        'Rajanpur',
                        'Rawalpindi',
                        'Sahiwal',
                        'Sargodha',
                        'Sheikhupura',
                        'Sialkot',
                        'Talagang',
                        'Taunsa',
                        'Toba Tek Singh',
                        'Vehari',
                        'Wazirabad'
                    ],

                    'Sindh': [
                        'Badin',
                        'Dadu',
                        'Ghotki',
                        'Hyderabad',
                        'Jacobabad',
                        'Jamshoro',
                        'Kambar Shahdadkot',
                        'Karachi Central',
                        'Karachi East',
                        'Karachi South',
                        'Karachi West',
                        'Kashmore',
                        'Keamari',
                        'Khairpur',
                        'Korangi',
                        'Larkana',
                        'Malir',
                        'Matiari',
                        'Mirpur Khas',
                        'Naushahro Feroze',
                        'Sanghar',
                        'Shaheed Benazirabad',
                        'Shikarpur',
                        'Sujawal',
                        'Sukkur',
                        'Tando Allahyar',
                        'Tando Muhammad Khan',
                        'Tharparkar',
                        'Thatta',
                        'Umerkot'
                    ],

                    'Khyber Pakhtunkhwa': [
                        'Abbottabad',
                        'Bajaur',
                        'Bannu',
                        'Battagram',
                        'Buner',
                        'Charsadda',
                        'Dera Ismail Khan',
                        'Hangu',
                        'Haripur',
                        'Karak',
                        'Khyber',
                        'Kohat',
                        'Kurram',
                        'Lakki Marwat',
                        'Lower Chitral',
                        'Lower Dir',
                        'Malakand',
                        'Mansehra',
                        'Mardan',
                        'Mohmand',
                        'North Waziristan',
                        'Nowshera',
                        'Orakzai',
                        'Peshawar',
                        'Shangla',
                        'Swabi',
                        'Swat',
                        'Tank',
                        'Upper Chitral',
                        'Upper Dir'
                    ],

                    'Balochistan': [
                        'Awaran',
                        'Barkhan',
                        'Chagai',
                        'Chaman',
                        'Dera Bugti',
                        'Duki',
                        'Gwadar',
                        'Harnai',
                        'Hub',
                        'Jafarabad',
                        'Jhal Magsi',
                        'Kalat',
                        'Kech',
                        'Kharan',
                        'Khuzdar',
                        'Killa Abdullah',
                        'Killa Saifullah',
                        'Kohlu',
                        'Lasbela',
                        'Loralai',
                        'Mastung',
                        'Musakhel',
                        'Nasirabad',
                        'Nushki',
                        'Panjgur',
                        'Pishin',
                        'Quetta',
                        'Sibi',
                        'Zhob',
                        'Ziarat'
                    ],

                    'Gilgit Baltistan': [
                        'Astore',
                        'Diamer',
                        'Ghanche',
                        'Ghizer',
                        'Gilgit',
                        'Hunza',
                        'Kharmang',
                        'Nagar',
                        'Shigar',
                        'Skardu'
                    ],

                    'Azad Jammu & Kashmir': [
                        'Bagh',
                        'Bhimber',
                        'Hattian Bala',
                        'Haveli',
                        'Kotli',
                        'Mirpur',
                        'Muzaffarabad',
                        'Neelum',
                        'Poonch',
                        'Sudhnoti'
                    ],

                    'Islamabad Capital Territory': [
                        'Islamabad'
                    ]
                };


                function populateDomicile(
                    province,
                    saved = ''
                ) {

                    if (
                        !domicileField
                    ) {
                        return;
                    }


                    domicileField.innerHTML =
                        '<option value="">Select domicile</option>';


                    const districts =
                        domicileOptions[
                            province
                        ] || [];


                    districts.forEach(
                        function (
                            district
                        ) {

                            const option =
                                document
                                    .createElement(
                                        'option'
                                    );


                            option.value =
                                district;


                            option.textContent =
                                district;


                            option.selected =
                                district === saved;


                            domicileField
                                .appendChild(
                                    option
                                );
                        }
                    );
                }


                if (
                    provinceField
                    && domicileField
                ) {

                    const saved =
                        domicileField
                            .dataset
                            .selectedDomicile
                        || '';


                    populateDomicile(
                        provinceField.value,
                        saved
                    );


                    provinceField
                        .addEventListener(
                            'change',
                            function () {

                                populateDomicile(
                                    this.value
                                );
                            }
                        );
                }



                /*
                |--------------------------------------------------------------------------
                | Password Toggle
                |--------------------------------------------------------------------------
                */

                const passwordInput =
                    document.getElementById(
                        'userPassword'
                    );

                const togglePassword =
                    document.getElementById(
                        'togglePassword'
                    );

                const passwordIcon =
                    document.getElementById(
                        'passwordIcon'
                    );


                if (
                    togglePassword
                    && passwordInput
                    && passwordIcon
                ) {

                    togglePassword
                        .addEventListener(
                            'click',
                            function () {

                                const hidden =
                                    passwordInput
                                        .type
                                    ===
                                    'password';


                                passwordInput.type =
                                    hidden
                                        ? 'text'
                                        : 'password';


                                passwordIcon
                                    .classList
                                    .toggle(
                                        'bi-eye',
                                        !hidden
                                    );


                                passwordIcon
                                    .classList
                                    .toggle(
                                        'bi-eye-slash',
                                        hidden
                                    );
                            }
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | Password Confirmation Toggle
                |--------------------------------------------------------------------------
                */

                const passwordConfirmationInput =
                    document.getElementById(
                        'passwordConfirmation'
                    );

                const togglePasswordConfirmation =
                    document.getElementById(
                        'togglePasswordConfirmation'
                    );

                const passwordConfirmationIcon =
                    document.getElementById(
                        'passwordConfirmationIcon'
                    );


                if (
                    togglePasswordConfirmation
                    && passwordConfirmationInput
                    && passwordConfirmationIcon
                ) {

                    togglePasswordConfirmation
                        .addEventListener(
                            'click',
                            function () {

                                const hidden =
                                    passwordConfirmationInput
                                        .type
                                    ===
                                    'password';


                                passwordConfirmationInput.type =
                                    hidden
                                        ? 'text'
                                        : 'password';


                                passwordConfirmationIcon
                                    .classList
                                    .toggle(
                                        'bi-eye',
                                        !hidden
                                    );


                                passwordConfirmationIcon
                                    .classList
                                    .toggle(
                                        'bi-eye-slash',
                                        hidden
                                    );
                            }
                        );
                }



                /*
                |--------------------------------------------------------------------------
                | Image Preview
                |--------------------------------------------------------------------------
                */

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


                if (
                    profileImage
                    && imagePreview
                    && defaultAvatar
                ) {

                    profileImage
                        .addEventListener(
                            'change',
                            function () {

                                const file =
                                    this.files[0];


                                if (
                                    !file
                                ) {
                                    return;
                                }


                                const allowedImageTypes = [
                                    'image/jpeg',
                                    'image/png',
                                    'image/webp',
                                ];


                                if (
                                    !allowedImageTypes
                                        .includes(file.type)
                                ) {

                                    this.value =
                                        '';

                                    alert(
                                        'Please select a JPG, JPEG, PNG or WebP image.'
                                    );

                                    return;
                                }


                                const maxImageSize =
                                    200 * 1024;


                                if (
                                    file.size > maxImageSize
                                ) {

                                    this.value =
                                        '';

                                    alert(
                                        'Profile image must not exceed 200 KB.'
                                    );

                                    return;
                                }


                                const reader =
                                    new FileReader();


                                reader
                                    .addEventListener(
                                        'load',
                                        function (
                                            event
                                        ) {

                                            imagePreview.src =
                                                event
                                                    .target
                                                    .result;


                                            imagePreview
                                                .classList
                                                .remove(
                                                    'd-none'
                                                );


                                            defaultAvatar
                                                .classList
                                                .add(
                                                    'd-none'
                                                );


                                            defaultAvatar
                                                .classList
                                                .remove(
                                                    'd-inline-flex'
                                                );
                                        }
                                    );


                                reader
                                    .readAsDataURL(
                                        file
                                    );
                            }
                        );
                }

            }
        );

    </script>

</body>
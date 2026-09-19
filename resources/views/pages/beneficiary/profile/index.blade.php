@include('layouts.admin.head')

<title>Beneficiary Profile</title>

<body>

    @php
        $beneficiaryProfile = $user->beneficiaryProfile;

        /*
        |--------------------------------------------------------------------------
        | Profile Completion Fields
        |--------------------------------------------------------------------------
        */

        $completionFields = [
            $user->name,
            $user->email,
            $user->image,
            $beneficiaryProfile?->gender,
            $beneficiaryProfile?->institution,
            $beneficiaryProfile?->degree_level,
            $beneficiaryProfile?->degree_program,
            $beneficiaryProfile?->enrollment_year,
            $beneficiaryProfile?->graduation_year,
            $beneficiaryProfile?->father_status,
            $beneficiaryProfile?->province,
            $beneficiaryProfile?->home_address,
        ];

        $completedFields = collect($completionFields)
            ->filter(fn ($field) => !is_null($field) && trim((string) $field) !== '')
            ->count();

        $profileCompletion = count($completionFields) > 0
            ? (int) round(($completedFields / count($completionFields)) * 100)
            : 0;
    @endphp


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

            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        Beneficiary Profile
                    </h3>

                    <p class="text-secondary small mb-0">
                        Manage your personal, academic and family information.
                    </p>
                </div>

                <a
                    href="{{ route('dashboard') }}"
                    class="btn btn-light border d-flex align-items-center gap-2"
                >
                    <i class="bi bi-arrow-left"></i>
                    <span>Back to Dashboard</span>
                </a>

            </div>


            {{-- =========================================================
                BREADCRUMB
            ========================================================== --}}
            <nav aria-label="breadcrumb" class="mb-4">

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

                    <li
                        class="breadcrumb-item active"
                        aria-current="page"
                    >
                        Beneficiary Profile
                    </li>

                </ol>

            </nav>


            {{-- =========================================================
                ALERTS
            ========================================================== --}}
            @include('layouts.admin.alert')


            {{-- =========================================================
                VALIDATION ERRORS
            ========================================================== --}}
            @if ($errors->any())

                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >

                    <div class="d-flex gap-3">

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        <div>

                            <h6 class="alert-heading fw-semibold mb-2">
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


            {{-- =========================================================
                PROFILE COMPLETION
            ========================================================== --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">

                        <div>

                            <h5 class="fw-semibold text-dark mb-1">
                                Profile Completion
                            </h5>

                            <p class="text-secondary small mb-0">
                                Complete at least 85% to access products and requests.
                            </p>

                        </div>

                        <span
                            class="fw-bold fs-5 {{ $profileCompletion >= 85 ? 'text-success' : 'text-warning' }}"
                        >
                            {{ $profileCompletion }}%
                        </span>

                    </div>


                    <div
                        class="progress"
                        role="progressbar"
                        aria-label="Profile completion"
                        aria-valuenow="{{ $profileCompletion }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        style="height: 9px;"
                    >

                        <div
                            class="progress-bar {{ $profileCompletion >= 85 ? 'bg-success' : 'bg-warning' }}"
                            style="width: {{ $profileCompletion }}%;"
                        ></div>

                    </div>


                    @if ($profileCompletion < 85)

                        <small class="d-block text-danger mt-2">

                            <i class="bi bi-lock me-1"></i>

                            Complete the missing required information to unlock all features.

                        </small>

                    @else

                        <small class="d-block text-success mt-2">

                            <i class="bi bi-check-circle me-1"></i>

                            All beneficiary features are unlocked.

                        </small>

                    @endif

                </div>

            </div>


            {{-- =========================================================
                PROFILE FORM
            ========================================================== --}}
            <form
                method="POST"
                action="{{ route('Beneficiary.profile.update') }}"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="row g-4">


                    {{-- =====================================================
                        MAIN FORM COLUMN
                    ====================================================== --}}
                    <div class="col-12 col-xl-8">


                        {{-- =================================================
                            PERSONAL INFORMATION
                        ================================================== --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                            <div class="card-header bg-white border-bottom px-4 py-3">

                                <div class="d-flex align-items-center gap-3">

                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary flex-shrink-0"
                                        style="width: 46px; height: 46px;"
                                    >
                                        <i class="bi bi-person fs-5"></i>
                                    </span>

                                    <div>

                                        <h5 class="fw-semibold text-dark mb-1">
                                            Personal Information
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            Review your basic account information.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="card-body p-4">

                                <div class="row g-4">


                                    {{-- Name --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="beneficiaryName"
                                            class="form-label fw-semibold"
                                        >
                                            Full Name
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-person"></i>
                                            </span>

                                            <input
                                                type="text"
                                                id="beneficiaryName"
                                                name="name"
                                                value="{{ old('name', $user->name) }}"
                                                class="form-control bg-light"
                                                readonly
                                            >

                                        </div>

                                    </div>


                                    {{-- Email --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="beneficiaryEmail"
                                            class="form-label fw-semibold"
                                        >
                                            Email Address
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-envelope"></i>
                                            </span>

                                            <input
                                                type="email"
                                                id="beneficiaryEmail"
                                                name="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="form-control bg-light"
                                                readonly
                                            >

                                        </div>

                                    </div>


                                    {{-- Phone --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="beneficiaryPhone"
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
                                                id="beneficiaryPhone"
                                                name="phone"
                                                value="{{ old('phone', $user->phone) }}"
                                                class="form-control bg-light"
                                                
                                            >

                                        </div>

                                        <div class="form-text">
                                            Contact an administrator if this information needs to be changed.
                                        </div>

                                    </div>


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


                        {{-- =================================================
                            ACADEMIC INFORMATION
                        ================================================== --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                            <div class="card-header bg-white border-bottom px-4 py-3">

                                <div class="d-flex align-items-center gap-3">

                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success-subtle text-success flex-shrink-0"
                                        style="width: 46px; height: 46px;"
                                    >
                                        <i class="bi bi-mortarboard fs-5"></i>
                                    </span>

                                    <div>

                                        <h5 class="fw-semibold text-dark mb-1">
                                            Academic Information
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            Provide your institution, degree and study duration.
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

                                        <div class="form-text">
                                            Graduation year will be calculated automatically.
                                        </div>

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
                                            id="degreeProgram"
                                            name="degree_program"
                                            value="{{ old('degree_program', $beneficiaryProfile?->degree_program) }}"
                                            class="form-control @error('degree_program') is-invalid @enderror"
                                            placeholder="For example: BS Computer Science"
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
                                            id="department"
                                            name="department"
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
                                            id="semester"
                                            name="semester"
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

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-bar-chart"></i>
                                            </span>

                                            <input
                                                type="number"
                                                id="cgpa"
                                                name="cgpa"
                                                value="{{ old('cgpa', $beneficiaryProfile?->cgpa) }}"
                                                class="form-control @error('cgpa') is-invalid @enderror"
                                                min="0"
                                                max="4"
                                                step="0.01"
                                                placeholder="For example: 3.45"
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


                                    {{-- Enrollment Year --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="enrollmentYear"
                                            class="form-label fw-semibold"
                                        >
                                            Enrollment Year
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-calendar-plus"></i>
                                            </span>

                                            <input
                                                type="number"
                                                id="enrollmentYear"
                                                name="enrollment_year"
                                                value="{{ old('enrollment_year', $beneficiaryProfile?->enrollment_year) }}"
                                                class="form-control @error('enrollment_year') is-invalid @enderror"
                                                min="2000"
                                                max="2100"
                                                placeholder="For example: 2023"
                                            >

                                            @error('enrollment_year')

                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Graduation Year --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="graduationYear"
                                            class="form-label fw-semibold"
                                        >
                                            Expected Graduation Year
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-calendar-check"></i>
                                            </span>

                                            <input
                                                type="number"
                                                id="graduationYear"
                                                name="graduation_year"
                                                value="{{ old('graduation_year', $beneficiaryProfile?->graduation_year) }}"
                                                class="form-control bg-light @error('graduation_year') is-invalid @enderror"
                                                min="2000"
                                                max="2100"
                                                placeholder="Calculated automatically"
                                                readonly
                                            >

                                            @error('graduation_year')

                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                            @enderror

                                        </div>

                                        <div
                                            id="degreeDurationMessage"
                                            class="form-text"
                                        >
                                            Select a degree level and enrollment year.
                                        </div>

                                    </div>


                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            FAMILY AND FINANCIAL INFORMATION
                        ================================================== --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                            <div class="card-header bg-white border-bottom px-4 py-3">

                                <div class="d-flex align-items-center gap-3">

                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-info-subtle text-info-emphasis flex-shrink-0"
                                        style="width: 46px; height: 46px;"
                                    >
                                        <i class="bi bi-people fs-5"></i>
                                    </span>

                                    <div>

                                        <h5 class="fw-semibold text-dark mb-1">
                                            Family and Financial Information
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            Provide information about your guardian and household income.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="card-body p-4">

                                <div class="row g-4">


                                    {{-- Father Status --}}
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


                                    {{-- Guardian Profession --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="guardianProfession"
                                            class="form-label fw-semibold"
                                        >
                                            Guardian Profession
                                        </label>

                                        <input
                                            type="text"
                                            id="guardianProfession"
                                            name="guardian_profession"
                                            value="{{ old('guardian_profession', $beneficiaryProfile?->guardian_profession) }}"
                                            class="form-control @error('guardian_profession') is-invalid @enderror"
                                            placeholder="Enter guardian profession"
                                        >

                                        @error('guardian_profession')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Monthly Income --}}
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
                                                id="monthlyIncome"
                                                name="monthly_income"
                                                value="{{ old('monthly_income', $beneficiaryProfile?->monthly_income) }}"
                                                class="form-control @error('monthly_income') is-invalid @enderror"
                                                min="0"
                                                step="0.01"
                                                placeholder="Enter monthly household income"
                                            >

                                            @error('monthly_income')

                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                            @enderror

                                        </div>

                                    </div>


                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            LOCATION INFORMATION
                        ================================================== --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                            <div class="card-header bg-white border-bottom px-4 py-3">

                                <div class="d-flex align-items-center gap-3">

                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning-subtle text-warning-emphasis flex-shrink-0"
                                        style="width: 46px; height: 46px;"
                                    >
                                        <i class="bi bi-geo-alt fs-5"></i>
                                    </span>

                                    <div>

                                        <h5 class="fw-semibold text-dark mb-1">
                                            Location Information
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            Enter your province, domicile and permanent address.
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
                                            Province or Territory
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

                                        @error('province')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

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
                                            id="domicile"
                                            name="domicile"
                                            class="form-select @error('domicile') is-invalid @enderror"
                                            data-selected-domicile="{{ old('domicile', $beneficiaryProfile?->domicile) }}"
                                            disabled
                                        >

                                            <option value="">
                                                Select a province first
                                            </option>

                                        </select>

                                        @error('domicile')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- Home Address --}}
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
                                            rows="5"
                                            class="form-control @error('home_address') is-invalid @enderror"
                                            placeholder="Enter your complete permanent home address"
                                        >{{ old('home_address', $beneficiaryProfile?->home_address) }}</textarea>

                                        @error('home_address')

                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                            CHANGE PASSWORD
                        ================================================== --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                            <div class="card-header bg-white border-bottom px-4 py-3">

                                <div class="d-flex align-items-center gap-3">

                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger-subtle text-danger flex-shrink-0"
                                        style="width: 46px; height: 46px;"
                                    >
                                        <i class="bi bi-shield-lock fs-5"></i>
                                    </span>

                                    <div>

                                        <h5 class="fw-semibold text-dark mb-1">
                                            Change Password
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            Leave these fields empty to keep your current password.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div class="card-body p-4">

                                <div class="row g-4">


                                    {{-- Current Password --}}
                                    <div class="col-12">

                                        <label
                                            for="currentPassword"
                                            class="form-label fw-semibold"
                                        >
                                            Current Password
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-lock"></i>
                                            </span>

                                            <input
                                                type="password"
                                                id="currentPassword"
                                                name="current_password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                placeholder="Enter your current password"
                                                autocomplete="current-password"
                                            >

                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary password-toggle"
                                                data-target="currentPassword"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            @error('current_password')

                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                            @enderror

                                        </div>

                                        <div class="form-text">
                                            Enter your current password first to enable the new password fields.
                                        </div>

                                    </div>


                                    {{-- New Password --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="newPassword"
                                            class="form-label fw-semibold"
                                        >
                                            New Password
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-key"></i>
                                            </span>

                                            <input
                                                type="password"
                                                id="newPassword"
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Enter a new password"
                                                autocomplete="new-password"
                                                disabled
                                            >

                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary password-toggle"
                                                data-target="newPassword"
                                                disabled
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            @error('password')

                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Confirm Password --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="passwordConfirmation"
                                            class="form-label fw-semibold"
                                        >
                                            Confirm New Password
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-key-fill"></i>
                                            </span>

                                            <input
                                                type="password"
                                                id="passwordConfirmation"
                                                name="password_confirmation"
                                                class="form-control"
                                                placeholder="Confirm new password"
                                                autocomplete="new-password"
                                                disabled
                                            >

                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary password-toggle"
                                                data-target="passwordConfirmation"
                                                disabled
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>

                                        </div>

                                    </div>


                                </div>

                            </div>

                        </div>


                    </div>


                    {{-- =====================================================
                        PROFILE IMAGE COLUMN
                    ====================================================== --}}
                    <div class="col-12 col-xl-4">

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                            <div class="card-header bg-white border-bottom px-4 py-3">

                                <h5 class="fw-semibold text-dark mb-1">
                                    Profile Image
                                </h5>

                                <p class="text-secondary small mb-0">
                                    View or replace your profile photo.
                                </p>

                            </div>


                            <div class="card-body p-4">

                                <div class="text-center mb-4">

                                    @if ($user->image)

                                        <img
                                            id="profilePreview"
                                            src="{{ asset('admins/asset/profilephoto/' . $user->image) }}"
                                            alt="{{ $user->name }}"
                                            width="130"
                                            height="130"
                                            class="rounded-circle border border-3 object-fit-cover"
                                        >

                                        <span
                                            id="defaultAvatar"
                                            class="d-none align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold fs-2"
                                            style="width: 130px; height: 130px;"
                                        >
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>

                                    @else

                                        <img
                                            id="profilePreview"
                                            src=""
                                            alt="Profile preview"
                                            width="130"
                                            height="130"
                                            class="rounded-circle border border-3 object-fit-cover d-none"
                                        >

                                        <span
                                            id="defaultAvatar"
                                            class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold fs-2"
                                            style="width: 130px; height: 130px;"
                                        >
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>

                                    @endif


                                    <h5 class="fw-semibold text-dark mt-3 mb-1">
                                        {{ $user->name }}
                                    </h5>

                                    <span class="badge rounded-pill bg-info-subtle text-info-emphasis px-3 py-2">
                                        Beneficiary
                                    </span>

                                </div>


                                <label
                                    for="profileImage"
                                    class="form-label fw-semibold"
                                >
                                    Upload New Image
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
                                    Accepted formats: JPG, JPEG, PNG and WebP. Maximum size: 200 KB.
                                </div>


                                {{-- =================================================
                                    ACCOUNT SUMMARY
                                ================================================== --}}
                                <div class="border rounded-3 overflow-hidden mt-4">

                                    <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                        <span class="text-secondary small">
                                            Account role
                                        </span>

                                        <span class="fw-semibold small text-capitalize">
                                            {{ $user->role }}
                                        </span>

                                    </div>


                                    <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                        <span class="text-secondary small">
                                            Qalam ID
                                        </span>

                                        <span class="fw-semibold small">
                                            {{ $user->qalam_id ?? 'Not available' }}
                                        </span>

                                    </div>


                                    <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                        <span class="text-secondary small">
                                            Institution
                                        </span>

                                        <span class="fw-semibold small">
                                            {{ $beneficiaryProfile?->institution ?? 'Not provided' }}
                                        </span>

                                    </div>


                                    <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                        <span class="text-secondary small">
                                            Degree Level
                                        </span>

                                        <span class="fw-semibold small">
                                            {{ $beneficiaryProfile?->degree_level ?? 'Not provided' }}
                                        </span>

                                    </div>


                                    <div class="d-flex justify-content-between gap-3 p-3 border-bottom">

                                        <span class="text-secondary small">
                                            Degree Program
                                        </span>

                                        <span class="fw-semibold small text-end">
                                            {{ $beneficiaryProfile?->degree_program ?? 'Not provided' }}
                                        </span>

                                    </div>


                                    <div class="d-flex justify-content-between gap-3 p-3">

                                        <span class="text-secondary small">
                                            Member since
                                        </span>

                                        <span class="fw-semibold small">
                                            {{ optional($user->created_at)->format('d M Y') }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                        FORM ACTIONS
                    ====================================================== --}}
                    <div class="col-12">

                        <div class="card border-0 shadow-sm rounded-4">

                            <div class="card-body px-4 py-3">

                                <div class="d-flex flex-column-reverse flex-sm-row align-items-sm-center justify-content-between gap-3">

                                    <p class="text-secondary small mb-0">

                                        <i class="bi bi-info-circle me-1"></i>

                                        Review your information before saving the changes.

                                    </p>


                                    <div class="d-flex flex-column-reverse flex-sm-row gap-2">

                                        <a
                                            href="{{ route('dashboard') }}"
                                            class="btn btn-light border"
                                        >
                                            <i class="bi bi-x-circle me-1"></i>
                                            Cancel
                                        </a>

                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            <i class="bi bi-check2-circle me-1"></i>
                                            Update Profile
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>

            </form>

        </main>

    </div>


    @include('layouts.admin.script')


    <script>

        document.addEventListener('DOMContentLoaded', function () {


            /*
            |--------------------------------------------------------------------------
            | DEGREE DURATION / GRADUATION YEAR
            |--------------------------------------------------------------------------
            |
            | UG  = Enrollment Year + 4
            | PG  = Enrollment Year + 2
            | PhD = Enrollment Year + 2
            |
            */

            const degreeLevelField =
                document.getElementById('degreeLevel');

            const enrollmentYearField =
                document.getElementById('enrollmentYear');

            const graduationYearField =
                document.getElementById('graduationYear');

            const degreeDurationMessage =
                document.getElementById('degreeDurationMessage');


            const degreeDurations = {
                'UG': 4,
                'PG': 2,
                'PhD': 2
            };


            const degreeLabels = {
                'UG': 'Undergraduate',
                'PG': 'Postgraduate',
                'PhD': 'PhD'
            };


            function calculateGraduationYear() {

                if (
                    !degreeLevelField ||
                    !enrollmentYearField ||
                    !graduationYearField
                ) {
                    return;
                }


                const degreeLevel =
                    degreeLevelField.value;

                const enrollmentYear =
                    parseInt(enrollmentYearField.value);


                /*
                |--------------------------------------------------------------------------
                | No Degree Selected
                |--------------------------------------------------------------------------
                */

                if (!degreeLevel) {

                    graduationYearField.value = '';

                    if (degreeDurationMessage) {

                        degreeDurationMessage.textContent =
                            'Select a degree level and enrollment year.';

                    }

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Get Duration
                |--------------------------------------------------------------------------
                */

                const duration =
                    degreeDurations[degreeLevel];


                if (!duration) {

                    graduationYearField.value = '';

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Degree Selected But Enrollment Year Missing
                |--------------------------------------------------------------------------
                */

                if (
                    !enrollmentYear ||
                    enrollmentYear < 2000 ||
                    enrollmentYear > 2100
                ) {

                    graduationYearField.value = '';

                    if (degreeDurationMessage) {

                        degreeDurationMessage.textContent =
                            degreeLabels[degreeLevel] +
                            ' program duration: ' +
                            duration +
                            ' years. Enter enrollment year to calculate graduation year.';

                    }

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Calculate Graduation Year
                |--------------------------------------------------------------------------
                */

                const graduationYear =
                    enrollmentYear + duration;


                graduationYearField.value =
                    graduationYear;


                if (degreeDurationMessage) {

                    degreeDurationMessage.textContent =
                        degreeLabels[degreeLevel] +
                        ' program: ' +
                        enrollmentYear +
                        ' - ' +
                        graduationYear +
                        ' (' +
                        duration +
                        ' years).';

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Degree Level Change
            |--------------------------------------------------------------------------
            */

            if (degreeLevelField) {

                degreeLevelField.addEventListener(
                    'change',
                    calculateGraduationYear
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Enrollment Year Change
            |--------------------------------------------------------------------------
            */

            if (enrollmentYearField) {

                enrollmentYearField.addEventListener(
                    'input',
                    calculateGraduationYear
                );

                enrollmentYearField.addEventListener(
                    'change',
                    calculateGraduationYear
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Calculate Existing Value On Page Load
            |--------------------------------------------------------------------------
            */

            calculateGraduationYear();



            /*
            |--------------------------------------------------------------------------
            | PROVINCE / DOMICILE
            |--------------------------------------------------------------------------
            */

            const provinceField =
                document.getElementById('province');

            const domicileField =
                document.getElementById('domicile');


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
                    'Central Dir',
                    'Charsadda',
                    'Dera Ismail Khan',
                    'Hangu',
                    'Haripur',
                    'Karak',
                    'Khyber',
                    'Kohat',
                    'Kolai-Palas',
                    'Kurram',
                    'Lakki Marwat',
                    'Lower Chitral',
                    'Lower Dir',
                    'Lower Kohistan',
                    'Lower South Waziristan',
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
                    'Torghar',
                    'Upper Chitral',
                    'Upper Dir',
                    'Upper Kohistan',
                    'Upper South Waziristan'
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
                    'Kachhi',
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
                    'Sherani',
                    'Sibi',
                    'Sohbatpur',
                    'Surab',
                    'Usta Muhammad',
                    'Washuk',
                    'Zhob',
                    'Ziarat'
                ],


                'Gilgit Baltistan': [
                    'Astore',
                    'Darel',
                    'Diamer',
                    'Ghanche',
                    'Ghizer',
                    'Gilgit',
                    'Gupis-Yasin',
                    'Hunza',
                    'Kharmang',
                    'Nagar',
                    'Roundu',
                    'Shigar',
                    'Skardu',
                    'Tangir'
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


            function populateDomiciles(
                selectedProvince,
                selectedDomicile = ''
            ) {

                if (!domicileField) {
                    return;
                }


                domicileField.innerHTML = '';


                const districts =
                    domicileOptions[selectedProvince] || [];


                const placeholderOption =
                    document.createElement('option');


                placeholderOption.value = '';

                placeholderOption.textContent =
                    districts.length
                        ? 'Select domicile district'
                        : 'Select a province first';


                domicileField.appendChild(
                    placeholderOption
                );


                /*
                |--------------------------------------------------------------------------
                | Preserve Existing Domicile
                |--------------------------------------------------------------------------
                */

                if (
                    selectedDomicile &&
                    !districts.includes(selectedDomicile)
                ) {

                    const savedOption =
                        document.createElement('option');


                    savedOption.value =
                        selectedDomicile;

                    savedOption.textContent =
                        selectedDomicile;

                    savedOption.selected =
                        true;


                    domicileField.appendChild(
                        savedOption
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Add District Options
                |--------------------------------------------------------------------------
                */

                districts.forEach(function (district) {

                    const option =
                        document.createElement('option');


                    option.value =
                        district;

                    option.textContent =
                        district;

                    option.selected =
                        district === selectedDomicile;


                    domicileField.appendChild(
                        option
                    );

                });


                domicileField.disabled =
                    districts.length === 0;

            }


            if (provinceField && domicileField) {

                const savedDomicile =
                    domicileField.dataset.selectedDomicile || '';


                populateDomiciles(
                    provinceField.value,
                    savedDomicile
                );


                provinceField.addEventListener(
                    'change',
                    function () {

                        populateDomiciles(
                            this.value
                        );

                    }
                );

            }



            /*
            |--------------------------------------------------------------------------
            | PROFILE IMAGE PREVIEW + 200 KB VALIDATION
            |--------------------------------------------------------------------------
            */

            const profileImage =
                document.getElementById('profileImage');

            const profilePreview =
                document.getElementById('profilePreview');

            const defaultAvatar =
                document.getElementById('defaultAvatar');

            const maximumProfileImageSize =
                200 * 1024;

            const validProfileImageTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];


            if (
                profileImage &&
                profilePreview &&
                defaultAvatar
            ) {
                profileImage.addEventListener(
                    'change',
                    function () {
                        const selectedFile =
                            this.files[0];

                        if (!selectedFile) {
                            return;
                        }

                        if (
                            !validProfileImageTypes.includes(
                                selectedFile.type
                            )
                        ) {
                            this.value = '';

                            alert(
                                'Profile image must be JPG, JPEG, PNG or WebP.'
                            );

                            return;
                        }

                        if (
                            selectedFile.size >
                            maximumProfileImageSize
                        ) {
                            this.value = '';

                            alert(
                                'Profile image must not exceed 200 KB.'
                            );

                            return;
                        }

                        const reader =
                            new FileReader();

                        reader.addEventListener(
                            'load',
                            function (event) {
                                profilePreview.src =
                                    event.target.result;

                                profilePreview.classList.remove(
                                    'd-none'
                                );

                                defaultAvatar.classList.add(
                                    'd-none'
                                );

                                defaultAvatar.classList.remove(
                                    'd-inline-flex'
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
            | PASSWORD FIELD CONTROL
            |--------------------------------------------------------------------------
            */

            const currentPasswordField =
                document.getElementById('currentPassword');

            const newPasswordField =
                document.getElementById('newPassword');

            const passwordConfirmationField =
                document.getElementById('passwordConfirmation');

            const newPasswordToggle =
                document.querySelector(
                    '[data-target="newPassword"]'
                );

            const passwordConfirmationToggle =
                document.querySelector(
                    '[data-target="passwordConfirmation"]'
                );


            if (
                currentPasswordField &&
                newPasswordField &&
                passwordConfirmationField
            ) {
                const updatePasswordFieldState =
                    function () {
                        const hasCurrentPassword =
                            currentPasswordField.value
                                .trim()
                                .length > 0;

                        newPasswordField.disabled =
                            !hasCurrentPassword;

                        passwordConfirmationField.disabled =
                            !hasCurrentPassword;

                        if (newPasswordToggle) {
                            newPasswordToggle.disabled =
                                !hasCurrentPassword;
                        }

                        if (passwordConfirmationToggle) {
                            passwordConfirmationToggle.disabled =
                                !hasCurrentPassword;
                        }

                        if (!hasCurrentPassword) {
                            newPasswordField.value = '';
                            passwordConfirmationField.value = '';

                            newPasswordField.type =
                                'password';

                            passwordConfirmationField.type =
                                'password';
                        }
                    };

                currentPasswordField.addEventListener(
                    'input',
                    updatePasswordFieldState
                );

                updatePasswordFieldState();
            }



            /*
            |--------------------------------------------------------------------------
            | PASSWORD VISIBILITY TOGGLE
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll('.password-toggle')
                .forEach(function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            const targetId =
                                this.getAttribute(
                                    'data-target'
                                );


                            const passwordField =
                                document.getElementById(
                                    targetId
                                );


                            const icon =
                                this.querySelector('i');


                            if (
                                !passwordField ||
                                !icon
                            ) {
                                return;
                            }


                            const isHidden =
                                passwordField.type ===
                                'password';


                            passwordField.type =
                                isHidden
                                    ? 'text'
                                    : 'password';


                            icon.classList.toggle(
                                'bi-eye',
                                !isHidden
                            );


                            icon.classList.toggle(
                                'bi-eye-slash',
                                isHidden
                            );

                        }
                    );

                });


        });

    </script>

</body>
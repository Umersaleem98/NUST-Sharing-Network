@include('layouts.admin.head')

<title>Update Donor Profile</title>

<body>

    {{-- New Sidebar --}}
    @include('layouts.admin.sidebar')


    {{-- Main Content --}}
    <div class="nsn-main">

        {{-- New Topbar --}}
        @include('layouts.admin.header')


        <main class="nsn-content">

            {{-- Page Header --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        Donor Profile
                    </h3>

                    <p class="text-secondary small mb-0">
                        Manage your personal, organization and account information.
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


            {{-- Breadcrumb --}}
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
                        Donor Profile
                    </li>

                </ol>

            </nav>


            {{-- Alert Messages --}}
            @include('layouts.admin.alert')


            {{-- Profile Completion --}}
            @isset($profileCompletion)

                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">

                            <div>
                                <h5 class="fw-semibold text-dark mb-1">
                                    Profile Completion
                                </h5>

                                <p class="text-secondary small mb-0">
                                    Complete at least 85% of your profile to access all donor features.
                                </p>
                            </div>

                            <span class="fw-bold fs-5 {{ $profileCompletion >= 85 ? 'text-success' : 'text-warning' }}">
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
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Add the missing profile information to unlock products and requests.
                            </small>
                        @else
                            <small class="d-block text-success mt-2">
                                <i class="bi bi-check-circle me-1"></i>
                                Your donor account features are fully unlocked.
                            </small>
                        @endif

                    </div>

                </div>

            @endisset


            <form
                method="POST"
                action="{{ route('donor.profile.update') }}"
                enctype="multipart/form-data"
            >
                @csrf


                <div class="row g-4">

                    {{-- Main Profile Information --}}
                    <div class="col-12 col-xl-8">

                        {{-- Personal Information --}}
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
                                            Review your name, email and phone number.
                                        </p>
                                    </div>

                                </div>

                            </div>


                            <div class="card-body p-4">

                                <div class="row g-4">

                                    {{-- Name --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="donorName"
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
                                                id="donorName"
                                                name="name"
                                                value="{{ old('name', $user->name) }}"
                                                class="form-control bg-light @error('name') is-invalid @enderror"
                                                readonly
                                            >

                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                        <div class="form-text">
                                            Contact an administrator to change your name.
                                        </div>

                                    </div>


                                    {{-- Email --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="donorEmail"
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
                                                id="donorEmail"
                                                name="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="form-control bg-light @error('email') is-invalid @enderror"
                                                readonly
                                            >

                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                        <div class="form-text">
                                            Your email address is used to access your account.
                                        </div>

                                    </div>


                                    {{-- Phone --}}
                                    <div class="col-12">

                                        <label
                                            for="donorPhone"
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
                                                id="donorPhone"
                                                name="phone"
                                                value="{{ old('phone', $user->phone) }}"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                placeholder="For example: 03001234567"
                                                autocomplete="tel"
                                            >

                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Organization Information --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                            <div class="card-header bg-white border-bottom px-4 py-3">

                                <div class="d-flex align-items-center gap-3">

                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success-subtle text-success flex-shrink-0"
                                        style="width: 46px; height: 46px;"
                                    >
                                        <i class="bi bi-building fs-5"></i>
                                    </span>

                                    <div>
                                        <h5 class="fw-semibold text-dark mb-1">
                                            Organization Information
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            Provide details about your organization and designation.
                                        </p>
                                    </div>

                                </div>

                            </div>


                            <div class="card-body p-4">

                                <div class="row g-4">

                                    {{-- Organization --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="organization"
                                            class="form-label fw-semibold"
                                        >
                                            Organization
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-building"></i>
                                            </span>

                                            <input
                                                type="text"
                                                id="organization"
                                                name="organization"
                                                value="{{ old('organization', optional($user->donorProfile)->organization) }}"
                                                class="form-control @error('organization') is-invalid @enderror"
                                                placeholder="Enter organization name"
                                            >

                                            @error('organization')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Designation --}}
                                    <div class="col-12 col-md-6">

                                        <label
                                            for="designation"
                                            class="form-label fw-semibold"
                                        >
                                            Designation
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-briefcase"></i>
                                            </span>

                                            <input
                                                type="text"
                                                id="designation"
                                                name="designation"
                                                value="{{ old('designation', optional($user->donorProfile)->designation) }}"
                                                class="form-control @error('designation') is-invalid @enderror"
                                                placeholder="Enter your designation"
                                            >

                                            @error('designation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Country --}}
                                    <div class="col-12">

                                        @php
                                            $countries = [
                                                'Afghanistan',
                                                'Albania',
                                                'Algeria',
                                                'Andorra',
                                                'Angola',
                                                'Antigua and Barbuda',
                                                'Argentina',
                                                'Armenia',
                                                'Australia',
                                                'Austria',
                                                'Azerbaijan',
                                                'Bahamas',
                                                'Bahrain',
                                                'Bangladesh',
                                                'Barbados',
                                                'Belarus',
                                                'Belgium',
                                                'Belize',
                                                'Benin',
                                                'Bhutan',
                                                'Bolivia',
                                                'Bosnia and Herzegovina',
                                                'Botswana',
                                                'Brazil',
                                                'Brunei',
                                                'Bulgaria',
                                                'Burkina Faso',
                                                'Burundi',
                                                'Cabo Verde',
                                                'Cambodia',
                                                'Cameroon',
                                                'Canada',
                                                'Central African Republic',
                                                'Chad',
                                                'Chile',
                                                'China',
                                                'Colombia',
                                                'Comoros',
                                                'Congo, Democratic Republic of the',
                                                'Congo, Republic of the',
                                                'Costa Rica',
                                                "Cote d'Ivoire",
                                                'Croatia',
                                                'Cuba',
                                                'Cyprus',
                                                'Czechia',
                                                'Denmark',
                                                'Djibouti',
                                                'Dominica',
                                                'Dominican Republic',
                                                'Ecuador',
                                                'Egypt',
                                                'El Salvador',
                                                'Equatorial Guinea',
                                                'Eritrea',
                                                'Estonia',
                                                'Eswatini',
                                                'Ethiopia',
                                                'Fiji',
                                                'Finland',
                                                'France',
                                                'Gabon',
                                                'Gambia',
                                                'Georgia',
                                                'Germany',
                                                'Ghana',
                                                'Greece',
                                                'Grenada',
                                                'Guatemala',
                                                'Guinea',
                                                'Guinea-Bissau',
                                                'Guyana',
                                                'Haiti',
                                                'Honduras',
                                                'Hungary',
                                                'Iceland',
                                                'India',
                                                'Indonesia',
                                                'Iran',
                                                'Iraq',
                                                'Ireland',
                                                'Israel',
                                                'Italy',
                                                'Jamaica',
                                                'Japan',
                                                'Jordan',
                                                'Kazakhstan',
                                                'Kenya',
                                                'Kiribati',
                                                'Kosovo',
                                                'Kuwait',
                                                'Kyrgyzstan',
                                                'Laos',
                                                'Latvia',
                                                'Lebanon',
                                                'Lesotho',
                                                'Liberia',
                                                'Libya',
                                                'Liechtenstein',
                                                'Lithuania',
                                                'Luxembourg',
                                                'Madagascar',
                                                'Malawi',
                                                'Malaysia',
                                                'Maldives',
                                                'Mali',
                                                'Malta',
                                                'Marshall Islands',
                                                'Mauritania',
                                                'Mauritius',
                                                'Mexico',
                                                'Micronesia',
                                                'Moldova',
                                                'Monaco',
                                                'Mongolia',
                                                'Montenegro',
                                                'Morocco',
                                                'Mozambique',
                                                'Myanmar',
                                                'Namibia',
                                                'Nauru',
                                                'Nepal',
                                                'Netherlands',
                                                'New Zealand',
                                                'Nicaragua',
                                                'Niger',
                                                'Nigeria',
                                                'North Korea',
                                                'North Macedonia',
                                                'Norway',
                                                'Oman',
                                                'Pakistan',
                                                'Palau',
                                                'Palestine',
                                                'Panama',
                                                'Papua New Guinea',
                                                'Paraguay',
                                                'Peru',
                                                'Philippines',
                                                'Poland',
                                                'Portugal',
                                                'Qatar',
                                                'Romania',
                                                'Russia',
                                                'Rwanda',
                                                'Saint Kitts and Nevis',
                                                'Saint Lucia',
                                                'Saint Vincent and the Grenadines',
                                                'Samoa',
                                                'San Marino',
                                                'Sao Tome and Principe',
                                                'Saudi Arabia',
                                                'Senegal',
                                                'Serbia',
                                                'Seychelles',
                                                'Sierra Leone',
                                                'Singapore',
                                                'Slovakia',
                                                'Slovenia',
                                                'Solomon Islands',
                                                'Somalia',
                                                'South Africa',
                                                'South Korea',
                                                'South Sudan',
                                                'Spain',
                                                'Sri Lanka',
                                                'Sudan',
                                                'Suriname',
                                                'Sweden',
                                                'Switzerland',
                                                'Syria',
                                                'Taiwan',
                                                'Tajikistan',
                                                'Tanzania',
                                                'Thailand',
                                                'Timor-Leste',
                                                'Togo',
                                                'Tonga',
                                                'Trinidad and Tobago',
                                                'Tunisia',
                                                'Turkey',
                                                'Turkmenistan',
                                                'Tuvalu',
                                                'Uganda',
                                                'Ukraine',
                                                'United Arab Emirates',
                                                'United Kingdom',
                                                'United States',
                                                'Uruguay',
                                                'Uzbekistan',
                                                'Vanuatu',
                                                'Vatican City',
                                                'Venezuela',
                                                'Vietnam',
                                                'Yemen',
                                                'Zambia',
                                                'Zimbabwe',
                                            ];

                                            $selectedCountry = old(
                                                'country',
                                                optional($user->donorProfile)->country
                                            );
                                        @endphp

                                        <label
                                            for="country"
                                            class="form-label fw-semibold"
                                        >
                                            Country
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-globe-asia-australia"></i>
                                            </span>

                                            <select
                                                id="country"
                                                name="country"
                                                class="form-select @error('country') is-invalid @enderror"
                                            >

                                                <option value="">
                                                    Select your country
                                                </option>

                                                @foreach ($countries as $country)
                                                    <option
                                                        value="{{ $country }}"
                                                        @selected($selectedCountry === $country)
                                                    >
                                                        {{ $country }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('country')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Address --}}
                                    <div class="col-12">

                                        <label
                                            for="address"
                                            class="form-label fw-semibold"
                                        >
                                            Address
                                        </label>

                                        <textarea
                                            name="address"
                                            id="address"
                                            rows="5"
                                            class="form-control @error('address') is-invalid @enderror"
                                            placeholder="Enter your complete address"
                                        >{{ old('address', optional($user->donorProfile)->address) }}</textarea>

                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Change Password --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                            <div class="card-header bg-white border-bottom px-4 py-3">

                                <div class="d-flex align-items-center gap-3">

                                    <span
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning-subtle text-warning-emphasis flex-shrink-0"
                                        style="width: 46px; height: 46px;"
                                    >
                                        <i class="bi bi-shield-lock fs-5"></i>
                                    </span>

                                    <div>
                                        <h5 class="fw-semibold text-dark mb-1">
                                            Change Password
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            Enter your current password first. The new password fields will unlock automatically.
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
                                                aria-label="Show or hide current password"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            @error('current_password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

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
                                                aria-label="Show or hide new password"
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
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                placeholder="Confirm your new password"
                                                autocomplete="new-password"
                                                disabled
                                            >

                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary password-toggle"
                                                data-target="passwordConfirmation"
                                                aria-label="Show or hide password confirmation"
                                                disabled
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Profile Image --}}
                    <div class="col-12 col-xl-4">

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                            <div class="card-header bg-white border-bottom px-4 py-3">

                                <h5 class="fw-semibold text-dark mb-1">
                                    Profile Image
                                </h5>

                                <p class="text-secondary small mb-0">
                                    View or replace your account photo.
                                </p>

                            </div>


                            <div class="card-body p-4">

                                {{-- Image Preview --}}
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

                                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                        Donor
                                    </span>

                                </div>


                                {{-- Image Input --}}
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
                                    Accepted formats: JPG, JPEG, PNG and WebP. Maximum file size: 200 KB.
                                </div>


                                {{-- Account Summary --}}
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
                                            Member since
                                        </span>

                                        <span class="fw-semibold small">
                                            {{ optional($user->created_at)->format('d M Y') }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between gap-3 p-3">
                                        <span class="text-secondary small">
                                            Organization
                                        </span>

                                        <span class="fw-semibold small text-end">
                                            {{ optional($user->donorProfile)->organization ?? 'Not provided' }}
                                        </span>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Form Actions --}}
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
            const profileImage = document.getElementById('profileImage');
            const profilePreview = document.getElementById('profilePreview');
            const defaultAvatar = document.getElementById('defaultAvatar');

            const currentPassword = document.getElementById('currentPassword');
            const newPassword = document.getElementById('newPassword');
            const passwordConfirmation = document.getElementById('passwordConfirmation');

            const newPasswordToggle = document.querySelector(
                '.password-toggle[data-target="newPassword"]'
            );

            const confirmationToggle = document.querySelector(
                '.password-toggle[data-target="passwordConfirmation"]'
            );

            const maxImageSize = 200 * 1024;
            const allowedImageTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];


            /* =========================================================
               IMAGE VALIDATION + PREVIEW
            ========================================================== */
            if (
                profileImage &&
                profilePreview &&
                defaultAvatar
            ) {
                profileImage.addEventListener('change', function () {
                    const selectedFile = this.files[0];

                    if (!selectedFile) {
                        return;
                    }

                    if (!allowedImageTypes.includes(selectedFile.type)) {
                        this.value = '';

                        alert(
                            'Please select a JPG, JPEG, PNG or WebP image.'
                        );

                        return;
                    }

                    if (selectedFile.size > maxImageSize) {
                        this.value = '';

                        alert(
                            'Profile image must not be larger than 200 KB.'
                        );

                        return;
                    }

                    const reader = new FileReader();

                    reader.addEventListener('load', function (event) {
                        profilePreview.src = event.target.result;
                        profilePreview.classList.remove('d-none');

                        defaultAvatar.classList.add('d-none');
                        defaultAvatar.classList.remove('d-inline-flex');
                    });

                    reader.readAsDataURL(selectedFile);
                });
            }


            /* =========================================================
               PASSWORD FIELD CONTROL
            ========================================================== */
            function syncPasswordFields() {
                if (
                    !currentPassword ||
                    !newPassword ||
                    !passwordConfirmation
                ) {
                    return;
                }

                const canChangePassword =
                    currentPassword.value.trim().length > 0;

                newPassword.disabled = !canChangePassword;
                passwordConfirmation.disabled = !canChangePassword;

                if (newPasswordToggle) {
                    newPasswordToggle.disabled = !canChangePassword;
                }

                if (confirmationToggle) {
                    confirmationToggle.disabled = !canChangePassword;
                }

                if (!canChangePassword) {
                    newPassword.value = '';
                    passwordConfirmation.value = '';

                    newPassword.type = 'password';
                    passwordConfirmation.type = 'password';

                    if (newPasswordToggle) {
                        const icon = newPasswordToggle.querySelector('i');

                        if (icon) {
                            icon.classList.remove('bi-eye-slash');
                            icon.classList.add('bi-eye');
                        }
                    }

                    if (confirmationToggle) {
                        const icon = confirmationToggle.querySelector('i');

                        if (icon) {
                            icon.classList.remove('bi-eye-slash');
                            icon.classList.add('bi-eye');
                        }
                    }
                }
            }

            if (currentPassword) {
                currentPassword.addEventListener(
                    'input',
                    syncPasswordFields
                );

                syncPasswordFields();
            }


            /* =========================================================
               SHOW / HIDE PASSWORD
            ========================================================== */
            document
                .querySelectorAll('.password-toggle')
                .forEach(function (button) {
                    button.addEventListener('click', function () {
                        if (this.disabled) {
                            return;
                        }

                        const targetId =
                            this.getAttribute('data-target');

                        const passwordField =
                            document.getElementById(targetId);

                        const icon =
                            this.querySelector('i');

                        if (!passwordField || !icon) {
                            return;
                        }

                        const isHidden =
                            passwordField.type === 'password';

                        passwordField.type =
                            isHidden ? 'text' : 'password';

                        icon.classList.toggle(
                            'bi-eye',
                            !isHidden
                        );

                        icon.classList.toggle(
                            'bi-eye-slash',
                            isHidden
                        );
                    });
                });
        });
    </script>

</body>

@include('layouts.admins.head')
<title>Edit Beneficiary Profile</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            {{-- =========================================================
                HEADER
            ========================================================== --}}

            <div class="row mb-4">

                <div class="col-md-8">

                    <h3 class="mb-1">
                        Edit Beneficiary Profile
                    </h3>

                    <p class="text-muted mb-0">
                        Update your personal, academic and beneficiary information.
                    </p>

                </div>


                <div class="col-md-4 text-md-right">

                    <a
                        href="{{ route('beneficiary.profile.index') }}"
                        class="btn btn-secondary"
                    >

                        <i class="fa fa-arrow-left mr-1"></i>

                        Back to Profile

                    </a>

                </div>

            </div>


            {{-- =========================================================
                ERRORS
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


            <form
                action="{{ route('beneficiary.profile.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                @method('PUT')


                <div class="row">


                    {{-- =================================================
                        MAIN CONTENT
                    ================================================== --}}

                    <div class="col-lg-8">


                        {{-- Account --}}

                        <div class="card mb-4">

                            <div class="card-body">

                                <h4 class="card-title mb-4">
                                    Account Information
                                </h4>


                                <div class="row">


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Full Name

                                                <span class="text-danger">*</span>
                                            </label>


                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ old('name', $user->name) }}"
                                                class="form-control"
                                                required
                                            >

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Email Address

                                                <span class="text-danger">*</span>
                                            </label>


                                            <input
                                                type="email"
                                                name="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="form-control"
                                                required
                                            >


                                            <small class="text-muted">

                                                Changing your email will require verification again.

                                            </small>

                                        </div>

                                    </div>


                                    {{-- Qalam --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Qalam ID
                                            </label>


                                            <input
                                                type="text"
                                                value="{{ $user->qalam_id }}"
                                                class="form-control"
                                                readonly
                                            >


                                            <small class="text-muted">

                                                Qalam ID cannot be changed from profile.

                                            </small>

                                        </div>

                                    </div>


                                    {{-- Phone --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Phone
                                            </label>


                                            <input
                                                type="text"
                                                name="phone"
                                                value="{{ old('phone', $profile->phone) }}"
                                                class="form-control"
                                                placeholder="+92 300 1234567"
                                            >

                                        </div>

                                    </div>


                                    {{-- Gender --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Gender
                                            </label>


                                            <select
                                                name="gender"
                                                class="form-control"
                                            >

                                                <option value="">
                                                    Select Gender
                                                </option>


                                                <option
                                                    value="male"
                                                    {{ old('gender', $profile->gender) === 'male' ? 'selected' : '' }}
                                                >
                                                    Male
                                                </option>


                                                <option
                                                    value="female"
                                                    {{ old('gender', $profile->gender) === 'female' ? 'selected' : '' }}
                                                >
                                                    Female
                                                </option>


                                                <option
                                                    value="other"
                                                    {{ old('gender', $profile->gender) === 'other' ? 'selected' : '' }}
                                                >
                                                    Other
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Academic --}}

                        <div class="card mb-4">

                            <div class="card-body">

                                <h4 class="card-title mb-4">
                                    Academic Information
                                </h4>


                                <div class="row">


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Institution
                                            </label>


                                            <input
                                                type="text"
                                                name="institution"
                                                value="{{ old('institution', $profile->institution) }}"
                                                class="form-control"
                                                placeholder="NUST School / Institution"
                                            >

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Degree
                                            </label>


                                            <select
                                                name="degree"
                                                class="form-control"
                                            >

                                                <option value="">
                                                    Select Degree Level
                                                </option>


                                                <option
                                                    value="UG"
                                                    {{ old('degree', $profile->degree) === 'UG' ? 'selected' : '' }}
                                                >
                                                    Undergraduate (UG)
                                                </option>


                                                <option
                                                    value="PG"
                                                    {{ old('degree', $profile->degree) === 'PG' ? 'selected' : '' }}
                                                >
                                                    Postgraduate (PG)
                                                </option>


                                                <option
                                                    value="PhD"
                                                    {{ old('degree', $profile->degree) === 'PhD' ? 'selected' : '' }}
                                                >
                                                    PhD
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Enrollment Year
                                            </label>


                                            <input
                                                type="number"
                                                name="enrollment_year"
                                                value="{{ old('enrollment_year', $profile->enrollment_year) }}"
                                                min="2000"
                                                max="2100"
                                                class="form-control"
                                                placeholder="2024"
                                            >

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Graduation Year
                                            </label>


                                            <input
                                                type="number"
                                                name="graduation_year"
                                                value="{{ old('graduation_year', $profile->graduation_year) }}"
                                                min="2000"
                                                max="2100"
                                                class="form-control"
                                                placeholder="2028"
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Family Financial --}}

                        <div class="card mb-4">

                            <div class="card-body">

                                <h4 class="card-title mb-4">
                                    Family & Financial Information
                                </h4>


                                <div class="row">


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Father Status
                                            </label>


                                            <select
                                                name="father_status"
                                                class="form-control"
                                            >

                                                <option value="">
                                                    Select
                                                </option>


                                                <option
                                                    value="alive"
                                                    {{ old('father_status', $profile->father_status) === 'alive' ? 'selected' : '' }}
                                                >
                                                    Alive
                                                </option>


                                                <option
                                                    value="deceased"
                                                    {{ old('father_status', $profile->father_status) === 'deceased' ? 'selected' : '' }}
                                                >
                                                    Deceased
                                                </option>


                                                <option
                                                    value="not_applicable"
                                                    {{ old('father_status', $profile->father_status) === 'not_applicable' ? 'selected' : '' }}
                                                >
                                                    Not Applicable
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Guardian Profession
                                            </label>


                                            <input
                                                type="text"
                                                name="guardian_profession"
                                                value="{{ old('guardian_profession', $profile->guardian_profession) }}"
                                                class="form-control"
                                                placeholder="Profession"
                                            >

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Monthly Household Income
                                            </label>


                                            <div class="input-group">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text">
                                                        PKR
                                                    </span>

                                                </div>


                                                <input
                                                    type="number"
                                                    name="monthly_income"
                                                    value="{{ old('monthly_income', $profile->monthly_income) }}"
                                                    class="form-control"
                                                    min="0"
                                                    step="0.01"
                                                    placeholder="50000"
                                                >

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Address --}}

                        <div class="card mb-4">

                            <div class="card-body">

                                <h4 class="card-title mb-4">
                                    Address Information
                                </h4>


                                <div class="row">


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Province / Region
                                            </label>


                                            <select
                                                name="province"
                                                class="form-control"
                                            >

                                                <option value="">
                                                    Select Province
                                                </option>


                                                @foreach([
                                                    'Punjab',
                                                    'Sindh',
                                                    'Khyber Pakhtunkhwa',
                                                    'Balochistan',
                                                    'Islamabad Capital Territory',
                                                    'Gilgit-Baltistan',
                                                    'Azad Jammu and Kashmir'
                                                ] as $province)

                                                    <option
                                                        value="{{ $province }}"
                                                        {{
                                                            old(
                                                                'province',
                                                                $profile->province
                                                            ) === $province
                                                                ? 'selected'
                                                                : ''
                                                        }}
                                                    >
                                                        {{ $province }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Domicile
                                            </label>


                                            <input
                                                type="text"
                                                name="domicile"
                                                value="{{ old('domicile', $profile->domicile) }}"
                                                class="form-control"
                                                placeholder="District / Domicile"
                                            >

                                        </div>

                                    </div>


                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                Home Address
                                            </label>


                                            <textarea
                                                name="home_address"
                                                rows="4"
                                                class="form-control"
                                                placeholder="Complete home address"
                                            >{{ old('home_address', $profile->home_address) }}</textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Submit --}}

                        <div class="card">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">

                                    <a
                                        href="{{ route('beneficiary.profile.index') }}"
                                        class="btn btn-secondary"
                                    >
                                        Cancel
                                    </a>


                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >

                                        <i class="fa fa-save mr-1"></i>

                                        Update Profile

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        PROFILE IMAGE
                    ================================================== --}}

                    <div class="col-lg-4">

                        <div class="card">

                            <div class="card-body">


                                <h4 class="card-title">
                                    Profile Image
                                </h4>


                                <div class="text-center my-4">


                                    @if($profile->profile_image)

                                        <img
                                            id="profilePreview"
                                            src="{{ asset('beneficiaries/images/profiles/'.$profile->profile_image) }}"
                                            alt="{{ $user->name }}"
                                            style="
                                                width: 160px;
                                                height: 160px;
                                                border-radius: 50%;
                                                object-fit: cover;
                                                border: 4px solid #f1f1f1;
                                            "
                                        >

                                    @else

                                        <div
                                            id="defaultAvatar"
                                            class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                            style="
                                                width: 160px;
                                                height: 160px;
                                                font-size: 55px;
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


                                        <img
                                            id="profilePreview"
                                            src=""
                                            alt="Profile Preview"
                                            style="
                                                width: 160px;
                                                height: 160px;
                                                border-radius: 50%;
                                                object-fit: cover;
                                                border: 4px solid #f1f1f1;
                                                display:none;
                                            "
                                        >

                                    @endif

                                </div>


                                <div class="form-group">

                                    <label>
                                        Change Profile Image
                                    </label>


                                    <input
                                        type="file"
                                        name="profile_image"
                                        id="profileImage"
                                        class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp"
                                    >


                                    <small class="text-muted">

                                        JPG, JPEG, PNG or WEBP.

                                        <br>

                                        Maximum 2 MB.

                                    </small>

                                </div>


                                <hr>


                                <p>

                                    <strong>
                                        Qalam ID:
                                    </strong>

                                    <br>

                                    {{ $user->qalam_id }}

                                </p>


                                <p>

                                    <strong>
                                        Account:
                                    </strong>

                                    <br>

                                    {{ $user->email }}

                                </p>


                                <p class="mb-0">

                                    <strong>
                                        Role:
                                    </strong>

                                    <br>

                                    <span class="badge badge-primary">
                                        Beneficiary
                                    </span>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>


@include('layouts.admins.script')


<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | Profile Image Preview
    |--------------------------------------------------------------------------
    */

    $('#profileImage').on(
        'change',
        function (event) {

            let file =
                event.target.files[0];


            if (!file) {
                return;
            }


            let reader =
                new FileReader();


            reader.onload =
                function (event) {

                    $('#defaultAvatar')
                        .hide();


                    $('#profilePreview')
                        .attr(
                            'src',
                            event.target.result
                        )
                        .show();

                };


            reader.readAsDataURL(
                file
            );

        }
    );

});

</script>

</body>
</html>
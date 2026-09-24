@include('layouts.admins.head')
<title>Edit Donor Profile</title>
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
                        Edit Donor Profile
                    </h3>

                    <p class="text-muted mb-0">
                        Update your account, professional and location information.
                    </p>

                </div>


                <div class="col-md-4 text-md-right">

                    <a
                        href="{{ route('donor.profile.show') }}"
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
                action="{{ route('donor.profile.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                @method('PUT')


                <div class="row">


                    {{-- =================================================
                        MAIN FORM
                    ================================================== --}}

                    <div class="col-lg-8">


                        {{-- Account Information --}}

                        <div class="card mb-4">

                            <div class="card-body">

                                <h4 class="card-title mb-4">
                                    Account Information
                                </h4>


                                <div class="row">


                                    {{-- Name --}}

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


                                    {{-- Email --}}

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

                                                Changing your email will require email verification again.

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

                                </div>

                            </div>

                        </div>


                        {{-- Professional Information --}}

                        <div class="card mb-4">

                            <div class="card-body">

                                <h4 class="card-title mb-4">
                                    Professional Information
                                </h4>


                                <div class="row">


                                    {{-- Organization --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Organization
                                            </label>


                                            <input
                                                type="text"
                                                name="organization"
                                                value="{{ old('organization', $profile->organization) }}"
                                                class="form-control"
                                                placeholder="Organization / Company"
                                            >

                                        </div>

                                    </div>


                                    {{-- Designation --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Designation
                                            </label>


                                            <input
                                                type="text"
                                                name="designation"
                                                value="{{ old('designation', $profile->designation) }}"
                                                class="form-control"
                                                placeholder="Your designation"
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Location --}}

                        <div class="card mb-4">

                            <div class="card-body">

                                <h4 class="card-title mb-4">
                                    Location Information
                                </h4>


                                <div class="row">


                                    {{-- Country Selection --}}

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                Country
                                                <span class="text-danger">*</span>
                                            </label>


                                            <select
                                                name="country_type"
                                                id="countryType"
                                                class="form-control"
                                                required
                                            >

                                                <option value="">
                                                    Select Country Type
                                                </option>


                                                <option
                                                    value="pakistan"
                                                    {{
                                                        old(
                                                            'country_type',
                                                            $profile->country === 'Pakistan'
                                                                ? 'pakistan'
                                                                : ''
                                                        ) === 'pakistan'
                                                            ? 'selected'
                                                            : ''
                                                    }}
                                                >
                                                    Pakistan
                                                </option>


                                                <option
                                                    value="other"
                                                    {{
                                                        old(
                                                            'country_type',
                                                            $profile->country &&
                                                            $profile->country !== 'Pakistan'
                                                                ? 'other'
                                                                : ''
                                                        ) === 'other'
                                                            ? 'selected'
                                                            : ''
                                                    }}
                                                >
                                                    Other Country
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                    {{-- ==========================================
                                        PAKISTAN FIELDS
                                    =========================================== --}}

                                    <div
                                        class="col-md-12"
                                        id="pakistanFields"
                                        style="display:none;"
                                    >

                                        <div class="row">


                                            {{-- Province --}}

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label>
                                                        Province / Region
                                                    </label>


                                                    <select
                                                        name="pakistan_state"
                                                        id="pakistanState"
                                                        class="form-control"
                                                    >

                                                        <option value="">
                                                            Select Province / Region
                                                        </option>


                                                        <option
                                                            value="Punjab"
                                                            {{ old('pakistan_state', $profile->state) === 'Punjab' ? 'selected' : '' }}
                                                        >
                                                            Punjab
                                                        </option>


                                                        <option
                                                            value="Sindh"
                                                            {{ old('pakistan_state', $profile->state) === 'Sindh' ? 'selected' : '' }}
                                                        >
                                                            Sindh
                                                        </option>


                                                        <option
                                                            value="Khyber Pakhtunkhwa"
                                                            {{ old('pakistan_state', $profile->state) === 'Khyber Pakhtunkhwa' ? 'selected' : '' }}
                                                        >
                                                            Khyber Pakhtunkhwa
                                                        </option>


                                                        <option
                                                            value="Balochistan"
                                                            {{ old('pakistan_state', $profile->state) === 'Balochistan' ? 'selected' : '' }}
                                                        >
                                                            Balochistan
                                                        </option>


                                                        <option
                                                            value="Islamabad Capital Territory"
                                                            {{ old('pakistan_state', $profile->state) === 'Islamabad Capital Territory' ? 'selected' : '' }}
                                                        >
                                                            Islamabad Capital Territory
                                                        </option>


                                                        <option
                                                            value="Gilgit-Baltistan"
                                                            {{ old('pakistan_state', $profile->state) === 'Gilgit-Baltistan' ? 'selected' : '' }}
                                                        >
                                                            Gilgit-Baltistan
                                                        </option>


                                                        <option
                                                            value="Azad Jammu and Kashmir"
                                                            {{ old('pakistan_state', $profile->state) === 'Azad Jammu and Kashmir' ? 'selected' : '' }}
                                                        >
                                                            Azad Jammu and Kashmir
                                                        </option>

                                                    </select>

                                                </div>

                                            </div>


                                            {{-- City --}}

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label>
                                                        City
                                                    </label>


                                                    <select
                                                        name="pakistan_city"
                                                        id="pakistanCity"
                                                        class="form-control"
                                                        data-current="{{ old('pakistan_city', $profile->city) }}"
                                                    >

                                                        <option value="">
                                                            Select City
                                                        </option>

                                                    </select>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- ==========================================
                                        OTHER COUNTRY FIELDS
                                    =========================================== --}}

                                    <div
                                        class="col-md-12"
                                        id="otherCountryFields"
                                        style="display:none;"
                                    >

                                        <div class="row">


                                            <div class="col-md-4">

                                                <div class="form-group">

                                                    <label>
                                                        Country
                                                    </label>


                                                    <input
                                                        type="text"
                                                        name="manual_country"
                                                        id="manualCountry"
                                                        value="{{
                                                            old(
                                                                'manual_country',
                                                                $profile->country !== 'Pakistan'
                                                                    ? $profile->country
                                                                    : ''
                                                            )
                                                        }}"
                                                        class="form-control"
                                                        placeholder="Enter country"
                                                    >

                                                </div>

                                            </div>


                                            <div class="col-md-4">

                                                <div class="form-group">

                                                    <label>
                                                        State / Province
                                                    </label>


                                                    <input
                                                        type="text"
                                                        name="manual_state"
                                                        id="manualState"
                                                        value="{{
                                                            old(
                                                                'manual_state',
                                                                $profile->country !== 'Pakistan'
                                                                    ? $profile->state
                                                                    : ''
                                                            )
                                                        }}"
                                                        class="form-control"
                                                        placeholder="Enter state / province"
                                                    >

                                                </div>

                                            </div>


                                            <div class="col-md-4">

                                                <div class="form-group">

                                                    <label>
                                                        City
                                                    </label>


                                                    <input
                                                        type="text"
                                                        name="manual_city"
                                                        id="manualCity"
                                                        value="{{
                                                            old(
                                                                'manual_city',
                                                                $profile->country !== 'Pakistan'
                                                                    ? $profile->city
                                                                    : ''
                                                            )
                                                        }}"
                                                        class="form-control"
                                                        placeholder="Enter city"
                                                    >

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Submit --}}

                        <div class="card">

                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between"
                                >

                                    <a
                                        href="{{ route('donor.profile.show') }}"
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


                                <div class="text-center mb-4">


                                    @if($profile->profile_image)

                                        <img
                                            id="profilePreview"
                                            src="{{ asset('donors/images/profiles/'.$profile->profile_image) }}"
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

                                        Maximum size: 2 MB.

                                    </small>

                                </div>


                                <hr>


                                <small class="text-muted">

                                    <strong>
                                        Account:
                                    </strong>

                                    {{ $user->email }}

                                    <br><br>


                                    <strong>
                                        Role:
                                    </strong>

                                    Donor

                                </small>

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
    | Pakistan Cities
    |--------------------------------------------------------------------------
    */

    const pakistanCities = {

        'Punjab': [
            'Lahore',
            'Rawalpindi',
            'Faisalabad',
            'Multan',
            'Gujranwala',
            'Sialkot',
            'Bahawalpur',
            'Sargodha',
            'Gujrat',
            'Sheikhupura',
            'Jhelum',
            'Sahiwal',
            'Rahim Yar Khan',
            'Dera Ghazi Khan',
            'Murree'
        ],

        'Sindh': [
            'Karachi',
            'Hyderabad',
            'Sukkur',
            'Larkana',
            'Mirpur Khas',
            'Nawabshah',
            'Thatta',
            'Jacobabad'
        ],

        'Khyber Pakhtunkhwa': [
            'Peshawar',
            'Abbottabad',
            'Mardan',
            'Swat',
            'Mingora',
            'Nowshera',
            'Mansehra',
            'Kohat',
            'Bannu',
            'Dera Ismail Khan',
            'Haripur'
        ],

        'Balochistan': [
            'Quetta',
            'Gwadar',
            'Turbat',
            'Khuzdar',
            'Chaman',
            'Sibi',
            'Zhob'
        ],

        'Islamabad Capital Territory': [
            'Islamabad'
        ],

        'Gilgit-Baltistan': [
            'Gilgit',
            'Skardu',
            'Hunza',
            'Chilas'
        ],

        'Azad Jammu and Kashmir': [
            'Muzaffarabad',
            'Mirpur',
            'Rawalakot',
            'Kotli',
            'Bagh'
        ]

    };


    /*
    |--------------------------------------------------------------------------
    | Country Type
    |--------------------------------------------------------------------------
    */

    function updateCountryFields()
    {
        let countryType =
            $('#countryType').val();


        if (countryType === 'pakistan') {

            $('#pakistanFields')
                .show();


            $('#otherCountryFields')
                .hide();


            $('#pakistanState')
                .prop(
                    'required',
                    true
                );


            $('#pakistanCity')
                .prop(
                    'required',
                    true
                );


            $('#manualCountry')
                .prop(
                    'required',
                    false
                );


            $('#manualState')
                .prop(
                    'required',
                    false
                );


            $('#manualCity')
                .prop(
                    'required',
                    false
                );

        } else if (countryType === 'other') {

            $('#pakistanFields')
                .hide();


            $('#otherCountryFields')
                .show();


            $('#pakistanState')
                .prop(
                    'required',
                    false
                );


            $('#pakistanCity')
                .prop(
                    'required',
                    false
                );


            $('#manualCountry')
                .prop(
                    'required',
                    true
                );


            $('#manualState')
                .prop(
                    'required',
                    true
                );


            $('#manualCity')
                .prop(
                    'required',
                    true
                );

        } else {

            $('#pakistanFields')
                .hide();


            $('#otherCountryFields')
                .hide();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Load Pakistan Cities
    |--------------------------------------------------------------------------
    */

    function loadPakistanCities()
    {
        let state =
            $('#pakistanState').val();


        let currentCity =
            $('#pakistanCity')
                .data('current');


        $('#pakistanCity')
            .html(
                '<option value="">Select City</option>'
            );


        if (
            state &&
            pakistanCities[state]
        ) {

            pakistanCities[state]
                .forEach(
                    function (city) {

                        let selected =
                            city === currentCity
                                ? 'selected'
                                : '';


                        $('#pakistanCity')
                            .append(
                                '<option value="'
                                + city
                                + '" '
                                + selected
                                + '>'
                                + city
                                + '</option>'
                            );
                    }
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Country Change
    |--------------------------------------------------------------------------
    */

    $('#countryType').on(
        'change',
        function () {

            updateCountryFields();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Province Change
    |--------------------------------------------------------------------------
    */

    $('#pakistanState').on(
        'change',
        function () {

            $('#pakistanCity')
                .data(
                    'current',
                    ''
                );


            loadPakistanCities();

        }
    );


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


    /*
    |--------------------------------------------------------------------------
    | Initial
    |--------------------------------------------------------------------------
    */

    updateCountryFields();

    loadPakistanCities();

});

</script>

</body>
</html>
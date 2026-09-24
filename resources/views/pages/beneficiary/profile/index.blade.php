@include('layouts.admins.head')
<title>My Profile</title>
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
                        My Profile
                    </h3>

                    <p class="text-muted mb-0">
                        View your personal, academic and beneficiary information.
                    </p>

                </div>


                <div class="col-md-4 text-md-right">

                    <a
                        href="{{ route('beneficiary.profile.edit') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa fa-edit mr-1"></i>

                        Edit Profile

                    </a>

                </div>

            </div>


            {{-- =========================================================
                SUCCESS
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


            <div class="row">


                {{-- =====================================================
                    PROFILE CARD
                ====================================================== --}}

                <div class="col-lg-4">

                    <div class="card">

                        <div class="card-body text-center">


                            {{-- Image --}}

                            @if($profile->profile_image)

                                <img
                                    src="{{ asset('beneficiaries/images/profiles/'.$profile->profile_image) }}"
                                    alt="{{ $user->name }}"
                                    style="
                                        width: 140px;
                                        height: 140px;
                                        border-radius: 50%;
                                        object-fit: cover;
                                        border: 4px solid #f1f1f1;
                                    "
                                >

                            @else

                                <div
                                    class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                    style="
                                        width: 140px;
                                        height: 140px;
                                        font-size: 50px;
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

                            @endif


                            <h4 class="mt-3 mb-1">

                                {{ $user->name }}

                            </h4>


                            <p class="text-muted mb-2">

                                {{ $user->email }}

                            </p>


                            <span class="badge badge-primary">
                                Beneficiary
                            </span>


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


                            <hr>


                            <p class="mb-1">

                                <strong>
                                    Qalam ID
                                </strong>

                            </p>


                            <p class="text-muted">

                                {{ $user->qalam_id ?? 'Not Available' }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    DETAILS
                ====================================================== --}}

                <div class="col-lg-8">


                    {{-- Personal Information --}}

                    <div class="card mb-4">

                        <div class="card-body">

                            <h4 class="card-title mb-4">
                                Personal Information
                            </h4>


                            <div class="table-responsive">

                                <table class="table table-bordered">

                                    <tr>

                                        <th width="35%">
                                            Full Name
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

                                            {{ $user->qalam_id ?? 'Not Available' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Phone
                                        </th>

                                        <td>

                                            {{ $profile->phone ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Gender
                                        </th>

                                        <td>

                                            {{ $profile->gender ? ucfirst($profile->gender) : 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Email Verification
                                        </th>

                                        <td>

                                            @if($user->email_verified_at)

                                                <span class="badge badge-success">
                                                    Verified
                                                </span>

                                            @else

                                                <span class="badge badge-warning">
                                                    Pending
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                </table>

                            </div>

                        </div>

                    </div>


                    {{-- Academic Information --}}

                    <div class="card mb-4">

                        <div class="card-body">

                            <h4 class="card-title mb-4">
                                Academic Information
                            </h4>


                            <div class="table-responsive">

                                <table class="table table-bordered">


                                    <tr>

                                        <th width="35%">
                                            Institution
                                        </th>

                                        <td>

                                            {{ $profile->institution ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Degree
                                        </th>

                                        <td>

                                            {{ $profile->degree ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Enrollment Year
                                        </th>

                                        <td>

                                            {{ $profile->enrollment_year ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Graduation Year
                                        </th>

                                        <td>

                                            {{ $profile->graduation_year ?? 'Not Provided' }}

                                        </td>

                                    </tr>

                                </table>

                            </div>

                        </div>

                    </div>


                    {{-- Family Financial --}}

                    <div class="card mb-4">

                        <div class="card-body">

                            <h4 class="card-title mb-4">
                                Family & Financial Information
                            </h4>


                            <div class="table-responsive">

                                <table class="table table-bordered">


                                    <tr>

                                        <th width="35%">
                                            Father Status
                                        </th>

                                        <td>

                                            @if($profile->father_status)

                                                {{ ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $profile->father_status
                                                    )
                                                ) }}

                                            @else

                                                Not Provided

                                            @endif

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Guardian Profession
                                        </th>

                                        <td>

                                            {{ $profile->guardian_profession ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Monthly Income
                                        </th>

                                        <td>

                                            @if($profile->monthly_income !== null)

                                                PKR

                                                {{ number_format(
                                                    (float) $profile->monthly_income,
                                                    0
                                                ) }}

                                            @else

                                                Not Provided

                                            @endif

                                        </td>

                                    </tr>

                                </table>

                            </div>

                        </div>

                    </div>


                    {{-- Address --}}

                    <div class="card">

                        <div class="card-body">

                            <h4 class="card-title mb-4">
                                Address Information
                            </h4>


                            <div class="table-responsive">

                                <table class="table table-bordered">


                                    <tr>

                                        <th width="35%">
                                            Province / Region
                                        </th>

                                        <td>

                                            {{ $profile->province ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Domicile
                                        </th>

                                        <td>

                                            {{ $profile->domicile ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Home Address
                                        </th>

                                        <td>

                                            {{ $profile->home_address ?? 'Not Provided' }}

                                        </td>

                                    </tr>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.admins.script')

</body>
</html>
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
                        Manage your personal and professional information.
                    </p>

                </div>


                <div class="col-md-4 text-md-right">

                    <a
                        href="{{ route('donor.profile.edit') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa fa-edit mr-1"></i>

                        Edit Profile

                    </a>

                </div>

            </div>


            {{-- =========================================================
                MESSAGE
            ========================================================== --}}

            @if(session('success'))

                <div class="alert alert-success">

                    <i class="fa fa-check-circle mr-1"></i>

                    {{ session('success') }}

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
                                    src="{{ asset('donors/images/profiles/'.$profile->profile_image) }}"
                                    alt="{{ $user->name }}"
                                    style="
                                        width: 130px;
                                        height: 130px;
                                        border-radius: 50%;
                                        object-fit: cover;
                                        border: 4px solid #f1f1f1;
                                    "
                                >

                            @else

                                <div
                                    class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                    style="
                                        width: 130px;
                                        height: 130px;
                                        font-size: 48px;
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
                                Donor
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

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    PROFILE DETAILS
                ====================================================== --}}

                <div class="col-lg-8">

                    <div class="card">

                        <div class="card-body">


                            <h4 class="card-title mb-4">
                                Profile Information
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
                                            Phone
                                        </th>

                                        <td>

                                            {{ $profile->phone ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Organization
                                        </th>

                                        <td>

                                            {{ $profile->organization ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Designation
                                        </th>

                                        <td>

                                            {{ $profile->designation ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            Country
                                        </th>

                                        <td>

                                            {{ $profile->country ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            State / Province
                                        </th>

                                        <td>

                                            {{ $profile->state ?? 'Not Provided' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <th>
                                            City
                                        </th>

                                        <td>

                                            {{ $profile->city ?? 'Not Provided' }}

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


                                    <tr>

                                        <th>
                                            Member Since
                                        </th>

                                        <td>

                                            {{ $user->created_at?->format('d M Y') }}

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
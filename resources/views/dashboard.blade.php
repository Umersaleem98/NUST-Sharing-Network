@include('layouts.admins.head')
    <title>Sharing Network Admin Dashboard</title>
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

                <div class="col-md-8">

                    <h3 class="mb-1">
                        Dashboard
                    </h3>


                    <p class="text-muted mb-0">

                        Welcome back,

                        <strong>
                            {{ $user->name }}
                        </strong>

                    </p>

                </div>


                <div class="col-md-4 text-md-right">

                    <span class="badge badge-primary p-2">

                        {{ ucfirst($user->role) }}

                    </span>


                    @if($user->profile_status === 'active')

                        <span class="badge badge-success p-2">
                            Active
                        </span>

                    @elseif($user->profile_status === 'suspended')

                        <span class="badge badge-warning p-2">
                            Suspended
                        </span>

                    @else

                        <span class="badge badge-danger p-2">
                            Blocked
                        </span>

                    @endif

                </div>

            </div>



            {{-- =========================================================
                ADMIN DASHBOARD
            ========================================================== --}}

            @if($role === 'admin')


                {{-- =====================================================
                    MAIN COUNTERS
                ====================================================== --}}

                <div class="row">


                    <div class="col-xl-3 col-lg-3 col-sm-6">

                        <div class="card gradient-1">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    Total Users
                                </h3>


                                <div class="d-inline-block">

                                    <h2 class="text-white">
                                        {{ $totalUsers }}
                                    </h2>


                                    <p class="text-white mb-0">

                                        {{ $totalDonors }} Donors /
                                        {{ $totalBeneficiaries }} Beneficiaries

                                    </p>

                                </div>


                                <span class="float-right display-5 opacity-5">

                                    <i class="fa fa-users"></i>

                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-3 col-lg-3 col-sm-6">

                        <div class="card gradient-2">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    Products
                                </h3>


                                <div class="d-inline-block">

                                    <h2 class="text-white">
                                        {{ $totalProducts }}
                                    </h2>


                                    <p class="text-white mb-0">

                                        {{ $activeProducts }} Active /
                                        {{ $inactiveProducts }} Inactive

                                    </p>

                                </div>


                                <span class="float-right display-5 opacity-5">

                                    <i class="fa fa-cubes"></i>

                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-3 col-lg-3 col-sm-6">

                        <div class="card gradient-3">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    Categories
                                </h3>


                                <div class="d-inline-block">

                                    <h2 class="text-white">
                                        {{ $totalCategories }}
                                    </h2>


                                    <p class="text-white mb-0">

                                        {{ $activeCategories }} Active /
                                        {{ $inactiveCategories }} Inactive

                                    </p>

                                </div>


                                <span class="float-right display-5 opacity-5">

                                    <i class="fa fa-list"></i>

                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-3 col-lg-3 col-sm-6">

                        <div class="card gradient-4">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    Requests
                                </h3>


                                <div class="d-inline-block">

                                    <h2 class="text-white">
                                        {{ $totalRequests }}
                                    </h2>


                                    <p class="text-white mb-0">

                                        {{ $pendingAdminRequests }} Pending Review

                                    </p>

                                </div>


                                <span class="float-right display-5 opacity-5">

                                    <i class="fa fa-paper-plane"></i>

                                </span>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    USER ROLE BREAKDOWN
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-4 col-md-6">

                        <div class="card">

                            <div class="card-body">

                                <h5 class="text-muted">
                                    Administrators
                                </h5>

                                <h2>
                                    {{ $totalAdmins }}
                                </h2>

                                <span class="text-muted">
                                    System administrators
                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-4 col-md-6">

                        <div class="card">

                            <div class="card-body">

                                <h5 class="text-muted">
                                    Donors
                                </h5>

                                <h2>
                                    {{ $totalDonors }}
                                </h2>

                                <span class="text-muted">
                                    Registered donors
                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-4 col-md-6">

                        <div class="card">

                            <div class="card-body">

                                <h5 class="text-muted">
                                    Beneficiaries
                                </h5>

                                <h2>
                                    {{ $totalBeneficiaries }}
                                </h2>

                                <span class="text-muted">
                                    Registered beneficiaries
                                </span>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    USER PROFILE STATUS
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-4 col-md-6">

                        <div class="card">

                            <div class="card-body">

                                <h5 class="text-success">
                                    Active Accounts
                                </h5>

                                <h2>
                                    {{ $activeProfiles }}
                                </h2>

                                <div class="progress" style="height:7px;">

                                    <div
                                        class="progress-bar bg-success"
                                        style="width:{{
                                            $totalUsers > 0
                                                ? ($activeProfiles / $totalUsers) * 100
                                                : 0
                                        }}%"
                                    ></div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-4 col-md-6">

                        <div class="card">

                            <div class="card-body">

                                <h5 class="text-warning">
                                    Suspended Accounts
                                </h5>

                                <h2>
                                    {{ $suspendedProfiles }}
                                </h2>

                                <div class="progress" style="height:7px;">

                                    <div
                                        class="progress-bar bg-warning"
                                        style="width:{{
                                            $totalUsers > 0
                                                ? ($suspendedProfiles / $totalUsers) * 100
                                                : 0
                                        }}%"
                                    ></div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-4 col-md-6">

                        <div class="card">

                            <div class="card-body">

                                <h5 class="text-danger">
                                    Blocked Accounts
                                </h5>

                                <h2>
                                    {{ $blockedProfiles }}
                                </h2>

                                <div class="progress" style="height:7px;">

                                    <div
                                        class="progress-bar bg-danger"
                                        style="width:{{
                                            $totalUsers > 0
                                                ? ($blockedProfiles / $totalUsers) * 100
                                                : 0
                                        }}%"
                                    ></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    PROFILE INFORMATION
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-6">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">
                                    Profile Overview
                                </h4>


                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <thead>

                                        <tr>

                                            <th>
                                                Profile
                                            </th>

                                            <th>
                                                Created
                                            </th>

                                            <th>
                                                Missing
                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>

                                        <tr>

                                            <td>
                                                Donor Profiles
                                            </td>

                                            <td>
                                                {{ $donorProfiles }}
                                            </td>

                                            <td>

                                                <span class="badge badge-warning">

                                                    {{ $donorsWithoutProfile }}

                                                </span>

                                            </td>

                                        </tr>


                                        <tr>

                                            <td>
                                                Beneficiary Profiles
                                            </td>

                                            <td>
                                                {{ $beneficiaryProfiles }}
                                            </td>

                                            <td>

                                                <span class="badge badge-warning">

                                                    {{ $beneficiariesWithoutProfile }}

                                                </span>

                                            </td>

                                        </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- Product Creator --}}

                    <div class="col-lg-6">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">
                                    Product Ownership
                                </h4>


                                <div class="row text-center">


                                    <div class="col-6 border-right">

                                        <h2>
                                            {{ $donorProducts }}
                                        </h2>

                                        <p class="mb-0 text-muted">
                                            Donor Products
                                        </p>

                                    </div>


                                    <div class="col-6">

                                        <h2>
                                            {{ $adminProducts }}
                                        </h2>

                                        <p class="mb-0 text-muted">
                                            Admin Products
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    ADMIN REQUEST STATUS
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-6">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">
                                    Admin Request Review
                                </h4>


                                <div class="row text-center">


                                    <div class="col-md-4">

                                        <h3 class="text-warning">
                                            {{ $pendingAdminRequests }}
                                        </h3>

                                        <small>
                                            Pending
                                        </small>

                                    </div>


                                    <div class="col-md-4">

                                        <h3 class="text-success">
                                            {{ $approvedAdminRequests }}
                                        </h3>

                                        <small>
                                            Approved
                                        </small>

                                    </div>


                                    <div class="col-md-4">

                                        <h3 class="text-danger">
                                            {{ $rejectedAdminRequests }}
                                        </h3>

                                        <small>
                                            Rejected
                                        </small>

                                    </div>

                                </div>


                                <div class="mt-4 text-center">

                                    <a
                                        href="{{ route('admin.product.requests.index') }}"
                                        class="btn btn-primary"
                                    >
                                        Manage Requests
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- Donor Decisions --}}

                    <div class="col-lg-6">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">
                                    Donor Request Decisions
                                </h4>


                                <div class="row text-center">


                                    <div class="col-md-4">

                                        <h3 class="text-warning">

                                            {{ $pendingDonorRequests }}

                                        </h3>

                                        <small>
                                            Waiting Donor
                                        </small>

                                    </div>


                                    <div class="col-md-4">

                                        <h3 class="text-success">

                                            {{ $acceptedDonorRequests }}

                                        </h3>

                                        <small>
                                            Accepted
                                        </small>

                                    </div>


                                    <div class="col-md-4">

                                        <h3 class="text-danger">

                                            {{ $rejectedDonorRequests }}

                                        </h3>

                                        <small>
                                            Rejected
                                        </small>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    STUDENTS / BENEFICIARIES INSTITUTION WISE
                ====================================================== --}}

                <div class="row">

                    <div class="col-lg-6">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title mb-1">
                                    Beneficiaries Institution Wise
                                </h4>

                                <p class="text-muted">
                                    Distribution of beneficiary profiles by institution.
                                </p>


                                @php

                                    $maximumInstitutionCount =
                                        max(
                                            1,
                                            (int) $institutionWise->max('total')
                                        );

                                @endphp


                                @forelse($institutionWise as $institution)

                                    @php

                                        $institutionPercentage =
                                            (
                                                $institution->total /
                                                $maximumInstitutionCount
                                            ) * 100;

                                    @endphp


                                    <div class="mb-4">

                                        <div
                                            class="d-flex justify-content-between mb-1"
                                        >

                                            <strong>

                                                {{
                                                    $institution->institution
                                                        ?: 'Not Provided'
                                                }}

                                            </strong>


                                            <span>

                                                {{ $institution->total }}

                                            </span>

                                        </div>


                                        <div
                                            class="progress"
                                            style="height:7px;"
                                        >

                                            <div
                                                class="progress-bar bg-primary"
                                                style="width:{{ $institutionPercentage }}%"
                                            ></div>

                                        </div>

                                    </div>


                                @empty

                                    <p class="text-muted">
                                        No institution information available.
                                    </p>

                                @endforelse

                            </div>

                        </div>

                    </div>



                    {{-- =================================================
                        PRODUCT CATEGORY WISE
                    ================================================== --}}

                    <div class="col-lg-6">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title mb-1">
                                    Products Category Wise
                                </h4>

                                <p class="text-muted">
                                    Product distribution across categories.
                                </p>


                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <thead>

                                        <tr>

                                            <th>
                                                Category
                                            </th>

                                            <th>
                                                Total
                                            </th>

                                            <th>
                                                Active
                                            </th>

                                            <th>
                                                Inactive
                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>

                                        @forelse($categoryProductStats as $category)

                                            <tr>

                                                <td>

                                                    {{ $category->name }}

                                                </td>

                                                <td>

                                                    <strong>

                                                        {{ $category->products_count }}

                                                    </strong>

                                                </td>

                                                <td>

                                                    <span class="badge badge-success">

                                                        {{ $category->active_products_count }}

                                                    </span>

                                                </td>

                                                <td>

                                                    <span class="badge badge-secondary">

                                                        {{ $category->inactive_products_count }}

                                                    </span>

                                                </td>

                                            </tr>


                                        @empty

                                            <tr>

                                                <td
                                                    colspan="4"
                                                    class="text-center"
                                                >
                                                    No categories available.
                                                </td>

                                            </tr>

                                        @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    LATEST USERS
                ====================================================== --}}

                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">

                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between align-items-center mb-3"
                                >

                                    <h4 class="card-title mb-0">
                                        Latest Users
                                    </h4>


                                    <a
                                        href="{{ route('admin.users.index') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        View All
                                    </a>

                                </div>


                                <div class="table-responsive">

                                    <table class="table table-hover">

                                        <thead>

                                        <tr>

                                            <th>
                                                Name
                                            </th>

                                            <th>
                                                Email
                                            </th>

                                            <th>
                                                Role
                                            </th>

                                            <th>
                                                Qalam ID
                                            </th>

                                            <th>
                                                Profile Status
                                            </th>

                                            <th>
                                                Joined
                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>

                                        @forelse($latestUsers as $latestUser)

                                            <tr>

                                                <td>

                                                    <strong>
                                                        {{ $latestUser->name }}
                                                    </strong>

                                                </td>

                                                <td>

                                                    {{ $latestUser->email }}

                                                </td>

                                                <td>

                                                    <span class="badge badge-primary">

                                                        {{ ucfirst($latestUser->role) }}

                                                    </span>

                                                </td>

                                                <td>

                                                    {{ $latestUser->qalam_id ?? '—' }}

                                                </td>

                                                <td>

                                                    @if($latestUser->profile_status === 'active')

                                                        <span class="badge badge-success">
                                                            Active
                                                        </span>

                                                    @elseif($latestUser->profile_status === 'suspended')

                                                        <span class="badge badge-warning">
                                                            Suspended
                                                        </span>

                                                    @else

                                                        <span class="badge badge-danger">
                                                            Blocked
                                                        </span>

                                                    @endif

                                                </td>

                                                <td>

                                                    {{ $latestUser->created_at?->format('d M Y') }}

                                                </td>

                                            </tr>


                                        @empty

                                            <tr>

                                                <td
                                                    colspan="6"
                                                    class="text-center"
                                                >
                                                    No users available.
                                                </td>

                                            </tr>

                                        @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    LATEST PRODUCTS
                ====================================================== --}}

                <div class="row">

                    <div class="col-lg-6">

                        <div class="card">

                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between mb-3"
                                >

                                    <h4 class="card-title mb-0">
                                        Latest Products
                                    </h4>


                                    <a
                                        href="{{ route('admin.products.index') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        View All
                                    </a>

                                </div>


                                <div class="table-responsive">

                                    <table class="table table-hover">

                                        <thead>

                                        <tr>

                                            <th>
                                                Product
                                            </th>

                                            <th>
                                                Category
                                            </th>

                                            <th>
                                                Creator
                                            </th>

                                            <th>
                                                Status
                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>

                                        @forelse($latestProducts as $product)

                                            <tr>

                                                <td>

                                                    <strong>

                                                        {{ $product->name }}

                                                    </strong>

                                                </td>

                                                <td>

                                                    {{ $product->category?->name ?? 'N/A' }}

                                                </td>

                                                <td>

                                                    {{ $product->creator?->name ?? 'N/A' }}

                                                </td>

                                                <td>

                                                    @if($product->status === 'active')

                                                        <span class="badge badge-success">
                                                            Active
                                                        </span>

                                                    @else

                                                        <span class="badge badge-secondary">
                                                            Inactive
                                                        </span>

                                                    @endif

                                                </td>

                                            </tr>


                                        @empty

                                            <tr>

                                                <td
                                                    colspan="4"
                                                    class="text-center"
                                                >
                                                    No products available.
                                                </td>

                                            </tr>

                                        @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- Latest Requests --}}

                    <div class="col-lg-6">

                        <div class="card">

                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between mb-3"
                                >

                                    <h4 class="card-title mb-0">
                                        Latest Requests
                                    </h4>


                                    <a
                                        href="{{ route('admin.product.requests.index') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        View All
                                    </a>

                                </div>


                                <div class="table-responsive">

                                    <table class="table table-hover">

                                        <thead>

                                        <tr>

                                            <th>
                                                Product
                                            </th>

                                            <th>
                                                Beneficiary
                                            </th>

                                            <th>
                                                Admin
                                            </th>

                                            <th>
                                                Donor
                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>

                                        @forelse($latestRequests as $productRequest)

                                            <tr>

                                                <td>

                                                    {{ $productRequest->product?->name ?? 'N/A' }}

                                                </td>


                                                <td>

                                                    {{ $productRequest->beneficiary?->name ?? 'N/A' }}

                                                </td>


                                                <td>

                                                    @if($productRequest->admin_status === 'approved')

                                                        <span class="badge badge-success">
                                                            Approved
                                                        </span>

                                                    @elseif($productRequest->admin_status === 'rejected')

                                                        <span class="badge badge-danger">
                                                            Rejected
                                                        </span>

                                                    @else

                                                        <span class="badge badge-warning">
                                                            Pending
                                                        </span>

                                                    @endif

                                                </td>


                                                <td>

                                                    @if(!$productRequest->donor_id)

                                                        <span class="badge badge-secondary">
                                                            N/A
                                                        </span>

                                                    @elseif($productRequest->admin_status !== 'approved')

                                                        <span class="badge badge-secondary">
                                                            Awaiting Admin
                                                        </span>

                                                    @elseif($productRequest->donor_status === 'accepted')

                                                        <span class="badge badge-success">
                                                            Accepted
                                                        </span>

                                                    @elseif($productRequest->donor_status === 'rejected')

                                                        <span class="badge badge-danger">
                                                            Rejected
                                                        </span>

                                                    @else

                                                        <span class="badge badge-warning">
                                                            Pending
                                                        </span>

                                                    @endif

                                                </td>

                                            </tr>


                                        @empty

                                            <tr>

                                                <td
                                                    colspan="4"
                                                    class="text-center"
                                                >
                                                    No requests available.
                                                </td>

                                            </tr>

                                        @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



            {{-- =========================================================
                DONOR DASHBOARD
            ========================================================== --}}

            @elseif($role === 'donor')


                {{-- =====================================================
                    COUNTERS
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-3 col-sm-6">

                        <div class="card gradient-1">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    My Products
                                </h3>

                                <h2 class="text-white">
                                    {{ $myProducts }}
                                </h2>

                                <p class="text-white mb-0">

                                    {{ $myActiveProducts }}
                                    Active

                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-sm-6">

                        <div class="card gradient-2">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    Approved Requests
                                </h3>

                                <h2 class="text-white">

                                    {{ $myTotalRequests }}

                                </h2>

                                <p class="text-white mb-0">
                                    Admin approved only
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-sm-6">

                        <div class="card gradient-3">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    Pending Decision
                                </h3>

                                <h2 class="text-white">

                                    {{ $myPendingRequests }}

                                </h2>

                                <p class="text-white mb-0">
                                    Waiting for you
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-sm-6">

                        <div class="card gradient-4">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    Profile
                                </h3>

                                <h2 class="text-white">

                                    {{ $profileCompletion }}%

                                </h2>

                                <p class="text-white mb-0">
                                    Profile completion
                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    PROFILE
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-4">

                        <div class="card">

                            <div class="card-body text-center">


                                @if($donorProfile?->profile_image)

                                    <img
                                        src="{{ asset('donors/images/profiles/'.$donorProfile->profile_image) }}"
                                        alt="{{ $user->name }}"
                                        style="
                                            width:120px;
                                            height:120px;
                                            object-fit:cover;
                                            border-radius:50%;
                                        "
                                    >

                                @endif


                                <h4 class="mt-3">
                                    {{ $user->name }}
                                </h4>


                                <p class="text-muted">
                                    {{ $user->email }}
                                </p>


                                <div class="progress mb-2">

                                    <div
                                        class="progress-bar"
                                        style="width:{{ $profileCompletion }}%"
                                    >
                                        {{ $profileCompletion }}%
                                    </div>

                                </div>


                                <a
                                    href="{{ route('donor.profile.edit') }}"
                                    class="btn btn-primary mt-3"
                                >
                                    Complete Profile
                                </a>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-8">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">
                                    Profile Information
                                </h4>


                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <tr>

                                            <th width="35%">
                                                Phone
                                            </th>

                                            <td>

                                                {{ $donorProfile?->phone ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Organization
                                            </th>

                                            <td>

                                                {{ $donorProfile?->organization ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Designation
                                            </th>

                                            <td>

                                                {{ $donorProfile?->designation ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Country
                                            </th>

                                            <td>

                                                {{ $donorProfile?->country ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                State
                                            </th>

                                            <td>

                                                {{ $donorProfile?->state ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                City
                                            </th>

                                            <td>

                                                {{ $donorProfile?->city ?? 'Not Provided' }}

                                            </td>

                                        </tr>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    REQUEST STATUS
                ====================================================== --}}

                <div class="row">

                    <div class="col-lg-4">

                        <div class="card">

                            <div class="card-body text-center">

                                <h3 class="text-warning">
                                    {{ $myPendingRequests }}
                                </h3>

                                <p class="mb-0">
                                    Pending Requests
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-4">

                        <div class="card">

                            <div class="card-body text-center">

                                <h3 class="text-success">
                                    {{ $myAcceptedRequests }}
                                </h3>

                                <p class="mb-0">
                                    Accepted Requests
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-4">

                        <div class="card">

                            <div class="card-body text-center">

                                <h3 class="text-danger">
                                    {{ $myRejectedRequests }}
                                </h3>

                                <p class="mb-0">
                                    Rejected Requests
                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    CATEGORY BREAKDOWN
                ====================================================== --}}

                <div class="row">

                    <div class="col-lg-5">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">
                                    My Products Category Wise
                                </h4>


                                @forelse($myCategoryStats as $category)

                                    <div
                                        class="d-flex justify-content-between border-bottom py-3"
                                    >

                                        <span>
                                            {{ $category->name }}
                                        </span>

                                        <strong>
                                            {{ $category->my_products_count }}
                                        </strong>

                                    </div>


                                @empty

                                    <p class="text-muted">
                                        No products added yet.
                                    </p>

                                @endforelse

                            </div>

                        </div>

                    </div>



                    {{-- Latest Products --}}

                    <div class="col-lg-7">

                        <div class="card">

                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between mb-3"
                                >

                                    <h4 class="card-title mb-0">
                                        Latest Products
                                    </h4>


                                    <a
                                        href="{{ route('donor.products.index') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        My Products
                                    </a>

                                </div>


                                <div class="table-responsive">

                                    <table class="table table-hover">

                                        <thead>

                                        <tr>

                                            <th>
                                                Product
                                            </th>

                                            <th>
                                                Category
                                            </th>

                                            <th>
                                                Status
                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>

                                        @forelse($latestMyProducts as $product)

                                            <tr>

                                                <td>

                                                    {{ $product->name }}

                                                </td>

                                                <td>

                                                    {{ $product->category?->name }}

                                                </td>

                                                <td>

                                                    @if($product->status === 'active')

                                                        <span class="badge badge-success">
                                                            Active
                                                        </span>

                                                    @else

                                                        <span class="badge badge-secondary">
                                                            Inactive
                                                        </span>

                                                    @endif

                                                </td>

                                            </tr>


                                        @empty

                                            <tr>

                                                <td
                                                    colspan="3"
                                                    class="text-center"
                                                >
                                                    No products found.
                                                </td>

                                            </tr>

                                        @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    LATEST APPROVED REQUESTS
                ====================================================== --}}

                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">

                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between mb-3"
                                >

                                    <h4 class="card-title mb-0">
                                        Latest Approved Requests
                                    </h4>


                                    <a
                                        href="{{ route('donor.product.requests.index') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        View Requests
                                    </a>

                                </div>


                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <thead>

                                        <tr>

                                            <th>
                                                Product
                                            </th>

                                            <th>
                                                Beneficiary
                                            </th>

                                            <th>
                                                Institution
                                            </th>

                                            <th>
                                                Status
                                            </th>

                                            <th>
                                                Date
                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>

                                        @forelse($latestDonorRequests as $productRequest)

                                            <tr>

                                                <td>

                                                    {{ $productRequest->product?->name }}

                                                </td>

                                                <td>

                                                    {{ $productRequest->beneficiary?->name }}

                                                </td>

                                                <td>

                                                    {{ $productRequest->beneficiary?->beneficiaryProfile?->institution ?? 'Not Provided' }}

                                                </td>

                                                <td>

                                                    @if($productRequest->donor_status === 'accepted')

                                                        <span class="badge badge-success">
                                                            Accepted
                                                        </span>

                                                    @elseif($productRequest->donor_status === 'rejected')

                                                        <span class="badge badge-danger">
                                                            Rejected
                                                        </span>

                                                    @else

                                                        <span class="badge badge-warning">
                                                            Pending
                                                        </span>

                                                    @endif

                                                </td>

                                                <td>

                                                    {{ $productRequest->created_at?->format('d M Y') }}

                                                </td>

                                            </tr>


                                        @empty

                                            <tr>

                                                <td
                                                    colspan="5"
                                                    class="text-center"
                                                >

                                                    No admin-approved requests available.

                                                </td>

                                            </tr>

                                        @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



            {{-- =========================================================
                BENEFICIARY DASHBOARD
            ========================================================== --}}

            @elseif($role === 'beneficiary')


                {{-- =====================================================
                    COUNTERS
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-3 col-sm-6">

                        <div class="card gradient-1">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    Available Products
                                </h3>

                                <h2 class="text-white">
                                    {{ $availableProducts }}
                                </h2>

                                <p class="text-white mb-0">
                                    Ready to request
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-sm-6">

                        <div class="card gradient-2">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    Categories
                                </h3>

                                <h2 class="text-white">
                                    {{ $availableCategories }}
                                </h2>

                                <p class="text-white mb-0">
                                    Active categories
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-sm-6">

                        <div class="card gradient-3">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    My Requests
                                </h3>

                                <h2 class="text-white">
                                    {{ $myRequests }}
                                </h2>

                                <p class="text-white mb-0">
                                    Total requests
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-sm-6">

                        <div class="card gradient-4">

                            <div class="card-body">

                                <h3 class="card-title text-white">
                                    My Profile
                                </h3>

                                <h2 class="text-white">
                                    {{ $profileCompletion }}%
                                </h2>

                                <p class="text-white mb-0">
                                    Profile completion
                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    BENEFICIARY PROFILE
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-4">

                        <div class="card">

                            <div class="card-body text-center">


                                @if($beneficiaryProfile?->profile_image)

                                    <img
                                        src="{{ asset('beneficiaries/images/profiles/'.$beneficiaryProfile->profile_image) }}"
                                        alt="{{ $user->name }}"
                                        style="
                                            width:120px;
                                            height:120px;
                                            border-radius:50%;
                                            object-fit:cover;
                                        "
                                    >

                                @endif


                                <h4 class="mt-3">
                                    {{ $user->name }}
                                </h4>


                                <p class="text-muted">

                                    {{ $user->email }}

                                </p>


                                <p>

                                    <strong>
                                        Qalam ID:
                                    </strong>

                                    {{ $user->qalam_id }}

                                </p>


                                <div class="progress">

                                    <div
                                        class="progress-bar"
                                        style="width:{{ $profileCompletion }}%"
                                    >
                                        {{ $profileCompletion }}%
                                    </div>

                                </div>


                                <a
                                    href="{{ route('beneficiary.profile.edit') }}"
                                    class="btn btn-primary mt-3"
                                >
                                    Complete Profile
                                </a>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-8">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">
                                    Academic & Profile Information
                                </h4>


                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <tr>

                                            <th width="35%">
                                                Institution
                                            </th>

                                            <td>

                                                {{ $beneficiaryProfile?->institution ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Degree
                                            </th>

                                            <td>

                                                {{ $beneficiaryProfile?->degree ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Enrollment Year
                                            </th>

                                            <td>

                                                {{ $beneficiaryProfile?->enrollment_year ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Graduation Year
                                            </th>

                                            <td>

                                                {{ $beneficiaryProfile?->graduation_year ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Province
                                            </th>

                                            <td>

                                                {{ $beneficiaryProfile?->province ?? 'Not Provided' }}

                                            </td>

                                        </tr>


                                        <tr>

                                            <th>
                                                Domicile
                                            </th>

                                            <td>

                                                {{ $beneficiaryProfile?->domicile ?? 'Not Provided' }}

                                            </td>

                                        </tr>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    REQUEST STATUS
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-3 col-md-6">

                        <div class="card">

                            <div class="card-body text-center">

                                <h3 class="text-warning">

                                    {{ $myAdminPendingRequests }}

                                </h3>

                                <p>
                                    Admin Pending
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-md-6">

                        <div class="card">

                            <div class="card-body text-center">

                                <h3 class="text-success">

                                    {{ $myAdminApprovedRequests }}

                                </h3>

                                <p>
                                    Admin Approved
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-md-6">

                        <div class="card">

                            <div class="card-body text-center">

                                <h3 class="text-primary">

                                    {{ $myDonorAcceptedRequests }}

                                </h3>

                                <p>
                                    Donor Accepted
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-md-6">

                        <div class="card">

                            <div class="card-body text-center">

                                <h3 class="text-danger">

                                    {{ $myAdminRejectedRequests + $myDonorRejectedRequests }}

                                </h3>

                                <p>
                                    Rejected
                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    AVAILABLE PRODUCTS CATEGORY WISE
                ====================================================== --}}

                <div class="row">


                    <div class="col-lg-5">

                        <div class="card">

                            <div class="card-body">

                                <h4 class="card-title">
                                    Available Products by Category
                                </h4>


                                @forelse($availableCategoryStats as $category)

                                    <div
                                        class="d-flex justify-content-between border-bottom py-3"
                                    >

                                        <span>

                                            {{ $category->name }}

                                        </span>


                                        <strong>

                                            {{ $category->available_products_count }}

                                        </strong>

                                    </div>


                                @empty

                                    <p class="text-muted">

                                        No available products.

                                    </p>

                                @endforelse

                            </div>

                        </div>

                    </div>



                    {{-- Latest Available --}}

                    <div class="col-lg-7">

                        <div class="card">

                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between mb-3"
                                >

                                    <h4 class="card-title mb-0">

                                        Latest Available Products

                                    </h4>


                                    <a
                                        href="{{ route('beneficiary.products.index') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        Browse All
                                    </a>

                                </div>


                                <div class="row">

                                    @forelse($latestAvailableProducts as $product)

                                        <div class="col-md-6 mb-3">

                                            <div class="border rounded p-3 h-100">


                                                @if($product->image)

                                                    <img
                                                        src="{{ asset('admins/images/products/'.$product->image) }}"
                                                        alt="{{ $product->name }}"
                                                        style="
                                                            width:100%;
                                                            height:130px;
                                                            object-fit:cover;
                                                            border-radius:6px;
                                                        "
                                                    >

                                                @endif


                                                <h5 class="mt-3">

                                                    {{ $product->name }}

                                                </h5>


                                                <span class="badge badge-info">

                                                    {{ $product->category?->name }}

                                                </span>


                                                <p class="text-muted mt-2 mb-0">

                                                    {{
                                                        \Illuminate\Support\Str::limit(
                                                            $product->description,
                                                            60
                                                        )
                                                    }}

                                                </p>

                                            </div>

                                        </div>


                                    @empty

                                        <div class="col-md-12">

                                            <p class="text-muted">
                                                No products available.
                                            </p>

                                        </div>

                                    @endforelse

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    MY LATEST REQUESTS
                ====================================================== --}}

                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">

                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between mb-3"
                                >

                                    <h4 class="card-title mb-0">
                                        My Latest Requests
                                    </h4>


                                    <a
                                        href="{{ route('beneficiary.requests.index') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        View All
                                    </a>

                                </div>


                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <thead>

                                        <tr>

                                            <th>
                                                Product
                                            </th>

                                            <th>
                                                Category
                                            </th>

                                            <th>
                                                Admin Status
                                            </th>

                                            <th>
                                                Donor Status
                                            </th>

                                            <th>
                                                Requested
                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>

                                        @forelse($latestMyRequests as $productRequest)

                                            <tr>

                                                <td>

                                                    {{ $productRequest->product?->name ?? 'Product Removed' }}

                                                </td>


                                                <td>

                                                    {{ $productRequest->product?->category?->name ?? 'N/A' }}

                                                </td>


                                                <td>

                                                    @if($productRequest->admin_status === 'approved')

                                                        <span class="badge badge-success">
                                                            Approved
                                                        </span>

                                                    @elseif($productRequest->admin_status === 'rejected')

                                                        <span class="badge badge-danger">
                                                            Rejected
                                                        </span>

                                                    @else

                                                        <span class="badge badge-warning">
                                                            Pending
                                                        </span>

                                                    @endif

                                                </td>


                                                <td>

                                                    @if(!$productRequest->donor_id)

                                                        <span class="badge badge-secondary">
                                                            N/A
                                                        </span>

                                                    @elseif($productRequest->admin_status !== 'approved')

                                                        <span class="badge badge-secondary">
                                                            Awaiting Admin
                                                        </span>

                                                    @elseif($productRequest->donor_status === 'accepted')

                                                        <span class="badge badge-success">
                                                            Accepted
                                                        </span>

                                                    @elseif($productRequest->donor_status === 'rejected')

                                                        <span class="badge badge-danger">
                                                            Rejected
                                                        </span>

                                                    @else

                                                        <span class="badge badge-warning">
                                                            Waiting Donor
                                                        </span>

                                                    @endif

                                                </td>


                                                <td>

                                                    {{ $productRequest->created_at?->format('d M Y') }}

                                                </td>

                                            </tr>


                                        @empty

                                            <tr>

                                                <td
                                                    colspan="5"
                                                    class="text-center"
                                                >

                                                    You have not submitted any requests.

                                                </td>

                                            </tr>

                                        @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            @endif


        </div>

    </div>

</div>


@include('layouts.admins.script')

</body>
</html>
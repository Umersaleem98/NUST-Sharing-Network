@include('layouts.admins.head')
<title>Product Requests</title>
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
                        Product Requests
                    </h3>

                    <p class="text-muted mb-0">
                        Review beneficiary requests before forwarding them to donors.
                    </p>

                </div>

            </div>


            {{-- =========================================================
                SUCCESS
            ========================================================== --}}

            @if(session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >

                    <i class="fa fa-check-circle mr-1"></i>

                    {{ session('success') }}


                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >
                        <span>&times;</span>
                    </button>

                </div>

            @endif


            {{-- =========================================================
                ERROR
            ========================================================== --}}

            @if(session('error'))

                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >

                    <i class="fa fa-exclamation-circle mr-1"></i>

                    {{ session('error') }}


                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >
                        <span>&times;</span>
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
                SUMMARY
            ========================================================== --}}

            <div class="row">


                {{-- Total --}}

                <div class="col-xl col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h5 class="text-muted">
                                Total Requests
                            </h5>

                            <h2 class="mb-0">
                                {{ $totalRequests }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- Pending --}}

                <div class="col-xl col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h5 class="text-warning">
                                Pending Review
                            </h5>

                            <h2 class="mb-0">
                                {{ $pendingRequests }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- Approved --}}

                <div class="col-xl col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h5 class="text-success">
                                Admin Approved
                            </h5>

                            <h2 class="mb-0">
                                {{ $approvedRequests }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- Rejected --}}

                <div class="col-xl col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h5 class="text-danger">
                                Admin Rejected
                            </h5>

                            <h2 class="mb-0">
                                {{ $rejectedRequests }}
                            </h2>

                        </div>

                    </div>

                </div>


                {{-- Donor Accepted --}}

                <div class="col-xl col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h5 class="text-primary">
                                Donor Accepted
                            </h5>

                            <h2 class="mb-0">
                                {{ $acceptedByDonor }}
                            </h2>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =========================================================
                FILTER
            ========================================================== --}}

            <div class="card mb-4">

                <div class="card-body">

                    <form
                        method="GET"
                        action="{{ route('admin.product.requests.index') }}"
                    >

                        <div class="row align-items-end">


                            {{-- Search --}}

                            <div class="col-lg-4 col-md-6">

                                <div class="form-group mb-lg-0">

                                    <label>
                                        Search
                                    </label>

                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        class="form-control"
                                        placeholder="Product, beneficiary, email or Qalam ID..."
                                    >

                                </div>

                            </div>


                            {{-- Admin Status --}}

                            <div class="col-lg-3 col-md-6">

                                <div class="form-group mb-lg-0">

                                    <label>
                                        Admin Status
                                    </label>

                                    <select
                                        name="admin_status"
                                        class="form-control"
                                    >

                                        <option value="">
                                            All Statuses
                                        </option>


                                        <option
                                            value="pending"
                                            {{ request('admin_status') === 'pending' ? 'selected' : '' }}
                                        >
                                            Pending
                                        </option>


                                        <option
                                            value="approved"
                                            {{ request('admin_status') === 'approved' ? 'selected' : '' }}
                                        >
                                            Approved
                                        </option>


                                        <option
                                            value="rejected"
                                            {{ request('admin_status') === 'rejected' ? 'selected' : '' }}
                                        >
                                            Rejected
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Donor Status --}}

                            <div class="col-lg-2 col-md-6">

                                <div class="form-group mb-lg-0">

                                    <label>
                                        Donor Status
                                    </label>

                                    <select
                                        name="donor_status"
                                        class="form-control"
                                    >

                                        <option value="">
                                            All Statuses
                                        </option>


                                        <option
                                            value="pending"
                                            {{ request('donor_status') === 'pending' ? 'selected' : '' }}
                                        >
                                            Pending
                                        </option>


                                        <option
                                            value="accepted"
                                            {{ request('donor_status') === 'accepted' ? 'selected' : '' }}
                                        >
                                            Accepted
                                        </option>


                                        <option
                                            value="rejected"
                                            {{ request('donor_status') === 'rejected' ? 'selected' : '' }}
                                        >
                                            Rejected
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Buttons --}}

                            <div class="col-lg-3 col-md-6">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa fa-search mr-1"></i>

                                    Search

                                </button>


                                <a
                                    href="{{ route('admin.product.requests.index') }}"
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
                REQUESTS TABLE
            ========================================================== --}}

            <div class="card">

                <div class="card-body">


                    <div class="d-flex justify-content-between mb-3">

                        <div>

                            <h4 class="card-title mb-1">
                                Requests
                            </h4>

                            <small class="text-muted">

                                Total:

                                <strong>
                                    {{ $requests->total() }}
                                </strong>

                            </small>

                        </div>

                    </div>


                    <div class="table-responsive">

                        <table class="table table-hover table-bordered">

                            <thead class="thead-light">

                            <tr>

                                <th>#</th>

                                <th>Product</th>

                                <th>Beneficiary</th>

                                <th>Donor</th>

                                <th>Admin Status</th>

                                <th>Donor Status</th>

                                <th>Date</th>

                                <th class="text-center">
                                    Action
                                </th>

                            </tr>

                            </thead>


                            <tbody>

                            @forelse($requests as $productRequest)

                                <tr>


                                    {{-- Number --}}

                                    <td>

                                        {{ $requests->firstItem() + $loop->index }}

                                    </td>


                                    {{-- Product --}}

                                    <td>

                                        <div class="d-flex align-items-center">


                                            @if($productRequest->product?->image)

                                                <img
                                                    src="{{ asset('admins/images/products/'.$productRequest->product->image) }}"
                                                    alt="{{ $productRequest->product->name }}"
                                                    style="
                                                        width: 55px;
                                                        height: 55px;
                                                        object-fit: cover;
                                                        border-radius: 6px;
                                                        margin-right: 10px;
                                                    "
                                                >

                                            @endif


                                            <div>

                                                <strong>

                                                    {{ $productRequest->product?->name ?? 'Product Removed' }}

                                                </strong>

                                                <br>

                                                <small class="text-muted">

                                                    {{ $productRequest->product?->category?->name ?? 'No Category' }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Beneficiary --}}

                                    <td>

                                        <strong>

                                            {{ $productRequest->beneficiary?->name ?? 'N/A' }}

                                        </strong>

                                        <br>

                                        <small>

                                            {{ $productRequest->beneficiary?->email }}

                                        </small>

                                        <br>

                                        <small class="text-muted">

                                            Qalam:
                                            {{ $productRequest->beneficiary?->qalam_id ?? 'N/A' }}

                                        </small>

                                    </td>


                                    {{-- Donor --}}

                                    <td>

                                        @if($productRequest->donor)

                                            <strong>

                                                {{ $productRequest->donor->name }}

                                            </strong>

                                            <br>

                                            <small>

                                                {{ $productRequest->donor->email }}

                                            </small>

                                        @else

                                            <span class="badge badge-secondary">
                                                Admin Product
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Admin Status --}}

                                    <td>

                                        @if($productRequest->admin_status === 'approved')

                                            <span class="badge badge-success">

                                                <i class="fa fa-check-circle mr-1"></i>

                                                Approved

                                            </span>


                                        @elseif($productRequest->admin_status === 'rejected')

                                            <span class="badge badge-danger">

                                                <i class="fa fa-times-circle mr-1"></i>

                                                Rejected

                                            </span>


                                        @else

                                            <span class="badge badge-warning">

                                                <i class="fa fa-clock-o mr-1"></i>

                                                Pending

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Donor Status --}}

                                    <td>

                                        @if(!$productRequest->donor_id)

                                            <span class="badge badge-secondary">
                                                N/A
                                            </span>


                                        @elseif($productRequest->admin_status !== 'approved')

                                            <span class="badge badge-secondary">
                                                Not Visible Yet
                                            </span>


                                        @elseif($productRequest->donor_status === 'accepted')

                                            <span class="badge badge-success">

                                                <i class="fa fa-check mr-1"></i>

                                                Accepted

                                            </span>


                                        @elseif($productRequest->donor_status === 'rejected')

                                            <span class="badge badge-danger">

                                                <i class="fa fa-times mr-1"></i>

                                                Rejected

                                            </span>


                                        @else

                                            <span class="badge badge-warning">
                                                Waiting Donor
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Date --}}

                                    <td>

                                        {{ $productRequest->created_at?->format('d M Y') }}

                                        <br>

                                        <small class="text-muted">

                                            {{ $productRequest->created_at?->format('h:i A') }}

                                        </small>

                                    </td>


                                    {{-- Action --}}

                                    <td class="text-center">

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-info"
                                            data-toggle="modal"
                                            data-target="#requestDetailsModal{{ $productRequest->id }}"
                                            title="View Complete Request"
                                        >

                                            <i class="fa fa-eye mr-1"></i>

                                            View

                                        </button>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="fa fa-inbox fa-3x text-muted mb-3"
                                        ></i>

                                        <h5>
                                            No Requests Found
                                        </h5>

                                        <p class="text-muted mb-0">
                                            No product requests match the selected filters.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- Pagination --}}

                    <div class="mt-4">

                        {{ $requests->links() }}

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        REQUEST DETAILS MODALS
    ========================================================== --}}

    @foreach($requests as $productRequest)

        @php

            $product =
                $productRequest->product;

            $beneficiary =
                $productRequest->beneficiary;

            $beneficiaryProfile =
                $beneficiary?->beneficiaryProfile;

            $donor =
                $productRequest->donor;

            $donorProfile =
                $donor?->donorProfile;

        @endphp


        <div
            class="modal fade"
            id="requestDetailsModal{{ $productRequest->id }}"
            tabindex="-1"
            role="dialog"
            aria-hidden="true"
        >

            <div
                class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
                role="document"
            >

                <div class="modal-content">


                    {{-- =================================================
                        MODAL HEADER
                    ================================================== --}}

                    <div
                        class="modal-header"
                        style="
                            background: #00558c;
                            color: #ffffff;
                        "
                    >

                        <div>

                            <h4 class="modal-title text-white mb-1">

                                Product Request #{{ $productRequest->id }}

                            </h4>

                            <small>

                                Submitted:
                                {{ $productRequest->created_at?->format('d M Y h:i A') }}

                            </small>

                        </div>


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



                    {{-- =================================================
                        MODAL BODY
                    ================================================== --}}

                    <div class="modal-body">


                        {{-- =================================================
                            REQUEST STATUS
                        ================================================== --}}

                        <div class="card mb-4">

                            <div class="card-body">

                                <div class="row">


                                    {{-- Admin Status --}}

                                    <div class="col-md-4">

                                        <small class="text-muted">
                                            Admin Status
                                        </small>

                                        <br>

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

                                    </div>


                                    {{-- Donor Status --}}

                                    <div class="col-md-4">

                                        <small class="text-muted">
                                            Donor Status
                                        </small>

                                        <br>


                                        @if(!$productRequest->donor_id)

                                            <span class="badge badge-secondary">
                                                Not Applicable
                                            </span>


                                        @elseif($productRequest->admin_status !== 'approved')

                                            <span class="badge badge-secondary">
                                                Not Visible To Donor
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

                                    </div>


                                    {{-- Request Date --}}

                                    <div class="col-md-4">

                                        <small class="text-muted">
                                            Request Date
                                        </small>

                                        <br>

                                        <strong>

                                            {{ $productRequest->created_at?->format('d M Y') }}

                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            PRODUCT DETAILS
                        ================================================== --}}

                        <div class="card mb-4">

                            <div class="card-header">

                                <h4 class="mb-0">

                                    <i class="fa fa-cube mr-2"></i>

                                    Product Details

                                </h4>

                            </div>


                            <div class="card-body">

                                <div class="row">


                                    {{-- Image --}}

                                    <div class="col-lg-3 col-md-4 text-center mb-3">


                                        @if($product?->image)

                                            <img
                                                src="{{ asset('admins/images/products/'.$product->image) }}"
                                                alt="{{ $product->name }}"
                                                style="
                                                    width: 100%;
                                                    max-width: 220px;
                                                    height: 200px;
                                                    object-fit: cover;
                                                    border-radius: 10px;
                                                    border: 1px solid #ddd;
                                                "
                                            >

                                        @else

                                            <div
                                                class="bg-light d-flex align-items-center justify-content-center mx-auto"
                                                style="
                                                    width: 100%;
                                                    max-width: 220px;
                                                    height: 200px;
                                                    border-radius: 10px;
                                                "
                                            >

                                                <i
                                                    class="fa fa-image text-muted"
                                                    style="font-size: 50px;"
                                                ></i>

                                            </div>

                                        @endif

                                    </div>


                                    {{-- Details --}}

                                    <div class="col-lg-9 col-md-8">

                                        <div class="table-responsive">

                                            <table class="table table-bordered">

                                                <tr>

                                                    <th width="30%">
                                                        Product Name
                                                    </th>

                                                    <td>

                                                        {{ $product?->name ?? 'Product Removed' }}

                                                    </td>

                                                </tr>


                                                <tr>

                                                    <th>
                                                        Category
                                                    </th>

                                                    <td>

                                                        {{ $product?->category?->name ?? 'Not Available' }}

                                                    </td>

                                                </tr>


                                                <tr>

                                                    <th>
                                                        Product Status
                                                    </th>

                                                    <td>

                                                        @if($product?->status === 'active')

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


                                                <tr>

                                                    <th>
                                                        Created By
                                                    </th>

                                                    <td>

                                                        {{ $product?->creator?->name ?? 'Not Available' }}

                                                        @if($product?->creator)

                                                            <br>

                                                            <small class="text-muted">

                                                                {{ $product->creator->email }}

                                                                |
                                                                {{ ucfirst($product->creator->role) }}

                                                            </small>

                                                        @endif

                                                    </td>

                                                </tr>


                                                <tr>

                                                    <th>
                                                        Description
                                                    </th>

                                                    <td>

                                                        {{ $product?->description ?: 'No description provided.' }}

                                                    </td>

                                                </tr>

                                            </table>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            BENEFICIARY PROFILE
                        ================================================== --}}

                        <div class="card mb-4">

                            <div
                                class="card-header"
                                style="
                                    background: #f8f9fa;
                                "
                            >

                                <h4 class="mb-0">

                                    <i class="fa fa-user mr-2"></i>

                                    Complete Beneficiary Profile

                                </h4>

                            </div>


                            <div class="card-body">

                                <div class="row">


                                    {{-- Profile Image --}}

                                    <div class="col-lg-3 text-center mb-4">


                                        @if($beneficiaryProfile?->profile_image)

                                            <img
                                                src="{{ asset('beneficiaries/images/profiles/'.$beneficiaryProfile->profile_image) }}"
                                                alt="{{ $beneficiary?->name }}"
                                                style="
                                                    width: 145px;
                                                    height: 145px;
                                                    border-radius: 50%;
                                                    object-fit: cover;
                                                    border: 4px solid #eeeeee;
                                                "
                                            >

                                        @else

                                            <div
                                                class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                                style="
                                                    width: 145px;
                                                    height: 145px;
                                                    font-size: 50px;
                                                    font-weight: 600;
                                                "
                                            >

                                                {{
                                                    $beneficiary
                                                        ? strtoupper(
                                                            substr(
                                                                $beneficiary->name,
                                                                0,
                                                                1
                                                            )
                                                        )
                                                        : '?'
                                                }}

                                            </div>

                                        @endif


                                        <h5 class="mt-3 mb-1">

                                            {{ $beneficiary?->name ?? 'Not Available' }}

                                        </h5>


                                        <span class="badge badge-primary">
                                            Beneficiary
                                        </span>


                                        @if($beneficiary?->profile_status === 'active')

                                            <span class="badge badge-success">
                                                Active
                                            </span>

                                        @elseif($beneficiary?->profile_status === 'suspended')

                                            <span class="badge badge-warning">
                                                Suspended
                                            </span>

                                        @elseif($beneficiary)

                                            <span class="badge badge-danger">
                                                Blocked
                                            </span>

                                        @endif

                                    </div>


                                    {{-- Profile Details --}}

                                    <div class="col-lg-9">

                                        <div class="row">


                                            {{-- Account --}}

                                            <div class="col-md-6">

                                                <h5 class="mb-3">
                                                    Account Information
                                                </h5>


                                                <table class="table table-bordered">

                                                    <tr>

                                                        <th width="45%">
                                                            Name
                                                        </th>

                                                        <td>
                                                            {{ $beneficiary?->name ?? 'N/A' }}
                                                        </td>

                                                    </tr>


                                                    <tr>

                                                        <th>
                                                            Email
                                                        </th>

                                                        <td>
                                                            {{ $beneficiary?->email ?? 'N/A' }}
                                                        </td>

                                                    </tr>


                                                    <tr>

                                                        <th>
                                                            Qalam ID
                                                        </th>

                                                        <td>
                                                            {{ $beneficiary?->qalam_id ?? 'N/A' }}
                                                        </td>

                                                    </tr>


                                                    <tr>

                                                        <th>
                                                            Phone
                                                        </th>

                                                        <td>
                                                            {{ $beneficiaryProfile?->phone ?? 'Not Provided' }}
                                                        </td>

                                                    </tr>


                                                    <tr>

                                                        <th>
                                                            Gender
                                                        </th>

                                                        <td>

                                                            {{
                                                                $beneficiaryProfile?->gender
                                                                    ? ucfirst($beneficiaryProfile->gender)
                                                                    : 'Not Provided'
                                                            }}

                                                        </td>

                                                    </tr>


                                                    <tr>

                                                        <th>
                                                            Email Verification
                                                        </th>

                                                        <td>

                                                            @if($beneficiary?->email_verified_at)

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


                                            {{-- Academic --}}

                                            <div class="col-md-6">

                                                <h5 class="mb-3">
                                                    Academic Information
                                                </h5>


                                                <table class="table table-bordered">

                                                    <tr>

                                                        <th width="45%">
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

                                                </table>

                                            </div>


                                            {{-- Financial --}}

                                            <div class="col-md-6 mt-3">

                                                <h5 class="mb-3">
                                                    Family & Financial Information
                                                </h5>


                                                <table class="table table-bordered">

                                                    <tr>

                                                        <th width="45%">
                                                            Father Status
                                                        </th>

                                                        <td>

                                                            @if($beneficiaryProfile?->father_status)

                                                                {{
                                                                    ucwords(
                                                                        str_replace(
                                                                            '_',
                                                                            ' ',
                                                                            $beneficiaryProfile->father_status
                                                                        )
                                                                    )
                                                                }}

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

                                                            {{ $beneficiaryProfile?->guardian_profession ?? 'Not Provided' }}

                                                        </td>

                                                    </tr>


                                                    <tr>

                                                        <th>
                                                            Monthly Income
                                                        </th>

                                                        <td>

                                                            @if($beneficiaryProfile?->monthly_income !== null)

                                                                PKR

                                                                {{
                                                                    number_format(
                                                                        (float) $beneficiaryProfile->monthly_income,
                                                                        0
                                                                    )
                                                                }}

                                                            @else

                                                                Not Provided

                                                            @endif

                                                        </td>

                                                    </tr>

                                                </table>

                                            </div>


                                            {{-- Address --}}

                                            <div class="col-md-6 mt-3">

                                                <h5 class="mb-3">
                                                    Address Information
                                                </h5>


                                                <table class="table table-bordered">

                                                    <tr>

                                                        <th width="45%">
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


                                                    <tr>

                                                        <th>
                                                            Home Address
                                                        </th>

                                                        <td>
                                                            {{ $beneficiaryProfile?->home_address ?? 'Not Provided' }}
                                                        </td>

                                                    </tr>

                                                </table>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            DONOR PROFILE
                        ================================================== --}}

                        <div class="card mb-4">

                            <div
                                class="card-header"
                                style="
                                    background: #f8f9fa;
                                "
                            >

                                <h4 class="mb-0">

                                    <i class="fa fa-user-circle mr-2"></i>

                                    Complete Donor Profile

                                </h4>

                            </div>


                            <div class="card-body">


                                @if($donor)


                                    <div class="row">


                                        {{-- Donor Image --}}

                                        <div class="col-lg-3 text-center mb-4">


                                            @if($donorProfile?->profile_image)

                                                <img
                                                    src="{{ asset('donors/images/profiles/'.$donorProfile->profile_image) }}"
                                                    alt="{{ $donor->name }}"
                                                    style="
                                                        width: 145px;
                                                        height: 145px;
                                                        border-radius: 50%;
                                                        object-fit: cover;
                                                        border: 4px solid #eeeeee;
                                                    "
                                                >

                                            @else

                                                <div
                                                    class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center"
                                                    style="
                                                        width: 145px;
                                                        height: 145px;
                                                        font-size: 50px;
                                                        font-weight: 600;
                                                    "
                                                >

                                                    {{
                                                        strtoupper(
                                                            substr(
                                                                $donor->name,
                                                                0,
                                                                1
                                                            )
                                                        )
                                                    }}

                                                </div>

                                            @endif


                                            <h5 class="mt-3 mb-1">

                                                {{ $donor->name }}

                                            </h5>


                                            <span class="badge badge-primary">
                                                Donor
                                            </span>


                                            @if($donor->profile_status === 'active')

                                                <span class="badge badge-success">
                                                    Active
                                                </span>

                                            @elseif($donor->profile_status === 'suspended')

                                                <span class="badge badge-warning">
                                                    Suspended
                                                </span>

                                            @else

                                                <span class="badge badge-danger">
                                                    Blocked
                                                </span>

                                            @endif

                                        </div>


                                        {{-- Donor Details --}}

                                        <div class="col-lg-9">

                                            <div class="row">


                                                {{-- Account --}}

                                                <div class="col-md-6">

                                                    <h5 class="mb-3">
                                                        Account Information
                                                    </h5>


                                                    <table class="table table-bordered">

                                                        <tr>

                                                            <th width="45%">
                                                                Name
                                                            </th>

                                                            <td>
                                                                {{ $donor->name }}
                                                            </td>

                                                        </tr>


                                                        <tr>

                                                            <th>
                                                                Email
                                                            </th>

                                                            <td>
                                                                {{ $donor->email }}
                                                            </td>

                                                        </tr>


                                                        <tr>

                                                            <th>
                                                                Phone
                                                            </th>

                                                            <td>
                                                                {{ $donorProfile?->phone ?? 'Not Provided' }}
                                                            </td>

                                                        </tr>


                                                        <tr>

                                                            <th>
                                                                Email Verification
                                                            </th>

                                                            <td>

                                                                @if($donor->email_verified_at)

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


                                                {{-- Professional --}}

                                                <div class="col-md-6">

                                                    <h5 class="mb-3">
                                                        Professional Information
                                                    </h5>


                                                    <table class="table table-bordered">

                                                        <tr>

                                                            <th width="45%">
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

                                                    </table>

                                                </div>


                                                {{-- Location --}}

                                                <div class="col-md-12 mt-3">

                                                    <h5 class="mb-3">
                                                        Location Information
                                                    </h5>


                                                    <table class="table table-bordered">

                                                        <tr>

                                                            <th width="25%">
                                                                Country
                                                            </th>

                                                            <td>
                                                                {{ $donorProfile?->country ?? 'Not Provided' }}
                                                            </td>

                                                        </tr>


                                                        <tr>

                                                            <th>
                                                                State / Province
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


                                @else


                                    <div class="alert alert-info mb-0">

                                        <i class="fa fa-info-circle mr-1"></i>

                                        This product was created by an administrator, therefore no donor profile is associated with this request.

                                    </div>


                                    @if($product?->creator)

                                        <div class="mt-3">

                                            <strong>
                                                Product Creator:
                                            </strong>

                                            {{ $product->creator->name }}

                                            <br>

                                            <strong>
                                                Email:
                                            </strong>

                                            {{ $product->creator->email }}

                                        </div>

                                    @endif


                                @endif

                            </div>

                        </div>



                        {{-- =================================================
                            BENEFICIARY REQUEST MESSAGE
                        ================================================== --}}

                        <div class="card mb-4">

                            <div class="card-header">

                                <h4 class="mb-0">

                                    <i class="fa fa-comment mr-2"></i>

                                    Beneficiary Request

                                </h4>

                            </div>


                            <div class="card-body">

                                <strong>
                                    Request Message
                                </strong>


                                <div class="bg-light p-3 rounded mt-2">

                                    {{
                                        $productRequest->beneficiary_message
                                            ?: 'No message provided by the beneficiary.'
                                    }}

                                </div>


                                @if($productRequest->admin_message)

                                    <hr>


                                    <strong>
                                        Admin Message
                                    </strong>


                                    <div class="alert alert-info mt-2 mb-0">

                                        {{ $productRequest->admin_message }}

                                    </div>

                                @endif


                                @if($productRequest->donor_message)

                                    <hr>


                                    <strong>
                                        Donor Message
                                    </strong>


                                    <div class="alert alert-secondary mt-2 mb-0">

                                        {{ $productRequest->donor_message }}

                                    </div>

                                @endif

                            </div>

                        </div>



                        {{-- =================================================
                            ADMIN ACTIONS
                        ================================================== --}}

                        @if($productRequest->admin_status === 'pending')

                            <div class="row">


                                {{-- Approve --}}

                                <div class="col-lg-6">

                                    <div class="card border-success">

                                        <div class="card-body">

                                            <h4 class="text-success">

                                                <i class="fa fa-check-circle mr-1"></i>

                                                Approve Request

                                            </h4>


                                            <p class="text-muted">

                                                After approval, this request becomes visible to the donor.

                                            </p>


                                            <form
                                                action="{{ route('admin.product.requests.approve', $productRequest) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PATCH')


                                                <div class="form-group">

                                                    <label>
                                                        Admin Note
                                                    </label>


                                                    <textarea
                                                        name="admin_message"
                                                        rows="4"
                                                        class="form-control"
                                                        maxlength="1000"
                                                        placeholder="Optional note for beneficiary/donor..."
                                                    ></textarea>

                                                </div>


                                                <button
                                                    type="submit"
                                                    class="btn btn-success"
                                                    onclick="return confirm('Approve this request and make it visible to the donor?');"
                                                >

                                                    <i class="fa fa-check mr-1"></i>

                                                    Approve Request

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>


                                {{-- Reject --}}

                                <div class="col-lg-6">

                                    <div class="card border-danger">

                                        <div class="card-body">

                                            <h4 class="text-danger">

                                                <i class="fa fa-times-circle mr-1"></i>

                                                Reject Request

                                            </h4>


                                            <p class="text-muted">

                                                Rejected requests will never be shown to the donor.

                                            </p>


                                            <form
                                                action="{{ route('admin.product.requests.reject', $productRequest) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('PATCH')


                                                <div class="form-group">

                                                    <label>
                                                        Rejection Reason
                                                        <span class="text-danger">*</span>
                                                    </label>


                                                    <textarea
                                                        name="admin_message"
                                                        rows="4"
                                                        class="form-control"
                                                        maxlength="1000"
                                                        placeholder="Enter rejection reason..."
                                                        required
                                                    ></textarea>

                                                </div>


                                                <button
                                                    type="submit"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to reject this request?');"
                                                >

                                                    <i class="fa fa-times mr-1"></i>

                                                    Reject Request

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>


                        @else


                            {{-- Already Reviewed --}}

                            <div class="card">

                                <div class="card-body">

                                    <h4>
                                        Admin Decision
                                    </h4>


                                    @if($productRequest->admin_status === 'approved')

                                        <div class="alert alert-success mb-0">

                                            <strong>

                                                <i class="fa fa-check-circle mr-1"></i>

                                                Approved

                                            </strong>

                                            <br>

                                            This request has been approved and is visible to the donor.

                                        </div>

                                    @else

                                        <div class="alert alert-danger mb-0">

                                            <strong>

                                                <i class="fa fa-times-circle mr-1"></i>

                                                Rejected

                                            </strong>

                                            <br>

                                            This request was rejected and is not visible to the donor.

                                        </div>

                                    @endif

                                </div>

                            </div>


                        @endif

                    </div>



                    {{-- =================================================
                        MODAL FOOTER
                    ================================================== --}}

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >

                            Close

                        </button>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div>


@include('layouts.admins.script')


<style>

    /*
    |--------------------------------------------------------------------------
    | Request Modal
    |--------------------------------------------------------------------------
    */

    .modal-xl {
        max-width: 1200px;
    }


    .modal-body .table th {
        background: #f8f9fa;
        vertical-align: middle;
    }


    .modal-body .table td {
        vertical-align: middle;
    }


    @media (max-width: 767.98px) {

        .modal-xl {
            max-width: 96%;
            margin-left: auto;
            margin-right: auto;
        }

    }

</style>

</body>
</html>
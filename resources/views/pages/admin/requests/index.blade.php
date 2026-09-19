@include('layouts.admin.head')

<title>Request Management</title>

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

            @php
                $stats = $requestStats ?? [
                    'total' => $requests->total(),
                    'pending' => $requests->getCollection()
                        ->where('admin_status', 'pending')
                        ->count(),
                    'approved' => $requests->getCollection()
                        ->where('admin_status', 'approved')
                        ->count(),
                    'rejected' => $requests->getCollection()
                        ->where('admin_status', 'rejected')
                        ->count(),
                ];
            @endphp


            {{-- =====================================================
                PAGE HEADER
            ====================================================== --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        Request Management
                    </h3>

                    <p class="text-secondary small mb-0">
                        Review product requests, beneficiary profiles and donor information before making an administrative decision.
                    </p>
                </div>


                <div class="d-flex flex-wrap align-items-center gap-2">

                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                        <i class="bi bi-clipboard-data me-1"></i>
                        {{ number_format($stats['total']) }}
                        Total Requests
                    </span>

                </div>

            </div>


            {{-- =====================================================
                BREADCRUMB
            ====================================================== --}}
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
                        Request Management
                    </li>

                </ol>

            </nav>


            {{-- =====================================================
                ALERTS
            ====================================================== --}}
            @include('layouts.admin.alert')


            {{-- =====================================================
                REQUEST STATISTICS
            ====================================================== --}}
            <div class="row g-3 mb-4">

                {{-- Total --}}
                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="request-stat-card h-100">

                        <div class="request-stat-icon bg-primary-subtle text-primary">
                            <i class="bi bi-collection"></i>
                        </div>

                        <div>
                            <div class="request-stat-label">
                                Total Requests
                            </div>

                            <div class="request-stat-value">
                                {{ number_format($stats['total']) }}
                            </div>
                        </div>

                    </div>

                </div>


                {{-- Pending --}}
                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="request-stat-card h-100">

                        <div class="request-stat-icon bg-warning-subtle text-warning-emphasis">
                            <i class="bi bi-hourglass-split"></i>
                        </div>

                        <div>
                            <div class="request-stat-label">
                                Pending Review
                            </div>

                            <div class="request-stat-value">
                                {{ number_format($stats['pending']) }}
                            </div>
                        </div>

                    </div>

                </div>


                {{-- Approved --}}
                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="request-stat-card h-100">

                        <div class="request-stat-icon bg-success-subtle text-success">
                            <i class="bi bi-check-circle"></i>
                        </div>

                        <div>
                            <div class="request-stat-label">
                                Approved
                            </div>

                            <div class="request-stat-value">
                                {{ number_format($stats['approved']) }}
                            </div>
                        </div>

                    </div>

                </div>


                {{-- Rejected --}}
                <div class="col-12 col-sm-6 col-xl-3">

                    <div class="request-stat-card h-100">

                        <div class="request-stat-icon bg-danger-subtle text-danger">
                            <i class="bi bi-x-circle"></i>
                        </div>

                        <div>
                            <div class="request-stat-label">
                                Rejected
                            </div>

                            <div class="request-stat-value">
                                {{ number_format($stats['rejected']) }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                REQUEST QUEUE
            ====================================================== --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- Card Header --}}
                <div class="card-header bg-white border-bottom px-4 py-3">

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                        <div>
                            <h5 class="fw-bold text-dark mb-1">
                                Product Request Queue
                            </h5>

                            <p class="text-secondary small mb-0">
                                Review the request in sequence, inspect both profiles, then approve or reject it.
                            </p>
                        </div>


                        <div class="d-flex flex-wrap gap-2">

                            <span class="request-legend">
                                <span class="request-legend-dot bg-warning"></span>
                                Pending
                            </span>

                            <span class="request-legend">
                                <span class="request-legend-dot bg-success"></span>
                                Approved
                            </span>

                            <span class="request-legend">
                                <span class="request-legend-dot bg-danger"></span>
                                Rejected
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Table --}}
                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table request-table align-middle mb-0">

                            <thead>

                                <tr>
                                    <th class="px-4">
                                        Request
                                    </th>

                                    <th>
                                        Product
                                    </th>

                                    <th>
                                        Beneficiary
                                    </th>

                                    <th>
                                        Donor
                                    </th>

                                    <th>
                                        Admin Status
                                    </th>

                                    <th>
                                        Donor Status
                                    </th>

                                    <th>
                                        Submitted
                                    </th>

                                    <th class="px-4 text-end">
                                        Actions
                                    </th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($requests as $key => $productRequest)

                                    @php
                                        $product = $productRequest->product;
                                        $beneficiary = $productRequest->beneficiary;
                                        $donor = $productRequest->donor;

                                        $productImages = [];

                                        if ($product) {
                                            $productImages = is_array($product->images)
                                                ? $product->images
                                                : json_decode($product->images, true);

                                            $productImages = is_array($productImages)
                                                ? $productImages
                                                : [];
                                        }

                                        $productImage = !empty($productImages)
                                            ? asset(
                                                'admins/products/' .
                                                basename($productImages[0])
                                            )
                                            : asset(
                                                'admins/asset/dummy/dummy.jpg'
                                            );

                                        $adminStatus = $productRequest->admin_status
                                            ?? 'pending';

                                        $donorStatus = $productRequest->donor_status
                                            ?? 'pending';

                                        $adminBadge = match ($adminStatus) {
                                            'approved' => 'status-approved',
                                            'rejected' => 'status-rejected',
                                            default => 'status-pending',
                                        };

                                        $adminIcon = match ($adminStatus) {
                                            'approved' => 'bi-check-circle-fill',
                                            'rejected' => 'bi-x-circle-fill',
                                            default => 'bi-hourglass-split',
                                        };

                                        $donorBadge = match ($donorStatus) {
                                            'accepted' => 'status-approved',
                                            'approved' => 'status-approved',
                                            'rejected' => 'status-rejected',
                                            default => 'status-waiting',
                                        };

                                        $donorIcon = match ($donorStatus) {
                                            'accepted' => 'bi-check-circle-fill',
                                            'approved' => 'bi-check-circle-fill',
                                            'rejected' => 'bi-x-circle-fill',
                                            default => 'bi-clock-fill',
                                        };

                                        $donorStatusLabel = match ($donorStatus) {
                                            'accepted' => 'Accepted',
                                            'approved' => 'Approved',
                                            'rejected' => 'Rejected',
                                            default => 'Waiting',
                                        };
                                    @endphp


                                    <tr>

                                        {{-- Request --}}
                                        <td class="px-4">

                                            <div class="request-number">
                                                #{{ $productRequest->id }}
                                            </div>

                                            <small class="text-secondary">
                                                Row {{ $requests->firstItem() + $key }}
                                            </small>

                                        </td>


                                        {{-- Product --}}
                                        <td>

                                            <div class="d-flex align-items-center gap-3 request-product">

                                                <img
                                                    src="{{ $productImage }}"
                                                    alt="{{ $product?->name ?? 'Product' }}"
                                                    width="64"
                                                    height="64"
                                                    class="request-product-image"
                                                >


                                                <div class="min-w-0">

                                                    <div class="fw-semibold text-dark text-truncate request-product-name">
                                                        {{ $product?->name ?? 'Product unavailable' }}
                                                    </div>

                                                    <small class="text-secondary d-block text-truncate">
                                                        {{ $product?->category?->name ?? 'No category' }}
                                                    </small>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- Beneficiary --}}
                                        <td>

                                            @if ($beneficiary)

                                                <div class="person-summary">

                                                    <div class="person-avatar bg-info-subtle text-info-emphasis">
                                                        {{ strtoupper(substr($beneficiary->name, 0, 1)) }}
                                                    </div>

                                                    <div class="min-w-0">

                                                        <div class="fw-semibold text-dark text-truncate">
                                                            {{ $beneficiary->name }}
                                                        </div>

                                                        <small class="text-secondary text-truncate d-block">
                                                            {{ $beneficiary->qalam_id ?? 'No Qalam ID' }}
                                                        </small>

                                                    </div>

                                                </div>

                                            @else

                                                <span class="text-secondary small">
                                                    <i class="bi bi-person-x me-1"></i>
                                                    Unavailable
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Donor --}}
                                        <td>

                                            @if ($donor)

                                                <div class="person-summary">

                                                    <div class="person-avatar bg-primary-subtle text-primary">
                                                        {{ strtoupper(substr($donor->name, 0, 1)) }}
                                                    </div>

                                                    <div class="min-w-0">

                                                        <div class="fw-semibold text-dark text-truncate">
                                                            {{ $donor->name }}
                                                        </div>

                                                        <small class="text-secondary text-truncate d-block">
                                                            {{ $donor->donorProfile?->organization ?? 'Individual Donor' }}
                                                        </small>

                                                    </div>

                                                </div>

                                            @else

                                                <span class="text-secondary small">
                                                    <i class="bi bi-person-x me-1"></i>
                                                    Unavailable
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Admin Status --}}
                                        <td>

                                            <span class="request-status {{ $adminBadge }}">
                                                <i class="bi {{ $adminIcon }}"></i>
                                                {{ ucfirst($adminStatus) }}
                                            </span>

                                        </td>


                                        {{-- Donor Status --}}
                                        <td>

                                            <span class="request-status {{ $donorBadge }}">
                                                <i class="bi {{ $donorIcon }}"></i>
                                                {{ $donorStatusLabel }}
                                            </span>

                                        </td>


                                        {{-- Submitted --}}
                                        <td>

                                            <div class="small fw-semibold text-dark">
                                                {{ optional($productRequest->created_at)->format('d M Y') ?? '—' }}
                                            </div>

                                            <small class="text-secondary">
                                                {{ optional($productRequest->created_at)->format('h:i A') ?? '' }}
                                            </small>

                                        </td>


                                        {{-- Actions --}}
                                        <td class="px-4 text-end">

                                            <div class="d-inline-flex align-items-center gap-2">

                                                {{-- Profile Dropdown --}}
                                                <div class="dropdown">

                                                    <button
                                                        type="button"
                                                        class="btn btn-light border btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                    >
                                                        <i class="bi bi-eye me-1"></i>
                                                        View
                                                    </button>


                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                                                        @if ($beneficiary)

                                                            <li>
                                                                <button
                                                                    type="button"
                                                                    class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#beneficiaryModal{{ $productRequest->id }}"
                                                                >
                                                                    <i class="bi bi-person-vcard text-info me-2"></i>
                                                                    Beneficiary Profile
                                                                </button>
                                                            </li>

                                                        @endif


                                                        @if ($donor)

                                                            <li>
                                                                <button
                                                                    type="button"
                                                                    class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#donorModal{{ $productRequest->id }}"
                                                                >
                                                                    <i class="bi bi-person-heart text-primary me-2"></i>
                                                                    Donor Profile
                                                                </button>
                                                            </li>

                                                        @endif


                                                        @if (!$beneficiary && !$donor)

                                                            <li>
                                                                <span class="dropdown-item-text text-secondary small">
                                                                    No profiles available
                                                                </span>
                                                            </li>

                                                        @endif

                                                    </ul>

                                                </div>


                                                {{-- Approve --}}
                                                <button
                                                    type="button"
                                                    class="btn btn-success btn-sm request-decision-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#requestDecisionModal"
                                                    data-action="{{ route('admin.request.update', $productRequest->id) }}"
                                                    data-status="approved"
                                                    data-request-id="{{ $productRequest->id }}"
                                                    data-product="{{ $product?->name ?? 'this product' }}"
                                                    @disabled($adminStatus === 'approved')
                                                    title="Approve request"
                                                >
                                                    <i class="bi bi-check-lg"></i>
                                                    <span class="d-none d-xxl-inline ms-1">
                                                        Approve
                                                    </span>
                                                </button>


                                                {{-- Reject --}}
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-danger btn-sm request-decision-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#requestDecisionModal"
                                                    data-action="{{ route('admin.request.update', $productRequest->id) }}"
                                                    data-status="rejected"
                                                    data-request-id="{{ $productRequest->id }}"
                                                    data-product="{{ $product?->name ?? 'this product' }}"
                                                    @disabled($adminStatus === 'rejected')
                                                    title="Reject request"
                                                >
                                                    <i class="bi bi-x-lg"></i>
                                                    <span class="d-none d-xxl-inline ms-1">
                                                        Reject
                                                    </span>
                                                </button>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="8"
                                            class="text-center py-5"
                                        >

                                            <div class="empty-state">

                                                <div class="empty-state-icon">
                                                    <i class="bi bi-clipboard-x"></i>
                                                </div>

                                                <h6 class="fw-bold text-dark mb-1">
                                                    No requests found
                                                </h6>

                                                <p class="text-secondary small mb-0">
                                                    Product requests will appear here after beneficiaries submit them.
                                                </p>

                                            </div>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- Pagination --}}
                @if ($requests->hasPages())

                    <div class="card-footer bg-white border-top px-4 py-3">

                        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between gap-3">

                            <p class="text-secondary small mb-0">

                                Showing

                                <span class="fw-semibold text-dark">
                                    {{ $requests->firstItem() }}
                                </span>

                                to

                                <span class="fw-semibold text-dark">
                                    {{ $requests->lastItem() }}
                                </span>

                                of

                                <span class="fw-semibold text-dark">
                                    {{ $requests->total() }}
                                </span>

                                requests

                            </p>


                            <div>
                                {{ $requests->withQueryString()->links() }}
                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </main>

    </div>



    {{-- =============================================================
        BENEFICIARY / DONOR PROFILE MODALS
    ============================================================= --}}
    @foreach ($requests as $productRequest)

        @php
            $beneficiary = $productRequest->beneficiary;
            $donor = $productRequest->donor;

            $beneficiaryProfile =
                $beneficiary?->beneficiaryProfile;

            $donorProfile =
                $donor?->donorProfile;

            $beneficiaryImage =
                $beneficiary && $beneficiary->image
                    ? asset(
                        'admins/asset/profilephoto/' .
                        basename($beneficiary->image)
                    )
                    : asset(
                        'admins/asset/dummy/dummy.jpg'
                    );

            $donorImage =
                $donor && $donor->image
                    ? asset(
                        'admins/asset/profilephoto/' .
                        basename($donor->image)
                    )
                    : asset(
                        'admins/asset/dummy/dummy.jpg'
                    );

            $beneficiaryAccountBadge =
                match ($beneficiary?->account_status) {
                    'active' => 'status-approved',
                    'suspended' => 'status-pending',
                    'blocked' => 'status-rejected',
                    default => 'status-neutral',
                };

            $donorAccountBadge =
                match ($donor?->account_status) {
                    'active' => 'status-approved',
                    'suspended' => 'status-pending',
                    'blocked' => 'status-rejected',
                    default => 'status-neutral',
                };
        @endphp


        {{-- =========================================================
            BENEFICIARY MODAL
        ========================================================== --}}
        @if ($beneficiary)

            <div
                class="modal fade"
                id="beneficiaryModal{{ $productRequest->id }}"
                tabindex="-1"
                aria-labelledby="beneficiaryModalLabel{{ $productRequest->id }}"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                        {{-- Header --}}
                        <div class="modal-header profile-modal-header px-4 py-3">

                            <div>
                                <h5
                                    class="modal-title fw-bold text-dark mb-1"
                                    id="beneficiaryModalLabel{{ $productRequest->id }}"
                                >
                                    Beneficiary Profile
                                </h5>

                                <p class="text-secondary small mb-0">
                                    Review beneficiary information for request #{{ $productRequest->id }}.
                                </p>
                            </div>


                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>

                        </div>


                        {{-- Body --}}
                        <div class="modal-body bg-light p-4">

                            {{-- Profile Summary --}}
                            <div class="card border-0 shadow-sm rounded-4 mb-4">

                                <div class="card-body p-4">

                                    <div class="row align-items-center g-4">

                                        <div class="col-12 col-lg-auto text-center">

                                            <img
                                                src="{{ $beneficiaryImage }}"
                                                alt="{{ $beneficiary->name }}"
                                                width="120"
                                                height="120"
                                                class="rounded-circle border border-4 border-white shadow-sm object-fit-cover"
                                            >

                                        </div>


                                        <div class="col-12 col-lg">

                                            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">

                                                <div>

                                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">

                                                        <h4 class="fw-bold text-dark mb-0">
                                                            {{ $beneficiary->name }}
                                                        </h4>

                                                        <span class="request-status status-waiting">
                                                            Beneficiary
                                                        </span>

                                                        <span class="request-status {{ $beneficiaryAccountBadge }}">
                                                            {{ ucfirst($beneficiary->account_status ?? 'Unknown') }}
                                                        </span>

                                                    </div>


                                                    <p class="text-secondary mb-2">
                                                        <i class="bi bi-envelope me-2"></i>
                                                        {{ $beneficiary->email }}
                                                    </p>

                                                    <p class="text-secondary mb-0">
                                                        <i class="bi bi-telephone me-2"></i>
                                                        {{ $beneficiary->phone ?? 'Phone not available' }}
                                                    </p>

                                                </div>


                                                <div class="text-lg-end">

                                                    <small class="d-block text-secondary mb-1">
                                                        Qalam ID
                                                    </small>

                                                    <span class="fw-bold text-dark">
                                                        {{ $beneficiary->qalam_id ?? 'Not available' }}
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="row g-4">

                                {{-- Account --}}
                                <div class="col-12 col-lg-6">

                                    <div class="profile-detail-card h-100">

                                        <div class="profile-detail-header">

                                            <span class="profile-section-icon bg-primary-subtle text-primary">
                                                <i class="bi bi-person-vcard"></i>
                                            </span>

                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    Account & Personal
                                                </h6>

                                                <small class="text-secondary">
                                                    Basic account details
                                                </small>
                                            </div>

                                        </div>


                                        <div class="profile-info-row">
                                            <span>Full Name</span>
                                            <strong>{{ $beneficiary->name }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Email</span>
                                            <strong class="text-break">{{ $beneficiary->email }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Phone</span>
                                            <strong>{{ $beneficiary->phone ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Gender</span>
                                            <strong class="text-capitalize">
                                                {{ $beneficiaryProfile?->gender ?? 'Not available' }}
                                            </strong>
                                        </div>

                                        <div class="profile-info-row border-bottom-0">
                                            <span>Member Since</span>
                                            <strong>
                                                {{ optional($beneficiary->created_at)->format('d M Y') ?? 'Not available' }}
                                            </strong>
                                        </div>

                                    </div>

                                </div>


                                {{-- Academic --}}
                                <div class="col-12 col-lg-6">

                                    <div class="profile-detail-card h-100">

                                        <div class="profile-detail-header">

                                            <span class="profile-section-icon bg-success-subtle text-success">
                                                <i class="bi bi-mortarboard"></i>
                                            </span>

                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    Academic Information
                                                </h6>

                                                <small class="text-secondary">
                                                    Study and enrollment details
                                                </small>
                                            </div>

                                        </div>


                                        <div class="profile-info-row">
                                            <span>Institution</span>
                                            <strong>{{ $beneficiaryProfile?->institution ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Degree Level</span>
                                            <strong>{{ $beneficiaryProfile?->degree_level ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Degree Program</span>
                                            <strong>{{ $beneficiaryProfile?->degree_program ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Department</span>
                                            <strong>{{ $beneficiaryProfile?->department ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Semester</span>
                                            <strong>{{ $beneficiaryProfile?->semester ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>CGPA</span>
                                            <strong>
                                                @if (!is_null($beneficiaryProfile?->cgpa))
                                                    {{ number_format((float) $beneficiaryProfile->cgpa, 2) }} / 4.00
                                                @else
                                                    Not available
                                                @endif
                                            </strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Enrollment Year</span>
                                            <strong>{{ $beneficiaryProfile?->enrollment_year ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row border-bottom-0">
                                            <span>Graduation Year</span>
                                            <strong>{{ $beneficiaryProfile?->graduation_year ?? 'Not available' }}</strong>
                                        </div>

                                    </div>

                                </div>


                                {{-- Family / Financial --}}
                                <div class="col-12 col-lg-6">

                                    <div class="profile-detail-card h-100">

                                        <div class="profile-detail-header">

                                            <span class="profile-section-icon bg-info-subtle text-info-emphasis">
                                                <i class="bi bi-people"></i>
                                            </span>

                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    Family & Financial
                                                </h6>

                                                <small class="text-secondary">
                                                    Household information
                                                </small>
                                            </div>

                                        </div>


                                        <div class="profile-info-row">
                                            <span>Father Status</span>
                                            <strong>{{ $beneficiaryProfile?->father_status ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Guardian Profession</span>
                                            <strong>{{ $beneficiaryProfile?->guardian_profession ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row border-bottom-0">
                                            <span>Monthly Income</span>
                                            <strong>
                                                @if (!is_null($beneficiaryProfile?->monthly_income))
                                                    PKR {{ number_format((float) $beneficiaryProfile->monthly_income, 2) }}
                                                @else
                                                    Not available
                                                @endif
                                            </strong>
                                        </div>

                                    </div>

                                </div>


                                {{-- Location --}}
                                <div class="col-12 col-lg-6">

                                    <div class="profile-detail-card h-100">

                                        <div class="profile-detail-header">

                                            <span class="profile-section-icon bg-warning-subtle text-warning-emphasis">
                                                <i class="bi bi-geo-alt"></i>
                                            </span>

                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    Location Information
                                                </h6>

                                                <small class="text-secondary">
                                                    Domicile and home address
                                                </small>
                                            </div>

                                        </div>


                                        <div class="profile-info-row">
                                            <span>Province / Territory</span>
                                            <strong>{{ $beneficiaryProfile?->province ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Domicile</span>
                                            <strong>{{ $beneficiaryProfile?->domicile ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-address">
                                            <span>Home Address</span>
                                            <strong>{{ $beneficiaryProfile?->home_address ?? 'Not available' }}</strong>
                                        </div>

                                    </div>

                                </div>


                                {{-- Request Context --}}
                                <div class="col-12">

                                    <div class="profile-detail-card">

                                        <div class="profile-detail-header">

                                            <span class="profile-section-icon bg-secondary-subtle text-secondary">
                                                <i class="bi bi-clipboard-check"></i>
                                            </span>

                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    Request Context
                                                </h6>

                                                <small class="text-secondary">
                                                    Information related to this request
                                                </small>
                                            </div>

                                        </div>


                                        <div class="row g-0">

                                            <div class="col-12 col-md-3 request-context-item">
                                                <span>Request ID</span>
                                                <strong>#{{ $productRequest->id }}</strong>
                                            </div>

                                            <div class="col-12 col-md-3 request-context-item">
                                                <span>Product</span>
                                                <strong>{{ $productRequest->product?->name ?? 'Unavailable' }}</strong>
                                            </div>

                                            <div class="col-12 col-md-3 request-context-item">
                                                <span>Admin Status</span>
                                                <strong class="text-capitalize">{{ $productRequest->admin_status }}</strong>
                                            </div>

                                            <div class="col-12 col-md-3 request-context-item">
                                                <span>Donor Status</span>
                                                <strong class="text-capitalize">{{ $productRequest->donor_status }}</strong>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="modal-footer bg-white border-top px-4 py-3">

                            <button
                                type="button"
                                class="btn btn-light border"
                                data-bs-dismiss="modal"
                            >
                                <i class="bi bi-x-circle me-1"></i>
                                Close
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        @endif



        {{-- =========================================================
            DONOR MODAL
        ========================================================== --}}
        @if ($donor)

            <div
                class="modal fade"
                id="donorModal{{ $productRequest->id }}"
                tabindex="-1"
                aria-labelledby="donorModalLabel{{ $productRequest->id }}"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                        {{-- Header --}}
                        <div class="modal-header profile-modal-header px-4 py-3">

                            <div>
                                <h5
                                    class="modal-title fw-bold text-dark mb-1"
                                    id="donorModalLabel{{ $productRequest->id }}"
                                >
                                    Donor Profile
                                </h5>

                                <p class="text-secondary small mb-0">
                                    Review donor information for request #{{ $productRequest->id }}.
                                </p>
                            </div>


                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>

                        </div>


                        {{-- Body --}}
                        <div class="modal-body bg-light p-4">

                            {{-- Profile Summary --}}
                            <div class="card border-0 shadow-sm rounded-4 mb-4">

                                <div class="card-body p-4">

                                    <div class="row align-items-center g-4">

                                        <div class="col-12 col-lg-auto text-center">

                                            <img
                                                src="{{ $donorImage }}"
                                                alt="{{ $donor->name }}"
                                                width="120"
                                                height="120"
                                                class="rounded-circle border border-4 border-white shadow-sm object-fit-cover"
                                            >

                                        </div>


                                        <div class="col-12 col-lg">

                                            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">

                                                <div>

                                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">

                                                        <h4 class="fw-bold text-dark mb-0">
                                                            {{ $donor->name }}
                                                        </h4>

                                                        <span class="request-status status-neutral">
                                                            Donor
                                                        </span>

                                                        <span class="request-status {{ $donorAccountBadge }}">
                                                            {{ ucfirst($donor->account_status ?? 'Unknown') }}
                                                        </span>

                                                    </div>


                                                    <p class="text-secondary mb-2">
                                                        <i class="bi bi-envelope me-2"></i>
                                                        {{ $donor->email }}
                                                    </p>

                                                    <p class="text-secondary mb-0">
                                                        <i class="bi bi-telephone me-2"></i>
                                                        {{ $donor->phone ?? 'Phone not available' }}
                                                    </p>

                                                </div>


                                                <div class="text-lg-end">

                                                    <small class="d-block text-secondary mb-1">
                                                        Donor ID
                                                    </small>

                                                    <span class="fw-bold text-dark">
                                                        #{{ $donor->id }}
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="row g-4">

                                {{-- Account --}}
                                <div class="col-12 col-lg-6">

                                    <div class="profile-detail-card h-100">

                                        <div class="profile-detail-header">

                                            <span class="profile-section-icon bg-primary-subtle text-primary">
                                                <i class="bi bi-person"></i>
                                            </span>

                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    Account Information
                                                </h6>

                                                <small class="text-secondary">
                                                    Donor account details
                                                </small>
                                            </div>

                                        </div>


                                        <div class="profile-info-row">
                                            <span>Full Name</span>
                                            <strong>{{ $donor->name }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Email</span>
                                            <strong class="text-break">{{ $donor->email }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Phone</span>
                                            <strong>{{ $donor->phone ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Account Status</span>
                                            <strong class="text-capitalize">
                                                {{ $donor->account_status ?? 'Not available' }}
                                            </strong>
                                        </div>

                                        <div class="profile-info-row border-bottom-0">
                                            <span>Member Since</span>
                                            <strong>
                                                {{ optional($donor->created_at)->format('d M Y') ?? 'Not available' }}
                                            </strong>
                                        </div>

                                    </div>

                                </div>


                                {{-- Organization --}}
                                <div class="col-12 col-lg-6">

                                    <div class="profile-detail-card h-100">

                                        <div class="profile-detail-header">

                                            <span class="profile-section-icon bg-success-subtle text-success">
                                                <i class="bi bi-building"></i>
                                            </span>

                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    Organization Information
                                                </h6>

                                                <small class="text-secondary">
                                                    Professional information
                                                </small>
                                            </div>

                                        </div>


                                        <div class="profile-info-row">
                                            <span>Organization</span>
                                            <strong>{{ $donorProfile?->organization ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Designation</span>
                                            <strong>{{ $donorProfile?->designation ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row border-bottom-0">
                                            <span>Country</span>
                                            <strong>{{ $donorProfile?->country ?? 'Not available' }}</strong>
                                        </div>

                                    </div>

                                </div>


                                {{-- Contact --}}
                                <div class="col-12 col-lg-6">

                                    <div class="profile-detail-card h-100">

                                        <div class="profile-detail-header">

                                            <span class="profile-section-icon bg-info-subtle text-info-emphasis">
                                                <i class="bi bi-envelope-paper"></i>
                                            </span>

                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    Contact Information
                                                </h6>

                                                <small class="text-secondary">
                                                    Communication details
                                                </small>
                                            </div>

                                        </div>


                                        <div class="profile-info-row">
                                            <span>Email Address</span>
                                            <strong class="text-break">{{ $donor->email }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Phone Number</span>
                                            <strong>{{ $donor->phone ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-address">
                                            <span>Address</span>
                                            <strong>{{ $donorProfile?->address ?? 'Not available' }}</strong>
                                        </div>

                                    </div>

                                </div>


                                {{-- Request --}}
                                <div class="col-12 col-lg-6">

                                    <div class="profile-detail-card h-100">

                                        <div class="profile-detail-header">

                                            <span class="profile-section-icon bg-warning-subtle text-warning-emphasis">
                                                <i class="bi bi-clipboard-data"></i>
                                            </span>

                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    Request Information
                                                </h6>

                                                <small class="text-secondary">
                                                    Current request state
                                                </small>
                                            </div>

                                        </div>


                                        <div class="profile-info-row">
                                            <span>Request ID</span>
                                            <strong>#{{ $productRequest->id }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Product</span>
                                            <strong>{{ $productRequest->product?->name ?? 'Not available' }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Admin Decision</span>
                                            <strong class="text-capitalize">{{ $productRequest->admin_status }}</strong>
                                        </div>

                                        <div class="profile-info-row">
                                            <span>Donor Decision</span>
                                            <strong class="text-capitalize">{{ $productRequest->donor_status }}</strong>
                                        </div>

                                        <div class="profile-info-row border-bottom-0">
                                            <span>Request Date</span>
                                            <strong>
                                                {{ optional($productRequest->created_at)->format('d M Y') ?? 'Not available' }}
                                            </strong>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="modal-footer bg-white border-top px-4 py-3">

                            <button
                                type="button"
                                class="btn btn-light border"
                                data-bs-dismiss="modal"
                            >
                                <i class="bi bi-x-circle me-1"></i>
                                Close
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        @endif

    @endforeach



    {{-- =============================================================
        REQUEST DECISION MODAL
    ============================================================= --}}
    <div
        class="modal fade"
        id="requestDecisionModal"
        tabindex="-1"
        aria-labelledby="requestDecisionModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <div class="modal-header border-bottom px-4 py-3">

                    <div>

                        <h5
                            class="modal-title fw-bold text-dark mb-1"
                            id="requestDecisionModalLabel"
                        >
                            Confirm Request Decision
                        </h5>

                        <p class="text-secondary small mb-0">
                            Please verify your decision before continuing.
                        </p>

                    </div>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <form
                    method="POST"
                    action=""
                    id="requestDecisionForm"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="admin_status"
                        id="decisionStatus"
                        value=""
                    >


                    <div class="modal-body p-4">

                        <div
                            id="decisionIcon"
                            class="decision-modal-icon mb-3"
                        >
                            <i class="bi bi-question-lg"></i>
                        </div>


                        <h6
                            id="decisionHeading"
                            class="fw-bold text-dark mb-2"
                        >
                            Confirm decision
                        </h6>


                        <p
                            id="decisionText"
                            class="text-secondary mb-0"
                        >
                            Are you sure you want to update this request?
                        </p>


                        <div
                            id="decisionNotice"
                            class="alert alert-light border small mt-3 mb-0"
                        >
                            <i class="bi bi-info-circle me-1"></i>
                            The request status can be changed again later.
                        </div>

                    </div>


                    <div class="modal-footer border-top px-4 py-3">

                        <button
                            type="button"
                            class="btn btn-light border"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>


                        <button
                            type="submit"
                            id="decisionSubmitButton"
                            class="btn btn-primary"
                        >
                            Confirm
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>



    {{-- =============================================================
        PAGE STYLES
    ============================================================= --}}
    <style>

        .request-stat-card {
            display: flex;
            align-items: center;
            gap: 14px;

            padding: 18px;

            background: #ffffff;

            border: 1px solid #edf0f3;
            border-radius: 16px;

            box-shadow: 0 4px 18px rgba(31, 45, 61, 0.05);
        }


        .request-stat-icon {
            width: 50px;
            height: 50px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 14px;

            font-size: 1.25rem;
        }


        .request-stat-label {
            color: #6c757d;

            font-size: 0.82rem;
            font-weight: 500;
        }


        .request-stat-value {
            color: #212529;

            font-size: 1.45rem;
            font-weight: 700;

            line-height: 1.2;

            margin-top: 2px;
        }


        .request-legend {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 6px 10px;

            color: #6c757d;

            background: #f8f9fa;

            border: 1px solid #edf0f3;
            border-radius: 999px;

            font-size: 0.76rem;
            font-weight: 600;
        }


        .request-legend-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;
        }


        .request-table {
            min-width: 1180px;
        }


        .request-table thead th {
            padding-top: 14px;
            padding-bottom: 14px;

            color: #6c757d;

            background: #f8f9fb;

            border-bottom: 1px solid #edf0f3;

            font-size: 0.74rem;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: 0.035em;

            white-space: nowrap;
        }


        .request-table tbody td {
            padding-top: 16px;
            padding-bottom: 16px;

            border-color: #f0f2f4;
        }


        .request-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }


        .request-table tbody tr:hover {
            background: #fbfcfd;
        }


        .request-number {
            color: #212529;

            font-size: 0.9rem;
            font-weight: 700;
        }


        .request-product {
            min-width: 230px;
        }


        .request-product-image {
            flex-shrink: 0;

            border: 1px solid #e6e9ed;
            border-radius: 12px;

            object-fit: cover;

            background: #f8f9fa;
        }


        .request-product-name {
            max-width: 180px;
        }


        .person-summary {
            display: flex;
            align-items: center;
            gap: 10px;

            min-width: 165px;
            max-width: 210px;
        }


        .person-avatar {
            width: 36px;
            height: 36px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 50%;

            font-size: 0.8rem;
            font-weight: 700;
        }


        .min-w-0 {
            min-width: 0;
        }


        .request-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 6px 10px;

            border-radius: 999px;

            font-size: 0.76rem;
            font-weight: 700;

            white-space: nowrap;
        }


        .status-approved {
            color: #137333;
            background: #e8f5e9;
        }


        .status-rejected {
            color: #b3261e;
            background: #fce8e6;
        }


        .status-pending {
            color: #8a5a00;
            background: #fff3cd;
        }


        .status-waiting {
            color: #075985;
            background: #e0f2fe;
        }


        .status-neutral {
            color: #495057;
            background: #eef1f4;
        }


        .empty-state {
            max-width: 420px;

            margin: 0 auto;
        }


        .empty-state-icon {
            width: 64px;
            height: 64px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 14px;

            color: #6c757d;
            background: #f1f3f5;

            border-radius: 50%;

            font-size: 1.7rem;
        }


        .dropdown-menu {
            min-width: 220px;
        }


        .dropdown-item {
            padding-top: 9px;
            padding-bottom: 9px;

            font-size: 0.875rem;
        }


        .modal-xl {
            --bs-modal-width: 1120px;
        }


        .profile-modal-header {
            background: #ffffff;
        }


        .profile-detail-card {
            overflow: hidden;

            background: #ffffff;

            border: 1px solid #edf0f3;
            border-radius: 16px;

            box-shadow: 0 3px 14px rgba(31, 45, 61, 0.04);
        }


        .profile-detail-header {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 16px;

            border-bottom: 1px solid #edf0f3;
        }


        .profile-section-icon {
            width: 40px;
            height: 40px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 12px;
        }


        .profile-info-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;

            padding: 13px 16px;

            border-bottom: 1px solid #edf0f3;
        }


        .profile-info-row > span {
            flex: 0 0 42%;

            color: #6c757d;

            font-size: 0.84rem;
        }


        .profile-info-row > strong {
            flex: 1;

            color: #212529;

            font-size: 0.84rem;
            font-weight: 600;

            text-align: right;

            word-break: break-word;
        }


        .profile-address {
            padding: 16px;
        }


        .profile-address > span {
            display: block;

            color: #6c757d;

            font-size: 0.84rem;

            margin-bottom: 7px;
        }


        .profile-address > strong {
            color: #212529;

            font-size: 0.84rem;
            font-weight: 600;

            line-height: 1.6;
        }


        .request-context-item {
            padding: 16px;

            border-right: 1px solid #edf0f3;
        }


        .request-context-item:last-child {
            border-right: 0;
        }


        .request-context-item > span {
            display: block;

            color: #6c757d;

            font-size: 0.78rem;

            margin-bottom: 4px;
        }


        .request-context-item > strong {
            color: #212529;

            font-size: 0.87rem;
        }


        .decision-modal-icon {
            width: 56px;
            height: 56px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 16px;

            color: #0d6efd;
            background: #e7f1ff;

            font-size: 1.4rem;
        }


        @media (max-width: 767.98px) {

            .request-stat-card {
                padding: 15px;
            }


            .profile-info-row {
                flex-direction: column;

                gap: 4px;
            }


            .profile-info-row > span,
            .profile-info-row > strong {
                flex: 0 0 auto;

                width: 100%;
            }


            .profile-info-row > strong {
                text-align: left;
            }


            .request-context-item {
                border-right: 0;
                border-bottom: 1px solid #edf0f3;
            }


            .request-context-item:last-child {
                border-bottom: 0;
            }


            .modal-body {
                padding: 16px !important;
            }

        }

    </style>



    @include('layouts.admin.script')


    {{-- =============================================================
        PAGE JAVASCRIPT
    ============================================================= --}}
    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const decisionButtons =
                    document.querySelectorAll(
                        '.request-decision-btn'
                    );

                const decisionForm =
                    document.getElementById(
                        'requestDecisionForm'
                    );

                const decisionStatus =
                    document.getElementById(
                        'decisionStatus'
                    );

                const decisionHeading =
                    document.getElementById(
                        'decisionHeading'
                    );

                const decisionText =
                    document.getElementById(
                        'decisionText'
                    );

                const decisionNotice =
                    document.getElementById(
                        'decisionNotice'
                    );

                const decisionIcon =
                    document.getElementById(
                        'decisionIcon'
                    );

                const decisionSubmitButton =
                    document.getElementById(
                        'decisionSubmitButton'
                    );


                decisionButtons.forEach(
                    function (button) {

                        button.addEventListener(
                            'click',
                            function () {

                                if (
                                    !decisionForm ||
                                    !decisionStatus
                                ) {
                                    return;
                                }


                                const action =
                                    this.getAttribute(
                                        'data-action'
                                    );

                                const status =
                                    this.getAttribute(
                                        'data-status'
                                    );

                                const requestId =
                                    this.getAttribute(
                                        'data-request-id'
                                    );

                                const product =
                                    this.getAttribute(
                                        'data-product'
                                    );


                                decisionForm.action =
                                    action;

                                decisionStatus.value =
                                    status;


                                if (
                                    status ===
                                    'approved'
                                ) {

                                    if (decisionHeading) {
                                        decisionHeading.textContent =
                                            'Approve Request #' +
                                            requestId;
                                    }

                                    if (decisionText) {
                                        decisionText.textContent =
                                            'Approve the request for "' +
                                            product +
                                            '" and make it available for donor review?';
                                    }

                                    if (decisionNotice) {
                                        decisionNotice.innerHTML =
                                            '<i class="bi bi-info-circle me-1"></i>' +
                                            'If the donor has not already made a final decision, donor status will remain pending.';
                                    }

                                    if (decisionIcon) {
                                        decisionIcon.className =
                                            'decision-modal-icon mb-3 text-success bg-success-subtle';

                                        decisionIcon.innerHTML =
                                            '<i class="bi bi-check-lg"></i>';
                                    }

                                    if (
                                        decisionSubmitButton
                                    ) {
                                        decisionSubmitButton.className =
                                            'btn btn-success';

                                        decisionSubmitButton.innerHTML =
                                            '<i class="bi bi-check-lg me-1"></i>Approve Request';
                                    }

                                } else {

                                    if (decisionHeading) {
                                        decisionHeading.textContent =
                                            'Reject Request #' +
                                            requestId;
                                    }

                                    if (decisionText) {
                                        decisionText.textContent =
                                            'Reject the request for "' +
                                            product +
                                            '"?';
                                    }

                                    if (decisionNotice) {
                                        decisionNotice.innerHTML =
                                            '<i class="bi bi-exclamation-triangle me-1"></i>' +
                                            'Rejecting this request resets the donor decision to pending.';
                                    }

                                    if (decisionIcon) {
                                        decisionIcon.className =
                                            'decision-modal-icon mb-3 text-danger bg-danger-subtle';

                                        decisionIcon.innerHTML =
                                            '<i class="bi bi-x-lg"></i>';
                                    }

                                    if (
                                        decisionSubmitButton
                                    ) {
                                        decisionSubmitButton.className =
                                            'btn btn-danger';

                                        decisionSubmitButton.innerHTML =
                                            '<i class="bi bi-x-lg me-1"></i>Reject Request';
                                    }

                                }

                            }
                        );

                    }
                );

            }
        );

    </script>

</body>

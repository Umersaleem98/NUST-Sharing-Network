@include('layouts.admin.head')

<title>Incoming Requests</title>

<body>

    @include('layouts.admin.sidebar')

    <div class="nsn-main">

        @include('layouts.admin.header')

        <main class="nsn-content">

            @php
                /*
                |--------------------------------------------------------------------------
                | Current Page Statistics
                |--------------------------------------------------------------------------
                |
                | The paginator knows the total request count across all pages.
                | Status collections below intentionally describe the current page.
                |
                */

                $pagePending = $requests
                    ->filter(fn ($item) => ($item->donor_status ?? 'pending') === 'pending')
                    ->count();

                $pageAccepted = $requests
                    ->filter(
                        fn ($item) => in_array(
                            $item->donor_status,
                            ['approved', 'accepted'],
                            true
                        )
                    )
                    ->count();

                $pageRejected = $requests
                    ->filter(fn ($item) => $item->donor_status === 'rejected')
                    ->count();
            @endphp


            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        Incoming Requests
                    </h3>

                    <p class="text-secondary small mb-0">
                        Review admin-approved beneficiary requests and make your donor decision.
                    </p>
                </div>

                <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                    <i class="bi bi-inbox me-1"></i>
                    {{ number_format($requests->total()) }}
                    {{ $requests->total() === 1 ? 'request' : 'requests' }}
                </span>

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
                        Incoming Requests
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
                    class="alert alert-danger alert-dismissible fade show mb-4"
                    role="alert"
                >
                    <div class="d-flex gap-3">

                        <i class="bi bi-exclamation-triangle-fill mt-1"></i>

                        <div>
                            <h6 class="fw-semibold mb-2">
                                Please correct the following:
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
                REQUEST SUMMARY
            ========================================================== --}}
            <div class="row g-3 mb-4">

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">

                            <div class="d-flex align-items-center justify-content-between gap-3">

                                <div>
                                    <p class="text-secondary small mb-1">
                                        Total Requests
                                    </p>

                                    <h3 class="fw-bold text-dark mb-0">
                                        {{ number_format($requests->total()) }}
                                    </h3>
                                </div>

                                <span class="request-stat-icon bg-primary-subtle text-primary">
                                    <i class="bi bi-inbox"></i>
                                </span>

                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">

                            <div class="d-flex align-items-center justify-content-between gap-3">

                                <div>
                                    <p class="text-secondary small mb-1">
                                        Pending on Page
                                    </p>

                                    <h3 class="fw-bold text-warning-emphasis mb-0">
                                        {{ $pagePending }}
                                    </h3>
                                </div>

                                <span class="request-stat-icon bg-warning-subtle text-warning-emphasis">
                                    <i class="bi bi-hourglass-split"></i>
                                </span>

                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">

                            <div class="d-flex align-items-center justify-content-between gap-3">

                                <div>
                                    <p class="text-secondary small mb-1">
                                        Accepted on Page
                                    </p>

                                    <h3 class="fw-bold text-success mb-0">
                                        {{ $pageAccepted }}
                                    </h3>
                                </div>

                                <span class="request-stat-icon bg-success-subtle text-success">
                                    <i class="bi bi-check-circle"></i>
                                </span>

                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">

                            <div class="d-flex align-items-center justify-content-between gap-3">

                                <div>
                                    <p class="text-secondary small mb-1">
                                        Rejected on Page
                                    </p>

                                    <h3 class="fw-bold text-danger mb-0">
                                        {{ $pageRejected }}
                                    </h3>
                                </div>

                                <span class="request-stat-icon bg-danger-subtle text-danger">
                                    <i class="bi bi-x-circle"></i>
                                </span>

                            </div>

                        </div>
                    </div>
                </div>

            </div>


            {{-- =========================================================
                REQUEST QUEUE
            ========================================================== --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <div class="card-header bg-white border-bottom px-4 py-3">

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                        <div>
                            <h5 class="fw-semibold text-dark mb-1">
                                Beneficiary Request Queue
                            </h5>

                            <p class="text-secondary small mb-0">
                                Review the beneficiary profile, make your decision, and control when your donor information becomes visible.
                            </p>
                        </div>

                        <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                            <i class="bi bi-shield-check me-1 text-success"></i>
                            Admin approved requests only
                        </span>

                    </div>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0 request-table">

                            <thead class="table-light">

                                <tr>
                                    <th class="px-4 py-3 text-secondary small">
                                        #
                                    </th>

                                    <th class="py-3 text-secondary small">
                                        Product
                                    </th>

                                    <th class="py-3 text-secondary small">
                                        Beneficiary
                                    </th>

                                    <th class="py-3 text-secondary small">
                                        Your Decision
                                    </th>

                                    <th class="py-3 text-secondary small">
                                        Message
                                    </th>

                                    <th class="py-3 text-secondary small">
                                        Information Access
                                    </th>

                                    <th class="py-3 text-secondary small">
                                        Requested
                                    </th>

                                    <th class="px-4 py-3 text-secondary small text-end">
                                        Actions
                                    </th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($requests as $key => $productRequest)

                                    @php
                                        $product =
                                            $productRequest->product;

                                        $beneficiary =
                                            $productRequest->beneficiary;


                                        /*
                                        |--------------------------------------------------------------------------
                                        | Product Image
                                        |--------------------------------------------------------------------------
                                        */

                                        $productImages = [];

                                        if ($product) {
                                            $productImages =
                                                is_array($product->images)
                                                    ? $product->images
                                                    : json_decode(
                                                        $product->images,
                                                        true
                                                    );

                                            $productImages =
                                                is_array($productImages)
                                                    ? $productImages
                                                    : [];
                                        }

                                        $productImage =
                                            ! empty($productImages)
                                                ? asset(
                                                    'admins/products/'
                                                    . basename($productImages[0])
                                                )
                                                : asset(
                                                    'admins/asset/dummy/dummy.jpg'
                                                );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | Beneficiary Image
                                        |--------------------------------------------------------------------------
                                        */

                                        $beneficiaryImage =
                                            $beneficiary
                                            && $beneficiary->image
                                                ? asset(
                                                    'admins/asset/profilephoto/'
                                                    . basename($beneficiary->image)
                                                )
                                                : null;


                                        /*
                                        |--------------------------------------------------------------------------
                                        | Donor Decision
                                        |--------------------------------------------------------------------------
                                        */

                                        $isAccepted =
                                            in_array(
                                                $productRequest->donor_status,
                                                [
                                                    'approved',
                                                    'accepted',
                                                ],
                                                true
                                            );

                                        $isRejected =
                                            $productRequest->donor_status ===
                                            'rejected';

                                        $isPending =
                                            ! $isAccepted
                                            && ! $isRejected;

                                        $informationAllowed =
                                            (bool) (
                                                $productRequest->donor_information_allowed
                                                ?? false
                                            );

                                        $statusBadge =
                                            $isAccepted
                                                ? 'bg-success-subtle text-success'
                                                : (
                                                    $isRejected
                                                        ? 'bg-danger-subtle text-danger'
                                                        : 'bg-warning-subtle text-warning-emphasis'
                                                );

                                        $statusLabel =
                                            $isAccepted
                                                ? 'Accepted'
                                                : (
                                                    $isRejected
                                                        ? 'Rejected'
                                                        : 'Pending'
                                                );

                                        $statusIcon =
                                            $isAccepted
                                                ? 'bi-check-circle'
                                                : (
                                                    $isRejected
                                                        ? 'bi-x-circle'
                                                        : 'bi-hourglass-split'
                                                );
                                    @endphp


                                    <tr>

                                        {{-- Row Number --}}
                                        <td class="px-4">
                                            <span class="text-secondary small">
                                                {{ $requests->firstItem() + $key }}
                                            </span>
                                        </td>


                                        {{-- Product --}}
                                        <td>
                                            <div class="d-flex align-items-center gap-3 product-cell">

                                                <img
                                                    src="{{ $productImage }}"
                                                    alt="{{ $product->name ?? 'Product' }}"
                                                    width="58"
                                                    height="58"
                                                    class="rounded-3 border object-fit-cover flex-shrink-0"
                                                >

                                                <div class="min-width-0">

                                                    <div class="fw-semibold text-dark text-truncate request-product-name">
                                                        {{ $product->name ?? 'Product unavailable' }}
                                                    </div>

                                                    <small class="text-secondary">
                                                        Request #{{ $productRequest->id }}
                                                    </small>

                                                </div>

                                            </div>
                                        </td>


                                        {{-- Beneficiary --}}
                                        <td>

                                            @if ($beneficiary)

                                                <div class="d-flex align-items-center gap-2">

                                                    @if ($beneficiaryImage)

                                                        <img
                                                            src="{{ $beneficiaryImage }}"
                                                            alt="{{ $beneficiary->name }}"
                                                            width="42"
                                                            height="42"
                                                            class="rounded-circle border object-fit-cover flex-shrink-0"
                                                        >

                                                    @else

                                                        <span
                                                            class="d-inline-flex align-items-center justify-content-center rounded-circle bg-info-subtle text-info-emphasis fw-semibold flex-shrink-0"
                                                            style="width:42px;height:42px;"
                                                        >
                                                            {{ strtoupper(substr($beneficiary->name, 0, 1)) }}
                                                        </span>

                                                    @endif


                                                    <div class="min-width-0">

                                                        <div class="fw-semibold text-dark small text-truncate beneficiary-name">
                                                            {{ $beneficiary->name }}
                                                        </div>

                                                        <small class="text-secondary d-block">
                                                            {{ $beneficiary->qalam_id ?? 'No Qalam ID' }}
                                                        </small>

                                                    </div>

                                                </div>

                                            @else

                                                <span class="text-secondary small">
                                                    Beneficiary unavailable
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Donor Decision --}}
                                        <td>

                                            <span class="badge rounded-pill {{ $statusBadge }} px-3 py-2">
                                                <i class="bi {{ $statusIcon }} me-1"></i>
                                                {{ $statusLabel }}
                                            </span>

                                            @if ($isPending)
                                                <small class="d-block text-secondary mt-1">
                                                    Awaiting your decision
                                                </small>
                                            @endif

                                        </td>


                                        {{-- Message --}}
                                        <td>

                                            @if ($productRequest->message)

                                                <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                                    <i class="bi bi-chat-left-text me-1"></i>
                                                    Added
                                                </span>

                                            @else

                                                <span class="badge rounded-pill bg-light text-secondary border px-3 py-2">
                                                    <i class="bi bi-chat me-1"></i>
                                                    None
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Information Access --}}
                                        <td>

                                            @if ($isAccepted)

                                                <form
                                                    method="POST"
                                                    action="{{ route('donor.request.update', $productRequest->id) }}"
                                                    class="d-inline"
                                                >
                                                    @csrf

                                                    <input
                                                        type="hidden"
                                                        name="donor_information_allowed"
                                                        value="{{ $informationAllowed ? 0 : 1 }}"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm {{ $informationAllowed ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                        onclick="return confirm('{{ $informationAllowed ? 'Revoke beneficiary access to your donor information?' : 'Allow this beneficiary to view your donor information?' }}');"
                                                    >
                                                        @if ($informationAllowed)
                                                            <i class="bi bi-lock me-1"></i>
                                                            Revoke Access
                                                        @else
                                                            <i class="bi bi-unlock me-1"></i>
                                                            Allow Access
                                                        @endif
                                                    </button>

                                                </form>


                                                @if ($informationAllowed)

                                                    <small class="d-block text-success mt-1">
                                                        <i class="bi bi-eye me-1"></i>
                                                        Information visible
                                                    </small>

                                                @else

                                                    <small class="d-block text-secondary mt-1">
                                                        <i class="bi bi-eye-slash me-1"></i>
                                                        Information private
                                                    </small>

                                                @endif

                                            @else

                                                <button
                                                    type="button"
                                                    class="btn btn-light border btn-sm text-secondary"
                                                    disabled
                                                >
                                                    <i class="bi bi-lock me-1"></i>
                                                    Locked
                                                </button>

                                                <small class="d-block text-secondary mt-1">
                                                    Accept request first
                                                </small>

                                            @endif

                                        </td>


                                        {{-- Requested --}}
                                        <td>

                                            <div class="small text-dark">
                                                <i class="bi bi-calendar3 text-secondary me-1"></i>

                                                {{
                                                    optional(
                                                        $productRequest->created_at
                                                    )->format('d M Y')
                                                    ?? '—'
                                                }}
                                            </div>

                                            <small class="text-secondary">
                                                {{
                                                    optional(
                                                        $productRequest->created_at
                                                    )->diffForHumans()
                                                    ?? ''
                                                }}
                                            </small>

                                        </td>


                                        {{-- Actions --}}
                                        <td class="px-4 text-end">

                                            <div class="d-flex flex-wrap justify-content-end gap-2">

                                                {{-- More / Review --}}
                                                <div class="dropdown">

                                                    <button
                                                        type="button"
                                                        class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                    >
                                                        <i class="bi bi-eye me-1"></i>
                                                        Review
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                                                        @if ($beneficiary)

                                                            <li>
                                                                <button
                                                                    type="button"
                                                                    class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#beneficiaryModal{{ $productRequest->id }}"
                                                                >
                                                                    <i class="bi bi-person-vcard me-2"></i>
                                                                    Beneficiary Profile
                                                                </button>
                                                            </li>

                                                        @endif


                                                        <li>
                                                            <button
                                                                type="button"
                                                                class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#messageModal{{ $productRequest->id }}"
                                                            >
                                                                <i class="bi bi-chat-dots me-2"></i>

                                                                {{
                                                                    $productRequest->message
                                                                        ? 'Edit Message'
                                                                        : 'Add Message'
                                                                }}
                                                            </button>
                                                        </li>

                                                    </ul>

                                                </div>


                                                {{-- Accept --}}
                                                <button
                                                    type="button"
                                                    class="btn btn-sm {{ $isAccepted ? 'btn-secondary' : 'btn-success' }} donor-decision-button"
                                                    data-action="{{ route('donor.request.update', $productRequest->id) }}"
                                                    data-status="approved"
                                                    data-request-id="{{ $productRequest->id }}"
                                                    data-beneficiary="{{ $beneficiary?->name ?? 'this beneficiary' }}"
                                                    data-product="{{ $product?->name ?? 'this product' }}"
                                                    @disabled($isAccepted)
                                                >
                                                    <i class="bi bi-check-lg me-1"></i>
                                                    {{ $isAccepted ? 'Accepted' : 'Accept' }}
                                                </button>


                                                {{-- Reject --}}
                                                <button
                                                    type="button"
                                                    class="btn btn-sm {{ $isRejected ? 'btn-secondary' : 'btn-danger' }} donor-decision-button"
                                                    data-action="{{ route('donor.request.update', $productRequest->id) }}"
                                                    data-status="rejected"
                                                    data-request-id="{{ $productRequest->id }}"
                                                    data-beneficiary="{{ $beneficiary?->name ?? 'this beneficiary' }}"
                                                    data-product="{{ $product?->name ?? 'this product' }}"
                                                    @disabled($isRejected)
                                                >
                                                    <i class="bi bi-x-lg me-1"></i>
                                                    {{ $isRejected ? 'Rejected' : 'Reject' }}
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

                                            <div class="d-flex flex-column align-items-center">

                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-secondary mb-3"
                                                    style="width:72px;height:72px;"
                                                >
                                                    <i class="bi bi-inbox fs-2"></i>
                                                </span>

                                                <h6 class="fw-semibold text-dark mb-1">
                                                    No incoming requests
                                                </h6>

                                                <p class="text-secondary small mb-0">
                                                    Beneficiary requests will appear here after administrator approval.
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

                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">

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
        REQUEST-SPECIFIC MODALS
    ============================================================== --}}
    @foreach ($requests as $productRequest)

        @php
            $beneficiary =
                $productRequest->beneficiary;

            $beneficiaryProfile =
                $beneficiary?->beneficiaryProfile;

            $beneficiaryImage =
                $beneficiary
                && $beneficiary->image
                    ? asset(
                        'admins/asset/profilephoto/'
                        . basename($beneficiary->image)
                    )
                    : asset(
                        'admins/asset/dummy/dummy.jpg'
                    );


            /*
            |--------------------------------------------------------------------------
            | Account Status
            |--------------------------------------------------------------------------
            */

            $accountStatusBadge =
                match (
                    $beneficiary?->account_status
                ) {
                    'active' =>
                        'bg-success-subtle text-success',

                    'suspended' =>
                        'bg-warning-subtle text-warning-emphasis',

                    'blocked' =>
                        'bg-danger-subtle text-danger',

                    default =>
                        'bg-secondary-subtle text-secondary',
                };


            /*
            |--------------------------------------------------------------------------
            | Profile Completion
            |--------------------------------------------------------------------------
            */

            $profileFields = [
                $beneficiary?->name,
                $beneficiary?->email,
                $beneficiary?->phone,
                $beneficiary?->qalam_id,
                $beneficiaryProfile?->gender,
                $beneficiaryProfile?->institution,
                $beneficiaryProfile?->degree_level,
                $beneficiaryProfile?->degree_program,
                $beneficiaryProfile?->department,
                $beneficiaryProfile?->semester,
                $beneficiaryProfile?->cgpa,
                $beneficiaryProfile?->enrollment_year,
                $beneficiaryProfile?->graduation_year,
                $beneficiaryProfile?->father_status,
                $beneficiaryProfile?->guardian_profession,
                $beneficiaryProfile?->monthly_income,
                $beneficiaryProfile?->province,
                $beneficiaryProfile?->domicile,
                $beneficiaryProfile?->home_address,
            ];

            $completedProfileFields =
                collect($profileFields)
                    ->filter(
                        fn ($field) =>
                            ! is_null($field)
                            && trim((string) $field) !== ''
                    )
                    ->count();

            $profileCompletion =
                count($profileFields) > 0
                    ? (int) round(
                        (
                            $completedProfileFields
                            / count($profileFields)
                        ) * 100
                    )
                    : 0;
        @endphp


        {{-- =========================================================
            BENEFICIARY PROFILE MODAL
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
                        <div class="modal-header bg-white border-bottom px-4 py-3">

                            <div>

                                <h5
                                    class="modal-title fw-bold text-dark mb-1"
                                    id="beneficiaryModalLabel{{ $productRequest->id }}"
                                >
                                    Beneficiary Profile
                                </h5>

                                <p class="text-secondary small mb-0">
                                    Review beneficiary information for Request #{{ $productRequest->id }}.
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

                            {{-- Profile Overview --}}
                            <div class="card border-0 shadow-sm rounded-4 mb-4">

                                <div class="card-body p-4">

                                    <div class="row align-items-center g-4">

                                        <div class="col-12 col-lg-auto text-center">

                                            <img
                                                src="{{ $beneficiaryImage }}"
                                                alt="{{ $beneficiary->name }}"
                                                width="125"
                                                height="125"
                                                class="rounded-circle border border-4 border-white shadow-sm object-fit-cover"
                                            >

                                        </div>


                                        <div class="col-12 col-lg">

                                            <div class="d-flex flex-column flex-lg-row justify-content-between gap-4">

                                                <div>

                                                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">

                                                        <h4 class="fw-bold text-dark mb-0">
                                                            {{ $beneficiary->name }}
                                                        </h4>

                                                        <span class="badge rounded-pill bg-info-subtle text-info-emphasis px-3 py-2">
                                                            <i class="bi bi-mortarboard me-1"></i>
                                                            Beneficiary
                                                        </span>

                                                        <span class="badge rounded-pill {{ $accountStatusBadge }} px-3 py-2">
                                                            {{
                                                                ucfirst(
                                                                    $beneficiary->account_status
                                                                    ?? 'Unknown'
                                                                )
                                                            }}
                                                        </span>

                                                    </div>


                                                    <p class="text-secondary mb-2">
                                                        <i class="bi bi-envelope me-2"></i>
                                                        {{ $beneficiary->email }}
                                                    </p>

                                                    <p class="text-secondary mb-0">
                                                        <i class="bi bi-telephone me-2"></i>
                                                        {{ $beneficiary->phone ?? 'Phone number not available' }}
                                                    </p>

                                                </div>


                                                <div class="text-lg-end">

                                                    <small class="d-block text-secondary mb-1">
                                                        Request
                                                    </small>

                                                    <span class="fw-bold text-dark d-block mb-2">
                                                        #{{ $productRequest->id }}
                                                    </span>

                                                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                                        {{ $productRequest->product?->name ?? 'Product unavailable' }}
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    {{-- Profile Completion --}}
                                    <div class="border-top mt-4 pt-4">

                                        <div class="d-flex align-items-center justify-content-between gap-3 mb-2">

                                            <span class="small text-secondary">
                                                Profile Information Completion
                                            </span>

                                            <strong class="small">
                                                {{ $profileCompletion }}%
                                            </strong>

                                        </div>

                                        <div
                                            class="progress"
                                            role="progressbar"
                                            aria-valuenow="{{ $profileCompletion }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            style="height:8px;"
                                        >
                                            <div
                                                class="progress-bar {{ $profileCompletion >= 85 ? 'bg-success' : 'bg-warning' }}"
                                                style="width: {{ $profileCompletion }}%;"
                                            ></div>
                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="row g-4">

                                {{-- Personal / Account --}}
                                <div class="col-12 col-lg-6">

                                    <div class="card border-0 shadow-sm rounded-4 h-100">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="modal-section-icon bg-primary-subtle text-primary">
                                                    <i class="bi bi-person-vcard"></i>
                                                </span>

                                                <div>
                                                    <h6 class="fw-bold text-dark mb-1">
                                                        Personal & Account
                                                    </h6>

                                                    <p class="text-secondary small mb-0">
                                                        Identity and account details.
                                                    </p>
                                                </div>

                                            </div>

                                        </div>


                                        <div class="card-body p-0">

                                            <div class="beneficiary-info-row">
                                                <span>Full Name</span>
                                                <strong>{{ $beneficiary->name }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Email Address</span>
                                                <strong class="text-break">{{ $beneficiary->email }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Phone Number</span>
                                                <strong>{{ $beneficiary->phone ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Qalam ID</span>
                                                <strong>{{ $beneficiary->qalam_id ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Gender</span>
                                                <strong class="text-capitalize">
                                                    {{ $beneficiaryProfile?->gender ?? 'Not available' }}
                                                </strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Account Status</span>
                                                <strong class="text-capitalize">
                                                    {{ $beneficiary->account_status ?? 'Not available' }}
                                                </strong>
                                            </div>

                                            <div class="beneficiary-info-row border-bottom-0">
                                                <span>Member Since</span>
                                                <strong>
                                                    {{
                                                        optional(
                                                            $beneficiary->created_at
                                                        )->format('d M Y')
                                                        ?? 'Not available'
                                                    }}
                                                </strong>
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Academic --}}
                                <div class="col-12 col-lg-6">

                                    <div class="card border-0 shadow-sm rounded-4 h-100">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="modal-section-icon bg-success-subtle text-success">
                                                    <i class="bi bi-mortarboard"></i>
                                                </span>

                                                <div>
                                                    <h6 class="fw-bold text-dark mb-1">
                                                        Academic Information
                                                    </h6>

                                                    <p class="text-secondary small mb-0">
                                                        Institution and academic progress.
                                                    </p>
                                                </div>

                                            </div>

                                        </div>


                                        <div class="card-body p-0">

                                            <div class="beneficiary-info-row">
                                                <span>Institution</span>
                                                <strong>{{ $beneficiaryProfile?->institution ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Degree Level</span>
                                                <strong>{{ $beneficiaryProfile?->degree_level ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Degree Program</span>
                                                <strong>{{ $beneficiaryProfile?->degree_program ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Department</span>
                                                <strong>{{ $beneficiaryProfile?->department ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Current Semester</span>
                                                <strong>{{ $beneficiaryProfile?->semester ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>CGPA</span>
                                                <strong>
                                                    @if (! is_null($beneficiaryProfile?->cgpa))
                                                        {{ number_format((float) $beneficiaryProfile->cgpa, 2) }} / 4.00
                                                    @else
                                                        Not available
                                                    @endif
                                                </strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Enrollment Year</span>
                                                <strong>{{ $beneficiaryProfile?->enrollment_year ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row border-bottom-0">
                                                <span>Expected Graduation</span>
                                                <strong>{{ $beneficiaryProfile?->graduation_year ?? 'Not available' }}</strong>
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Family / Financial --}}
                                <div class="col-12 col-lg-6">

                                    <div class="card border-0 shadow-sm rounded-4 h-100">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="modal-section-icon bg-info-subtle text-info-emphasis">
                                                    <i class="bi bi-people"></i>
                                                </span>

                                                <div>
                                                    <h6 class="fw-bold text-dark mb-1">
                                                        Family & Financial
                                                    </h6>

                                                    <p class="text-secondary small mb-0">
                                                        Household and guardian information.
                                                    </p>
                                                </div>

                                            </div>

                                        </div>


                                        <div class="card-body p-0">

                                            <div class="beneficiary-info-row">
                                                <span>Father Status</span>
                                                <strong>{{ $beneficiaryProfile?->father_status ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Guardian Profession</span>
                                                <strong>{{ $beneficiaryProfile?->guardian_profession ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row border-bottom-0">
                                                <span>Monthly Household Income</span>

                                                <strong>
                                                    @if (! is_null($beneficiaryProfile?->monthly_income))
                                                        PKR {{ number_format((float) $beneficiaryProfile->monthly_income, 2) }}
                                                    @else
                                                        Not available
                                                    @endif
                                                </strong>
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Location --}}
                                <div class="col-12 col-lg-6">

                                    <div class="card border-0 shadow-sm rounded-4 h-100">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="modal-section-icon bg-warning-subtle text-warning-emphasis">
                                                    <i class="bi bi-geo-alt"></i>
                                                </span>

                                                <div>
                                                    <h6 class="fw-bold text-dark mb-1">
                                                        Location Information
                                                    </h6>

                                                    <p class="text-secondary small mb-0">
                                                        Province, domicile and address.
                                                    </p>
                                                </div>

                                            </div>

                                        </div>


                                        <div class="card-body p-0">

                                            <div class="beneficiary-info-row">
                                                <span>Province / Territory</span>
                                                <strong>{{ $beneficiaryProfile?->province ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="beneficiary-info-row">
                                                <span>Domicile</span>
                                                <strong>{{ $beneficiaryProfile?->domicile ?? 'Not available' }}</strong>
                                            </div>

                                            <div class="p-3">
                                                <span class="d-block text-secondary small mb-2">
                                                    Permanent Home Address
                                                </span>

                                                <div class="fw-semibold text-dark small lh-lg">
                                                    {{ $beneficiaryProfile?->home_address ?? 'Not available' }}
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Request Information --}}
                                <div class="col-12">

                                    <div class="card border-0 shadow-sm rounded-4">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="modal-section-icon bg-secondary-subtle text-secondary">
                                                    <i class="bi bi-clipboard-check"></i>
                                                </span>

                                                <div>
                                                    <h6 class="fw-bold text-dark mb-1">
                                                        Request Information
                                                    </h6>

                                                    <p class="text-secondary small mb-0">
                                                        Details related to this beneficiary request.
                                                    </p>
                                                </div>

                                            </div>

                                        </div>


                                        <div class="card-body">

                                            <div class="row g-4">

                                                <div class="col-12 col-sm-6 col-lg-3">
                                                    <small class="d-block text-secondary mb-1">
                                                        Request ID
                                                    </small>

                                                    <strong>
                                                        #{{ $productRequest->id }}
                                                    </strong>
                                                </div>


                                                <div class="col-12 col-sm-6 col-lg-3">
                                                    <small class="d-block text-secondary mb-1">
                                                        Product
                                                    </small>

                                                    <strong>
                                                        {{ $productRequest->product?->name ?? 'Not available' }}
                                                    </strong>
                                                </div>


                                                <div class="col-12 col-sm-6 col-lg-3">
                                                    <small class="d-block text-secondary mb-1">
                                                        Admin Status
                                                    </small>

                                                    <strong class="text-capitalize">
                                                        {{ $productRequest->admin_status ?? 'Not available' }}
                                                    </strong>
                                                </div>


                                                <div class="col-12 col-sm-6 col-lg-3">
                                                    <small class="d-block text-secondary mb-1">
                                                        Your Decision
                                                    </small>

                                                    <strong>
                                                        {{
                                                            in_array(
                                                                $productRequest->donor_status,
                                                                ['approved', 'accepted'],
                                                                true
                                                            )
                                                                ? 'Accepted'
                                                                : (
                                                                    $productRequest->donor_status === 'rejected'
                                                                        ? 'Rejected'
                                                                        : 'Pending'
                                                                )
                                                        }}
                                                    </strong>
                                                </div>


                                                <div class="col-12 col-md-6">
                                                    <small class="d-block text-secondary mb-1">
                                                        Beneficiary Access
                                                    </small>

                                                    <strong class="{{ ($productRequest->donor_information_allowed ?? false) ? 'text-success' : 'text-secondary' }}">
                                                        {{
                                                            ($productRequest->donor_information_allowed ?? false)
                                                                ? 'Allowed'
                                                                : 'Private'
                                                        }}
                                                    </strong>
                                                </div>


                                                <div class="col-12 col-md-6">
                                                    <small class="d-block text-secondary mb-1">
                                                        Requested On
                                                    </small>

                                                    <strong>
                                                        {{
                                                            optional(
                                                                $productRequest->created_at
                                                            )->format('d M Y, h:i A')
                                                            ?? 'Not available'
                                                        }}
                                                    </strong>
                                                </div>


                                                <div class="col-12 col-md-6">
                                                    <small class="d-block text-secondary mb-1">
                                                        Donor
                                                    </small>

                                                    <strong>
                                                        {{ $productRequest->donor?->name ?? 'Not available' }}
                                                    </strong>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Existing Message --}}
                                @if ($productRequest->message)

                                    <div class="col-12">

                                        <div class="card border-0 shadow-sm rounded-4">

                                            <div class="card-header bg-white border-bottom px-4 py-3">

                                                <div class="d-flex align-items-center gap-3">

                                                    <span class="modal-section-icon bg-primary-subtle text-primary">
                                                        <i class="bi bi-chat-left-text"></i>
                                                    </span>

                                                    <div>
                                                        <h6 class="fw-bold text-dark mb-1">
                                                            Donor Message
                                                        </h6>

                                                        <p class="text-secondary small mb-0">
                                                            Message currently attached to this request.
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="card-body">
                                                <div class="p-3 rounded-3 bg-light border">
                                                    <p class="mb-0 text-dark">
                                                        {{ $productRequest->message }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="modal-footer bg-white border-top px-4 py-3">

                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 w-100">

                                <small class="text-secondary">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Review the profile before making a final decision.
                                </small>

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

            </div>

        @endif


        {{-- =========================================================
            MESSAGE MODAL
        ========================================================== --}}
        <div
            class="modal fade"
            id="messageModal{{ $productRequest->id }}"
            tabindex="-1"
            aria-labelledby="messageModalLabel{{ $productRequest->id }}"
            aria-hidden="true"
        >

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow rounded-4 overflow-hidden">

                    <form
                        method="POST"
                        action="{{ route('donor.request.update', $productRequest->id) }}"
                    >
                        @csrf

                        <div class="modal-header border-bottom px-4 py-3">

                            <div>

                                <h5
                                    class="modal-title fw-bold text-dark"
                                    id="messageModalLabel{{ $productRequest->id }}"
                                >
                                    {{
                                        $productRequest->message
                                            ? 'Update Message'
                                            : 'Add Message'
                                    }}
                                </h5>

                                <p class="text-secondary small mb-0 mt-1">
                                    @if ($beneficiary)
                                        Add information for {{ $beneficiary->name }} about this request.
                                    @else
                                        Add information to this request.
                                    @endif
                                </p>

                            </div>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>

                        </div>


                        <div class="modal-body p-4">

                            <div class="alert alert-light border small">
                                <i class="bi bi-info-circle me-1 text-primary"></i>
                                This message can contain collection instructions, availability details or other relevant information.
                            </div>


                            <label
                                for="message{{ $productRequest->id }}"
                                class="form-label fw-semibold"
                            >
                                Message
                            </label>

                            <textarea
                                name="message"
                                id="message{{ $productRequest->id }}"
                                rows="6"
                                maxlength="1000"
                                class="form-control"
                                placeholder="Write your message..."
                            >{{ $productRequest->message }}</textarea>

                            <div class="d-flex justify-content-between gap-3 mt-2">
                                <div class="form-text">
                                    Maximum 1000 characters.
                                </div>

                                <small
                                    class="text-secondary message-character-count"
                                    data-target="message{{ $productRequest->id }}"
                                >
                                    0 / 1000
                                </small>
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
                                class="btn btn-primary"
                            >
                                <i class="bi bi-save me-1"></i>
                                Save Message
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endforeach


    {{-- =============================================================
        DONOR DECISION CONFIRMATION MODAL
    ============================================================== --}}
    <div
        class="modal fade"
        id="donorDecisionModal"
        tabindex="-1"
        aria-labelledby="donorDecisionModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <form
                    method="POST"
                    id="donorDecisionForm"
                    action=""
                >
                    @csrf

                    <input
                        type="hidden"
                        name="donor_status"
                        id="donorDecisionStatus"
                        value=""
                    >


                    <div class="modal-header border-bottom px-4 py-3">

                        <div class="d-flex align-items-center gap-3">

                            <span
                                id="donorDecisionIconWrapper"
                                class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                                style="width:46px;height:46px;"
                            >
                                <i
                                    id="donorDecisionIcon"
                                    class="bi"
                                ></i>
                            </span>

                            <div>
                                <h5
                                    id="donorDecisionModalLabel"
                                    class="modal-title fw-bold text-dark mb-1"
                                >
                                    Confirm Decision
                                </h5>

                                <p
                                    id="donorDecisionSubtitle"
                                    class="text-secondary small mb-0"
                                ></p>
                            </div>

                        </div>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>


                    <div class="modal-body p-4">

                        <div
                            id="donorDecisionMessage"
                            class="alert mb-0"
                        ></div>

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
                            id="donorDecisionSubmit"
                            class="btn"
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
    ============================================================== --}}
    <style>

        .request-stat-icon,
        .modal-section-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            font-size: 1.1rem;
        }


        .request-table th {
            white-space: nowrap;
            font-weight: 600;
        }


        .request-table td {
            vertical-align: middle;
        }


        .min-width-0 {
            min-width: 0;
        }


        .request-product-name {
            max-width: 220px;
        }


        .beneficiary-name {
            max-width: 190px;
        }


        .object-fit-cover {
            object-fit: cover;
        }


        .modal-xl {
            --bs-modal-width: 1140px;
        }


        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 40px);
        }


        .beneficiary-info-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            padding: 14px 18px;
            border-bottom: 1px solid #e9ecef;
        }


        .beneficiary-info-row > span {
            flex: 0 0 42%;
            color: #6c757d;
            font-size: 0.875rem;
        }


        .beneficiary-info-row > strong {
            flex: 1;
            color: #212529;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: right;
            overflow-wrap: anywhere;
        }


        .dropdown-menu {
            min-width: 210px;
        }


        @media (max-width: 991.98px) {

            .request-product-name,
            .beneficiary-name {
                max-width: 160px;
            }

        }


        @media (max-width: 767.98px) {

            .beneficiary-info-row {
                flex-direction: column;
                gap: 5px;
            }


            .beneficiary-info-row > span,
            .beneficiary-info-row > strong {
                flex: 0 0 auto;
                width: 100%;
            }


            .beneficiary-info-row > strong {
                text-align: left;
            }


            .modal-body {
                padding: 16px !important;
            }


            .modal-xl {
                margin: 10px;
            }

        }

    </style>


    @include('layouts.admin.script')


    {{-- =============================================================
        PAGE JAVASCRIPT
    ============================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | DONOR DECISION MODAL
            |--------------------------------------------------------------------------
            */

            const decisionModalElement =
                document.getElementById('donorDecisionModal');

            const decisionForm =
                document.getElementById('donorDecisionForm');

            const decisionStatus =
                document.getElementById('donorDecisionStatus');

            const decisionTitle =
                document.getElementById('donorDecisionModalLabel');

            const decisionSubtitle =
                document.getElementById('donorDecisionSubtitle');

            const decisionMessage =
                document.getElementById('donorDecisionMessage');

            const decisionSubmit =
                document.getElementById('donorDecisionSubmit');

            const decisionIconWrapper =
                document.getElementById('donorDecisionIconWrapper');

            const decisionIcon =
                document.getElementById('donorDecisionIcon');


            if (
                decisionModalElement &&
                decisionForm &&
                decisionStatus &&
                decisionTitle &&
                decisionSubtitle &&
                decisionMessage &&
                decisionSubmit &&
                decisionIconWrapper &&
                decisionIcon
            ) {
                const decisionModal =
                    new bootstrap.Modal(
                        decisionModalElement
                    );


                document
                    .querySelectorAll('.donor-decision-button')
                    .forEach(function (button) {

                        button.addEventListener(
                            'click',
                            function () {

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

                                const beneficiaryName =
                                    this.getAttribute(
                                        'data-beneficiary'
                                    );

                                const productName =
                                    this.getAttribute(
                                        'data-product'
                                    );


                                decisionForm.action =
                                    action;

                                decisionStatus.value =
                                    status;

                                decisionSubtitle.textContent =
                                    'Request #' +
                                    requestId +
                                    ' • ' +
                                    productName;


                                if (status === 'approved') {

                                    decisionTitle.textContent =
                                        'Accept Request';

                                    decisionMessage.className =
                                        'alert alert-success mb-0';

                                    decisionMessage.textContent =
                                        'Accept this request from ' +
                                        beneficiaryName +
                                        '? Confirm only after reviewing the beneficiary profile and product availability.';

                                    decisionSubmit.className =
                                        'btn btn-success';

                                    decisionSubmit.innerHTML =
                                        '<i class="bi bi-check-lg me-1"></i> Accept Request';

                                    decisionIconWrapper.className =
                                        'd-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0 bg-success-subtle text-success';

                                    decisionIcon.className =
                                        'bi bi-check-circle';

                                } else {

                                    decisionTitle.textContent =
                                        'Reject Request';

                                    decisionMessage.className =
                                        'alert alert-danger mb-0';

                                    decisionMessage.textContent =
                                        'Reject this request from ' +
                                        beneficiaryName +
                                        '? The request will remain recorded with your decision as rejected.';

                                    decisionSubmit.className =
                                        'btn btn-danger';

                                    decisionSubmit.innerHTML =
                                        '<i class="bi bi-x-lg me-1"></i> Reject Request';

                                    decisionIconWrapper.className =
                                        'd-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0 bg-danger-subtle text-danger';

                                    decisionIcon.className =
                                        'bi bi-x-circle';
                                }


                                decisionModal.show();
                            }
                        );

                    });
            }


            /*
            |--------------------------------------------------------------------------
            | MESSAGE CHARACTER COUNTERS
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.message-character-count'
                )
                .forEach(function (counter) {

                    const targetId =
                        counter.getAttribute(
                            'data-target'
                        );

                    const textarea =
                        document.getElementById(
                            targetId
                        );


                    if (!textarea) {
                        return;
                    }


                    const updateCounter =
                        function () {

                            counter.textContent =
                                textarea.value.length +
                                ' / 1000';
                        };


                    textarea.addEventListener(
                        'input',
                        updateCounter
                    );


                    updateCounter();

                });

        });

    </script>

</body>

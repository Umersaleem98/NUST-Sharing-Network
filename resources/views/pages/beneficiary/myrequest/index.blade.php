@include('layouts.admin.head')

<title>My Requests</title>

<style>
    :root {
        --br-primary: #0d6efd;
        --br-primary-dark: #0a4fa3;
        --br-success: #198754;
        --br-warning: #f59f00;
        --br-danger: #dc3545;
        --br-info: #0dcaf0;
        --br-text: #172033;
        --br-muted: #667085;
        --br-border: #e6eaf0;
        --br-surface: #ffffff;
        --br-soft: #f7f9fc;
        --br-shadow: 0 9px 28px rgba(16, 24, 40, 0.06);
    }

    .br-page-header {
        position: relative;
        overflow: hidden;
        padding: 1.45rem;
        border: 1px solid var(--br-border);
        border-radius: 1.2rem;
        background:
            radial-gradient(
                circle at top right,
                rgba(13, 110, 253, 0.11),
                transparent 34%
            ),
            linear-gradient(
                135deg,
                #ffffff 0%,
                #f7faff 100%
            );
        box-shadow: 0 8px 26px rgba(16, 24, 40, 0.04);
    }

    .br-header-icon {
        width: 50px;
        height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 1rem;
        color: var(--br-primary);
        background: rgba(13, 110, 253, 0.09);
        font-size: 1.3rem;
    }

    .br-browse-btn {
        min-height: 43px;
        border-radius: 0.75rem;
        font-weight: 650;
    }

    .br-summary-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .br-stat-card {
        border: 1px solid var(--br-border) !important;
        border-radius: 1rem !important;
        box-shadow: 0 5px 18px rgba(16, 24, 40, 0.045) !important;
    }

    .br-stat-icon {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 0.85rem;
        font-size: 1.05rem;
    }

    .br-stat-label {
        color: var(--br-muted);
        font-size: 0.74rem;
        font-weight: 650;
    }

    .br-stat-value {
        margin-bottom: 0;
        color: var(--br-text);
        font-size: 1.65rem;
        font-weight: 800;
        line-height: 1.1;
    }

    .br-history-card {
        overflow: hidden;
        border: 1px solid var(--br-border) !important;
        border-radius: 1.15rem !important;
        box-shadow: var(--br-shadow) !important;
    }

    .br-table th {
        white-space: nowrap;
        color: #667085 !important;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .br-table td {
        vertical-align: middle;
    }

    .br-product-image {
        width: 58px;
        height: 58px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid var(--br-border);
        border-radius: 0.75rem;
        background: #f2f4f7;
    }

    .br-product-name {
        max-width: 220px;
        color: var(--br-text);
        font-size: 0.86rem;
        font-weight: 700;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .br-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.32rem;
        padding: 0.48rem 0.72rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .br-status-note {
        display: block;
        margin-top: 0.3rem;
        color: var(--br-muted);
        font-size: 0.7rem;
        line-height: 1.35;
    }

    .br-contact-state {
        display: flex;
        align-items: flex-start;
        gap: 0.55rem;
        max-width: 245px;
        font-size: 0.76rem;
        line-height: 1.4;
    }

    .br-action-btn {
        min-height: 36px;
        border-radius: 0.65rem;
        font-size: 0.74rem;
        font-weight: 650;
    }

    .br-empty-icon {
        width: 72px;
        height: 72px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #7c8798;
        background: #f2f4f7;
        font-size: 1.8rem;
    }

    .br-modal-icon {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 0.85rem;
    }

    .br-profile-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.9rem 1rem;
        border-bottom: 1px solid #edf0f4;
    }

    .br-profile-row:last-child {
        border-bottom: 0;
    }

    .br-profile-row > span {
        flex: 0 0 40%;
        color: var(--br-muted);
        font-size: 0.8rem;
    }

    .br-profile-row > strong {
        flex: 1;
        color: var(--br-text);
        font-size: 0.8rem;
        font-weight: 650;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .br-message-box {
        padding: 1rem;
        border: 1px solid #dbe7f7;
        border-radius: 0.85rem;
        color: #344054;
        background: #f8fbff;
        line-height: 1.7;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    @media (max-width: 1399.98px) {
        .br-summary-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .br-summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .br-page-header {
            padding: 1.1rem;
        }

        .br-summary-grid {
            grid-template-columns: 1fr;
        }

        .br-profile-row {
            flex-direction: column;
            gap: 0.25rem;
        }

        .br-profile-row > span,
        .br-profile-row > strong {
            width: 100%;
            flex: 0 0 auto;
            text-align: left;
        }
    }
</style>

<body>

    @php
        $fallbackImage =
            asset('admins/asset/dummy/dummy.jpg');

        $totalRequests =
            $requestStats['total']
            ?? $requests->total();

        $adminPendingRequests =
            $requestStats['admin_pending']
            ?? 0;

        $awaitingDonorRequests =
            $requestStats['awaiting_donor']
            ?? 0;

        $acceptedRequests =
            $requestStats['accepted']
            ?? 0;

        $rejectedRequests =
            $requestStats['rejected']
            ?? 0;
    @endphp


    @include('layouts.admin.sidebar')


    <div class="nsn-main">

        @include('layouts.admin.header')


        <main class="nsn-content">

            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}
            <section class="br-page-header mb-4">

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                    <div class="d-flex align-items-center gap-3">

                        <span class="br-header-icon">
                            <i class="bi bi-clipboard-check"></i>
                        </span>

                        <div>
                            <h3 class="fw-bold text-dark mb-1">
                                My Requests
                            </h3>

                            <p class="text-secondary small mb-0">
                                Track administrator review, donor decisions, messages and accepted donor details.
                            </p>
                        </div>

                    </div>


                    <a
                        href="{{ route('beneficiary.products.index') }}"
                        class="btn btn-primary br-browse-btn d-flex align-items-center gap-2"
                    >
                        <i class="bi bi-grid-3x3-gap"></i>
                        <span>Browse Products</span>
                    </a>

                </div>

            </section>


            {{-- =========================================================
                BREADCRUMB
            ========================================================== --}}
            <nav
                aria-label="breadcrumb"
                class="mb-4"
            >

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
                        My Requests
                    </li>

                </ol>

            </nav>


            @include('layouts.admin.alert')


            {{-- =========================================================
                REQUEST SUMMARY
            ========================================================== --}}
            <section class="br-summary-grid">

                {{-- Total --}}
                <div class="card br-stat-card h-100">

                    <div class="card-body p-3">

                        <div class="d-flex align-items-center justify-content-between gap-3">

                            <div>
                                <div class="br-stat-label mb-1">
                                    Total Requests
                                </div>

                                <p class="br-stat-value">
                                    {{ number_format($totalRequests) }}
                                </p>
                            </div>

                            <span class="br-stat-icon bg-primary-subtle text-primary">
                                <i class="bi bi-clipboard-data"></i>
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Admin Review --}}
                <div class="card br-stat-card h-100">

                    <div class="card-body p-3">

                        <div class="d-flex align-items-center justify-content-between gap-3">

                            <div>
                                <div class="br-stat-label mb-1">
                                    Admin Review
                                </div>

                                <p class="br-stat-value text-warning-emphasis">
                                    {{ number_format($adminPendingRequests) }}
                                </p>
                            </div>

                            <span class="br-stat-icon bg-warning-subtle text-warning-emphasis">
                                <i class="bi bi-shield-clock"></i>
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Awaiting Donor --}}
                <div class="card br-stat-card h-100">

                    <div class="card-body p-3">

                        <div class="d-flex align-items-center justify-content-between gap-3">

                            <div>
                                <div class="br-stat-label mb-1">
                                    Awaiting Donor
                                </div>

                                <p class="br-stat-value text-info">
                                    {{ number_format($awaitingDonorRequests) }}
                                </p>
                            </div>

                            <span class="br-stat-icon bg-info-subtle text-info-emphasis">
                                <i class="bi bi-person-clock"></i>
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Accepted --}}
                <div class="card br-stat-card h-100">

                    <div class="card-body p-3">

                        <div class="d-flex align-items-center justify-content-between gap-3">

                            <div>
                                <div class="br-stat-label mb-1">
                                    Accepted
                                </div>

                                <p class="br-stat-value text-success">
                                    {{ number_format($acceptedRequests) }}
                                </p>
                            </div>

                            <span class="br-stat-icon bg-success-subtle text-success">
                                <i class="bi bi-check-circle"></i>
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Rejected --}}
                <div class="card br-stat-card h-100">

                    <div class="card-body p-3">

                        <div class="d-flex align-items-center justify-content-between gap-3">

                            <div>
                                <div class="br-stat-label mb-1">
                                    Rejected
                                </div>

                                <p class="br-stat-value text-danger">
                                    {{ number_format($rejectedRequests) }}
                                </p>
                            </div>

                            <span class="br-stat-icon bg-danger-subtle text-danger">
                                <i class="bi bi-x-circle"></i>
                            </span>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                REQUEST HISTORY
            ========================================================== --}}
            <section class="card br-history-card">

                <div class="card-header bg-white border-bottom px-4 py-3">

                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                        <div>

                            <h5 class="fw-semibold text-dark mb-1">
                                Product Request History
                            </h5>

                            <p class="text-secondary small mb-0">
                                Donor profile, contact information and messages unlock only after admin approval, donor acceptance, and donor permission.
                            </p>

                        </div>


                        <span class="badge rounded-pill bg-light text-secondary border px-3 py-2">
                            <i class="bi bi-list-ul me-1"></i>
                            {{ number_format($totalRequests) }}
                            {{ $totalRequests === 1 ? 'request' : 'requests' }}
                        </span>

                    </div>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0 br-table">

                            <thead class="table-light">

                                <tr>
                                    <th class="px-4 py-3">
                                        #
                                    </th>

                                    <th class="py-3">
                                        Product
                                    </th>

                                    <th class="py-3">
                                        Admin Review
                                    </th>

                                    <th class="py-3">
                                        Donor Decision
                                    </th>

                                    <th class="py-3">
                                        Donor / Message
                                    </th>

                                    <th class="py-3">
                                        Submitted
                                    </th>

                                    <th class="px-4 py-3 text-end">
                                        Product
                                    </th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($requests as $key => $productRequest)

                                    @php
                                        $product =
                                            $productRequest->product;

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
                                                    ? array_values(
                                                        array_filter(
                                                            $productImages
                                                        )
                                                    )
                                                    : [];
                                        }

                                        $productImage =
                                            ! empty($productImages)
                                                ? asset(
                                                    'admins/products/'
                                                    . basename($productImages[0])
                                                )
                                                : $fallbackImage;


                                        /*
                                        |--------------------------------------------------------------------------
                                        | Status Checks
                                        |--------------------------------------------------------------------------
                                        */

                                        $adminStatus =
                                            $productRequest->admin_status
                                            ?? 'pending';

                                        $donorStatus =
                                            $productRequest->donor_status
                                            ?? 'pending';

                                        $donorAccepted =
                                            in_array(
                                                $donorStatus,
                                                [
                                                    'accepted',
                                                    'approved',
                                                ],
                                                true
                                            );

                                        $adminApproved =
                                            $adminStatus ===
                                            'approved';

                                        $adminRejected =
                                            $adminStatus ===
                                            'rejected';

                                        $donorRejected =
                                            $donorStatus ===
                                            'rejected';

                                        $informationAllowed =
                                            (bool) (
                                                $productRequest->donor_information_allowed
                                                ?? false
                                            );

                                        $donorInformationAllowed =
                                            $adminApproved
                                            && $donorAccepted
                                            && $informationAllowed;

                                        $donor =
                                            $donorInformationAllowed
                                                ? $productRequest->donor
                                                : null;


                                        /*
                                        |--------------------------------------------------------------------------
                                        | Admin Status Presentation
                                        |--------------------------------------------------------------------------
                                        */

                                        $adminBadge =
                                            match ($adminStatus) {
                                                'approved' =>
                                                    'bg-success-subtle text-success',

                                                'rejected' =>
                                                    'bg-danger-subtle text-danger',

                                                default =>
                                                    'bg-warning-subtle text-warning-emphasis',
                                            };

                                        $adminIcon =
                                            match ($adminStatus) {
                                                'approved' =>
                                                    'bi-shield-check',

                                                'rejected' =>
                                                    'bi-shield-x',

                                                default =>
                                                    'bi-hourglass-split',
                                            };

                                        $adminLabel =
                                            match ($adminStatus) {
                                                'approved' =>
                                                    'Approved',

                                                'rejected' =>
                                                    'Rejected',

                                                default =>
                                                    'Under Review',
                                            };


                                        /*
                                        |--------------------------------------------------------------------------
                                        | Donor Status Presentation
                                        |--------------------------------------------------------------------------
                                        */

                                        if ($adminRejected) {
                                            $donorBadge =
                                                'bg-secondary-subtle text-secondary';

                                            $donorIcon =
                                                'bi-dash-circle';

                                            $donorLabel =
                                                'Not Forwarded';

                                        } elseif (! $adminApproved) {
                                            $donorBadge =
                                                'bg-light text-secondary border';

                                            $donorIcon =
                                                'bi-lock';

                                            $donorLabel =
                                                'Waiting';

                                        } elseif ($donorAccepted) {
                                            $donorBadge =
                                                'bg-success-subtle text-success';

                                            $donorIcon =
                                                'bi-check-circle';

                                            $donorLabel =
                                                'Accepted';

                                        } elseif ($donorRejected) {
                                            $donorBadge =
                                                'bg-danger-subtle text-danger';

                                            $donorIcon =
                                                'bi-x-circle';

                                            $donorLabel =
                                                'Rejected';

                                        } else {
                                            $donorBadge =
                                                'bg-info-subtle text-info-emphasis';

                                            $donorIcon =
                                                'bi-person-clock';

                                            $donorLabel =
                                                'Awaiting Donor';
                                        }
                                    @endphp


                                    <tr>

                                        {{-- Number --}}
                                        <td class="px-4">

                                            <span class="text-secondary small">
                                                {{ $requests->firstItem() + $key }}
                                            </span>

                                        </td>


                                        {{-- Product --}}
                                        <td>

                                            <div class="d-flex align-items-center gap-3">

                                                <img
                                                    src="{{ $productImage }}"
                                                    alt="{{ $product->name ?? 'Product' }}"
                                                    width="58"
                                                    height="58"
                                                    class="br-product-image"
                                                    loading="lazy"
                                                    onerror="this.onerror=null;this.src='{{ $fallbackImage }}';"
                                                >


                                                <div class="min-width-0">

                                                    <div
                                                        class="br-product-name"
                                                        title="{{ $product->name ?? 'Product unavailable' }}"
                                                    >
                                                        {{ $product->name ?? 'Product unavailable' }}
                                                    </div>

                                                    <small class="text-secondary">
                                                        Request #{{ $productRequest->id }}
                                                    </small>

                                                    @if ($product?->category)

                                                        <small class="d-block text-primary mt-1">
                                                            <i class="bi bi-tag me-1"></i>
                                                            {{ $product->category->name }}
                                                        </small>

                                                    @endif

                                                </div>

                                            </div>

                                        </td>


                                        {{-- Admin Review --}}
                                        <td>

                                            <span class="br-status-badge {{ $adminBadge }}">
                                                <i class="bi {{ $adminIcon }}"></i>
                                                {{ $adminLabel }}
                                            </span>


                                            @if ($adminStatus === 'pending')

                                                <span class="br-status-note">
                                                    Waiting for administrator review.
                                                </span>

                                            @elseif ($adminRejected)

                                                <span class="br-status-note text-danger">
                                                    Request stopped at admin review.
                                                </span>

                                            @else

                                                <span class="br-status-note">
                                                    Forwarded to the donor.
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Donor Decision --}}
                                        <td>

                                            <span class="br-status-badge {{ $donorBadge }}">
                                                <i class="bi {{ $donorIcon }}"></i>
                                                {{ $donorLabel }}
                                            </span>


                                            @if ($adminApproved && $donorStatus === 'pending')

                                                <span class="br-status-note">
                                                    Donor decision is pending.
                                                </span>

                                            @elseif ($donorAccepted)

                                                <span class="br-status-note text-success">
                                                    Donor accepted your request.
                                                </span>

                                            @elseif ($donorRejected)

                                                <span class="br-status-note text-danger">
                                                    Donor rejected your request.
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Donor / Message --}}
                                        <td>

                                            @if ($donorInformationAllowed && $donor)

                                                <div class="d-flex flex-wrap gap-2">

                                                    <button
                                                        type="button"
                                                        class="btn btn-outline-primary btn-sm br-action-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#donorModal{{ $productRequest->id }}"
                                                    >
                                                        <i class="bi bi-person-vcard me-1"></i>
                                                        View Donor
                                                    </button>


                                                    <button
                                                        type="button"
                                                        class="btn btn-outline-info btn-sm br-action-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#messageModal{{ $productRequest->id }}"
                                                    >
                                                        <i class="bi bi-chat-left-text me-1"></i>

                                                        {{
                                                            $productRequest->message
                                                                ? 'View Message'
                                                                : 'Message'
                                                        }}
                                                    </button>

                                                </div>


                                            @elseif ($donorRejected)

                                                <div class="br-contact-state text-danger">

                                                    <i class="bi bi-x-circle mt-1"></i>

                                                    <span>
                                                        Donor information is not available because the request was rejected.
                                                    </span>

                                                </div>


                                            @elseif ($adminRejected)

                                                <div class="br-contact-state text-danger">

                                                    <i class="bi bi-shield-x mt-1"></i>

                                                    <span>
                                                        This request was not forwarded to the donor.
                                                    </span>

                                                </div>


                                            @elseif (
                                                $adminApproved
                                                && $donorAccepted
                                                && ! $informationAllowed
                                            )

                                                <div class="br-contact-state text-secondary">

                                                    <i class="bi bi-shield-lock mt-1"></i>

                                                    <span>
                                                        Donor accepted your request, but donor information is private until the donor enables access.
                                                    </span>

                                                </div>


                                            @else

                                                <div class="br-contact-state text-secondary">

                                                    <i class="bi bi-lock mt-1"></i>

                                                    <span>
                                                        Donor information remains locked until all permissions are complete.
                                                    </span>

                                                </div>

                                            @endif

                                        </td>


                                        {{-- Submitted --}}
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


                                        {{-- Product Action --}}
                                        <td class="px-4 text-end">

                                            @if ($product)

                                                <a
                                                    href="{{ route('beneficiary.products.detail.show', $product->id) }}"
                                                    class="btn btn-light border btn-sm br-action-btn"
                                                >
                                                    <i class="bi bi-eye me-1"></i>
                                                    View
                                                </a>

                                            @else

                                                <span class="text-secondary small">
                                                    Unavailable
                                                </span>

                                            @endif

                                        </td>

                                    </tr>


                                @empty

                                    <tr>

                                        <td
                                            colspan="7"
                                            class="text-center py-5"
                                        >

                                            <div class="d-flex flex-column align-items-center px-3">

                                                <span class="br-empty-icon mb-3">
                                                    <i class="bi bi-clipboard-x"></i>
                                                </span>

                                                <h5 class="fw-bold text-dark mb-2">
                                                    No product requests yet
                                                </h5>

                                                <p class="text-secondary small mb-4">
                                                    Browse available products and submit a request for something you need.
                                                </p>

                                                <a
                                                    href="{{ route('beneficiary.products.index') }}"
                                                    class="btn btn-primary btn-sm px-4"
                                                >
                                                    <i class="bi bi-grid-3x3-gap me-1"></i>
                                                    Browse Products
                                                </a>

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

            </section>

        </main>

    </div>


    {{-- =============================================================
        DONOR / MESSAGE MODALS
    ============================================================== --}}
    @foreach ($requests as $productRequest)

        @php
            $adminAllowed =
                ($productRequest->admin_status ?? 'pending')
                === 'approved';

            $donorAllowed =
                in_array(
                    $productRequest->donor_status,
                    [
                        'accepted',
                        'approved',
                    ],
                    true
                );

            $informationAllowed =
                (bool) (
                    $productRequest->donor_information_allowed
                    ?? false
                );

            $donorInformationAllowed =
                $adminAllowed
                && $donorAllowed
                && $informationAllowed;

            $donor =
                $donorInformationAllowed
                    ? $productRequest->donor
                    : null;

            $donorProfile =
                $donorInformationAllowed
                    ? $donor?->donorProfile
                    : null;

            $donorImage =
                $donorInformationAllowed
                && $donor
                && $donor->image
                    ? asset(
                        'admins/asset/profilephoto/'
                        . basename($donor->image)
                    )
                    : $fallbackImage;
        @endphp


        @if ($donorInformationAllowed && $donor)

            {{-- =========================================================
                DONOR PROFILE MODAL
            ========================================================== --}}
            <div
                class="modal fade"
                id="donorModal{{ $productRequest->id }}"
                tabindex="-1"
                aria-labelledby="donorModalLabel{{ $productRequest->id }}"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                        <div class="modal-header bg-white border-bottom px-4 py-3">

                            <div>

                                <h5
                                    class="modal-title fw-bold text-dark mb-1"
                                    id="donorModalLabel{{ $productRequest->id }}"
                                >
                                    Donor Information
                                </h5>

                                <p class="text-secondary small mb-0">
                                    Donor details for accepted Request #{{ $productRequest->id }}.
                                </p>

                            </div>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>

                        </div>


                        <div class="modal-body bg-light p-4">

                            {{-- Profile Summary --}}
                            <div class="card border-0 shadow-sm rounded-4 mb-4">

                                <div class="card-body p-4">

                                    <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start gap-3">

                                        <img
                                            src="{{ $donorImage }}"
                                            alt="{{ $donor->name }}"
                                            width="100"
                                            height="100"
                                            class="rounded-circle border border-3 border-white shadow-sm object-fit-cover flex-shrink-0"
                                        >

                                        <div class="text-center text-sm-start">

                                            <div class="d-flex flex-wrap justify-content-center justify-content-sm-start align-items-center gap-2 mb-2">

                                                <h4 class="fw-bold text-dark mb-0">
                                                    {{ $donor->name }}
                                                </h4>

                                                <span class="badge rounded-pill bg-primary-subtle text-primary">
                                                    Donor
                                                </span>

                                            </div>


                                            <p class="text-secondary mb-1">
                                                <i class="bi bi-envelope me-2"></i>
                                                {{ $donor->email }}
                                            </p>

                                            <p class="text-secondary mb-0">
                                                <i class="bi bi-telephone me-2"></i>
                                                {{ $donor->phone ?? 'Phone not available' }}
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="row g-4">

                                {{-- Organization --}}
                                <div class="col-12 col-md-6">

                                    <div class="card border-0 shadow-sm rounded-4 h-100">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="br-modal-icon bg-success-subtle text-success">
                                                    <i class="bi bi-building"></i>
                                                </span>

                                                <h6 class="fw-bold text-dark mb-0">
                                                    Organization
                                                </h6>

                                            </div>

                                        </div>


                                        <div class="card-body p-0">

                                            <div class="br-profile-row">
                                                <span>Organization</span>
                                                <strong>
                                                    {{ $donorProfile?->organization ?? 'Not available' }}
                                                </strong>
                                            </div>

                                            <div class="br-profile-row">
                                                <span>Designation</span>
                                                <strong>
                                                    {{ $donorProfile?->designation ?? 'Not available' }}
                                                </strong>
                                            </div>

                                            <div class="br-profile-row">
                                                <span>Country</span>
                                                <strong>
                                                    {{ $donorProfile?->country ?? 'Not available' }}
                                                </strong>
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Contact --}}
                                <div class="col-12 col-md-6">

                                    <div class="card border-0 shadow-sm rounded-4 h-100">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="br-modal-icon bg-info-subtle text-info-emphasis">
                                                    <i class="bi bi-person-lines-fill"></i>
                                                </span>

                                                <h6 class="fw-bold text-dark mb-0">
                                                    Contact Details
                                                </h6>

                                            </div>

                                        </div>


                                        <div class="card-body p-0">

                                            <div class="br-profile-row">
                                                <span>Email</span>
                                                <strong class="text-break">
                                                    {{ $donor->email }}
                                                </strong>
                                            </div>

                                            <div class="br-profile-row">
                                                <span>Phone</span>
                                                <strong>
                                                    {{ $donor->phone ?? 'Not available' }}
                                                </strong>
                                            </div>

                                            <div class="p-3">
                                                <span class="d-block text-secondary small mb-2">
                                                    Address
                                                </span>

                                                <div class="fw-semibold small text-dark lh-lg">
                                                    {{ $donorProfile?->address ?? 'Not available' }}
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- Request Context --}}
                                <div class="col-12">

                                    <div class="card border-0 shadow-sm rounded-4">

                                        <div class="card-header bg-white border-bottom px-4 py-3">

                                            <div class="d-flex align-items-center gap-3">

                                                <span class="br-modal-icon bg-primary-subtle text-primary">
                                                    <i class="bi bi-clipboard-check"></i>
                                                </span>

                                                <h6 class="fw-bold text-dark mb-0">
                                                    Request Context
                                                </h6>

                                            </div>

                                        </div>


                                        <div class="card-body">

                                            <div class="row g-3">

                                                <div class="col-12 col-sm-4">
                                                    <small class="d-block text-secondary mb-1">
                                                        Request ID
                                                    </small>

                                                    <strong>
                                                        #{{ $productRequest->id }}
                                                    </strong>
                                                </div>

                                                <div class="col-12 col-sm-4">
                                                    <small class="d-block text-secondary mb-1">
                                                        Product
                                                    </small>

                                                    <strong>
                                                        {{ $productRequest->product?->name ?? 'Not available' }}
                                                    </strong>
                                                </div>

                                                <div class="col-12 col-sm-4">
                                                    <small class="d-block text-secondary mb-1">
                                                        Donor Decision
                                                    </small>

                                                    <strong class="text-success">
                                                        Accepted
                                                    </strong>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


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


            {{-- =========================================================
                DONOR MESSAGE MODAL
            ========================================================== --}}
            <div
                class="modal fade"
                id="messageModal{{ $productRequest->id }}"
                tabindex="-1"
                aria-labelledby="messageModalLabel{{ $productRequest->id }}"
                aria-hidden="true"
            >

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                        <div class="modal-header bg-white border-bottom px-4 py-3">

                            <div>

                                <h5
                                    class="modal-title fw-bold text-dark mb-1"
                                    id="messageModalLabel{{ $productRequest->id }}"
                                >
                                    Message from Donor
                                </h5>

                                <p class="text-secondary small mb-0">
                                    Request #{{ $productRequest->id }}
                                    •
                                    {{ $productRequest->product?->name ?? 'Product' }}
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

                            @if ($productRequest->message)

                                <div class="d-flex align-items-start gap-3 mb-3">

                                    <img
                                        src="{{ $donorImage }}"
                                        alt="{{ $donor->name }}"
                                        width="48"
                                        height="48"
                                        class="rounded-circle border object-fit-cover flex-shrink-0"
                                    >

                                    <div>

                                        <h6 class="fw-bold text-dark mb-1">
                                            {{ $donor->name }}
                                        </h6>

                                        <small class="text-secondary">
                                            Donor
                                        </small>

                                    </div>

                                </div>


                                <div class="br-message-box">
                                    {!! nl2br(e($productRequest->message)) !!}
                                </div>


                            @else

                                <div class="text-center py-3">

                                    <span class="br-modal-icon bg-light text-secondary mx-auto mb-3">
                                        <i class="bi bi-chat"></i>
                                    </span>

                                    <h6 class="fw-semibold text-dark mb-1">
                                        No message added
                                    </h6>

                                    <p class="text-secondary small mb-0">
                                        The donor accepted the request but has not added a message yet.
                                    </p>

                                </div>

                            @endif

                        </div>


                        <div class="modal-footer bg-white border-top px-4 py-3">

                            <button
                                type="button"
                                class="btn btn-light border"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        @endif

    @endforeach


    @include('layouts.admin.script')

</body>

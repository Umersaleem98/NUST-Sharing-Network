@include('layouts.admin.head')

<title>{{ $product->name }} | Product Details</title>

<style>
    :root {
        --pd-primary: #0d6efd;
        --pd-primary-dark: #0a4fa3;
        --pd-success: #198754;
        --pd-danger: #dc3545;
        --pd-warning: #f59f00;
        --pd-text: #172033;
        --pd-muted: #667085;
        --pd-border: #e6eaf0;
        --pd-surface: #ffffff;
        --pd-soft: #f7f9fc;
        --pd-shadow: 0 10px 30px rgba(16, 24, 40, 0.07);
        --pd-shadow-hover: 0 18px 42px rgba(16, 24, 40, 0.12);
    }

    .pd-page-header {
        position: relative;
        overflow: hidden;
        padding: 1.45rem;
        border: 1px solid var(--pd-border);
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

    .pd-header-icon {
        width: 50px;
        height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 1rem;
        color: var(--pd-primary);
        background: rgba(13, 110, 253, 0.09);
        font-size: 1.3rem;
    }

    .pd-back-btn {
        min-height: 42px;
        border-radius: 0.75rem;
        font-weight: 600;
    }

    .pd-card {
        overflow: hidden;
        border: 1px solid var(--pd-border) !important;
        border-radius: 1.15rem !important;
        background: var(--pd-surface);
        box-shadow: var(--pd-shadow) !important;
    }

    .pd-gallery-column {
        position: sticky;
        top: 1.25rem;
        align-self: flex-start;
    }

    .pd-gallery-main {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: linear-gradient(135deg, #f3f6fa, #eef2f7);
    }

    .pd-gallery-main .carousel-inner,
    .pd-gallery-main .carousel-item {
        height: 100%;
    }

    .pd-gallery-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
        background: #f8fafc;
    }

    .pd-gallery-overlay {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background:
            linear-gradient(
                to top,
                rgba(15, 23, 42, 0.18),
                transparent 35%
            );
    }

    .pd-photo-count {
        position: absolute;
        z-index: 3;
        right: 0.85rem;
        bottom: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 0.7rem;
        border-radius: 999px;
        color: #fff;
        background: rgba(15, 23, 42, 0.78);
        font-size: 0.74rem;
        font-weight: 650;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .pd-gallery-main .carousel-control-prev,
    .pd-gallery-main .carousel-control-next {
        width: 14%;
    }

    .pd-gallery-main .carousel-control-prev-icon,
    .pd-gallery-main .carousel-control-next-icon {
        width: 2.4rem;
        height: 2.4rem;
        padding: 0.55rem;
        border-radius: 50%;
        background-color: rgba(15, 23, 42, 0.72);
        background-size: 52%;
    }

    .pd-thumbnail-strip {
        display: flex;
        gap: 0.65rem;
        overflow-x: auto;
        padding: 0.85rem;
        background: #fff;
        scrollbar-width: thin;
    }

    .pd-thumbnail {
        flex: 0 0 auto;
        width: 78px;
        height: 66px;
        padding: 3px;
        overflow: hidden;
        border: 2px solid transparent !important;
        border-radius: 0.7rem;
        background: #fff;
        transition:
            border-color 0.2s ease,
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .pd-thumbnail:hover,
    .pd-thumbnail.active {
        transform: translateY(-2px);
        border-color: var(--pd-primary) !important;
        box-shadow: 0 5px 12px rgba(13, 110, 253, 0.15);
    }

    .pd-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0.45rem;
    }

    .pd-main-card .card-body {
        padding: 1.6rem;
    }

    .pd-status-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        align-items: center;
        margin-bottom: 1rem;
    }

    .pd-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.48rem 0.75rem;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
    }

    .pd-product-name {
        margin-bottom: 0.55rem;
        color: var(--pd-text);
        font-size: clamp(1.7rem, 3vw, 2.45rem);
        font-weight: 800;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }

    .pd-product-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        margin-bottom: 1.4rem;
    }

    .pd-meta-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.42rem 0.68rem;
        border: 1px solid var(--pd-border);
        border-radius: 0.65rem;
        color: var(--pd-muted);
        background: #fafbfd;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .pd-facts {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.8rem;
        margin-bottom: 1.5rem;
    }

    .pd-fact {
        min-width: 0;
        padding: 1rem;
        border: 1px solid var(--pd-border);
        border-radius: 0.9rem;
        background: #f9fbfd;
    }

    .pd-fact-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.65rem;
        border-radius: 0.65rem;
        color: var(--pd-primary);
        background: #eaf2ff;
    }

    .pd-fact-label {
        margin-bottom: 0.15rem;
        color: var(--pd-muted);
        font-size: 0.72rem;
    }

    .pd-fact-value {
        color: var(--pd-text);
        font-size: 0.86rem;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .pd-section-title {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 0.85rem;
        color: var(--pd-text);
        font-size: 1rem;
        font-weight: 750;
    }

    .pd-section-title-icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 0.65rem;
        color: var(--pd-primary);
        background: #edf4ff;
    }

    .pd-description-box {
        padding: 1.15rem 1.2rem;
        border: 1px solid var(--pd-border);
        border-radius: 0.9rem;
        color: #475467;
        background: #fbfcfe;
        font-size: 0.9rem;
        line-height: 1.75;
        overflow-wrap: anywhere;
    }

    .pd-request-panel {
        margin-top: 1.4rem;
        padding: 1.1rem;
        border: 1px solid var(--pd-border);
        border-radius: 0.95rem;
        background: #fff;
    }

    .pd-request-panel.is-success {
        border-color: #cce8d8;
        background: #f5fbf7;
    }

    .pd-request-panel.is-warning {
        border-color: #f4ddb0;
        background: #fffaf0;
    }

    .pd-request-panel.is-primary {
        border-color: #d5e4ff;
        background: #f7faff;
    }

    .pd-request-icon {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 0.8rem;
        font-size: 1.05rem;
    }

    .pd-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        padding-top: 1.25rem;
        margin-top: 1.25rem;
        border-top: 1px solid var(--pd-border);
    }

    .pd-actions .btn {
        min-height: 45px;
        border-radius: 0.75rem;
        padding-inline: 1.15rem;
        font-weight: 650;
    }

    .pd-process-card {
        margin-top: 1rem;
        border: 1px solid var(--pd-border) !important;
        border-radius: 1rem !important;
        background: #fff;
        box-shadow: 0 5px 18px rgba(16, 24, 40, 0.04);
    }

    .pd-process-step {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        padding: 0.9rem 0;
    }

    .pd-process-step + .pd-process-step {
        border-top: 1px solid #edf0f4;
    }

    .pd-process-number {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 50%;
        color: var(--pd-primary);
        background: #edf4ff;
        font-size: 0.78rem;
        font-weight: 800;
    }

    .pd-related-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .pd-related-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
    }

    .pd-related-card {
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--pd-border) !important;
        border-radius: 1rem !important;
        background: #fff;
        box-shadow: 0 6px 20px rgba(16, 24, 40, 0.055);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }

    .pd-related-card:hover {
        transform: translateY(-5px);
        border-color: #cbdbfb !important;
        box-shadow: var(--pd-shadow-hover);
    }

    .pd-related-image-wrap {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: #f2f4f7;
    }

    .pd-related-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .pd-related-card:hover .pd-related-image {
        transform: scale(1.045);
    }

    .pd-related-category {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        max-width: 100%;
        padding: 0.35rem 0.58rem;
        border-radius: 999px;
        color: var(--pd-primary-dark);
        background: #edf4ff;
        font-size: 0.68rem;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pd-related-title {
        min-height: 2.65rem;
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        color: var(--pd-text);
        font-size: 0.98rem;
        line-height: 1.35;
    }

    .pd-related-description {
        min-height: 3.75rem;
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        color: var(--pd-muted);
        font-size: 0.79rem;
        line-height: 1.55;
    }

    .pd-related-btn {
        min-height: 40px;
        border-radius: 0.72rem;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .pd-confirm-icon {
        width: 68px;
        height: 68px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--pd-primary);
        background: #edf4ff;
        font-size: 1.8rem;
    }

    @media (max-width: 1199.98px) {
        .pd-gallery-column {
            position: static;
        }

        .pd-related-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .pd-related-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .pd-page-header {
            padding: 1.1rem;
        }

        .pd-facts {
            grid-template-columns: 1fr;
            gap: 0.65rem;
        }

        .pd-fact {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.85rem;
        }

        .pd-fact-icon {
            flex: 0 0 auto;
            margin-bottom: 0;
        }

        .pd-main-card .card-body {
            padding: 1.15rem;
        }
    }

    @media (max-width: 575.98px) {
        .pd-related-grid {
            grid-template-columns: 1fr;
        }

        .pd-actions,
        .pd-actions form,
        .pd-actions .btn {
            width: 100%;
        }

        .pd-actions form .btn {
            width: 100%;
        }
    }
</style>

<body>

    @php
        /*
        |--------------------------------------------------------------------------
        | Product Images
        |--------------------------------------------------------------------------
        */

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

        $fallbackImage =
            asset('admins/asset/dummy/dummy.jpg');

        $categoryName =
            optional($product->category)->name
            ?? 'Uncategorized';

        $isActive =
            ($product->status ?? 'inactive')
            === 'active';
    @endphp


    @include('layouts.admin.sidebar')


    <div class="nsn-main">

        @include('layouts.admin.header')


        <main class="nsn-content">

            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}
            <section class="pd-page-header mb-4">

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                    <div class="d-flex align-items-center gap-3">

                        <span class="pd-header-icon">
                            <i class="bi bi-box-seam"></i>
                        </span>

                        <div>
                            <h3 class="fw-bold text-dark mb-1">
                                Product Details
                            </h3>

                            <p class="text-secondary small mb-0">
                                Review the product information before submitting your request.
                            </p>
                        </div>

                    </div>


                    <a
                        href="{{ route('beneficiary.products.index') }}"
                        class="btn btn-light border pd-back-btn d-flex align-items-center gap-2"
                    >
                        <i class="bi bi-arrow-left"></i>
                        <span>Back to Products</span>
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


                    <li class="breadcrumb-item">

                        <a
                            href="{{ route('beneficiary.products.index') }}"
                            class="text-decoration-none"
                        >
                            Products
                        </a>

                    </li>


                    <li
                        class="breadcrumb-item active text-truncate"
                        aria-current="page"
                        style="max-width: 260px;"
                    >
                        {{ $product->name }}
                    </li>

                </ol>

            </nav>


            @include('layouts.admin.alert')


            {{-- =========================================================
                PRODUCT DETAILS
            ========================================================== --}}
            <div class="row g-4">

                {{-- =====================================================
                    PRODUCT GALLERY
                ====================================================== --}}
                <div class="col-12 col-xl-5">

                    <div class="pd-gallery-column">

                        <div class="pd-card card">

                            @if (! empty($productImages))

                                <div
                                    id="productImageCarousel"
                                    class="pd-gallery-main carousel slide"
                                    data-bs-ride="false"
                                >

                                    <div class="carousel-inner">

                                        @foreach ($productImages as $index => $image)

                                            <div
                                                class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                                            >

                                                <img
                                                    src="{{ asset('admins/products/' . basename($image)) }}"
                                                    alt="{{ $product->name }} image {{ $index + 1 }}"
                                                    width="900"
                                                    height="675"
                                                    class="pd-gallery-image"
                                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                                    decoding="async"
                                                    onerror="this.onerror=null;this.src='{{ $fallbackImage }}';"
                                                >

                                            </div>

                                        @endforeach

                                    </div>


                                    <div class="pd-gallery-overlay"></div>


                                    @if (count($productImages) > 1)

                                        <span class="pd-photo-count">
                                            <i class="bi bi-images"></i>

                                            {{ count($productImages) }}

                                            {{
                                                count($productImages) === 1
                                                    ? 'photo'
                                                    : 'photos'
                                            }}
                                        </span>


                                        <button
                                            class="carousel-control-prev"
                                            type="button"
                                            data-bs-target="#productImageCarousel"
                                            data-bs-slide="prev"
                                        >
                                            <span
                                                class="carousel-control-prev-icon"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="visually-hidden">
                                                Previous
                                            </span>
                                        </button>


                                        <button
                                            class="carousel-control-next"
                                            type="button"
                                            data-bs-target="#productImageCarousel"
                                            data-bs-slide="next"
                                        >
                                            <span
                                                class="carousel-control-next-icon"
                                                aria-hidden="true"
                                            ></span>

                                            <span class="visually-hidden">
                                                Next
                                            </span>
                                        </button>

                                    @endif

                                </div>


                                @if (count($productImages) > 1)

                                    <div class="border-top">

                                        <div class="pd-thumbnail-strip">

                                            @foreach ($productImages as $index => $image)

                                                <button
                                                    type="button"
                                                    class="pd-thumbnail btn {{ $index === 0 ? 'active' : '' }}"
                                                    data-bs-target="#productImageCarousel"
                                                    data-bs-slide-to="{{ $index }}"
                                                    aria-label="View image {{ $index + 1 }}"
                                                >
                                                    <img
                                                        src="{{ asset('admins/products/' . basename($image)) }}"
                                                        alt="{{ $product->name }} thumbnail {{ $index + 1 }}"
                                                        width="78"
                                                        height="66"
                                                        loading="lazy"
                                                        decoding="async"
                                                        onerror="this.onerror=null;this.src='{{ $fallbackImage }}';"
                                                    >
                                                </button>

                                            @endforeach

                                        </div>

                                    </div>

                                @endif


                            @else

                                <div class="text-center p-5 bg-light">

                                    <img
                                        src="{{ $fallbackImage }}"
                                        alt="No product image available"
                                        width="260"
                                        height="260"
                                        class="img-fluid rounded-3 object-fit-cover"
                                    >

                                    <h6 class="fw-semibold text-dark mt-3 mb-1">
                                        No product photos available
                                    </h6>

                                    <p class="text-secondary small mb-0">
                                        The donor has not uploaded any images for this product.
                                    </p>

                                </div>

                            @endif

                        </div>


                        {{-- Request Process --}}
                        <div class="pd-process-card card">

                            <div class="card-body p-4">

                                <h6 class="fw-bold text-dark mb-3">
                                    <i class="bi bi-list-check me-2 text-primary"></i>
                                    Request Process
                                </h6>


                                <div class="pd-process-step">

                                    <span class="pd-process-number">
                                        1
                                    </span>

                                    <div>
                                        <div class="fw-semibold text-dark small">
                                            Submit Request
                                        </div>

                                        <div class="text-secondary small">
                                            Send your request for the available product.
                                        </div>
                                    </div>

                                </div>


                                <div class="pd-process-step">

                                    <span class="pd-process-number">
                                        2
                                    </span>

                                    <div>
                                        <div class="fw-semibold text-dark small">
                                            Admin Review
                                        </div>

                                        <div class="text-secondary small">
                                            The request is reviewed before it reaches the donor.
                                        </div>
                                    </div>

                                </div>


                                <div class="pd-process-step">

                                    <span class="pd-process-number">
                                        3
                                    </span>

                                    <div>
                                        <div class="fw-semibold text-dark small">
                                            Donor Decision
                                        </div>

                                        <div class="text-secondary small">
                                            The donor accepts or rejects the approved request.
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    PRODUCT INFORMATION
                ====================================================== --}}
                <div class="col-12 col-xl-7">

                    <div class="pd-card pd-main-card card h-100">

                        <div class="card-body">

                            {{-- Status --}}
                            <div class="pd-status-row">

                                @if ($isActive)

                                    <span class="pd-badge bg-success-subtle text-success">
                                        <i class="bi bi-check-circle"></i>
                                        Available
                                    </span>

                                @else

                                    <span class="pd-badge bg-danger-subtle text-danger">
                                        <i class="bi bi-x-circle"></i>
                                        Unavailable
                                    </span>

                                @endif


                                <span class="pd-badge bg-primary-subtle text-primary">
                                    <i class="bi bi-tag"></i>
                                    {{ $categoryName }}
                                </span>

                            </div>


                            {{-- Name --}}
                            <h1 class="pd-product-name">
                                {{ $product->name }}
                            </h1>


                            {{-- Small Meta --}}
                            <div class="pd-product-meta">

                                <span class="pd-meta-pill">
                                    <i class="bi bi-upc-scan"></i>
                                    Product #{{ $product->id }}
                                </span>


                                @if ($product->created_at)

                                    <span class="pd-meta-pill">
                                        <i class="bi bi-calendar3"></i>
                                        Added {{ $product->created_at->format('d M Y') }}
                                    </span>

                                @endif


                                @if (count($productImages) > 0)

                                    <span class="pd-meta-pill">
                                        <i class="bi bi-images"></i>
                                        {{ count($productImages) }}
                                        {{ count($productImages) === 1 ? 'photo' : 'photos' }}
                                    </span>

                                @endif

                            </div>


                            {{-- Facts --}}
                            <div class="pd-facts">

                                <div class="pd-fact">

                                    <span class="pd-fact-icon">
                                        <i class="bi bi-tag"></i>
                                    </span>

                                    <div class="pd-fact-label">
                                        Category
                                    </div>

                                    <div class="pd-fact-value">
                                        {{ $categoryName }}
                                    </div>

                                </div>


                                <div class="pd-fact">

                                    <span class="pd-fact-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </span>

                                    <div class="pd-fact-label">
                                        Availability
                                    </div>

                                    <div class="pd-fact-value {{ $isActive ? 'text-success' : 'text-danger' }}">
                                        {{ $isActive ? 'Available' : 'Unavailable' }}
                                    </div>

                                </div>


                                <div class="pd-fact">

                                    <span class="pd-fact-icon">
                                        <i class="bi bi-calendar-check"></i>
                                    </span>

                                    <div class="pd-fact-label">
                                        Date Added
                                    </div>

                                    <div class="pd-fact-value">
                                        {{
                                            optional(
                                                $product->created_at
                                            )->format('d M Y')
                                            ?? 'Not available'
                                        }}
                                    </div>

                                </div>

                            </div>


                            {{-- Description --}}
                            <section class="mb-4">

                                <div class="pd-section-title">

                                    <span class="pd-section-title-icon">
                                        <i class="bi bi-card-text"></i>
                                    </span>

                                    Product Description

                                </div>


                                @if ($product->description)

                                    <div class="pd-description-box">
                                        {!! nl2br(e($product->description)) !!}
                                    </div>

                                @else

                                    <div class="pd-description-box text-secondary">
                                        No description has been provided for this product.
                                    </div>

                                @endif

                            </section>


                            {{-- =================================================
                                REQUEST STATUS
                            ================================================== --}}
                            @if ($requestExists)

                                <div class="pd-request-panel is-success">

                                    <div class="d-flex align-items-start gap-3">

                                        <span class="pd-request-icon bg-success-subtle text-success">
                                            <i class="bi bi-check-circle"></i>
                                        </span>

                                        <div>

                                            <h6 class="fw-bold text-success mb-1">
                                                Request Already Submitted
                                            </h6>

                                            <p class="text-secondary small mb-0">
                                                You have already submitted a request for this product.
                                                Track its progress from your request history.
                                            </p>

                                        </div>

                                    </div>

                                </div>


                            @elseif (! $isActive)

                                <div class="pd-request-panel is-warning">

                                    <div class="d-flex align-items-start gap-3">

                                        <span class="pd-request-icon bg-warning-subtle text-warning-emphasis">
                                            <i class="bi bi-exclamation-triangle"></i>
                                        </span>

                                        <div>

                                            <h6 class="fw-bold text-warning-emphasis mb-1">
                                                Product Currently Unavailable
                                            </h6>

                                            <p class="text-secondary small mb-0">
                                                This product is inactive and cannot be requested at this time.
                                            </p>

                                        </div>

                                    </div>

                                </div>


                            @else

                                <div class="pd-request-panel is-primary">

                                    <div class="d-flex align-items-start gap-3">

                                        <span class="pd-request-icon bg-primary-subtle text-primary">
                                            <i class="bi bi-send-check"></i>
                                        </span>

                                        <div>

                                            <h6 class="fw-bold text-primary mb-1">
                                                Interested in this product?
                                            </h6>

                                            <p class="text-secondary small mb-0">
                                                Submit a request for administrator review. Once approved,
                                                the donor will be able to make the final decision.
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            @endif


                            {{-- =================================================
                                ACTIONS
                            ================================================== --}}
                            <div class="pd-actions">

                                @if ($requestExists)

                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        disabled
                                    >
                                        <i class="bi bi-check2-circle me-1"></i>
                                        Request Sent
                                    </button>


                                    <a
                                        href="{{ route('beneficiary.my.requests') }}"
                                        class="btn btn-outline-primary"
                                    >
                                        <i class="bi bi-clipboard-text me-1"></i>
                                        View My Requests
                                    </a>


                                @elseif ($isActive)

                                    <form
                                        method="POST"
                                        action="{{ route('product.request.send', $product->id) }}"
                                        id="productRequestForm"
                                    >
                                        @csrf

                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#requestConfirmationModal"
                                        >
                                            <i class="bi bi-send me-1"></i>
                                            Send Request
                                        </button>
                                    </form>


                                @else

                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        disabled
                                    >
                                        <i class="bi bi-lock me-1"></i>
                                        Product Unavailable
                                    </button>

                                @endif


                                <a
                                    href="{{ route('beneficiary.products.index') }}"
                                    class="btn btn-light border"
                                >
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Back to Products
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                RELATED PRODUCTS
            ========================================================== --}}
            @if ($relatedProducts->isNotEmpty())

                <section class="mt-5">

                    <div class="pd-related-header">

                        <div>

                            <h4 class="fw-bold text-dark mb-1">
                                Related Products
                            </h4>

                            <p class="text-secondary small mb-0">
                                Other products available in the same category.
                            </p>

                        </div>


                        <a
                            href="{{ route('beneficiary.products.index') }}"
                            class="btn btn-outline-primary btn-sm"
                        >
                            View All Products
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>

                    </div>


                    <div class="pd-related-grid">

                        @foreach ($relatedProducts as $relatedProduct)

                            @php
                                $relatedImages =
                                    is_array($relatedProduct->images)
                                        ? $relatedProduct->images
                                        : json_decode(
                                            $relatedProduct->images,
                                            true
                                        );

                                $relatedImages =
                                    is_array($relatedImages)
                                        ? array_values(
                                            array_filter(
                                                $relatedImages
                                            )
                                        )
                                        : [];

                                $relatedImage =
                                    ! empty($relatedImages)
                                        ? asset(
                                            'admins/products/'
                                            . basename($relatedImages[0])
                                        )
                                        : $fallbackImage;

                                $relatedCategory =
                                    optional($relatedProduct->category)->name
                                    ?? 'Uncategorized';

                                $relatedActive =
                                    ($relatedProduct->status ?? 'inactive')
                                    === 'active';
                            @endphp


                            <article class="pd-related-card card h-100">

                                <div class="pd-related-image-wrap">

                                    <img
                                        src="{{ $relatedImage }}"
                                        alt="{{ $relatedProduct->name }}"
                                        width="600"
                                        height="450"
                                        class="pd-related-image"
                                        loading="lazy"
                                        decoding="async"
                                        onerror="this.onerror=null;this.src='{{ $fallbackImage }}';"
                                    >

                                </div>


                                <div class="card-body p-3 d-flex flex-column">

                                    <div class="d-flex align-items-center justify-content-between gap-2 mb-3">

                                        <span
                                            class="pd-related-category"
                                            title="{{ $relatedCategory }}"
                                        >
                                            <i class="bi bi-tag"></i>
                                            {{ $relatedCategory }}
                                        </span>


                                        @if ($relatedActive)

                                            <span class="badge rounded-pill bg-success-subtle text-success">
                                                Available
                                            </span>

                                        @endif

                                    </div>


                                    <h3 class="pd-related-title fw-semibold mb-2">
                                        {{ $relatedProduct->name }}
                                    </h3>


                                    @if ($relatedProduct->description)

                                        <p class="pd-related-description mb-3">
                                            {{
                                                \Illuminate\Support\Str::limit(
                                                    strip_tags($relatedProduct->description),
                                                    105
                                                )
                                            }}
                                        </p>

                                    @else

                                        <p class="pd-related-description mb-3">
                                            View the product to see more information.
                                        </p>

                                    @endif


                                    <div class="mt-auto">

                                        <a
                                            href="{{ route('beneficiary.products.detail.show', $relatedProduct->id) }}"
                                            class="pd-related-btn btn btn-outline-primary w-100"
                                        >
                                            View Product
                                            <i class="bi bi-arrow-right ms-1"></i>
                                        </a>

                                    </div>

                                </div>

                            </article>

                        @endforeach

                    </div>

                </section>

            @endif

        </main>

    </div>


    {{-- =============================================================
        REQUEST CONFIRMATION MODAL
    ============================================================== --}}
    @if (! $requestExists && $isActive)

        <div
            class="modal fade"
            id="requestConfirmationModal"
            tabindex="-1"
            aria-labelledby="requestConfirmationLabel"
            aria-hidden="true"
        >

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">

                    <div class="modal-body text-center p-4 p-md-5">

                        <span class="pd-confirm-icon mb-3">
                            <i class="bi bi-send-check"></i>
                        </span>


                        <h5
                            class="fw-bold text-dark mb-2"
                            id="requestConfirmationLabel"
                        >
                            Submit Product Request?
                        </h5>


                        <p class="text-secondary small mb-4">
                            You are requesting
                            <strong class="text-dark">
                                {{ $product->name }}
                            </strong>.
                            Your request will first be reviewed by the administrator
                            and then forwarded to the donor.
                        </p>


                        <div class="alert alert-light border text-start small mb-4">

                            <div class="d-flex gap-2">

                                <i class="bi bi-info-circle text-primary mt-1"></i>

                                <div>
                                    Please submit only if you genuinely need this product.
                                    You can track the request later from
                                    <strong>My Requests</strong>.
                                </div>

                            </div>

                        </div>


                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">

                            <button
                                type="button"
                                class="btn btn-light border px-4"
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>


                            <button
                                type="submit"
                                form="productRequestForm"
                                id="confirmProductRequestButton"
                                class="btn btn-primary px-4"
                            >
                                <i class="bi bi-send me-1"></i>
                                Confirm Request
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endif


    @include('layouts.admin.script')


    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function () {

                /*
                |--------------------------------------------------------------------------
                | Gallery Thumbnails
                |--------------------------------------------------------------------------
                */

                const carousel =
                    document.getElementById(
                        'productImageCarousel'
                    );

                const thumbnails =
                    document.querySelectorAll(
                        '.pd-thumbnail'
                    );


                if (
                    carousel
                    && thumbnails.length
                ) {
                    carousel.addEventListener(
                        'slid.bs.carousel',
                        function (event) {

                            thumbnails.forEach(
                                function (
                                    thumbnail,
                                    index
                                ) {
                                    thumbnail.classList.toggle(
                                        'active',
                                        index === event.to
                                    );
                                }
                            );

                        }
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Prevent Duplicate Request Submission
                |--------------------------------------------------------------------------
                */

                const requestForm =
                    document.getElementById(
                        'productRequestForm'
                    );

                const confirmRequestButton =
                    document.getElementById(
                        'confirmProductRequestButton'
                    );


                if (requestForm) {

                    requestForm.addEventListener(
                        'submit',
                        function () {

                            if (confirmRequestButton) {

                                confirmRequestButton.disabled =
                                    true;

                                confirmRequestButton.innerHTML =
                                    '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>'
                                    + 'Submitting...';
                            }

                        }
                    );
                }

            }
        );
    </script>

</body>

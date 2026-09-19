@include('layouts.admin.head')

<title>Available Products</title>

<style>
    :root {
        --catalog-primary: #0d6efd;
        --catalog-primary-dark: #0a4fa3;
        --catalog-success: #198754;
        --catalog-text: #172033;
        --catalog-muted: #667085;
        --catalog-border: #e6eaf0;
        --catalog-surface: #ffffff;
        --catalog-soft: #f7f9fc;
        --catalog-shadow: 0 10px 30px rgba(16, 24, 40, 0.07);
        --catalog-shadow-hover: 0 20px 45px rgba(16, 24, 40, 0.13);
    }

    .catalog-page-header {
        position: relative;
        overflow: hidden;
        padding: 1.5rem;
        border: 1px solid var(--catalog-border);
        border-radius: 1.25rem;
        background:
            radial-gradient(
                circle at top right,
                rgba(13, 110, 253, 0.11),
                transparent 32%
            ),
            linear-gradient(
                135deg,
                #ffffff 0%,
                #f7faff 100%
            );
        box-shadow: 0 8px 28px rgba(16, 24, 40, 0.04);
    }

    .catalog-page-header::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -75px;
        bottom: -110px;
        border-radius: 50%;
        background: rgba(13, 110, 253, 0.055);
        pointer-events: none;
    }

    .catalog-header-icon {
        width: 52px;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 1rem;
        color: var(--catalog-primary);
        background: rgba(13, 110, 253, 0.09);
        font-size: 1.35rem;
    }

    .catalog-total-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.65rem 0.9rem;
        border: 1px solid #dce8ff;
        border-radius: 999px;
        background: #eef5ff;
        color: var(--catalog-primary-dark);
        font-size: 0.8rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .catalog-filter-card {
        border: 1px solid var(--catalog-border) !important;
        border-radius: 1.15rem !important;
        box-shadow: var(--catalog-shadow) !important;
    }

    .catalog-filter-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 0.85rem;
        color: var(--catalog-primary);
        background: rgba(13, 110, 253, 0.08);
    }

    .catalog-filter-card .form-control,
    .catalog-filter-card .form-select,
    .catalog-filter-card .input-group-text {
        min-height: 47px;
        border-color: #dfe4eb;
    }

    .catalog-filter-card .form-control,
    .catalog-filter-card .form-select {
        background-color: #fff;
    }

    .catalog-filter-card .form-control:focus,
    .catalog-filter-card .form-select:focus {
        border-color: #8ab6fb;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.10);
    }

    .catalog-filter-card .input-group-text {
        color: #748094;
        background: #f8fafc;
    }

    .catalog-filter-btn {
        min-height: 47px;
        border-radius: 0.75rem;
        font-weight: 600;
    }

    .catalog-active-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.55rem;
        margin-bottom: 1.25rem;
    }

    .catalog-filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        max-width: 100%;
        padding: 0.48rem 0.75rem;
        border: 1px solid #dce8ff;
        border-radius: 999px;
        color: var(--catalog-primary-dark);
        background: #f2f7ff;
        font-size: 0.76rem;
        font-weight: 600;
    }

    .catalog-results-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .catalog-results-title {
        color: var(--catalog-text);
        font-size: 1rem;
        font-weight: 700;
    }

    .catalog-results-meta {
        color: var(--catalog-muted);
        font-size: 0.8rem;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.25rem;
    }

    .catalog-product-card {
        position: relative;
        min-width: 0;
        overflow: hidden;
        border: 1px solid var(--catalog-border) !important;
        border-radius: 1.15rem !important;
        background: var(--catalog-surface);
        box-shadow: 0 6px 22px rgba(16, 24, 40, 0.055);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }

    .catalog-product-card:hover {
        transform: translateY(-6px);
        border-color: #cbdcff !important;
        box-shadow: var(--catalog-shadow-hover);
    }

    .catalog-image-wrap {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background:
            linear-gradient(
                135deg,
                #f3f6fa,
                #eef2f7
            );
    }

    .catalog-product-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform 0.45s ease;
    }

    .catalog-product-card:hover .catalog-product-image {
        transform: scale(1.045);
    }

    .catalog-image-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                to top,
                rgba(15, 23, 42, 0.34) 0%,
                rgba(15, 23, 42, 0) 42%
            );
        pointer-events: none;
    }

    .catalog-status-badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.42rem 0.65rem;
        border: 1px solid rgba(255, 255, 255, 0.45);
        border-radius: 999px;
        color: #fff;
        background: rgba(25, 135, 84, 0.94);
        font-size: 0.7rem;
        font-weight: 700;
        line-height: 1;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .catalog-status-badge.is-inactive {
        background: rgba(108, 117, 125, 0.92);
    }

    .catalog-photo-count {
        position: absolute;
        left: 0.75rem;
        bottom: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.4rem 0.58rem;
        border-radius: 0.55rem;
        color: #fff;
        background: rgba(15, 23, 42, 0.78);
        font-size: 0.7rem;
        font-weight: 600;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .catalog-product-body {
        display: flex;
        flex: 1 1 auto;
        flex-direction: column;
        padding: 1.1rem 1.1rem 0.9rem;
    }

    .catalog-product-topline {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .catalog-category {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        max-width: 100%;
        padding: 0.37rem 0.62rem;
        border-radius: 999px;
        color: var(--catalog-primary-dark);
        background: #edf4ff;
        font-size: 0.7rem;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .catalog-date {
        flex-shrink: 0;
        color: #98a2b3;
        font-size: 0.68rem;
        white-space: nowrap;
    }

    .catalog-product-title {
        margin-bottom: 0.55rem;
        color: var(--catalog-text);
        font-size: 1rem;
        font-weight: 750;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        min-height: 2.8rem;
    }

    .catalog-product-description {
        margin-bottom: 0;
        color: var(--catalog-muted);
        font-size: 0.79rem;
        line-height: 1.62;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
        min-height: 3.85rem;
    }

    .catalog-product-footer {
        padding: 0 1.1rem 1.1rem;
        border: 0;
        background: #fff;
    }

    .catalog-product-action {
        min-height: 42px;
        border-radius: 0.78rem;
        font-size: 0.8rem;
        font-weight: 700;
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .catalog-product-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(13, 110, 253, 0.2);
    }

    .catalog-empty {
        grid-column: 1 / -1;
    }

    .catalog-empty-card {
        border: 1px dashed #d8dee8 !important;
        border-radius: 1.15rem !important;
        background:
            linear-gradient(
                180deg,
                #ffffff 0%,
                #fbfcfe 100%
            );
    }

    .catalog-empty-icon {
        width: 78px;
        height: 78px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #7b8798;
        background: #f1f4f8;
        font-size: 2rem;
    }

    .catalog-pagination-card {
        border: 1px solid var(--catalog-border) !important;
        border-radius: 1rem !important;
        box-shadow: 0 5px 18px rgba(16, 24, 40, 0.045) !important;
    }

    @media (max-width: 1399.98px) {
        .products-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .products-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .catalog-page-header {
            padding: 1.15rem;
        }

        .catalog-header-icon {
            width: 46px;
            height: 46px;
            border-radius: 0.85rem;
        }

        .products-grid {
            gap: 1rem;
        }
    }

    @media (max-width: 575.98px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .catalog-results-bar {
            align-items: flex-start;
        }

        .catalog-product-title {
            min-height: auto;
        }

        .catalog-product-description {
            min-height: auto;
        }
    }
</style>

<body>

    @php
        $fallbackImage =
            asset('admins/asset/dummy/dummy.jpg');
    @endphp


    @include('layouts.admin.sidebar')


    <div class="nsn-main">

        @include('layouts.admin.header')


        <main class="nsn-content">

            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}
            <section class="catalog-page-header mb-4">

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                    <div class="d-flex align-items-center gap-3">

                        <span class="catalog-header-icon">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </span>

                        <div>
                            <h3 class="fw-bold text-dark mb-1">
                                Available Products
                            </h3>

                            <p class="text-secondary small mb-0">
                                Explore products shared by donors for the NUST community.
                            </p>
                        </div>

                    </div>


                    <span class="catalog-total-badge">
                        <i class="bi bi-box-seam"></i>

                        {{ number_format($products->total()) }}

                        {{
                            $products->total() === 1
                                ? 'product'
                                : 'products'
                        }}
                    </span>

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
                        Available Products
                    </li>

                </ol>

            </nav>


            {{-- =========================================================
                ALERT MESSAGES
            ========================================================== --}}
            @include('layouts.admin.alert')


            {{-- =========================================================
                FILTERS
            ========================================================== --}}
            <section class="card catalog-filter-card border-0 mb-4">

                <div class="card-header bg-white border-bottom px-4 py-3">

                    <div class="d-flex align-items-center gap-3">

                        <span class="catalog-filter-icon">
                            <i class="bi bi-funnel"></i>
                        </span>

                        <div>
                            <h5 class="fw-semibold text-dark mb-1">
                                Find a Product
                            </h5>

                            <p class="text-secondary small mb-0">
                                Search by product name or browse a specific category.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="card-body p-4">

                    <form
                        method="GET"
                        action="{{ route('beneficiary.products.index') }}"
                    >

                        <div class="row g-3 align-items-end">

                            {{-- Search --}}
                            <div class="col-12 col-lg-5">

                                <label
                                    for="productSearch"
                                    class="form-label fw-semibold small"
                                >
                                    Search Product
                                </label>


                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>

                                    <input
                                        type="search"
                                        id="productSearch"
                                        name="search"
                                        value="{{ request('search') }}"
                                        class="form-control"
                                        placeholder="Search by product name..."
                                        autocomplete="off"
                                    >

                                </div>

                            </div>


                            {{-- Category --}}
                            <div class="col-12 col-md-7 col-lg-4">

                                <label
                                    for="categoryFilter"
                                    class="form-label fw-semibold small"
                                >
                                    Product Category
                                </label>

                                <select
                                    name="category_id"
                                    id="categoryFilter"
                                    class="form-select"
                                >

                                    <option value="">
                                        All Categories
                                    </option>

                                    @foreach ($categories as $category)

                                        <option
                                            value="{{ $category->id }}"
                                            @selected(
                                                (string) request('category_id')
                                                ===
                                                (string) $category->id
                                            )
                                        >
                                            {{ $category->name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Apply --}}
                            <div class="col-12 col-sm-6 col-md-3 col-lg">

                                <button
                                    type="submit"
                                    class="btn btn-primary catalog-filter-btn w-100"
                                >
                                    <i class="bi bi-funnel me-1"></i>
                                    Apply
                                </button>

                            </div>


                            {{-- Reset --}}
                            <div class="col-12 col-sm-6 col-md-2 col-lg-auto">

                                <a
                                    href="{{ route('beneficiary.products.index') }}"
                                    class="btn btn-light border catalog-filter-btn w-100 px-lg-4"
                                >
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                                    Reset
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </section>


            {{-- =========================================================
                ACTIVE FILTERS
            ========================================================== --}}
            @if (
                request()->filled('search')
                || request()->filled('category_id')
            )

                @php
                    $selectedCategory =
                        request()->filled('category_id')
                            ? $categories->firstWhere(
                                'id',
                                request('category_id')
                            )
                            : null;
                @endphp


                <div class="catalog-active-filters">

                    <span class="text-secondary small fw-semibold">
                        Active filters:
                    </span>


                    @if (request()->filled('search'))

                        <span class="catalog-filter-chip">
                            <i class="bi bi-search"></i>

                            <span class="text-truncate">
                                {{ request('search') }}
                            </span>
                        </span>

                    @endif


                    @if ($selectedCategory)

                        <span class="catalog-filter-chip">
                            <i class="bi bi-tag"></i>
                            {{ $selectedCategory->name }}
                        </span>

                    @endif


                    <a
                        href="{{ route('beneficiary.products.index') }}"
                        class="small text-danger fw-semibold text-decoration-none ms-1"
                    >
                        <i class="bi bi-x-circle me-1"></i>
                        Clear all
                    </a>

                </div>

            @endif


            {{-- =========================================================
                RESULT SUMMARY
            ========================================================== --}}
            <div class="catalog-results-bar">

                <div>

                    <div class="catalog-results-title">
                        Product Catalogue
                    </div>

                    <div class="catalog-results-meta">
                        @if ($products->total() > 0)

                            Showing
                            {{ $products->firstItem() }}
                            -
                            {{ $products->lastItem() }}
                            of
                            {{ $products->total() }}
                            products

                        @else

                            No products are currently available.

                        @endif
                    </div>

                </div>


                @if (
                    request()->filled('search')
                    || request()->filled('category_id')
                )

                    <span class="badge rounded-pill bg-light text-secondary border px-3 py-2">
                        <i class="bi bi-filter-circle me-1"></i>
                        Filtered results
                    </span>

                @endif

            </div>


            {{-- =========================================================
                PRODUCT GRID
            ========================================================== --}}
            <section class="products-grid">

                @forelse ($products as $product)

                    @php
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

                        $productImage =
                            ! empty($productImages)
                                ? asset(
                                    'admins/products/'
                                    . basename($productImages[0])
                                )
                                : $fallbackImage;

                        $categoryName =
                            optional($product->category)->name
                            ?? 'Uncategorized';

                        $isActive =
                            ($product->status ?? 'active')
                            === 'active';
                    @endphp


                    <article class="catalog-product-card card h-100">

                        {{-- Product Image --}}
                        <div class="catalog-image-wrap">

                            <img
                                src="{{ $productImage }}"
                                alt="{{ $product->name }}"
                                width="600"
                                height="450"
                                class="catalog-product-image"
                                loading="lazy"
                                decoding="async"
                                onerror="this.onerror=null;this.src='{{ $fallbackImage }}';"
                            >

                            <div class="catalog-image-overlay"></div>


                            <span class="catalog-status-badge {{ $isActive ? '' : 'is-inactive' }}">

                                @if ($isActive)
                                    <i class="bi bi-check-circle"></i>
                                    Available
                                @else
                                    <i class="bi bi-pause-circle"></i>
                                    Unavailable
                                @endif

                            </span>


                            @if (count($productImages) > 1)

                                <span class="catalog-photo-count">
                                    <i class="bi bi-images"></i>

                                    {{ count($productImages) }}

                                    {{
                                        count($productImages) === 1
                                            ? 'photo'
                                            : 'photos'
                                    }}
                                </span>

                            @endif

                        </div>


                        {{-- Card Body --}}
                        <div class="catalog-product-body card-body">

                            <div class="catalog-product-topline">

                                <span
                                    class="catalog-category"
                                    title="{{ $categoryName }}"
                                >
                                    <i class="bi bi-tag"></i>
                                    {{ $categoryName }}
                                </span>


                                @if ($product->created_at)

                                    <span
                                        class="catalog-date"
                                        title="{{ $product->created_at->format('d M Y, h:i A') }}"
                                    >
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $product->created_at->format('d M Y') }}
                                    </span>

                                @endif

                            </div>


                            <h2
                                class="catalog-product-title"
                                title="{{ $product->name }}"
                            >
                                {{ $product->name }}
                            </h2>


                            @if ($product->description)

                                <p class="catalog-product-description">
                                    {{
                                        \Illuminate\Support\Str::limit(
                                            strip_tags($product->description),
                                            125
                                        )
                                    }}
                                </p>

                            @else

                                <p class="catalog-product-description">
                                    No description has been provided for this product.
                                </p>

                            @endif

                        </div>


                        {{-- Card Footer --}}
                        <div class="catalog-product-footer card-footer">

                            <a
                                href="{{ route('beneficiary.products.detail.show', $product->id) }}"
                                class="catalog-product-action btn btn-primary d-flex align-items-center justify-content-center gap-2 w-100"
                                aria-label="View details for {{ $product->name }}"
                            >
                                <span>
                                    View Product
                                </span>

                                <i class="bi bi-arrow-right"></i>
                            </a>

                        </div>

                    </article>


                @empty

                    <div class="catalog-empty">

                        <div class="card catalog-empty-card border-0">

                            <div class="card-body text-center py-5 px-4">

                                <span class="catalog-empty-icon mb-3">
                                    <i class="bi bi-search"></i>
                                </span>


                                <h5 class="fw-bold text-dark mb-2">

                                    @if (
                                        request()->filled('search')
                                        || request()->filled('category_id')
                                    )
                                        No matching products
                                    @else
                                        No products available
                                    @endif

                                </h5>


                                <p class="text-secondary small mb-4">

                                    @if (
                                        request()->filled('search')
                                        || request()->filled('category_id')
                                    )
                                        We could not find any products matching your current filters.
                                        Try another search term or category.
                                    @else
                                        There are currently no products available for beneficiaries.
                                        Please check again later.
                                    @endif

                                </p>


                                @if (
                                    request()->filled('search')
                                    || request()->filled('category_id')
                                )

                                    <a
                                        href="{{ route('beneficiary.products.index') }}"
                                        class="btn btn-primary btn-sm px-4"
                                    >
                                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                                        Clear Filters
                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>

                @endforelse

            </section>


            {{-- =========================================================
                PAGINATION
            ========================================================== --}}
            @if ($products->hasPages())

                <section class="card catalog-pagination-card border-0 mt-4">

                    <div class="card-body px-4 py-3">

                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">

                            <p class="text-secondary small mb-0">

                                Showing

                                <span class="fw-semibold text-dark">
                                    {{ $products->firstItem() }}
                                </span>

                                to

                                <span class="fw-semibold text-dark">
                                    {{ $products->lastItem() }}
                                </span>

                                of

                                <span class="fw-semibold text-dark">
                                    {{ $products->total() }}
                                </span>

                                products

                            </p>


                            <div>
                                {{ $products->withQueryString()->links() }}
                            </div>

                        </div>

                    </div>

                </section>

            @endif

        </main>

    </div>


    @include('layouts.admin.script')

</body>

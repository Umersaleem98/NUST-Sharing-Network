        @include('layouts.admin.head')

        <title>Manage Products</title>

        <body>

        {{-- New Sidebar --}}
        @include('layouts.admin.sidebar')


        {{-- Main Content --}}
        <div class="nsn-main">

        {{-- New Topbar --}}
        @include('layouts.admin.header')


        <main class="nsn-content">

        {{-- Page Header --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

            <div>
                <h3 class="fw-bold text-dark mb-1">
                    Products
                </h3>

                <p class="text-secondary small mb-0">
                    Manage products submitted to the NUST Sharing Network.
                </p>
            </div>

            <button
                type="button"
                class="btn btn-primary d-flex align-items-center gap-2"
                data-bs-toggle="modal"
                data-bs-target="#addProductModal"
            >
                <i class="bi bi-plus-lg"></i>
                <span>Add Product</span>
            </button>

        </div>


        {{-- Breadcrumb --}}
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
                    Products
                </li>

            </ol>
        </nav>


        {{-- Alert Messages --}}
        @include('layouts.admin.alert')


        {{-- Products Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            {{-- Card Header --}}
            <div class="card-header bg-white border-bottom px-4 py-3">

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                    <div>
                        <h5 class="fw-semibold text-dark mb-1">
                            All Products
                        </h5>

                        <p class="text-secondary small mb-0">
                            Total products:
                            <span class="fw-semibold text-dark">
                                {{ $products->total() }}
                            </span>
                        </p>
                    </div>

                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                        <i class="bi bi-box-seam me-1"></i>
                        {{ $products->count() }} displayed
                    </span>

                </div>

            </div>


            {{-- Products Table --}}
            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3 text-secondary small">
                                    #
                                </th>

                                <th class="py-3 text-secondary small">
                                    Product
                                </th>

                                <th class="py-3 text-secondary small">
                                    Category
                                </th>

                                <th class="py-3 text-secondary small">
                                    Added By
                                </th>

                                <th class="py-3 text-secondary small">
                                    Status
                                </th>

                                <th class="px-4 py-3 text-secondary small text-end">
                                    Actions
                                </th>
                            </tr>
                        </thead>


                        <tbody>

                            @forelse ($products as $key => $product)

                                @php
                                    $images = is_array($product->images)
                                        ? $product->images
                                        : json_decode($product->images, true);

                                    $images = is_array($images) ? $images : [];

                                    $productUser = $product->user;
                                @endphp

                                <tr>

                                    {{-- Number --}}
                                    <td class="px-4">
                                        <span class="text-secondary">
                                            {{ $products->firstItem() + $key }}
                                        </span>
                                    </td>


                                    {{-- Product --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            @if (!empty($images))
                                                <img
                                                    src="{{ asset('admins/products/' . $images[0]) }}"
                                                    alt="{{ $product->name }}"
                                                    width="58"
                                                    height="58"
                                                    class="rounded-3 border object-fit-cover flex-shrink-0"
                                                >
                                            @else
                                                <span
                                                    class="d-inline-flex align-items-center justify-content-center rounded-3 bg-light border text-secondary flex-shrink-0"
                                                    style="width: 58px; height: 58px;"
                                                >
                                                    <i class="bi bi-image fs-5"></i>
                                                </span>
                                            @endif

                                            <div>
                                                <div class="fw-semibold text-dark">
                                                    {{ $product->name }}
                                                </div>

                                                <small class="text-secondary">
                                                    ID: {{ $product->id }}
                                                </small>
                                            </div>

                                        </div>
                                    </td>


                                    {{-- Category --}}
                                    <td>
                                        <span class="badge bg-light text-secondary border fw-normal">
                                            <i class="bi bi-tag me-1"></i>
                                            {{ optional($product->category)->name ?? 'Not assigned' }}
                                        </span>
                                    </td>


                                    {{-- Added By --}}
                                    <td>
                                        @if ($productUser)

                                            <div class="d-flex align-items-center gap-2">

                                                @if ($productUser->image)
                                                    <img
                                                        src="{{ asset('admins/asset/profilephoto/' . $productUser->image) }}"
                                                        alt="{{ $productUser->name }}"
                                                        width="34"
                                                        height="34"
                                                        class="rounded-circle border object-fit-cover"
                                                    >
                                                @else
                                                    <span
                                                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-semibold"
                                                        style="width: 34px; height: 34px;"
                                                    >
                                                        {{ strtoupper(substr($productUser->name, 0, 1)) }}
                                                    </span>
                                                @endif

                                                <div>
                                                    <div class="small fw-semibold text-dark">
                                                        {{ $productUser->name }}
                                                    </div>

                                                    <button
                                                        type="button"
                                                        class="btn btn-link btn-sm text-decoration-none p-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#userModal{{ $product->id }}"
                                                    >
                                                        View profile
                                                    </button>
                                                </div>

                                            </div>

                                        @else
                                            <span class="text-secondary small">
                                                User unavailable
                                            </span>
                                        @endif
                                    </td>


                                    {{-- Status --}}
                                    <td>
                                        @if ($product->status === 'active')
                                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Active
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-4 text-end">

                                        <div class="d-inline-flex align-items-center gap-2">

                                            <a
                                                href="{{ route('admin.product.edit', $product->id) }}"
                                                class="btn btn-outline-warning btn-sm"
                                                title="Edit product"
                                            >
                                                <i class="bi bi-pencil-square me-1"></i>
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.products.delete', $product->id) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Delete product"
                                                >
                                                    <i class="bi bi-trash3 me-1"></i>
                                                    Delete
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-5">

                                        <div class="d-flex flex-column align-items-center">

                                            <span
                                                class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-secondary mb-3"
                                                style="width: 64px; height: 64px;"
                                            >
                                                <i class="bi bi-box-seam fs-3"></i>
                                            </span>

                                            <h6 class="fw-semibold text-dark mb-1">
                                                No products found
                                            </h6>

                                            <p class="text-secondary small mb-3">
                                                Add your first product to get started.
                                            </p>

                                            <button
                                                type="button"
                                                class="btn btn-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addProductModal"
                                            >
                                                <i class="bi bi-plus-lg me-1"></i>
                                                Add Product
                                            </button>

                                        </div>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Pagination --}}
            @if ($products->hasPages())

                <div class="card-footer bg-white border-top px-4 py-3">

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

            @endif

        </div>

        </main>

        </div>


        {{-- ===================================================== --}}
        {{-- USER PROFILE MODALS --}}
        {{-- ===================================================== --}}
        @foreach ($products as $product)

        @php
        $productUser = $product->user;
        @endphp

        @if ($productUser)

        <div
            class="modal fade"
            id="userModal{{ $product->id }}"
            tabindex="-1"
            aria-labelledby="userModalLabel{{ $product->id }}"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow rounded-4">

                    {{-- Header --}}
                    <div class="modal-header border-bottom px-4 py-3">

                        <h5
                            class="modal-title fw-bold"
                            id="userModalLabel{{ $product->id }}"
                        >
                            User Profile
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>


                    {{-- Body --}}
                    <div class="modal-body p-4">

                        <div class="text-center mb-4">

                            @if ($productUser->image)
                                <img
                                    src="{{ asset('admins/asset/profilephoto/' . $productUser->image) }}"
                                    alt="{{ $productUser->name }}"
                                    width="105"
                                    height="105"
                                    class="rounded-circle border border-3 object-fit-cover mb-3"
                                >
                            @else
                                <span
                                    class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary fw-bold fs-2 mb-3"
                                    style="width: 105px; height: 105px;"
                                >
                                    {{ strtoupper(substr($productUser->name, 0, 1)) }}
                                </span>
                            @endif

                            <h5 class="fw-bold text-dark mb-1">
                                {{ $productUser->name }}
                            </h5>

                            <p class="text-secondary small mb-2">
                                {{ $productUser->email }}
                            </p>

                            <span class="badge rounded-pill bg-primary-subtle text-primary text-capitalize px-3 py-2">
                                {{ $productUser->role }}
                            </span>

                        </div>


                        <div class="border rounded-3 overflow-hidden">

                            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                <span class="text-secondary small">
                                    <i class="bi bi-person-badge me-2"></i>
                                    User ID
                                </span>

                                <span class="fw-semibold text-dark">
                                    #{{ $productUser->id }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                <span class="text-secondary small">
                                    <i class="bi bi-envelope me-2"></i>
                                    Email
                                </span>

                                <span class="fw-semibold text-dark small">
                                    {{ $productUser->email }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center p-3">
                                <span class="text-secondary small">
                                    <i class="bi bi-box-seam me-2"></i>
                                    Total Products
                                </span>

                                <span class="fw-semibold text-dark">
                                    {{ $productUser->products->count() }}
                                </span>
                            </div>

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="modal-footer border-top px-4 py-3">

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


        {{-- ===================================================== --}}
        {{-- ADD PRODUCT MODAL --}}
        {{-- ===================================================== --}}
        <div
        class="modal fade"
        id="addProductModal"
        tabindex="-1"
        aria-labelledby="addProductModalLabel"
        aria-hidden="true"
        >
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content border-0 shadow rounded-4">

            <form
                action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf


                {{-- Modal Header --}}
                <div class="modal-header border-bottom px-4 py-3">

                    <div>
                        <h5
                            class="modal-title fw-bold"
                            id="addProductModalLabel"
                        >
                            <i class="bi bi-box-seam me-2"></i>
                            Add New Product
                        </h5>

                        <p class="text-secondary small mb-0 mt-1">
                            Enter product information and upload its images.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                {{-- Modal Body --}}
                <div class="modal-body p-4">

                    <div class="row g-4">

                        {{-- Category --}}
                        <div class="col-12 col-md-6">

                            <label
                                for="category_id"
                                class="form-label fw-semibold"
                            >
                                Category
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="category_id"
                                id="category_id"
                                class="form-select @error('category_id') is-invalid @enderror"
                                required
                            >
                                <option value="">
                                    Select category
                                </option>

                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @selected(old('category_id') == $category->id)
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Product Name --}}
                        <div class="col-12 col-md-6">

                            <label
                                for="product_name"
                                class="form-label fw-semibold"
                            >
                                Product Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="product_name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter product name"
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Slug --}}
                        <div class="col-12 col-md-6">

                            <label
                                for="product_slug"
                                class="form-label fw-semibold"
                            >
                                Product Slug
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light">
                                    <i class="bi bi-link-45deg"></i>
                                </span>

                                <input
                                    type="text"
                                    name="slug"
                                    id="product_slug"
                                    value="{{ old('slug') }}"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    placeholder="Auto-generated slug"
                                    required
                                >

                                @error('slug')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="col-12 col-md-6">

                            <label
                                for="status"
                                class="form-label fw-semibold"
                            >
                                Status
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required
                            >
                                <option
                                    value="active"
                                    @selected(old('status', 'active') === 'active')
                                >
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    @selected(old('status') === 'inactive')
                                >
                                    Inactive
                                </option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="col-12">

                            <label
                                for="description"
                                class="form-label fw-semibold"
                            >
                                Product Description
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="5"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Write product details here..."
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Product Images --}}
                        <div class="col-12">

                            <label
                                for="productImages"
                                class="form-label fw-semibold"
                            >
                                Product Images
                            </label>

                            <div class="border border-2 border-secondary-subtle rounded-4 bg-light p-4 text-center">

                                <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>

                                <h6 class="fw-semibold text-dark mt-2 mb-1">
                                    Upload Product Images
                                </h6>

                                <p class="text-secondary small mb-3">
                                    You can select multiple JPG, PNG or WebP images.
                                </p>

                                <input
                                    type="file"
                                    id="productImages"
                                    name="images[]"
                                    class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                    multiple
                                    accept="image/*"
                                >

                                @error('images')
                                    <div class="invalid-feedback text-start">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @error('images.*')
                                    <div class="invalid-feedback text-start">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div
                                    id="imagePreview"
                                    class="d-flex flex-wrap justify-content-center gap-2 mt-3"
                                ></div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Modal Footer --}}
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
                        <i class="bi bi-check2-circle me-1"></i>
                        Save Product
                    </button>

                </div>

            </form>

        </div>

        </div>
        </div>


        @include('layouts.admin.script')


        <script>
        document.addEventListener('DOMContentLoaded', function () {
        const productName = document.getElementById('product_name');
        const productSlug = document.getElementById('product_slug');
        const productImages = document.getElementById('productImages');
        const imagePreview = document.getElementById('imagePreview');

        if (productName && productSlug) {
            productName.addEventListener('input', function () {
                productSlug.value = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            });
        }

        if (productImages && imagePreview) {
            productImages.addEventListener('change', function () {
                imagePreview.innerHTML = '';

                Array.from(this.files).forEach(function (file) {
                    if (!file.type.startsWith('image/')) {
                        return;
                    }

                    const reader = new FileReader();

                    reader.addEventListener('load', function (event) {
                        const image = document.createElement('img');

                        image.src = event.target.result;
                        image.alt = file.name;
                        image.width = 90;
                        image.height = 90;
                        image.className =
                            'rounded-3 border bg-white object-fit-cover p-1';

                        imagePreview.appendChild(image);
                    });

                    reader.readAsDataURL(file);
                });
            });
        }

        @if ($errors->any())
            const addProductModal =
                document.getElementById('addProductModal');

            if (addProductModal) {
                bootstrap.Modal
                    .getOrCreateInstance(addProductModal)
                    .show();
            }
        @endif
        });
        </script>

        </body>

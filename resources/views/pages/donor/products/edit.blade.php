@include('layouts.admin.head')

<title>Update Product</title>

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
                        Update Product
                    </h3>

                    <p class="text-secondary small mb-0">
                        Update your product information, status and images.
                    </p>
                </div>

                <a
                    href="{{ route('donor.product.index') }}"
                    class="btn btn-light border d-flex align-items-center gap-2"
                >
                    <i class="bi bi-arrow-left"></i>
                    <span>Back to Products</span>
                </a>

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

                    <li class="breadcrumb-item">
                        <a
                            href="{{ route('donor.product.index') }}"
                            class="text-decoration-none"
                        >
                            My Products
                        </a>
                    </li>

                    <li
                        class="breadcrumb-item active"
                        aria-current="page"
                    >
                        Update Product
                    </li>

                </ol>

            </nav>


            {{-- Alert Messages --}}
            @include('layouts.admin.alert')


            {{-- Global Validation Errors --}}
            @if ($errors->any())

                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    <div class="d-flex gap-3">

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        <div>
                            <h6 class="alert-heading fw-semibold mb-2">
                                Please correct the following errors:
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


            @php
                $currentImages = is_array($product->images)
                    ? $product->images
                    : json_decode($product->images, true);

                $currentImages = is_array($currentImages)
                    ? $currentImages
                    : [];
            @endphp


            <div class="row justify-content-center">

                <div class="col-12 col-xl-10">

                    <form
                        method="POST"
                        action="{{ route('donor.product.update', $product->id) }}"
                        enctype="multipart/form-data"
                        id="updateForm"
                    >
                        @csrf
                        @method('PUT')


                        <div class="row g-4">

                            {{-- Product Information --}}
                            <div class="col-12 col-lg-8">

                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                                    {{-- Card Header --}}
                                    <div class="card-header bg-white border-bottom px-4 py-3">

                                        <div class="d-flex align-items-center gap-3">

                                            <span
                                                class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary flex-shrink-0"
                                                style="width: 46px; height: 46px;"
                                            >
                                                <i class="bi bi-pencil-square fs-5"></i>
                                            </span>

                                            <div>
                                                <h5 class="fw-semibold text-dark mb-1">
                                                    Product Information
                                                </h5>

                                                <p class="text-secondary small mb-0">
                                                    Editing:
                                                    <span class="fw-semibold">
                                                        {{ $product->name }}
                                                    </span>
                                                </p>
                                            </div>

                                        </div>

                                    </div>


                                    {{-- Card Body --}}
                                    <div class="card-body p-4">

                                        <div class="row g-4">

                                            {{-- Product Name --}}
                                            <div class="col-12">

                                                <label
                                                    for="productName"
                                                    class="form-label fw-semibold"
                                                >
                                                    Product Name
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <div class="input-group">

                                                    <span class="input-group-text bg-light">
                                                        <i class="bi bi-box"></i>
                                                    </span>

                                                    <input
                                                        type="text"
                                                        id="productName"
                                                        name="name"
                                                        value="{{ old('name', $product->name) }}"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="Enter product name"
                                                        required
                                                        autofocus
                                                    >

                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>

                                            </div>


                                            {{-- Category --}}
                                            <div class="col-12 col-md-6">

                                                <label
                                                    for="categoryId"
                                                    class="form-label fw-semibold"
                                                >
                                                    Category
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select
                                                    name="category_id"
                                                    id="categoryId"
                                                    class="form-select @error('category_id') is-invalid @enderror"
                                                    required
                                                >
                                                    <option value="">
                                                        Select category
                                                    </option>

                                                    @foreach ($categories as $category)
                                                        <option
                                                            value="{{ $category->id }}"
                                                            @selected(
                                                                old(
                                                                    'category_id',
                                                                    $product->category_id
                                                                ) == $category->id
                                                            )
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


                                            {{-- Status --}}
                                            <div class="col-12 col-md-6">

                                                <label
                                                    for="productStatus"
                                                    class="form-label fw-semibold"
                                                >
                                                    Status
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select
                                                    name="status"
                                                    id="productStatus"
                                                    class="form-select @error('status') is-invalid @enderror"
                                                    required
                                                >
                                                    <option value="">
                                                        Select status
                                                    </option>

                                                    <option
                                                        value="active"
                                                        @selected(
                                                            old(
                                                                'status',
                                                                $product->status
                                                            ) === 'active'
                                                        )
                                                    >
                                                        Active
                                                    </option>

                                                    <option
                                                        value="inactive"
                                                        @selected(
                                                            old(
                                                                'status',
                                                                $product->status
                                                            ) === 'inactive'
                                                        )
                                                    >
                                                        Inactive
                                                    </option>
                                                </select>

                                                @error('status')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <div class="form-text">
                                                    Inactive products will not be shown to beneficiaries.
                                                </div>

                                            </div>


                                            {{-- Description --}}
                                            <div class="col-12">

                                                <label
                                                    for="productDescription"
                                                    class="form-label fw-semibold"
                                                >
                                                    Product Description
                                                </label>

                                                <textarea
                                                    name="description"
                                                    id="productDescription"
                                                    rows="7"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    placeholder="Describe the product, its condition and other important details..."
                                                >{{ old('description', $product->description) }}</textarea>

                                                @error('description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <div class="form-text">
                                                    Include the condition and any important usage information.
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- Images Section --}}
                            <div class="col-12 col-lg-4">

                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                                    {{-- Card Header --}}
                                    <div class="card-header bg-white border-bottom px-4 py-3">

                                        <h5 class="fw-semibold text-dark mb-1">
                                            Product Images
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            View or replace the current images.
                                        </p>

                                    </div>


                                    <div class="card-body p-4">

                                        {{-- Current Images --}}
                                        <div class="mb-4">

                                            <label class="form-label fw-semibold">
                                                Current Images
                                            </label>

                                            @if (!empty($currentImages))

                                                <div class="row g-2">

                                                    @foreach ($currentImages as $image)

                                                        <div class="col-6">

                                                            <div class="border rounded-3 bg-light p-1">

                                                                <img
                                                                    src="{{ asset('admins/products/' . $image) }}"
                                                                    alt="{{ $product->name }}"
                                                                    width="150"
                                                                    height="110"
                                                                    class="img-fluid rounded-2 object-fit-cover w-100"
                                                                >

                                                            </div>

                                                        </div>

                                                    @endforeach

                                                </div>

                                            @else

                                                <div class="border rounded-3 bg-light text-center p-4">

                                                    <i class="bi bi-image text-secondary fs-2"></i>

                                                    <p class="text-secondary small mb-0 mt-2">
                                                        No current images found.
                                                    </p>

                                                </div>

                                            @endif

                                        </div>


                                        {{-- Replace Images --}}
                                        <div>

                                            <label
                                                for="imageInput"
                                                class="form-label fw-semibold"
                                            >
                                                Replace Images
                                            </label>

                                            <input
                                                type="file"
                                                id="imageInput"
                                                name="images[]"
                                                class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                                multiple
                                            >

                                            @error('images')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            @error('images.*')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <div class="form-text">
                                                Leave empty to keep existing images.
                                                Maximum size is 200 KB per image.
                                            </div>

                                        </div>


                                        {{-- Requirements --}}
                                        <div class="border rounded-3 mt-3 p-3">

                                            <h6 class="fw-semibold text-dark small mb-2">
                                                Image requirements
                                            </h6>

                                            <ul class="text-secondary small ps-3 mb-0">
                                                <li>JPG, JPEG, PNG or WebP</li>
                                                <li>Maximum 200 KB per image</li>
                                                <li>Maximum 5 images per product</li>
                                                <li>Multiple images are allowed</li>
                                            </ul>

                                        </div>


                                        {{-- JavaScript Error --}}
                                        <div
                                            id="imageError"
                                            class="alert alert-danger small mt-3 mb-0 d-none"
                                            role="alert"
                                        ></div>


                                        {{-- New Image Preview --}}
                                        <div
                                            id="imagePreview"
                                            class="row g-2 mt-2"
                                        ></div>

                                    </div>

                                </div>

                            </div>


                            {{-- Form Actions --}}
                            <div class="col-12">

                                <div class="card border-0 shadow-sm rounded-4">

                                    <div class="card-body px-4 py-3">

                                        <div class="d-flex flex-column-reverse flex-sm-row align-items-sm-center justify-content-between gap-3">

                                            <p class="text-secondary small mb-0">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Selecting new images will replace all current images.
                                            </p>

                                            <div class="d-flex flex-column-reverse flex-sm-row gap-2">

                                                <a
                                                    href="{{ route('donor.product.index') }}"
                                                    class="btn btn-light border"
                                                >
                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Cancel
                                                </a>

                                                <button
                                                    type="submit"
                                                    id="updateProductButton"
                                                    class="btn btn-primary"
                                                >
                                                    <i class="bi bi-check2-circle me-1"></i>
                                                    Update Product
                                                </button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </main>

    </div>


    @include('layouts.admin.script')


    {{-- Image Validation and Preview --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput =
                document.getElementById('imageInput');

            const imagePreview =
                document.getElementById('imagePreview');

            const imageError =
                document.getElementById('imageError');

            const updateButton =
                document.getElementById('updateProductButton');

            const maximumImageSize = 200 * 1024;
            const maximumImageCount = 5;

            const validImageTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];


            if (
                !imageInput ||
                !imagePreview ||
                !imageError
            ) {
                return;
            }


            imageInput.addEventListener('change', function () {
                imagePreview.innerHTML = '';
                imageError.innerHTML = '';
                imageError.classList.add('d-none');

                if (updateButton) {
                    updateButton.disabled = false;
                }

                const files = Array.from(this.files);
                const validationErrors = [];

                if (files.length > maximumImageCount) {
                    imageError.textContent =
                        'You can upload a maximum of 5 product images.';

                    imageError.classList.remove('d-none');
                    this.value = '';
                    imagePreview.innerHTML = '';

                    if (updateButton) {
                        updateButton.disabled = true;
                    }

                    return;
                }


                files.forEach(function (file) {
                    if (!validImageTypes.includes(file.type)) {
                        validationErrors.push(
                            file.name + ' has an unsupported format.'
                        );

                        return;
                    }

                    if (file.size > maximumImageSize) {
                        validationErrors.push(
                            file.name + ' is larger than 200 KB.'
                        );

                        return;
                    }


                    const reader = new FileReader();

                    reader.addEventListener('load', function (event) {
                        const column =
                            document.createElement('div');

                        column.className = 'col-6';


                        const container =
                            document.createElement('div');

                        container.className =
                            'border rounded-3 bg-light p-1';


                        const image =
                            document.createElement('img');

                        image.src = event.target.result;
                        image.alt = file.name;
                        image.width = 150;
                        image.height = 110;
                        image.className =
                            'img-fluid rounded-2 object-fit-cover w-100';


                        const fileName =
                            document.createElement('small');

                        fileName.className =
                            'd-block text-secondary text-truncate px-1 py-1';

                        fileName.textContent = file.name;


                        container.appendChild(image);
                        container.appendChild(fileName);
                        column.appendChild(container);
                        imagePreview.appendChild(column);
                    });

                    reader.readAsDataURL(file);
                });


                if (validationErrors.length > 0) {
                    imageError.innerHTML = '';

                    const errorTitle =
                        document.createElement('strong');

                    errorTitle.textContent =
                        'Image upload error:';

                    const errorList =
                        document.createElement('ul');

                    errorList.className =
                        'mb-0 mt-1 ps-3';

                    validationErrors.forEach(function (message) {
                        const item =
                            document.createElement('li');

                        item.textContent = message;
                        errorList.appendChild(item);
                    });

                    imageError.appendChild(errorTitle);
                    imageError.appendChild(errorList);
                    imageError.classList.remove('d-none');

                    this.value = '';
                    imagePreview.innerHTML = '';

                    if (updateButton) {
                        updateButton.disabled = true;
                    }
                }
            });
        });
    </script>

</body>

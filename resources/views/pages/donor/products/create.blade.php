@include('layouts.admin.head')

<title>Add Donor Product</title>

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
                        Add Product
                    </h3>

                    <p class="text-secondary small mb-0">
                        Share a product with the NUST community.
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
                        Add Product
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


            <div class="row justify-content-center">

                <div class="col-12 col-xl-10">

                    <form
                        method="POST"
                        action="{{ route('donor.product.store') }}"
                        enctype="multipart/form-data"
                        id="productForm"
                    >
                        @csrf


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
                                                <i class="bi bi-box-seam fs-5"></i>
                                            </span>

                                            <div>
                                                <h5 class="fw-semibold text-dark mb-1">
                                                    Product Information
                                                </h5>

                                                <p class="text-secondary small mb-0">
                                                    Provide clear and accurate product details.
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
                                                        value="{{ old('name') }}"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="For example: Study Table"
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

                                                <div class="form-text">
                                                    Active products can be viewed by beneficiaries.
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
                                                    placeholder="Describe the product, its condition, specifications and other important details..."
                                                >{{ old('description') }}</textarea>

                                                @error('description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <div class="form-text">
                                                    Include the product condition and any important usage information.
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- Product Images --}}
                            <div class="col-12 col-lg-4">

                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                                    {{-- Card Header --}}
                                    <div class="card-header bg-white border-bottom px-4 py-3">

                                        <h5 class="fw-semibold text-dark mb-1">
                                            Product Images
                                        </h5>

                                        <p class="text-secondary small mb-0">
                                            Upload clear images of the product.
                                        </p>

                                    </div>


                                    <div class="card-body p-4">

                                        <div class="border border-2 border-secondary-subtle rounded-4 bg-light p-4 text-center">

                                            <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>

                                            <h6 class="fw-semibold text-dark mt-2 mb-1">
                                                Upload Images
                                            </h6>

                                            <p class="text-secondary small mb-3">
                                                Select one or multiple product images.
                                            </p>

                                            <input
                                                type="file"
                                                id="imageInput"
                                                name="images[]"
                                                class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                                multiple
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

                                        </div>


                                        {{-- Upload Requirements --}}
                                        <div class="border rounded-3 mt-3 p-3">

                                            <h6 class="fw-semibold text-dark small mb-2">
                                                Image requirements
                                            </h6>

                                            <ul class="text-secondary small ps-3 mb-0">
                                                <li>JPG, JPEG, PNG or WebP</li>
                                                <li>Maximum 200 KB per image</li>
                                                <li>Maximum 5 images per product</li>
                                                <li>Multiple images are allowed</li>
                                                <li>Use clear and well-lit images</li>
                                            </ul>

                                        </div>


                                        {{-- Image Validation Message --}}
                                        <div
                                            id="imageError"
                                            class="alert alert-danger small mt-3 mb-0 d-none"
                                            role="alert"
                                        ></div>


                                        {{-- Image Preview --}}
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
                                                Review your product information before submitting.
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
                                                    id="submitProductButton"
                                                    class="btn btn-primary"
                                                >
                                                    <i class="bi bi-check2-circle me-1"></i>
                                                    Save Product
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


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput =
                document.getElementById('imageInput');

            const imagePreview =
                document.getElementById('imagePreview');

            const imageError =
                document.getElementById('imageError');

            const submitButton =
                document.getElementById('submitProductButton');

            const maximumImageSize = 200 * 1024;
            const maximumImageCount = 5;


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

                if (submitButton) {
                    submitButton.disabled = false;
                }

                const files = Array.from(this.files);
                const invalidFiles = [];

                if (files.length > maximumImageCount) {
                    imageError.textContent =
                        'You can upload a maximum of 5 product images.';

                    imageError.classList.remove('d-none');
                    this.value = '';
                    imagePreview.innerHTML = '';

                    if (submitButton) {
                        submitButton.disabled = true;
                    }

                    return;
                }


                files.forEach(function (file) {
                    const validImageTypes = [
                        'image/jpeg',
                        'image/png',
                        'image/webp'
                    ];

                    if (!validImageTypes.includes(file.type)) {
                        invalidFiles.push(
                            file.name + ' has an unsupported format.'
                        );

                        return;
                    }

                    if (file.size > maximumImageSize) {
                        invalidFiles.push(
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
                        image.width = 120;
                        image.height = 100;
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


                if (invalidFiles.length > 0) {
                    imageError.innerHTML = '';

                    const errorTitle =
                        document.createElement('strong');

                    errorTitle.textContent =
                        'Image upload error:';

                    const errorList =
                        document.createElement('ul');

                    errorList.className =
                        'mb-0 mt-1 ps-3';

                    invalidFiles.forEach(function (message) {
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

                    if (submitButton) {
                        submitButton.disabled = true;
                    }
                }
            });
        });
    </script>

</body>

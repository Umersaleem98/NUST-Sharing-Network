@include('layouts.admins.head')
<title>Edit Product</title>
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
                        Edit Product
                    </h3>


                    <p class="text-muted mb-0">

                        Update

                        <strong>
                            {{ $product->name }}
                        </strong>

                    </p>

                </div>


                <div class="col-md-4 text-md-right">

                    <a
                        href="{{ route('donor.products.index') }}"
                        class="btn btn-secondary"
                    >

                        <i class="fa fa-arrow-left mr-1"></i>

                        My Products

                    </a>

                </div>

            </div>


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


            <div class="row">


                <div class="col-lg-8">


                    <div class="card">

                        <div class="card-body">


                            <h4 class="card-title mb-4">
                                Product Information
                            </h4>


                            <form
                                action="{{ route('donor.products.update', $product) }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >

                                @csrf

                                @method('PUT')


                                <div class="row">


                                    {{-- Name --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Product Name

                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>


                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ old('name', $product->name) }}"
                                                class="form-control"
                                                required
                                            >

                                        </div>

                                    </div>


                                    {{-- Category --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Category

                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>


                                            <select
                                                name="category_id"
                                                class="form-control"
                                                required
                                            >

                                                @foreach($categories as $category)

                                                    <option
                                                        value="{{ $category->id }}"
                                                        {{
                                                            old(
                                                                'category_id',
                                                                $product->category_id
                                                            ) == $category->id
                                                                ? 'selected'
                                                                : ''
                                                        }}
                                                    >

                                                        {{ $category->name }}

                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>

                                    </div>


                                    {{-- Description --}}

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                Description
                                            </label>


                                            <textarea
                                                name="description"
                                                class="form-control"
                                                rows="6"
                                            >{{ old('description', $product->description) }}</textarea>

                                        </div>

                                    </div>


                                    {{-- Image --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Replace Product Image
                                            </label>


                                            <input
                                                type="file"
                                                name="image"
                                                id="productImage"
                                                class="form-control"
                                                accept=".jpg,.jpeg,.png,.webp"
                                            >


                                            <small class="text-muted">

                                                Leave blank to keep the current image.

                                            </small>

                                        </div>

                                    </div>


                                    {{-- Status --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Status
                                            </label>


                                            <select
                                                name="status"
                                                class="form-control"
                                                required
                                            >

                                                <option
                                                    value="active"
                                                    {{ old('status', $product->status) === 'active' ? 'selected' : '' }}
                                                >
                                                    Active
                                                </option>


                                                <option
                                                    value="inactive"
                                                    {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}
                                                >
                                                    Inactive
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                    {{-- Image Preview --}}

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                Product Image
                                            </label>

                                            <br>


                                            @if($product->image)

                                                <img
                                                    id="imagePreview"
                                                    src="{{ asset('admins/images/products/'.$product->image) }}"
                                                    alt="{{ $product->name }}"
                                                    style="
                                                        width: 200px;
                                                        height: 200px;
                                                        object-fit: cover;
                                                        border-radius: 10px;
                                                        border: 1px solid #ddd;
                                                    "
                                                >

                                            @else

                                                <img
                                                    id="imagePreview"
                                                    src=""
                                                    alt="Product Preview"
                                                    style="
                                                        width: 200px;
                                                        height: 200px;
                                                        object-fit: cover;
                                                        border-radius: 10px;
                                                        border: 1px solid #ddd;
                                                        display:none;
                                                    "
                                                >


                                                <div
                                                    id="noImage"
                                                    class="text-muted"
                                                >
                                                    No image uploaded.
                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                </div>


                                <hr>


                                <div
                                    class="d-flex justify-content-between"
                                >

                                    <a
                                        href="{{ route('donor.products.index') }}"
                                        class="btn btn-secondary"
                                    >
                                        Cancel
                                    </a>


                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >

                                        <i class="fa fa-save mr-1"></i>

                                        Update Product

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    PRODUCT INFORMATION
                ====================================================== --}}

                <div class="col-lg-4">


                    <div class="card">

                        <div class="card-body">


                            <h4 class="card-title">
                                Product Details
                            </h4>


                            <hr>


                            <p>

                                <strong>
                                    Created By:
                                </strong>

                                <br>

                                {{ $product->creator?->name }}

                            </p>


                            <p>

                                <strong>
                                    Email:
                                </strong>

                                <br>

                                {{ $product->creator?->email }}

                            </p>


                            <p>

                                <strong>
                                    Created:
                                </strong>

                                <br>

                                {{ $product->created_at?->format('d M Y h:i A') }}

                            </p>


                            <p class="mb-0">

                                <strong>
                                    Last Updated:
                                </strong>

                                <br>

                                {{ $product->updated_at?->format('d M Y h:i A') }}

                            </p>

                        </div>

                    </div>


                    {{-- Danger Zone --}}

                    <div class="card border-danger">

                        <div class="card-body">

                            <h5 class="text-danger">

                                <i class="fa fa-exclamation-triangle mr-1"></i>

                                Danger Zone

                            </h5>


                            <p class="text-muted">

                                Permanently remove this product.

                            </p>


                            <form
                                action="{{ route('donor.products.destroy', $product) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to permanently delete this product?');"
                            >

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="btn btn-danger btn-block"
                                >

                                    <i class="fa fa-trash mr-1"></i>

                                    Delete Product

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.admins.script')


<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | Image Preview
    |--------------------------------------------------------------------------
    */

    $('#productImage').on(
        'change',
        function (event) {

            let file =
                event.target.files[0];


            if (!file) {
                return;
            }


            let reader =
                new FileReader();


            reader.onload =
                function (event) {

                    $('#noImage')
                        .hide();


                    $('#imagePreview')
                        .attr(
                            'src',
                            event.target.result
                        )
                        .show();

                };


            reader.readAsDataURL(
                file
            );

        }
    );

});

</script>

</body>
</html>
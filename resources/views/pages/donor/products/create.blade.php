@include('layouts.admins.head')
<title>Add Product</title>
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
                        Add Product
                    </h3>

                    <p class="text-muted mb-0">
                        Add a new product to the NUST Sharing Network.
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
                VALIDATION
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
                                action="{{ route('donor.products.store') }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >

                                @csrf


                                <div class="row">


                                    {{-- Product Name --}}

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
                                                value="{{ old('name') }}"
                                                class="form-control"
                                                placeholder="Enter product name"
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

                                                <option value="">
                                                    Select Category
                                                </option>


                                                @foreach($categories as $category)

                                                    <option
                                                        value="{{ $category->id }}"
                                                        {{ old('category_id') == $category->id ? 'selected' : '' }}
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
                                                placeholder="Describe the product, condition, specifications, etc."
                                            >{{ old('description') }}</textarea>

                                        </div>

                                    </div>


                                    {{-- Image --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Product Image
                                            </label>


                                            <input
                                                type="file"
                                                name="image"
                                                id="productImage"
                                                class="form-control"
                                                accept=".jpg,.jpeg,.png,.webp"
                                            >


                                            <small class="text-muted">

                                                JPG, JPEG, PNG or WEBP.

                                                Maximum size 2 MB.

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
                                                    {{ old('status', 'active') === 'active' ? 'selected' : '' }}
                                                >
                                                    Active
                                                </option>


                                                <option
                                                    value="inactive"
                                                    {{ old('status') === 'inactive' ? 'selected' : '' }}
                                                >
                                                    Inactive
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                    {{-- Image Preview --}}

                                    <div
                                        class="col-md-12"
                                        id="imagePreviewWrapper"
                                        style="display:none;"
                                    >

                                        <div class="form-group">

                                            <label>
                                                Image Preview
                                            </label>

                                            <br>


                                            <img
                                                id="imagePreview"
                                                src=""
                                                alt="Product Preview"
                                                style="
                                                    width: 180px;
                                                    height: 180px;
                                                    object-fit: cover;
                                                    border-radius: 10px;
                                                    border: 1px solid #ddd;
                                                "
                                            >

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

                                        Add Product

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    DONOR INFORMATION
                ====================================================== --}}

                <div class="col-lg-4">

                    <div class="card">

                        <div class="card-body">

                            <h4 class="card-title">
                                Product Owner
                            </h4>


                            <hr>


                            <p>

                                <strong>
                                    Donor:
                                </strong>

                                <br>

                                {{ auth()->user()->name }}

                            </p>


                            <p>

                                <strong>
                                    Email:
                                </strong>

                                <br>

                                {{ auth()->user()->email }}

                            </p>


                            <p>

                                <strong>
                                    Role:
                                </strong>

                                <br>

                                <span class="badge badge-primary">
                                    Donor
                                </span>

                            </p>


                            <div class="alert alert-info mb-0">

                                <small>

                                    The product will automatically be linked to your account.

                                </small>

                            </div>

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

                $('#imagePreviewWrapper')
                    .hide();

                return;
            }


            let reader =
                new FileReader();


            reader.onload =
                function (event) {

                    $('#imagePreview')
                        .attr(
                            'src',
                            event.target.result
                        );


                    $('#imagePreviewWrapper')
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
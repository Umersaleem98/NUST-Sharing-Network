@include('layouts.admins.head')
<title>Edit Product</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            <div class="row mb-4">

                <div class="col-md-6">

                    <h3>
                        Edit Product
                    </h3>

                </div>


                <div class="col-md-6 text-md-right">

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn btn-secondary"
                    >
                        Back
                    </a>

                </div>

            </div>


            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="card">

                <div class="card-body">


                    <form
                        action="{{ route('admin.products.update', $product) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        @method('PUT')


                        <div class="row">


                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Product Name
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


                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Category
                                    </label>

                                    <select
                                        name="category_id"
                                        class="form-control"
                                        required
                                    >

                                        @foreach($categories as $category)

                                            <option
                                                value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}
                                            >
                                                {{ $category->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>


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


                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Replace Image
                                    </label>

                                    <input
                                        type="file"
                                        name="image"
                                        class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp"
                                    >

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Status
                                    </label>

                                    <select
                                        name="status"
                                        class="form-control"
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


                         @if($product->image)

    <div class="col-md-12">

        <div class="form-group">

            <label>
                Current Image
            </label>

            <br>

            <img
                src="{{ asset('admins/images/products/'.$product->image) }}"
                alt="{{ $product->name }}"
                style="
                    width: 180px;
                    height: 180px;
                    object-fit: cover;
                    border-radius: 10px;
                "
            >

        </div>

    </div>

@endif


                            <div class="col-md-12">

                                <div class="alert alert-info">

                                    Product originally created by:

                                    <strong>

                                        {{ $product->creator?->name ?? 'System' }}

                                    </strong>

                                    @if($product->creator)

                                        <br>

                                        {{ $product->creator->email }}

                                    @endif

                                </div>

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fa fa-save mr-1"></i>

                            Update Product
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.admins.script')

</body>
</html>
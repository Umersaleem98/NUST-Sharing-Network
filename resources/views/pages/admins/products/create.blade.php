@include('layouts.admins.head')
<title>Create Product</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            <div class="row mb-4">

                <div class="col-md-6">

                    <h3>
                        Create Product
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
                        method="POST"
                        action="{{ route('admin.products.store') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <div class="row">


                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Product Name
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
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


                            <div class="col-md-12">

                                <div class="form-group">

                                    <label>
                                        Description
                                    </label>

                                    <textarea
                                        name="description"
                                        class="form-control"
                                        rows="6"
                                    >{{ old('description') }}</textarea>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="form-group">

                                    <label>
                                        Product Image
                                    </label>

                                    <input
                                        type="file"
                                        name="image"
                                        class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp"
                                    >

                                    <small class="text-muted">

                                        JPG, JPEG, PNG or WEBP.
                                        Maximum 2 MB.

                                    </small>

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
                                        required
                                    >

                                        <option value="active">
                                            Active
                                        </option>

                                        <option value="inactive">
                                            Inactive
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fa fa-save mr-1"></i>

                            Create Product
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
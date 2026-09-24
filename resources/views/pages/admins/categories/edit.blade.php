@include('layouts.admins.head')
<title>Edit Category</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            <div class="row mb-4">

                <div class="col-md-6">

                    <h3>
                        Edit Category
                    </h3>

                </div>


                <div class="col-md-6 text-md-right">

                    <a
                        href="{{ route('admin.categories.index') }}"
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

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="card">

                <div class="card-body">


                    <form
                        method="POST"
                        action="{{ route('admin.categories.update', $category) }}"
                    >

                        @csrf

                        @method('PUT')


                        <div class="form-group">

                            <label>
                                Category Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $category->name) }}"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Description
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="5"
                            >{{ old('description', $category->description) }}</textarea>

                        </div>


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
                                    {{ old('status', $category->status) === 'active' ? 'selected' : '' }}
                                >
                                    Active
                                </option>


                                <option
                                    value="inactive"
                                    {{ old('status', $category->status) === 'inactive' ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>

                            </select>

                        </div>


                        <div class="alert alert-info">

                            Created By:

                            <strong>
                                {{ $category->creator?->name ?? 'System' }}
                            </strong>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fa fa-save mr-1"></i>

                            Update Category
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
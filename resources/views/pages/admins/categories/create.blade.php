@include('layouts.admins.head')
<title>Create Category</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            <div class="row mb-4">

                <div class="col-md-6">

                    <h3>
                        Create Category
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
                        action="{{ route('admin.categories.store') }}"
                    >

                        @csrf


                        <div class="form-group">

                            <label>
                                Category Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
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
                            >{{ old('description') }}</textarea>

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

                                <option value="active">
                                    Active
                                </option>

                                <option value="inactive">
                                    Inactive
                                </option>

                            </select>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fa fa-save mr-1"></i>

                            Save Category
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
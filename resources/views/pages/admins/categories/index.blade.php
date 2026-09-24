@include('layouts.admins.head')
<title>Create Category</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            {{-- Header --}}

            <div class="row mb-4">

                <div class="col-md-6">

                    <h3 class="mb-1">
                        Category Management
                    </h3>

                    <p class="text-muted">
                        Manage product categories.
                    </p>

                </div>


                <div class="col-md-6 text-md-right">

                    <a
                        href="{{ route('admin.categories.create') }}"
                        class="btn btn-primary"
                    >
                        <i class="fa fa-plus mr-1"></i>

                        Add Category
                    </a>

                </div>

            </div>


            {{-- Messages --}}

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

            @endif


            {{-- Search --}}

            <div class="card mb-4">

                <div class="card-body">

                    <form
                        action="{{ route('admin.categories.index') }}"
                        method="GET"
                    >

                        <div class="row align-items-end">

                            <div class="col-md-6">

                                <div class="form-group mb-md-0">

                                    <label>
                                        Search
                                    </label>

                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        class="form-control"
                                        placeholder="Search category..."
                                    >

                                </div>

                            </div>


                            <div class="col-md-3">

                                <div class="form-group mb-md-0">

                                    <label>
                                        Status
                                    </label>

                                    <select
                                        name="status"
                                        class="form-control"
                                    >

                                        <option value="">
                                            All
                                        </option>

                                        <option
                                            value="active"
                                            {{ request('status') === 'active' ? 'selected' : '' }}
                                        >
                                            Active
                                        </option>

                                        <option
                                            value="inactive"
                                            {{ request('status') === 'inactive' ? 'selected' : '' }}
                                        >
                                            Inactive
                                        </option>

                                    </select>

                                </div>

                            </div>


                            <div class="col-md-3">

                                <button
                                    class="btn btn-primary"
                                    type="submit"
                                >
                                    Search
                                </button>

                                <a
                                    href="{{ route('admin.categories.index') }}"
                                    class="btn btn-secondary"
                                >
                                    Reset
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- Table --}}

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover table-bordered">

                            <thead class="thead-light">

                            <tr>

                                <th>#</th>

                                <th>Name</th>

                                <th>Description</th>

                                <th>Products</th>

                                <th>Created By</th>

                                <th>Status</th>

                                <th>Created</th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                            </thead>


                            <tbody>

                            @forelse($categories as $category)

                                <tr>

                                    <td>

                                        {{ $categories->firstItem() + $loop->index }}

                                    </td>


                                    <td>

                                        <strong>
                                            {{ $category->name }}
                                        </strong>

                                    </td>


                                    <td>

                                        {{ \Illuminate\Support\Str::limit(
                                            $category->description,
                                            70
                                        ) }}

                                    </td>


                                    <td>

                                        <span class="badge badge-info">

                                            {{ $category->products_count }}

                                        </span>

                                    </td>


                                    <td>

                                        {{ $category->creator?->name ?? 'System' }}

                                    </td>


                                    <td>

                                        @if($category->status === 'active')

                                            <span class="badge badge-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge badge-secondary">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        {{ $category->created_at?->format('d M Y') }}

                                    </td>


                                    <td class="text-center">

                                        <a
                                            href="{{ route('admin.categories.edit', $category) }}"
                                            class="btn btn-sm btn-warning"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </a>


                                        <form
                                            action="{{ route('admin.categories.destroy', $category) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Delete this category?');"
                                        >

                                            @csrf
                                            @method('DELETE')


                                            <button
                                                class="btn btn-sm btn-danger"
                                                type="submit"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-4"
                                    >
                                        No categories found.
                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{ $categories->links() }}

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.admins.script')

</body>
</html>
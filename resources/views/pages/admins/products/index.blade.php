@include('layouts.admins.head')
<title>index Product</title>
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
                            Product Management
                        </h3>

                        <p class="text-muted">
                            Manage all products.
                        </p>

                    </div>


                    <div class="col-md-6 text-md-right">

                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus mr-1"></i>

                            Add Product
                        </a>

                    </div>

                </div>


                {{-- Messages --}}

                @if (session('success'))
                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>
                @endif


                @if (session('error'))
                    <div class="alert alert-danger">

                        {{ session('error') }}

                    </div>
                @endif


                {{-- Filters --}}

                <div class="card mb-4">

                    <div class="card-body">

                        <form action="{{ route('admin.products.index') }}" method="GET">

                            <div class="row align-items-end">


                                <div class="col-md-4">

                                    <div class="form-group mb-md-0">

                                        <label>
                                            Search
                                        </label>

                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="form-control" placeholder="Search product...">

                                    </div>

                                </div>


                                <div class="col-md-3">

                                    <div class="form-group mb-md-0">

                                        <label>
                                            Category
                                        </label>

                                        <select name="category_id" class="form-control">

                                            <option value="">
                                                All Categories
                                            </option>

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>


                                <div class="col-md-2">

                                    <div class="form-group mb-md-0">

                                        <label>
                                            Status
                                        </label>

                                        <select name="status" class="form-control">

                                            <option value="">
                                                All
                                            </option>

                                            <option value="active"
                                                {{ request('status') === 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>

                                            <option value="inactive"
                                                {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>

                                        </select>

                                    </div>

                                </div>


                                <div class="col-md-3">

                                    <button type="submit" class="btn btn-primary">
                                        Search
                                    </button>

                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                        Reset
                                    </a>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- Products --}}

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-hover table-bordered">

                                <thead class="thead-light">

                                    <tr>

                                        <th>#</th>

                                        <th>Image</th>

                                        <th>Product</th>

                                        <th>Category</th>

                                        <th>Description</th>

                                        <th>Status</th>

                                        <th>Created By</th>

                                        <th>Created</th>

                                        <th class="text-center">
                                            Actions
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($products as $product)
                                        <tr>

                                            <td>

                                                {{ $products->firstItem() + $loop->index }}

                                            </td>


                                            <td>

                                                @if ($product->image)
                                                    <img src="{{ asset('admins/images/products/' . $product->image) }}"
                                                        alt="{{ $product->name }}"
                                                        style="
                width: 65px;
                height: 65px;
                object-fit: cover;
                border-radius: 8px;
            ">
                                                @else
                                                    <span class="text-muted">
                                                        No Image
                                                    </span>
                                                @endif

                                            </td>


                                            <td>

                                                <strong>
                                                    {{ $product->name }}
                                                </strong>

                                            </td>


                                            <td>

                                                {{ $product->category?->name }}

                                            </td>


                                            <td>

                                                {{ \Illuminate\Support\Str::limit($product->description, 60) }}

                                            </td>


                                            <td>

                                                @if ($product->status === 'active')
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

                                                {{ $product->creator?->name ?? 'System' }}

                                            </td>


                                            <td>

                                                {{ $product->created_at?->format('d M Y') }}

                                            </td>


                                            <td class="text-center">

                                                <a href="{{ route('admin.products.edit', $product) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>


                                                <form action="{{ route('admin.products.destroy', $product) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this product?');">

                                                    @csrf

                                                    @method('DELETE')


                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>

                                                </form>

                                            </td>

                                        </tr>


                                    @empty

                                        <tr>

                                            <td colspan="9" class="text-center py-4">
                                                No products found.
                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                        {{ $products->links() }}

                    </div>

                </div>

            </div>

        </div>

    </div>


    @include('layouts.admins.script')

</body>

</html>

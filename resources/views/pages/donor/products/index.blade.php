@include('layouts.admins.head')
<title>My Products</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}

            <div class="row mb-4">

                <div class="col-md-6">

                    <h3 class="mb-1">
                        My Products
                    </h3>

                    <p class="text-muted mb-0">
                        Manage the products you have added to the Sharing Network.
                    </p>

                </div>


                <div class="col-md-6 text-md-right">

                    <a
                        href="{{ route('donor.products.create') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa fa-plus mr-1"></i>

                        Add Product

                    </a>

                </div>

            </div>


            {{-- =========================================================
                SUCCESS
            ========================================================== --}}

            @if(session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                >

                    <i class="fa fa-check-circle mr-1"></i>

                    {{ session('success') }}


                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >

                        <span>
                            &times;
                        </span>

                    </button>

                </div>

            @endif


            {{-- =========================================================
                ERROR
            ========================================================== --}}

            @if(session('error'))

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

            @endif


            {{-- =========================================================
                SEARCH / FILTER
            ========================================================== --}}

            <div class="card mb-4">

                <div class="card-body">

                    <form
                        action="{{ route('donor.products.index') }}"
                        method="GET"
                    >

                        <div class="row align-items-end">


                            {{-- Search --}}

                            <div class="col-md-4">

                                <div class="form-group mb-md-0">

                                    <label>
                                        Search
                                    </label>


                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        class="form-control"
                                        placeholder="Search product..."
                                    >

                                </div>

                            </div>


                            {{-- Category --}}

                            <div class="col-md-3">

                                <div class="form-group mb-md-0">

                                    <label>
                                        Category
                                    </label>


                                    <select
                                        name="category_id"
                                        class="form-control"
                                    >

                                        <option value="">
                                            All Categories
                                        </option>


                                        @foreach($categories as $category)

                                            <option
                                                value="{{ $category->id }}"
                                                {{
                                                    (string) request('category_id') ===
                                                    (string) $category->id
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


                            {{-- Status --}}

                            <div class="col-md-2">

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


                            {{-- Buttons --}}

                            <div class="col-md-3">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa fa-search"></i>

                                    Search

                                </button>


                                <a
                                    href="{{ route('donor.products.index') }}"
                                    class="btn btn-secondary"
                                >
                                    Reset
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- =========================================================
                PRODUCTS TABLE
            ========================================================== --}}

            <div class="card">

                <div class="card-body">


                    <div
                        class="d-flex justify-content-between align-items-center mb-3"
                    >

                        <div>

                            <h4 class="card-title mb-1">
                                My Products
                            </h4>


                            <small class="text-muted">

                                Total Products:

                                <strong>
                                    {{ $products->total() }}
                                </strong>

                            </small>

                        </div>

                    </div>


                    <div class="table-responsive">

                        <table
                            class="table table-hover table-bordered"
                        >

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


                                    {{-- Image --}}

                                    <td>

                                        @if($product->image)

                                            <img
                                                src="{{ asset('admins/images/products/'.$product->image) }}"
                                                alt="{{ $product->name }}"
                                                style="
                                                    width: 70px;
                                                    height: 70px;
                                                    object-fit: cover;
                                                    border-radius: 8px;
                                                "
                                            >

                                        @else

                                            <div
                                                class="bg-light d-flex align-items-center justify-content-center"
                                                style="
                                                    width:70px;
                                                    height:70px;
                                                    border-radius:8px;
                                                "
                                            >

                                                <i
                                                    class="fa fa-image text-muted"
                                                    style="font-size:24px;"
                                                ></i>

                                            </div>

                                        @endif

                                    </td>


                                    {{-- Product --}}

                                    <td>

                                        <strong>
                                            {{ $product->name }}
                                        </strong>

                                    </td>


                                    {{-- Category --}}

                                    <td>

                                        {{ $product->category?->name ?? 'Not Available' }}

                                    </td>


                                    {{-- Description --}}

                                    <td>

                                        {{ \Illuminate\Support\Str::limit(
                                            $product->description,
                                            70
                                        ) }}

                                    </td>


                                    {{-- Status --}}

                                    <td>

                                        @if($product->status === 'active')

                                            <span class="badge badge-success">

                                                <i class="fa fa-check-circle"></i>

                                                Active

                                            </span>

                                        @else

                                            <span class="badge badge-secondary">

                                                Inactive

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Creator --}}

                                    <td>

                                        <strong>

                                            {{ $product->creator?->name ?? 'Unknown' }}

                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $product->creator?->email }}

                                        </small>

                                    </td>


                                    {{-- Created --}}

                                    <td>

                                        {{ $product->created_at?->format('d M Y') }}

                                    </td>


                                    {{-- Actions --}}

                                    <td class="text-center">

                                        <a
                                            href="{{ route('donor.products.edit', $product) }}"
                                            class="btn btn-sm btn-warning"
                                            title="Edit"
                                        >

                                            <i class="fa fa-edit"></i>

                                        </a>


                                        <form
                                            action="{{ route('donor.products.destroy', $product) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Delete"
                                            >

                                                <i class="fa fa-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="9"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="fa fa-cube fa-3x text-muted mb-3"
                                        ></i>


                                        <h5>
                                            No Products Found
                                        </h5>


                                        <p class="text-muted">

                                            You have not added any products yet.

                                        </p>


                                        <a
                                            href="{{ route('donor.products.create') }}"
                                            class="btn btn-primary"
                                        >

                                            <i class="fa fa-plus mr-1"></i>

                                            Add Your First Product

                                        </a>

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>


                    <div class="mt-4">

                        {{ $products->links() }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.admins.script')

</body>
</html>
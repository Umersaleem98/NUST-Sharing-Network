@include('layouts.admins.head')
<title>Available Products</title>
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

                <div class="col-md-7">

                    <h3 class="mb-1">
                        Available Products
                    </h3>

                    <p class="text-muted mb-0">
                        Browse available products and submit a request.
                    </p>

                </div>


                <div class="col-md-5 text-md-right">

                    <a
                        href="{{ route('beneficiary.requests.index') }}"
                        class="btn btn-info"
                    >

                        <i class="fa fa-list mr-1"></i>

                        My Requests

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
                        <span>&times;</span>
                    </button>

                </div>

            @endif


            {{-- =========================================================
                ERROR
            ========================================================== --}}

            @if(session('error'))

                <div
                    class="alert alert-danger alert-dismissible fade show"
                >

                    <i class="fa fa-exclamation-circle mr-1"></i>

                    {{ session('error') }}


                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >
                        <span>&times;</span>
                    </button>

                </div>

            @endif


            {{-- =========================================================
                VALIDATION
            ========================================================== --}}

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


            {{-- =========================================================
                FILTERS
            ========================================================== --}}

            <div class="card mb-4">

                <div class="card-body">

                    <form
                        method="GET"
                        action="{{ route('beneficiary.products.index') }}"
                    >

                        <div class="row align-items-end">


                            {{-- Search --}}

                            <div class="col-md-6">

                                <div class="form-group mb-md-0">

                                    <label>
                                        Search Products
                                    </label>


                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        class="form-control"
                                        placeholder="Search by product name..."
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


                            {{-- Buttons --}}

                            <div class="col-md-3">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa fa-search mr-1"></i>

                                    Search

                                </button>


                                <a
                                    href="{{ route('beneficiary.products.index') }}"
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
                PRODUCTS
            ========================================================== --}}

            <div class="row">


                @forelse($products as $product)

                    @php

                        $existingRequest =
                            $product
                                ->productRequests
                                ->first();

                    @endphp


                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                        <div
                            class="card h-100"
                            style="
                                border-radius: 10px;
                                overflow: hidden;
                            "
                        >


                            {{-- Product Image --}}

                            <div
                                style="
                                    height: 220px;
                                    background: #f5f5f5;
                                    overflow: hidden;
                                "
                            >

                                @if($product->image)

                                    <img
                                        src="{{ asset('admins/images/products/'.$product->image) }}"
                                        alt="{{ $product->name }}"
                                        style="
                                            width: 100%;
                                            height: 100%;
                                            object-fit: cover;
                                        "
                                    >

                                @else

                                    <div
                                        class="d-flex align-items-center justify-content-center h-100"
                                    >

                                        <i
                                            class="fa fa-image text-muted"
                                            style="font-size: 55px;"
                                        ></i>

                                    </div>

                                @endif

                            </div>


                            <div class="card-body">


                                {{-- Category --}}

                                <div class="mb-2">

                                    <span class="badge badge-info">

                                        {{ $product->category?->name ?? 'Uncategorized' }}

                                    </span>

                                </div>


                                {{-- Name --}}

                                <h4 class="mb-2">

                                    {{ $product->name }}

                                </h4>


                                {{-- Description --}}

                                <p class="text-muted">

                                    {{
                                        \Illuminate\Support\Str::limit(
                                            $product->description,
                                            120
                                        )
                                    }}

                                </p>


                                {{-- Owner --}}

                                <div
                                    class="border-top pt-3 mt-3"
                                >

                                    <small class="text-muted">

                                        Added By

                                    </small>

                                    <br>


                                    <strong>

                                        {{ $product->creator?->name ?? 'NUST Sharing Network' }}

                                    </strong>


                                    @if(
                                        $product->creator &&
                                        $product->creator->role === 'donor'
                                    )

                                        <span class="badge badge-primary ml-1">
                                            Donor
                                        </span>

                                    @elseif($product->creator)

                                        <span class="badge badge-secondary ml-1">
                                            Admin
                                        </span>

                                    @endif

                                </div>

                            </div>


                            {{-- =================================================
                                ACTIONS
                            ================================================== --}}

                            <div
                                class="card-footer bg-white"
                            >

                                <div class="d-flex">


                                    {{-- View --}}

                                    <button
                                        type="button"
                                        class="btn btn-outline-info flex-fill mr-2"
                                        data-toggle="modal"
                                        data-target="#viewProduct{{ $product->id }}"
                                    >

                                        <i class="fa fa-eye mr-1"></i>

                                        View

                                    </button>


                                    {{-- Request --}}

                                    @if($existingRequest)

                                        <button
                                            type="button"
                                            class="btn btn-success flex-fill"
                                            disabled
                                        >

                                            <i class="fa fa-check mr-1"></i>

                                            Requested

                                        </button>

                                    @else

                                        <button
                                            type="button"
                                            class="btn btn-primary flex-fill"
                                            data-toggle="modal"
                                            data-target="#requestProduct{{ $product->id }}"
                                        >

                                            <i class="fa fa-paper-plane mr-1"></i>

                                            Request

                                        </button>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>


                @empty

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-body text-center py-5">

                                <i
                                    class="fa fa-cubes fa-4x text-muted mb-3"
                                ></i>


                                <h4>
                                    No Products Available
                                </h4>


                                <p class="text-muted mb-0">

                                    No active products match your search.

                                </p>

                            </div>

                        </div>

                    </div>

                @endforelse


            </div>


            {{-- Pagination --}}

            <div class="mt-3">

                {{ $products->links() }}

            </div>

        </div>

    </div>


    {{-- =========================================================
        VIEW PRODUCT MODALS
    ========================================================== --}}

    @foreach($products as $product)

        <div
            class="modal fade"
            id="viewProduct{{ $product->id }}"
            tabindex="-1"
            role="dialog"
        >

            <div
                class="modal-dialog modal-lg modal-dialog-centered"
                role="document"
            >

                <div class="modal-content">


                    <div
                        class="modal-header"
                        style="
                            background:#00558c;
                            color:white;
                        "
                    >

                        <h5 class="modal-title text-white">

                            {{ $product->name }}

                        </h5>


                        <button
                            type="button"
                            class="close text-white"
                            data-dismiss="modal"
                        >

                            <span>
                                &times;
                            </span>

                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="row">


                            {{-- Image --}}

                            <div class="col-md-5">

                                @if($product->image)

                                    <img
                                        src="{{ asset('admins/images/products/'.$product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="img-fluid"
                                        style="
                                            width:100%;
                                            max-height:350px;
                                            object-fit:cover;
                                            border-radius:8px;
                                        "
                                    >

                                @else

                                    <div
                                        class="bg-light d-flex align-items-center justify-content-center"
                                        style="
                                            height:300px;
                                            border-radius:8px;
                                        "
                                    >

                                        <i
                                            class="fa fa-image text-muted"
                                            style="font-size:60px;"
                                        ></i>

                                    </div>

                                @endif

                            </div>


                            {{-- Details --}}

                            <div class="col-md-7">

                                <h4>
                                    {{ $product->name }}
                                </h4>


                                <p>

                                    <strong>
                                        Category:
                                    </strong>

                                    {{ $product->category?->name ?? 'Not Available' }}

                                </p>


                                <p>

                                    <strong>
                                        Status:
                                    </strong>

                                    <span class="badge badge-success">
                                        Available
                                    </span>

                                </p>


                                <p>

                                    <strong>
                                        Added By:
                                    </strong>

                                    {{ $product->creator?->name ?? 'NUST Sharing Network' }}

                                </p>


                                <hr>


                                <strong>
                                    Description
                                </strong>


                                <p class="mt-2">

                                    {{ $product->description ?: 'No description provided.' }}

                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>

                    </div>

                </div>

            </div>

        </div>

    @endforeach



    {{-- =========================================================
        REQUEST PRODUCT MODALS
    ========================================================== --}}

    @foreach($products as $product)

        @if($product->productRequests->isEmpty())

            <div
                class="modal fade"
                id="requestProduct{{ $product->id }}"
                tabindex="-1"
                role="dialog"
            >

                <div
                    class="modal-dialog modal-dialog-centered"
                    role="document"
                >

                    <div class="modal-content">


                        <form
                            action="{{ route('beneficiary.products.request', $product) }}"
                            method="POST"
                        >

                            @csrf


                            <div
                                class="modal-header"
                                style="
                                    background:#00558c;
                                    color:white;
                                "
                            >

                                <h5 class="modal-title text-white">

                                    Request Product

                                </h5>


                                <button
                                    type="button"
                                    class="close text-white"
                                    data-dismiss="modal"
                                >

                                    <span>
                                        &times;
                                    </span>

                                </button>

                            </div>


                            <div class="modal-body">


                                <div class="alert alert-info">

                                    You are requesting:

                                    <br>

                                    <strong>
                                        {{ $product->name }}
                                    </strong>

                                </div>


                                <div class="form-group">

                                    <label>
                                        Request Message
                                    </label>


                                    <textarea
                                        name="beneficiary_message"
                                        class="form-control"
                                        rows="5"
                                        maxlength="1000"
                                        placeholder="Briefly explain why you need this product..."
                                    ></textarea>


                                    <small class="text-muted">

                                        Maximum 1000 characters.

                                    </small>

                                </div>


                                <div class="bg-light p-3 rounded">

                                    <small class="text-muted">

                                        Your request will first be reviewed by the administrator.

                                        @if(
                                            $product->creator &&
                                            $product->creator->role === 'donor'
                                        )

                                            After admin approval, it can be reviewed by the donor.

                                        @endif

                                    </small>

                                </div>

                            </div>


                            <div class="modal-footer">


                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                >
                                    Cancel
                                </button>


                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa fa-paper-plane mr-1"></i>

                                    Send Request

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        @endif

    @endforeach

</div>


@include('layouts.admins.script')

</body>
</html>
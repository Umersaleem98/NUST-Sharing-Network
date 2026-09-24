@include('layouts.admins.head')
<title>My Product Requests</title>
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
                        My Product Requests
                    </h3>

                    <p class="text-muted mb-0">
                        Track the status of your submitted product requests.
                    </p>

                </div>


                <div class="col-md-5 text-md-right">

                    <a
                        href="{{ route('beneficiary.products.index') }}"
                        class="btn btn-primary"
                    >

                        <i class="fa fa-search mr-1"></i>

                        Browse Products

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
                FILTERS
            ========================================================== --}}

            <div class="card mb-4">

                <div class="card-body">

                    <form
                        method="GET"
                        action="{{ route('beneficiary.requests.index') }}"
                    >

                        <div class="row align-items-end">


                            {{-- Admin Status --}}

                            <div class="col-md-4">

                                <div class="form-group mb-md-0">

                                    <label>
                                        Admin Status
                                    </label>


                                    <select
                                        name="admin_status"
                                        class="form-control"
                                    >

                                        <option value="">
                                            All
                                        </option>


                                        <option
                                            value="pending"
                                            {{ request('admin_status') === 'pending' ? 'selected' : '' }}
                                        >
                                            Pending
                                        </option>


                                        <option
                                            value="approved"
                                            {{ request('admin_status') === 'approved' ? 'selected' : '' }}
                                        >
                                            Approved
                                        </option>


                                        <option
                                            value="rejected"
                                            {{ request('admin_status') === 'rejected' ? 'selected' : '' }}
                                        >
                                            Rejected
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Donor Status --}}

                            <div class="col-md-4">

                                <div class="form-group mb-md-0">

                                    <label>
                                        Donor Status
                                    </label>


                                    <select
                                        name="donor_status"
                                        class="form-control"
                                    >

                                        <option value="">
                                            All
                                        </option>


                                        <option
                                            value="pending"
                                            {{ request('donor_status') === 'pending' ? 'selected' : '' }}
                                        >
                                            Pending
                                        </option>


                                        <option
                                            value="accepted"
                                            {{ request('donor_status') === 'accepted' ? 'selected' : '' }}
                                        >
                                            Accepted
                                        </option>


                                        <option
                                            value="rejected"
                                            {{ request('donor_status') === 'rejected' ? 'selected' : '' }}
                                        >
                                            Rejected
                                        </option>

                                    </select>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    Filter
                                </button>


                                <a
                                    href="{{ route('beneficiary.requests.index') }}"
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
                REQUEST TABLE
            ========================================================== --}}

            <div class="card">

                <div class="card-body">


                    <h4 class="card-title mb-3">
                        Requests
                    </h4>


                    <div class="table-responsive">

                        <table
                            class="table table-hover table-bordered"
                        >

                            <thead class="thead-light">

                            <tr>

                                <th>#</th>

                                <th>Product</th>

                                <th>Category</th>

                                <th>Owner</th>

                                <th>My Message</th>

                                <th>Admin Status</th>

                                <th>Donor Status</th>

                                <th>Requested</th>

                            </tr>

                            </thead>


                            <tbody>

                            @forelse($requests as $productRequest)

                                <tr>


                                    <td>

                                        {{ $requests->firstItem() + $loop->index }}

                                    </td>


                                    {{-- Product --}}

                                    <td>

                                        <div class="d-flex align-items-center">


                                            @if($productRequest->product?->image)

                                                <img
                                                    src="{{ asset('admins/images/products/'.$productRequest->product->image) }}"
                                                    alt="{{ $productRequest->product->name }}"
                                                    style="
                                                        width:55px;
                                                        height:55px;
                                                        object-fit:cover;
                                                        border-radius:6px;
                                                        margin-right:10px;
                                                    "
                                                >

                                            @endif


                                            <strong>

                                                {{ $productRequest->product?->name ?? 'Product Removed' }}

                                            </strong>

                                        </div>

                                    </td>


                                    {{-- Category --}}

                                    <td>

                                        {{ $productRequest->product?->category?->name ?? 'N/A' }}

                                    </td>


                                    {{-- Owner --}}

                                    <td>

                                        {{ $productRequest->product?->creator?->name ?? 'NUST Sharing Network' }}

                                    </td>


                                    {{-- Message --}}

                                    <td>

                                        {{
                                            \Illuminate\Support\Str::limit(
                                                $productRequest->beneficiary_message,
                                                60
                                            )
                                            ?: '—'
                                        }}

                                    </td>


                                    {{-- Admin Status --}}

                                    <td>

                                        @if($productRequest->admin_status === 'approved')

                                            <span class="badge badge-success">
                                                Approved
                                            </span>

                                        @elseif($productRequest->admin_status === 'rejected')

                                            <span class="badge badge-danger">
                                                Rejected
                                            </span>

                                        @else

                                            <span class="badge badge-warning">
                                                Pending
                                            </span>

                                        @endif


                                        @if($productRequest->admin_message)

                                            <br>

                                            <small class="text-muted">

                                                {{ $productRequest->admin_message }}

                                            </small>

                                        @endif

                                    </td>


                                    {{-- Donor Status --}}

                                    <td>

                                        @if(!$productRequest->donor_id)

                                            <span class="badge badge-secondary">
                                                Not Applicable
                                            </span>


                                        @elseif($productRequest->admin_status !== 'approved')

                                            <span class="badge badge-secondary">
                                                Awaiting Admin
                                            </span>


                                        @elseif($productRequest->donor_status === 'accepted')

                                            <span class="badge badge-success">
                                                Accepted
                                            </span>


                                        @elseif($productRequest->donor_status === 'rejected')

                                            <span class="badge badge-danger">
                                                Rejected
                                            </span>


                                        @else

                                            <span class="badge badge-warning">
                                                Pending
                                            </span>

                                        @endif


                                        @if($productRequest->donor_message)

                                            <br>

                                            <small class="text-muted">

                                                {{ $productRequest->donor_message }}

                                            </small>

                                        @endif

                                    </td>


                                    {{-- Date --}}

                                    <td>

                                        {{ $productRequest->created_at?->format('d M Y') }}

                                        <br>

                                        <small class="text-muted">

                                            {{ $productRequest->created_at?->format('h:i A') }}

                                        </small>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="fa fa-list-alt fa-3x text-muted mb-3"
                                        ></i>


                                        <h5>
                                            No Requests Found
                                        </h5>


                                        <p class="text-muted">

                                            You have not submitted any product requests yet.

                                        </p>


                                        <a
                                            href="{{ route('beneficiary.products.index') }}"
                                            class="btn btn-primary"
                                        >
                                            Browse Products
                                        </a>

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>


                    <div class="mt-4">

                        {{ $requests->links() }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.admins.script')

</body>
</html>
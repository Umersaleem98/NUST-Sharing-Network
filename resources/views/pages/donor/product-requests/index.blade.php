@include('layouts.admins.head')
<title>Product Requests</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            <div class="row mb-4">

                <div class="col-md-8">

                    <h3 class="mb-1">
                        Product Requests
                    </h3>

                    <p class="text-muted mb-0">
                        Only requests approved by the administrator are shown here.
                    </p>

                </div>

            </div>


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


            {{-- Filter --}}

            <div class="card mb-4">

                <div class="card-body">

                    <form
                        action="{{ route('donor.product.requests.index') }}"
                        method="GET"
                    >

                        <div class="row align-items-end">

                            <div class="col-md-4">

                                <div class="form-group mb-md-0">

                                    <label>
                                        Request Status
                                    </label>


                                    <select
                                        name="status"
                                        class="form-control"
                                    >

                                        <option value="">
                                            All
                                        </option>

                                        <option
                                            value="pending"
                                            {{ request('status') === 'pending' ? 'selected' : '' }}
                                        >
                                            Pending
                                        </option>

                                        <option
                                            value="accepted"
                                            {{ request('status') === 'accepted' ? 'selected' : '' }}
                                        >
                                            Accepted
                                        </option>

                                        <option
                                            value="rejected"
                                            {{ request('status') === 'rejected' ? 'selected' : '' }}
                                        >
                                            Rejected
                                        </option>

                                    </select>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <button
                                    class="btn btn-primary"
                                    type="submit"
                                >
                                    Filter
                                </button>


                                <a
                                    href="{{ route('donor.product.requests.index') }}"
                                    class="btn btn-secondary"
                                >
                                    Reset
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            <div class="card">

                <div class="card-body">


                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead class="thead-light">

                            <tr>

                                <th>#</th>

                                <th>Product</th>

                                <th>Beneficiary</th>

                                <th>Qalam ID</th>

                                <th>Admin Status</th>

                                <th>My Status</th>

                                <th>Date</th>

                                <th>Action</th>

                            </tr>

                            </thead>


                            <tbody>

                            @forelse($requests as $productRequest)

                                <tr>


                                    <td>

                                        {{ $requests->firstItem() + $loop->index }}

                                    </td>


                                    <td>

                                        <strong>

                                            {{ $productRequest->product?->name }}

                                        </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ $productRequest->product?->category?->name }}

                                        </small>

                                    </td>


                                    <td>

                                        {{ $productRequest->beneficiary?->name }}

                                    </td>


                                    <td>

                                        {{ $productRequest->beneficiary?->qalam_id }}

                                    </td>


                                    <td>

                                        <span class="badge badge-success">
                                            Admin Approved
                                        </span>

                                    </td>


                                    <td>

                                        @if($productRequest->donor_status === 'accepted')

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

                                    </td>


                                    <td>

                                        {{ $productRequest->created_at?->format('d M Y') }}

                                    </td>


                                    <td>

                                        <a
                                            href="{{ route('donor.product.requests.show', $productRequest) }}"
                                            class="btn btn-sm btn-info"
                                        >

                                            <i class="fa fa-eye"></i>

                                            View

                                        </a>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-5"
                                    >

                                        <h5>
                                            No Approved Requests
                                        </h5>

                                        <p class="text-muted mb-0">

                                            Requests will appear here only after administrator approval.

                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{ $requests->links() }}

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.admins.script')

</body>
</html>
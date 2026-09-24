@include('layouts.admins.head')
<title>Product Request Details</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            <div class="row mb-4">

                <div class="col-md-8">

                    <h3>
                        Product Request
                    </h3>

                </div>


                <div class="col-md-4 text-md-right">

                    <a
                        href="{{ route('donor.product.requests.index') }}"
                        class="btn btn-secondary"
                    >

                        <i class="fa fa-arrow-left mr-1"></i>

                        Requests

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


            <div class="row">


                {{-- Product --}}

                <div class="col-lg-5">

                    <div class="card">

                        <div class="card-body">


                            <h4>
                                Product
                            </h4>


                            <hr>


                            @if($productRequest->product?->image)

                                <img
                                    src="{{ asset('admins/images/products/'.$productRequest->product->image) }}"
                                    alt="{{ $productRequest->product->name }}"
                                    class="img-fluid mb-3"
                                    style="
                                        width:100%;
                                        max-height:300px;
                                        object-fit:cover;
                                        border-radius:8px;
                                    "
                                >

                            @endif


                            <h4>

                                {{ $productRequest->product?->name }}

                            </h4>


                            <p>

                                <strong>
                                    Category:
                                </strong>

                                {{ $productRequest->product?->category?->name }}

                            </p>


                            <p>

                                {{ $productRequest->product?->description }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- Beneficiary --}}

                <div class="col-lg-7">

                    <div class="card">

                        <div class="card-body">


                            <h4>
                                Beneficiary Information
                            </h4>


                            <hr>


                            @php

                                $beneficiary =
                                    $productRequest->beneficiary;

                                $profile =
                                    $beneficiary?->beneficiaryProfile;

                            @endphp


                            <div class="row">


                                <div class="col-md-6">

                                    <p>
                                        <strong>Name</strong><br>
                                        {{ $beneficiary?->name }}
                                    </p>

                                </div>


                                <div class="col-md-6">

                                    <p>
                                        <strong>Email</strong><br>
                                        {{ $beneficiary?->email }}
                                    </p>

                                </div>


                                <div class="col-md-6">

                                    <p>
                                        <strong>Qalam ID</strong><br>
                                        {{ $beneficiary?->qalam_id }}
                                    </p>

                                </div>


                                <div class="col-md-6">

                                    <p>
                                        <strong>Phone</strong><br>
                                        {{ $profile?->phone ?? 'Not Provided' }}
                                    </p>

                                </div>


                                <div class="col-md-6">

                                    <p>
                                        <strong>Institution</strong><br>
                                        {{ $profile?->institution ?? 'Not Provided' }}
                                    </p>

                                </div>


                                <div class="col-md-6">

                                    <p>
                                        <strong>Degree</strong><br>
                                        {{ $profile?->degree ?? 'Not Provided' }}
                                    </p>

                                </div>


                                <div class="col-md-6">

                                    <p>
                                        <strong>Province</strong><br>
                                        {{ $profile?->province ?? 'Not Provided' }}
                                    </p>

                                </div>


                                <div class="col-md-6">

                                    <p>
                                        <strong>Domicile</strong><br>
                                        {{ $profile?->domicile ?? 'Not Provided' }}
                                    </p>

                                </div>


                                <div class="col-md-12">

                                    <p>
                                        <strong>Address</strong><br>
                                        {{ $profile?->home_address ?? 'Not Provided' }}
                                    </p>

                                </div>

                            </div>


                            <hr>


                            <h5>
                                Request Message
                            </h5>


                            <p>

                                {{ $productRequest->beneficiary_message ?: 'No message provided.' }}

                            </p>


                            <div class="alert alert-success">

                                <strong>
                                    Administrator Approved
                                </strong>

                                @if($productRequest->admin_message)

                                    <br>

                                    {{ $productRequest->admin_message }}

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                DONOR ACTION
            ========================================================== --}}

            @if($productRequest->donor_status === 'pending')

                <div class="row">


                    <div class="col-lg-6">

                        <div class="card border-success">

                            <div class="card-body">

                                <h4 class="text-success">
                                    Accept Request
                                </h4>


                                <form
                                    method="POST"
                                    action="{{ route('donor.product.requests.accept', $productRequest) }}"
                                >

                                    @csrf

                                    @method('PATCH')


                                    <div class="form-group">

                                        <label>
                                            Message
                                        </label>


                                        <textarea
                                            name="donor_message"
                                            class="form-control"
                                            rows="4"
                                            placeholder="Optional message for beneficiary..."
                                        ></textarea>

                                    </div>


                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        onclick="return confirm('Accept this beneficiary request?');"
                                    >

                                        <i class="fa fa-check mr-1"></i>

                                        Accept Request

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-6">

                        <div class="card border-danger">

                            <div class="card-body">

                                <h4 class="text-danger">
                                    Reject Request
                                </h4>


                                <form
                                    method="POST"
                                    action="{{ route('donor.product.requests.reject', $productRequest) }}"
                                >

                                    @csrf

                                    @method('PATCH')


                                    <div class="form-group">

                                        <label>
                                            Rejection Reason
                                        </label>


                                        <textarea
                                            name="donor_message"
                                            class="form-control"
                                            rows="4"
                                            required
                                        ></textarea>

                                    </div>


                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm('Reject this request?');"
                                    >

                                        <i class="fa fa-times mr-1"></i>

                                        Reject Request

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>


            @else

                <div class="card">

                    <div class="card-body">


                        <h4>
                            Final Decision
                        </h4>


                        @if($productRequest->donor_status === 'accepted')

                            <span class="badge badge-success">
                                Accepted
                            </span>

                        @else

                            <span class="badge badge-danger">
                                Rejected
                            </span>

                        @endif


                        @if($productRequest->donor_message)

                            <p class="mt-3 mb-0">

                                {{ $productRequest->donor_message }}

                            </p>

                        @endif

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>


@include('layouts.admins.script')

</body>
</html>
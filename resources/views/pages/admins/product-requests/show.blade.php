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
                        Product Request Review
                    </h3>

                </div>


                <div class="col-md-4 text-md-right">

                    <a
                        href="{{ route('admin.product.requests.index') }}"
                        class="btn btn-secondary"
                    >

                        <i class="fa fa-arrow-left mr-1"></i>

                        Requests

                    </a>

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


            <div class="row">


                {{-- =====================================================
                    PRODUCT
                ====================================================== --}}

                <div class="col-lg-4">

                    <div class="card">

                        <div class="card-body">


                            <h4>
                                Product
                            </h4>


                            <hr>


                            @if($productRequest->product?->image)

                                <img
                                    src="{{ asset('admins/images/products/'.$productRequest->product->image) }}"
                                    class="img-fluid mb-3"
                                    alt="{{ $productRequest->product->name }}"
                                    style="
                                        width:100%;
                                        max-height:250px;
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

                                <strong>
                                    Description:
                                </strong>

                                <br>

                                {{ $productRequest->product?->description }}

                            </p>


                            <p>

                                <strong>
                                    Product Status:
                                </strong>

                                {{ ucfirst($productRequest->product?->status) }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    BENEFICIARY
                ====================================================== --}}

                <div class="col-lg-4">

                    <div class="card">

                        <div class="card-body">


                            <h4>
                                Beneficiary Profile
                            </h4>


                            <hr>


                            @php

                                $beneficiary =
                                    $productRequest->beneficiary;

                                $beneficiaryProfile =
                                    $beneficiary?->beneficiaryProfile;

                            @endphp


                            <p>

                                <strong>Name:</strong>

                                <br>

                                {{ $beneficiary?->name }}

                            </p>


                            <p>

                                <strong>Email:</strong>

                                <br>

                                {{ $beneficiary?->email }}

                            </p>


                            <p>

                                <strong>Qalam ID:</strong>

                                <br>

                                {{ $beneficiary?->qalam_id }}

                            </p>


                            <p>

                                <strong>Phone:</strong>

                                <br>

                                {{ $beneficiaryProfile?->phone ?? 'Not Provided' }}

                            </p>


                            <p>

                                <strong>Institution:</strong>

                                <br>

                                {{ $beneficiaryProfile?->institution ?? 'Not Provided' }}

                            </p>


                            <p>

                                <strong>Degree:</strong>

                                <br>

                                {{ $beneficiaryProfile?->degree ?? 'Not Provided' }}

                            </p>


                            <p>

                                <strong>Enrollment Year:</strong>

                                <br>

                                {{ $beneficiaryProfile?->enrollment_year ?? 'Not Provided' }}

                            </p>


                            <p>

                                <strong>Graduation Year:</strong>

                                <br>

                                {{ $beneficiaryProfile?->graduation_year ?? 'Not Provided' }}

                            </p>


                            <p>

                                <strong>Father Status:</strong>

                                <br>

                                {{ $beneficiaryProfile?->father_status ?? 'Not Provided' }}

                            </p>


                            <p>

                                <strong>Guardian Profession:</strong>

                                <br>

                                {{ $beneficiaryProfile?->guardian_profession ?? 'Not Provided' }}

                            </p>


                            <p>

                                <strong>Monthly Income:</strong>

                                <br>

                                @if($beneficiaryProfile?->monthly_income)

                                    PKR
                                    {{ number_format($beneficiaryProfile->monthly_income) }}

                                @else

                                    Not Provided

                                @endif

                            </p>


                            <p>

                                <strong>Province:</strong>

                                <br>

                                {{ $beneficiaryProfile?->province ?? 'Not Provided' }}

                            </p>


                            <p>

                                <strong>Domicile:</strong>

                                <br>

                                {{ $beneficiaryProfile?->domicile ?? 'Not Provided' }}

                            </p>


                            <p>

                                <strong>Address:</strong>

                                <br>

                                {{ $beneficiaryProfile?->home_address ?? 'Not Provided' }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    DONOR
                ====================================================== --}}

                <div class="col-lg-4">

                    <div class="card">

                        <div class="card-body">


                            <h4>
                                Donor / Product Owner
                            </h4>


                            <hr>


                            @if($productRequest->donor)

                                @php

                                    $donor =
                                        $productRequest->donor;

                                    $donorProfile =
                                        $donor->donorProfile;

                                @endphp


                                <p>

                                    <strong>Name:</strong>

                                    <br>

                                    {{ $donor->name }}

                                </p>


                                <p>

                                    <strong>Email:</strong>

                                    <br>

                                    {{ $donor->email }}

                                </p>


                                <p>

                                    <strong>Phone:</strong>

                                    <br>

                                    {{ $donorProfile?->phone ?? 'Not Provided' }}

                                </p>


                                <p>

                                    <strong>Organization:</strong>

                                    <br>

                                    {{ $donorProfile?->organization ?? 'Not Provided' }}

                                </p>


                                <p>

                                    <strong>Designation:</strong>

                                    <br>

                                    {{ $donorProfile?->designation ?? 'Not Provided' }}

                                </p>


                                <p>

                                    <strong>Location:</strong>

                                    <br>

                                    {{
                                        collect([
                                            $donorProfile?->city,
                                            $donorProfile?->state,
                                            $donorProfile?->country
                                        ])->filter()->implode(', ')
                                        ?: 'Not Provided'
                                    }}

                                </p>

                            @else

                                <div class="alert alert-info">

                                    This product was created by an administrator.

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                BENEFICIARY MESSAGE
            ========================================================== --}}

            <div class="card mb-4">

                <div class="card-body">


                    <h4>
                        Beneficiary Request
                    </h4>


                    <p>

                        {{ $productRequest->beneficiary_message ?: 'No message provided.' }}

                    </p>


                    <hr>


                    <strong>
                        Admin Status:
                    </strong>


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

                        <p class="mt-3 mb-0">

                            <strong>
                                Admin Note:
                            </strong>

                            <br>

                            {{ $productRequest->admin_message }}

                        </p>

                    @endif

                </div>

            </div>


            {{-- =========================================================
                ADMIN ACTIONS
            ========================================================== --}}

            @if($productRequest->admin_status === 'pending')

                <div class="row">


                    {{-- Approve --}}

                    <div class="col-lg-6">

                        <div class="card border-success">

                            <div class="card-body">

                                <h4 class="text-success">
                                    Approve Request
                                </h4>


                                <p class="text-muted">

                                    After approval, this request will become visible to the donor.

                                </p>


                                <form
                                    action="{{ route('admin.product.requests.approve', $productRequest) }}"
                                    method="POST"
                                >

                                    @csrf

                                    @method('PATCH')


                                    <div class="form-group">

                                        <label>
                                            Admin Note
                                        </label>


                                        <textarea
                                            name="admin_message"
                                            rows="4"
                                            class="form-control"
                                            placeholder="Optional note..."
                                        ></textarea>

                                    </div>


                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        onclick="return confirm('Approve this request and forward it to the donor?');"
                                    >

                                        <i class="fa fa-check mr-1"></i>

                                        Approve Request

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>


                    {{-- Reject --}}

                    <div class="col-lg-6">

                        <div class="card border-danger">

                            <div class="card-body">

                                <h4 class="text-danger">
                                    Reject Request
                                </h4>


                                <form
                                    action="{{ route('admin.product.requests.reject', $productRequest) }}"
                                    method="POST"
                                >

                                    @csrf

                                    @method('PATCH')


                                    <div class="form-group">

                                        <label>
                                            Rejection Reason
                                        </label>


                                        <textarea
                                            name="admin_message"
                                            rows="4"
                                            class="form-control"
                                            required
                                            placeholder="Reason for rejection..."
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

            @endif

        </div>

    </div>

</div>


@include('layouts.admins.script')

</body>
</html>
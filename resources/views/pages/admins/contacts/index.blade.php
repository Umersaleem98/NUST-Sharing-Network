@include('layouts.admins.head')
<title>Contact Messages</title>
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

                <div class="col-md-8">

                    <h3 class="mb-1">
                        Contact Messages
                    </h3>

                    <p class="text-muted mb-0">

                        View and manage inquiries submitted through
                        the NUST Sharing Network contact form.

                    </p>

                </div>

            </div>



            {{-- =========================================================
                SUCCESS MESSAGE
            ========================================================== --}}

            @if(session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >

                    <i class="fa fa-check-circle mr-2"></i>

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
                STATISTICS
            ========================================================== --}}

            <div class="row">


                {{-- Total --}}

                <div class="col-xl-3 col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div
                                    class="contact-stat-icon bg-primary-light"
                                >
                                    <i class="icon-envelope"></i>
                                </div>


                                <div class="ml-3">

                                    <p class="mb-1 text-muted">
                                        Total Messages
                                    </p>

                                    <h4 class="mb-0">
                                        {{ $totalContacts }}
                                    </h4>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- New --}}

                <div class="col-xl-3 col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div
                                    class="contact-stat-icon bg-warning-light"
                                >
                                    <i class="fa fa-envelope"></i>
                                </div>


                                <div class="ml-3">

                                    <p class="mb-1 text-muted">
                                        New
                                    </p>

                                    <h4 class="mb-0">
                                        {{ $newContacts }}
                                    </h4>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- Read --}}

                <div class="col-xl-3 col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div
                                    class="contact-stat-icon bg-info-light"
                                >
                                    <i class="fa fa-envelope-open"></i>
                                </div>


                                <div class="ml-3">

                                    <p class="mb-1 text-muted">
                                        Read
                                    </p>

                                    <h4 class="mb-0">
                                        {{ $readContacts }}
                                    </h4>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- Resolved --}}

                <div class="col-xl-3 col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div
                                    class="contact-stat-icon bg-success-light"
                                >
                                    <i class="fa fa-check"></i>
                                </div>


                                <div class="ml-3">

                                    <p class="mb-1 text-muted">
                                        Resolved
                                    </p>

                                    <h4 class="mb-0">
                                        {{ $resolvedContacts }}
                                    </h4>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =========================================================
                FILTERS
            ========================================================== --}}

            <div class="card mb-4">

                <div class="card-body">

                    <form
                        action="{{ route('admin.contacts.index') }}"
                        method="GET"
                    >

                        <div class="row align-items-end">


                            {{-- Search --}}

                            <div class="col-lg-5 col-md-6 mb-3">

                                <label class="font-weight-bold">
                                    Search
                                </label>

                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    value="{{ request('search') }}"
                                    placeholder="Name, email, phone, subject..."
                                >

                            </div>



                            {{-- Status --}}

                            <div class="col-lg-2 col-md-3 mb-3">

                                <label class="font-weight-bold">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="form-control"
                                >

                                    <option value="">
                                        All Statuses
                                    </option>

                                    <option
                                        value="new"
                                        {{ request('status') === 'new' ? 'selected' : '' }}
                                    >
                                        New
                                    </option>

                                    <option
                                        value="read"
                                        {{ request('status') === 'read' ? 'selected' : '' }}
                                    >
                                        Read
                                    </option>

                                    <option
                                        value="resolved"
                                        {{ request('status') === 'resolved' ? 'selected' : '' }}
                                    >
                                        Resolved
                                    </option>

                                </select>

                            </div>



                            {{-- Inquiry --}}

                            <div class="col-lg-3 col-md-3 mb-3">

                                <label class="font-weight-bold">
                                    Inquiry Type
                                </label>

                                <select
                                    name="inquiry_type"
                                    class="form-control"
                                >

                                    <option value="">
                                        All Types
                                    </option>

                                    <option
                                        value="general"
                                        {{ request('inquiry_type') === 'general' ? 'selected' : '' }}
                                    >
                                        General
                                    </option>

                                    <option
                                        value="donor_support"
                                        {{ request('inquiry_type') === 'donor_support' ? 'selected' : '' }}
                                    >
                                        Donor Support
                                    </option>

                                    <option
                                        value="beneficiary_support"
                                        {{ request('inquiry_type') === 'beneficiary_support' ? 'selected' : '' }}
                                    >
                                        Beneficiary Support
                                    </option>

                                    <option
                                        value="account_support"
                                        {{ request('inquiry_type') === 'account_support' ? 'selected' : '' }}
                                    >
                                        Account Support
                                    </option>

                                    <option
                                        value="technical"
                                        {{ request('inquiry_type') === 'technical' ? 'selected' : '' }}
                                    >
                                        Technical
                                    </option>

                                    <option
                                        value="feedback"
                                        {{ request('inquiry_type') === 'feedback' ? 'selected' : '' }}
                                    >
                                        Feedback
                                    </option>

                                    <option
                                        value="other"
                                        {{ request('inquiry_type') === 'other' ? 'selected' : '' }}
                                    >
                                        Other
                                    </option>

                                </select>

                            </div>



                            {{-- Buttons --}}

                            <div class="col-lg-2 mb-3">

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-block"
                                >

                                    <i class="fa fa-search mr-1"></i>

                                    Filter

                                </button>

                            </div>

                        </div>


                        @if(
                            request()->filled('search')
                            ||
                            request()->filled('status')
                            ||
                            request()->filled('inquiry_type')
                        )

                            <a
                                href="{{ route('admin.contacts.index') }}"
                                class="btn btn-sm btn-light"
                            >

                                <i class="fa fa-times mr-1"></i>

                                Clear Filters

                            </a>

                        @endif

                    </form>

                </div>

            </div>



            {{-- =========================================================
                CONTACT TABLE
            ========================================================== --}}

            <div class="card">

                <div class="card-header">

                    <h4 class="card-title mb-0">
                        Messages
                    </h4>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            class="table table-hover align-middle"
                        >

                            <thead>

                            <tr>

                                <th>#</th>

                                <th>Sender</th>

                                <th>Subject</th>

                                <th>Inquiry</th>

                                <th>Status</th>

                                <th>Date</th>

                                <th class="text-center">
                                    Action
                                </th>

                            </tr>

                            </thead>


                            <tbody>


                            @forelse($contacts as $contact)

                                <tr
                                    class="{{
                                        $contact->status === 'new'
                                            ? 'contact-unread-row'
                                            : ''
                                    }}"
                                >


                                    <td>

                                        {{
                                            $contacts->firstItem()
                                            + $loop->index
                                        }}

                                    </td>



                                    {{-- Sender --}}

                                    <td>

                                        <div class="font-weight-bold">

                                            {{ $contact->name }}


                                            @if($contact->status === 'new')

                                                <span
                                                    class="contact-new-dot"
                                                    title="New Message"
                                                ></span>

                                            @endif

                                        </div>


                                        <small class="text-muted">

                                            {{ $contact->email }}

                                        </small>


                                        @if($contact->phone)

                                            <small
                                                class="d-block text-muted"
                                            >

                                                {{ $contact->phone }}

                                            </small>

                                        @endif

                                    </td>



                                    {{-- Subject --}}

                                    <td>

                                        <strong>

                                            {{
                                                \Illuminate\Support\Str::limit(
                                                    $contact->subject,
                                                    45
                                                )
                                            }}

                                        </strong>


                                        <small
                                            class="d-block text-muted mt-1"
                                        >

                                            {{
                                                \Illuminate\Support\Str::limit(
                                                    $contact->message,
                                                    60
                                                )
                                            }}

                                        </small>

                                    </td>



                                    {{-- Inquiry Type --}}

                                    <td>

                                        <span
                                            class="badge badge-light"
                                        >

                                            {{
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $contact->inquiry_type
                                                    )
                                                )
                                            }}

                                        </span>

                                    </td>



                                    {{-- Status --}}

                                    <td>

                                        @if($contact->status === 'new')

                                            <span
                                                class="badge badge-warning"
                                            >
                                                New
                                            </span>


                                        @elseif($contact->status === 'read')

                                            <span
                                                class="badge badge-info"
                                            >
                                                Read
                                            </span>


                                        @else

                                            <span
                                                class="badge badge-success"
                                            >
                                                Resolved
                                            </span>

                                        @endif

                                    </td>



                                    {{-- Date --}}

                                    <td>

                                        {{
                                            $contact
                                                ->created_at
                                                ->format('d M Y')
                                        }}

                                        <small
                                            class="d-block text-muted"
                                        >

                                            {{
                                                $contact
                                                    ->created_at
                                                    ->format('h:i A')
                                            }}

                                        </small>

                                    </td>



                                    {{-- Actions --}}

                                    <td class="text-center">

                                        <a
                                            href="{{
                                                route(
                                                    'admin.contacts.show',
                                                    $contact
                                                )
                                            }}"
                                            class="btn btn-sm btn-primary"
                                            title="View Message"
                                        >

                                            <i class="fa fa-eye"></i>

                                        </a>


                                        <form
                                            action="{{
                                                route(
                                                    'admin.contacts.destroy',
                                                    $contact
                                                )
                                            }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="
                                                return confirm(
                                                    'Are you sure you want to delete this contact message?'
                                                );
                                            "
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
                                        colspan="7"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="icon-envelope"
                                            style="
                                                font-size: 35px;
                                                color: #ccd5dc;
                                            "
                                        ></i>


                                        <h6 class="mt-3">
                                            No Contact Messages
                                        </h6>


                                        <p class="text-muted mb-0">

                                            No contact messages were found.

                                        </p>

                                    </td>

                                </tr>

                            @endforelse


                            </tbody>

                        </table>

                    </div>



                    {{-- Pagination --}}

                    @if($contacts->hasPages())

                        <div
                            class="d-flex justify-content-center mt-4"
                        >

                            {{ $contacts->links() }}

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>




</div>


@include('layouts.admins.script')


<style>

    .contact-stat-icon {

        width: 48px;

        height: 48px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 10px;

        font-size: 20px;
    }


    .bg-primary-light {

        background:
            rgba(
                0,
                85,
                140,
                0.12
            );

        color: #00558c;
    }


    .bg-warning-light {

        background:
            rgba(
                255,
                193,
                7,
                0.15
            );

        color: #c69500;
    }


    .bg-info-light {

        background:
            rgba(
                23,
                162,
                184,
                0.13
            );

        color: #138496;
    }


    .bg-success-light {

        background:
            rgba(
                40,
                167,
                69,
                0.13
            );

        color: #218838;
    }


    .contact-unread-row {

        background:
            rgba(
                0,
                85,
                140,
                0.035
            );
    }


    .contact-new-dot {

        display: inline-block;

        width: 7px;

        height: 7px;

        margin-left: 5px;

        border-radius: 50%;

        background: #00558c;
    }

</style>

</body>
</html>
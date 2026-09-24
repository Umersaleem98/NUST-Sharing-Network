@include('layouts.admins.head')
<title>Contact Message</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')

    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            {{-- =========================================================
                HEADER
            ========================================================== --}}

            <div
                class="d-flex justify-content-between align-items-center flex-wrap mb-4"
            >

                <div>

                    <h3 class="mb-1">

                        Contact Message

                    </h3>


                    <p class="text-muted mb-0">

                        View complete contact inquiry details.

                    </p>

                </div>


                <a
                    href="{{ route('admin.contacts.index') }}"
                    class="btn btn-light"
                >

                    <i class="fa fa-arrow-left mr-1"></i>

                    Back to Messages

                </a>

            </div>



            {{-- =========================================================
                SUCCESS
            ========================================================== --}}

            @if(session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                >

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



            <div class="row">


                {{-- =====================================================
                    MESSAGE
                ====================================================== --}}

                <div class="col-lg-8">

                    <div class="card">

                        <div class="card-header">

                            <div
                                class="d-flex justify-content-between align-items-center"
                            >

                                <h4 class="card-title mb-0">

                                    {{ $contact->subject }}

                                </h4>


                                @if($contact->status === 'new')

                                    <span class="badge badge-warning">
                                        New
                                    </span>


                                @elseif($contact->status === 'read')

                                    <span class="badge badge-info">
                                        Read
                                    </span>


                                @else

                                    <span class="badge badge-success">
                                        Resolved
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="card-body">

                            <div class="contact-message-box">

                                {!! nl2br(e($contact->message)) !!}

                            </div>

                        </div>

                    </div>



                    {{-- Actions --}}

                    <div class="card">

                        <div class="card-body">

                            <div
                                class="d-flex flex-wrap"
                                style="gap: 10px;"
                            >


                                @if($contact->status !== 'resolved')

                                    <form
                                        action="{{
                                            route(
                                                'admin.contacts.resolve',
                                                $contact
                                            )
                                        }}"
                                        method="POST"
                                    >

                                        @csrf
                                        @method('PATCH')


                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                        >

                                            <i class="fa fa-check mr-1"></i>

                                            Mark as Resolved

                                        </button>

                                    </form>

                                @endif



                                <form
                                    action="{{
                                        route(
                                            'admin.contacts.destroy',
                                            $contact
                                        )
                                    }}"
                                    method="POST"
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
                                        class="btn btn-danger"
                                    >

                                        <i class="fa fa-trash mr-1"></i>

                                        Delete Message

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    SENDER INFORMATION
                ====================================================== --}}

                <div class="col-lg-4">

                    <div class="card">

                        <div class="card-header">

                            <h4 class="card-title mb-0">

                                Sender Information

                            </h4>

                        </div>


                        <div class="card-body">


                            {{-- Name --}}

                            <div class="contact-detail-item">

                                <span>
                                    Full Name
                                </span>

                                <strong>
                                    {{ $contact->name }}
                                </strong>

                            </div>



                            {{-- Email --}}

                            <div class="contact-detail-item">

                                <span>
                                    Email
                                </span>

                                <a
                                    href="mailto:{{ $contact->email }}"
                                >

                                    {{ $contact->email }}

                                </a>

                            </div>



                            {{-- Phone --}}

                            <div class="contact-detail-item">

                                <span>
                                    Phone
                                </span>

                                @if($contact->phone)

                                    <a
                                        href="tel:{{ $contact->phone }}"
                                    >

                                        {{ $contact->phone }}

                                    </a>

                                @else

                                    <strong>
                                        —
                                    </strong>

                                @endif

                            </div>



                            {{-- User Type --}}

                            <div class="contact-detail-item">

                                <span>
                                    User Type
                                </span>

                                <strong>

                                    {{
                                        $contact->user_type
                                            ? ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $contact->user_type
                                                )
                                            )
                                            : 'Not Specified'
                                    }}

                                </strong>

                            </div>



                            {{-- Inquiry Type --}}

                            <div class="contact-detail-item">

                                <span>
                                    Inquiry Type
                                </span>

                                <strong>

                                    {{
                                        ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $contact->inquiry_type
                                            )
                                        )
                                    }}

                                </strong>

                            </div>



                            {{-- Submitted --}}

                            <div class="contact-detail-item">

                                <span>
                                    Submitted
                                </span>

                                <strong>

                                    {{
                                        $contact
                                            ->created_at
                                            ->format(
                                                'd M Y, h:i A'
                                            )
                                    }}

                                </strong>

                            </div>



                            {{-- Read At --}}

                            <div class="contact-detail-item">

                                <span>
                                    Read At
                                </span>

                                <strong>

                                    {{
                                        $contact->read_at
                                            ? $contact
                                                ->read_at
                                                ->format(
                                                    'd M Y, h:i A'
                                                )
                                            : 'Not Read'
                                    }}

                                </strong>

                            </div>



                            {{-- Privacy --}}

                            <div
                                class="contact-detail-item border-0"
                            >

                                <span>
                                    Privacy Consent
                                </span>


                                @if($contact->privacy)

                                    <strong class="text-success">

                                        <i
                                            class="fa fa-check-circle mr-1"
                                        ></i>

                                        Accepted

                                    </strong>

                                @else

                                    <strong class="text-danger">

                                        Not Accepted

                                    </strong>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>




</div>


@include('layouts.admins.script')


<style>

    .contact-message-box {

        min-height: 180px;

        padding: 22px;

        border:
            1px solid
            #e5ebef;

        border-radius: 8px;

        background: #f9fbfc;

        color: #405363;

        font-size: 14px;

        line-height: 1.8;
    }


    .contact-detail-item {

        display: flex;

        flex-direction: column;

        gap: 4px;

        padding:
            12px
            0;

        border-bottom:
            1px solid
            #edf1f4;
    }


    .contact-detail-item span {

        color: #8795a1;

        font-size: 11px;

        font-weight: 600;

        text-transform: uppercase;

        letter-spacing:
            0.4px;
    }


    .contact-detail-item strong,
    .contact-detail-item a {

        color: #25384b;

        font-size: 13px;

        font-weight: 600;

        word-break: break-word;
    }


    .contact-detail-item a:hover {

        color: #00558c;
    }

</style>

</body>
</html>
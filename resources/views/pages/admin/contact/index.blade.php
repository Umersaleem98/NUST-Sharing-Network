@include('layouts.admin.head')

<title>Contact Messages | Admin Dashboard</title>


<style>

    /* =========================================================
       CONTACT ADMIN PAGE
    ========================================================== */

    .contact-admin-page {
        width: 100%;
    }


    .contact-admin-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }


    .contact-admin-title-wrap h1 {
        margin: 0 0 7px;
        color: #123b60;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
    }


    .contact-admin-title-wrap p {
        margin: 0;
        color: #6f7f90;
        font-size: 13px;
        line-height: 1.7;
    }


    .contact-admin-title-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 44px;
        height: 44px;

        margin-bottom: 12px;

        border-radius: 12px;

        background: rgba(250, 188, 77, .18);
        color: #d99b24;

        font-size: 18px;
    }


    /* =========================================================
       STAT CARDS
    ========================================================== */

    .contact-stat-card {
        height: 100%;

        padding: 20px;

        border: 1px solid #e3e9ef;
        border-radius: 16px;

        background: #ffffff;

        box-shadow:
            0 8px 24px
            rgba(18, 59, 96, .05);
    }


    .contact-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;
    }


    .contact-stat-icon {
        width: 43px;
        height: 43px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background: #f4f7fa;
        color: #123b60;

        font-size: 17px;
    }


    .contact-stat-card h3 {
        margin: 17px 0 3px;

        color: #123b60;

        font-size: 26px;
        font-weight: 800;
    }


    .contact-stat-card p {
        margin: 0;

        color: #7d8b99;

        font-size: 12px;
        font-weight: 600;
    }


    .contact-stat-new .contact-stat-icon {
        background: rgba(250, 188, 77, .18);
        color: #d99b24;
    }


    .contact-stat-read .contact-stat-icon {
        background: rgba(18, 59, 96, .10);
        color: #123b60;
    }


    .contact-stat-resolved .contact-stat-icon {
        background: rgba(46, 139, 102, .11);
        color: #2e8b66;
    }


    /* =========================================================
       MAIN CARD
    ========================================================== */

    .contact-admin-card {
        margin-top: 25px;

        border: 1px solid #e3e9ef;
        border-radius: 18px;

        background: #ffffff;

        box-shadow:
            0 10px 30px
            rgba(18, 59, 96, .05);

        overflow: hidden;
    }


    .contact-admin-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding: 20px 22px;

        border-bottom: 1px solid #e8edf2;

        background: #ffffff;
    }


    .contact-admin-card-header h5 {
        margin: 0;

        color: #123b60;

        font-size: 17px;
        font-weight: 800;
    }


    .contact-admin-card-header p {
        margin: 5px 0 0;

        color: #7c8a98;

        font-size: 12px;
    }


    /* =========================================================
       DELETE SELECTED
    ========================================================== */

    .contact-delete-selected-btn {
        display: none;
        align-items: center;
        justify-content: center;

        gap: 7px;

        min-height: 40px;

        padding: 9px 15px;

        border: 1px solid #bd3b3b;
        border-radius: 10px;

        background: #ffffff;
        color: #bd3b3b;

        font-size: 12px;
        font-weight: 700;

        cursor: pointer;

        transition: .2s ease;
    }


    .contact-delete-selected-btn.show {
        display: inline-flex;
    }


    .contact-delete-selected-btn:hover {
        background: #bd3b3b;
        color: #ffffff;
    }


    .selected-count {
        min-width: 20px;
        height: 20px;

        padding: 0 6px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 30px;

        background: #bd3b3b;
        color: #ffffff;

        font-size: 10px;
    }


    .contact-delete-selected-btn:hover .selected-count {
        background: #ffffff;
        color: #bd3b3b;
    }


    /* =========================================================
       FILTERS
    ========================================================== */

    .contact-filter-form {
        padding: 20px 22px;

        border-bottom: 1px solid #edf1f5;

        background: #fafbfd;
    }


    .contact-filter-control {
        width: 100%;
        height: 43px;

        padding: 9px 13px;

        border: 1px solid #dce3ea;
        border-radius: 10px;

        background: #ffffff;
        color: #25384b;

        font-size: 13px;

        outline: none;

        transition: .2s ease;
    }


    .contact-filter-control:focus {
        border-color: #123b60;

        box-shadow:
            0 0 0 3px
            rgba(18, 59, 96, .06);
    }


    .contact-filter-btn {
        width: 100%;
        height: 43px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 7px;

        border: none;
        border-radius: 10px;

        background: #123b60;
        color: #ffffff;

        font-size: 13px;
        font-weight: 700;

        transition: .25s ease;
    }


    .contact-filter-btn:hover {
        background: #082944;
        color: #fabc4d;
    }


    .contact-reset-btn {
        width: 100%;
        height: 43px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 7px;

        border: 1px solid #dce3ea;
        border-radius: 10px;

        background: #ffffff;
        color: #536474;

        font-size: 13px;
        font-weight: 700;

        text-decoration: none;

        transition: .25s ease;
    }


    .contact-reset-btn:hover {
        border-color: #123b60;
        color: #123b60;
    }


    /* =========================================================
       CHECKBOX
    ========================================================== */

    .contact-checkbox {
        width: 17px;
        height: 17px;

        border: 1px solid #cbd5df;
        border-radius: 4px;

        cursor: pointer;

        accent-color: #123b60;
    }


    /* =========================================================
       TABLE
    ========================================================== */

    .contact-table-wrap {
        width: 100%;
        overflow-x: auto;
    }


    .contact-table {
        width: 100%;
        min-width: 1100px;

        margin: 0;

        border-collapse: collapse;
    }


    .contact-table thead th {
        padding: 14px 16px;

        border-bottom: 1px solid #dfe6ed;

        background: #f7f9fb;
        color: #51606f;

        font-size: 11px;
        font-weight: 800;

        letter-spacing: .35px;

        text-transform: uppercase;

        white-space: nowrap;
    }


    .contact-table tbody td {
        padding: 15px 16px;

        border-bottom: 1px solid #edf1f4;

        color: #445464;

        font-size: 13px;

        vertical-align: middle;
    }


    .contact-table tbody tr {
        transition: .2s ease;
    }


    .contact-table tbody tr:hover {
        background: #fafcfe;
    }


    .contact-table tbody tr.contact-row-selected {
        background: rgba(18, 59, 96, .045);
    }


    .contact-table tbody tr.contact-row-new {
        background: rgba(250, 188, 77, .04);
    }


    .contact-table tbody tr:last-child td {
        border-bottom: none;
    }


    .contact-user-info {
        display: flex;
        align-items: center;

        gap: 11px;

        min-width: 190px;
    }


    .contact-user-avatar {
        flex: 0 0 38px;

        width: 38px;
        height: 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #123b60;
        color: #ffffff;

        font-size: 13px;
        font-weight: 800;

        text-transform: uppercase;
    }


    .contact-user-name {
        margin: 0 0 2px;

        color: #123b60;

        font-size: 13px;
        font-weight: 700;
    }


    .contact-user-email {
        margin: 0;

        color: #7d8b98;

        font-size: 11px;
    }


    .contact-subject {
        max-width: 230px;

        color: #334659;

        font-weight: 600;
        line-height: 1.5;
    }


    .contact-message-preview {
        max-width: 260px;

        color: #758493;

        font-size: 12px;
        line-height: 1.5;
    }


    /* =========================================================
       BADGES
    ========================================================== */

    .contact-status-badge,
    .contact-type-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 6px 10px;

        border-radius: 50px;

        font-size: 10px;
        font-weight: 800;

        line-height: 1;

        white-space: nowrap;

        text-transform: capitalize;
    }


    .contact-status-new {
        background: rgba(250, 188, 77, .18);
        color: #b57b10;
    }


    .contact-status-read {
        background: rgba(18, 59, 96, .10);
        color: #123b60;
    }


    .contact-status-resolved {
        background: rgba(46, 139, 102, .12);
        color: #2e8b66;
    }


    .contact-type-badge {
        background: #f1f4f7;
        color: #5c6d7d;
    }


    /* =========================================================
       DATE
    ========================================================== */

    .contact-created-date {
        white-space: nowrap;
    }


    .contact-created-date strong {
        display: block;

        color: #334659;

        font-size: 12px;
        font-weight: 700;
    }


    .contact-created-date span {
        color: #8a98a5;

        font-size: 10px;
    }


    /* =========================================================
       DELETE ACTION
    ========================================================== */

    .contact-actions {
        display: flex;
        align-items: center;

        gap: 6px;
    }


    .contact-action-delete {
        width: 36px;
        height: 36px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 1px solid rgba(189, 59, 59, .20);
        border-radius: 9px;

        background: rgba(189, 59, 59, .06);
        color: #bd3b3b;

        font-size: 12px;

        cursor: pointer;

        transition: .2s ease;
    }


    .contact-action-delete:hover {
        border-color: #bd3b3b;

        background: #bd3b3b;
        color: #ffffff;
    }


    /* =========================================================
       EMPTY
    ========================================================== */

    .contact-empty-state {
        padding: 60px 20px;

        text-align: center;
    }


    .contact-empty-icon {
        width: 70px;
        height: 70px;

        margin: 0 auto 17px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #f2f5f8;
        color: #9ba8b4;

        font-size: 24px;
    }


    .contact-empty-state h5 {
        color: #123b60;

        font-weight: 800;
    }


    .contact-empty-state p {
        margin: 0;

        color: #7a8998;

        font-size: 13px;
    }


    /* =========================================================
       PAGINATION
    ========================================================== */

    .contact-pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding: 18px 22px;

        border-top: 1px solid #edf1f4;

        background: #ffffff;
    }


    .contact-pagination-info {
        margin: 0;

        color: #7b8996;

        font-size: 12px;
    }


    /* =========================================================
       SUCCESS / ERROR
    ========================================================== */

    .contact-admin-alert-success {
        display: flex;
        align-items: center;

        gap: 10px;

        margin-bottom: 20px;
        padding: 14px 17px;

        border:
            1px solid
            rgba(46, 139, 102, .20);

        border-radius: 12px;

        background:
            rgba(46, 139, 102, .07);

        color: #247453;

        font-size: 13px;
        font-weight: 600;
    }


    .contact-admin-alert-danger {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 20px;
        padding: 14px 17px;

        border:
            1px solid
            rgba(189, 59, 59, .20);

        border-radius: 12px;

        background:
            rgba(189, 59, 59, .06);

        color: #a83232;

        font-size: 13px;
    }


    .contact-admin-alert-danger ul {
        margin: 5px 0 0;
        padding-left: 18px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 767.98px) {

        .contact-admin-header {
            flex-direction: column;
        }


        .contact-admin-card-header {
            align-items: flex-start;
            flex-direction: column;
        }


        .contact-pagination-wrap {
            flex-direction: column;
            align-items: flex-start;
        }

    }

</style>


<body>


@include('layouts.admin.sidebar')


<!-- =========================================================
     MAIN
========================================================== -->
<div class="nsn-main">


    @include('layouts.admin.header')
    @include('layouts.admin.alert')


    <div class="nsn-content">


        <div class="contact-admin-page">


            <!-- =================================================
                 PAGE HEADER
            ================================================== -->
            <div class="contact-admin-header">


                <div class="contact-admin-title-wrap">


                    <div class="contact-admin-title-icon">

                        <i class="fa-solid fa-envelope-open-text"></i>

                    </div>


                    <h1>
                        Contact Messages
                    </h1>


                    <p>
                        Review and manage messages submitted
                        through the NUST Sharing Network
                        contact form.
                    </p>


                </div>


            </div>



            <!-- =================================================
                 STATISTICS
            ================================================== -->
            <div class="row g-3">


                <!-- Total -->
                <div class="col-xl-3 col-md-6">

                    <div class="contact-stat-card">

                        <div class="contact-stat-top">

                            <div class="contact-stat-icon">

                                <i class="fa-solid fa-envelope"></i>

                            </div>

                        </div>


                        <h3>
                            {{ number_format($totalContacts) }}
                        </h3>


                        <p>
                            Total Messages
                        </p>

                    </div>

                </div>


                <!-- New -->
                <div class="col-xl-3 col-md-6">

                    <div class="contact-stat-card contact-stat-new">

                        <div class="contact-stat-top">

                            <div class="contact-stat-icon">

                                <i class="fa-solid fa-envelope-circle-check"></i>

                            </div>

                        </div>


                        <h3>
                            {{ number_format($newContacts) }}
                        </h3>


                        <p>
                            New Messages
                        </p>

                    </div>

                </div>


                <!-- Read -->
                <div class="col-xl-3 col-md-6">

                    <div class="contact-stat-card contact-stat-read">

                        <div class="contact-stat-top">

                            <div class="contact-stat-icon">

                                <i class="fa-solid fa-envelope-open"></i>

                            </div>

                        </div>


                        <h3>
                            {{ number_format($readContacts) }}
                        </h3>


                        <p>
                            Read Messages
                        </p>

                    </div>

                </div>


                <!-- Resolved -->
                <div class="col-xl-3 col-md-6">

                    <div class="contact-stat-card contact-stat-resolved">

                        <div class="contact-stat-top">

                            <div class="contact-stat-icon">

                                <i class="fa-solid fa-circle-check"></i>

                            </div>

                        </div>


                        <h3>
                            {{ number_format($resolvedContacts) }}
                        </h3>


                        <p>
                            Resolved Messages
                        </p>

                    </div>

                </div>


            </div>


            <!-- =================================================
                 CONTACT CARD
            ================================================== -->
            <div class="contact-admin-card">


                <!-- =============================================
                     CARD HEADER
                ============================================== -->
                <div class="contact-admin-card-header">


                    <div>

                        <h5>
                            All Contact Messages
                        </h5>


                        <p>
                            Latest messages are displayed first.
                        </p>

                    </div>


                    <!-- =========================================
                         DELETE SELECTED BUTTON
                    ========================================== -->
                    <button
                        type="button"
                        id="deleteSelectedBtn"
                        class="contact-delete-selected-btn"
                    >

                        <i class="fa-solid fa-trash"></i>

                        Delete Selected

                        <span
                            class="selected-count"
                            id="selectedCount"
                        >
                            0
                        </span>

                    </button>


                </div>


                <!-- =============================================
                     FILTER FORM
                ============================================== -->
                <form
                    action="{{ route('admin.contact.index') }}"
                    method="GET"
                    class="contact-filter-form"
                >


                    <div class="row g-2">


                        <!-- Search -->
                        <div class="col-lg-5">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="contact-filter-control"
                                placeholder="Search name, email, subject or message..."
                            >

                        </div>


                        <!-- Status -->
                        <div class="col-lg-2 col-md-4">

                            <select
                                name="status"
                                class="contact-filter-control"
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


                        <!-- Inquiry Type -->
                        <div class="col-lg-2 col-md-4">

                            <select
                                name="inquiry_type"
                                class="contact-filter-control"
                            >

                                <option value="">
                                    All Inquiry Types
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


                        <!-- Filter -->
                        <div class="col-lg-1 col-md-2">

                            <button
                                type="submit"
                                class="contact-filter-btn"
                                title="Apply Filters"
                            >

                                <i class="fa-solid fa-filter"></i>

                            </button>

                        </div>


                        <!-- Reset -->
                        <div class="col-lg-2 col-md-2">

                            <a
                                href="{{ route('admin.contact.index') }}"
                                class="contact-reset-btn"
                            >

                                <i class="fa-solid fa-rotate-left"></i>

                                Reset

                            </a>

                        </div>


                    </div>


                </form>


                <!-- =============================================
                     BULK DELETE FORM
                ============================================== -->
                <form
                    id="bulkDeleteForm"
                    action="{{ route('admin.contact.destroy-selected') }}"
                    method="POST"
                >

                    @csrf
                    @method('DELETE')


                    @if($contacts->count() > 0)


                        <!-- =====================================
                             TABLE
                        ====================================== -->
                        <div class="contact-table-wrap">


                            <table class="contact-table">


                                <thead>

                                    <tr>


                                        <!-- Select All -->
                                        <th style="width: 45px;">

                                            <input
                                                type="checkbox"
                                                id="selectAll"
                                                class="contact-checkbox"
                                                title="Select All"
                                            >

                                        </th>


                                        <th>
                                            #
                                        </th>


                                        <th>
                                            Sender
                                        </th>


                                        <th>
                                            Subject
                                        </th>


                                        <th>
                                            Inquiry Type
                                        </th>


                                        <th>
                                            Message
                                        </th>


                                        <th>
                                            Status
                                        </th>


                                        <th>
                                            Created Date
                                        </th>


                                        <th>
                                            Delete
                                        </th>


                                    </tr>

                                </thead>


                                <tbody>


                                    @foreach($contacts as $contact)


                                        <tr
                                            class="{{ $contact->status === 'new' ? 'contact-row-new' : '' }}"
                                            data-row-id="{{ $contact->id }}"
                                        >


                                            <!-- Checkbox -->
                                            <td>

                                                <input
                                                    type="checkbox"
                                                    name="ids[]"
                                                    value="{{ $contact->id }}"
                                                    class="contact-checkbox contact-row-checkbox"
                                                >

                                            </td>


                                            <!-- Serial -->
                                            <td>

                                                {{
                                                    $contacts->firstItem()
                                                    +
                                                    $loop->index
                                                }}

                                            </td>


                                            <!-- Sender -->
                                            <td>


                                                <div class="contact-user-info">


                                                    <div class="contact-user-avatar">

                                                        {{
                                                            strtoupper(
                                                                substr(
                                                                    $contact->name,
                                                                    0,
                                                                    1
                                                                )
                                                            )
                                                        }}

                                                    </div>


                                                    <div>


                                                        <p class="contact-user-name">

                                                            {{ $contact->name }}

                                                        </p>


                                                        <p class="contact-user-email">

                                                            {{ $contact->email }}

                                                        </p>


                                                        @if($contact->phone)

                                                            <p class="contact-user-email">

                                                                {{ $contact->phone }}

                                                            </p>

                                                        @endif


                                                    </div>


                                                </div>


                                            </td>


                                            <!-- Subject -->
                                            <td>

                                                <div class="contact-subject">

                                                    {{
                                                        $contact->subject
                                                    }}

                                                </div>

                                            </td>


                                            <!-- Inquiry Type -->
                                            <td>

                                                <span class="contact-type-badge">

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


                                            <!-- Message -->
                                            <td>

                                                <div class="contact-message-preview">

                                                    {{
                                                        \Illuminate\Support\Str::limit(
                                                            $contact->message,
                                                            90
                                                        )
                                                    }}

                                                </div>

                                            </td>


                                            <!-- Status -->
                                            <td>


                                                @if($contact->status === 'new')

                                                    <span
                                                        class="
                                                            contact-status-badge
                                                            contact-status-new
                                                        "
                                                    >

                                                        New

                                                    </span>


                                                @elseif($contact->status === 'read')

                                                    <span
                                                        class="
                                                            contact-status-badge
                                                            contact-status-read
                                                        "
                                                    >

                                                        Read

                                                    </span>


                                                @elseif($contact->status === 'resolved')

                                                    <span
                                                        class="
                                                            contact-status-badge
                                                            contact-status-resolved
                                                        "
                                                    >

                                                        Resolved

                                                    </span>

                                                @endif


                                            </td>


                                            <!-- Created Date -->
                                            <td>

                                                <div class="contact-created-date">


                                                    <strong>

                                                        {{
                                                            $contact
                                                                ->created_at
                                                                ->format(
                                                                    'd M Y'
                                                                )
                                                        }}

                                                    </strong>


                                                    <span>

                                                        {{
                                                            $contact
                                                                ->created_at
                                                                ->format(
                                                                    'h:i A'
                                                                )
                                                        }}

                                                    </span>


                                                </div>

                                            </td>


                                            <!-- Delete -->
                                            <td>

                                                <button
                                                    type="button"
                                                    class="contact-action-delete single-delete-btn"
                                                    data-delete-url="{{
                                                        route(
                                                            'admin.contact.destroy',
                                                            $contact->id
                                                        )
                                                    }}"
                                                    data-contact-name="{{
                                                        $contact->name
                                                    }}"
                                                    title="Delete Message"
                                                >

                                                    <i class="fa-solid fa-trash"></i>

                                                </button>

                                            </td>


                                        </tr>


                                    @endforeach


                                </tbody>


                            </table>


                        </div>


                        <!-- =====================================
                             PAGINATION
                        ====================================== -->
                        <div class="contact-pagination-wrap">


                            <p class="contact-pagination-info">

                                Showing

                                <strong>
                                    {{ $contacts->firstItem() }}
                                </strong>

                                to

                                <strong>
                                    {{ $contacts->lastItem() }}
                                </strong>

                                of

                                <strong>
                                    {{ $contacts->total() }}
                                </strong>

                                messages

                            </p>


                            <div>

                                {{ $contacts->links() }}

                            </div>


                        </div>


                    @else


                        <!-- =====================================
                             EMPTY
                        ====================================== -->
                        <div class="contact-empty-state">


                            <div class="contact-empty-icon">

                                <i class="fa-regular fa-envelope-open"></i>

                            </div>


                            <h5>
                                No Contact Messages Found
                            </h5>


                            <p>
                                There are currently no contact
                                messages matching your filters.
                            </p>


                        </div>


                    @endif


                </form>


            </div>


        </div>


    </div>


</div>


<!-- =========================================================
     SINGLE DELETE FORM
========================================================== -->
<form
    id="singleDeleteForm"
    method="POST"
    class="d-none"
>

    @csrf
    @method('DELETE')

</form>


@include('layouts.admin.script')


<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const selectAll =
                document.getElementById('selectAll');

            const checkboxes =
                document.querySelectorAll(
                    '.contact-row-checkbox'
                );

            const deleteSelectedBtn =
                document.getElementById(
                    'deleteSelectedBtn'
                );

            const selectedCount =
                document.getElementById(
                    'selectedCount'
                );

            const bulkDeleteForm =
                document.getElementById(
                    'bulkDeleteForm'
                );


            /*
            |--------------------------------------------------------------------------
            | Update Selected State
            |--------------------------------------------------------------------------
            */

            function updateSelectedState() {

                const checked =
                    document.querySelectorAll(
                        '.contact-row-checkbox:checked'
                    );


                /*
                |--------------------------------------------------------------------------
                | Count
                |--------------------------------------------------------------------------
                */

                if (selectedCount) {

                    selectedCount.textContent =
                        checked.length;

                }


                /*
                |--------------------------------------------------------------------------
                | Delete Selected Button
                |--------------------------------------------------------------------------
                */

                if (deleteSelectedBtn) {

                    if (checked.length > 0) {

                        deleteSelectedBtn
                            .classList
                            .add('show');

                    } else {

                        deleteSelectedBtn
                            .classList
                            .remove('show');

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Row Highlight
                |--------------------------------------------------------------------------
                */

                checkboxes.forEach(
                    function (checkbox) {

                        const row =
                            checkbox.closest('tr');


                        if (!row) {
                            return;
                        }


                        if (checkbox.checked) {

                            row.classList.add(
                                'contact-row-selected'
                            );

                        } else {

                            row.classList.remove(
                                'contact-row-selected'
                            );

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Select All Checkbox
                |--------------------------------------------------------------------------
                */

                if (
                    selectAll
                    &&
                    checkboxes.length > 0
                ) {

                    selectAll.checked =
                        checked.length
                        ===
                        checkboxes.length;


                    selectAll.indeterminate =
                        checked.length > 0
                        &&
                        checked.length
                        <
                        checkboxes.length;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Select All
            |--------------------------------------------------------------------------
            */

            if (selectAll) {

                selectAll.addEventListener(
                    'change',
                    function () {

                        checkboxes.forEach(
                            function (checkbox) {

                                checkbox.checked =
                                    selectAll.checked;

                            }
                        );


                        updateSelectedState();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Individual Checkbox
            |--------------------------------------------------------------------------
            */

            checkboxes.forEach(
                function (checkbox) {

                    checkbox.addEventListener(
                        'change',
                        updateSelectedState
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Delete Selected
            |--------------------------------------------------------------------------
            */

            if (
                deleteSelectedBtn
                &&
                bulkDeleteForm
            ) {

                deleteSelectedBtn.addEventListener(
                    'click',
                    function () {

                        const checked =
                            document.querySelectorAll(
                                '.contact-row-checkbox:checked'
                            );


                        if (
                            checked.length === 0
                        ) {

                            alert(
                                'Please select at least one contact message.'
                            );

                            return;

                        }


                        const confirmed =
                            confirm(
                                'Are you sure you want to delete '
                                +
                                checked.length
                                +
                                ' selected contact message(s)?'
                            );


                        if (confirmed) {

                            bulkDeleteForm.submit();

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Single Delete
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.single-delete-btn'
                )
                .forEach(
                    function (button) {

                        button.addEventListener(
                            'click',
                            function () {

                                const deleteUrl =
                                    this.dataset.deleteUrl;

                                const contactName =
                                    this.dataset.contactName;


                                const confirmed =
                                    confirm(
                                        'Are you sure you want to delete the message from "'
                                        +
                                        contactName
                                        +
                                        '"?'
                                    );


                                if (!confirmed) {
                                    return;
                                }


                                const deleteForm =
                                    document.getElementById(
                                        'singleDeleteForm'
                                    );


                                deleteForm.action =
                                    deleteUrl;


                                deleteForm.submit();

                            }
                        );

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Initialize
            |--------------------------------------------------------------------------
            */

            updateSelectedState();

        }
    );

</script>


</body>
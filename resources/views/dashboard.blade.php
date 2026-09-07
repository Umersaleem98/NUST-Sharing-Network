@include('layouts.admin.head')

<title>NUST Sharing Network · Dashboard</title>


<style>

    :root {
        --dash-primary: #005f8f;
        --dash-primary-dark: #00466d;
        --dash-success: #198754;
        --dash-info: #168aad;
        --dash-warning: #e59b18;
        --dash-danger: #dc4c64;

        --dash-dark: #182230;
        --dash-muted: #667085;
        --dash-light-muted: #98a2b3;

        --dash-border: #e6eaf0;
        --dash-surface: #ffffff;
        --dash-page: #f6f8fb;

        --dash-radius: 16px;
    }


    body {
        background: var(--dash-page);
    }


    /*
    |--------------------------------------------------------------------------
    | Main
    |--------------------------------------------------------------------------
    */

    .dashboard-wrapper {
        width: 100%;

        max-width: 1800px;

        margin-inline: auto;
    }


    /*
    |--------------------------------------------------------------------------
    | Welcome Header
    |--------------------------------------------------------------------------
    */

    .dashboard-welcome {
        position: relative;

        overflow: hidden;

        padding: 25px 28px;

        margin-bottom: 22px;

        border-radius: 18px;

        background:
            linear-gradient(
                135deg,
                #004d75,
                #0078a8
            );

        color: #ffffff;

        box-shadow:
            0 10px 28px
            rgba(0, 86, 128, .14);
    }


    .dashboard-welcome::before {
        position: absolute;

        content: "";

        width: 190px;
        height: 190px;

        right: -45px;
        top: -80px;

        border-radius: 50%;

        background:
            rgba(
                255,
                255,
                255,
                .07
            );
    }


    .dashboard-welcome::after {
        position: absolute;

        content: "";

        width: 120px;
        height: 120px;

        right: 100px;
        bottom: -80px;

        border-radius: 50%;

        background:
            rgba(
                255,
                255,
                255,
                .05
            );
    }


    .dashboard-welcome-content {
        position: relative;

        z-index: 2;
    }


    .dashboard-heading {
        margin: 0 0 6px;

        color: #ffffff;

        font-size:
            clamp(
                1.4rem,
                2vw,
                1.95rem
            );

        font-weight: 700;
    }


    .dashboard-subtitle {
        max-width: 700px;

        margin: 0;

        color:
            rgba(
                255,
                255,
                255,
                .8
            );

        font-size: .86rem;
    }


    .dashboard-role-badge {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        padding: 7px 12px;

        border:
            1px solid
            rgba(
                255,
                255,
                255,
                .16
            );

        border-radius: 100px;

        background:
            rgba(
                255,
                255,
                255,
                .1
            );

        color: #ffffff;

        font-size: .76rem;

        font-weight: 600;
    }


    /*
    |--------------------------------------------------------------------------
    | General Cards
    |--------------------------------------------------------------------------
    */

    .dashboard-card {
        height: 100%;

        overflow: hidden;

        background:
            var(--dash-surface);

        border:
            1px solid
            var(--dash-border);

        border-radius:
            var(--dash-radius);

        box-shadow:
            0 4px 18px
            rgba(
                15,
                23,
                42,
                .045
            );
    }


    .dashboard-card-hover {
        transition:
            transform .2s ease,
            box-shadow .2s ease;
    }


    .dashboard-card-hover:hover {
        transform:
            translateY(-3px);

        box-shadow:
            0 12px 26px
            rgba(
                15,
                23,
                42,
                .08
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Stat Cards
    |--------------------------------------------------------------------------
    */

    .dashboard-stat {
        position: relative;

        min-height: 145px;

        padding: 20px;
    }


    .dashboard-stat::after {
        position: absolute;

        right: -25px;
        bottom: -35px;

        width: 100px;
        height: 100px;

        content: "";

        border-radius: 50%;

        background:
            rgba(
                255,
                255,
                255,
                .09
            );
    }


    .dashboard-stat-primary {
        color: white;

        background:
            linear-gradient(
                135deg,
                #005c86,
                #0787b5
            );
    }


    .dashboard-stat-success {
        color: white;

        background:
            linear-gradient(
                135deg,
                #147353,
                #23a476
            );
    }


    .dashboard-stat-info {
        color: white;

        background:
            linear-gradient(
                135deg,
                #2766a0,
                #419bd0
            );
    }


    .dashboard-stat-warning {
        color: white;

        background:
            linear-gradient(
                135deg,
                #cc7c00,
                #edaa22
            );
    }


    .dashboard-stat-danger {
        color: white;

        background:
            linear-gradient(
                135deg,
                #b83a4d,
                #dd5b6e
            );
    }


    .dashboard-stat-dark {
        color: white;

        background:
            linear-gradient(
                135deg,
                #293241,
                #495667
            );
    }


    .dashboard-stat-icon {
        position: relative;

        z-index: 2;

        display: inline-flex;

        width: 40px;
        height: 40px;

        align-items: center;
        justify-content: center;

        margin-bottom: 16px;

        border-radius: 11px;

        background:
            rgba(
                255,
                255,
                255,
                .17
            );

        font-size: 1.05rem;
    }


    .dashboard-stat-label {
        position: relative;

        z-index: 2;

        margin-bottom: 5px;

        color:
            rgba(
                255,
                255,
                255,
                .78
            );

        font-size: .72rem;

        font-weight: 700;

        letter-spacing: .04em;

        text-transform: uppercase;
    }


    .dashboard-stat-value {
        position: relative;

        z-index: 2;

        margin: 0;

        color: #ffffff;

        font-size: 1.85rem;

        font-weight: 700;

        line-height: 1.1;
    }


    .dashboard-stat-description {
        position: relative;

        z-index: 2;

        display: block;

        margin-top: 9px;

        color:
            rgba(
                255,
                255,
                255,
                .78
            );

        font-size: .72rem;
    }


    /*
    |--------------------------------------------------------------------------
    | Section Header
    |--------------------------------------------------------------------------
    */

    .dashboard-section-header {
        display: flex;

        align-items: flex-start;
        justify-content: space-between;

        gap: 15px;

        padding: 19px 20px;

        border-bottom:
            1px solid
            var(--dash-border);
    }


    .dashboard-section-title {
        margin: 0;

        color:
            var(--dash-dark);

        font-size: .98rem;

        font-weight: 700;
    }


    .dashboard-section-description {
        margin: 4px 0 0;

        color:
            var(--dash-light-muted);

        font-size: .74rem;
    }


    /*
    |--------------------------------------------------------------------------
    | Profile Completion
    |--------------------------------------------------------------------------
    */

    .dashboard-profile-card {
        padding: 21px 23px;

        margin-bottom: 22px;

        border:
            1px solid
            #dfe9ef;

        border-radius: 17px;

        background:
            linear-gradient(
                135deg,
                #ffffff,
                #f8fbfd
            );

        box-shadow:
            0 4px 18px
            rgba(
                15,
                23,
                42,
                .035
            );
    }


    .profile-completion-value {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-width: 57px;
        height: 33px;

        border-radius: 100px;

        background:
            #edf4f7;

        color:
            var(--dash-primary);

        font-size: .82rem;

        font-weight: 700;
    }


    .dashboard-progress {
        height: 8px;

        overflow: hidden;

        border-radius: 20px;

        background: #e8edf1;
    }


    .dashboard-progress .progress-bar {
        border-radius: 20px;

        background:
            linear-gradient(
                90deg,
                #00608c,
                #23a476
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Account Status
    |--------------------------------------------------------------------------
    */

    .account-status-card {
        display: flex;

        align-items: center;

        gap: 12px;

        padding: 14px 16px;

        border:
            1px solid
            var(--dash-border);

        border-radius: 13px;

        background: white;
    }


    .account-status-icon {
        display: inline-flex;

        width: 39px;
        height: 39px;

        align-items: center;
        justify-content: center;

        border-radius: 10px;
    }


    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    */

    .dashboard-table {
        margin: 0;

        vertical-align: middle;
    }


    .dashboard-table thead th {
        padding: 10px 13px;

        border-bottom:
            1px solid
            var(--dash-border);

        background: #f8fafc;

        color:
            var(--dash-muted);

        font-size: .68rem;

        font-weight: 700;

        letter-spacing: .035em;

        white-space: nowrap;

        text-transform: uppercase;
    }


    .dashboard-table tbody td {
        padding: 11px 13px;

        border-color: #eff2f5;

        color: #344054;

        font-size: .78rem;
    }


    .dashboard-table tbody tr:last-child td {
        border-bottom: 0;
    }


    /*
    |--------------------------------------------------------------------------
    | User Avatar
    |--------------------------------------------------------------------------
    */

    .dashboard-user-avatar {
        display: inline-flex;

        width: 34px;
        height: 34px;

        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background:
            rgba(
                0,
                96,
                140,
                .1
            );

        color:
            var(--dash-primary);

        font-size: .75rem;

        font-weight: 700;

        object-fit: cover;

        flex: 0 0 34px;
    }


    /*
    |--------------------------------------------------------------------------
    | Status Badge
    |--------------------------------------------------------------------------
    */

    .status-badge {
        display: inline-flex;

        align-items: center;

        gap: 4px;

        padding: 4px 8px;

        border-radius: 100px;

        font-size: .65rem;

        font-weight: 700;

        text-transform: capitalize;
    }


    .status-pending {
        color: #9a6700;

        background: #fff3cd;
    }


    .status-approved,
    .status-accepted {
        color: #157347;

        background: #d1e7dd;
    }


    .status-rejected {
        color: #b02a37;

        background: #f8d7da;
    }


    .status-active {
        color: #157347;

        background: #d1e7dd;
    }


    .status-suspended {
        color: #9a6700;

        background: #fff3cd;
    }


    .status-blocked {
        color: #b02a37;

        background: #f8d7da;
    }


    .status-default {
        color: #495057;

        background: #e9ecef;
    }


    .dashboard-role {
        display: inline-flex;

        padding: 4px 8px;

        border-radius: 100px;

        color:
            var(--dash-primary);

        background:
            rgba(
                0,
                96,
                140,
                .09
            );

        font-size: .65rem;

        font-weight: 700;

        text-transform: capitalize;
    }


    /*
    |--------------------------------------------------------------------------
    | Chart
    |--------------------------------------------------------------------------
    */

    .dashboard-chart-body {
        padding: 18px 20px 20px;
    }


    .chart-container {
        position: relative;

        width: 100%;

        height: 280px;
    }


    /*
    |--------------------------------------------------------------------------
    | Information Grid
    |--------------------------------------------------------------------------
    */

    .dashboard-info-grid {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 10px;

        padding: 18px 20px 20px;
    }


    .dashboard-info-item {
        padding: 12px 13px;

        border:
            1px solid
            var(--dash-border);

        border-radius: 11px;

        background: #fafbfd;
    }


    .dashboard-info-item span {
        display: block;

        margin-bottom: 4px;

        color:
            var(--dash-light-muted);

        font-size: .67rem;

        text-transform: uppercase;
    }


    .dashboard-info-item strong {
        color:
            var(--dash-dark);

        font-size: .78rem;
    }


    /*
    |--------------------------------------------------------------------------
    | Empty
    |--------------------------------------------------------------------------
    */

    .dashboard-empty {
        padding: 35px 15px !important;

        color:
            var(--dash-light-muted)
            !important;

        text-align: center;
    }


    /*
    |--------------------------------------------------------------------------
    | Responsive
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767.98px) {

        .nsn-content {
            padding: 16px 12px;
        }


        .dashboard-welcome {
            padding: 21px 19px;
        }


        .dashboard-stat {
            min-height: 135px;

            padding: 18px;
        }


        .dashboard-info-grid {
            grid-template-columns: 1fr;
        }


        .chart-container {
            height: 245px;
        }

    }

</style>


<body>


    @include('layouts.admin.sidebar')


    <div class="nsn-main">


        @include('layouts.admin.header')


        <main class="nsn-content">


            <div class="dashboard-wrapper">


                {{-- =========================================================
                    WELCOME HEADER
                ========================================================== --}}
                <section class="dashboard-welcome">


                    <div class="dashboard-welcome-content">


                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">


                            <div>


                                <h1 class="dashboard-heading">

                                    Welcome back, {{ $user->name }}

                                </h1>


                                <p class="dashboard-subtitle">

                                    @if ($user->role === 'admin')

                                        Monitor users, products, requests and overall Sharing Network activity.

                                    @elseif ($user->role === 'donor')

                                        Manage your shared products and review approved beneficiary requests.

                                    @else

                                        Track your product requests and monitor their approval progress.

                                    @endif

                                </p>


                            </div>



                            <div class="d-flex flex-wrap gap-2">


                                <span class="dashboard-role-badge">

                                    @if ($user->role === 'admin')

                                        <i class="bi bi-shield-check"></i>

                                    @elseif ($user->role === 'donor')

                                        <i class="bi bi-heart"></i>

                                    @else

                                        <i class="bi bi-mortarboard"></i>

                                    @endif


                                    {{ ucfirst($user->role) }}

                                </span>


                                <span class="dashboard-role-badge">

                                    <i class="bi bi-calendar3"></i>

                                    {{ now()->format('d M Y') }}

                                </span>


                            </div>


                        </div>


                    </div>


                </section>



                {{-- =========================================================
                    ACCOUNT STATUS
                ========================================================== --}}
                @php

                    $accountStatus =
                        strtolower(
                            $user->account_status
                            ?? 'active'
                        );

                @endphp


                @if ($accountStatus !== 'active')


                    <div class="alert {{ $accountStatus === 'blocked' ? 'alert-danger' : 'alert-warning' }} border mb-4">


                        <div class="d-flex gap-3">


                            <i class="bi {{ $accountStatus === 'blocked' ? 'bi-slash-circle' : 'bi-pause-circle' }} fs-4"></i>


                            <div>


                                <strong class="d-block mb-1">

                                    Account {{ ucfirst($accountStatus) }}

                                </strong>


                                <span class="small">

                                    {{
                                        $user->status_reason
                                        ??
                                        'Please contact the administrator for further information.'
                                    }}

                                </span>


                            </div>


                        </div>


                    </div>


                @endif



                {{-- =========================================================
                    ADMIN DASHBOARD
                ========================================================== --}}
                @if ($user->role === 'admin')


                    {{-- =====================================================
                        MAIN STATISTICS
                    ====================================================== --}}
                    <div class="row g-3 mb-4">


                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-primary">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-people"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Registered Users

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ number_format($totalUsers) }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    +{{ $newUsersThisMonth }} registered this month

                                </span>


                            </div>


                        </div>



                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-success">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-box-seam"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Products

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ number_format($totalProducts) }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    {{ $totalCategories }} categories ·
                                    +{{ $newProductsThisMonth }} this month

                                </span>


                            </div>


                        </div>



                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-info">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-clipboard-data"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Product Requests

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ number_format($totalRequests) }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    {{ $pendingAdmin }} awaiting admin review

                                </span>


                            </div>


                        </div>



                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-warning">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-check2-circle"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Completed Requests

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ number_format($completedRequests) }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    {{ $requestSuccessRate }}% overall completion rate

                                </span>


                            </div>


                        </div>


                    </div>



                    {{-- =====================================================
                        USER / ACCOUNT SUMMARY
                    ====================================================== --}}
                    <div class="row g-3 mb-4">


                        <div class="col-12 col-xl-7">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            User Overview

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Distribution of registered platform accounts.

                                        </p>

                                    </div>


                                    <i class="bi bi-people text-primary"></i>


                                </div>


                                <div class="dashboard-info-grid">


                                    <div class="dashboard-info-item">

                                        <span>
                                            Administrators
                                        </span>

                                        <strong>
                                            {{ number_format($totalAdmins) }}
                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Donors
                                        </span>

                                        <strong>
                                            {{ number_format($totalDonors) }}
                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Beneficiaries
                                        </span>

                                        <strong>
                                            {{ number_format($totalBeneficiaries) }}
                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            New This Month
                                        </span>

                                        <strong>
                                            {{ number_format($newUsersThisMonth) }}
                                        </strong>

                                    </div>


                                </div>


                                <div class="dashboard-chart-body pt-0">


                                    <div class="chart-container">

                                        <canvas id="userChart"></canvas>

                                    </div>


                                </div>


                            </div>


                        </div>



                        <div class="col-12 col-xl-5">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Account Health

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Active, suspended and blocked accounts.

                                        </p>

                                    </div>


                                    <i class="bi bi-shield-check text-success"></i>


                                </div>


                                <div class="dashboard-info-grid">


                                    <div class="account-status-card">


                                        <span class="account-status-icon bg-success-subtle text-success">

                                            <i class="bi bi-check-circle"></i>

                                        </span>


                                        <div>

                                            <small class="text-secondary d-block">

                                                Active

                                            </small>


                                            <strong>

                                                {{ $activeUsers }}

                                            </strong>

                                        </div>


                                    </div>


                                    <div class="account-status-card">


                                        <span class="account-status-icon bg-warning-subtle text-warning">

                                            <i class="bi bi-pause-circle"></i>

                                        </span>


                                        <div>

                                            <small class="text-secondary d-block">

                                                Suspended

                                            </small>


                                            <strong>

                                                {{ $suspendedUsers }}

                                            </strong>

                                        </div>


                                    </div>


                                    <div class="account-status-card">


                                        <span class="account-status-icon bg-danger-subtle text-danger">

                                            <i class="bi bi-slash-circle"></i>

                                        </span>


                                        <div>

                                            <small class="text-secondary d-block">

                                                Blocked

                                            </small>


                                            <strong>

                                                {{ $blockedUsers }}

                                            </strong>

                                        </div>


                                    </div>


                                </div>


                                <div class="dashboard-chart-body pt-0">


                                    <div class="chart-container">

                                        <canvas id="accountStatusChart"></canvas>

                                    </div>


                                </div>


                            </div>


                        </div>


                    </div>



                    {{-- =====================================================
                        REQUEST STATUS
                    ====================================================== --}}
                    <div class="row g-3 mb-4">


                        <div class="col-12 col-xl-7">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Request Activity

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Monthly request submissions during {{ now()->year }}.

                                        </p>

                                    </div>


                                    <span class="badge bg-primary-subtle text-primary">

                                        +{{ $newRequestsThisMonth }} this month

                                    </span>


                                </div>


                                <div class="dashboard-chart-body">


                                    <div class="chart-container">

                                        <canvas id="monthlyChart"></canvas>

                                    </div>


                                </div>


                            </div>


                        </div>



                        <div class="col-12 col-xl-5">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Admin Decisions

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Administrative request review status.

                                        </p>

                                    </div>


                                </div>


                                <div class="dashboard-info-grid">


                                    <div class="dashboard-info-item">

                                        <span>
                                            Pending
                                        </span>

                                        <strong class="text-warning">

                                            {{ $pendingAdmin }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Approved
                                        </span>

                                        <strong class="text-success">

                                            {{ $approvedByAdmin }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Rejected
                                        </span>

                                        <strong class="text-danger">

                                            {{ $rejectedByAdmin }}

                                        </strong>

                                    </div>


                                </div>


                                <div class="dashboard-chart-body pt-0">


                                    <div class="chart-container">

                                        <canvas id="requestChart"></canvas>

                                    </div>


                                </div>


                            </div>


                        </div>


                    </div>



                    {{-- =====================================================
                        DONOR DECISIONS + USER REGISTRATION
                    ====================================================== --}}
                    <div class="row g-3 mb-4">


                        <div class="col-12 col-xl-5">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Donor Decisions

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Outcomes after administrative approval.

                                        </p>

                                    </div>


                                </div>


                                <div class="dashboard-chart-body">


                                    <div class="chart-container">

                                        <canvas id="donorChart"></canvas>

                                    </div>


                                </div>


                            </div>


                        </div>



                        <div class="col-12 col-xl-7">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            User Registrations

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Monthly registrations during {{ now()->year }}.

                                        </p>

                                    </div>


                                </div>


                                <div class="dashboard-chart-body">


                                    <div class="chart-container">

                                        <canvas id="registrationChart"></canvas>

                                    </div>


                                </div>


                            </div>


                        </div>


                    </div>



                    {{-- =====================================================
                        RECENT USERS
                    ====================================================== --}}
                    <div class="dashboard-card mb-4">


                        <div class="dashboard-section-header">


                            <div>

                                <h2 class="dashboard-section-title">

                                    Recent Users

                                </h2>


                                <p class="dashboard-section-description">

                                    Latest accounts registered on the platform.

                                </p>

                            </div>


                            @if (Route::has('admin.user.index'))

                                <a
                                    href="{{ route('admin.user.index') }}"
                                    class="btn btn-sm btn-outline-primary"
                                >

                                    View Users

                                </a>

                            @endif


                        </div>


                        <div class="table-responsive">


                            <table class="table table-sm dashboard-table">


                                <thead>

                                    <tr>

                                        <th>
                                            User
                                        </th>

                                        <th>
                                            Contact
                                        </th>

                                        <th>
                                            Role
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Joined
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>


                                    @forelse ($recentUsers as $item)


                                        @php

                                            $itemStatus =
                                                strtolower(
                                                    $item->account_status
                                                    ?? 'active'
                                                );

                                        @endphp


                                        <tr>


                                            <td>


                                                <div class="d-flex align-items-center gap-2">


                                                    @if ($item->image)

                                                        <img
                                                            src="{{ asset('admins/asset/profilephoto/' . $item->image) }}"
                                                            class="dashboard-user-avatar"
                                                            alt="{{ $item->name }}"
                                                        >

                                                    @else

                                                        <span class="dashboard-user-avatar">

                                                            {{ strtoupper(substr($item->name, 0, 1)) }}

                                                        </span>

                                                    @endif


                                                    <div>


                                                        <strong class="d-block">

                                                            {{ $item->name }}

                                                        </strong>


                                                        <small class="text-secondary">

                                                            #{{ $item->id }}

                                                        </small>


                                                    </div>


                                                </div>


                                            </td>


                                            <td>


                                                <div>
                                                    {{ $item->email }}
                                                </div>


                                                <small class="text-secondary">

                                                    {{ $item->phone ?? 'No phone' }}

                                                </small>


                                            </td>


                                            <td>

                                                <span class="dashboard-role">

                                                    {{ $item->role }}

                                                </span>

                                            </td>


                                            <td>

                                                <span class="status-badge status-{{ $itemStatus }}">

                                                    {{ ucfirst($itemStatus) }}

                                                </span>

                                            </td>


                                            <td>

                                                {{ optional($item->created_at)->format('d M Y') }}

                                            </td>


                                        </tr>


                                    @empty


                                        <tr>

                                            <td
                                                colspan="5"
                                                class="dashboard-empty"
                                            >

                                                No users available.

                                            </td>

                                        </tr>


                                    @endforelse


                                </tbody>


                            </table>


                        </div>


                    </div>



                    {{-- =====================================================
                        PRODUCTS + REQUESTS
                    ====================================================== --}}
                    <div class="row g-3">


                        <div class="col-12 col-xl-5">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Recent Products

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Latest products shared by donors.

                                        </p>

                                    </div>


                                </div>


                                <div class="table-responsive">


                                    <table class="table table-sm dashboard-table">


                                        <thead>

                                            <tr>

                                                <th>
                                                    Product
                                                </th>

                                                <th>
                                                    Donor
                                                </th>

                                                <th>
                                                    Date
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>


                                            @forelse ($recentProducts as $product)


                                                <tr>


                                                    <td>

                                                        <strong>
                                                            {{ $product->name }}
                                                        </strong>


                                                        <small class="d-block text-secondary">

                                                            {{ $product->category?->name ?? 'No category' }}

                                                        </small>

                                                    </td>


                                                    <td>

                                                        {{ $product->user?->name ?? 'Not available' }}

                                                    </td>


                                                    <td>

                                                        {{ optional($product->created_at)->format('d M Y') }}

                                                    </td>


                                                </tr>


                                            @empty


                                                <tr>

                                                    <td
                                                        colspan="3"
                                                        class="dashboard-empty"
                                                    >

                                                        No products available.

                                                    </td>

                                                </tr>


                                            @endforelse


                                        </tbody>


                                    </table>


                                </div>


                            </div>


                        </div>



                        <div class="col-12 col-xl-7">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Recent Requests

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Latest beneficiary request activity.

                                        </p>

                                    </div>


                                </div>


                                <div class="table-responsive">


                                    <table class="table table-sm dashboard-table">


                                        <thead>

                                            <tr>

                                                <th>
                                                    Product
                                                </th>

                                                <th>
                                                    Beneficiary
                                                </th>

                                                <th>
                                                    Donor
                                                </th>

                                                <th>
                                                    Admin
                                                </th>

                                                <th>
                                                    Donor
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>


                                            @forelse ($recentRequests as $requestItem)


                                                @php

                                                    $adminStatus =
                                                        strtolower(
                                                            $requestItem->admin_status
                                                            ?? 'pending'
                                                        );

                                                    $donorStatus =
                                                        strtolower(
                                                            $requestItem->donor_status
                                                            ?? 'pending'
                                                        );

                                                    $donorStatusLabel =
                                                        in_array(
                                                            $donorStatus,
                                                            [
                                                                'accepted',
                                                                'approved',
                                                            ]
                                                        )
                                                        ? 'Accepted'
                                                        : ucfirst($donorStatus);

                                                @endphp


                                                <tr>


                                                    <td>

                                                        <strong>

                                                            {{ $requestItem->product?->name ?? 'Unavailable' }}

                                                        </strong>

                                                    </td>


                                                    <td>

                                                        {{ $requestItem->beneficiary?->name ?? 'Unavailable' }}

                                                    </td>


                                                    <td>

                                                        {{ $requestItem->donor?->name ?? 'Unavailable' }}

                                                    </td>


                                                    <td>

                                                        <span class="status-badge status-{{ $adminStatus }}">

                                                            {{ ucfirst($adminStatus) }}

                                                        </span>

                                                    </td>


                                                    <td>

                                                        <span class="status-badge status-{{ $donorStatus }}">

                                                            {{ $donorStatusLabel }}

                                                        </span>

                                                    </td>


                                                </tr>


                                            @empty


                                                <tr>

                                                    <td
                                                        colspan="5"
                                                        class="dashboard-empty"
                                                    >

                                                        No requests available.

                                                    </td>

                                                </tr>


                                            @endforelse


                                        </tbody>


                                    </table>


                                </div>


                            </div>


                        </div>


                    </div>


                @endif



                {{-- =========================================================
                    DONOR DASHBOARD
                ========================================================== --}}
                @if ($user->role === 'donor')


                    {{-- Profile --}}
                    <div class="dashboard-profile-card">


                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">


                            <div>


                                <h2 class="dashboard-section-title">

                                    Profile Completion

                                </h2>


                                <p class="dashboard-section-description">

                                    Keep your donor information complete and up to date.

                                </p>


                            </div>


                            <span class="profile-completion-value">

                                {{ $profileCompletion }}%

                            </span>


                        </div>


                        <div class="progress dashboard-progress">


                            <div
                                class="progress-bar"
                                style="width: {{ $profileCompletion }}%;"
                            ></div>


                        </div>


                        <div class="d-flex flex-wrap justify-content-between gap-2 mt-3">


                            <small class="{{ $profileCompletion >= 85 ? 'text-success' : 'text-warning' }}">


                                @if ($profileCompletion >= 85)

                                    <i class="bi bi-check-circle me-1"></i>

                                    Your donor profile is sufficiently complete.

                                @else

                                    <i class="bi bi-exclamation-circle me-1"></i>

                                    Complete at least 85% of your profile.

                                @endif


                            </small>


                            @if (Route::has('donor.profile.index'))

                                <a
                                    href="{{ route('donor.profile.index') }}"
                                    class="small text-decoration-none fw-semibold"
                                >

                                    Update Profile

                                    <i class="bi bi-arrow-right ms-1"></i>

                                </a>

                            @endif


                        </div>


                    </div>



                    {{-- Stats --}}
                    <div class="row g-3 mb-4">


                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-primary">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-box-seam"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    My Products

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ $myProducts }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    Products shared through your account.

                                </span>


                            </div>


                        </div>



                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-info">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-inbox"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Incoming Requests

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ $incomingRequests }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    Admin-approved beneficiary requests.

                                </span>


                            </div>


                        </div>



                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-warning">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-hourglass-split"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Pending Decision

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ $pendingRequests }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    Requests waiting for your response.

                                </span>


                            </div>


                        </div>



                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-success">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-check-circle"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Accepted

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ $acceptedRequests }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    {{ $responseRate }}% request response rate.

                                </span>


                            </div>


                        </div>


                    </div>



                    {{-- Profile + Request Chart --}}
                    <div class="row g-3 mb-4">


                        <div class="col-12 col-xl-5">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Donor Profile

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Current organization information.

                                        </p>

                                    </div>


                                    <i class="bi bi-building text-primary"></i>


                                </div>


                                <div class="dashboard-info-grid">


                                    <div class="dashboard-info-item">

                                        <span>
                                            Organization
                                        </span>

                                        <strong>

                                            {{ $profile?->organization ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Designation
                                        </span>

                                        <strong>

                                            {{ $profile?->designation ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Country
                                        </span>

                                        <strong>

                                            {{ $profile?->country ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Account Status
                                        </span>

                                        <strong>

                                            <span class="status-badge status-{{ $accountStatus }}">

                                                {{ ucfirst($accountStatus) }}

                                            </span>

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item" style="grid-column:1/-1;">

                                        <span>
                                            Address
                                        </span>

                                        <strong>

                                            {{ $profile?->address ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                </div>


                            </div>


                        </div>



                        <div class="col-12 col-xl-7">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Request Decisions

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Pending, accepted and rejected beneficiary requests.

                                        </p>

                                    </div>


                                </div>


                                <div class="dashboard-chart-body">


                                    <div class="chart-container">

                                        <canvas id="donorRequestChart"></canvas>

                                    </div>


                                </div>


                            </div>


                        </div>


                    </div>



                    {{-- Products + Requests --}}
                    <div class="row g-3">


                        <div class="col-12 col-xl-5">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Recent Products

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Your latest shared items.

                                        </p>

                                    </div>


                                </div>


                                <div class="table-responsive">


                                    <table class="table table-sm dashboard-table">


                                        <thead>

                                            <tr>

                                                <th>
                                                    Product
                                                </th>

                                                <th>
                                                    Category
                                                </th>

                                                <th>
                                                    Date
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>


                                            @forelse ($recentProducts as $product)


                                                <tr>


                                                    <td class="fw-semibold">

                                                        {{ $product->name }}

                                                    </td>


                                                    <td>

                                                        {{ $product->category?->name ?? '—' }}

                                                    </td>


                                                    <td>

                                                        {{ optional($product->created_at)->format('d M Y') }}

                                                    </td>


                                                </tr>


                                            @empty


                                                <tr>

                                                    <td
                                                        colspan="3"
                                                        class="dashboard-empty"
                                                    >

                                                        You have not shared any products yet.

                                                    </td>

                                                </tr>


                                            @endforelse


                                        </tbody>


                                    </table>


                                </div>


                            </div>


                        </div>



                        <div class="col-12 col-xl-7">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Recent Incoming Requests

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Beneficiary requests approved by administration.

                                        </p>

                                    </div>


                                </div>


                                <div class="table-responsive">


                                    <table class="table table-sm dashboard-table">


                                        <thead>

                                            <tr>

                                                <th>
                                                    Beneficiary
                                                </th>

                                                <th>
                                                    Product
                                                </th>

                                                <th>
                                                    Institution
                                                </th>

                                                <th>
                                                    Status
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>


                                            @forelse ($recentIncomingRequests as $requestItem)


                                                @php

                                                    $donorStatus =
                                                        strtolower(
                                                            $requestItem->donor_status
                                                            ?? 'pending'
                                                        );

                                                    $donorLabel =
                                                        in_array(
                                                            $donorStatus,
                                                            [
                                                                'approved',
                                                                'accepted',
                                                            ]
                                                        )
                                                        ? 'Accepted'
                                                        : ucfirst($donorStatus);

                                                @endphp


                                                <tr>


                                                    <td>


                                                        <strong class="d-block">

                                                            {{ $requestItem->beneficiary?->name ?? 'Unavailable' }}

                                                        </strong>


                                                        <small class="text-secondary">

                                                            {{ $requestItem->beneficiary?->qalam_id ?? 'No Qalam ID' }}

                                                        </small>


                                                    </td>


                                                    <td>

                                                        {{ $requestItem->product?->name ?? 'Unavailable' }}

                                                    </td>


                                                    <td>

                                                        {{
                                                            $requestItem
                                                                ->beneficiary
                                                                ?->beneficiaryProfile
                                                                ?->institution
                                                            ?? 'Not available'
                                                        }}

                                                    </td>


                                                    <td>

                                                        <span class="status-badge status-{{ $donorStatus }}">

                                                            {{ $donorLabel }}

                                                        </span>

                                                    </td>


                                                </tr>


                                            @empty


                                                <tr>

                                                    <td
                                                        colspan="4"
                                                        class="dashboard-empty"
                                                    >

                                                        No beneficiary requests available.

                                                    </td>

                                                </tr>


                                            @endforelse


                                        </tbody>


                                    </table>


                                </div>


                            </div>


                        </div>


                    </div>



                    @if (! $user->termAcceptance)

                        @include('layouts.admin.term&condition')

                    @endif


                @endif



                {{-- =========================================================
                    BENEFICIARY DASHBOARD
                ========================================================== --}}
                @if ($user->role === 'beneficiary')


                    {{-- Profile Completion --}}
                    <div class="dashboard-profile-card">


                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">


                            <div>


                                <h2 class="dashboard-section-title">

                                    Student Profile Completion

                                </h2>


                                <p class="dashboard-section-description">

                                    Complete your academic, family and contact information.

                                </p>


                            </div>


                            <span class="profile-completion-value">

                                {{ $profileCompletion }}%

                            </span>


                        </div>


                        <div class="progress dashboard-progress">


                            <div
                                class="progress-bar"
                                style="width: {{ $profileCompletion }}%;"
                            ></div>


                        </div>


                        <small class="d-block mt-3 {{ $profileCompletion >= 85 ? 'text-success' : 'text-warning' }}">


                            @if ($profileCompletion >= 85)

                                <i class="bi bi-check-circle me-1"></i>

                                Your beneficiary profile is sufficiently complete.

                            @else

                                <i class="bi bi-exclamation-circle me-1"></i>

                                Complete at least 85% of your profile to access all beneficiary features.

                            @endif


                        </small>


                    </div>



                    {{-- Stats --}}
                    <div class="row g-3 mb-4">


                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-primary">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-clipboard-data"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    My Requests

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ $myRequests }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    Total product requests submitted.

                                </span>


                            </div>


                        </div>



                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-warning">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-hourglass-split"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Admin Pending

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ $pending }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    Waiting for administrative review.

                                </span>


                            </div>


                        </div>



                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-info">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-shield-check"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Admin Approved

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ $approved }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    Approved by administration.

                                </span>


                            </div>


                        </div>



                        <div class="col-12 col-sm-6 col-xl-3">


                            <div class="dashboard-card dashboard-card-hover dashboard-stat dashboard-stat-success">


                                <span class="dashboard-stat-icon">

                                    <i class="bi bi-check2-circle"></i>

                                </span>


                                <div class="dashboard-stat-label">

                                    Donor Accepted

                                </div>


                                <h2 class="dashboard-stat-value">

                                    {{ $accepted }}

                                </h2>


                                <span class="dashboard-stat-description">

                                    {{ $successRate }}% overall success rate.

                                </span>


                            </div>


                        </div>


                    </div>



                    {{-- Profile information --}}
                    <div class="row g-3 mb-4">


                        <div class="col-12 col-xl-5">


                            <div class="dashboard-card">


                                <div class="dashboard-section-header">


                                    <div>

                                        <h2 class="dashboard-section-title">

                                            Academic Profile

                                        </h2>


                                        <p class="dashboard-section-description">

                                            Your current academic information.

                                        </p>

                                    </div>


                                    <i class="bi bi-mortarboard text-primary"></i>


                                </div>


                                <div class="dashboard-info-grid">


                                    <div class="dashboard-info-item">

                                        <span>
                                            Qalam ID
                                        </span>

                                        <strong>

                                            {{ $user->qalam_id ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Gender
                                        </span>

                                        <strong class="text-capitalize">

                                            {{ $profile?->gender ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Institution
                                        </span>

                                        <strong>

                                            {{ $profile?->institution ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Degree Level
                                        </span>

                                        <strong>

                                            {{ $profile?->degree_level ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Degree Program
                                        </span>

                                        <strong>

                                            {{ $profile?->degree_program ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Department
                                        </span>

                                        <strong>

                                            {{ $profile?->department ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Semester
                                        </span>

                                        <strong>

                                            {{ $profile?->semester ?? 'Not provided' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            CGPA
                                        </span>

                                        <strong>

                                            @if (!is_null($profile?->cgpa))

                                                {{ number_format((float) $profile->cgpa, 2) }}
                                                / 4.00

                                            @else

                                                Not provided

                                            @endif

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Enrollment
                                        </span>

                                        <strong>

                                            {{ $profile?->enrollment_year ?? '—' }}

                                        </strong>

                                    </div>


                                    <div class="dashboard-info-item">

                                        <span>
                                            Graduation
                                        </span>

                                        <strong>

                                            {{ $profile?->graduation_year ?? '—' }}

                                        </strong>

                                    </div>


                                </div>


                            </div>


                        </div>



                        {{-- Charts --}}
                        <div class="col-12 col-xl-7">


                            <div class="row g-3">


                                <div class="col-12 col-lg-6">


                                    <div class="dashboard-card">


                                        <div class="dashboard-section-header">


                                            <div>

                                                <h2 class="dashboard-section-title">

                                                    Admin Review

                                                </h2>


                                                <p class="dashboard-section-description">

                                                    Administrative request status.

                                                </p>

                                            </div>


                                        </div>


                                        <div class="dashboard-chart-body">


                                            <div class="chart-container">

                                                <canvas id="beneficiaryAdminChart"></canvas>

                                            </div>


                                        </div>


                                    </div>


                                </div>



                                <div class="col-12 col-lg-6">


                                    <div class="dashboard-card">


                                        <div class="dashboard-section-header">


                                            <div>

                                                <h2 class="dashboard-section-title">

                                                    Donor Decisions

                                                </h2>


                                                <p class="dashboard-section-description">

                                                    Status after admin approval.

                                                </p>

                                            </div>


                                        </div>


                                        <div class="dashboard-chart-body">


                                            <div class="chart-container">

                                                <canvas id="beneficiaryDonorChart"></canvas>

                                            </div>


                                        </div>


                                    </div>


                                </div>


                            </div>


                        </div>


                    </div>



                    {{-- Recent Requests --}}
                    <div class="dashboard-card">


                        <div class="dashboard-section-header">


                            <div>

                                <h2 class="dashboard-section-title">

                                    My Recent Requests

                                </h2>


                                <p class="dashboard-section-description">

                                    Track your latest product requests and decisions.

                                </p>

                            </div>


                        </div>


                        <div class="table-responsive">


                            <table class="table table-sm dashboard-table">


                                <thead>

                                    <tr>

                                        <th>
                                            Product
                                        </th>

                                        <th>
                                            Donor
                                        </th>

                                        <th>
                                            Admin Status
                                        </th>

                                        <th>
                                            Donor Status
                                        </th>

                                        <th>
                                            Date
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>


                                    @forelse ($recentMyRequests as $requestItem)


                                        @php

                                            $adminStatus =
                                                strtolower(
                                                    $requestItem->admin_status
                                                    ?? 'pending'
                                                );

                                            $donorStatus =
                                                strtolower(
                                                    $requestItem->donor_status
                                                    ?? 'pending'
                                                );

                                            $donorStatusLabel =
                                                in_array(
                                                    $donorStatus,
                                                    [
                                                        'accepted',
                                                        'approved',
                                                    ]
                                                )
                                                ? 'Accepted'
                                                : ucfirst($donorStatus);

                                        @endphp


                                        <tr>


                                            <td>

                                                <strong>

                                                    {{ $requestItem->product?->name ?? 'Unavailable' }}

                                                </strong>

                                            </td>


                                            <td>


                                                <div>

                                                    {{ $requestItem->donor?->name ?? 'Not available' }}

                                                </div>


                                                <small class="text-secondary">

                                                    {{
                                                        $requestItem
                                                            ->donor
                                                            ?->donorProfile
                                                            ?->organization
                                                        ?? ''
                                                    }}

                                                </small>


                                            </td>


                                            <td>

                                                <span class="status-badge status-{{ $adminStatus }}">

                                                    {{ ucfirst($adminStatus) }}

                                                </span>

                                            </td>


                                            <td>

                                                <span class="status-badge status-{{ $donorStatus }}">

                                                    {{ $donorStatusLabel }}

                                                </span>

                                            </td>


                                            <td>

                                                {{ optional($requestItem->created_at)->format('d M Y') }}

                                            </td>


                                        </tr>


                                    @empty


                                        <tr>

                                            <td
                                                colspan="5"
                                                class="dashboard-empty"
                                            >

                                                You have not submitted any product requests yet.

                                            </td>

                                        </tr>


                                    @endforelse


                                </tbody>


                            </table>


                        </div>


                    </div>


                @endif


            </div>


        </main>


    </div>



    @include('layouts.admin.script')



    {{-- =============================================================
        CHART.JS
    ============================================================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {


                if (
                    typeof Chart ===
                    'undefined'
                ) {
                    return;
                }


                Chart.defaults.font.family =
                    "'Inter', 'Segoe UI', Arial, sans-serif";


                Chart.defaults.color =
                    '#667085';



                const legendBottom = {

                    position: 'bottom',

                    labels: {

                        usePointStyle: true,

                        pointStyle: 'circle',

                        padding: 17,

                        boxWidth: 7,

                        boxHeight: 7
                    }
                };



                /*
                |--------------------------------------------------------------------------
                | ADMIN CHARTS
                |--------------------------------------------------------------------------
                */

                @if ($user->role === 'admin')


                    /*
                    | User Distribution
                    */

                    const userChart =
                        document.getElementById(
                            'userChart'
                        );


                    if (userChart) {

                        new Chart(
                            userChart,
                            {

                                type: 'doughnut',

                                data: {

                                    labels: [
                                        'Admins',
                                        'Donors',
                                        'Beneficiaries'
                                    ],

                                    datasets: [{

                                        data:
                                            @json($usersChart),

                                        backgroundColor: [
                                            '#344054',
                                            '#00608c',
                                            '#23a476'
                                        ],

                                        borderColor:
                                            '#ffffff',

                                        borderWidth: 4,

                                        hoverOffset: 5
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    maintainAspectRatio: false,

                                    cutout: '68%',

                                    plugins: {

                                        legend:
                                            legendBottom
                                    }
                                }
                            }
                        );
                    }



                    /*
                    | Account Status
                    */

                    const accountChart =
                        document.getElementById(
                            'accountStatusChart'
                        );


                    if (accountChart) {

                        new Chart(
                            accountChart,
                            {

                                type: 'doughnut',

                                data: {

                                    labels: [
                                        'Active',
                                        'Suspended',
                                        'Blocked'
                                    ],

                                    datasets: [{

                                        data:
                                            @json($accountStatusChart),

                                        backgroundColor: [
                                            '#23a476',
                                            '#e7a31c',
                                            '#dc4c64'
                                        ],

                                        borderColor:
                                            '#ffffff',

                                        borderWidth: 4
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    maintainAspectRatio: false,

                                    cutout: '67%',

                                    plugins: {

                                        legend:
                                            legendBottom
                                    }
                                }
                            }
                        );
                    }



                    /*
                    | Admin Request Status
                    */

                    const requestChart =
                        document.getElementById(
                            'requestChart'
                        );


                    if (requestChart) {

                        new Chart(
                            requestChart,
                            {

                                type: 'bar',

                                data: {

                                    labels: [
                                        'Pending',
                                        'Approved',
                                        'Rejected'
                                    ],

                                    datasets: [{

                                        data:
                                            @json($requestChart),

                                        backgroundColor: [
                                            '#e7a31c',
                                            '#23a476',
                                            '#dc4c64'
                                        ],

                                        borderRadius: 7,

                                        maxBarThickness: 48
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    maintainAspectRatio: false,

                                    plugins: {

                                        legend: {
                                            display: false
                                        }
                                    },

                                    scales: {

                                        x: {

                                            grid: {
                                                display: false
                                            },

                                            border: {
                                                display: false
                                            }
                                        },

                                        y: {

                                            beginAtZero: true,

                                            ticks: {
                                                precision: 0
                                            },

                                            grid: {
                                                color: '#eef1f5'
                                            },

                                            border: {
                                                display: false
                                            }
                                        }
                                    }
                                }
                            }
                        );
                    }



                    /*
                    | Monthly Requests
                    */

                    const monthlyChart =
                        document.getElementById(
                            'monthlyChart'
                        );


                    if (monthlyChart) {

                        new Chart(
                            monthlyChart,
                            {

                                type: 'line',

                                data: {

                                    labels:
                                        @json($requestMonths),

                                    datasets: [{

                                        label: 'Requests',

                                        data:
                                            @json($requestCounts),

                                        borderColor:
                                            '#00608c',

                                        backgroundColor:
                                            'rgba(0,96,140,.08)',

                                        pointBackgroundColor:
                                            '#00608c',

                                        pointBorderColor:
                                            '#ffffff',

                                        pointBorderWidth: 2,

                                        pointRadius: 4,

                                        tension: .35,

                                        fill: true
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    maintainAspectRatio: false,

                                    interaction: {

                                        intersect: false,

                                        mode: 'index'
                                    },

                                    plugins: {

                                        legend: {
                                            display: false
                                        }
                                    },

                                    scales: {

                                        x: {

                                            grid: {
                                                display: false
                                            },

                                            border: {
                                                display: false
                                            }
                                        },

                                        y: {

                                            beginAtZero: true,

                                            ticks: {
                                                precision: 0
                                            },

                                            grid: {
                                                color: '#eef1f5'
                                            },

                                            border: {
                                                display: false
                                            }
                                        }
                                    }
                                }
                            }
                        );
                    }



                    /*
                    | Donor Decision
                    */

                    const donorChart =
                        document.getElementById(
                            'donorChart'
                        );


                    if (donorChart) {

                        new Chart(
                            donorChart,
                            {

                                type: 'pie',

                                data: {

                                    labels: [
                                        'Accepted',
                                        'Rejected',
                                        'Pending'
                                    ],

                                    datasets: [{

                                        data:
                                            @json($donorDecisionChart),

                                        backgroundColor: [
                                            '#23a476',
                                            '#dc4c64',
                                            '#e7a31c'
                                        ],

                                        borderColor:
                                            '#ffffff',

                                        borderWidth: 4
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    maintainAspectRatio: false,

                                    plugins: {

                                        legend:
                                            legendBottom
                                    }
                                }
                            }
                        );
                    }



                    /*
                    | User Registrations
                    */

                    const registrationChart =
                        document.getElementById(
                            'registrationChart'
                        );


                    if (registrationChart) {

                        new Chart(
                            registrationChart,
                            {

                                type: 'bar',

                                data: {

                                    labels:
                                        @json($requestMonths),

                                    datasets: [{

                                        label:
                                            'New Users',

                                        data:
                                            @json($userRegistrationCounts),

                                        backgroundColor:
                                            '#168aad',

                                        borderRadius: 6,

                                        maxBarThickness: 34
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    maintainAspectRatio: false,

                                    plugins: {

                                        legend: {
                                            display: false
                                        }
                                    },

                                    scales: {

                                        x: {

                                            grid: {
                                                display: false
                                            },

                                            border: {
                                                display: false
                                            }
                                        },

                                        y: {

                                            beginAtZero: true,

                                            ticks: {
                                                precision: 0
                                            },

                                            grid: {
                                                color: '#eef1f5'
                                            },

                                            border: {
                                                display: false
                                            }
                                        }
                                    }
                                }
                            }
                        );
                    }


                @endif



                /*
                |--------------------------------------------------------------------------
                | DONOR CHART
                |--------------------------------------------------------------------------
                */

                @if ($user->role === 'donor')


                    const donorRequestChart =
                        document.getElementById(
                            'donorRequestChart'
                        );


                    if (donorRequestChart) {

                        new Chart(
                            donorRequestChart,
                            {

                                type: 'doughnut',

                                data: {

                                    labels: [
                                        'Pending',
                                        'Accepted',
                                        'Rejected'
                                    ],

                                    datasets: [{

                                        data:
                                            @json($donorRequestChart),

                                        backgroundColor: [
                                            '#e7a31c',
                                            '#23a476',
                                            '#dc4c64'
                                        ],

                                        borderColor:
                                            '#ffffff',

                                        borderWidth: 4
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    maintainAspectRatio: false,

                                    cutout: '68%',

                                    plugins: {

                                        legend:
                                            legendBottom
                                    }
                                }
                            }
                        );
                    }


                @endif



                /*
                |--------------------------------------------------------------------------
                | BENEFICIARY CHARTS
                |--------------------------------------------------------------------------
                */

                @if ($user->role === 'beneficiary')


                    const beneficiaryAdminChart =
                        document.getElementById(
                            'beneficiaryAdminChart'
                        );


                    if (beneficiaryAdminChart) {

                        new Chart(
                            beneficiaryAdminChart,
                            {

                                type: 'doughnut',

                                data: {

                                    labels: [
                                        'Pending',
                                        'Approved',
                                        'Rejected'
                                    ],

                                    datasets: [{

                                        data:
                                            @json($beneficiaryRequestChart),

                                        backgroundColor: [
                                            '#e7a31c',
                                            '#168aad',
                                            '#dc4c64'
                                        ],

                                        borderColor:
                                            '#ffffff',

                                        borderWidth: 4
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    maintainAspectRatio: false,

                                    cutout: '66%',

                                    plugins: {

                                        legend:
                                            legendBottom
                                    }
                                }
                            }
                        );
                    }



                    const beneficiaryDonorChart =
                        document.getElementById(
                            'beneficiaryDonorChart'
                        );


                    if (beneficiaryDonorChart) {

                        new Chart(
                            beneficiaryDonorChart,
                            {

                                type: 'doughnut',

                                data: {

                                    labels: [
                                        'Waiting',
                                        'Accepted',
                                        'Rejected'
                                    ],

                                    datasets: [{

                                        data:
                                            @json($beneficiaryDonorChart),

                                        backgroundColor: [
                                            '#e7a31c',
                                            '#23a476',
                                            '#dc4c64'
                                        ],

                                        borderColor:
                                            '#ffffff',

                                        borderWidth: 4
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    maintainAspectRatio: false,

                                    cutout: '66%',

                                    plugins: {

                                        legend:
                                            legendBottom
                                    }
                                }
                            }
                        );
                    }


                @endif


            }
        );

    </script>


</body>
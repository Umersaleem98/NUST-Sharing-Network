{{-- =========================================================
    AUTHENTICATED USER DATA
========================================================== --}}

@php

    $headerUser = auth()->user();

    $headerProfileImage = null;
    $headerProfileRoute = null;
    $headerProfileEditRoute = null;

    $headerNotifications = collect();

    $headerUnreadNotificationsCount = 0;


    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    if ($headerUser) {

        $headerNotifications =
            $headerUser
                ->notifications()
                ->latest()
                ->limit(8)
                ->get();


        $headerUnreadNotificationsCount =
            $headerUser
                ->unreadNotifications()
                ->count();
    }


    /*
    |--------------------------------------------------------------------------
    | Donor Profile
    |--------------------------------------------------------------------------
    */

    if (
        $headerUser &&
        $headerUser->role === 'donor'
    ) {

        $donorProfile =
            $headerUser->donorProfile;


        if (
            $donorProfile &&
            $donorProfile->profile_image
        ) {

            $headerProfileImage =
                asset(
                    'donors/images/profiles/' .
                    $donorProfile->profile_image
                );
        }


        $headerProfileRoute =
            route('donor.profile.show');


        $headerProfileEditRoute =
            route('donor.profile.edit');
    }


    /*
    |--------------------------------------------------------------------------
    | Beneficiary Profile
    |--------------------------------------------------------------------------
    */

    if (
        $headerUser &&
        $headerUser->role === 'beneficiary'
    ) {

        $beneficiaryProfile =
            $headerUser->beneficiaryProfile;


        if (
            $beneficiaryProfile &&
            $beneficiaryProfile->profile_image
        ) {

            $headerProfileImage =
                asset(
                    'beneficiaries/images/profiles/' .
                    $beneficiaryProfile->profile_image
                );
        }


        $headerProfileRoute =
            route(
                'beneficiary.profile.index'
            );


        $headerProfileEditRoute =
            route(
                'beneficiary.profile.edit'
            );
    }

@endphp



{{-- =========================================================
    NAV HEADER
========================================================== --}}

<div class="nav-header bg-white">

    <div class="brand-logo">

        <a href="{{ route('dashboard') }}">


            <b class="logo-abbr">

               

            </b>


            <span class="logo-compact">

               

            </span>


            <span class="brand-title">

               

            </span>

        </a>

    </div>

</div>



{{-- =========================================================
    MAIN HEADER
========================================================== --}}

<div class="header">

    <div class="header-content clearfix">


        {{-- =================================================
            SIDEBAR TOGGLE
        ================================================== --}}

        <div class="nav-control">

            <div class="hamburger">

                <span class="toggle-icon">

                    <i class="icon-menu"></i>

                </span>

            </div>

        </div>



        {{-- =================================================
            HEADER RIGHT
        ================================================== --}}

        <div class="header-right">

            <ul class="clearfix">



                {{-- =================================================
                    NOTIFICATIONS
                ================================================== --}}

                @auth

                    <li class="icons dropdown notification-wrapper">


                        {{-- Notification Trigger --}}

                        <a
                            href="javascript:void(0)"
                            id="dashboardNotificationDropdown"
                            class="header-notification-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >

                            <i class="mdi mdi-bell-outline"></i>


                            @if($headerUnreadNotificationsCount > 0)

                                <span
                                    class="badge badge-pill gradient-2 notification-counter"
                                >

                                    {{
                                        $headerUnreadNotificationsCount > 99
                                            ? '99+'
                                            : $headerUnreadNotificationsCount
                                    }}

                                </span>

                            @endif

                        </a>



                        {{-- =========================================
                            NOTIFICATION DROPDOWN
                        ========================================== --}}

                        <div
                            class="drop-down animated fadeIn dropdown-menu dropdown-menu-right dashboard-notification-dropdown"
                            aria-labelledby="dashboardNotificationDropdown"
                        >


                            {{-- =====================================
                                HEADER
                            ====================================== --}}

                            <div class="notification-dropdown-header">

                                <div>

                                    <h6>
                                        Notifications
                                    </h6>


                                    <span>

                                        @if($headerUnreadNotificationsCount > 0)

                                            You have
                                            {{ $headerUnreadNotificationsCount }}
                                            unread notification{{ $headerUnreadNotificationsCount !== 1 ? 's' : '' }}.

                                        @else

                                            You're all caught up.

                                        @endif

                                    </span>

                                </div>


                                @if($headerUnreadNotificationsCount > 0)

                                    <form
                                        action="{{ route('notifications.read-all') }}"
                                        method="POST"
                                        class="m-0"
                                    >

                                        @csrf
                                        @method('PATCH')


                                        <button
                                            type="submit"
                                            class="mark-all-read-button"
                                        >

                                            Mark all read

                                        </button>

                                    </form>

                                @endif

                            </div>



                            {{-- =====================================
                                NOTIFICATION LIST
                            ====================================== --}}

                            <div class="dashboard-notification-list">


                                @forelse(
                                    $headerNotifications
                                    as $notification
                                )


                                    @php

                                        $notificationData =
                                            $notification->data;


                                        $notificationType =
                                            $notificationData['type']
                                            ?? 'general';


                                        $notificationTitle =
                                            $notificationData['title']
                                            ?? 'New Notification';


                                        $notificationSubject =
                                            $notificationData['subject']
                                            ?? null;


                                        $notificationName =
                                            $notificationData['name']
                                            ?? null;


                                        $notificationMessage =
                                            $notificationData['message']
                                            ?? null;


                                        $isUnread =
                                            is_null(
                                                $notification->read_at
                                            );

                                    @endphp



                                    <div
                                        class="dashboard-notification-item {{ $isUnread ? 'notification-unread-item' : '' }}"
                                    >


                                        {{-- Icon --}}

                                        <div
                                            class="dashboard-notification-icon {{ $notificationType === 'contact_message' ? 'contact-notification-icon' : '' }}"
                                        >

                                            @if(
                                                $notificationType ===
                                                'contact_message'
                                            )

                                                <i class="icon-envelope"></i>

                                            @else

                                                <i class="icon-bell"></i>

                                            @endif

                                        </div>



                                        {{-- Content --}}

                                        <div class="dashboard-notification-content">


                                            <div class="notification-title-row">

                                                <h6>

                                                    {{ $notificationTitle }}

                                                </h6>


                                                @if($isUnread)

                                                    <span
                                                        class="notification-unread-dot"
                                                        title="Unread"
                                                    ></span>

                                                @endif

                                            </div>



                                            {{-- Contact Sender --}}

                                            @if($notificationName)

                                                <div class="notification-sender">

                                                    {{ $notificationName }}

                                                    @if(
                                                        !empty(
                                                            $notificationData['email']
                                                        )
                                                    )

                                                        <span>

                                                            {{
                                                                $notificationData['email']
                                                            }}

                                                        </span>

                                                    @endif

                                                </div>

                                            @endif



                                            {{-- Subject --}}

                                            @if($notificationSubject)

                                                <div class="notification-subject">

                                                    {{ $notificationSubject }}

                                                </div>

                                            @endif



                                            {{-- Message --}}

                                            @if($notificationMessage)

                                                <p>

                                                    {{
                                                        \Illuminate\Support\Str::limit(
                                                            $notificationMessage,
                                                            100
                                                        )
                                                    }}

                                                </p>

                                            @endif



                                            {{-- Footer --}}

                                            <div class="notification-item-footer">


                                                <span class="notification-time">

                                                    <i class="icon-clock"></i>

                                                    {{
                                                        $notification
                                                            ->created_at
                                                            ->diffForHumans()
                                                    }}

                                                </span>



                                                @if($isUnread)

                                                    <form
                                                        action="{{
                                                            route(
                                                                'notifications.read',
                                                                $notification->id
                                                            )
                                                        }}"
                                                        method="POST"
                                                        class="m-0"
                                                    >

                                                        @csrf
                                                        @method('PATCH')


                                                        <button
                                                            type="submit"
                                                            class="mark-read-button"
                                                        >

                                                            <i class="fa fa-check"></i>

                                                            Mark read

                                                        </button>

                                                    </form>

                                                @else

                                                    <span class="notification-read-label">

                                                        <i class="fa fa-check-circle"></i>

                                                        Read

                                                    </span>

                                                @endif


                                            </div>

                                        </div>

                                    </div>


                                @empty


                                    {{-- =================================
                                        EMPTY STATE
                                    ================================== --}}

                                    <div class="notification-empty-state">

                                        <div class="notification-empty-icon">

                                            <i class="mdi mdi-bell-outline"></i>

                                        </div>


                                        <h6>

                                            No Notifications

                                        </h6>


                                        <p>

                                            You don't have any notifications
                                            at the moment.

                                        </p>

                                    </div>


                                @endforelse


                            </div>



                            {{-- =====================================
                                FOOTER
                            ====================================== --}}

                            <div class="notification-dropdown-footer">

                                <span>

                                    Showing latest
                                    {{ $headerNotifications->count() }}
                                    notification{{ $headerNotifications->count() !== 1 ? 's' : '' }}

                                </span>

                            </div>


                        </div>

                    </li>

                @endauth



                {{-- =================================================
                    PROFILE DROPDOWN
                ================================================== --}}

                @auth

                    <li
                        class="icons dropdown profile-dropdown-wrapper"
                    >


                        {{-- =============================================
                            PROFILE TRIGGER
                        ============================================== --}}

                        <a
                            href="javascript:void(0)"
                            id="profileDropdown"
                            class="user-profile-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >


                            <span
                                class="activity active"
                            ></span>



                            {{-- Profile Image --}}

                            @if($headerProfileImage)

                                <img
                                    src="{{ $headerProfileImage }}"
                                    alt="{{ $headerUser->name }}"
                                    class="header-profile-image"
                                >

                            @else

                                <div class="header-profile-avatar">

                                    {{
                                        strtoupper(
                                            substr(
                                                $headerUser->name,
                                                0,
                                                1
                                            )
                                        )
                                    }}

                                </div>

                            @endif



                            {{-- User Information --}}

                            <div class="header-profile-info">

                                <span class="header-profile-name">

                                    {{ $headerUser->name }}

                                </span>


                                <small class="header-profile-role">

                                    {{ ucfirst($headerUser->role) }}

                                </small>

                            </div>


                            <i
                                class="fa fa-angle-down profile-chevron"
                            ></i>

                        </a>



                        {{-- =============================================
                            PROFILE MENU
                        ============================================== --}}

                        <div
                            class="drop-down dropdown-profile animated fadeIn dropdown-menu dropdown-menu-right"
                            aria-labelledby="profileDropdown"
                        >

                            <div class="dropdown-content-body">


                                {{-- =====================================
                                    PROFILE HEADER
                                ====================================== --}}

                                <div class="profile-dropdown-header">

                                    <div class="profile-dropdown-user">


                                        @if($headerProfileImage)

                                            <img
                                                src="{{ $headerProfileImage }}"
                                                alt="{{ $headerUser->name }}"
                                                class="profile-dropdown-avatar"
                                            >

                                        @else

                                            <div
                                                class="profile-dropdown-avatar-fallback"
                                            >

                                                {{
                                                    strtoupper(
                                                        substr(
                                                            $headerUser->name,
                                                            0,
                                                            1
                                                        )
                                                    )
                                                }}

                                            </div>

                                        @endif



                                        <div class="profile-dropdown-details">

                                            <h6>

                                                {{ $headerUser->name }}

                                            </h6>


                                            <small>

                                                {{ $headerUser->email }}

                                            </small>


                                            <div class="mt-2">


                                                <span
                                                    class="badge badge-primary"
                                                >

                                                    {{
                                                        ucfirst(
                                                            $headerUser->role
                                                        )
                                                    }}

                                                </span>



                                                @if(
                                                    $headerUser->profile_status
                                                    === 'active'
                                                )

                                                    <span
                                                        class="badge badge-success"
                                                    >

                                                        Active

                                                    </span>


                                                @elseif(
                                                    $headerUser->profile_status
                                                    === 'suspended'
                                                )

                                                    <span
                                                        class="badge badge-warning"
                                                    >

                                                        Suspended

                                                    </span>


                                                @else

                                                    <span
                                                        class="badge badge-danger"
                                                    >

                                                        Blocked

                                                    </span>

                                                @endif


                                            </div>

                                        </div>

                                    </div>

                                </div>



                                {{-- =====================================
                                    PROFILE MENU
                                ====================================== --}}

                                <ul class="profile-dropdown-menu-list">


                                    {{-- Dashboard --}}

                                    <li>

                                        <a href="{{ route('dashboard') }}">

                                            <i class="icon-home"></i>

                                            <span>
                                                Dashboard
                                            </span>

                                        </a>

                                    </li>



                                    {{-- Profile --}}

                                    @if($headerProfileRoute)

                                        <li>

                                            <a
                                                href="{{ $headerProfileRoute }}"
                                            >

                                                <i class="icon-user"></i>

                                                <span>
                                                    My Profile
                                                </span>

                                            </a>

                                        </li>

                                    @endif



                                    {{-- Edit Profile --}}

                                    @if($headerProfileEditRoute)

                                        <li>

                                            <a
                                                href="{{ $headerProfileEditRoute }}"
                                            >

                                                <i class="icon-note"></i>

                                                <span>
                                                    Edit Profile
                                                </span>

                                            </a>

                                        </li>

                                    @endif



                                    <li
                                        class="profile-dropdown-divider"
                                    ></li>



                                    {{-- Logout --}}

                                    <li>

                                        <form
                                            action="{{ route('logout') }}"
                                            method="POST"
                                            class="profile-logout-form"
                                        >

                                            @csrf


                                            <button
                                                type="submit"
                                                class="profile-logout-button"
                                            >

                                                <i class="icon-key"></i>

                                                <span>
                                                    Logout
                                                </span>

                                            </button>

                                        </form>

                                    </li>


                                </ul>

                            </div>

                        </div>

                    </li>

                @endauth


            </ul>

        </div>

    </div>

</div>



{{-- =========================================================
    HEADER STYLES
========================================================== --}}

<style>

    /*
    |--------------------------------------------------------------------------
    | Header Variables
    |--------------------------------------------------------------------------
    */

    :root {

        --admin-header-height: 80px;

        --admin-sidebar-width: 243px;

        --admin-sidebar-mini-width: 60px;

        --nust-primary: #00558c;

        --nust-dark: #123b60;

        --nust-light: #eef6fb;
    }


    /*
    |--------------------------------------------------------------------------
    | Fixed Logo Header
    |--------------------------------------------------------------------------
    */

    .nav-header {

        position: fixed !important;

        top: 0 !important;
        left: 0 !important;

        width:
            var(
                --admin-sidebar-width
            );

        height:
            var(
                --admin-header-height
            );

        z-index:
            1202 !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Fixed Main Header
    |--------------------------------------------------------------------------
    */

    .header {

        position: fixed !important;

        top: 0 !important;

        left:
            var(
                --admin-sidebar-width
            ) !important;

        right: 0 !important;

        width: auto !important;

        margin-left: 0 !important;

        z-index:
            1200 !important;

        background:
            #ffffff !important;

        box-shadow:
            0 2px 12px
            rgba(
                0,
                0,
                0,
                0.06
            );

        transition:
            left 0.3s ease;
    }


    .header .header-content {

        position: relative;

        width: 100%;

        height: 100%;

        background: #ffffff;

        z-index: 1;
    }


    /*
    |--------------------------------------------------------------------------
    | Content Offset
    |--------------------------------------------------------------------------
    */

    .content-body {

        padding-top:
            var(
                --admin-header-height
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    */

    .nk-sidebar {

        position: fixed !important;

        top:
            var(
                --admin-header-height
            ) !important;

        bottom: 0;

        height:
            calc(
                100vh -
                var(
                    --admin-header-height
                )
            ) !important;

        overflow-y: auto;

        z-index: 1100;
    }


    .nk-sidebar
    .nk-nav-scroll {

        height: 100%;

        overflow-y: auto;
    }


    /*
    |--------------------------------------------------------------------------
    | Mini Sidebar
    |--------------------------------------------------------------------------
    */

    [data-sidebar-style="mini"]
    .nav-header {

        width:
            var(
                --admin-sidebar-mini-width
            );
    }


    [data-sidebar-style="mini"]
    .header {

        left:
            var(
                --admin-sidebar-mini-width
            ) !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Compact
    |--------------------------------------------------------------------------
    */

    [data-sidebar-style="compact"]
    .header {

        left:
            150px !important;
    }


    [data-sidebar-style="compact"]
    .nav-header {

        width: 150px;
    }


    /*
    |--------------------------------------------------------------------------
    | Overlay
    |--------------------------------------------------------------------------
    */

    [data-sidebar-style="overlay"]
    .header {

        left:
            0 !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Header Right
    |--------------------------------------------------------------------------
    */

    .header-right {

        position: relative;

        z-index: 1205;
    }


    .header-right
    .icons.dropdown {

        position: relative;
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Trigger
    |--------------------------------------------------------------------------
    */

    .header-notification-toggle {

        position: relative;

        display: flex !important;

        align-items: center;

        justify-content: center;

        min-width: 55px;

        min-height: 60px;

        color: #555555 !important;

        text-decoration: none !important;

        font-size: 21px;

        cursor: pointer;
    }


    .header-notification-toggle:hover {

        color:
            var(
                --nust-primary
            ) !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Counter
    |--------------------------------------------------------------------------
    */

    .notification-counter {

        position: absolute;

        top: 9px;

        right: 5px;

        min-width: 18px;

        height: 18px;

        padding:
            0
            5px;

        display: flex;

        align-items: center;

        justify-content: center;

        border:
            2px solid
            #ffffff;

        border-radius: 20px;

        background: #dc3545 !important;

        color: #ffffff;

        font-size: 9px;

        line-height: 1;
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Dropdown
    |--------------------------------------------------------------------------
    */

    .dashboard-notification-dropdown {

        width: 390px !important;

        max-width:
            calc(
                100vw - 30px
            );

        padding: 0 !important;

        right: 0 !important;

        left: auto !important;

        border: 0 !important;

        border-radius: 10px !important;

        overflow: hidden;

        background: #ffffff;

        box-shadow:
            0 12px 40px
            rgba(
                18,
                59,
                96,
                0.17
            );

        z-index:
            1300 !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Header
    |--------------------------------------------------------------------------
    */

    .notification-dropdown-header {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

        padding:
            17px
            18px;

        background:
            #f7fafc;

        border-bottom:
            1px solid
            #e5ebf0;
    }


    .notification-dropdown-header h6 {

        margin: 0 0 3px;

        color:
            var(
                --nust-dark
            );

        font-size: 14px;

        font-weight: 700;
    }


    .notification-dropdown-header span {

        color: #8996a0;

        font-size: 10px;
    }


    .mark-all-read-button {

        padding: 0;

        border: 0;

        background: transparent;

        color:
            var(
                --nust-primary
            );

        font-size: 10px;

        font-weight: 700;

        white-space: nowrap;

        cursor: pointer;
    }


    .mark-all-read-button:hover {

        text-decoration: underline;
    }


    /*
    |--------------------------------------------------------------------------
    | Notification List
    |--------------------------------------------------------------------------
    */

    .dashboard-notification-list {

        max-height: 430px;

        overflow-y: auto;
    }


    .dashboard-notification-item {

        display: flex;

        align-items: flex-start;

        gap: 12px;

        padding:
            15px
            17px;

        border-bottom:
            1px solid
            #edf1f4;

        background:
            #ffffff;

        transition:
            background 0.2s ease;
    }


    .dashboard-notification-item:hover {

        background:
            #f8fbfd;
    }


    .notification-unread-item {

        background:
            #eef7fc;
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Icon
    |--------------------------------------------------------------------------
    */

    .dashboard-notification-icon {

        width: 40px;

        height: 40px;

        min-width: 40px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        background:
            #eef2f5;

        color:
            #657582;

        font-size: 15px;
    }


    .contact-notification-icon {

        background:
            #e5f2f9;

        color:
            var(
                --nust-primary
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Content
    |--------------------------------------------------------------------------
    */

    .dashboard-notification-content {

        min-width: 0;

        flex: 1;
    }


    .notification-title-row {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 10px;
    }


    .notification-title-row h6 {

        margin:
            0
            0
            4px;

        color:
            #25384b;

        font-size: 12px;

        font-weight: 700;
    }


    .notification-unread-dot {

        width: 7px;

        height: 7px;

        min-width: 7px;

        border-radius: 50%;

        background:
            var(
                --nust-primary
            );
    }


    .notification-sender {

        margin-bottom: 3px;

        color: #405363;

        font-size: 11px;

        font-weight: 600;
    }


    .notification-sender span {

        display: block;

        margin-top: 1px;

        color: #8996a0;

        font-size: 9px;

        font-weight: 400;
    }


    .notification-subject {

        margin-bottom: 3px;

        color:
            var(
                --nust-primary
            );

        font-size: 11px;

        font-weight: 600;
    }


    .dashboard-notification-content p {

        margin:
            3px
            0
            6px;

        color: #758491;

        font-size: 10px;

        line-height: 1.5;
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Footer
    |--------------------------------------------------------------------------
    */

    .notification-item-footer {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 10px;

        margin-top: 7px;
    }


    .notification-time {

        color: #9aa6b1;

        font-size: 9px;
    }


    .notification-time i {

        margin-right: 3px;
    }


    .mark-read-button {

        padding: 0;

        border: 0;

        background: transparent;

        color:
            var(
                --nust-primary
            );

        font-size: 9px;

        font-weight: 700;

        cursor: pointer;
    }


    .notification-read-label {

        color: #28a745;

        font-size: 9px;
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Empty State
    |--------------------------------------------------------------------------
    */

    .notification-empty-state {

        padding:
            38px
            20px;

        text-align: center;
    }


    .notification-empty-icon {

        width: 55px;

        height: 55px;

        display: flex;

        align-items: center;

        justify-content: center;

        margin:
            0
            auto
            10px;

        border-radius: 50%;

        background:
            #eef6fb;

        color:
            var(
                --nust-primary
            );

        font-size: 23px;
    }


    .notification-empty-state h6 {

        margin-bottom: 4px;

        color:
            #405363;

        font-size: 13px;
    }


    .notification-empty-state p {

        margin: 0;

        color: #8996a0;

        font-size: 10px;
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Dropdown Footer
    |--------------------------------------------------------------------------
    */

    .notification-dropdown-footer {

        padding:
            10px
            17px;

        text-align: center;

        background:
            #f8fafc;

        border-top:
            1px solid
            #e5ebf0;
    }


    .notification-dropdown-footer span {

        color: #8996a0;

        font-size: 9px;
    }


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    .profile-dropdown-wrapper {

        position: relative;
    }


    .user-profile-toggle {

        display:
            flex !important;

        align-items: center;

        position: relative;

        gap: 10px;

        min-height: 60px;

        padding:
            8px
            12px !important;

        color:
            #555555 !important;

        text-decoration:
            none !important;

        cursor: pointer;
    }


    .user-profile-toggle:hover {

        color:
            var(
                --nust-primary
            ) !important;

        text-decoration:
            none !important;
    }


    .profile-dropdown-wrapper
    .activity {

        position: absolute;

        top: 12px;

        left: 42px;

        width: 10px;

        height: 10px;

        border:
            2px solid
            #ffffff;

        border-radius: 50%;

        z-index: 5;
    }


    .profile-dropdown-wrapper
    .activity.active {

        background:
            #28a745;
    }


    .header-profile-image {

        width:
            42px !important;

        height:
            42px !important;

        min-width: 42px;

        object-fit: cover;

        border-radius: 50%;

        border:
            2px solid
            #eef2f5;
    }


    .header-profile-avatar {

        width: 42px;

        height: 42px;

        min-width: 42px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        background:
            var(
                --nust-primary
            );

        color: #ffffff;

        font-size: 17px;

        font-weight: 700;

        border:
            2px solid
            #eef2f5;
    }


    .header-profile-info {

        display: flex;

        flex-direction: column;

        line-height: 1.3;

        text-align: left;
    }


    .header-profile-name {

        display: block;

        max-width: 140px;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;

        color: #333333;

        font-size: 13px;

        font-weight: 600;
    }


    .header-profile-role {

        color: #8a98a5;

        font-size: 10px;
    }


    .profile-chevron {

        margin-left: 2px;

        color: #8a98a5;

        font-size: 12px;

        transition:
            transform 0.2s ease;
    }


    .profile-dropdown-wrapper.show
    .profile-chevron {

        transform:
            rotate(180deg);
    }


    /*
    |--------------------------------------------------------------------------
    | Profile Dropdown
    |--------------------------------------------------------------------------
    */

    .profile-dropdown-wrapper
    .dropdown-profile {

        width: 290px;

        min-width: 290px;

        padding:
            0 !important;

        margin-top: 0;

        right:
            0 !important;

        left:
            auto !important;

        border: 0;

        border-radius: 8px;

        overflow: hidden;

        background:
            #ffffff;

        box-shadow:
            0 8px 28px
            rgba(
                0,
                0,
                0,
                0.13
            );

        z-index:
            1300 !important;
    }


    .profile-dropdown-header {

        padding: 18px;

        background:
            #f7fafc;

        border-bottom:
            1px solid
            #e6edf1;
    }


    .profile-dropdown-user {

        display: flex;

        align-items: center;

        gap: 12px;
    }


    .profile-dropdown-avatar {

        width: 54px;

        height: 54px;

        min-width: 54px;

        border-radius: 50%;

        object-fit: cover;

        border:
            3px solid
            #ffffff;
    }


    .profile-dropdown-avatar-fallback {

        width: 54px;

        height: 54px;

        min-width: 54px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        background:
            var(
                --nust-primary
            );

        color: #ffffff;

        font-size: 21px;

        font-weight: 700;

        border:
            3px solid
            #ffffff;
    }


    .profile-dropdown-details {

        min-width: 0;

        flex: 1;
    }


    .profile-dropdown-details h6 {

        margin:
            0
            0
            3px;

        color: #243746;

        font-size: 14px;

        font-weight: 600;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;
    }


    .profile-dropdown-details small {

        display: block;

        color: #7c8994;

        font-size: 11px;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;
    }


    /*
    |--------------------------------------------------------------------------
    | Profile Menu
    |--------------------------------------------------------------------------
    */

    .profile-dropdown-menu-list {

        margin:
            0 !important;

        padding:
            8px
            0 !important;

        list-style: none;
    }


    .profile-dropdown-menu-list li {

        margin: 0;

        padding: 0;
    }


    .profile-dropdown-menu-list li a,
    .profile-logout-button {

        display: flex;

        align-items: center;

        gap: 12px;

        width: 100%;

        padding:
            11px
            18px;

        border: 0;

        background: transparent;

        color: #52616b;

        font-size: 13px;

        text-align: left;

        text-decoration: none;
    }


    .profile-dropdown-menu-list
    li a:hover {

        color:
            var(
                --nust-primary
            );

        background:
            #eef6fb;

        text-decoration: none;
    }


    .profile-dropdown-menu-list
    li a i,
    .profile-logout-button i {

        width: 18px;

        font-size: 15px;

        text-align: center;
    }


    .profile-dropdown-divider {

        height: 1px;

        margin:
            7px
            0 !important;

        background:
            #e8edf1;
    }


    .profile-logout-form {

        margin: 0;

        padding: 0;
    }


    .profile-logout-button {

        cursor: pointer;

        color:
            #dc3545 !important;
    }


    .profile-logout-button:hover {

        color:
            #bd2130 !important;

        background:
            #fff2f3 !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Dropdown Fix
    |--------------------------------------------------------------------------
    */

    .profile-dropdown-wrapper.show
    > .dropdown-menu,
    .notification-wrapper.show
    > .dropdown-menu {

        display: block;
    }


    .header
    .dropdown-menu {

        z-index:
            1300 !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Tablet
    |--------------------------------------------------------------------------
    */

    @media
    (
        max-width: 991.98px
    ) {

        .header {

            left:
                60px !important;

            right:
                0 !important;
        }


        .nav-header {

            width: 60px;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Mobile
    |--------------------------------------------------------------------------
    */

    @media
    (
        max-width: 767.98px
    ) {

        .nav-header {

            width:
                60px !important;
        }


        .header {

            left:
                60px !important;

            right:
                0 !important;
        }


        .header-profile-info {

            display: none;
        }


        .profile-chevron {

            display: none;
        }


        .user-profile-toggle {

            padding-left:
                8px !important;

            padding-right:
                8px !important;
        }


        .profile-dropdown-wrapper
        .dropdown-profile {

            width: 280px;

            min-width: 280px;

            right:
                -5px !important;
        }


        .dashboard-notification-dropdown {

            position:
                fixed !important;

            top:
                var(
                    --admin-header-height
                ) !important;

            right:
                10px !important;

            left:
                auto !important;

            width:
                calc(
                    100vw - 80px
                ) !important;

            max-width:
                380px;
        }

    }


    @media
    (
        max-width: 420px
    ) {

        .profile-dropdown-wrapper
        .dropdown-profile {

            width: 260px;

            min-width: 260px;

            right:
                -5px !important;
        }


        .dashboard-notification-dropdown {

            width:
                calc(
                    100vw - 75px
                ) !important;
        }

    }

</style>
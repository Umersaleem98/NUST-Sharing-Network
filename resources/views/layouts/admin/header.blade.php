@php

    $authUser = Auth::user();


    /*
    |--------------------------------------------------------------------------
    | Generate User Initials
    |--------------------------------------------------------------------------
    */

    $nameParts = preg_split(
        '/\s+/',
        trim($authUser->name)
    );


    $userInitials = collect($nameParts)
        ->filter()
        ->take(2)
        ->map(
            fn ($part) =>
                strtoupper(
                    substr($part, 0, 1)
                )
        )
        ->implode('');


    /*
    |--------------------------------------------------------------------------
    | Determine Profile Route
    |--------------------------------------------------------------------------
    */

    $profileRoute = route('dashboard');


    if (
        $authUser->role === 'donor'
        &&
        Route::has('donor.profile.index')
    ) {

        $profileRoute =
            route('donor.profile.index');

    } elseif (
        $authUser->role === 'beneficiary'
        &&
        Route::has('Beneficiary.profile.index')
    ) {

        $profileRoute =
            route('Beneficiary.profile.index');

    }

@endphp


<!-- =========================================================
     TOPBAR
========================================================== -->
<header class="nsn-topbar">


    <!-- =====================================================
         SIDEBAR TOGGLE
    ====================================================== -->
    <button
        type="button"
        class="nsn-toggle-btn"
        id="sidebarToggle"
        aria-label="Toggle sidebar"
    >

        <i
            class="bi bi-list"
            style="font-size: 1.3rem;"
        ></i>

    </button>


    <!-- =====================================================
         SEARCH AREA
    ====================================================== -->
    <div
        class="
            input-group
            nsn-search
            d-none
            d-md-flex
        "
    >
    </div>


    <!-- =====================================================
         RIGHT SIDE
    ====================================================== -->
    <div
        class="
            ms-auto
            d-flex
            align-items-center
            gap-2
        "
    >


        <!-- =================================================
             ADMIN NOTIFICATIONS
        ================================================== -->
        @if ($authUser->role === 'admin')

            @php

                /*
                |--------------------------------------------------------------------------
                | Notification Count
                |--------------------------------------------------------------------------
                */

                $unreadNotificationCount =
                    $authUser
                        ->unreadNotifications()
                        ->count();


                /*
                |--------------------------------------------------------------------------
                | Latest 10 Notifications
                |--------------------------------------------------------------------------
                */

                $headerNotifications =
                    $authUser
                        ->notifications()
                        ->latest()
                        ->limit(10)
                        ->get();

            @endphp


            <div class="dropdown">


                <!-- =========================================
                     NOTIFICATION BELL
                ========================================== -->
                <button
                    type="button"
                    class="
                        nsn-icon-btn
                        position-relative
                    "
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                    aria-label="Notifications"
                >

                    <i class="bi bi-bell"></i>


                    @if (
                        $unreadNotificationCount > 0
                    )

                        <span class="ping"></span>


                        <span
                            class="
                                position-absolute
                                top-0
                                start-100
                                translate-middle
                                badge
                                rounded-pill
                                bg-danger
                            "
                            style="
                                font-size: 0.62rem;
                            "
                        >

                            {{
                                $unreadNotificationCount > 99
                                    ? '99+'
                                    : $unreadNotificationCount
                            }}


                            <span class="visually-hidden">
                                unread notifications
                            </span>

                        </span>

                    @endif

                </button>


                <!-- =========================================
                     NOTIFICATION DROPDOWN
                ========================================== -->
                <div
                    class="
                        dropdown-menu
                        dropdown-menu-end
                        border-0
                        shadow
                        rounded-4
                        overflow-hidden
                        p-0
                    "
                    style="
                        width:
                            min(
                                410px,
                                calc(100vw - 24px)
                            );
                    "
                >


                    <!-- =====================================
                         DROPDOWN HEADER
                    ====================================== -->
                    <div
                        class="
                            d-flex
                            align-items-center
                            justify-content-between
                            gap-3
                            px-3
                            py-3
                            border-bottom
                        "
                    >

                        <div>

                            <h6
                                class="
                                    fw-bold
                                    text-dark
                                    mb-1
                                "
                            >
                                Notifications
                            </h6>


                            <p
                                class="
                                    text-secondary
                                    mb-0
                                "
                                style="
                                    font-size:
                                        0.72rem;
                                "
                            >

                                {{
                                    $unreadNotificationCount
                                }}

                                unread

                                {{
                                    \Illuminate\Support\Str::plural(
                                        'notification',
                                        $unreadNotificationCount
                                    )
                                }}

                            </p>

                        </div>


                        @if (
                            $unreadNotificationCount > 0
                        )

                            <form
                                method="POST"
                                action="{{
                                    route(
                                        'notifications.read-all'
                                    )
                                }}"
                            >

                                @csrf
                                @method('PATCH')


                                <button
                                    type="submit"
                                    class="
                                        btn
                                        btn-link
                                        btn-sm
                                        text-decoration-none
                                        p-0
                                    "
                                >
                                    Mark all read
                                </button>

                            </form>

                        @endif

                    </div>


                    <!-- =====================================
                         NOTIFICATION LIST
                    ====================================== -->
                    <div
                        style="
                            max-height: 430px;
                            overflow-y: auto;
                        "
                    >

                        @forelse (
                            $headerNotifications
                            as $notification
                        )

                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | Notification Data
                                |--------------------------------------------------------------------------
                                */

                                $notificationData =
                                    $notification->data;


                                $isUnread =
                                    is_null(
                                        $notification->read_at
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | Notification Type
                                |--------------------------------------------------------------------------
                                */

                                $notificationType =
                                    $notificationData['type']
                                    ?? 'general';


                                /*
                                |--------------------------------------------------------------------------
                                | Title
                                |--------------------------------------------------------------------------
                                */

                                $notificationTitle =
                                    $notificationData['title']
                                    ?? 'New Notification';


                                /*
                                |--------------------------------------------------------------------------
                                | Message
                                |--------------------------------------------------------------------------
                                */

                                $notificationMessage =
                                    $notificationData['message']
                                    ?? 'You have a new notification.';


                                /*
                                |--------------------------------------------------------------------------
                                | Sender Name
                                |--------------------------------------------------------------------------
                                |
                                | Supports:
                                | - Contact messages
                                | - Donor/product notifications
                                | - Older notifications
                                |
                                */

                                $createdByName =
                                    $notificationData[
                                        'created_by_name'
                                    ]
                                    ??
                                    $notificationData[
                                        'sender_name'
                                    ]
                                    ??
                                    $notificationData[
                                        'donor_name'
                                    ]
                                    ??
                                    'Unknown user';


                                /*
                                |--------------------------------------------------------------------------
                                | Sender Role
                                |--------------------------------------------------------------------------
                                */

                                $createdByRole =
                                    $notificationData[
                                        'created_by_role'
                                    ]
                                    ??
                                    $notificationData[
                                        'user_type'
                                    ]
                                    ??
                                    'user';


                                /*
                                |--------------------------------------------------------------------------
                                | Icon
                                |--------------------------------------------------------------------------
                                */

                                $notificationIcon =
                                    $notificationData[
                                        'icon'
                                    ]
                                    ?? 'bi-bell';


                                /*
                                |--------------------------------------------------------------------------
                                | Contact Specific Data
                                |--------------------------------------------------------------------------
                                */

                                $contactSubject =
                                    $notificationData[
                                        'subject'
                                    ]
                                    ?? null;


                                $senderEmail =
                                    $notificationData[
                                        'sender_email'
                                    ]
                                    ?? null;


                                $inquiryType =
                                    $notificationData[
                                        'inquiry_type'
                                    ]
                                    ?? null;

                            @endphp


                            <!-- =============================
                                 NOTIFICATION FORM
                            ============================== -->
                            <form
                                method="POST"
                                action="{{
                                    route(
                                        'notifications.read',
                                        $notification->id
                                    )
                                }}"
                                class="border-bottom"
                            >

                                @csrf
                                @method('PATCH')


                                <button
                                    type="submit"
                                    class="
                                        dropdown-item
                                        text-wrap
                                        px-3
                                        py-3
                                        {{
                                            $isUnread
                                                ? 'bg-primary-subtle'
                                                : 'bg-white'
                                        }}
                                    "
                                >

                                    <span
                                        class="
                                            d-flex
                                            align-items-start
                                            gap-3
                                        "
                                    >


                                        <!-- =====================
                                             NOTIFICATION ICON
                                        ====================== -->
                                        <span
                                            class="
                                                d-inline-flex
                                                flex-shrink-0
                                                align-items-center
                                                justify-content-center
                                                rounded-circle
                                                {{
                                                    $notificationType
                                                    ===
                                                    'contact_message'
                                                        ? 'bg-warning text-dark'
                                                        : 'bg-primary text-white'
                                                }}
                                            "
                                            style="
                                                width: 42px;
                                                height: 42px;
                                            "
                                        >

                                            <i
                                                class="
                                                    bi
                                                    {{
                                                        $notificationIcon
                                                    }}
                                                "
                                            ></i>

                                        </span>


                                        <!-- =====================
                                             NOTIFICATION CONTENT
                                        ====================== -->
                                        <span
                                            class="
                                                flex-grow-1
                                                overflow-hidden
                                            "
                                        >


                                            <!-- Title -->
                                            <span
                                                class="
                                                    d-flex
                                                    align-items-start
                                                    justify-content-between
                                                    gap-2
                                                "
                                            >

                                                <strong
                                                    class="
                                                        d-block
                                                        text-dark
                                                    "
                                                    style="
                                                        font-size:
                                                            0.82rem;
                                                    "
                                                >

                                                    {{
                                                        $notificationTitle
                                                    }}

                                                </strong>


                                                @if ($isUnread)

                                                    <span
                                                        class="
                                                            d-inline-block
                                                            flex-shrink-0
                                                            rounded-circle
                                                            bg-primary
                                                            mt-1
                                                        "
                                                        style="
                                                            width: 8px;
                                                            height: 8px;
                                                        "
                                                        title="Unread"
                                                    ></span>

                                                @endif

                                            </span>


                                            <!-- =================================
                                                 CONTACT SUBJECT
                                            ================================== -->
                                            @if (
                                                $notificationType
                                                ===
                                                'contact_message'
                                                &&
                                                $contactSubject
                                            )

                                                <span
                                                    class="
                                                        d-block
                                                        text-dark
                                                        fw-semibold
                                                        mt-2
                                                    "
                                                    style="
                                                        font-size:
                                                            .76rem;
                                                    "
                                                >

                                                    <i
                                                        class="
                                                            bi
                                                            bi-chat-left-text
                                                            text-warning
                                                            me-1
                                                        "
                                                    ></i>

                                                    {{
                                                        \Illuminate\Support\Str::limit(
                                                            $contactSubject,
                                                            55
                                                        )
                                                    }}

                                                </span>

                                            @endif


                                            <!-- =================================
                                                 SENDER NAME / ROLE
                                            ================================== -->
                                            <span
                                                class="
                                                    d-flex
                                                    flex-wrap
                                                    align-items-center
                                                    gap-2
                                                    mt-2
                                                "
                                            >

                                                <span
                                                    class="
                                                        d-inline-flex
                                                        align-items-center
                                                        text-dark
                                                        fw-semibold
                                                    "
                                                    style="
                                                        font-size:
                                                            0.76rem;
                                                    "
                                                >

                                                    <i
                                                        class="
                                                            bi
                                                            bi-person-circle
                                                            text-primary
                                                            me-1
                                                        "
                                                    ></i>

                                                    {{
                                                        $createdByName
                                                    }}

                                                </span>


                                                <span
                                                    class="
                                                        badge
                                                        rounded-pill
                                                        bg-light
                                                        text-secondary
                                                        border
                                                        text-capitalize
                                                    "
                                                    style="
                                                        font-size:
                                                            0.62rem;
                                                    "
                                                >

                                                    {{
                                                        str_replace(
                                                            '_',
                                                            ' ',
                                                            $createdByRole
                                                        )
                                                    }}

                                                </span>

                                            </span>


                                            <!-- =================================
                                                 CONTACT EMAIL
                                            ================================== -->
                                            @if (
                                                $notificationType
                                                ===
                                                'contact_message'
                                                &&
                                                $senderEmail
                                            )

                                                <span
                                                    class="
                                                        d-block
                                                        text-secondary
                                                        mt-1
                                                    "
                                                    style="
                                                        font-size:
                                                            .70rem;
                                                    "
                                                >

                                                    <i
                                                        class="
                                                            bi
                                                            bi-envelope
                                                            me-1
                                                        "
                                                    ></i>

                                                    {{
                                                        $senderEmail
                                                    }}

                                                </span>

                                            @endif


                                            <!-- =================================
                                                 INQUIRY TYPE
                                            ================================== -->
                                            @if (
                                                $notificationType
                                                ===
                                                'contact_message'
                                                &&
                                                $inquiryType
                                            )

                                                <span
                                                    class="
                                                        d-inline-block
                                                        badge
                                                        rounded-pill
                                                        bg-warning-subtle
                                                        text-warning-emphasis
                                                        border
                                                        mt-2
                                                    "
                                                    style="
                                                        font-size:
                                                            .62rem;
                                                    "
                                                >

                                                    {{
                                                        ucwords(
                                                            str_replace(
                                                                '_',
                                                                ' ',
                                                                $inquiryType
                                                            )
                                                        )
                                                    }}

                                                </span>

                                            @endif


                                            <!-- =================================
                                                 MESSAGE
                                            ================================== -->
                                            <span
                                                class="
                                                    d-block
                                                    text-secondary
                                                    mt-2
                                                "
                                                style="
                                                    font-size:
                                                        0.74rem;
                                                    line-height:
                                                        1.45;
                                                    white-space:
                                                        normal;
                                                "
                                            >

                                                {{
                                                    \Illuminate\Support\Str::limit(
                                                        $notificationMessage,
                                                        115
                                                    )
                                                }}

                                            </span>


                                            <!-- =================================
                                                 DATE
                                            ================================== -->
                                            <span
                                                class="
                                                    d-block
                                                    text-primary
                                                    mt-2
                                                "
                                                style="
                                                    font-size:
                                                        0.68rem;
                                                "
                                            >

                                                <i
                                                    class="
                                                        bi
                                                        bi-clock
                                                        me-1
                                                    "
                                                ></i>

                                                {{
                                                    $notification
                                                        ->created_at
                                                        ->diffForHumans()
                                                }}

                                            </span>

                                        </span>

                                    </span>

                                </button>

                            </form>


                        @empty


                            <!-- =============================
                                 EMPTY NOTIFICATIONS
                            ============================== -->
                            <div
                                class="
                                    text-center
                                    px-4
                                    py-5
                                "
                            >

                                <span
                                    class="
                                        d-inline-flex
                                        align-items-center
                                        justify-content-center
                                        rounded-circle
                                        bg-light
                                        text-secondary
                                        mb-3
                                    "
                                    style="
                                        width: 64px;
                                        height: 64px;
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-bell-slash
                                            fs-4
                                        "
                                    ></i>

                                </span>


                                <h6
                                    class="
                                        fw-semibold
                                        text-dark
                                        mb-2
                                    "
                                >
                                    No notifications
                                </h6>


                                <p
                                    class="
                                        text-secondary
                                        small
                                        mb-0
                                    "
                                >

                                    New product requests,
                                    donor activity and contact
                                    messages will appear here.

                                </p>

                            </div>

                        @endforelse

                    </div>


                    <!-- =====================================
                         DROPDOWN FOOTER
                    ====================================== -->
                    @if (
                        $headerNotifications->isNotEmpty()
                    )

                        <div
                            class="
                                d-flex
                                align-items-center
                                justify-content-between
                                gap-2
                                px-3
                                py-2
                                bg-light
                                border-top
                            "
                        >

                            <small class="text-secondary">
                                Latest 10 notifications
                            </small>


                            <form
                                method="POST"
                                action="{{
                                    route(
                                        'notifications.clear-all'
                                    )
                                }}"
                                onsubmit="
                                    return confirm(
                                        'Are you sure you want to clear all notifications?'
                                    );
                                "
                            >

                                @csrf
                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="
                                        btn
                                        btn-link
                                        btn-sm
                                        text-danger
                                        text-decoration-none
                                        p-0
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-trash3
                                            me-1
                                        "
                                    ></i>

                                    Clear all

                                </button>

                            </form>

                        </div>

                    @endif

                </div>

            </div>

        @endif


        <!-- =================================================
             USER DROPDOWN
        ================================================== -->
        <div class="dropdown">


            <button
                type="button"
                class="
                    d-flex
                    align-items-center
                    gap-2
                    btn
                    p-1
                    border-0
                "
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >


                <!-- =========================================
                     USER IMAGE / INITIALS
                ========================================== -->
                @if ($authUser->image)

                    <img
                        src="{{
                            asset(
                                'admins/asset/profilephoto/'
                                .
                                $authUser->image
                            )
                        }}"
                        alt="{{ $authUser->name }}"
                        class="
                            rounded-circle
                            object-fit-cover
                        "
                        style="
                            width: 40px;
                            height: 40px;
                            border:
                                2px solid #e9ecef;
                        "
                    >

                @else

                    <div class="nsn-avatar">

                        {{
                            $userInitials ?: 'U'
                        }}

                    </div>

                @endif


                <!-- =========================================
                     NAME / ROLE
                ========================================== -->
                <div
                    class="
                        d-none
                        d-lg-block
                        text-start
                    "
                >

                    <div
                        class="
                            fw-semibold
                            text-dark
                        "
                        style="
                            font-size: 0.82rem;
                            line-height: 1.2;
                        "
                    >

                        {{ $authUser->name }}

                    </div>


                    <small
                        class="
                            text-secondary
                            text-capitalize
                        "
                        style="
                            font-size: 0.7rem;
                        "
                    >

                        {{ $authUser->role }}

                    </small>

                </div>


                <i
                    class="
                        bi
                        bi-chevron-down
                        d-none
                        d-sm-inline-block
                        small
                    "
                ></i>

            </button>


            <!-- =============================================
                 USER DROPDOWN MENU
            ============================================== -->
            <ul
                class="
                    dropdown-menu
                    dropdown-menu-end
                    shadow-sm
                "
            >


                <!-- User Information -->
                <li>

                    <div class="dropdown-header">

                        <div
                            class="
                                fw-semibold
                                text-dark
                            "
                        >

                            {{ $authUser->name }}

                        </div>


                        <small
                            class="
                                text-secondary
                                text-capitalize
                            "
                        >

                            {{
                                $authUser->role
                            }}
                            Account

                        </small>

                    </div>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                <!-- =========================================
                     PROFILE
                ========================================== -->
                @if (
                    $authUser->role !== 'admin'
                )

                    <li>

                        <a
                            class="
                                dropdown-item
                                {{
                                    request()->url()
                                    ===
                                    $profileRoute
                                        ? 'active'
                                        : ''
                                }}
                            "
                            href="{{ $profileRoute }}"
                        >

                            <i
                                class="
                                    bi
                                    bi-person
                                    me-2
                                "
                            ></i>

                            My Profile

                        </a>

                    </li>

                @endif


                <!-- =========================================
                     DASHBOARD
                ========================================== -->
                <li>

                    <a
                        class="dropdown-item"
                        href="{{
                            route(
                                'dashboard'
                            )
                        }}"
                    >

                        <i
                            class="
                                bi
                                bi-grid-1x2
                                me-2
                            "
                        ></i>

                        Dashboard

                    </a>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                <!-- =========================================
                     LOGOUT
                ========================================== -->
                <li>

                    <a
                        href="{{ route('logout') }}"
                        class="
                            dropdown-item
                            text-danger
                        "
                        onclick="
                            event.preventDefault();

                            document
                                .getElementById(
                                    'topbar-logout-form'
                                )
                                .submit();
                        "
                    >

                        <i
                            class="
                                bi
                                bi-box-arrow-right
                                me-2
                            "
                        ></i>

                        Sign Out

                    </a>

                </li>

            </ul>

        </div>

    </div>


    <!-- =====================================================
         LOGOUT FORM
    ====================================================== -->
    <form
        id="topbar-logout-form"
        action="{{ route('logout') }}"
        method="POST"
        class="d-none"
    >

        @csrf

    </form>

</header>
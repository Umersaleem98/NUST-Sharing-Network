<!-- ============ NEW SIDEBAR ============ -->

<aside class="nsn-sidebar" id="sidebar">

    <!-- =========================================================
         BRAND / USER PROFILE
    ========================================================== -->

    <div class="nsn-brand">

        <a
            href="{{ route('dashboard') }}"
            class="d-flex align-items-center text-decoration-none w-100"
        >

            <div class="nsn-brand-mark me-0 me-2">

                @if (Auth::user()->image)

                    <img
                        src="{{ asset('admins/asset/profilephoto/' . Auth::user()->image) }}"
                        alt="{{ Auth::user()->name }}"
                        class="w-100 h-100 rounded-circle object-fit-cover"
                    >

                @else

                    <img
                        src="{{ asset('admins/asset/dummy/dummy.jpg') }}"
                        alt="{{ Auth::user()->name }}"
                        class="w-100 h-100 rounded-circle object-fit-cover"
                    >

                @endif

            </div>


            <div class="nsn-brand-text nsn-label">

                <div
                    class="fw-semibold font-display"
                    style="font-size: .95rem;"
                >
                    {{ Auth::user()->name }}
                </div>

                <small class="text-capitalize">
                    {{ Auth::user()->role }} Portal
                </small>

            </div>

        </a>

    </div>


    <!-- =========================================================
         NAVIGATION
    ========================================================== -->

    <nav class="nsn-nav">


        <!-- =====================================================
             OVERVIEW
        ====================================================== -->

        <div class="nsn-nav-section">

            <div class="nsn-sec-title">
                Overview
            </div>


            <a
                href="{{ route('dashboard') }}"
                class="nsn-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >

                <i class="bi bi-grid-1x2-fill"></i>

                <span class="nsn-label">
                    Dashboard
                </span>

            </a>

        </div>


        <!-- =====================================================
             ADMIN SIDEBAR
             ONLY ADMIN CAN SEE THIS SECTION
        ====================================================== -->

        @if (Auth::user()->role === 'admin')

            <div class="nsn-nav-section">

                <div class="nsn-sec-title">
                    Administration
                </div>


                <!-- Existing Admin Sidebar -->

                @include('layouts.admin.components.adminSidebar')


                <!-- =================================================
                     STUDENT STORIES
                     ADMIN ONLY
                ================================================== -->

                <a
                    href="{{ route('admin.student.stories.index') }}"
                    class="nsn-nav-link {{ request()->routeIs('admin.student-stories.*') ? 'active' : '' }}"
                >

                    <i class="bi bi-chat-square-quote-fill"></i>

                    <span class="nsn-label">
                        Student Stories
                    </span>

                </a>

            </div>

        @endif


        <!-- =====================================================
             DONOR SIDEBAR
        ====================================================== -->

        @if (Auth::user()->role === 'donor')

            <div class="nsn-nav-section">

                <div class="nsn-sec-title">
                    Donor Management
                </div>

                @include('layouts.admin.components.donorSidebar')

            </div>

        @endif


        <!-- =====================================================
             BENEFICIARY SIDEBAR
        ====================================================== -->

        @if (Auth::user()->role === 'beneficiary')

            <div class="nsn-nav-section">

                <div class="nsn-sec-title">
                    Beneficiary Portal
                </div>

                @include('layouts.admin.components.beneficiarySidebar')

            </div>

        @endif


        <!-- =====================================================
             ACCOUNT
        ====================================================== -->

        <div class="nsn-nav-section">

            <div class="nsn-sec-title">
                Account
            </div>


            <!-- My Profile -->

            @if (Route::has('profile.edit'))

                <a
                    href="{{ route('profile.edit') }}"
                    class="nsn-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                >

                    <i class="bi bi-person-circle"></i>

                    <span class="nsn-label">
                        My Profile
                    </span>

                </a>

            @endif


            <!-- Settings -->

            @if (Route::has('settings'))

                <a
                    href="{{ route('settings') }}"
                    class="nsn-nav-link {{ request()->routeIs('settings*') ? 'active' : '' }}"
                >

                    <i class="bi bi-gear"></i>

                    <span class="nsn-label">
                        Settings
                    </span>

                </a>

            @endif


            <!-- Logout -->

            <a
                href="{{ route('logout') }}"
                class="nsn-nav-link"
                onclick="
                    event.preventDefault();
                    document.getElementById('sidebar-logout-form').submit();
                "
            >

                <i class="bi bi-box-arrow-right"></i>

                <span class="nsn-label">
                    Logout
                </span>

            </a>


            <form
                id="sidebar-logout-form"
                action="{{ route('logout') }}"
                method="POST"
                class="d-none"
            >
                @csrf
            </form>

        </div>

    </nav>


    <!-- =========================================================
         SIDEBAR FOOTER
    ========================================================== -->

    <div class="nsn-sidebar-foot">

        <div class="nsn-mini-status">

            <span class="nsn-dot-live"></span>

            <span class="nsn-label">
                Secure connection
            </span>

        </div>

    </div>

</aside>
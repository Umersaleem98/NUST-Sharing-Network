{{-- =========================================================
    DONOR SIDEBAR
========================================================== --}}

<li class="nav-label">

    Donor

</li>



{{-- =========================================================
    PROFILE COMPLETION
========================================================== --}}

<li>

    <div class="sidebar-profile-completion">


        <div class="sidebar-profile-completion-header">

            <span>

                Profile Completion

            </span>


            <span class="sidebar-profile-completion-percent">

                {{ $donorProfileCompletion }}%

            </span>

        </div>


        <div class="sidebar-profile-progress">

            <div
                class="sidebar-profile-progress-bar"
                style="
                    width:
                    {{ min($donorProfileCompletion, 100) }}%;
                "
            ></div>

        </div>


        @if($donorProfileCompletion < 80)

            <div class="sidebar-profile-warning">

                <i class="fa fa-lock mr-1"></i>

                Complete at least 80% of your profile
                to unlock donor modules.

            </div>

        @else

            <div class="sidebar-profile-complete">

                <i class="fa fa-check-circle mr-1"></i>

                Donor modules unlocked.

            </div>

        @endif

    </div>

</li>



{{-- =========================================================
    MY PROFILE
========================================================== --}}

<li
    class="{{
        request()->routeIs('donor.profile.*')
            ? 'mm-active'
            : ''
    }}"
>

    <a
        class="has-arrow"
        href="javascript:void(0)"
        aria-expanded="{{
            request()->routeIs('donor.profile.*')
                ? 'true'
                : 'false'
        }}"
    >

        <i class="icon-user menu-icon"></i>

        <span class="nav-text">

            My Profile

        </span>

    </a>


    <ul
        class="{{
            request()->routeIs('donor.profile.*')
                ? 'mm-show'
                : ''
        }}"
        aria-expanded="{{
            request()->routeIs('donor.profile.*')
                ? 'true'
                : 'false'
        }}"
    >


        {{-- View Profile --}}

        <li>

            <a
                href="{{ route('donor.profile.show') }}"
                class="{{
                    request()->routeIs(
                        'donor.profile.show'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                View Profile

            </a>

        </li>



        {{-- Edit Profile --}}

        <li>

            <a
                href="{{ route('donor.profile.edit') }}"
                class="{{
                    request()->routeIs(
                        'donor.profile.edit'
                    )
                        ? 'active'
                        : ''
                }}"
            >

                Edit Profile

            </a>

        </li>

    </ul>

</li>



{{-- =========================================================
    PROFILE IS 80% OR MORE
========================================================== --}}

@if($donorProfileCompletion >= 80)


    {{-- =====================================================
        MY PRODUCTS
    ====================================================== --}}

    <li
        class="{{
            request()->routeIs('donor.products.*')
                ? 'mm-active'
                : ''
        }}"
    >

        <a
            class="has-arrow"
            href="javascript:void(0)"
            aria-expanded="{{
                request()->routeIs('donor.products.*')
                    ? 'true'
                    : 'false'
            }}"
        >

            <i class="icon-bag menu-icon"></i>

            <span class="nav-text">

                My Products

            </span>

        </a>


        <ul
            class="{{
                request()->routeIs('donor.products.*')
                    ? 'mm-show'
                    : ''
            }}"
            aria-expanded="{{
                request()->routeIs('donor.products.*')
                    ? 'true'
                    : 'false'
            }}"
        >


            {{-- All Products --}}

            <li>

                <a
                    href="{{ route('donor.products.index') }}"
                    class="{{
                        request()->routeIs(
                            'donor.products.index'
                        )
                            ? 'active'
                            : ''
                    }}"
                >

                    All Products

                </a>

            </li>



            {{-- Add Product --}}

            <li>

                <a
                    href="{{ route('donor.products.create') }}"
                    class="{{
                        request()->routeIs(
                            'donor.products.create'
                        )
                            ? 'active'
                            : ''
                    }}"
                >

                    Add Product

                </a>

            </li>

        </ul>

    </li>



    {{-- =====================================================
        PRODUCT REQUESTS
    ====================================================== --}}

    <li
        class="{{
            request()->routeIs(
                'donor.product.requests.*'
            )
                ? 'active'
                : ''
        }}"
    >

        <a
            href="{{
                route(
                    'donor.product.requests.index'
                )
            }}"
            aria-expanded="false"
        >

            <i class="icon-envelope menu-icon"></i>

            <span class="nav-text">

                Product Requests

            </span>

        </a>

    </li>



@else


    {{-- =====================================================
        LOCKED PRODUCTS
    ====================================================== --}}

    <li>

        <a
            href="javascript:void(0)"
            class="sidebar-locked-link"
            aria-disabled="true"
            title="Complete at least 80% of your profile to unlock this module."
        >

            <i class="icon-bag menu-icon"></i>

            <span class="nav-text">

                My Products

                <i
                    class="fa fa-lock sidebar-lock-icon"
                ></i>

            </span>

        </a>


        <small class="sidebar-lock-message">

            Complete profile to 80%

        </small>

    </li>



    {{-- =====================================================
        LOCKED REQUESTS
    ====================================================== --}}

    <li>

        <a
            href="javascript:void(0)"
            class="sidebar-locked-link"
            aria-disabled="true"
            title="Complete at least 80% of your profile to unlock this module."
        >

            <i class="icon-envelope menu-icon"></i>

            <span class="nav-text">

                Product Requests

                <i
                    class="fa fa-lock sidebar-lock-icon"
                ></i>

            </span>

        </a>


        <small class="sidebar-lock-message">

            Complete profile to 80%

        </small>

    </li>


@endif
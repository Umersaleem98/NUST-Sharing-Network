{{-- =========================================================
    BENEFICIARY SIDEBAR
========================================================== --}}

<li class="nav-label">

    Beneficiary

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

                {{ $beneficiaryProfileCompletion }}%

            </span>

        </div>


        <div class="sidebar-profile-progress">

            <div
                class="sidebar-profile-progress-bar"
                style="
                    width:
                    {{ min($beneficiaryProfileCompletion, 100) }}%;
                "
            ></div>

        </div>


        @if($beneficiaryProfileCompletion < 80)

            <div class="sidebar-profile-warning">

                <i class="fa fa-lock mr-1"></i>

                Complete at least 80% of your profile
                to unlock beneficiary modules.

            </div>

        @else

            <div class="sidebar-profile-complete">

                <i class="fa fa-check-circle mr-1"></i>

                Beneficiary modules unlocked.

            </div>

        @endif

    </div>

</li>



{{-- =========================================================
    MY PROFILE
========================================================== --}}

<li
    class="{{
        request()->routeIs('beneficiary.profile.*')
            ? 'mm-active'
            : ''
    }}"
>

    <a
        class="has-arrow"
        href="javascript:void(0)"
        aria-expanded="{{
            request()->routeIs('beneficiary.profile.*')
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
            request()->routeIs('beneficiary.profile.*')
                ? 'mm-show'
                : ''
        }}"
        aria-expanded="{{
            request()->routeIs('beneficiary.profile.*')
                ? 'true'
                : 'false'
        }}"
    >


        {{-- View Profile --}}

        <li>

            <a
                href="{{
                    route(
                        'beneficiary.profile.index'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'beneficiary.profile.index'
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
                href="{{
                    route(
                        'beneficiary.profile.edit'
                    )
                }}"
                class="{{
                    request()->routeIs(
                        'beneficiary.profile.edit'
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

@if($beneficiaryProfileCompletion >= 80)


    {{-- =====================================================
        PRODUCTS
    ====================================================== --}}

    <li
        class="{{
            request()->routeIs('beneficiary.products.*') ||
            request()->routeIs('beneficiary.requests.*')
                ? 'mm-active'
                : ''
        }}"
    >

        <a
            class="has-arrow"
            href="javascript:void(0)"
            aria-expanded="{{
                request()->routeIs('beneficiary.products.*') ||
                request()->routeIs('beneficiary.requests.*')
                    ? 'true'
                    : 'false'
            }}"
        >

            <i class="icon-bag menu-icon"></i>

            <span class="nav-text">

                Products

            </span>

        </a>


        <ul
            class="{{
                request()->routeIs('beneficiary.products.*') ||
                request()->routeIs('beneficiary.requests.*')
                    ? 'mm-show'
                    : ''
            }}"
            aria-expanded="{{
                request()->routeIs('beneficiary.products.*') ||
                request()->routeIs('beneficiary.requests.*')
                    ? 'true'
                    : 'false'
            }}"
        >


            {{-- Browse Products --}}

            <li>

                <a
                    href="{{
                        route(
                            'beneficiary.products.index'
                        )
                    }}"
                    class="{{
                        request()->routeIs(
                            'beneficiary.products.index'
                        )
                            ? 'active'
                            : ''
                    }}"
                >

                    Browse Products

                </a>

            </li>



            {{-- My Requests --}}

            <li>

                <a
                    href="{{
                        route(
                            'beneficiary.requests.index'
                        )
                    }}"
                    class="{{
                        request()->routeIs(
                            'beneficiary.requests.*'
                        )
                            ? 'active'
                            : ''
                    }}"
                >

                    My Requests

                </a>

            </li>

        </ul>

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

                Products

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
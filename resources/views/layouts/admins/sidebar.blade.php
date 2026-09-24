<!--**********************************
    Sidebar Start
***********************************-->

@php

    $sidebarUser = auth()->user();

    $donorProfileCompletion = 0;
    $beneficiaryProfileCompletion = 0;


    /*
    |--------------------------------------------------------------------------
    | Donor Profile Completion
    |--------------------------------------------------------------------------
    */

    if (
        $sidebarUser &&
        $sidebarUser->role === 'donor'
    ) {

        $donorProfile = $sidebarUser->donorProfile;


        $donorProfileFields = [

            $sidebarUser->name,
            $sidebarUser->email,

            $donorProfile?->phone,
            $donorProfile?->organization,
            $donorProfile?->designation,
            $donorProfile?->country,
            $donorProfile?->state,
            $donorProfile?->city,
            $donorProfile?->profile_image,

        ];


        $completedDonorFields =
            collect($donorProfileFields)
                ->filter(function ($value) {

                    return
                        $value !== null &&
                        $value !== '';

                })
                ->count();


        $donorProfileCompletion =
            count($donorProfileFields) > 0
                ? (int) round(
                    (
                        $completedDonorFields /
                        count($donorProfileFields)
                    ) * 100
                )
                : 0;
    }


    /*
    |--------------------------------------------------------------------------
    | Beneficiary Profile Completion
    |--------------------------------------------------------------------------
    */

    if (
        $sidebarUser &&
        $sidebarUser->role === 'beneficiary'
    ) {

        $beneficiaryProfile =
            $sidebarUser->beneficiaryProfile;


        $beneficiaryProfileFields = [

            $sidebarUser->name,
            $sidebarUser->email,
            $sidebarUser->qalam_id,

            $beneficiaryProfile?->phone,
            $beneficiaryProfile?->gender,
            $beneficiaryProfile?->institution,
            $beneficiaryProfile?->degree,
            $beneficiaryProfile?->enrollment_year,
            $beneficiaryProfile?->graduation_year,
            $beneficiaryProfile?->father_status,
            $beneficiaryProfile?->guardian_profession,
            $beneficiaryProfile?->monthly_income,
            $beneficiaryProfile?->province,
            $beneficiaryProfile?->domicile,
            $beneficiaryProfile?->home_address,
            $beneficiaryProfile?->profile_image,

        ];


        $completedBeneficiaryFields =
            collect($beneficiaryProfileFields)
                ->filter(function ($value) {

                    return
                        $value !== null &&
                        $value !== '';

                })
                ->count();


        $beneficiaryProfileCompletion =
            count($beneficiaryProfileFields) > 0
                ? (int) round(
                    (
                        $completedBeneficiaryFields /
                        count($beneficiaryProfileFields)
                    ) * 100
                )
                : 0;
    }

@endphp


<div class="nk-sidebar">

    <div class="nk-nav-scroll">

        <ul
            class="metismenu"
            id="menu"
        >


            {{-- =========================================================
                DASHBOARD
            ========================================================== --}}

            <li class="nav-label">
                Dashboard
            </li>


            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <a
                    href="{{ route('dashboard') }}"
                    aria-expanded="false"
                >

                    <i class="icon-speedometer menu-icon"></i>

                    <span class="nav-text">
                        Dashboard
                    </span>

                </a>

            </li>



            {{-- =========================================================
                ROLE BASED MENU
            ========================================================== --}}

            @auth


                {{-- =====================================================
                    ADMIN
                ====================================================== --}}

                @if($sidebarUser->role === 'admin')

                    @include(
                        'layouts.admins.components.adminSidebar'
                    )

                @endif



                {{-- =====================================================
                    DONOR
                ====================================================== --}}

                @if($sidebarUser->role === 'donor')

                    @include(
                        'layouts.admins.components.donorSidebar',
                        [
                            'donorProfileCompletion' =>
                                $donorProfileCompletion
                        ]
                    )

                @endif



                {{-- =====================================================
                    BENEFICIARY
                ====================================================== --}}

                @if($sidebarUser->role === 'beneficiary')

                    @include(
                        'layouts.admins.components.beneficiarySidebar',
                        [
                            'beneficiaryProfileCompletion' =>
                                $beneficiaryProfileCompletion
                        ]
                    )

                @endif



                {{-- =====================================================
                    ACCOUNT
                ====================================================== --}}

                <li class="nav-label">
                    Account
                </li>


                <li>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        class="m-0"
                    >

                        @csrf


                        <button
                            type="submit"
                            class="btn btn-link text-left w-100 sidebar-logout-button"
                        >

                            <i class="icon-logout menu-icon"></i>

                            <span class="nav-text">
                                Logout
                            </span>

                        </button>

                    </form>

                </li>


            @endauth


        </ul>

    </div>

</div>



<style>

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    .sidebar-logout-button {

        color: inherit !important;

        text-decoration: none !important;

        padding: 13px 20px !important;

        border: 0 !important;

        background: transparent !important;

        text-align: left !important;

        box-shadow: none !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Profile Completion
    |--------------------------------------------------------------------------
    */

    .sidebar-profile-completion {

        margin: 8px 15px 16px;

        padding: 12px 13px;

        border-radius: 8px;

        background:
            rgba(
                0,
                85,
                140,
                0.08
            );

        border:
            1px solid
            rgba(
                0,
                85,
                140,
                0.13
            );
    }


    .sidebar-profile-completion-header {

        display: flex;

        align-items: center;

        justify-content: space-between;

        margin-bottom: 7px;

        font-size: 11px;

        font-weight: 600;

        color: #555;
    }


    .sidebar-profile-completion-percent {

        color: #00558c;

        font-weight: 700;
    }


    .sidebar-profile-progress {

        width: 100%;

        height: 6px;

        overflow: hidden;

        border-radius: 20px;

        background: #dde7ed;
    }


    .sidebar-profile-progress-bar {

        height: 100%;

        border-radius: 20px;

        background: #00558c;

        transition: width 0.3s ease;
    }


    .sidebar-profile-warning {

        margin-top: 7px;

        color: #a47400;

        font-size: 10px;

        line-height: 1.5;
    }


    .sidebar-profile-complete {

        margin-top: 7px;

        color: #198754;

        font-size: 10px;

        line-height: 1.5;
    }


    /*
    |--------------------------------------------------------------------------
    | Locked Menu
    |--------------------------------------------------------------------------
    */

    .sidebar-locked-link {

        opacity: 0.50 !important;

        cursor: not-allowed !important;

        pointer-events: none !important;
    }


    .sidebar-lock-icon {

        float: right;

        margin-top: 4px;

        font-size: 11px;
    }


    .sidebar-lock-message {

        display: block;

        padding:
            3px
            20px
            10px
            52px;

        color: #9b7b34;

        font-size: 10px;

        line-height: 1.4;
    }


    /*
    |--------------------------------------------------------------------------
    | MetisMenu Fix
    |--------------------------------------------------------------------------
    |
    | All submenus remain hidden unless MetisMenu adds mm-show.
    |
    */

    #menu .mm-collapse:not(.mm-show) {

        display: none;
    }


    #menu .mm-collapse.mm-show {

        display: block;
    }

</style>

<!--**********************************
    Sidebar End
***********************************-->
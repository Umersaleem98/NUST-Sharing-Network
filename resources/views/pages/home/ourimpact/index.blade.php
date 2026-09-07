@include('layouts.home.head')

<title>Our Impact | NUST Sharing Network</title>

<style>

    /* =========================================================
       NUST SHARING NETWORK - OUR IMPACT
    ========================================================= */

    :root {
        --impact-primary: #123b60;
        --impact-primary-dark: #082944;
        --impact-primary-light: #1c527c;

        --impact-gold: #fabc4d;
        --impact-gold-dark: #d99b24;

        --impact-white: #ffffff;

        --impact-light: #f6f8fb;
        --impact-border: #e3e9ef;

        --impact-text: #25384b;
        --impact-muted: #6f7f90;

        --impact-success: #2e8b66;
    }


    html {
        scroll-behavior: smooth;
    }


    body {
        background: var(--impact-white);
        color: var(--impact-text);
    }



    /* =========================================================
       PAGE HEADER
    ========================================================= */

    .impact-page-header {
        position: relative;

        min-height: 330px;

        display: flex;
        align-items: center;

        overflow: hidden;

        isolation: isolate;

        background:
            linear-gradient(
                90deg,
                rgba(5, 30, 51, .97) 0%,
                rgba(8, 41, 68, .94) 42%,
                rgba(18, 59, 96, .86) 72%,
                rgba(18, 59, 96, .72) 100%
            ),
            url('{{ asset("templates/assets/sliders/slider2.png") }}');

        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }


    .impact-page-header::before {
        content: "";

        position: absolute;

        width: 420px;
        height: 420px;

        right: -160px;
        top: -210px;

        z-index: -1;

        border:
            65px solid
            rgba(250, 188, 77, .08);

        border-radius: 50%;
    }


    .impact-page-header::after {
        content: "";

        position: absolute;

        width: 260px;
        height: 260px;

        left: -120px;
        bottom: -180px;

        z-index: -1;

        border-radius: 50%;

        background:
            rgba(250, 188, 77, .06);
    }


    .impact-header-shape {
        position: absolute;

        width: 115px;
        height: 115px;

        right: 11%;
        bottom: 45px;

        z-index: -1;

        border:
            1px solid
            rgba(255, 255, 255, .08);

        border-radius: 28px;

        background:
            rgba(255, 255, 255, .03);

        transform: rotate(25deg);

        backdrop-filter: blur(5px);
    }


    .impact-header-content {
        position: relative;

        z-index: 3;

        max-width: 800px;

        padding: 52px 0;
    }


    /* =========================================================
       HEADER NAVIGATION
    ========================================================= */

    .impact-header-nav {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 16px;

        margin-bottom: 20px;
    }


    .impact-back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 9px 17px;

        border:
            1px solid
            rgba(255, 255, 255, .18);

        border-radius: 50px;

        background:
            rgba(255, 255, 255, .07);

        color:
            rgba(255, 255, 255, .90);

        text-decoration: none;

        font-size: 12px;
        font-weight: 700;

        transition: .3s ease;
    }


    .impact-back-btn:hover {
        border-color:
            var(--impact-gold);

        background:
            var(--impact-gold);

        color:
            var(--impact-primary-dark);

        transform:
            translateX(-3px);
    }


    .impact-breadcrumb {
        display: inline-flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 8px;

        font-size: 12px;
    }


    .impact-breadcrumb a {
        color:
            rgba(255, 255, 255, .60);

        text-decoration: none;

        transition: .3s ease;
    }


    .impact-breadcrumb a:hover {
        color:
            var(--impact-gold);
    }


    .impact-breadcrumb-divider {
        color:
            rgba(255, 255, 255, .35);
    }


    .impact-breadcrumb-current {
        color:
            rgba(255, 255, 255, .90);
    }


    /* =========================================================
       HEADER CONTENT
    ========================================================= */

    .impact-header-label {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 13px;

        padding: 7px 13px;

        border:
            1px solid
            rgba(250, 188, 77, .22);

        border-radius: 50px;

        background:
            rgba(250, 188, 77, .09);

        color:
            var(--impact-gold);

        font-size: 10px;
        font-weight: 800;

        letter-spacing: 1.6px;

        text-transform: uppercase;
    }


    .impact-page-header h1 {
        margin-bottom: 14px;

        color:
            var(--impact-white);

        font-size:
            clamp(36px, 5vw, 52px);

        font-weight: 800;

        line-height: 1.1;

        letter-spacing: -.7px;
    }


    .impact-page-header h1 span {
        position: relative;

        color:
            var(--impact-gold);
    }


    .impact-page-header h1 span::after {
        content: "";

        position: absolute;

        left: 1px;
        bottom: -6px;

        width: 70%;
        height: 3px;

        border-radius: 50px;

        background:
            var(--impact-gold);
    }


    .impact-page-header p {
        max-width: 650px;

        margin: 0;

        color:
            rgba(255, 255, 255, .74);

        font-size: 15px;

        line-height: 1.8;
    }


    .impact-header-highlights {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 20px;

        margin-top: 22px;
    }


    .impact-header-highlight {
        display: flex;
        align-items: center;

        gap: 8px;

        color:
            rgba(255, 255, 255, .67);

        font-size: 12px;
    }


    .impact-header-highlight i {
        width: 29px;
        height: 29px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background:
            rgba(250, 188, 77, .12);

        color:
            var(--impact-gold);

        font-size: 11px;
    }



    /* =========================================================
       COMMON SECTIONS
    ========================================================= */

    .impact-section {
        padding: 85px 0;
    }


    .impact-section-light {
        background:
            var(--impact-light);
    }


    .impact-section-heading {
        max-width: 720px;

        margin:
            0 auto 42px;

        text-align:
            center;
    }


    .impact-section-label {
        display: inline-block;

        margin-bottom: 9px;

        color:
            var(--impact-gold-dark);

        font-size: 11px;
        font-weight: 800;

        letter-spacing: 1.6px;

        text-transform: uppercase;
    }


    .impact-section-heading h2,
    .impact-content-title {
        color:
            var(--impact-primary);

        font-size:
            clamp(28px, 4vw, 39px);

        font-weight: 800;

        line-height: 1.2;
    }


    .impact-section-heading p {
        max-width: 630px;

        margin:
            13px auto 0;

        color:
            var(--impact-muted);

        font-size: 14px;

        line-height: 1.8;
    }



    /* =========================================================
       INTRODUCTION
    ========================================================= */

    .impact-intro-image {
        position: relative;

        min-height: 430px;

        overflow: hidden;

        border-radius: 22px;

        background:
            linear-gradient(
                rgba(8, 41, 68, .08),
                rgba(8, 41, 68, .08)
            ),
            url('{{ asset("templates/assets/sliders/slider2.png") }}');

        background-size: cover;
        background-position: center;

        box-shadow:
            0 20px 50px
            rgba(18, 59, 96, .12);
    }


    .impact-intro-image::before {
        content: "";

        position: absolute;

        width: 130px;
        height: 130px;

        right: -40px;
        bottom: -40px;

        border-radius: 50%;

        background:
            var(--impact-gold);
    }


    .impact-intro-content {
        padding-left: 25px;
    }


    .impact-intro-content p {
        margin-bottom: 18px;

        color:
            var(--impact-muted);

        font-size: 15px;

        line-height: 1.85;
    }


    .impact-mini-features {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 13px;

        margin-top: 25px;
    }


    .impact-mini-feature {
        display: flex;
        align-items: center;

        gap: 11px;

        padding: 14px;

        border:
            1px solid
            var(--impact-border);

        border-radius: 13px;

        background:
            var(--impact-white);
    }


    .impact-mini-feature i {
        width: 38px;
        height: 38px;

        flex: 0 0 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background:
            rgba(250, 188, 77, .17);

        color:
            var(--impact-primary);

        font-size: 14px;
    }


    .impact-mini-feature span {
        color:
            var(--impact-primary);

        font-size: 13px;

        font-weight: 700;
    }



    /* =========================================================
       PRIMARY STATISTICS
    ========================================================= */

    .impact-stat-card {
        position: relative;

        height: 100%;

        overflow: hidden;

        padding: 30px 27px;

        border:
            1px solid
            var(--impact-border);

        border-radius: 18px;

        background:
            var(--impact-white);

        transition:
            all .35s ease;
    }


    .impact-stat-card::before {
        content: "";

        position: absolute;

        width: 115px;
        height: 115px;

        right: -45px;
        top: -50px;

        border-radius: 50%;

        background:
            rgba(250, 188, 77, .13);
    }


    .impact-stat-card:hover {
        transform:
            translateY(-7px);

        border-color:
            rgba(250, 188, 77, .75);

        box-shadow:
            0 20px 40px
            rgba(18, 59, 96, .09);
    }


    .impact-stat-icon {
        position: relative;

        z-index: 2;

        width: 52px;
        height: 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 22px;

        border-radius: 14px;

        background:
            var(--impact-primary);

        color:
            var(--impact-gold);

        font-size: 19px;
    }


    .impact-stat-number {
        position: relative;

        z-index: 2;

        display: block;

        margin-bottom: 8px;

        color:
            var(--impact-primary);

        font-size: 38px;

        font-weight: 800;

        line-height: 1;
    }


    .impact-stat-title {
        position: relative;

        z-index: 2;

        display: block;

        margin-bottom: 7px;

        color:
            var(--impact-text);

        font-size: 15px;

        font-weight: 750;
    }


    .impact-stat-description {
        position: relative;

        z-index: 2;

        margin: 0;

        color:
            var(--impact-muted);

        font-size: 13px;

        line-height: 1.65;
    }



    /* =========================================================
       PARTICIPATION SUMMARY
    ========================================================= */

    .impact-summary-wrapper {
        overflow: hidden;

        border-radius: 22px;

        background:
            linear-gradient(
                135deg,
                var(--impact-primary-dark),
                var(--impact-primary)
            );

        box-shadow:
            0 20px 50px
            rgba(18, 59, 96, .15);
    }


    .impact-summary-content {
        height: 100%;

        padding: 45px 40px;
    }


    .impact-summary-content .impact-section-label {
        color:
            var(--impact-gold);
    }


    .impact-summary-content h2 {
        margin-bottom: 15px;

        color:
            var(--impact-white);

        font-size:
            clamp(28px, 4vw, 38px);

        font-weight: 800;

        line-height: 1.2;
    }


    .impact-summary-content > p {
        margin-bottom: 0;

        color:
            rgba(255, 255, 255, .70);

        font-size: 14px;

        line-height: 1.8;
    }


    .impact-summary-stats {
        height: 100%;

        padding: 30px;

        background:
            rgba(255, 255, 255, .055);
    }


    .impact-summary-item {
        height: 100%;

        padding: 22px;

        border:
            1px solid
            rgba(255, 255, 255, .10);

        border-radius: 15px;

        background:
            rgba(255, 255, 255, .06);
    }


    .impact-summary-icon {
        width: 42px;
        height: 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 15px;

        border-radius: 11px;

        background:
            var(--impact-gold);

        color:
            var(--impact-primary-dark);

        font-size: 16px;
    }


    .impact-summary-number {
        display: block;

        margin-bottom: 5px;

        color:
            var(--impact-white);

        font-size: 31px;

        font-weight: 800;

        line-height: 1;
    }


    .impact-summary-title {
        color:
            var(--impact-gold);

        font-size: 13px;

        font-weight: 700;
    }



    /* =========================================================
       IMPACT AREAS
    ========================================================= */

    .impact-area-card {
        height: 100%;

        padding: 30px 27px;

        border:
            1px solid
            var(--impact-border);

        border-radius: 17px;

        background:
            var(--impact-white);

        transition:
            .35s ease;
    }


    .impact-area-card:hover {
        transform:
            translateY(-6px);

        border-color:
            var(--impact-gold);

        box-shadow:
            0 18px 38px
            rgba(18, 59, 96, .08);
    }


    .impact-area-icon {
        width: 54px;
        height: 54px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 20px;

        border-radius: 14px;

        background:
            rgba(250, 188, 77, .17);

        color:
            var(--impact-primary);

        font-size: 20px;
    }


    .impact-area-card h5 {
        margin-bottom: 10px;

        color:
            var(--impact-primary);

        font-size: 17px;

        font-weight: 750;
    }


    .impact-area-card p {
        margin: 0;

        color:
            var(--impact-muted);

        font-size: 13px;

        line-height: 1.75;
    }



    /* =========================================================
       FINAL CTA
    ========================================================= */

    .impact-cta-section {
        padding: 80px 0;

        background:
            var(--impact-white);
    }


    .impact-cta-box {
        position: relative;

        overflow: hidden;

        padding: 52px 45px;

        border-radius: 24px;

        background:
            var(--impact-gold);
    }


    .impact-cta-box::before {
        content: "";

        position: absolute;

        width: 230px;
        height: 230px;

        left: -130px;
        top: -140px;

        border:
            40px solid
            rgba(18, 59, 96, .07);

        border-radius: 50%;
    }


    .impact-cta-box::after {
        content: "";

        position: absolute;

        width: 300px;
        height: 300px;

        right: -130px;
        bottom: -180px;

        border:
            50px solid
            rgba(18, 59, 96, .08);

        border-radius: 50%;
    }


    .impact-cta-content,
    .impact-cta-action {
        position: relative;

        z-index: 2;
    }


    .impact-cta-label {
        display: inline-block;

        margin-bottom: 8px;

        color:
            var(--impact-primary);

        font-size: 11px;

        font-weight: 800;

        letter-spacing: 1.5px;

        text-transform: uppercase;
    }


    .impact-cta-box h2 {
        margin-bottom: 11px;

        color:
            var(--impact-primary-dark);

        font-size:
            clamp(27px, 4vw, 38px);

        font-weight: 800;
    }


    .impact-cta-box p {
        max-width: 650px;

        margin: 0;

        color:
            rgba(8, 41, 68, .76);

        font-size: 14px;

        line-height: 1.8;
    }


    .impact-cta-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 13px 26px;

        border-radius: 50px;

        background:
            var(--impact-primary);

        color:
            var(--impact-white);

        text-decoration: none;

        font-size: 14px;

        font-weight: 700;

        transition:
            .3s ease;
    }


    .impact-cta-btn:hover {
        background:
            var(--impact-primary-dark);

        color:
            var(--impact-gold);

        transform:
            translateY(-2px);
    }



    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .impact-page-header {
            min-height: 300px;
        }


        .impact-section {
            padding: 70px 0;
        }


        .impact-intro-content {
            margin-top: 38px;

            padding-left: 0;
        }


        .impact-intro-image {
            min-height: 370px;
        }


        .impact-summary-content {
            padding: 38px 32px;
        }


        .impact-cta-section {
            padding: 65px 0;
        }


        .impact-cta-box {
            padding: 42px 35px;
        }

    }


    @media (max-width: 767.98px) {

        .impact-page-header {
            min-height: 280px;
        }


        .impact-header-content {
            padding: 38px 0;
        }


        .impact-page-header h1 {
            font-size: 33px;
        }


        .impact-section {
            padding: 58px 0;
        }


        .impact-section-heading {
            margin-bottom: 34px;
        }


        .impact-mini-features {
            grid-template-columns: 1fr;
        }


        .impact-intro-image {
            min-height: 320px;
        }


        .impact-summary-content {
            padding: 32px 25px;
        }


        .impact-summary-stats {
            padding: 25px;
        }


        .impact-cta-box {
            padding: 38px 26px;

            text-align: center;
        }


        .impact-cta-box p {
            margin: 0 auto;
        }


        .impact-cta-action {
            margin-top: 22px;

            text-align: center !important;
        }

    }


    @media (max-width: 575.98px) {

        .impact-header-nav {
            flex-direction: column;
            align-items: flex-start;

            gap: 10px;
        }


        .impact-page-header h1 {
            font-size: 29px;
        }


        .impact-page-header p {
            font-size: 14px;
        }


        .impact-header-highlights {
            flex-direction: column;
            align-items: flex-start;

            gap: 9px;
        }


        .impact-section-heading h2,
        .impact-content-title {
            font-size: 27px;
        }


        .impact-cta-btn {
            width: 100%;
        }

    }

</style>


<body>


{{-- @include('layouts.home.preloader') --}}

@include('layouts.home.header')



{{-- ============================================================
     PAGE HEADER
============================================================ --}}

<section class="impact-page-header">

    <span class="impact-header-shape"></span>


    <div class="container">

        <div class="impact-header-content">


            {{-- NAVIGATION --}}
            <div class="impact-header-nav">

                <a
                    href="javascript:history.back()"
                    class="impact-back-btn"
                >

                    <i class="fas fa-arrow-left"></i>

                    Back

                </a>


                <div class="impact-breadcrumb">

                    <a href="{{ url('/') }}">
                        Home
                    </a>

                    <span class="impact-breadcrumb-divider">
                        /
                    </span>

                    <span class="impact-breadcrumb-current">
                        Our Impact
                    </span>

                </div>

            </div>



            {{-- LABEL --}}
            <span class="impact-header-label">

                <i class="fas fa-chart-line"></i>

                NUST Sharing Network

            </span>


            {{-- TITLE --}}
            <h1>

                Our

                <span>Impact</span>

            </h1>


            {{-- DESCRIPTION --}}
            <p>

                Discover how the NUST Sharing Network is building
                a connected community of donors and beneficiaries
                around responsible educational support.

            </p>


            {{-- HIGHLIGHTS --}}
            <div class="impact-header-highlights">


                <div class="impact-header-highlight">

                    <i class="fas fa-users"></i>

                    Community Driven

                </div>


                <div class="impact-header-highlight">

                    <i class="fas fa-user-check"></i>

                    Verified Participation

                </div>


                <div class="impact-header-highlight">

                    <i class="fas fa-hand-holding-heart"></i>

                    Educational Support

                </div>


            </div>


        </div>

    </div>

</section>



{{-- ============================================================
     INTRODUCTION
============================================================ --}}

<section class="impact-section">

    <div class="container">


        <div class="row align-items-center g-5">


            {{-- IMAGE --}}
            <div class="col-lg-6">

                <div class="impact-intro-image"></div>

            </div>


            {{-- CONTENT --}}
            <div class="col-lg-6">

                <div class="impact-intro-content">


                    <span class="impact-section-label">
                        Why It Matters
                    </span>


                    <h2 class="impact-content-title mb-3">

                        Sharing Resources.
                        Supporting Students.

                    </h2>


                    <p>

                        NUST Sharing Network connects available
                        educational resources with genuine student
                        needs through a structured digital platform.

                    </p>


                    <p>

                        The goal is simple: encourage responsible
                        sharing while making participation more
                        transparent, accessible and meaningful.

                    </p>


                    <div class="impact-mini-features">


                        <div class="impact-mini-feature">

                            <i class="fas fa-hand-holding-heart"></i>

                            <span>
                                Responsible Giving
                            </span>

                        </div>


                        <div class="impact-mini-feature">

                            <i class="fas fa-user-graduate"></i>

                            <span>
                                Student Support
                            </span>

                        </div>


                        <div class="impact-mini-feature">

                            <i class="fas fa-shield-alt"></i>

                            <span>
                                Structured Participation
                            </span>

                        </div>


                        <div class="impact-mini-feature">

                            <i class="fas fa-users"></i>

                            <span>
                                Community Connection
                            </span>

                        </div>


                    </div>


                </div>

            </div>


        </div>


    </div>

</section>



{{-- ============================================================
     COMMUNITY STATISTICS
============================================================ --}}

<section class="impact-section impact-section-light">

    <div class="container">


        <div class="impact-section-heading">

            <span class="impact-section-label">
                Community in Numbers
            </span>


            <h2>
                Growing Together Through Sharing
            </h2>


            <p>

                A snapshot of the registered community currently
                participating in the NUST Sharing Network.

            </p>

        </div>



        <div class="row g-4">


            {{-- TOTAL USERS --}}
            <div class="col-lg-4 col-md-6">

                <div class="impact-stat-card">


                    <div class="impact-stat-icon">

                        <i class="fas fa-users"></i>

                    </div>


                    <span
                        class="impact-stat-number impact-counter"
                        data-target="{{ $totalUsers ?? 0 }}"
                    >
                        0
                    </span>


                    <span class="impact-stat-title">
                        Registered Users
                    </span>


                    <p class="impact-stat-description">

                        Total registered participants across
                        the Sharing Network.

                    </p>


                </div>

            </div>



            {{-- DONORS --}}
            <div class="col-lg-4 col-md-6">

                <div class="impact-stat-card">


                    <div class="impact-stat-icon">

                        <i class="fas fa-hand-holding-heart"></i>

                    </div>


                    <span
                        class="impact-stat-number impact-counter"
                        data-target="{{ $totalDonors ?? 0 }}"
                    >
                        0
                    </span>


                    <span class="impact-stat-title">
                        Registered Donors
                    </span>


                    <p class="impact-stat-description">

                        Members participating as donors within
                        the platform.

                    </p>


                </div>

            </div>



            {{-- BENEFICIARIES --}}
            <div class="col-lg-4 col-md-6">

                <div class="impact-stat-card">


                    <div class="impact-stat-icon">

                        <i class="fas fa-user-graduate"></i>

                    </div>


                    <span
                        class="impact-stat-number impact-counter"
                        data-target="{{ $totalBeneficiaries ?? 0 }}"
                    >
                        0
                    </span>


                    <span class="impact-stat-title">
                        Beneficiaries
                    </span>


                    <p class="impact-stat-description">

                        Students registered to participate as
                        beneficiaries.

                    </p>


                </div>

            </div>


        </div>


    </div>

</section>



{{-- ============================================================
     ACTIVE & VERIFIED COMMUNITY
============================================================ --}}

<section class="impact-section">

    <div class="container">


        <div class="impact-summary-wrapper">


            <div class="row g-0 align-items-stretch">


                {{-- CONTENT --}}
                <div class="col-lg-5">

                    <div class="impact-summary-content">


                        <span class="impact-section-label">
                            Active Community
                        </span>


                        <h2>

                            Participation Built on
                            Active & Verified Accounts

                        </h2>


                        <p>

                            Account status and email verification
                            help strengthen responsible participation
                            across the Sharing Network.

                        </p>


                    </div>

                </div>



                {{-- STATISTICS --}}
                <div class="col-lg-7">

                    <div class="impact-summary-stats">


                        <div class="row g-3">


                            {{-- ACTIVE USERS --}}
                            <div class="col-md-6">

                                <div class="impact-summary-item">


                                    <div class="impact-summary-icon">

                                        <i class="fas fa-user-check"></i>

                                    </div>


                                    <span
                                        class="impact-summary-number impact-counter"
                                        data-target="{{ $activeUsers ?? 0 }}"
                                    >
                                        0
                                    </span>


                                    <span class="impact-summary-title">
                                        Active Users
                                    </span>


                                </div>

                            </div>



                            {{-- VERIFIED --}}
                            <div class="col-md-6">

                                <div class="impact-summary-item">


                                    <div class="impact-summary-icon">

                                        <i class="fas fa-envelope-open-text"></i>

                                    </div>


                                    <span
                                        class="impact-summary-number impact-counter"
                                        data-target="{{ $verifiedUsers ?? 0 }}"
                                    >
                                        0
                                    </span>


                                    <span class="impact-summary-title">
                                        Verified Accounts
                                    </span>


                                </div>

                            </div>



                            {{-- ACTIVE DONORS --}}
                            <div class="col-md-6">

                                <div class="impact-summary-item">


                                    <div class="impact-summary-icon">

                                        <i class="fas fa-hands-helping"></i>

                                    </div>


                                    <span
                                        class="impact-summary-number impact-counter"
                                        data-target="{{ $activeDonors ?? 0 }}"
                                    >
                                        0
                                    </span>


                                    <span class="impact-summary-title">
                                        Active Donors
                                    </span>


                                </div>

                            </div>



                            {{-- ACTIVE BENEFICIARIES --}}
                            <div class="col-md-6">

                                <div class="impact-summary-item">


                                    <div class="impact-summary-icon">

                                        <i class="fas fa-graduation-cap"></i>

                                    </div>


                                    <span
                                        class="impact-summary-number impact-counter"
                                        data-target="{{ $activeBeneficiaries ?? 0 }}"
                                    >
                                        0
                                    </span>


                                    <span class="impact-summary-title">
                                        Active Beneficiaries
                                    </span>


                                </div>

                            </div>


                        </div>


                    </div>

                </div>


            </div>


        </div>


    </div>

</section>



{{-- ============================================================
     AREAS OF IMPACT
============================================================ --}}

<section class="impact-section impact-section-light">

    <div class="container">


        <div class="impact-section-heading">


            <span class="impact-section-label">
                Areas of Impact
            </span>


            <h2>
                Creating Value Beyond Resource Sharing
            </h2>


            <p>

                The network supports access, participation and
                responsible reuse while strengthening the connection
                between the wider community and students.

            </p>


        </div>



        <div class="row g-4">


            {{-- EDUCATIONAL ACCESS --}}
            <div class="col-lg-3 col-md-6">

                <div class="impact-area-card">


                    <div class="impact-area-icon">

                        <i class="fas fa-book-open"></i>

                    </div>


                    <h5>
                        Educational Access
                    </h5>


                    <p>

                        Helping connect students with useful
                        academic and educational resources.

                    </p>


                </div>

            </div>



            {{-- STUDENT SUPPORT --}}
            <div class="col-lg-3 col-md-6">

                <div class="impact-area-card">


                    <div class="impact-area-icon">

                        <i class="fas fa-user-graduate"></i>

                    </div>


                    <h5>
                        Student Support
                    </h5>


                    <p>

                        Building a structured platform around
                        genuine educational needs.

                    </p>


                </div>

            </div>



            {{-- COMMUNITY --}}
            <div class="col-lg-3 col-md-6">

                <div class="impact-area-card">


                    <div class="impact-area-icon">

                        <i class="fas fa-users"></i>

                    </div>


                    <h5>
                        Community Engagement
                    </h5>


                    <p>

                        Encouraging donors and students to participate
                        in a responsible sharing ecosystem.

                    </p>


                </div>

            </div>



            {{-- RESPONSIBLE REUSE --}}
            <div class="col-lg-3 col-md-6">

                <div class="impact-area-card">


                    <div class="impact-area-icon">

                        <i class="fas fa-recycle"></i>

                    </div>


                    <h5>
                        Responsible Reuse
                    </h5>


                    <p>

                        Extending the useful life of educational
                        resources through meaningful reuse.

                    </p>


                </div>

            </div>


        </div>


    </div>

</section>



{{-- ============================================================
     FINAL CTA
============================================================ --}}

<section class="impact-cta-section">

    <div class="container">


        <div class="impact-cta-box">


            <div class="row align-items-center g-4">


                {{-- CONTENT --}}
                <div class="col-lg-8">


                    <div class="impact-cta-content">


                        <span class="impact-cta-label">
                            Make an Impact
                        </span>


                        <h2>
                            Become Part of the Sharing Network
                        </h2>


                        <p>

                            Explore educational needs or join the
                            NUST Sharing Network to become part of
                            a community focused on meaningful and
                            responsible student support.

                        </p>


                    </div>


                </div>



                {{-- BUTTON --}}
                <div class="col-lg-4 text-lg-end">


                    <div class="impact-cta-action">


                        @guest

                            <a
                                href="{{ route('register') }}"
                                class="impact-cta-btn"
                            >

                                Join the Network

                                <i class="fas fa-arrow-right"></i>

                            </a>

                        @else

                            <a
                                href="{{ route('explore.needs') }}"
                                class="impact-cta-btn"
                            >

                                Explore Needs

                                <i class="fas fa-arrow-right"></i>

                            </a>

                        @endguest


                    </div>


                </div>


            </div>


        </div>


    </div>

</section>



@include('layouts.home.footer')

@include('layouts.home.script')



{{-- ============================================================
     COUNTER ANIMATION
============================================================ --}}

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const counters =
                document.querySelectorAll(
                    '.impact-counter'
                );


            if (!counters.length) {
                return;
            }


            const observer =
                new IntersectionObserver(

                    function (entries, observerInstance) {

                        entries.forEach(function (entry) {

                            if (!entry.isIntersecting) {
                                return;
                            }


                            const counter =
                                entry.target;


                            const target =
                                parseInt(
                                    counter.dataset.target
                                ) || 0;


                            const duration =
                                1200;


                            const startTime =
                                performance.now();


                            function animate(currentTime) {

                                const progress =
                                    Math.min(
                                        (
                                            currentTime -
                                            startTime
                                        ) / duration,
                                        1
                                    );


                                const currentValue =
                                    Math.floor(
                                        target * progress
                                    );


                                counter.textContent =
                                    currentValue.toLocaleString();


                                if (progress < 1) {

                                    requestAnimationFrame(
                                        animate
                                    );

                                } else {

                                    counter.textContent =
                                        target.toLocaleString();

                                }

                            }


                            requestAnimationFrame(
                                animate
                            );


                            observerInstance.unobserve(
                                counter
                            );

                        });

                    },

                    {
                        threshold: 0.25
                    }

                );


            counters.forEach(
                function (counter) {

                    observer.observe(
                        counter
                    );

                }
            );

        }
    );

</script>


</body>
@include('layouts.home.head')

<title>Explore Needs | NUST Sharing Network</title>

<style>
    /* =========================================================
       NUST SHARING NETWORK - EXPLORE NEEDS
    ========================================================= */

    :root {
        --needs-primary: #123b60;
        --needs-primary-dark: #082944;
        --needs-primary-light: #1d527c;

        --needs-gold: #fabc4d;
        --needs-gold-dark: #d99b24;

        --needs-white: #ffffff;
        --needs-light: #f6f8fb;
        --needs-border: #e3e9ef;

        --needs-text: #25384b;
        --needs-muted: #6f7e8e;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background: var(--needs-white);
        color: var(--needs-text);
    }


    /* =========================================================
       ATTRACTIVE PAGE HERO
    ========================================================= */

    .needs-hero {
        position: relative;

        min-height: 320px;

        display: flex;
        align-items: center;

        overflow: hidden;

        isolation: isolate;

        background:
            linear-gradient(
                90deg,
                rgba(5, 30, 51, .97) 0%,
                rgba(8, 41, 68, .94) 38%,
                rgba(18, 59, 96, .88) 68%,
                rgba(18, 59, 96, .76) 100%
            ),
            url('{{ asset("templates/assets/sliders/slider1.png") }}');

        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }


    /* dark overlay */
    .needs-hero::before {
        content: "";

        position: absolute;
        inset: 0;

        z-index: -3;

        background:
            linear-gradient(
                180deg,
                rgba(0, 0, 0, .05),
                rgba(0, 0, 0, .18)
            );
    }


    /* gold decorative glow */
    .needs-hero::after {
        content: "";

        position: absolute;

        width: 420px;
        height: 420px;

        right: -160px;
        top: -210px;

        z-index: -2;

        border-radius: 50%;

        border:
            70px solid
            rgba(250, 188, 77, .08);

        box-shadow:
            0 0 80px
            rgba(250, 188, 77, .05);
    }


    .needs-hero-shape-left {
        position: absolute;

        width: 260px;
        height: 260px;

        left: -130px;
        bottom: -160px;

        z-index: -1;

        border-radius: 50%;

        background:
            rgba(250, 188, 77, .06);
    }


    .needs-hero-shape-right {
        position: absolute;

        width: 110px;
        height: 110px;

        right: 9%;
        bottom: 40px;

        z-index: -1;

        border:
            1px solid
            rgba(255, 255, 255, .08);

        border-radius: 28px;

        transform: rotate(24deg);

        background:
            rgba(255, 255, 255, .025);

        backdrop-filter: blur(6px);
    }


    /* =========================================================
       HERO INNER LAYOUT
    ========================================================= */

    .needs-hero-inner {
        position: relative;
        z-index: 5;

        width: 100%;
    }


    .needs-hero-content {
        position: relative;

        max-width: 820px;

        padding: 52px 0;
    }


    .needs-hero-panel {
        position: relative;

        max-width: 760px;

        padding: 28px 30px;

        border:
            1px solid
            rgba(255, 255, 255, .10);

        border-radius: 22px;

        background:
            linear-gradient(
                135deg,
                rgba(255, 255, 255, .075),
                rgba(255, 255, 255, .025)
            );

        backdrop-filter: blur(7px);

        box-shadow:
            0 20px 55px
            rgba(0, 0, 0, .14);
    }


    .needs-hero-panel::before {
        content: "";

        position: absolute;

        top: 22px;
        left: 0;

        width: 4px;
        height: 65px;

        border-radius: 0 5px 5px 0;

        background:
            var(--needs-gold);
    }


    /* =========================================================
       HERO TOP NAV
    ========================================================= */

    .needs-hero-nav {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 16px;

        margin-bottom: 20px;
    }


    .needs-back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        min-height: 38px;

        padding: 8px 16px;

        border:
            1px solid
            rgba(255, 255, 255, .18);

        border-radius: 50px;

        background:
            rgba(255, 255, 255, .07);

        color:
            rgba(255, 255, 255, .92);

        text-decoration: none;

        font-size: 12px;
        font-weight: 700;

        transition: all .3s ease;
    }


    .needs-back-btn i {
        font-size: 11px;

        transition:
            transform .3s ease;
    }


    .needs-back-btn:hover {
        border-color:
            var(--needs-gold);

        background:
            var(--needs-gold);

        color:
            var(--needs-primary-dark);

        box-shadow:
            0 8px 20px
            rgba(250, 188, 77, .18);
    }


    .needs-back-btn:hover i {
        transform: translateX(-3px);
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .needs-breadcrumb {
        display: inline-flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 8px;

        margin: 0;

        font-size: 12px;
    }


    .needs-breadcrumb a {
        color:
            rgba(255, 255, 255, .62);

        text-decoration: none;

        transition:
            color .3s ease;
    }


    .needs-breadcrumb a:hover {
        color:
            var(--needs-gold);
    }


    .needs-breadcrumb-divider {
        color:
            rgba(255, 255, 255, .35);
    }


    .needs-breadcrumb-current {
        color:
            rgba(255, 255, 255, .88);
    }


    /* =========================================================
       HERO LABEL
    ========================================================= */

    .needs-label {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 12px;

        padding: 7px 12px;

        border:
            1px solid
            rgba(250, 188, 77, .20);

        border-radius: 50px;

        background:
            rgba(250, 188, 77, .08);

        color:
            var(--needs-gold);

        font-size: 10px;
        font-weight: 800;

        letter-spacing: 1.6px;

        text-transform: uppercase;
    }


    .needs-label i {
        font-size: 11px;
    }


    /* =========================================================
       HERO HEADING
    ========================================================= */

    .needs-hero h1 {
        margin-bottom: 13px;

        color:
            var(--needs-white);

        font-size:
            clamp(34px, 5vw, 50px);

        font-weight: 800;

        letter-spacing: -.7px;

        line-height: 1.10;
    }


    .needs-hero h1 span {
        position: relative;

        color:
            var(--needs-gold);
    }


    .needs-hero h1 span::after {
        content: "";

        position: absolute;

        left: 2px;
        bottom: -5px;

        width: 70%;
        height: 3px;

        border-radius: 50px;

        background:
            var(--needs-gold);

        opacity: .75;
    }


    .needs-hero p {
        max-width: 640px;

        margin: 0;

        color:
            rgba(255, 255, 255, .72);

        font-size: 14px;

        line-height: 1.8;
    }


    /* =========================================================
       HERO MINI INFO
    ========================================================= */

    .needs-hero-info {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 18px;

        margin-top: 20px;
    }


    .needs-hero-info-item {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        color:
            rgba(255, 255, 255, .68);

        font-size: 12px;
    }


    .needs-hero-info-item i {
        width: 27px;
        height: 27px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background:
            rgba(250, 188, 77, .12);

        color:
            var(--needs-gold);

        font-size: 10px;
    }


    /* =========================================================
       CATEGORY SECTION
    ========================================================= */

    .needs-categories-section {
        padding: 80px 0;

        background: var(--needs-light);
    }


    .needs-section-heading {
        max-width: 700px;

        margin: 0 auto 40px;

        text-align: center;
    }


    .needs-section-label {
        display: inline-block;

        margin-bottom: 8px;

        color: var(--needs-gold-dark);

        font-size: 11px;

        font-weight: 800;

        letter-spacing: 1.6px;

        text-transform: uppercase;
    }


    .needs-section-heading h2 {
        margin-bottom: 12px;

        color: var(--needs-primary);

        font-size:
            clamp(27px, 4vw, 38px);

        font-weight: 800;

        line-height: 1.2;
    }


    .needs-section-heading p {
        max-width: 620px;

        margin: auto;

        color: var(--needs-muted);

        font-size: 14px;

        line-height: 1.75;
    }


    /* =========================================================
       CATEGORY COUNT
    ========================================================= */

    .needs-category-count-wrapper {
        margin-bottom: 35px;

        text-align: center;
    }


    .needs-category-count {
        display: inline-flex;
        align-items: center;

        gap: 8px;

        padding: 9px 18px;

        border:
            1px solid
            var(--needs-border);

        border-radius: 50px;

        background:
            var(--needs-white);

        color:
            var(--needs-muted);

        font-size: 13px;

        box-shadow:
            0 7px 20px
            rgba(18, 59, 96, .04);
    }


    .needs-category-count i {
        color:
            var(--needs-gold-dark);
    }


    .needs-category-count strong {
        color:
            var(--needs-primary);
    }


    /* =========================================================
       CATEGORY CARD
    ========================================================= */

    .needs-category-card {
        position: relative;

        height: 100%;

        min-height: 225px;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        overflow: hidden;

        padding: 27px;

        border:
            1px solid
            var(--needs-border);

        border-radius: 18px;

        background:
            var(--needs-white);

        transition:
            transform .3s ease,
            box-shadow .3s ease,
            border-color .3s ease;
    }


    .needs-category-card::before {
        content: "";

        position: absolute;

        width: 140px;
        height: 140px;

        right: -80px;
        top: -80px;

        border-radius: 50%;

        background:
            rgba(250, 188, 77, .15);

        transition:
            .35s ease;
    }


    .needs-category-card:hover {
        transform:
            translateY(-7px);

        border-color:
            rgba(250, 188, 77, .85);

        box-shadow:
            0 20px 42px
            rgba(18, 59, 96, .10);
    }


    .needs-category-card:hover::before {
        transform:
            scale(1.15);
    }


    .needs-category-icon {
        position: relative;

        z-index: 2;

        width: 58px;
        height: 58px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 22px;

        border-radius: 15px;

        background:
            var(--needs-primary);

        color:
            var(--needs-gold);

        font-size: 22px;

        transition:
            all .3s ease;
    }


    .needs-category-card:hover
    .needs-category-icon {
        background:
            var(--needs-gold);

        color:
            var(--needs-primary-dark);

        transform:
            rotate(-4deg);
    }


    .needs-category-content {
        position: relative;

        z-index: 2;
    }


    .needs-category-card h4 {
        margin-bottom: 8px;

        color:
            var(--needs-primary);

        font-size: 19px;

        font-weight: 750;

        line-height: 1.35;
    }


    .needs-category-card p {
        margin: 0;

        color:
            var(--needs-muted);

        font-size: 13px;

        line-height: 1.7;
    }


    .needs-category-footer {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: center;
        justify-content: space-between;

        margin-top: 21px;

        padding-top: 15px;

        border-top:
            1px solid
            #edf0f3;
    }


    .needs-category-slug {
        max-width: 75%;

        overflow: hidden;

        color:
            #9aa6b1;

        font-size: 11px;

        text-overflow: ellipsis;

        white-space: nowrap;
    }


    .needs-category-arrow {
        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background:
            rgba(250, 188, 77, .16);

        color:
            var(--needs-primary);

        font-size: 11px;

        transition:
            .3s ease;
    }


    .needs-category-card:hover
    .needs-category-arrow {
        background:
            var(--needs-primary);

        color:
            var(--needs-gold);

        transform:
            translateX(3px);
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .needs-empty-state {
        padding: 60px 30px;

        border:
            1px dashed
            #cbd5df;

        border-radius: 18px;

        background:
            var(--needs-white);

        text-align: center;
    }


    .needs-empty-icon {
        width: 70px;
        height: 70px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin:
            0 auto 18px;

        border-radius: 50%;

        background:
            rgba(250, 188, 77, .17);

        color:
            var(--needs-primary);

        font-size: 26px;
    }


    .needs-empty-state h4 {
        margin-bottom: 8px;

        color:
            var(--needs-primary);

        font-weight: 750;
    }


    .needs-empty-state p {
        max-width: 520px;

        margin: auto;

        color:
            var(--needs-muted);

        font-size: 14px;

        line-height: 1.7;
    }


    /* =========================================================
       CTA
    ========================================================= */

    .needs-cta-section {
        padding: 75px 0;

        background:
            var(--needs-white);
    }


    .needs-cta-box {
        position: relative;

        overflow: hidden;

        padding: 48px 42px;

        border-radius: 22px;

        background:
            linear-gradient(
                135deg,
                var(--needs-primary-dark),
                var(--needs-primary)
            );
    }


    .needs-cta-box::before {
        content: "";

        position: absolute;

        width: 230px;
        height: 230px;

        right: -100px;
        top: -130px;

        border:
            40px solid
            rgba(250, 188, 77, .08);

        border-radius: 50%;
    }


    .needs-cta-content,
    .needs-cta-action {
        position: relative;

        z-index: 2;
    }


    .needs-cta-label {
        display: inline-block;

        margin-bottom: 9px;

        color:
            var(--needs-gold);

        font-size: 11px;

        font-weight: 800;

        letter-spacing: 1.5px;

        text-transform: uppercase;
    }


    .needs-cta-box h2 {
        margin-bottom: 10px;

        color:
            var(--needs-white);

        font-size:
            clamp(25px, 4vw, 34px);

        font-weight: 800;
    }


    .needs-cta-box p {
        max-width: 650px;

        margin: 0;

        color:
            rgba(255, 255, 255, .72);

        font-size: 14px;

        line-height: 1.75;
    }


    .needs-cta-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding:
            13px 25px;

        border-radius: 50px;

        background:
            var(--needs-gold);

        color:
            var(--needs-primary-dark);

        text-decoration: none;

        font-size: 14px;

        font-weight: 750;

        transition:
            .3s ease;
    }


    .needs-cta-btn:hover {
        background:
            var(--needs-white);

        color:
            var(--needs-primary);

        transform:
            translateY(-2px);
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .needs-hero {
            min-height: 300px;
        }

        .needs-hero-panel {
            max-width: 720px;
        }

        .needs-categories-section {
            padding:
                65px 0;
        }

        .needs-cta-section {
            padding:
                60px 0;
        }

        .needs-cta-box {
            padding:
                40px 32px;
        }

    }


    @media (max-width: 767.98px) {

        .needs-hero {
            min-height: 290px;
        }

        .needs-hero-content {
            padding:
                38px 0;
        }

        .needs-hero-panel {
            padding:
                24px 22px;

            border-radius:
                18px;
        }

        .needs-hero-nav {
            gap: 12px;

            margin-bottom: 17px;
        }

        .needs-hero h1 {
            font-size:
                32px;
        }

        .needs-hero p {
            font-size:
                14px;
        }

        .needs-hero-info {
            gap:
                12px;
        }

        .needs-categories-section {
            padding:
                55px 0;
        }

        .needs-section-heading {
            margin-bottom:
                32px;
        }

        .needs-category-card {
            min-height:
                auto;

            padding:
                24px;
        }

        .needs-cta-box {
            padding:
                35px 25px;

            text-align:
                center;
        }

        .needs-cta-box p {
            margin:
                0 auto;
        }

        .needs-cta-action {
            margin-top:
                22px;

            text-align:
                center !important;
        }

    }


    @media (max-width: 575.98px) {

        .needs-hero {
            min-height:
                auto;
        }

        .needs-hero-content {
            padding:
                32px 0;
        }

        .needs-hero-panel {
            padding:
                22px 18px;
        }

        .needs-hero-panel::before {
            height:
                55px;
        }

        .needs-hero-nav {
            align-items:
                flex-start;

            flex-direction:
                column;
        }

        .needs-back-btn {
            margin-bottom:
                0;
        }

        .needs-hero h1 {
            font-size:
                29px;
        }

        .needs-hero-info {
            flex-direction:
                column;

            align-items:
                flex-start;

            gap:
                9px;
        }

        .needs-section-heading h2 {
            font-size:
                27px;
        }

        .needs-category-card {
            border-radius:
                15px;
        }

        .needs-cta-btn {
            width:
                100%;
        }

    }
</style>


<body>

{{-- @include('layouts.home.preloader') --}}

@include('layouts.home.header')


{{-- ============================================================
     ATTRACTIVE HERO
============================================================ --}}

<section class="needs-hero">

    {{-- DECORATIVE SHAPES --}}
    <span class="needs-hero-shape-left"></span>
    <span class="needs-hero-shape-right"></span>


    <div class="container needs-hero-inner">

        <div class="needs-hero-content">

            <div class="needs-hero-panel">


                {{-- ==================================================
                     TOP NAVIGATION
                =================================================== --}}

                <div class="needs-hero-nav">

                    <a
                        href="javascript:history.back()"
                        class="needs-back-btn"
                    >
                        <i class="fas fa-arrow-left"></i>

                        Back
                    </a>


                    <div class="needs-breadcrumb">

                        <a href="{{ url('/') }}">
                            Home
                        </a>

                        <span class="needs-breadcrumb-divider">
                            /
                        </span>

                        <span class="needs-breadcrumb-current">
                            Explore Needs
                        </span>

                    </div>

                </div>


                {{-- ==================================================
                     LABEL
                =================================================== --}}

                <span class="needs-label">

                    <i class="fas fa-hand-holding-heart"></i>

                    NUST Sharing Network

                </span>


                {{-- ==================================================
                     TITLE
                =================================================== --}}

                <h1>

                    Explore Educational
                    <span>Needs</span>

                </h1>


                {{-- ==================================================
                     DESCRIPTION
                =================================================== --}}

                <p>

                    Discover educational support categories and
                    explore where meaningful contributions can
                    support students across the NUST community.

                </p>


                {{-- ==================================================
                     SMALL INFO ITEMS
                =================================================== --}}

                <div class="needs-hero-info">

                    <div class="needs-hero-info-item">

                        <i class="fas fa-layer-group"></i>

                        <span>
                            Multiple Need Categories
                        </span>

                    </div>


                    <div class="needs-hero-info-item">

                        <i class="fas fa-shield-alt"></i>

                        <span>
                            Responsible Sharing
                        </span>

                    </div>


                    <div class="needs-hero-info-item">

                        <i class="fas fa-user-graduate"></i>

                        <span>
                            Student Focused
                        </span>

                    </div>

                </div>


            </div>

        </div>

    </div>

</section>



{{-- ============================================================
     CATEGORY SECTION
============================================================ --}}

<section
    class="needs-categories-section"
    id="need-categories"
>

    <div class="container">


        {{-- SECTION HEADING --}}
        <div class="needs-section-heading">

            <span class="needs-section-label">
                Explore Needs
            </span>

            <h2>
                Educational Need Categories
            </h2>

            <p>
                Select a category to understand the different
                educational resources required by students.
            </p>

        </div>



        {{-- CATEGORY COUNT --}}
        <div class="needs-category-count-wrapper">

            <div class="needs-category-count">

                <i class="fas fa-layer-group"></i>

                <span>

                    <strong>
                        {{ number_format($totalCategories ?? 0) }}
                    </strong>

                    {{
                        ($totalCategories ?? 0) == 1
                            ? 'category available'
                            : 'categories available'
                    }}

                </span>

            </div>

        </div>



        {{-- ====================================================
             CATEGORY GRID
        ===================================================== --}}

        <div class="row g-4">

            @forelse($categories as $category)

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <div class="needs-category-card">

                        <div>

                            {{-- ICON --}}
                            <div class="needs-category-icon">

                                <i class="fas fa-folder-open"></i>

                            </div>


                            {{-- CONTENT --}}
                            <div class="needs-category-content">

                                <h4>
                                    {{ $category->name }}
                                </h4>

                                <p>
                                    Explore educational resources
                                    and support opportunities available
                                    under this category.
                                </p>

                            </div>

                        </div>


                        {{-- FOOTER --}}
                        <div class="needs-category-footer">

                            <span class="needs-category-slug">

                                {{ $category->slug }}

                            </span>

                            <span class="needs-category-arrow">

                                <i class="fas fa-arrow-right"></i>

                            </span>

                        </div>

                    </div>

                </div>


            @empty

                <div class="col-12">

                    <div class="needs-empty-state">

                        <div class="needs-empty-icon">

                            <i class="fas fa-layer-group"></i>

                        </div>

                        <h4>
                            No Categories Available
                        </h4>

                        <p>
                            Educational need categories are not
                            available at the moment. Please check
                            again later.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>



{{-- ============================================================
     CTA
============================================================ --}}

<section class="needs-cta-section">

    <div class="container">

        <div class="needs-cta-box">

            <div class="row align-items-center g-4">


                {{-- CONTENT --}}
                <div class="col-lg-8">

                    <div class="needs-cta-content">

                        <span class="needs-cta-label">
                            NUST Sharing Network
                        </span>

                        <h2>
                            Ready to Make a Difference?
                        </h2>

                        <p>
                            Join the NUST Sharing Network and help
                            connect useful resources with genuine
                            educational needs.
                        </p>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="col-lg-4 text-lg-end needs-cta-action">

                    @guest

                        <a
                            href="{{ route('register') }}"
                            class="needs-cta-btn"
                        >

                            Join the Network

                            <i class="fas fa-arrow-right"></i>

                        </a>

                    @else

                        <a
                            href="{{ url('/dashboard') }}"
                            class="needs-cta-btn"
                        >

                            Open Dashboard

                            <i class="fas fa-arrow-right"></i>

                        </a>

                    @endguest

                </div>


            </div>

        </div>

    </div>

</section>



@include('layouts.home.footer')

@include('layouts.home.script')

</body>
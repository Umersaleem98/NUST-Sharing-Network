@include('layouts.home.head')

<title>Student Stories | NUST Sharing Network</title>

<body>

@include('layouts.home.header')

@include('layouts.home.preloader')


<style>
    /* =========================================================
       ROOT
    ========================================================== */

    .all-stories-page {
        --story-primary: #0065a8;
        --story-primary-dark: #003f6b;
        --story-primary-soft: #eaf5fc;
        --story-accent: #f5a623;
        --story-text: #17212b;
        --story-text-soft: #40515e;
        --story-muted: #71808c;
        --story-border: #dce5ec;
        --story-white: #ffffff;

        position: relative;

        min-height: 100vh;

        padding: 90px 0;

        overflow: hidden;

        background:
            radial-gradient(
                circle at 8% 12%,
                rgba(0, 101, 168, 0.07),
                transparent 25%
            ),
            radial-gradient(
                circle at 92% 88%,
                rgba(245, 166, 35, 0.08),
                transparent 24%
            ),
            #f7fafc;
    }


    .all-stories-container {
        position: relative;

        z-index: 2;

        width:
            min(
                1180px,
                calc(100% - 40px)
            );

        margin: 0 auto;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================== */

    .stories-breadcrumb {
        display: flex;

        align-items: center;

        gap: 8px;

        margin-bottom: 30px;

        color: var(--story-muted);

        font-size: 0.85rem;
    }


    .stories-breadcrumb a {
        color: var(--story-primary);

        text-decoration: none;
    }


    .stories-breadcrumb a:hover {
        text-decoration: underline;
    }


    /* =========================================================
       HEADER
    ========================================================== */

    .all-stories-header {
        max-width: 820px;

        margin:
            0 auto
            55px;

        text-align: center;
    }


    .all-stories-eyebrow {
        display: inline-flex;

        align-items: center;

        gap: 8px;

        margin-bottom: 15px;

        padding: 7px 14px;

        border:
            1px solid
            rgba(0, 101, 168, 0.15);

        border-radius: 50px;

        color: var(--story-primary-dark);

        background:
            var(--story-primary-soft);

        font-size: 0.78rem;
        font-weight: 700;

        letter-spacing: 0.7px;

        text-transform: uppercase;
    }


    .all-stories-eyebrow i {
        color: var(--story-accent);
    }


    .all-stories-title {
        margin:
            0
            0
            16px;

        color: var(--story-text);

        font-size:
            clamp(
                2.2rem,
                5vw,
                3.5rem
            );

        font-weight: 800;

        line-height: 1.12;
        letter-spacing: -1px;
    }


    .all-stories-title span {
        color: var(--story-primary);
    }


    .all-stories-description {
        max-width: 700px;

        margin: 0 auto;

        color: var(--story-muted);

        font-size: 1rem;
        line-height: 1.8;
    }


    /* =========================================================
       INFORMATION BAR
    ========================================================== */

    .stories-information-bar {
        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 30px;

        padding: 18px 22px;

        border:
            1px solid
            var(--story-border);

        border-radius: 14px;

        background: #ffffff;

        box-shadow:
            0 6px 20px
            rgba(27, 48, 65, 0.05);
    }


    .stories-information-count {
        color: var(--story-text);

        font-size: 0.9rem;
        font-weight: 700;
    }


    .stories-information-count span {
        color: var(--story-primary);
    }


    .stories-home-link {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        color: var(--story-primary);

        font-size: 0.84rem;
        font-weight: 700;

        text-decoration: none;
    }


    .stories-home-link:hover {
        color: var(--story-primary-dark);

        text-decoration: none;
    }


    /* =========================================================
       GRID
    ========================================================== */

    .all-stories-grid {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );

        gap: 25px;
    }


    /* =========================================================
       CARD
    ========================================================== */

    .all-story-card {
        position: relative;

        display: flex;

        min-width: 0;
        min-height: 500px;

        flex-direction: column;

        overflow: hidden;

        border:
            1px solid
            var(--story-border);

        border-radius: 20px;

        background: var(--story-white);

        box-shadow:
            0 10px 35px
            rgba(27, 48, 65, 0.07);

        cursor: pointer;

        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease,
            border-color 0.3s ease;
    }


    .all-story-card:hover {
        border-color:
            rgba(0, 101, 168, 0.28);

        box-shadow:
            0 20px 50px
            rgba(0, 63, 107, 0.14);

        transform:
            translateY(-6px);
    }


    .all-story-card:focus-visible {
        outline:
            3px solid
            rgba(0, 101, 168, 0.22);

        outline-offset: 3px;
    }


    /* =========================================================
       IMAGE
    ========================================================== */

    .all-story-media {
        position: relative;

        flex: 0 0 240px;

        height: 240px;

        overflow: hidden;

        background: #eaf1f5;
    }


    .all-story-image {
        display: block;

        width: 100%;
        height: 240px;

        object-fit: cover;
        object-position: center;

        transition:
            transform 0.45s ease;
    }


    .all-story-card:hover
    .all-story-image {
        transform:
            scale(1.045);
    }


    .all-story-image-overlay {
        position: absolute;

        inset: 0;

        background:
            linear-gradient(
                180deg,
                transparent 50%,
                rgba(0, 40, 67, 0.34)
                100%
            );

        pointer-events: none;
    }


    .all-story-placeholder {
        display: flex;

        width: 100%;
        height: 240px;

        align-items: center;
        justify-content: center;

        background:
            linear-gradient(
                135deg,
                #eaf5fc,
                #f8fcff 55%,
                #fff7e9
            );
    }


    .all-story-placeholder span {
        display: flex;

        align-items: center;
        justify-content: center;

        width: 82px;
        height: 82px;

        border:
            1px solid
            rgba(0, 101, 168, 0.12);

        border-radius: 24px;

        color: var(--story-primary);

        background:
            rgba(255, 255, 255, 0.92);

        box-shadow:
            0 10px 30px
            rgba(0, 101, 168, 0.09);

        font-size: 2rem;
    }


    .all-story-type {
        position: absolute;

        top: 15px;
        left: 15px;

        z-index: 2;

        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 7px 11px;

        border:
            1px solid
            rgba(255, 255, 255, 0.45);

        border-radius: 50px;

        color: #ffffff;

        background:
            rgba(0, 63, 107, 0.86);

        backdrop-filter:
            blur(7px);

        font-size: 0.69rem;
        font-weight: 700;
    }


    /* =========================================================
       CARD BODY
    ========================================================== */

    .all-story-body {
        display: flex;

        flex: 1;

        flex-direction: column;

        padding: 25px;
    }


    .all-story-meta {
        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 12px;

        margin-bottom: 17px;
    }


    .all-story-support {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        max-width:
            calc(100% - 48px);

        padding: 7px 11px;

        overflow: hidden;

        border-radius: 50px;

        color: var(--story-primary-dark);
        background: var(--story-primary-soft);

        font-size: 0.73rem;
        font-weight: 700;

        text-overflow: ellipsis;
        white-space: nowrap;
    }


    .all-story-quote {
        display: flex;

        flex: 0 0 38px;

        width: 38px;
        height: 38px;

        align-items: center;
        justify-content: center;

        border-radius: 11px;

        color: #9c6900;

        background:
            rgba(245, 166, 35, 0.17);
    }


    .all-story-preview {
        display: -webkit-box;

        margin:
            0
            0
            20px;

        overflow: hidden;

        color: var(--story-text-soft);

        font-size: 0.93rem;
        line-height: 1.75;

        -webkit-box-orient:
            vertical;

        -webkit-line-clamp: 4;
    }


    /* =========================================================
       STUDENT
    ========================================================== */

    .all-story-student {
        display: flex;

        align-items: center;

        gap: 12px;

        margin-top: auto;

        padding-top: 18px;

        border-top:
            1px solid
            #edf1f4;
    }


    .all-story-avatar {
        width: 48px;
        height: 48px;

        flex: 0 0 48px;

        object-fit: cover;

        border:
            2px solid
            #ffffff;

        border-radius: 50%;

        box-shadow:
            0 3px 10px
            rgba(22, 42, 56, 0.14);
    }


    .all-story-avatar-fallback {
        display: flex;

        width: 48px;
        height: 48px;

        flex: 0 0 48px;

        align-items: center;
        justify-content: center;

        border-radius: 50%;

        color: #ffffff;

        background:
            linear-gradient(
                135deg,
                var(--story-primary),
                var(--story-primary-dark)
            );

        font-size: 0.85rem;
        font-weight: 800;
    }


    .all-story-student-details {
        min-width: 0;
    }


    .all-story-student-name {
        display: block;

        overflow: hidden;

        color: var(--story-text);

        font-size: 0.94rem;
        font-weight: 700;

        text-overflow: ellipsis;
        white-space: nowrap;
    }


    .all-story-program {
        display: block;

        margin-top: 3px;

        overflow: hidden;

        color: var(--story-muted);

        font-size: 0.77rem;

        text-overflow: ellipsis;
        white-space: nowrap;
    }


    .all-story-read-more {
        display: inline-flex;

        align-items: center;

        gap: 5px;

        margin-top: 5px;

        color: var(--story-primary);

        font-size: 0.7rem;
        font-weight: 700;
    }


    /* =========================================================
       PAGINATION
    ========================================================== */

    .stories-pagination {
        display: flex;

        justify-content: center;

        margin-top: 50px;
    }


    /* =========================================================
       EMPTY
    ========================================================== */

    .all-stories-empty {
        grid-column: 1 / -1;

        padding: 70px 25px;

        border:
            1px dashed
            #b8cad7;

        border-radius: 20px;

        background: #ffffff;

        text-align: center;
    }


    .all-stories-empty-icon {
        display: flex;

        width: 70px;
        height: 70px;

        margin:
            0 auto 18px;

        align-items: center;
        justify-content: center;

        border-radius: 20px;

        color: var(--story-primary);
        background: var(--story-primary-soft);

        font-size: 1.6rem;
    }


    /* =========================================================
       MODAL
    ========================================================== */

    .all-story-modal {
        z-index: 1090;
    }


    .all-story-modal
    .modal-dialog {
        width:
            calc(100% - 32px);

        max-width: 960px;

        margin: 20px auto;
    }


    .all-story-modal
    .modal-content {
        position: relative;

        overflow: hidden;

        border: 0;
        border-radius: 22px;

        background: #ffffff;

        box-shadow:
            0 30px 100px
            rgba(10, 31, 45, 0.32);
    }


    .all-story-modal-close {
        position: absolute;

        top: 16px;
        right: 16px;

        z-index: 50;

        display: flex;

        width: 44px;
        height: 44px;

        align-items: center;
        justify-content: center;

        padding: 0;

        border:
            2px solid
            rgba(255, 255, 255, 0.8);

        border-radius: 50%;

        color: #ffffff;

        background:
            rgba(20, 31, 40, 0.78);

        font-size: 28px;

        cursor: pointer;
    }


    .all-story-modal-layout {
        display: grid;

        grid-template-columns:
            minmax(320px, 42%)
            minmax(0, 58%);
    }


    .all-story-modal-media {
        position: relative;

        min-height: 560px;

        background: #eaf1f5;
    }


    .all-story-modal-image {
        width: 100%;
        height: 100%;

        min-height: 560px;

        object-fit: cover;
    }


    .all-story-modal-placeholder {
        display: flex;

        width: 100%;
        height: 100%;

        min-height: 560px;

        align-items: center;
        justify-content: center;

        color: var(--story-primary);

        background:
            linear-gradient(
                135deg,
                #eaf5fc,
                #f9fcfe,
                #fff7e8
            );

        font-size: 3rem;
    }


    .all-story-modal-details {
        padding: 48px 42px 35px;
    }


    .all-story-modal-support {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        margin-bottom: 18px;

        padding: 7px 13px;

        border-radius: 50px;

        color: var(--story-primary-dark);
        background: var(--story-primary-soft);

        font-size: 0.76rem;
        font-weight: 700;
    }


    .all-story-modal-name {
        margin:
            0
            0
            6px;

        color: var(--story-text);

        font-size: 2rem;
        font-weight: 800;
    }


    .all-story-modal-program {
        color: var(--story-muted);
    }


    .all-story-modal-divider {
        margin: 24px 0;
    }


    .all-story-modal-label {
        display: block;

        margin-bottom: 10px;

        color: var(--story-primary-dark);

        font-size: 0.73rem;
        font-weight: 800;

        letter-spacing: 0.7px;

        text-transform: uppercase;
    }


    .all-story-modal-text {
        color: #354550;

        font-size: 0.96rem;
        line-height: 1.9;

        white-space: pre-line;
    }


    .all-story-modal-tags {
        display: flex;

        flex-wrap: wrap;

        gap: 9px;

        margin-top: 28px;
    }


    .all-story-modal-tag {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 7px 11px;

        border:
            1px solid
            #e3eaf0;

        border-radius: 8px;

        color: var(--story-muted);

        background: #fafcfd;

        font-size: 0.74rem;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 991.98px) {

        .all-stories-grid {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );
        }


        .all-story-modal-layout {
            grid-template-columns: 1fr;
        }


        .all-story-modal-media,
        .all-story-modal-image,
        .all-story-modal-placeholder {
            height: 330px;
            min-height: 330px;
        }

    }


    @media (max-width: 767.98px) {

        .all-stories-page {
            padding: 60px 0;
        }


        .all-stories-container {
            width:
                min(
                    calc(100% - 30px),
                    560px
                );
        }


        .all-stories-grid {
            grid-template-columns: 1fr;
        }


        .stories-information-bar {
            flex-direction: column;

            align-items: flex-start;
        }


        .all-story-card {
            min-height: auto;
        }


        .all-story-modal
        .modal-dialog {
            width:
                calc(100% - 20px);

            margin: 10px auto;
        }


        .all-story-modal-media,
        .all-story-modal-image,
        .all-story-modal-placeholder {
            height: 270px;
            min-height: 270px;
        }


        .all-story-modal-details {
            padding: 30px 23px;
        }

    }
</style>



{{-- =========================================================
    ALL STUDENT STORIES
========================================================= --}}

<section class="all-stories-page">

    <div class="all-stories-container">


        {{-- Breadcrumb --}}

        <div class="stories-breadcrumb">

            <a href="{{ url('/') }}">

                <i class="fa fa-home"></i>

                Home

            </a>


            <i class="fa fa-angle-right"></i>


            <span>
                Student Stories
            </span>

        </div>



        {{-- Header --}}

        <div class="all-stories-header">

            <div class="all-stories-eyebrow">

                <i class="fa fa-heart"></i>

                Student Stories

            </div>


            <h1 class="all-stories-title">

                Real support.

                <span>
                    Meaningful change.
                </span>

            </h1>


            <p class="all-stories-description">

                Discover inspiring experiences from students
                across the NUST community and see how sharing,
                generosity and meaningful support can make a
                real difference in a student's educational
                journey.

            </p>

        </div>



        {{-- Information --}}

        <div class="stories-information-bar">

            <div class="stories-information-count">

                Showing

                <span>
                    {{ $stories->count() }}
                </span>

                of

                <span>
                    {{ $stories->total() }}
                </span>

                active student stories

            </div>


            <a
                href="{{ url('/#testimonials') }}"
                class="stories-home-link"
            >

                <i class="fa fa-arrow-left"></i>

                Back to Homepage

            </a>

        </div>



        {{-- =====================================================
            STORIES
        ====================================================== --}}

        <div class="all-stories-grid">

            @forelse($stories as $story)

                @php

                    $studentName =
                        $story->student_name
                        ?: 'NUST Student';


                    $studentProgram =
                        $story->program
                        ?: 'NUST';


                    $supportType =
                        $story->support_type
                        ?: 'Community Support';


                    $storyType =
                        $story->story_type
                        ?: 'text';


                    $storyText =
                        $story->story
                        ?: null;


                    $storyImage =
                        !empty($story->image)
                            ? asset(
                                'admins/story/' .
                                $story->image
                            )
                            : null;


                    $studentInitials = collect(
                        preg_split(
                            '/\s+/',
                            trim($studentName)
                        )
                    )
                        ->filter()
                        ->take(2)
                        ->map(
                            fn ($part) =>
                                strtoupper(
                                    mb_substr(
                                        $part,
                                        0,
                                        1
                                    )
                                )
                        )
                        ->implode('');


                    $storyTypeLabel =
                        match ($storyType) {

                            'image' =>
                                'Image Story',

                            'image_text' =>
                                'Image & Text',

                            default =>
                                'Text Story',
                        };


                    $modalId =
                        'allStoryModal' .
                        $story->id;

                @endphp


                <article
                    class="all-story-card"
                    role="button"
                    tabindex="0"
                    data-bs-toggle="modal"
                    data-bs-target="#{{ $modalId }}"
                    aria-label="Read {{ $studentName }} story"
                    onkeydown="
                        if (
                            event.key === 'Enter'
                            ||
                            event.key === ' '
                        ) {
                            event.preventDefault();
                            this.click();
                        }
                    "
                >


                    {{-- Image --}}

                    <div class="all-story-media">

                        @if(
                            $storyImage
                            &&
                            in_array(
                                $storyType,
                                [
                                    'image',
                                    'image_text',
                                ],
                                true
                            )
                        )

                            <img
                                src="{{ $storyImage }}"
                                alt="{{ $story->image_alt ?: $studentName }}"
                                class="all-story-image"
                                loading="lazy"
                            >


                            <div
                                class="all-story-image-overlay"
                            ></div>

                        @else

                            <div class="all-story-placeholder">

                                <span>

                                    <i class="fa fa-quote-left"></i>

                                </span>

                            </div>

                        @endif


                        <span class="all-story-type">

                            @if($storyType === 'image_text')

                                <i class="fa fa-image"></i>

                            @elseif($storyType === 'image')

                                <i class="fa fa-camera"></i>

                            @else

                                <i class="fa fa-align-left"></i>

                            @endif


                            {{ $storyTypeLabel }}

                        </span>

                    </div>



                    {{-- Body --}}

                    <div class="all-story-body">

                        <div class="all-story-meta">

                            <span class="all-story-support">

                                <i class="fa fa-gift"></i>

                                {{ $supportType }}

                            </span>


                            <span class="all-story-quote">

                                <i class="fa fa-quote-left"></i>

                            </span>

                        </div>


                        @if($storyText)

                            <p class="all-story-preview">

                                “{{ $storyText }}”

                            </p>

                        @else

                            <p class="all-story-preview">

                                View this student's experience
                                with the NUST Sharing Network.

                            </p>

                        @endif



                        {{-- Student --}}

                        <div class="all-story-student">

                            @if($storyImage)

                                <img
                                    src="{{ $storyImage }}"
                                    alt="{{ $studentName }}"
                                    class="all-story-avatar"
                                    loading="lazy"
                                >

                            @else

                                <span class="all-story-avatar-fallback">

                                    {{ $studentInitials ?: 'NS' }}

                                </span>

                            @endif


                            <div class="all-story-student-details">

                                <strong class="all-story-student-name">

                                    {{ $studentName }}

                                </strong>


                                <span class="all-story-program">

                                    {{ $studentProgram }}

                                </span>


                                <span class="all-story-read-more">

                                    Read Full Story

                                    <i class="fa fa-arrow-right"></i>

                                </span>

                            </div>

                        </div>

                    </div>

                </article>


            @empty

                <div class="all-stories-empty">

                    <span class="all-stories-empty-icon">

                        <i class="fa fa-book"></i>

                    </span>


                    <h3>
                        Student stories are coming soon
                    </h3>


                    <p class="text-muted">

                        Approved student experiences
                        will appear here.

                    </p>

                </div>

            @endforelse

        </div>



        {{-- =====================================================
            PAGINATION
        ====================================================== --}}

        @if($stories->hasPages())

            <div class="stories-pagination">

                {{ $stories->links() }}

            </div>

        @endif

    </div>

</section>



{{-- =========================================================
    MODALS
========================================================= --}}

@foreach($stories as $story)

    @php

        $modalId =
            'allStoryModal' .
            $story->id;


        $storyImage =
            !empty($story->image)
                ? asset(
                    'admins/story/' .
                    $story->image
                )
                : null;


        $studentName =
            $story->student_name
            ?: 'NUST Student';


        $studentProgram =
            $story->program
            ?: 'NUST';


        $supportType =
            $story->support_type
            ?: 'Community Support';


        $storyType =
            $story->story_type
            ?: 'text';


        $storyTypeLabel =
            match ($storyType) {

                'image' =>
                    'Image Story',

                'image_text' =>
                    'Image & Text Story',

                default =>
                    'Text Story',
            };

    @endphp


    <div
        class="modal fade all-story-modal"
        id="{{ $modalId }}"
        tabindex="-1"
        aria-hidden="true"
    >

        <div
            class="modal-dialog modal-dialog-centered"
        >

            <div class="modal-content">


                <button
                    type="button"
                    class="all-story-modal-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                    &times;
                </button>



                <div class="all-story-modal-layout">


                    {{-- Image --}}

                    <div class="all-story-modal-media">

                        @if($storyImage)

                            <img
                                src="{{ $storyImage }}"
                                alt="{{ $story->image_alt ?: $studentName }}"
                                class="all-story-modal-image"
                            >

                        @else

                            <div class="all-story-modal-placeholder">

                                <i class="fa fa-quote-left"></i>

                            </div>

                        @endif

                    </div>



                    {{-- Details --}}

                    <div class="all-story-modal-details">

                        <span class="all-story-modal-support">

                            <i class="fa fa-gift"></i>

                            {{ $supportType }}

                        </span>


                        <h2 class="all-story-modal-name">

                            {{ $studentName }}

                        </h2>


                        <p class="all-story-modal-program">

                            <i class="fa fa-graduation-cap me-1"></i>

                            {{ $studentProgram }}

                        </p>


                        <hr class="all-story-modal-divider">


                        <span class="all-story-modal-label">

                            Student Story

                        </span>


                        @if($story->story)

                            <div class="all-story-modal-text">

                                “{{ $story->story }}”

                            </div>

                        @else

                            <div class="all-story-modal-text">

                                This student experience has been
                                shared as an image story through
                                the NUST Sharing Network.

                            </div>

                        @endif



                        {{-- Tags --}}

                        <div class="all-story-modal-tags">

                            <span class="all-story-modal-tag">

                                @if($storyType === 'image_text')

                                    <i class="fa fa-image"></i>

                                @elseif($storyType === 'image')

                                    <i class="fa fa-camera"></i>

                                @else

                                    <i class="fa fa-align-left"></i>

                                @endif


                                {{ $storyTypeLabel }}

                            </span>


                            @if($story->is_featured)

                                <span class="all-story-modal-tag">

                                    <i class="fa fa-star"></i>

                                    Featured Story

                                </span>

                            @endif


                            <span class="all-story-modal-tag">

                                <i class="fa fa-heart"></i>

                                NUST Sharing Network

                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endforeach





@include('layouts.home.footer')

@include('layouts.home.script')

</body>
</html>
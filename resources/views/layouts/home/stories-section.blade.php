{{-- =========================================================
    STUDENT STORIES SECTION
========================================================= --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Stories Collection
    |--------------------------------------------------------------------------
    */
    $studentStories = $stories ?? collect();
@endphp


<style>
    /* =========================================================
       ROOT / SECTION
    ========================================================= */

    .stories-section {
        --story-primary: #0065a8;
        --story-primary-dark: #003f6b;
        --story-primary-soft: #eaf5fc;
        --story-accent: #f5a623;

        --story-text: #17212b;
        --story-text-soft: #40515e;
        --story-muted: #71808c;

        --story-border: #dce5ec;
        --story-white: #ffffff;
        --story-background: #f7fafc;

        position: relative;

        padding: 95px 0;

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
            var(--story-background);
    }


    .stories-section::before {
        position: absolute;

        top: -130px;
        right: -120px;

        width: 330px;
        height: 330px;

        border: 55px solid rgba(0, 101, 168, 0.035);
        border-radius: 50%;

        content: "";

        pointer-events: none;
    }


    .stories-container {
        position: relative;

        z-index: 1;

        width: min(
            1180px,
            calc(100% - 40px)
        );

        margin: 0 auto;
    }


    /* =========================================================
       HEADING
    ========================================================= */

    .stories-heading {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            minmax(300px, 440px);

        gap: 50px;

        align-items: end;

        margin-bottom: 42px;
    }


    .stories-eyebrow {
        display: inline-flex;

        align-items: center;

        gap: 8px;

        width: fit-content;

        margin-bottom: 14px;

        padding: 7px 14px;

        border: 1px solid rgba(0, 101, 168, 0.15);
        border-radius: 50px;

        color: var(--story-primary-dark);

        background:
            var(--story-primary-soft);

        font-size: 0.78rem;
        font-weight: 700;

        letter-spacing: 0.7px;

        text-transform: uppercase;
    }


    .stories-eyebrow i {
        color: var(--story-accent);
    }


    .stories-title {
        max-width: 690px;

        margin: 0;

        color: var(--story-text);

        font-size:
            clamp(2rem, 4vw, 3.2rem);

        font-weight: 800;

        line-height: 1.12;

        letter-spacing: -1px;
    }


    .stories-title span {
        color: var(--story-primary);
    }


    .stories-introduction {
        margin: 0;

        color: var(--story-muted);

        font-size: 1rem;

        line-height: 1.8;
    }


    /* =========================================================
       GRID
    ========================================================= */

    .stories-grid {
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
    ========================================================= */

    .story-card {
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

        background:
            var(--story-white);

        box-shadow:
            0 10px 35px
            rgba(27, 48, 65, 0.07);

        cursor: pointer;

        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease,
            border-color 0.3s ease;
    }


    .story-card:hover {
        border-color:
            rgba(0, 101, 168, 0.28);

        box-shadow:
            0 20px 50px
            rgba(0, 63, 107, 0.14);

        transform:
            translateY(-6px);
    }


    .story-card:focus-visible {
        outline:
            3px solid
            rgba(0, 101, 168, 0.22);

        outline-offset: 3px;
    }


    /* =========================================================
       CARD IMAGE
       FIXED SIZE
    ========================================================= */

    .story-card-media {
        position: relative;

        flex: 0 0 240px;

        width: 100%;
        height: 240px;

        overflow: hidden;

        background: #eaf1f5;
    }


    .story-card-image {
        display: block;

        width: 100%;
        height: 240px;

        object-fit: cover;
        object-position: center;

        transition:
            transform 0.45s ease;
    }


    .story-card:hover
    .story-card-image {
        transform:
            scale(1.045);
    }


    .story-card-image-overlay {
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


    /* =========================================================
       TEXT-ONLY VISUAL
    ========================================================= */

    .story-text-visual {
        display: flex;

        align-items: center;
        justify-content: center;

        width: 100%;
        height: 240px;

        background:
            linear-gradient(
                135deg,
                #eaf5fc,
                #f8fcff 55%,
                #fff7e9
            );
    }


    .story-text-visual-icon {
        display: flex;

        align-items: center;
        justify-content: center;

        width: 82px;
        height: 82px;

        border:
            1px solid
            rgba(0, 101, 168, 0.12);

        border-radius: 24px;

        color:
            var(--story-primary);

        background:
            rgba(255, 255, 255, 0.92);

        box-shadow:
            0 10px 30px
            rgba(0, 101, 168, 0.09);

        font-size: 2rem;
    }


    /* =========================================================
       STORY TYPE BADGE
    ========================================================= */

    .story-media-badge {
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

        -webkit-backdrop-filter:
            blur(7px);

        font-size: 0.69rem;
        font-weight: 700;
    }


    /* =========================================================
       CARD BODY
    ========================================================= */

    .story-card-body {
        display: flex;

        flex: 1;

        flex-direction: column;

        padding: 25px;
    }


    .story-card-meta {
        display: flex;

        justify-content:
            space-between;

        align-items: center;

        gap: 12px;

        margin-bottom: 17px;
    }


    .story-support-type {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        max-width:
            calc(100% - 48px);

        padding: 7px 11px;

        overflow: hidden;

        border-radius: 50px;

        color:
            var(--story-primary-dark);

        background:
            var(--story-primary-soft);

        font-size: 0.73rem;
        font-weight: 700;

        text-overflow: ellipsis;

        white-space: nowrap;
    }


    .story-support-type i {
        color:
            var(--story-primary);
    }


    .story-quote-icon {
        display: flex;

        flex: 0 0 38px;

        align-items: center;
        justify-content: center;

        width: 38px;
        height: 38px;

        border-radius: 11px;

        color: #9c6900;

        background:
            rgba(245, 166, 35, 0.17);
    }


    /* =========================================================
       STORY PREVIEW
    ========================================================= */

    .story-preview {
        display: -webkit-box;

        margin: 0 0 20px;

        overflow: hidden;

        color:
            var(--story-text-soft);

        font-size: 0.93rem;

        line-height: 1.75;

        -webkit-box-orient:
            vertical;

        -webkit-line-clamp: 3;
    }


    .story-image-message {
        margin: 0 0 20px;

        color:
            var(--story-muted);

        font-size: 0.9rem;

        line-height: 1.7;
    }


    /* =========================================================
       STUDENT FOOTER
    ========================================================= */

    .story-student {
        display: flex;

        align-items: center;

        gap: 12px;

        margin-top: auto;

        padding-top: 18px;

        border-top:
            1px solid #edf1f4;
    }


    .story-avatar {
        flex: 0 0 48px;

        width: 48px;
        height: 48px;

        object-fit: cover;
        object-position: center;

        border:
            2px solid #ffffff;

        border-radius: 50%;

        box-shadow:
            0 3px 10px
            rgba(22, 42, 56, 0.14);
    }


    .story-avatar-fallback {
        display: flex;

        flex: 0 0 48px;

        align-items: center;
        justify-content: center;

        width: 48px;
        height: 48px;

        border:
            2px solid #ffffff;

        border-radius: 50%;

        color: #ffffff;

        background:
            linear-gradient(
                135deg,
                var(--story-primary),
                var(--story-primary-dark)
            );

        box-shadow:
            0 3px 10px
            rgba(22, 42, 56, 0.14);

        font-size: 0.85rem;
        font-weight: 800;
    }


    .story-student-details {
        min-width: 0;
    }


    .story-student-name {
        display: block;

        margin-bottom: 3px;

        overflow: hidden;

        color:
            var(--story-text);

        font-size: 0.94rem;
        font-weight: 750;

        text-overflow: ellipsis;

        white-space: nowrap;
    }


    .story-student-program {
        display: block;

        overflow: hidden;

        color:
            var(--story-muted);

        font-size: 0.77rem;

        text-overflow: ellipsis;

        white-space: nowrap;
    }


    .story-read-more {
        display: inline-flex;

        align-items: center;

        gap: 5px;

        margin-top: 5px;

        color:
            var(--story-primary);

        font-size: 0.7rem;
        font-weight: 700;
    }


    .story-read-more i {
        font-size: 0.65rem;

        transition:
            transform 0.25s ease;
    }


    .story-card:hover
    .story-read-more i {
        transform:
            translateX(3px);
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .stories-empty {
        grid-column: 1 / -1;

        padding: 60px 25px;

        border:
            1px dashed #b8cad7;

        border-radius: 20px;

        background:
            rgba(255, 255, 255, 0.75);

        text-align: center;
    }


    .stories-empty-icon {
        display: flex;

        align-items: center;
        justify-content: center;

        width: 64px;
        height: 64px;

        margin:
            0 auto 18px;

        border-radius: 18px;

        color:
            var(--story-primary);

        background:
            var(--story-primary-soft);

        font-size: 1.4rem;
    }


    .stories-empty h3 {
        margin: 0 0 8px;

        color:
            var(--story-text);

        font-size: 1.2rem;
    }


    .stories-empty p {
        margin: 0;

        color:
            var(--story-muted);
    }


    /* =========================================================
       MODAL ROOT
    ========================================================= */

    .story-detail-modal {
        z-index: 1090;
    }


    .story-detail-modal
    .modal-dialog {
        width:
            calc(100% - 32px);

        max-width: 960px;

        margin:
            20px auto;
    }


    .story-detail-modal
    .modal-content {
        position: relative;

        width: 100%;

        max-height:
            calc(100vh - 40px);

        overflow: hidden;

        border: 0;

        border-radius: 22px;

        background: #ffffff;

        box-shadow:
            0 30px 100px
            rgba(10, 31, 45, 0.32);
    }


    /* =========================================================
       VERY VISIBLE CLOSE BUTTON
    ========================================================= */

    .story-modal-close-button {
        position: absolute;

        top: 16px;
        right: 16px;

        z-index: 30;

        display: flex;

        align-items: center;
        justify-content: center;

        width: 44px;
        height: 44px;

        padding: 0;

        border:
            2px solid
            rgba(255, 255, 255, 0.8);

        border-radius: 50%;

        color: #ffffff;

        background:
            rgba(20, 31, 40, 0.78);

        box-shadow:
            0 5px 20px
            rgba(0, 0, 0, 0.18);

        font-size: 28px;
        font-weight: 300;

        line-height: 1;

        cursor: pointer;

        transition:
            background 0.2s ease,
            transform 0.2s ease;
    }


    .story-modal-close-button:hover {
        color: #ffffff;

        background:
            #003f6b;

        transform:
            scale(1.05);
    }


    .story-modal-close-button:focus {
        outline:
            3px solid
            rgba(0, 101, 168, 0.25);

        outline-offset: 2px;
    }


    /* =========================================================
       MODAL LAYOUT
    ========================================================= */

    .story-modal-layout {
        display: grid;

        grid-template-columns:
            minmax(320px, 42%)
            minmax(0, 58%);

        width: 100%;

        max-height:
            calc(100vh - 40px);
    }


    /* =========================================================
       MODAL IMAGE
    ========================================================= */

    .story-modal-media {
        position: relative;

        width: 100%;
        height: 100%;

        min-height: 560px;

        overflow: hidden;

        background: #eaf1f5;
    }


    .story-modal-image {
        display: block;

        width: 100%;
        height: 100%;

        min-height: 560px;

        object-fit: cover;
        object-position: center;
    }


    .story-modal-image-shade {
        position: absolute;

        inset: 0;

        background:
            linear-gradient(
                to top,
                rgba(0, 40, 67, 0.17),
                transparent 45%
            );

        pointer-events: none;
    }


    /* =========================================================
       MODAL TEXT PLACEHOLDER
    ========================================================= */

    .story-modal-placeholder {
        display: flex;

        align-items: center;
        justify-content: center;

        width: 100%;
        height: 100%;

        min-height: 560px;

        background:
            linear-gradient(
                135deg,
                #eaf5fc,
                #f9fcfe 55%,
                #fff7e8
            );
    }


    .story-modal-placeholder-icon {
        display: flex;

        align-items: center;
        justify-content: center;

        width: 115px;
        height: 115px;

        border-radius: 30px;

        color:
            var(--story-primary);

        background:
            rgba(255, 255, 255, 0.9);

        box-shadow:
            0 15px 45px
            rgba(0, 101, 168, 0.11);

        font-size: 2.7rem;
    }


    /* =========================================================
       MODAL DETAILS
    ========================================================= */

    .story-modal-details {
        display: flex;

        min-width: 0;

        max-height:
            calc(100vh - 40px);

        flex-direction: column;

        overflow-y: auto;

        padding:
            48px 42px 35px;
    }


    .story-modal-support {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        width: fit-content;

        margin-bottom: 18px;

        padding: 7px 13px;

        border-radius: 50px;

        color:
            var(--story-primary-dark);

        background:
            var(--story-primary-soft);

        font-size: 0.76rem;
        font-weight: 700;
    }


    .story-modal-support i {
        color:
            var(--story-primary);
    }


    .story-modal-name {
        margin: 0 0 6px;

        padding-right: 45px;

        color:
            var(--story-text);

        font-size:
            clamp(
                1.6rem,
                3vw,
                2.15rem
            );

        font-weight: 800;

        line-height: 1.2;
    }


    .story-modal-program {
        margin: 0;

        color:
            var(--story-muted);

        font-size: 0.93rem;

        line-height: 1.6;
    }


    .story-modal-divider {
        margin: 24px 0;

        border-color: #e6edf2;

        opacity: 1;
    }


    .story-modal-label {
        display: block;

        margin-bottom: 10px;

        color:
            var(--story-primary-dark);

        font-size: 0.73rem;
        font-weight: 800;

        letter-spacing: 0.7px;

        text-transform: uppercase;
    }


    .story-modal-story {
        margin: 0;

        color: #354550;

        font-size: 0.96rem;

        line-height: 1.9;

        white-space: pre-line;
    }


    .story-modal-no-text {
        margin: 0;

        color:
            var(--story-muted);

        font-size: 0.93rem;

        line-height: 1.8;
    }


    /* =========================================================
       MODAL META
    ========================================================= */

    .story-modal-meta {
        display: flex;

        flex-wrap: wrap;

        gap: 9px;

        margin-top: 28px;
    }


    .story-modal-meta-item {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 7px 11px;

        border:
            1px solid #e3eaf0;

        border-radius: 8px;

        color:
            var(--story-muted);

        background: #fafcfd;

        font-size: 0.74rem;
    }


    /* =========================================================
       MODAL FOOTER
    ========================================================= */

    .story-modal-footer {
        margin-top: auto;

        padding-top: 30px;
    }


    .story-modal-footer-line {
        margin: 0 0 20px;

        border-color: #e8edf1;

        opacity: 1;
    }


    .story-modal-close-footer {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: 7px;

        min-width: 115px;

        padding: 10px 18px;

        border:
            1px solid
            var(--story-primary-dark);

        border-radius: 9px;

        color: #ffffff;

        background:
            var(--story-primary-dark);

        font-size: 0.85rem;
        font-weight: 700;

        transition:
            background 0.2s ease;
    }


    .story-modal-close-footer:hover {
        color: #ffffff;

        background:
            var(--story-primary);
    }


    /* =========================================================
       BACKDROP
    ========================================================= */

    .modal-backdrop.show {
        opacity: 0.68;
    }


    /* =========================================================
       TABLET
    ========================================================= */

    @media (
        max-width: 991.98px
    ) {

        .stories-section {
            padding: 75px 0;
        }


        .stories-heading {
            grid-template-columns: 1fr;

            gap: 18px;
        }


        .stories-grid {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );
        }


        .story-modal-layout {
            grid-template-columns: 1fr;

            max-height:
                calc(100vh - 30px);

            overflow-y: auto;
        }


        .story-modal-media {
            min-height: 330px;
            height: 330px;
        }


        .story-modal-image {
            min-height: 330px;
            height: 330px;
        }


        .story-modal-placeholder {
            min-height: 330px;
            height: 330px;
        }


        .story-modal-details {
            max-height: none;

            overflow: visible;

            padding:
                35px 32px 30px;
        }


        .story-detail-modal
        .modal-content {
            max-height:
                calc(100vh - 30px);

            overflow-y: auto;
        }

    }


    /* =========================================================
       MOBILE
    ========================================================= */

    @media (
        max-width: 767.98px
    ) {

        .stories-section {
            padding: 60px 0;
        }


        .stories-container {
            width:
                min(
                    calc(100% - 30px),
                    560px
                );
        }


        .stories-heading {
            margin-bottom: 30px;

            text-align: center;
        }


        .stories-eyebrow {
            margin-right: auto;
            margin-left: auto;
        }


        .stories-grid {
            grid-template-columns: 1fr;
        }


        .story-card {
            min-height: auto;
        }


        .story-card-media,
        .story-card-image,
        .story-text-visual {
            height: 230px;
        }


        .story-card-media {
            flex-basis: 230px;
        }


        .story-detail-modal
        .modal-dialog {
            width:
                calc(100% - 20px);

            margin:
                10px auto;
        }


        .story-detail-modal
        .modal-content {
            max-height:
                calc(100vh - 20px);

            border-radius: 17px;
        }


        .story-modal-layout {
            max-height:
                calc(100vh - 20px);
        }


        .story-modal-media,
        .story-modal-image,
        .story-modal-placeholder {
            height: 275px;
            min-height: 275px;
        }


        .story-modal-details {
            padding:
                30px 23px 25px;
        }


        .story-modal-close-button {
            top: 12px;
            right: 12px;

            width: 40px;
            height: 40px;

            font-size: 25px;
        }


        .story-modal-name {
            padding-right: 0;
        }

    }


    /* =========================================================
       SMALL MOBILE
    ========================================================= */

    @media (
        max-width: 480px
    ) {

        .story-card-media,
        .story-card-image,
        .story-text-visual {
            height: 210px;
        }


        .story-card-media {
            flex-basis: 210px;
        }


        .story-card-body {
            padding: 21px;
        }


        .story-modal-media,
        .story-modal-image,
        .story-modal-placeholder {
            height: 230px;
            min-height: 230px;
        }


        .story-modal-details {
            padding:
                26px 19px 22px;
        }


        .story-modal-name {
            font-size: 1.45rem;
        }

    }
</style>



{{-- =========================================================
     STUDENT STORIES
========================================================= --}}

<section
    class="stories-section"
    id="testimonials"
    aria-labelledby="stories-title"
>

    <div class="stories-container">


        {{-- =====================================================
             HEADING
        ====================================================== --}}

        <div class="stories-heading">

            <div>

                <div class="stories-eyebrow">

                    <i class="fa fa-heart"></i>

                    Student Stories

                </div>


                <h2
                    class="stories-title"
                    id="stories-title"
                >

                    Real support.

                    <span>
                        Meaningful change.
                    </span>

                </h2>

            </div>


            <p class="stories-introduction">

                Discover how the NUST Sharing Network helps students
                overcome challenges, continue their education, and
                move forward with confidence through the generosity
                of our community.

            </p>

        </div>



        {{-- =====================================================
             STORY CARDS
        ====================================================== --}}

        <div class="stories-grid">


            @forelse (
                $studentStories as $story
            )

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Student Information
                    |--------------------------------------------------------------------------
                    */

                    $studentName =
                        $story->student_name
                        ?: 'NUST Student';


                    $studentProgram =
                        $story->program
                        ?: 'NUST';


                    /*
                    |--------------------------------------------------------------------------
                    | Story Information
                    |--------------------------------------------------------------------------
                    */

                    $supportType =
                        $story->support_type
                        ?: 'Community Support';


                    $storyType =
                        $story->story_type
                        ?: 'text';


                    $storyText =
                        $story->story
                        ?: null;


                    /*
                    |--------------------------------------------------------------------------
                    | Image
                    |--------------------------------------------------------------------------
                    */

                    $storyImage =
                        !empty($story->image)
                            ? asset(
                                'admins/story/'
                                . $story->image
                            )
                            : null;


                    /*
                    |--------------------------------------------------------------------------
                    | Initials
                    |--------------------------------------------------------------------------
                    */

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


                    /*
                    |--------------------------------------------------------------------------
                    | Story Type Label
                    |--------------------------------------------------------------------------
                    */

                    $storyTypeLabel =
                        match ($storyType) {

                            'image' =>
                                'Image Story',

                            'image_text' =>
                                'Image & Text',

                            default =>
                                'Text Story',
                        };


                    /*
                    |--------------------------------------------------------------------------
                    | Modal ID
                    |--------------------------------------------------------------------------
                    */

                    $storyModalId =
                        'storyModal'
                        . $story->id;

                @endphp



                {{-- =================================================
                     STORY CARD
                ================================================== --}}

                <article
                    class="story-card"
                    role="button"
                    tabindex="0"
                    data-bs-toggle="modal"
                    data-bs-target="#{{ $storyModalId }}"
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


                    {{-- =============================================
                         CARD IMAGE
                    ============================================== --}}

                    <div class="story-card-media">


                        @if (
                            $storyImage
                            &&
                            in_array(
                                $storyType,
                                [
                                    'image',
                                    'image_text'
                                ]
                            )
                        )

                            <img
                                src="{{ $storyImage }}"
                                alt="{{ $story->image_alt ?: $studentName }}"
                                class="story-card-image"
                                width="380"
                                height="240"
                                loading="lazy"
                            >


                            <div
                                class="story-card-image-overlay"
                            ></div>


                        @else

                            <div
                                class="story-text-visual"
                            >

                                <span
                                    class="story-text-visual-icon"
                                >

                                    <i
                                        class="fa fa-quote-left"
                                    ></i>

                                </span>

                            </div>

                        @endif



                        {{-- Story Type --}}

                        <span
                            class="story-media-badge"
                        >

                            @if (
                                $storyType ===
                                'image_text'
                            )

                                <i
                                    class="fa fa-image"
                                ></i>

                            @elseif (
                                $storyType ===
                                'image'
                            )

                                <i
                                    class="fa fa-camera"
                                ></i>

                            @else

                                <i
                                    class="fa fa-align-left"
                                ></i>

                            @endif


                            {{ $storyTypeLabel }}

                        </span>

                    </div>



                    {{-- =============================================
                         CARD BODY
                    ============================================== --}}

                    <div class="story-card-body">


                        <div class="story-card-meta">

                            <span
                                class="story-support-type"
                            >

                                <i
                                    class="fa fa-gift"
                                ></i>

                                {{ $supportType }}

                            </span>


                            <span
                                class="story-quote-icon"
                            >

                                <i
                                    class="fa fa-quote-left"
                                ></i>

                            </span>

                        </div>



                        {{-- Story Preview --}}

                        @if ($storyText)

                            <p class="story-preview">

                                “{{ $storyText }}”

                            </p>

                        @else

                            <p
                                class="story-image-message"
                            >

                                View this student's
                                experience with the NUST
                                Sharing Network.

                            </p>

                        @endif



                        {{-- =========================================
                             STUDENT
                        ========================================== --}}

                        <div class="story-student">


                            @if ($storyImage)

                                <img
                                    src="{{ $storyImage }}"
                                    alt="{{ $studentName }}"
                                    class="story-avatar"
                                    width="48"
                                    height="48"
                                    loading="lazy"
                                >

                            @else

                                <span
                                    class="story-avatar-fallback"
                                >

                                    {{ $studentInitials ?: 'NS' }}

                                </span>

                            @endif



                            <div
                                class="story-student-details"
                            >

                                <strong
                                    class="story-student-name"
                                >

                                    {{ $studentName }}

                                </strong>


                                <span
                                    class="story-student-program"
                                >

                                    {{ $studentProgram }}

                                </span>


                                <span
                                    class="story-read-more"
                                >

                                    Read Full Story

                                    <i
                                        class="fa fa-arrow-right"
                                    ></i>

                                </span>

                            </div>

                        </div>

                    </div>

                </article>


            @empty


                <div class="stories-empty">

                    <span
                        class="stories-empty-icon"
                    >

                        <i
                            class="fa fa-book"
                        ></i>

                    </span>


                    <h3>
                        Student stories are coming soon
                    </h3>


                    <p>
                        Approved student experiences
                        will appear here.
                    </p>

                </div>


            @endforelse

        </div>

    </div>

</section>



{{-- =========================================================
     STORY MODALS
     
     IMPORTANT:
     These are OUTSIDE .stories-section.
========================================================= --}}

@foreach (
    $studentStories as $story
)

    @php

        /*
        |--------------------------------------------------------------------------
        | Modal Student Data
        |--------------------------------------------------------------------------
        */

        $modalStudentName =
            $story->student_name
            ?: 'NUST Student';


        $modalStudentProgram =
            $story->program
            ?: 'NUST';


        $modalSupportType =
            $story->support_type
            ?: 'Community Support';


        $modalStoryType =
            $story->story_type
            ?: 'text';


        $modalStoryText =
            $story->story
            ?: null;


        /*
        |--------------------------------------------------------------------------
        | Modal Image
        |--------------------------------------------------------------------------
        */

        $modalStoryImage =
            !empty($story->image)
                ? asset(
                    'admins/story/'
                    . $story->image
                )
                : null;


        /*
        |--------------------------------------------------------------------------
        | Type Label
        |--------------------------------------------------------------------------
        */

        $modalStoryTypeLabel =
            match ($modalStoryType) {

                'image' =>
                    'Image Story',

                'image_text' =>
                    'Image & Text Story',

                default =>
                    'Text Story',
            };


        /*
        |--------------------------------------------------------------------------
        | Modal ID
        |--------------------------------------------------------------------------
        */

        $storyModalId =
            'storyModal'
            . $story->id;

    @endphp



    <div
        class="modal fade story-detail-modal"
        id="{{ $storyModalId }}"
        tabindex="-1"
        aria-labelledby="{{ $storyModalId }}Label"
        aria-hidden="true"
    >

        <div
            class="modal-dialog modal-dialog-centered"
        >

            <div class="modal-content">


                {{-- =============================================
                     TOP CLOSE BUTTON
                ============================================== --}}

                <button
                    type="button"
                    class="story-modal-close-button"
                    data-bs-dismiss="modal"
                    aria-label="Close Story"
                >
                    &times;
                </button>



                {{-- =============================================
                     MODAL LAYOUT
                ============================================== --}}

                <div class="story-modal-layout">


                    {{-- =========================================
                         LEFT IMAGE
                    ========================================== --}}

                    <div class="story-modal-media">


                        @if ($modalStoryImage)

                            <img
                                src="{{ $modalStoryImage }}"
                                alt="{{ $story->image_alt ?: $modalStudentName }}"
                                class="story-modal-image"
                                width="400"
                                height="560"
                            >


                            <div
                                class="story-modal-image-shade"
                            ></div>


                        @else

                            <div
                                class="story-modal-placeholder"
                            >

                                <span
                                    class="story-modal-placeholder-icon"
                                >

                                    <i
                                        class="fa fa-quote-left"
                                    ></i>

                                </span>

                            </div>

                        @endif

                    </div>



                    {{-- =========================================
                         RIGHT DETAILS
                    ========================================== --}}

                    <div class="story-modal-details">


                        {{-- Support Type --}}

                        <span
                            class="story-modal-support"
                        >

                            <i
                                class="fa fa-gift"
                            ></i>

                            {{ $modalSupportType }}

                        </span>



                        {{-- Student Name --}}

                        <h3
                            class="story-modal-name"
                            id="{{ $storyModalId }}Label"
                        >

                            {{ $modalStudentName }}

                        </h3>



                        {{-- Student Program --}}

                        <p
                            class="story-modal-program"
                        >

                            <i
                                class="fa fa-graduation-cap me-1"
                            ></i>

                            {{ $modalStudentProgram }}

                        </p>



                        <hr
                            class="story-modal-divider"
                        >



                        {{-- =====================================
                             FULL STORY
                        ====================================== --}}

                        <div>

                            <span
                                class="story-modal-label"
                            >

                                Student Story

                            </span>


                            @if (
                                $modalStoryText
                            )

                                <p
                                    class="story-modal-story"
                                >

                                    “{{ $modalStoryText }}”

                                </p>

                            @else

                                <p
                                    class="story-modal-no-text"
                                >

                                    This student experience
                                    has been shared as an
                                    image story through the
                                    NUST Sharing Network.

                                </p>

                            @endif

                        </div>



                        {{-- =====================================
                             INFORMATION TAGS
                        ====================================== --}}

                        <div class="story-modal-meta">


                            <span
                                class="story-modal-meta-item"
                            >

                                @if (
                                    $modalStoryType
                                    ===
                                    'image_text'
                                )

                                    <i
                                        class="fa fa-image"
                                    ></i>

                                @elseif (
                                    $modalStoryType
                                    ===
                                    'image'
                                )

                                    <i
                                        class="fa fa-camera"
                                    ></i>

                                @else

                                    <i
                                        class="fa fa-align-left"
                                    ></i>

                                @endif


                                {{ $modalStoryTypeLabel }}

                            </span>



                            @if (
                                $story->is_featured
                            )

                                <span
                                    class="story-modal-meta-item"
                                >

                                    <i
                                        class="fa fa-star"
                                    ></i>

                                    Featured Story

                                </span>

                            @endif



                            <span
                                class="story-modal-meta-item"
                            >

                                <i
                                    class="fa fa-heart"
                                ></i>

                                NUST Sharing Network

                            </span>

                        </div>



                        {{-- =====================================
                             BOTTOM CLOSE
                        ====================================== --}}

                        <div class="story-modal-footer">

                            <hr
                                class="story-modal-footer-line"
                            >


                            <button
                                type="button"
                                class="story-modal-close-footer"
                                data-bs-dismiss="modal"
                            >

                                <i
                                    class="fa fa-times"
                                ></i>

                                Close

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endforeach
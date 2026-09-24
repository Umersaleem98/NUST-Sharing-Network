{{-- =========================================================
    STUDENT STORY FORM
========================================================== --}}

<div class="row">


    {{-- =====================================================
        STUDENT NAME
    ====================================================== --}}

    <div class="col-md-6 mb-4">

        <label class="font-weight-bold">

            Student Name

            <span class="text-danger">*</span>

        </label>


        <input
            type="text"
            name="student_name"
            class="form-control @error('student_name') is-invalid @enderror"
            value="{{
                old(
                    'student_name',
                    $studentStory->student_name ?? ''
                )
            }}"
            placeholder="Enter student name"
            maxlength="255"
            required
        >


        @error('student_name')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    </div>



    {{-- =====================================================
        PROGRAM
    ====================================================== --}}

    <div class="col-md-6 mb-4">

        <label class="font-weight-bold">

            Program

        </label>


        <input
            type="text"
            name="program"
            class="form-control @error('program') is-invalid @enderror"
            value="{{
                old(
                    'program',
                    $studentStory->program ?? ''
                )
            }}"
            placeholder="e.g. BS Computer Science"
            maxlength="255"
        >


        @error('program')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    </div>



    {{-- =====================================================
        STORY TYPE
    ====================================================== --}}

    <div class="col-md-4 mb-4">

        <label class="font-weight-bold">

            Story Type

            <span class="text-danger">*</span>

        </label>


        @php

            $selectedStoryType =
                old(
                    'story_type',
                    $studentStory->story_type
                    ?? 'text'
                );

        @endphp


        <select
            name="story_type"
            id="storyType"
            class="form-control @error('story_type') is-invalid @enderror"
            required
        >

            <option value="">
                Select Story Type
            </option>


            <option
                value="text"
                {{ $selectedStoryType === 'text' ? 'selected' : '' }}
            >
                Text Story
            </option>


            <option
                value="image"
                {{ $selectedStoryType === 'image' ? 'selected' : '' }}
            >
                Image Story
            </option>


            <option
                value="image_text"
                {{ $selectedStoryType === 'image_text' ? 'selected' : '' }}
            >
                Image & Text Story
            </option>

        </select>


        @error('story_type')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    </div>



    {{-- =====================================================
        SUPPORT TYPE
    ====================================================== --}}

    <div class="col-md-4 mb-4">

        <label class="font-weight-bold">

            Support Type

        </label>


        <input
            type="text"
            name="support_type"
            class="form-control @error('support_type') is-invalid @enderror"
            value="{{
                old(
                    'support_type',
                    $studentStory->support_type ?? ''
                )
            }}"
            placeholder="e.g. Educational Support"
            maxlength="255"
        >


        @error('support_type')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    </div>



    {{-- =====================================================
        DISPLAY ORDER
    ====================================================== --}}

    <div class="col-md-4 mb-4">

        <label class="font-weight-bold">

            Display Order

        </label>


        <input
            type="number"
            name="display_order"
            min="0"
            class="form-control @error('display_order') is-invalid @enderror"
            value="{{
                old(
                    'display_order',
                    $studentStory->display_order ?? 0
                )
            }}"
        >


        <small class="form-text text-muted">

            Lower numbers appear first.

        </small>


        @error('display_order')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    </div>



    {{-- =====================================================
        STORY
    ====================================================== --}}

    <div
        class="col-12 mb-4"
        id="storyTextSection"
    >

        <label class="font-weight-bold">

            Student Story

        </label>


        <textarea
            name="story"
            id="storyText"
            rows="9"
            class="form-control @error('story') is-invalid @enderror"
            placeholder="Write the complete student story..."
        >{{ old('story', $studentStory->story ?? '') }}</textarea>


        <small class="form-text text-muted">

            Required for Text Story and Image & Text Story.

        </small>


        @error('story')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    </div>



    {{-- =====================================================
        IMAGE
    ====================================================== --}}

    <div
        class="col-md-6 mb-4"
        id="storyImageSection"
    >

        <label class="font-weight-bold">

            Story Image

        </label>


        <div class="story-image-upload">

            <input
                type="file"
                name="image"
                id="storyImage"
                class="form-control-file"
                accept=".jpg,.jpeg,.png,.webp"
            >


            <small class="form-text text-muted">

                JPG, JPEG, PNG or WEBP.
                Maximum file size: 1 MB.

            </small>

        </div>


        @error('image')

            <div class="text-danger small mt-2">

                {{ $message }}

            </div>

        @enderror



        {{-- Current Image --}}

        @if(
            isset($studentStory)
            &&
            $studentStory->image
        )

            <div class="current-story-image mt-3">

                <p class="font-weight-bold mb-2">

                    Current Image

                </p>


                <img
                    src="{{
                        asset(
                            'admins/story/' .
                            $studentStory->image
                        )
                    }}"
                    alt="{{
                        $studentStory->image_alt
                        ?: $studentStory->student_name
                    }}"
                    class="story-form-current-image"
                >


                <div class="form-check mt-2">

                    <input
                        type="checkbox"
                        name="remove_image"
                        value="1"
                        id="removeImage"
                        class="form-check-input"
                    >


                    <label
                        for="removeImage"
                        class="form-check-label text-danger"
                    >

                        Remove current image

                    </label>

                </div>

            </div>

        @endif

    </div>



    {{-- =====================================================
        IMAGE ALT TEXT
    ====================================================== --}}

    <div
        class="col-md-6 mb-4"
        id="imageAltSection"
    >

        <label class="font-weight-bold">

            Image Alt Text

        </label>


        <input
            type="text"
            name="image_alt"
            class="form-control @error('image_alt') is-invalid @enderror"
            value="{{
                old(
                    'image_alt',
                    $studentStory->image_alt ?? ''
                )
            }}"
            placeholder="Describe the image"
            maxlength="255"
        >


        <small class="form-text text-muted">

            Used for accessibility and SEO.

        </small>


        @error('image_alt')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    </div>



    {{-- =====================================================
        SETTINGS
    ====================================================== --}}

    <div class="col-12">

        <hr>

        <h5 class="mb-3">
            Display Settings
        </h5>

    </div>



    {{-- Featured --}}

    <div class="col-md-6 mb-4">

        <div class="story-setting-card">

            <div>

                <strong>
                    Featured Story
                </strong>


                <small class="d-block text-muted">

                    Highlight this story as a featured story.

                </small>

            </div>


            <label class="story-switch">

                <input
                    type="checkbox"
                    name="is_featured"
                    value="1"
                    {{
                        old(
                            'is_featured',
                            $studentStory->is_featured
                            ?? false
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <span class="story-slider"></span>

            </label>

        </div>

    </div>



    {{-- Active --}}

    <div class="col-md-6 mb-4">

        <div class="story-setting-card">

            <div>

                <strong>
                    Active Story
                </strong>


                <small class="d-block text-muted">

                    Show this story on the public website.

                </small>

            </div>


            <label class="story-switch">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{
                        old(
                            'is_active',
                            isset($studentStory)
                                ? $studentStory->is_active
                                : true
                        )
                            ? 'checked'
                            : ''
                    }}
                >

                <span class="story-slider"></span>

            </label>

        </div>

    </div>

</div>


<style>

    .story-form-current-image {
        width: 180px;
        height: 130px;

        object-fit: cover;
        object-position: center;

        border: 1px solid #dde6eb;
        border-radius: 9px;
    }


    .story-setting-card {
        min-height: 80px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding: 16px;

        border: 1px solid #e2e9ed;
        border-radius: 9px;

        background: #f9fbfc;
    }


    .story-switch {
        position: relative;

        width: 48px;
        height: 25px;

        margin: 0;

        flex-shrink: 0;
    }


    .story-switch input {
        width: 0;
        height: 0;

        opacity: 0;
    }


    .story-slider {
        position: absolute;

        inset: 0;

        border-radius: 50px;

        background: #c7d0d6;

        cursor: pointer;

        transition: 0.25s;
    }


    .story-slider::before {
        content: "";

        position: absolute;

        width: 19px;
        height: 19px;

        left: 3px;
        bottom: 3px;

        border-radius: 50%;

        background: #ffffff;

        transition: 0.25s;
    }


    .story-switch
    input:checked
    + .story-slider {

        background: #00558c;
    }


    .story-switch
    input:checked
    + .story-slider::before {

        transform:
            translateX(23px);
    }

</style>
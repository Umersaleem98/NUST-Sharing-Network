@include('layouts.admin.head')

<body>

@include('layouts.admin.sidebar')

<div class="nsn-main">

    @include('layouts.admin.header')


    <div class="nsn-content">

        <div class="container-fluid py-4">

            <div class="row justify-content-center">

                <div class="col-xl-9 col-lg-10">


                    <div
                        class="d-flex justify-content-between align-items-center mb-4"
                    >

                        <div>

                            <h3 class="fw-bold mb-1">
                                Edit Student Story
                            </h3>

                            <p class="text-muted mb-0">
                                Update student story information.
                            </p>

                        </div>


                        <a
                            href="{{ route('admin.student.stories.index') }}"
                            class="btn btn-outline-secondary"
                        >
                            <i class="bi bi-arrow-left me-1"></i>

                            Back
                        </a>

                    </div>


                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <div class="card border-0 shadow-sm">

                        <div class="card-body p-4">

                            <form
                                action="{{ route('admin.student.stories.update', $story) }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >

                                @csrf
                                @method('PUT')


                                <div class="row g-4">


                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Student Name
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            name="student_name"
                                            class="form-control"
                                            value="{{ old('student_name', $story->student_name) }}"
                                            required
                                        >

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Program
                                        </label>

                                        <input
                                            type="text"
                                            name="program"
                                            class="form-control"
                                            value="{{ old('program', $story->program) }}"
                                        >

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Support Type
                                        </label>

                                        <input
                                            type="text"
                                            name="support_type"
                                            class="form-control"
                                            value="{{ old('support_type', $story->support_type) }}"
                                        >

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Story Type
                                        </label>

                                        <select
                                            name="story_type"
                                            id="story_type"
                                            class="form-select"
                                            required
                                        >

                                            <option
                                                value="text"
                                                {{ old('story_type', $story->story_type) === 'text' ? 'selected' : '' }}
                                            >
                                                Text Story
                                            </option>

                                            <option
                                                value="image"
                                                {{ old('story_type', $story->story_type) === 'image' ? 'selected' : '' }}
                                            >
                                                Image Story
                                            </option>

                                            <option
                                                value="image_text"
                                                {{ old('story_type', $story->story_type) === 'image_text' ? 'selected' : '' }}
                                            >
                                                Image + Text Story
                                            </option>

                                        </select>

                                    </div>


                                    <div
                                        class="col-12"
                                        id="storyTextContainer"
                                    >

                                        <label class="form-label fw-semibold">
                                            Story
                                        </label>

                                        <textarea
                                            name="story"
                                            class="form-control"
                                            rows="7"
                                        >{{ old('story', $story->story) }}</textarea>

                                    </div>


                                    <div
                                        class="col-md-6"
                                        id="storyImageContainer"
                                    >

                                        <label class="form-label fw-semibold">
                                            Story Image
                                        </label>


                                        @if ($story->image)

                                            <div class="mb-3">

                                                <img
                                                    src="{{ asset('admins/story/' . $story->image) }}"
                                                    alt="{{ $story->image_alt ?? $story->student_name }}"
                                                    class="rounded border"
                                                    style="
                                                        width: 140px;
                                                        height: 110px;
                                                        object-fit: cover;
                                                    "
                                                >

                                            </div>

                                        @endif


                                        <input
                                            type="file"
                                            name="image"
                                            class="form-control"
                                            accept=".jpg,.jpeg,.png,.webp"
                                        >

                                        <small class="text-muted">
                                            Leave empty to keep current image.
                                        </small>

                                    </div>


                                    <div
                                        class="col-md-6"
                                        id="imageAltContainer"
                                    >

                                        <label class="form-label fw-semibold">
                                            Image Alt Text
                                        </label>

                                        <input
                                            type="text"
                                            name="image_alt"
                                            class="form-control"
                                            value="{{ old('image_alt', $story->image_alt) }}"
                                        >

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold">
                                            Display Order
                                        </label>

                                        <input
                                            type="number"
                                            name="display_order"
                                            class="form-control"
                                            min="0"
                                            value="{{ old('display_order', $story->display_order) }}"
                                        >

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold d-block">
                                            Featured
                                        </label>

                                        <div class="form-check form-switch mt-2">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="is_featured"
                                                value="1"
                                                id="is_featured"
                                                {{ old('is_featured', $story->is_featured) ? 'checked' : '' }}
                                            >

                                            <label
                                                class="form-check-label"
                                                for="is_featured"
                                            >
                                                Featured Story
                                            </label>

                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label fw-semibold d-block">
                                            Status
                                        </label>

                                        <div class="form-check form-switch mt-2">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="is_active"
                                                value="1"
                                                id="is_active"
                                                {{ old('is_active', $story->is_active) ? 'checked' : '' }}
                                            >

                                            <label
                                                class="form-check-label"
                                                for="is_active"
                                            >
                                                Active
                                            </label>

                                        </div>

                                    </div>


                                    <div class="col-12">

                                        <hr>

                                        <div
                                            class="d-flex justify-content-end gap-2"
                                        >

                                            <a
                                                href="{{ route('admin.student.stories.index') }}"
                                                class="btn btn-light"
                                            >
                                                Cancel
                                            </a>

                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                            >
                                                <i class="bi bi-check-circle me-1"></i>

                                                Update Story
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.admin.script')


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const storyType =
            document.getElementById('story_type');

        const storyTextContainer =
            document.getElementById('storyTextContainer');

        const storyImageContainer =
            document.getElementById('storyImageContainer');

        const imageAltContainer =
            document.getElementById('imageAltContainer');


        function updateStoryFields() {

            const type = storyType.value;


            if (type === 'text') {

                storyTextContainer.style.display = '';

                storyImageContainer.style.display = 'none';

                imageAltContainer.style.display = 'none';

            }

            else if (type === 'image') {

                storyTextContainer.style.display = 'none';

                storyImageContainer.style.display = '';

                imageAltContainer.style.display = '';

            }

            else {

                storyTextContainer.style.display = '';

                storyImageContainer.style.display = '';

                imageAltContainer.style.display = '';

            }

        }


        storyType.addEventListener(
            'change',
            updateStoryFields
        );


        updateStoryFields();

    });
</script>
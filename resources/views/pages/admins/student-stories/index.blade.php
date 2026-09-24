@include('layouts.admins.head')
<title>Edit Student Story</title>    
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}

            <div
                class="d-flex justify-content-between align-items-center flex-wrap mb-4"
            >

                <div>

                    <h3 class="mb-1">
                        Student Stories
                    </h3>

                    <p class="text-muted mb-0">
                        Manage student stories displayed on the NUST Sharing Network.
                    </p>

                </div>


                <a
                    href="{{ route('admin.student-stories.create') }}"
                    class="btn btn-primary"
                >
                    <i class="fa fa-plus mr-1"></i>

                    Add Student Story
                </a>

            </div>



            {{-- =========================================================
                SUCCESS MESSAGE
            ========================================================== --}}

            @if(session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >

                    <i class="fa fa-check-circle mr-2"></i>

                    {{ session('success') }}


                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >
                        <span>&times;</span>
                    </button>

                </div>

            @endif



            {{-- =========================================================
                STATISTICS
            ========================================================== --}}

            <div class="row">


                {{-- Total --}}

                <div class="col-xl-3 col-md-6">

                    <div class="card story-stat-card">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="story-stat-icon story-stat-primary">

                                    <i class="fa fa-book"></i>

                                </div>


                                <div class="ml-3">

                                    <small class="text-muted">
                                        Total Stories
                                    </small>

                                    <h3 class="mb-0 mt-1">
                                        {{ $totalStories }}
                                    </h3>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- Active --}}

                <div class="col-xl-3 col-md-6">

                    <div class="card story-stat-card">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="story-stat-icon story-stat-success">

                                    <i class="fa fa-check"></i>

                                </div>


                                <div class="ml-3">

                                    <small class="text-muted">
                                        Active Stories
                                    </small>

                                    <h3 class="mb-0 mt-1">
                                        {{ $activeStories }}
                                    </h3>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- Inactive --}}

                <div class="col-xl-3 col-md-6">

                    <div class="card story-stat-card">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="story-stat-icon story-stat-danger">

                                    <i class="fa fa-ban"></i>

                                </div>


                                <div class="ml-3">

                                    <small class="text-muted">
                                        Inactive Stories
                                    </small>

                                    <h3 class="mb-0 mt-1">
                                        {{ $inactiveStories }}
                                    </h3>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- Featured --}}

                <div class="col-xl-3 col-md-6">

                    <div class="card story-stat-card">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="story-stat-icon story-stat-warning">

                                    <i class="fa fa-star"></i>

                                </div>


                                <div class="ml-3">

                                    <small class="text-muted">
                                        Featured Stories
                                    </small>

                                    <h3 class="mb-0 mt-1">
                                        {{ $featuredStories }}
                                    </h3>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =========================================================
                FILTERS
            ========================================================== --}}

            <div class="card mb-4">

                <div class="card-header">

                    <h4 class="card-title mb-0">
                        Search & Filter
                    </h4>

                </div>


                <div class="card-body">

                    <form
                        action="{{ route('admin.student-stories.index') }}"
                        method="GET"
                    >

                        <div class="row align-items-end">


                            {{-- Search --}}

                            <div class="col-lg-5 col-md-6 mb-3">

                                <label class="font-weight-bold">
                                    Search
                                </label>

                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    value="{{ request('search') }}"
                                    placeholder="Student name, program, support type..."
                                >

                            </div>



                            {{-- Status --}}

                            <div class="col-lg-2 col-md-3 mb-3">

                                <label class="font-weight-bold">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="form-control"
                                >

                                    <option value="">
                                        All
                                    </option>

                                    <option
                                        value="active"
                                        {{ request('status') === 'active' ? 'selected' : '' }}
                                    >
                                        Active
                                    </option>

                                    <option
                                        value="inactive"
                                        {{ request('status') === 'inactive' ? 'selected' : '' }}
                                    >
                                        Inactive
                                    </option>

                                </select>

                            </div>



                            {{-- Story Type --}}

                            <div class="col-lg-3 col-md-3 mb-3">

                                <label class="font-weight-bold">
                                    Story Type
                                </label>

                                <select
                                    name="story_type"
                                    class="form-control"
                                >

                                    <option value="">
                                        All Types
                                    </option>

                                    <option
                                        value="text"
                                        {{ request('story_type') === 'text' ? 'selected' : '' }}
                                    >
                                        Text Story
                                    </option>

                                    <option
                                        value="image"
                                        {{ request('story_type') === 'image' ? 'selected' : '' }}
                                    >
                                        Image Story
                                    </option>

                                    <option
                                        value="image_text"
                                        {{ request('story_type') === 'image_text' ? 'selected' : '' }}
                                    >
                                        Image & Text
                                    </option>

                                </select>

                            </div>



                            {{-- Filter Button --}}

                            <div class="col-lg-2 mb-3">

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-block"
                                >

                                    <i class="fa fa-search mr-1"></i>

                                    Filter

                                </button>

                            </div>

                        </div>


                        @if(
                            request()->filled('search')
                            ||
                            request()->filled('status')
                            ||
                            request()->filled('story_type')
                        )

                            <a
                                href="{{ route('admin.student-stories.index') }}"
                                class="btn btn-sm btn-light"
                            >

                                <i class="fa fa-times mr-1"></i>

                                Clear Filters

                            </a>

                        @endif

                    </form>

                </div>

            </div>



            {{-- =========================================================
                STORIES TABLE
            ========================================================== --}}

            <div class="card">

                <div class="card-header">

                    <h4 class="card-title mb-0">
                        Student Stories List
                    </h4>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead>

                            <tr>

                                <th>#</th>

                                <th>Image</th>

                                <th>Student</th>

                                <th>Type</th>

                                <th>Support</th>

                                <th>Order</th>

                                <th>Status</th>

                                <th>Featured</th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                            </thead>


                            <tbody>

                            @forelse($stories as $story)

                                <tr>


                                    {{-- Number --}}

                                    <td>

                                        {{
                                            $stories->firstItem()
                                            + $loop->index
                                        }}

                                    </td>



                                    {{-- Image --}}

                                    <td>

                                        @if($story->image)

                                            <img
                                                src="{{
                                                    asset(
                                                        'admins/story/' .
                                                        $story->image
                                                    )
                                                }}"
                                                alt="{{
                                                    $story->image_alt
                                                    ?: $story->student_name
                                                }}"
                                                class="student-story-table-image"
                                            >

                                        @else

                                            <div class="student-story-placeholder">

                                                <i class="fa fa-user"></i>

                                            </div>

                                        @endif

                                    </td>



                                    {{-- Student --}}

                                    <td>

                                        <strong class="story-student-name">

                                            {{ $story->student_name }}

                                        </strong>


                                        <small class="d-block text-muted mt-1">

                                            {{
                                                $story->program
                                                ?: 'Program not specified'
                                            }}

                                        </small>

                                    </td>



                                    {{-- Type --}}

                                    <td>

                                        @if($story->story_type === 'image')

                                            <span class="badge badge-info">

                                                <i class="fa fa-camera mr-1"></i>

                                                Image

                                            </span>

                                        @elseif($story->story_type === 'image_text')

                                            <span class="badge badge-primary">

                                                <i class="fa fa-image mr-1"></i>

                                                Image & Text

                                            </span>

                                        @else

                                            <span class="badge badge-secondary">

                                                <i class="fa fa-align-left mr-1"></i>

                                                Text

                                            </span>

                                        @endif

                                    </td>



                                    {{-- Support --}}

                                    <td>

                                        {{
                                            $story->support_type
                                            ?: '—'
                                        }}

                                    </td>



                                    {{-- Order --}}

                                    <td>

                                        <span class="story-order-badge">

                                            {{ $story->display_order }}

                                        </span>

                                    </td>



                                    {{-- Status --}}

                                    <td>

                                        @if($story->is_active)

                                            <span class="badge badge-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge badge-danger">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>



                                    {{-- Featured --}}

                                    <td>

                                        @if($story->is_featured)

                                            <span class="badge badge-warning">

                                                <i class="fa fa-star mr-1"></i>

                                                Featured

                                            </span>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>



                                    {{-- Actions --}}

                                    <td class="text-center">

                                        <div class="btn-group">


                                            {{-- View --}}

                                            <a
                                                href="{{
                                                    route(
                                                        'admin.student-stories.show',
                                                        $story
                                                    )
                                                }}"
                                                class="btn btn-sm btn-info"
                                                title="View Story"
                                            >

                                                <i class="fa fa-eye"></i>

                                            </a>



                                            {{-- Edit --}}

                                            <a
                                                href="{{
                                                    route(
                                                        'admin.student-stories.edit',
                                                        $story
                                                    )
                                                }}"
                                                class="btn btn-sm btn-primary"
                                                title="Edit Story"
                                            >

                                                <i class="fa fa-edit"></i>

                                            </a>



                                            {{-- Delete --}}

                                            <form
                                                action="{{
                                                    route(
                                                        'admin.student-stories.destroy',
                                                        $story
                                                    )
                                                }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="
                                                    return confirm(
                                                        'Are you sure you want to delete this student story?'
                                                    );
                                                "
                                            >

                                                @csrf
                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete Story"
                                                >

                                                    <i class="fa fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="9"
                                        class="text-center py-5"
                                    >

                                        <div class="story-empty-state">

                                            <i class="fa fa-book"></i>


                                            <h5 class="mt-3">
                                                No Student Stories Found
                                            </h5>


                                            <p class="text-muted mb-3">

                                                Create your first student story
                                                to display it on the website.

                                            </p>


                                            <a
                                                href="{{ route('admin.student-stories.create') }}"
                                                class="btn btn-primary"
                                            >

                                                <i class="fa fa-plus mr-1"></i>

                                                Add Student Story

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>



                    {{-- Pagination --}}

                    @if($stories->hasPages())

                        <div
                            class="d-flex justify-content-center mt-4"
                        >

                            {{ $stories->links() }}

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>




</div>


@include('layouts.admins.script')


<style>

    .story-stat-card {
        border: 0;
        box-shadow:
            0 3px 12px
            rgba(0, 0, 0, 0.05);
    }

    .story-stat-icon {
        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        font-size: 19px;
    }

    .story-stat-primary {
        color: #00558c;
        background: rgba(0, 85, 140, 0.12);
    }

    .story-stat-success {
        color: #218838;
        background: rgba(40, 167, 69, 0.12);
    }

    .story-stat-danger {
        color: #c82333;
        background: rgba(220, 53, 69, 0.12);
    }

    .story-stat-warning {
        color: #b17b00;
        background: rgba(255, 193, 7, 0.15);
    }

    .student-story-table-image {
        width: 65px;
        height: 65px;

        object-fit: cover;
        object-position: center;

        border: 1px solid #e1e8ed;
        border-radius: 9px;
    }

    .student-story-placeholder {
        width: 65px;
        height: 65px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        color: #8293a0;
        background: #eef4f7;

        font-size: 20px;
    }

    .story-student-name {
        color: #243746;
    }

    .story-order-badge {
        display: inline-flex;

        min-width: 32px;
        height: 32px;

        align-items: center;
        justify-content: center;

        border-radius: 50%;

        color: #00558c;
        background: #eef6fb;

        font-size: 12px;
        font-weight: 700;
    }

    .story-empty-state > i {
        color: #a9b7c1;
        font-size: 42px;
    }

</style>

</body>
</html>
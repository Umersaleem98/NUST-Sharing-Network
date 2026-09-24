@include('layouts.admins.head')
<title>Student Story Details</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')
    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            {{-- =========================================================
                HEADER
            ========================================================== --}}

            <div
                class="d-flex justify-content-between align-items-center flex-wrap mb-4"
            >

                <div>

                    <h3 class="mb-1">

                        Student Story Details

                    </h3>


                    <p class="text-muted mb-0">

                        View complete student story information.

                    </p>

                </div>


                <div>


                    <a
                        href="{{
                            route(
                                'admin.student-stories.edit',
                                $studentStory
                            )
                        }}"
                        class="btn btn-primary"
                    >

                        <i class="fa fa-edit mr-1"></i>

                        Edit Story

                    </a>


                    <a
                        href="{{ route('admin.student-stories.index') }}"
                        class="btn btn-light"
                    >

                        <i class="fa fa-arrow-left mr-1"></i>

                        Back

                    </a>

                </div>

            </div>



            {{-- =========================================================
                SUCCESS
            ========================================================== --}}

            @if(session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                >

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



            <div class="row">


                {{-- =====================================================
                    STORY IMAGE
                ====================================================== --}}

                <div class="col-lg-4 mb-4">

                    <div class="card h-100">

                        <div class="card-header">

                            <h4 class="card-title mb-0">

                                Story Image

                            </h4>

                        </div>


                        <div class="card-body">

                            @if($studentStory->image)

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
                                    class="story-detail-image"
                                >

                            @else

                                <div class="story-detail-placeholder">

                                    <i class="fa fa-image"></i>


                                    <span>
                                        No Image Available
                                    </span>

                                </div>

                            @endif


                            @if($studentStory->image_alt)

                                <div class="mt-3">

                                    <small class="text-muted d-block">
                                        Image Alt Text
                                    </small>


                                    <span>
                                        {{ $studentStory->image_alt }}
                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    DETAILS
                ====================================================== --}}

                <div class="col-lg-8 mb-4">

                    <div class="card">

                        <div class="card-header">

                            <div
                                class="d-flex justify-content-between align-items-center"
                            >

                                <h4 class="card-title mb-0">

                                    Student Information

                                </h4>


                                <div>


                                    @if($studentStory->is_active)

                                        <span class="badge badge-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge badge-danger">
                                            Inactive
                                        </span>

                                    @endif


                                    @if($studentStory->is_featured)

                                        <span class="badge badge-warning ml-1">

                                            <i class="fa fa-star"></i>

                                            Featured

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        <div class="card-body">


                            {{-- Student --}}

                            <div class="story-student-heading">

                                <div class="story-detail-avatar">

                                    {{
                                        strtoupper(
                                            mb_substr(
                                                $studentStory->student_name,
                                                0,
                                                1
                                            )
                                        )
                                    }}

                                </div>


                                <div>

                                    <h3 class="mb-1">

                                        {{ $studentStory->student_name }}

                                    </h3>


                                    <p class="text-muted mb-0">

                                        {{
                                            $studentStory->program
                                            ?: 'Program not specified'
                                        }}

                                    </p>

                                </div>

                            </div>


                            <hr>



                            {{-- Information Grid --}}

                            <div class="row">


                                {{-- Story Type --}}

                                <div class="col-md-6">

                                    <div class="story-detail-item">

                                        <span>
                                            Story Type
                                        </span>


                                        <strong>

                                            @if($studentStory->story_type === 'image')

                                                Image Story

                                            @elseif($studentStory->story_type === 'image_text')

                                                Image & Text Story

                                            @else

                                                Text Story

                                            @endif

                                        </strong>

                                    </div>

                                </div>



                                {{-- Support Type --}}

                                <div class="col-md-6">

                                    <div class="story-detail-item">

                                        <span>
                                            Support Type
                                        </span>


                                        <strong>

                                            {{
                                                $studentStory->support_type
                                                ?: 'Not specified'
                                            }}

                                        </strong>

                                    </div>

                                </div>



                                {{-- Display Order --}}

                                <div class="col-md-6">

                                    <div class="story-detail-item">

                                        <span>
                                            Display Order
                                        </span>


                                        <strong>

                                            {{ $studentStory->display_order }}

                                        </strong>

                                    </div>

                                </div>



                                {{-- Status --}}

                                <div class="col-md-6">

                                    <div class="story-detail-item">

                                        <span>
                                            Website Status
                                        </span>


                                        <strong>

                                            {{
                                                $studentStory->is_active
                                                    ? 'Visible on Website'
                                                    : 'Hidden from Website'
                                            }}

                                        </strong>

                                    </div>

                                </div>



                                {{-- Created --}}

                                <div class="col-md-6">

                                    <div class="story-detail-item">

                                        <span>
                                            Created At
                                        </span>


                                        <strong>

                                            {{
                                                $studentStory
                                                    ->created_at
                                                    ->format(
                                                        'd M Y, h:i A'
                                                    )
                                            }}

                                        </strong>

                                    </div>

                                </div>



                                {{-- Updated --}}

                                <div class="col-md-6">

                                    <div class="story-detail-item">

                                        <span>
                                            Last Updated
                                        </span>


                                        <strong>

                                            {{
                                                $studentStory
                                                    ->updated_at
                                                    ->format(
                                                        'd M Y, h:i A'
                                                    )
                                            }}

                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- =================================================
                        STORY CONTENT
                    ================================================== --}}

                    <div class="card">

                        <div class="card-header">

                            <h4 class="card-title mb-0">

                                Student Story

                            </h4>

                        </div>


                        <div class="card-body">

                            @if($studentStory->story)

                                <div class="student-story-content">

                                    {!! nl2br(e($studentStory->story)) !!}

                                </div>

                            @else

                                <div class="text-center py-4">

                                    <i
                                        class="fa fa-image text-muted"
                                        style="font-size: 35px;"
                                    ></i>


                                    <p class="text-muted mt-3 mb-0">

                                        This is an image-only student story.

                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>



                    {{-- =================================================
                        ACTIONS
                    ================================================== --}}

                    <div class="card">

                        <div class="card-body">

                            <div
                                class="d-flex flex-wrap"
                                style="gap: 10px;"
                            >


                                <a
                                    href="{{
                                        route(
                                            'admin.student-stories.edit',
                                            $studentStory
                                        )
                                    }}"
                                    class="btn btn-primary"
                                >

                                    <i class="fa fa-edit mr-1"></i>

                                    Edit Story

                                </a>



                                <form
                                    action="{{
                                        route(
                                            'admin.student-stories.destroy',
                                            $studentStory
                                        )
                                    }}"
                                    method="POST"
                                    onsubmit="
                                        return confirm(
                                            'Are you sure you want to permanently delete this student story?'
                                        );
                                    "
                                >

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                    >

                                        <i class="fa fa-trash mr-1"></i>

                                        Delete Story

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>




</div>


@include('layouts.admins.script')


<style>

    .story-detail-image {
        display: block;

        width: 100%;
        max-height: 470px;

        object-fit: cover;
        object-position: center;

        border-radius: 10px;

        background: #eef4f7;
    }


    .story-detail-placeholder {
        min-height: 320px;

        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;

        gap: 12px;

        border-radius: 10px;

        color: #8d9ba5;
        background: #eef4f7;
    }


    .story-detail-placeholder i {
        font-size: 45px;
    }


    .story-student-heading {
        display: flex;
        align-items: center;

        gap: 15px;
    }


    .story-detail-avatar {
        width: 58px;
        height: 58px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 50%;

        color: #ffffff;
        background:
            linear-gradient(
                135deg,
                #00558c,
                #003f69
            );

        font-size: 20px;
        font-weight: 700;
    }


    .story-detail-item {
        display: flex;
        flex-direction: column;

        gap: 4px;

        padding:
            13px
            0;

        border-bottom:
            1px solid
            #edf1f4;
    }


    .story-detail-item span {
        color: #84929d;

        font-size: 10px;
        font-weight: 700;

        letter-spacing: 0.4px;
        text-transform: uppercase;
    }


    .story-detail-item strong {
        color: #243746;

        font-size: 13px;
        font-weight: 600;
    }


    .student-story-content {
        padding: 20px;

        border:
            1px solid
            #e4eaee;

        border-radius: 9px;

        color: #405363;
        background: #f9fbfc;

        font-size: 14px;
        line-height: 1.9;
    }

</style>

</body>
</html>
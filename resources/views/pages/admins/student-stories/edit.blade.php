@include('layouts.admins.head')
<title>Edit Student Story</title>    
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

                        Edit Student Story

                    </h3>


                    <p class="text-muted mb-0">

                        Update
                        <strong>
                            {{ $studentStory->student_name }}
                        </strong>
                        story information.

                    </p>

                </div>


                <div>


                    <a
                        href="{{
                            route(
                                'admin.student-stories.show',
                                $studentStory
                            )
                        }}"
                        class="btn btn-info"
                    >

                        <i class="fa fa-eye mr-1"></i>

                        View

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
                VALIDATION ERRORS
            ========================================================== --}}

            @if($errors->any())

                <div
                    class="alert alert-danger"
                    role="alert"
                >

                    <strong>
                        Please correct the following errors:
                    </strong>


                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif



            {{-- =========================================================
                EDIT FORM
            ========================================================== --}}

            <div class="card">

                <div class="card-header">

                    <h4 class="card-title mb-0">

                        Edit Story Information

                    </h4>

                </div>


                <div class="card-body">

                    <form
                        action="{{
                            route(
                                'admin.student-stories.update',
                                $studentStory
                            )
                        }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf
                        @method('PUT')


                        @include(
                            'pages.admins.student-stories.form'
                        )


                        <hr>


                        <div
                            class="d-flex justify-content-end flex-wrap"
                            style="gap: 10px;"
                        >

                            <a
                                href="{{ route('admin.student-stories.index') }}"
                                class="btn btn-light"
                            >

                                Cancel

                            </a>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="fa fa-save mr-1"></i>

                                Update Student Story

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>




</div>


@include('layouts.admins.script')

</body>
</html>
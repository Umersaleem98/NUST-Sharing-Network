@include('layouts.admins.head')
<title>Add Student Story</title>
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

                        Add Student Story

                    </h3>


                    <p class="text-muted mb-0">

                        Add a new student experience to the
                        NUST Sharing Network.

                    </p>

                </div>


                <a
                    href="{{ route('admin.student-stories.index') }}"
                    class="btn btn-light"
                >

                    <i class="fa fa-arrow-left mr-1"></i>

                    Back to Stories

                </a>

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
                CREATE FORM
            ========================================================== --}}

            <div class="card">

                <div class="card-header">

                    <h4 class="card-title mb-0">

                        Student Story Information

                    </h4>

                </div>


                <div class="card-body">

                    <form
                        action="{{ route('admin.student-stories.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf


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

                                Save Student Story

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
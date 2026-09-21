@include('layouts.admin.head')

<body>

@include('layouts.admin.sidebar')

<div class="nsn-main">

    @include('layouts.admin.header')


    <div class="nsn-content">

        <div class="container-fluid py-4">


            {{-- =====================================================
                 PAGE HEADER
            ====================================================== --}}

            <div
                class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4"
            >

                <div>

                    <h3 class="fw-bold mb-1">
                        Student Stories
                    </h3>

                    <p class="text-muted mb-0">
                        Manage student stories displayed on the website.
                    </p>

                </div>


                <a
                    href="{{ route('admin.student.stories.create') }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-plus-circle me-1"></i>

                    Add Story
                </a>

            </div>


            {{-- =====================================================
                 SUCCESS MESSAGE
            ====================================================== --}}

            @if (session('success'))

                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >

                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>

                </div>

            @endif


            {{-- =====================================================
                 STORIES TABLE
            ====================================================== --}}

            <div class="card border-0 shadow-sm">

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table
                            class="table table-hover align-middle mb-0"
                        >

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-4">
                                        #
                                    </th>

                                    <th>
                                        Student
                                    </th>

                                    <th>
                                        Image
                                    </th>

                                    <th>
                                        Type
                                    </th>

                                    <th>
                                        Support
                                    </th>

                                    <th>
                                        Featured
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Order
                                    </th>

                                    <th class="text-end pe-4">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($stories as $story)

                                    <tr>

                                        <td class="ps-4">

                                            {{ $stories->firstItem() + $loop->index }}

                                        </td>


                                        <td>

                                            <div class="fw-semibold">

                                                {{ $story->student_name }}

                                            </div>

                                            <small class="text-muted">

                                                {{ $story->program ?? 'N/A' }}

                                            </small>

                                        </td>


                                        <td>

                                            @if ($story->image)

                                                <img
                                                    src="{{ asset('admins/story/' . $story->image) }}"
                                                    alt="{{ $story->image_alt ?? $story->student_name }}"
                                                    width="55"
                                                    height="55"
                                                    class="rounded object-fit-cover"
                                                >

                                            @else

                                                <div
                                                    class="d-flex align-items-center justify-content-center rounded bg-light"
                                                    style="width: 55px; height: 55px;"
                                                >
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>

                                            @endif

                                        </td>


                                        <td>

                                            @if ($story->story_type === 'text')

                                                <span class="badge bg-info">
                                                    Text
                                                </span>

                                            @elseif ($story->story_type === 'image')

                                                <span class="badge bg-primary">
                                                    Image
                                                </span>

                                            @else

                                                <span class="badge bg-dark">
                                                    Image + Text
                                                </span>

                                            @endif

                                        </td>


                                        <td>

                                            {{ $story->support_type ?? 'N/A' }}

                                        </td>


                                        <td>

                                            @if ($story->is_featured)

                                                <span class="badge bg-warning text-dark">
                                                    Featured
                                                </span>

                                            @else

                                                <span class="text-muted">
                                                    No
                                                </span>

                                            @endif

                                        </td>


                                        <td>

                                            @if ($story->is_active)

                                                <span class="badge bg-success">
                                                    Active
                                                </span>

                                            @else

                                                <span class="badge bg-secondary">
                                                    Inactive
                                                </span>

                                            @endif

                                        </td>


                                        <td>

                                            {{ $story->display_order }}

                                        </td>


                                        <td class="text-end pe-4">

                                            <div
                                                class="d-flex justify-content-end gap-2"
                                            >

                                                <a
                                                    href="{{ route('admin.student.stories.edit', $story) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Edit"
                                                >
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>


                                                <form
                                                    action="{{ route('admin.student.stories.destroy', $story) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this student story?');"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete"
                                                    >
                                                        <i class="bi bi-trash"></i>
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

                                            <i
                                                class="bi bi-chat-square-quote fs-1 text-muted"
                                            ></i>

                                            <h5 class="mt-3">
                                                No student stories found
                                            </h5>

                                            <p class="text-muted mb-3">
                                                Create your first student story.
                                            </p>

                                            <a
                                                href="{{ route('admin.story.create') }}"
                                                class="btn btn-primary"
                                            >
                                                Add Story
                                            </a>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            {{-- Pagination --}}

            @if ($stories->hasPages())

                <div class="mt-4">

                    {{ $stories->links() }}

                </div>

            @endif

        </div>

    </div>

</div>


@include('layouts.admin.script')
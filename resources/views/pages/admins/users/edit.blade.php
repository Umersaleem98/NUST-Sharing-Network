@include('layouts.admins.head')
<title>Edit User</title>
<body>

<div id="main-wrapper">

    @include('layouts.admins.header')

    @include('layouts.admins.sidebar')


    <div class="content-body">

        <div class="container-fluid mt-3">


            {{-- =========================================================
                PAGE HEADER
            ========================================================== --}}

            <div class="row mb-4">

                <div class="col-md-8">

                    <h3 class="mb-1">
                        Edit User
                    </h3>


                    <p class="text-muted mb-0">

                        Update account information for

                        <strong>
                            {{ $user->name }}
                        </strong>.

                    </p>

                </div>


                <div class="col-md-4 text-md-right">

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="btn btn-secondary"
                    >

                        <i class="fa fa-arrow-left mr-1"></i>

                        Back to Users

                    </a>

                </div>

            </div>


            {{-- =========================================================
                VALIDATION ERRORS
            ========================================================== --}}

            @if($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Please correct the following:
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


            <div class="row">


                {{-- =====================================================
                    EDIT FORM
                ====================================================== --}}

                <div class="col-lg-8">

                    <div class="card">

                        <div class="card-body">


                            <h4 class="card-title mb-4">
                                Account Information
                            </h4>


                            <form
                                action="{{ route('admin.users.update', $user) }}"
                                method="POST"
                            >

                                @csrf

                                @method('PUT')


                                <div class="row">


                                    {{-- Name --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Full Name

                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>


                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ old('name', $user->name) }}"
                                                class="form-control"
                                                required
                                            >

                                        </div>

                                    </div>


                                    {{-- Email --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Email Address

                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>


                                            <input
                                                type="email"
                                                name="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="form-control"
                                                required
                                            >

                                        </div>

                                    </div>


                                    {{-- Role --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Role

                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>


                                            <select
                                                name="role"
                                                id="editRole"
                                                class="form-control"
                                                required
                                            >

                                                <option
                                                    value="admin"
                                                    {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                                                >
                                                    Admin
                                                </option>


                                                <option
                                                    value="donor"
                                                    {{ old('role', $user->role) === 'donor' ? 'selected' : '' }}
                                                >
                                                    Donor
                                                </option>


                                                <option
                                                    value="beneficiary"
                                                    {{ old('role', $user->role) === 'beneficiary' ? 'selected' : '' }}
                                                >
                                                    Beneficiary
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                    {{-- Profile Status --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                Profile Status

                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>


                                            <select
                                                name="profile_status"
                                                class="form-control"
                                                required
                                            >

                                                <option
                                                    value="active"
                                                    {{ old('profile_status', $user->profile_status) === 'active' ? 'selected' : '' }}
                                                >
                                                    Active
                                                </option>


                                                <option
                                                    value="suspended"
                                                    {{ old('profile_status', $user->profile_status) === 'suspended' ? 'selected' : '' }}
                                                >
                                                    Suspended
                                                </option>


                                                <option
                                                    value="blocked"
                                                    {{ old('profile_status', $user->profile_status) === 'blocked' ? 'selected' : '' }}
                                                >
                                                    Blocked
                                                </option>

                                            </select>


                                            <small class="text-muted">

                                                Active users have normal access.
                                                Suspended and blocked users can be restricted through authentication logic.

                                            </small>

                                        </div>

                                    </div>


                                    {{-- Qalam ID --}}

                                    <div
                                        class="col-md-6"
                                        id="editQalamWrapper"
                                    >

                                        <div class="form-group">

                                            <label>
                                                Qalam ID
                                            </label>


                                            <input
                                                type="text"
                                                name="qalam_id"
                                                id="editQalam"
                                                value="{{ old('qalam_id', $user->qalam_id) }}"
                                                class="form-control"
                                                inputmode="numeric"
                                                placeholder="Numbers only"
                                            >


                                            <small class="text-muted">

                                                Required only when role is Beneficiary.

                                            </small>

                                        </div>

                                    </div>


                                    {{-- Password --}}

                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label>
                                                New Password
                                            </label>


                                            <input
                                                type="password"
                                                name="password"
                                                class="form-control"
                                                minlength="8"
                                                placeholder="Leave blank to keep existing password"
                                            >


                                            <small class="text-muted">

                                                Leave blank if the password should remain unchanged.

                                            </small>

                                        </div>

                                    </div>

                                </div>


                                <hr>


                                <div
                                    class="d-flex justify-content-between"
                                >

                                    <a
                                        href="{{ route('admin.users.index') }}"
                                        class="btn btn-secondary"
                                    >
                                        Cancel
                                    </a>


                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >

                                        <i class="fa fa-save mr-1"></i>

                                        Update User

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    USER SUMMARY
                ====================================================== --}}

                <div class="col-lg-4">

                    <div class="card">

                        <div class="card-body">


                            <div class="text-center mb-4">

                                <div
                                    class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                    style="
                                        width: 85px;
                                        height: 85px;
                                        font-size: 30px;
                                        font-weight: 600;
                                    "
                                >

                                    {{ strtoupper(
                                        substr(
                                            $user->name,
                                            0,
                                            1
                                        )
                                    ) }}

                                </div>


                                <h4 class="mt-3 mb-1">

                                    {{ $user->name }}

                                </h4>


                                <span class="badge badge-primary">

                                    {{ ucfirst($user->role) }}

                                </span>

                            </div>


                            <hr>


                            {{-- Email --}}

                            <p>

                                <strong>
                                    Email:
                                </strong>

                                <br>

                                {{ $user->email }}

                            </p>


                            {{-- Qalam --}}

                            <p>

                                <strong>
                                    Qalam ID:
                                </strong>

                                <br>

                                {{ $user->qalam_id ?? 'Not Applicable' }}

                            </p>


                            {{-- Profile Status --}}

                            <p>

                                <strong>
                                    Profile Status:
                                </strong>

                                <br>


                                @if($user->profile_status === 'active')

                                    <span class="badge badge-success">

                                        <i class="fa fa-check-circle"></i>

                                        Active

                                    </span>


                                @elseif($user->profile_status === 'suspended')

                                    <span class="badge badge-warning">

                                        <i class="fa fa-pause-circle"></i>

                                        Suspended

                                    </span>


                                @else

                                    <span class="badge badge-danger">

                                        <i class="fa fa-ban"></i>

                                        Blocked

                                    </span>

                                @endif

                            </p>


                            {{-- Verification --}}

                            <p>

                                <strong>
                                    Email Verification:
                                </strong>

                                <br>


                                @if($user->email_verified_at)

                                    <span class="text-success">

                                        <i class="fa fa-check-circle"></i>

                                        Verified

                                    </span>

                                @else

                                    <span class="text-warning">

                                        Pending

                                    </span>

                                @endif

                            </p>


                            {{-- Created --}}

                            <p>

                                <strong>
                                    Created:
                                </strong>

                                <br>

                                {{ $user->created_at?->format('d M Y h:i A') }}

                            </p>


                            {{-- Updated --}}

                            <p class="mb-0">

                                <strong>
                                    Last Updated:
                                </strong>

                                <br>

                                {{ $user->updated_at?->format('d M Y h:i A') }}

                            </p>

                        </div>

                    </div>


                    {{-- =================================================
                        DANGER ZONE
                    ================================================== --}}

                    <div class="card border-danger">

                        <div class="card-body">


                            <h5 class="text-danger">

                                <i class="fa fa-exclamation-triangle mr-1"></i>

                                Danger Zone

                            </h5>


                            <p class="text-muted">

                                Permanently delete this user account.

                                This action cannot be undone.

                            </p>


                            <button
                                type="button"
                                class="btn btn-danger btn-block"
                                data-toggle="modal"
                                data-target="#deleteUserModal"
                            >

                                <i class="fa fa-trash mr-1"></i>

                                Delete User

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        DELETE USER MODAL
    ========================================================== --}}

    <div
        class="modal fade"
        id="deleteUserModal"
        tabindex="-1"
        role="dialog"
    >

        <div
            class="modal-dialog modal-dialog-centered"
            role="document"
        >

            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Delete User
                    </h5>


                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                    >

                        <span>
                            &times;
                        </span>

                    </button>

                </div>


                <div class="modal-body text-center py-4">

                    <i
                        class="fa fa-exclamation-triangle text-danger"
                        style="font-size:50px;"
                    ></i>


                    <h4 class="mt-3">
                        Delete this user?
                    </h4>


                    <p class="mb-1">

                        You are about to permanently delete:

                    </p>


                    <strong>

                        {{ $user->name }}

                    </strong>


                    <p class="text-danger mt-3 mb-0">

                        This action cannot be undone.

                    </p>

                </div>


                <div class="modal-footer">


                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Cancel
                    </button>


                    <form
                        action="{{ route('admin.users.destroy', $user) }}"
                        method="POST"
                    >

                        @csrf

                        @method('DELETE')


                        <button
                            type="submit"
                            class="btn btn-danger"
                        >

                            <i class="fa fa-trash mr-1"></i>

                            Yes, Delete User

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.admins.script')


<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | Qalam Field
    |--------------------------------------------------------------------------
    */

    function updateQalamField()
    {
        let role =
            $('#editRole').val();


        if (role === 'beneficiary') {

            $('#editQalamWrapper')
                .show();


            $('#editQalam')
                .prop(
                    'required',
                    true
                );

        } else {

            $('#editQalamWrapper')
                .hide();


            $('#editQalam')
                .prop(
                    'required',
                    false
                )
                .val('');

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Role Change
    |--------------------------------------------------------------------------
    */

    $('#editRole').on(
        'change',
        function () {

            updateQalamField();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Initial State
    |--------------------------------------------------------------------------
    */

    updateQalamField();

});

</script>

</body>
</html>
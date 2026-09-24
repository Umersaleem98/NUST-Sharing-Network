@include('layouts.home.head')
<title>Login - NUST Sharing Network</title>
 <style>

        /*
        |--------------------------------------------------------------------------
        | NUST SHARING NETWORK THEME
        |--------------------------------------------------------------------------
        */

        :root {

            --nust-primary: #00558c;

            --nust-primary-dark: #003f69;

            --nust-secondary: #0072bc;

            --nust-green: #82b295;

            --nust-light: #eef6fb;

            --nust-soft: #f7fafc;

            --nust-text: #243746;

            --nust-muted: #6c7a89;

            --nust-border: #dce6ec;

            --white: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | Base
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
        }


        html,
        body {
            min-height: 100%;
        }


        body {

            margin: 0;

            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;

            color: var(--nust-text);

            background:
                linear-gradient(
                    135deg,
                    #edf5fa 0%,
                    #f9fbfd 45%,
                    #e7f1f7 100%
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Wrapper
        |--------------------------------------------------------------------------
        */

        .login-wrapper {

            position: relative;

            min-height: 100vh;

            display: flex;

            align-items: center;

            padding: 45px 0;

            overflow: hidden;
        }


        .login-wrapper::before {

            content: "";

            position: absolute;

            width: 450px;

            height: 450px;

            top: -190px;

            left: -180px;

            border-radius: 50%;

            background:
                rgba(
                    0,
                    85,
                    140,
                    0.07
                );
        }


        .login-wrapper::after {

            content: "";

            position: absolute;

            width: 500px;

            height: 500px;

            right: -210px;

            bottom: -260px;

            border-radius: 50%;

            background:
                rgba(
                    0,
                    114,
                    188,
                    0.06
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Main Card
        |--------------------------------------------------------------------------
        */

        .login-card {

            position: relative;

            z-index: 2;

            background: var(--white);

            border: 0;

            border-radius: 22px;

            overflow: hidden;

            box-shadow:
                0 20px 60px
                rgba(
                    24,
                    63,
                    88,
                    0.13
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Branding Panel
        |--------------------------------------------------------------------------
        */

        .brand-panel {

            position: relative;

            height: 100%;

            min-height: 620px;

            padding: 55px 45px;

            display: flex;

            align-items: center;

            color: #ffffff;

            background:
                linear-gradient(
                    150deg,
                    var(--nust-primary-dark) 0%,
                    var(--nust-primary) 50%,
                    var(--nust-secondary) 100%
                );

            overflow: hidden;
        }


        .brand-panel::before {

            content: "";

            position: absolute;

            width: 300px;

            height: 300px;

            right: -120px;

            top: -100px;

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    0.14
                );

            border-radius: 50%;
        }


        .brand-panel::after {

            content: "";

            position: absolute;

            width: 220px;

            height: 220px;

            left: -80px;

            bottom: -100px;

            border-radius: 50%;

            background:
                rgba(
                    255,
                    255,
                    255,
                    0.05
                );
        }


        .brand-content {

            position: relative;

            z-index: 2;

            width: 100%;
        }


        .brand-badge {

            display: inline-flex;

            align-items: center;

            gap: 9px;

            padding: 8px 15px;

            margin-bottom: 32px;

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    0.18
                );

            border-radius: 30px;

            background:
                rgba(
                    255,
                    255,
                    255,
                    0.10
                );

            font-size: 13px;
        }


        .brand-title {

            margin-bottom: 20px;

            font-size: 37px;

            line-height: 1.25;

            font-weight: 700;
        }


        .brand-description {

            max-width: 430px;

            margin-bottom: 35px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    0.86
                );

            font-size: 15px;

            line-height: 1.8;
        }


        /*
        |--------------------------------------------------------------------------
        | Feature Items
        |--------------------------------------------------------------------------
        */

        .feature-item {

            display: flex;

            align-items: flex-start;

            gap: 13px;

            margin-bottom: 18px;
        }


        .feature-icon {

            width: 36px;

            height: 36px;

            min-width: 36px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 9px;

            background:
                rgba(
                    255,
                    255,
                    255,
                    0.12
                );
        }


        .feature-item strong {

            display: block;

            margin-bottom: 2px;

            font-size: 14px;
        }


        .feature-item span {

            color:
                rgba(
                    255,
                    255,
                    255,
                    0.72
                );

            font-size: 12px;

            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | Form Panel
        |--------------------------------------------------------------------------
        */

        .form-panel {

            padding: 50px;
        }


        .login-icon {

            width: 68px;

            height: 68px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 22px;

            border-radius: 15px;

            color: var(--nust-primary);

            background: var(--nust-light);

            font-size: 28px;
        }


        .form-heading {

            margin-bottom: 8px;

            color: var(--nust-primary-dark);

            font-size: 29px;

            font-weight: 700;
        }


        .form-subheading {

            margin-bottom: 30px;

            color: var(--nust-muted);

            font-size: 14px;

            line-height: 1.7;
        }


        /*
        |--------------------------------------------------------------------------
        | Form Elements
        |--------------------------------------------------------------------------
        */

        .form-label {

            margin-bottom: 8px;

            color: #34495e;

            font-size: 14px;

            font-weight: 600;
        }


        .form-control,
        .form-select {

            min-height: 51px;

            padding: 11px 14px;

            border:
                1px solid
                var(--nust-border);

            border-radius: 10px;

            color: var(--nust-text);

            background-color: #ffffff;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }


        .form-control:focus,
        .form-select:focus {

            border-color: var(--nust-primary);

            box-shadow:
                0 0 0 0.2rem
                rgba(
                    0,
                    85,
                    140,
                    0.12
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Role Help
        |--------------------------------------------------------------------------
        */

        .role-help {

            display: none;

            margin-top: 9px;

            padding: 11px 13px;

            border-radius: 8px;

            color: #516978;

            background: var(--nust-light);

            font-size: 12px;

            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | Qalam
        |--------------------------------------------------------------------------
        */

        #qalamField {

            display: none;
        }


        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        .password-wrapper {

            position: relative;
        }


        .password-wrapper .form-control {

            padding-right: 50px;
        }


        .password-toggle {

            position: absolute;

            top: 50%;

            right: 5px;

            transform: translateY(-50%);

            width: 42px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border: 0;

            border-radius: 8px;

            color: #768691;

            background: transparent;

            cursor: pointer;
        }


        .password-toggle:hover {

            color: var(--nust-primary);

            background: var(--nust-light);
        }


        /*
        |--------------------------------------------------------------------------
        | Remember
        |--------------------------------------------------------------------------
        */

        .form-check-input:checked {

            background-color: var(--nust-primary);

            border-color: var(--nust-primary);
        }


        .form-check-label {

            color: #667784;

            font-size: 13px;
        }


        /*
        |--------------------------------------------------------------------------
        | Login Button
        |--------------------------------------------------------------------------
        */

        .btn-login {

            min-height: 52px;

            border: 0;

            border-radius: 10px;

            color: #ffffff;

            font-weight: 600;

            background:
                linear-gradient(
                    135deg,
                    var(--nust-primary),
                    var(--nust-secondary)
                );

            box-shadow:
                0 8px 18px
                rgba(
                    0,
                    85,
                    140,
                    0.18
                );

            transition:
                all 0.2s ease;
        }


        .btn-login:hover {

            color: #ffffff;

            transform:
                translateY(-1px);

            box-shadow:
                0 10px 22px
                rgba(
                    0,
                    85,
                    140,
                    0.24
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Register
        |--------------------------------------------------------------------------
        */

        .register-area {

            margin-top: 28px;

            padding-top: 23px;

            border-top:
                1px solid
                #e6edf1;

            text-align: center;
        }


        .register-area p {

            margin-bottom: 8px;

            color: var(--nust-muted);

            font-size: 13px;
        }


        .register-link {

            color: var(--nust-primary);

            font-weight: 600;

            text-decoration: none;
        }


        .register-link:hover {

            color: var(--nust-primary-dark);

            text-decoration: underline;
        }


        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        .security-note {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            margin-top: 22px;

            color: #8996a0;

            font-size: 11px;
        }


        /*
        |--------------------------------------------------------------------------
        | Alerts
        |--------------------------------------------------------------------------
        */

        .alert {

            border: 0;

            border-radius: 9px;

            font-size: 13px;
        }


        .alert-success {

            border-left:
                4px solid
                #198754;

            background: #eaf7f0;
        }


        .alert-warning {

            border-left:
                4px solid
                #f0ad4e;

            background: #fff8e8;
        }


        .alert-danger {

            border-left:
                4px solid
                #dc3545;

            background: #fff1f2;
        }


        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991.98px) {

            .brand-panel {

                min-height: auto;

                padding: 40px 35px;
            }


            .brand-title {

                font-size: 30px;
            }


            .form-panel {

                padding: 42px 35px;
            }

        }


        @media (max-width: 767.98px) {

            .login-wrapper {

                padding: 25px 0;
            }


            .login-card {

                border-radius: 16px;
            }


            .brand-panel {

                padding: 35px 28px;
            }


            .brand-title {

                font-size: 27px;
            }


            .form-panel {

                padding: 35px 25px;
            }


            .form-heading {

                font-size: 25px;
            }

        }

    </style>
<body>


<div class="login-wrapper">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-11">


                <div class="login-card">

                    <div class="row g-0">


                        {{-- =================================================
                            LEFT SIDE
                        ================================================== --}}

                        <div class="col-lg-5">

                            <div class="brand-panel">

                                <div class="brand-content">


                                    <div class="brand-badge">

                                        <i class="bi bi-share-fill"></i>

                                        NUST Sharing Network

                                    </div>


                                    <h1 class="brand-title">

                                        Connecting Resources

                                        <br>

                                        With Those

                                        <br>

                                        Who Need Them.

                                    </h1>


                                    <p class="brand-description">

                                        Sign in to securely access your
                                        NUST Sharing Network account and
                                        manage your role-specific activities.

                                    </p>



                                    {{-- Admin --}}

                                    <div class="feature-item">

                                        <div class="feature-icon">

                                            <i class="bi bi-shield-check"></i>

                                        </div>


                                        <div>

                                            <strong>
                                                Administrator
                                            </strong>

                                            <span>

                                                Manage users, products,
                                                categories and request approvals.

                                            </span>

                                        </div>

                                    </div>



                                    {{-- Donor --}}

                                    <div class="feature-item">

                                        <div class="feature-icon">

                                            <i class="bi bi-box-seam"></i>

                                        </div>


                                        <div>

                                            <strong>
                                                Donor
                                            </strong>

                                            <span>

                                                Add products and review
                                                administrator-approved requests.

                                            </span>

                                        </div>

                                    </div>



                                    {{-- Beneficiary --}}

                                    <div class="feature-item">

                                        <div class="feature-icon">

                                            <i class="bi bi-person-check"></i>

                                        </div>


                                        <div>

                                            <strong>
                                                Beneficiary
                                            </strong>

                                            <span>

                                                Browse available products and
                                                track submitted requests.

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            LOGIN FORM
                        ================================================== --}}

                        <div class="col-lg-7">

                            <div class="form-panel">


                                {{-- Login Icon --}}

                                <div class="login-icon">

                                    <i class="bi bi-person-lock"></i>

                                </div>


                                {{-- Heading --}}

                                <h2 class="form-heading">

                                    Welcome Back

                                </h2>


                                <p class="form-subheading">

                                    Select your account type and enter your
                                    credentials to continue.

                                </p>



                                {{-- =================================================
                                    SUCCESS
                                ================================================== --}}

                                @if(session('success'))

                                    <div
                                        class="alert alert-success"
                                        role="alert"
                                    >

                                        <div class="d-flex align-items-start">

                                            <i
                                                class="bi bi-check-circle-fill me-2 mt-1"
                                            ></i>


                                            <div>

                                                {{ session('success') }}

                                            </div>

                                        </div>

                                    </div>

                                @endif



                                {{-- =================================================
                                    WARNING
                                ================================================== --}}

                                @if(session('warning'))

                                    <div
                                        class="alert alert-warning"
                                        role="alert"
                                    >

                                        <div class="d-flex align-items-start">

                                            <i
                                                class="bi bi-exclamation-triangle-fill me-2 mt-1"
                                            ></i>


                                            <div>

                                                {{ session('warning') }}

                                            </div>

                                        </div>

                                    </div>

                                @endif



                                {{-- =================================================
                                    ERRORS
                                ================================================== --}}

                                @if($errors->any())

                                    <div
                                        class="alert alert-danger"
                                        role="alert"
                                    >

                                        <div class="d-flex align-items-start">

                                            <i
                                                class="bi bi-exclamation-circle-fill me-2 mt-1"
                                            ></i>


                                            <div class="w-100">

                                                <strong>
                                                    Login unsuccessful.
                                                </strong>


                                                <ul class="mb-0 mt-2 ps-3">

                                                    @foreach($errors->all() as $error)

                                                        <li>
                                                            {{ $error }}
                                                        </li>

                                                    @endforeach

                                                </ul>

                                            </div>

                                        </div>

                                    </div>

                                @endif



                                {{-- =================================================
                                    LOGIN FORM
                                ================================================== --}}

                                <form
                                    method="POST"
                                    action="{{ route('login.submit') }}"
                                    id="loginForm"
                                >

                                    @csrf



                                    {{-- =================================================
                                        LOGIN ROLE
                                    ================================================== --}}

                                    <div class="mb-3">

                                        <label
                                            for="role"
                                            class="form-label"
                                        >

                                            Login As

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <select
                                            name="role"
                                            id="role"
                                            class="form-select @error('role') is-invalid @enderror"
                                            required
                                        >

                                            <option value="">
                                                Select Account Type
                                            </option>


                                            <option
                                                value="admin"
                                                {{ old('role') === 'admin' ? 'selected' : '' }}
                                            >
                                                Administrator
                                            </option>


                                            <option
                                                value="donor"
                                                {{ old('role') === 'donor' ? 'selected' : '' }}
                                            >
                                                Donor
                                            </option>


                                            <option
                                                value="beneficiary"
                                                {{ old('role') === 'beneficiary' ? 'selected' : '' }}
                                            >
                                                Beneficiary
                                            </option>

                                        </select>


                                        @error('role')

                                            <div class="invalid-feedback">

                                                {{ $message }}

                                            </div>

                                        @enderror


                                        <div
                                            class="role-help"
                                            id="roleHelp"
                                        ></div>

                                    </div>



                                    {{-- =================================================
                                        EMAIL
                                    ================================================== --}}

                                    <div class="mb-3">

                                        <label
                                            for="email"
                                            class="form-label"
                                        >

                                            Email Address

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <input
                                            type="email"
                                            name="email"
                                            id="email"
                                            value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Enter your registered email address"
                                            autocomplete="email"
                                            required
                                        >


                                        @error('email')

                                            <div class="invalid-feedback">

                                                {{ $message }}

                                            </div>

                                        @enderror

                                    </div>



                                    {{-- =================================================
                                        QALAM ID
                                    ================================================== --}}

                                    <div
                                        class="mb-3"
                                        id="qalamField"
                                    >

                                        <label
                                            for="qalam_id"
                                            class="form-label"
                                        >

                                            Qalam ID

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <input
                                            type="text"
                                            name="qalam_id"
                                            id="qalam_id"
                                            value="{{ old('qalam_id') }}"
                                            class="form-control @error('qalam_id') is-invalid @enderror"
                                            placeholder="Enter your Qalam ID"
                                            inputmode="numeric"
                                            pattern="[0-9]+"
                                        >


                                        @error('qalam_id')

                                            <div class="invalid-feedback">

                                                {{ $message }}

                                            </div>

                                        @enderror


                                        <div class="form-text">

                                            Required only for beneficiary accounts.

                                        </div>

                                    </div>



                                    {{-- =================================================
                                        PASSWORD
                                    ================================================== --}}

                                    <div class="mb-3">

                                        <label
                                            for="password"
                                            class="form-label"
                                        >

                                            Password

                                            <span class="text-danger">
                                                *
                                            </span>

                                        </label>


                                        <div class="password-wrapper">

                                            <input
                                                type="password"
                                                name="password"
                                                id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Enter your password"
                                                autocomplete="current-password"
                                                required
                                            >


                                            <button
                                                type="button"
                                                class="password-toggle"
                                                id="passwordToggle"
                                                aria-label="Show password"
                                            >

                                                <i
                                                    class="bi bi-eye"
                                                    id="passwordIcon"
                                                ></i>

                                            </button>

                                        </div>


                                        @error('password')

                                            <div class="text-danger small mt-1">

                                                {{ $message }}

                                            </div>

                                        @enderror

                                    </div>



                                    {{-- =================================================
                                        REMEMBER
                                    ================================================== --}}

                                    <div
                                        class="d-flex justify-content-between align-items-center mb-4"
                                    >

                                        <div class="form-check">

                                            <input
                                                type="checkbox"
                                                name="remember"
                                                value="1"
                                                id="remember"
                                                class="form-check-input"
                                                {{ old('remember') ? 'checked' : '' }}
                                            >


                                            <label
                                                for="remember"
                                                class="form-check-label"
                                            >
                                                Remember me
                                            </label>

                                        </div>

                                    </div>



                                    {{-- =================================================
                                        LOGIN BUTTON
                                    ================================================== --}}

                                    <div class="d-grid">

                                        <button
                                            type="submit"
                                            class="btn btn-login"
                                            id="loginButton"
                                        >

                                            <span id="loginButtonContent">

                                                <i class="bi bi-box-arrow-in-right me-2"></i>

                                                Login to Account

                                            </span>


                                            <span
                                                id="loginButtonLoading"
                                                style="display:none;"
                                            >

                                                <span
                                                    class="spinner-border spinner-border-sm me-2"
                                                    role="status"
                                                ></span>

                                                Signing In...

                                            </span>

                                        </button>

                                    </div>

                                </form>



                                {{-- =================================================
                                    REGISTRATION
                                ================================================== --}}

                                <div class="register-area">

                                    <p>
                                        Want to contribute as a donor?
                                    </p>


                                    <a
                                        href="{{ route('register') }}"
                                        class="register-link"
                                    >

                                        <i class="bi bi-person-plus me-1"></i>

                                        Create Donor Account

                                    </a>

                                </div>



                                {{-- =================================================
                                    SECURITY
                                ================================================== --}}

                                <div class="security-note">

                                    <i class="bi bi-shield-lock"></i>

                                    Secure access to NUST Sharing Network

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@include('layouts.home.script')



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const role =
            document.getElementById(
                'role'
            );


        const qalamField =
            document.getElementById(
                'qalamField'
            );


        const qalamInput =
            document.getElementById(
                'qalam_id'
            );


        const roleHelp =
            document.getElementById(
                'roleHelp'
            );


        const password =
            document.getElementById(
                'password'
            );


        const passwordToggle =
            document.getElementById(
                'passwordToggle'
            );


        const passwordIcon =
            document.getElementById(
                'passwordIcon'
            );


        const loginForm =
            document.getElementById(
                'loginForm'
            );


        const loginButton =
            document.getElementById(
                'loginButton'
            );


        const loginButtonContent =
            document.getElementById(
                'loginButtonContent'
            );


        const loginButtonLoading =
            document.getElementById(
                'loginButtonLoading'
            );



        /*
        |--------------------------------------------------------------------------
        | Role / Qalam Logic
        |--------------------------------------------------------------------------
        */

        function updateRoleFields() {

            /*
            |--------------------------------------------------------------------------
            | Beneficiary
            |--------------------------------------------------------------------------
            */

            if (
                role.value ===
                'beneficiary'
            ) {

                qalamField.style.display =
                    'block';


                qalamInput.required =
                    true;


                roleHelp.style.display =
                    'block';


                roleHelp.innerHTML =
                    '<i class="bi bi-info-circle me-1"></i>' +
                    'Beneficiary login requires your registered email, Qalam ID and password.';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Admin
            |--------------------------------------------------------------------------
            */

            if (
                role.value ===
                'admin'
            ) {

                qalamField.style.display =
                    'none';


                qalamInput.required =
                    false;


                qalamInput.value =
                    '';


                roleHelp.style.display =
                    'block';


                roleHelp.innerHTML =
                    '<i class="bi bi-shield-check me-1"></i>' +
                    'Administrator accounts use email and password.';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Donor
            |--------------------------------------------------------------------------
            */

            if (
                role.value ===
                'donor'
            ) {

                qalamField.style.display =
                    'none';


                qalamInput.required =
                    false;


                qalamInput.value =
                    '';


                roleHelp.style.display =
                    'block';


                roleHelp.innerHTML =
                    '<i class="bi bi-box-seam me-1"></i>' +
                    'Donor accounts use the registered email address and password.';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Nothing Selected
            |--------------------------------------------------------------------------
            */

            qalamField.style.display =
                'none';


            qalamInput.required =
                false;


            qalamInput.value =
                '';


            roleHelp.style.display =
                'none';


            roleHelp.innerHTML =
                '';

        }



        /*
        |--------------------------------------------------------------------------
        | Role Change
        |--------------------------------------------------------------------------
        */

        role.addEventListener(
            'change',
            updateRoleFields
        );


        updateRoleFields();



        /*
        |--------------------------------------------------------------------------
        | Password Visibility
        |--------------------------------------------------------------------------
        */

        passwordToggle.addEventListener(
            'click',
            function () {

                if (
                    password.type ===
                    'password'
                ) {

                    password.type =
                        'text';


                    passwordIcon.classList.remove(
                        'bi-eye'
                    );


                    passwordIcon.classList.add(
                        'bi-eye-slash'
                    );


                    passwordToggle.setAttribute(
                        'aria-label',
                        'Hide password'
                    );

                } else {

                    password.type =
                        'password';


                    passwordIcon.classList.remove(
                        'bi-eye-slash'
                    );


                    passwordIcon.classList.add(
                        'bi-eye'
                    );


                    passwordToggle.setAttribute(
                        'aria-label',
                        'Show password'
                    );

                }

            }
        );



        /*
        |--------------------------------------------------------------------------
        | Prevent Multiple Login Submissions
        |--------------------------------------------------------------------------
        */

        loginForm.addEventListener(
            'submit',
            function () {

                loginButton.disabled =
                    true;


                loginButtonContent.style.display =
                    'none';


                loginButtonLoading.style.display =
                    'inline';

            }
        );

    }
);

</script>


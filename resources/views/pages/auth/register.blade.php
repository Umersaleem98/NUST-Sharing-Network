@include('layouts.home.head')
<title>Register - NUST Sharing Network</title>

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

        --nust-light: #eef6fb;

        --nust-soft: #f6f9fc;

        --nust-text: #22313f;

        --nust-muted: #6c7a89;

        --nust-border: #d9e3ea;

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

        background:
            linear-gradient(135deg,
                #eef6fb 0%,
                #f8fbfd 45%,
                #e5f0f7 100%);

        color: var(--nust-text);
    }


    /*
        |--------------------------------------------------------------------------
        | Background Decoration
        |--------------------------------------------------------------------------
        */

    .auth-wrapper {

        position: relative;

        min-height: 100vh;

        display: flex;

        align-items: center;

        padding: 45px 0;

        overflow: hidden;
    }


    .auth-wrapper::before {

        content: "";

        position: absolute;

        width: 420px;

        height: 420px;

        background:
            rgba(0,
                85,
                140,
                0.08);

        border-radius: 50%;

        top: -160px;

        left: -150px;
    }


    .auth-wrapper::after {

        content: "";

        position: absolute;

        width: 500px;

        height: 500px;

        background:
            rgba(0,
                114,
                188,
                0.07);

        border-radius: 50%;

        right: -200px;

        bottom: -240px;
    }


    /*
        |--------------------------------------------------------------------------
        | Registration Container
        |--------------------------------------------------------------------------
        */

    .registration-card {

        position: relative;

        z-index: 2;

        background: var(--white);

        border: none;

        border-radius: 22px;

        overflow: hidden;

        box-shadow:
            0 20px 60px rgba(24,
                63,
                88,
                0.13);
    }


    /*
        |--------------------------------------------------------------------------
        | Branding Side
        |--------------------------------------------------------------------------
        */

    .brand-panel {

        position: relative;

        height: 100%;

        padding: 55px 45px;

        color: var(--white);

        background:
            linear-gradient(150deg,
                var(--nust-primary-dark) 0%,
                var(--nust-primary) 50%,
                var(--nust-secondary) 100%);

        overflow: hidden;
    }


    .brand-panel::before {

        content: "";

        position: absolute;

        width: 280px;

        height: 280px;

        border:

            1px solid rgba(255,
                255,
                255,
                0.15);

        border-radius: 50%;

        right: -120px;

        top: -90px;
    }


    .brand-panel::after {

        content: "";

        position: absolute;

        width: 220px;

        height: 220px;

        background:
            rgba(255,
                255,
                255,
                0.05);

        border-radius: 50%;

        bottom: -100px;

        left: -80px;
    }


    .brand-content {

        position: relative;

        z-index: 2;
    }


    .brand-badge {

        display: inline-flex;

        align-items: center;

        gap: 10px;

        padding: 8px 15px;

        margin-bottom: 35px;

        background:
            rgba(255,
                255,
                255,
                0.11);

        border:

            1px solid rgba(255,
                255,
                255,
                0.16);

        border-radius: 50px;

        font-size: 13px;

        letter-spacing: 0.3px;
    }


    .brand-title {

        font-size: 37px;

        font-weight: 700;

        line-height: 1.22;

        margin-bottom: 20px;
    }


    .brand-description {

        font-size: 16px;

        line-height: 1.8;

        color:
            rgba(255,
                255,
                255,
                0.86);

        margin-bottom: 35px;
    }


    .benefit-item {

        display: flex;

        align-items: flex-start;

        gap: 13px;

        margin-bottom: 18px;

        color:
            rgba(255,
                255,
                255,
                0.94);
    }


    .benefit-icon {

        width: 34px;

        height: 34px;

        min-width: 34px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        background:
            rgba(255,
                255,
                255,
                0.12);

        border-radius: 9px;
    }


    /*
        |--------------------------------------------------------------------------
        | Form Side
        |--------------------------------------------------------------------------
        */

    .form-panel {

        padding: 48px 50px;
    }


    .form-heading {

        color: var(--nust-primary-dark);

        font-size: 29px;

        font-weight: 700;

        margin-bottom: 8px;
    }


    .form-subheading {

        color: var(--nust-muted);

        margin-bottom: 30px;
    }


    /*
        |--------------------------------------------------------------------------
        | Form Controls
        |--------------------------------------------------------------------------
        */

    .form-label {

        color: #34495e;

        font-size: 14px;

        font-weight: 600;

        margin-bottom: 8px;
    }


    .form-control,
    .form-select {

        min-height: 51px;

        border:

            1px solid var(--nust-border);

        border-radius: 10px;

        padding:
            11px 14px;

        color: var(--nust-text);

        background-color: #fff;

        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease;
    }


    .form-control:focus,
    .form-select:focus {

        border-color: var(--nust-primary);

        box-shadow:
            0 0 0 0.2rem rgba(0,
                85,
                140,
                0.12);
    }


    .form-select:disabled {

        background-color: #f5f8fa;

        color: #425466;

        opacity: 1;
    }


    /*
        |--------------------------------------------------------------------------
        | Input Group
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

        right: 5px;

        top: 50%;

        transform: translateY(-50%);

        width: 42px;

        height: 42px;

        border: none;

        background: transparent;

        color: #6c7a89;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 8px;

        cursor: pointer;
    }


    .password-toggle:hover {

        color: var(--nust-primary);

        background: var(--nust-light);
    }


    /*
        |--------------------------------------------------------------------------
        | Account Type
        |--------------------------------------------------------------------------
        */

    .account-type-note {

        padding: 12px 14px;

        margin-top: 10px;

        border-radius: 9px;

        background: var(--nust-light);

        color: #456276;

        font-size: 13px;

        line-height: 1.6;
    }


    /*
        |--------------------------------------------------------------------------
        | Button
        |--------------------------------------------------------------------------
        */

    .btn-register {

        min-height: 52px;

        border: none;

        border-radius: 10px;

        font-weight: 600;

        color: #ffffff;

        background:
            linear-gradient(135deg,
                var(--nust-primary),
                var(--nust-secondary));

        box-shadow:
            0 8px 18px rgba(0,
                85,
                140,
                0.18);

        transition:
            all 0.2s ease;
    }


    .btn-register:hover {

        color: #ffffff;

        transform:
            translateY(-1px);

        box-shadow:
            0 10px 22px rgba(0,
                85,
                140,
                0.25);
    }


    /*
        |--------------------------------------------------------------------------
        | Login Link
        |--------------------------------------------------------------------------
        */

    .login-link {

        color: var(--nust-primary);

        font-weight: 600;

        text-decoration: none;
    }


    .login-link:hover {

        color: var(--nust-primary-dark);

        text-decoration: underline;
    }


    /*
        |--------------------------------------------------------------------------
        | Security Text
        |--------------------------------------------------------------------------
        */

    .security-note {

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 7px;

        margin-top: 20px;

        color: #8795a1;

        font-size: 12px;
    }


    /*
        |--------------------------------------------------------------------------
        | Alert
        |--------------------------------------------------------------------------
        */

    .alert-danger {

        border: none;

        border-left:
            4px solid #dc3545;

        border-radius: 9px;

        background: #fff2f3;
    }


    /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

    @media (max-width: 991.98px) {

        .brand-panel {

            padding: 40px 35px;
        }


        .brand-title {

            font-size: 30px;
        }


        .form-panel {

            padding: 40px 35px;
        }

    }


    @media (max-width: 767.98px) {

        .auth-wrapper {

            padding: 25px 0;
        }


        .registration-card {

            border-radius: 16px;
        }


        .brand-panel {

            padding: 35px 28px;
        }


        .brand-title {

            font-size: 27px;
        }


        .brand-description {

            font-size: 14px;
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


    <div class="auth-wrapper">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-11">


                    <div class="registration-card">

                        <div class="row g-0">


                            {{-- =================================================
                            LEFT BRAND PANEL
                        ================================================== --}}

                            <div class="col-lg-5">

                                <div class="brand-panel">

                                    <div class="brand-content">


                                        <div class="brand-badge">

                                            <i class="bi bi-share-fill"></i>

                                            NUST Sharing Network

                                        </div>


                                        <h1 class="brand-title">

                                            Give More.

                                            <br>

                                            Share More.

                                            <br>

                                            Impact More.

                                        </h1>


                                        <p class="brand-description">

                                            Join the NUST Sharing Network as a donor
                                            and help make useful resources available
                                            to deserving beneficiaries within the
                                            community.

                                        </p>


                                        {{-- Benefit 1 --}}

                                        <div class="benefit-item">

                                            <div class="benefit-icon">

                                                <i class="bi bi-box-seam"></i>

                                            </div>

                                            <div>

                                                <strong>
                                                    Share Useful Products
                                                </strong>

                                                <div class="small opacity-75">

                                                    List products you want to donate
                                                    through a controlled platform.

                                                </div>

                                            </div>

                                        </div>


                                        {{-- Benefit 2 --}}

                                        <div class="benefit-item">

                                            <div class="benefit-icon">

                                                <i class="bi bi-shield-check"></i>

                                            </div>

                                            <div>

                                                <strong>
                                                    Reviewed Requests
                                                </strong>

                                                <div class="small opacity-75">

                                                    Beneficiary requests are reviewed
                                                    by administration before reaching you.

                                                </div>

                                            </div>

                                        </div>


                                        {{-- Benefit 3 --}}

                                        <div class="benefit-item">

                                            <div class="benefit-icon">

                                                <i class="bi bi-people"></i>

                                            </div>

                                            <div>

                                                <strong>
                                                    Support the Community
                                                </strong>

                                                <div class="small opacity-75">

                                                    Help connect available resources
                                                    with people who need them.

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            {{-- =================================================
                            REGISTRATION FORM
                        ================================================== --}}

                            <div class="col-lg-7">

                                <div class="form-panel">


                                    {{-- Heading --}}

                                    <div class="mb-4">

                                        <h2 class="form-heading">

                                            Create Donor Account

                                        </h2>


                                        <p class="form-subheading">

                                            Enter your information below to join
                                            the NUST Sharing Network.

                                        </p>

                                    </div>



                                    {{-- =================================================
                                    ERRORS
                                ================================================== --}}

                                    @if ($errors->any())

                                        <div class="alert alert-danger" role="alert">

                                            <div class="d-flex align-items-center mb-2">

                                                <i class="bi bi-exclamation-circle-fill me-2"></i>

                                                <strong>
                                                    Please correct the following:
                                                </strong>

                                            </div>


                                            <ul class="mb-0 ps-4">

                                                @foreach ($errors->all() as $error)
                                                    <li>
                                                        {{ $error }}
                                                    </li>
                                                @endforeach

                                            </ul>

                                        </div>

                                    @endif



                                    {{-- =================================================
                                    FORM
                                ================================================== --}}

                                    <form method="POST" action="{{ route('register.submit') }}">

                                        @csrf


                                        {{-- =================================================
                                        ROLE
                                    ================================================== --}}

                                        <input type="hidden" name="role" value="donor">



                                        {{-- =================================================
                                        NAME
                                    ================================================== --}}

                                        <div class="mb-3">

                                            <label for="name" class="form-label">

                                                Full Name

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <input type="text" name="name" id="name"
                                                value="{{ old('name') }}"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Enter your full name" autocomplete="name" required
                                                autofocus>


                                            @error('name')
                                                <div class="invalid-feedback">

                                                    {{ $message }}

                                                </div>
                                            @enderror

                                        </div>



                                        {{-- =================================================
                                        ACCOUNT TYPE
                                    ================================================== --}}

                                        <div class="mb-3">

                                            <label for="roleDisplay" class="form-label">

                                                Register As

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <select id="roleDisplay" class="form-select" disabled>

                                                <option value="donor" selected>
                                                    Donor
                                                </option>


                                                <option value="beneficiary" disabled>
                                                    Beneficiary — Registration Disabled
                                                </option>

                                            </select>


                                            <div class="account-type-note">

                                                <i class="bi bi-info-circle me-1"></i>

                                                Public registration is currently available
                                                for donors only. Beneficiary accounts are
                                                managed through the administration system.

                                            </div>

                                        </div>



                                        {{-- =================================================
                                        EMAIL
                                    ================================================== --}}

                                        <div class="mb-3">

                                            <label for="email" class="form-label">

                                                Email Address

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <input type="email" name="email" id="email"
                                                value="{{ old('email') }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="name@example.com" autocomplete="email" required>


                                            @error('email')
                                                <div class="invalid-feedback">

                                                    {{ $message }}

                                                </div>
                                            @enderror

                                        </div>



                                        {{-- =================================================
                                        PASSWORD
                                    ================================================== --}}

                                        <div class="mb-3">

                                            <label for="password" class="form-label">

                                                Password

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <div class="password-wrapper">

                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Create a secure password" autocomplete="new-password"
                                                    minlength="8" required>


                                                <button type="button" class="password-toggle"
                                                    data-password-target="password" aria-label="Show password">

                                                    <i class="bi bi-eye"></i>

                                                </button>

                                            </div>


                                            <div class="form-text">

                                                Use at least 8 characters.

                                            </div>


                                            @error('password')
                                                <div class="text-danger small mt-1">

                                                    {{ $message }}

                                                </div>
                                            @enderror

                                        </div>



                                        {{-- =================================================
                                        CONFIRM PASSWORD
                                    ================================================== --}}

                                        <div class="mb-4">

                                            <label for="password_confirmation" class="form-label">

                                                Confirm Password

                                                <span class="text-danger">
                                                    *
                                                </span>

                                            </label>


                                            <div class="password-wrapper">

                                                <input type="password" name="password_confirmation"
                                                    id="password_confirmation" class="form-control"
                                                    placeholder="Re-enter your password" autocomplete="new-password"
                                                    minlength="8" required>


                                                <button type="button" class="password-toggle"
                                                    data-password-target="password_confirmation"
                                                    aria-label="Show confirmation password">

                                                    <i class="bi bi-eye"></i>

                                                </button>

                                            </div>

                                        </div>



                                        {{-- =================================================
                                        SUBMIT
                                    ================================================== --}}

                                        <div class="d-grid">

                                            <button type="submit" class="btn btn-register">

                                                <i class="bi bi-person-plus me-2"></i>

                                                Create Donor Account

                                            </button>

                                        </div>

                                    </form>



                                    {{-- =================================================
                                    LOGIN
                                ================================================== --}}

                                    <div class="text-center mt-4">

                                        <span class="text-muted">

                                            Already have an account?

                                        </span>


                                        <a href="{{ route('login') }}" class="login-link ms-1">

                                            Login here

                                        </a>

                                    </div>



                                    {{-- =================================================
                                    SECURITY
                                ================================================== --}}

                                    <div class="security-note">

                                        <i class="bi bi-shield-lock"></i>

                                        Your account information is securely protected.

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


    {{-- =========================================================
    PASSWORD TOGGLE
========================================================== --}}

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                /*
                |--------------------------------------------------------------------------
                | Password Visibility
                |--------------------------------------------------------------------------
                */

                const passwordButtons =
                    document.querySelectorAll(
                        '.password-toggle'
                    );


                passwordButtons.forEach(
                    function(button) {

                        button.addEventListener(
                            'click',
                            function() {

                                const targetId =
                                    button.getAttribute(
                                        'data-password-target'
                                    );


                                const input =
                                    document.getElementById(
                                        targetId
                                    );


                                const icon =
                                    button.querySelector(
                                        'i'
                                    );


                                if (
                                    input.type ===
                                    'password'
                                ) {

                                    input.type =
                                        'text';


                                    icon.classList.remove(
                                        'bi-eye'
                                    );


                                    icon.classList.add(
                                        'bi-eye-slash'
                                    );


                                    button.setAttribute(
                                        'aria-label',
                                        'Hide password'
                                    );

                                } else {

                                    input.type =
                                        'password';


                                    icon.classList.remove(
                                        'bi-eye-slash'
                                    );


                                    icon.classList.add(
                                        'bi-eye'
                                    );


                                    button.setAttribute(
                                        'aria-label',
                                        'Show password'
                                    );
                                }

                            }
                        );

                    }
                );

            }
        );
    </script>

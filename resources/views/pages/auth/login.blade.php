@include('layouts.admin.head')

<title>Login | NUST Sharing Network</title>

<style>
    :root {
        --auth-primary: #0065a8;
        --auth-primary-dark: #003f6b;
        --auth-primary-light: #eaf5fc;
        --auth-accent: #f5a623;
        --auth-text: #17212b;
        --auth-muted: #667481;
        --auth-border: #dce5ec;
        --auth-white: #ffffff;
        --auth-background: #f4f8fb;
        --auth-danger: #dc3545;
        --auth-danger-light: #fff2f2;
        --auth-font: "Inter", "Segoe UI", Arial, sans-serif;
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        min-height: 100%;
        margin: 0;
    }

    body,
    input,
    select,
    button,
    textarea,
    label,
    a,
    p,
    span,
    small,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: var(--auth-font) !important;
    }

    body {
        min-height: 100vh;
        color: var(--auth-text);
        background-color: var(--auth-background);
    }

    .auth-page {
        position: relative;
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

    /* Left panel */
    .auth-information {
        position: relative;
        display: flex;
        flex: 0 0 42%;
        align-items: center;
        padding: 55px 65px;
        overflow: hidden;
        color: var(--auth-white);
        background:
            linear-gradient(
                135deg,
                rgba(0, 63, 107, 0.97),
                rgba(0, 101, 168, 0.90)
            ),
            url('{{ asset('admins/assets/images/backgrounds/nust-campus.jpg') }}')
            center center / cover no-repeat;
    }

    .auth-information::before,
    .auth-information::after {
        position: absolute;
        border-radius: 50%;
        content: "";
        pointer-events: none;
    }

    .auth-information::before {
        top: -180px;
        right: -130px;
        width: 420px;
        height: 420px;
        border: 70px solid rgba(255, 255, 255, 0.06);
    }

    .auth-information::after {
        bottom: -180px;
        left: -130px;
        width: 400px;
        height: 400px;
        background-color: rgba(245, 166, 35, 0.10);
    }

    .information-content {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 580px;
        margin: auto;
    }

    .brand-logo-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        padding: 12px 18px;
        border-radius: 14px;
        background-color: rgba(255, 255, 255, 0.96);
    }

    .brand-logo-wrapper img {
        display: block;
        width: 145px;
        max-height: 70px;
        object-fit: contain;
    }

    .information-badge {
        display: inline-flex;
        gap: 9px;
        align-items: center;
        margin-bottom: 18px;
        padding: 8px 14px;
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 50rem;
        background-color: rgba(255, 255, 255, 0.10);
        font-size: 0.84rem;
        font-weight: 600;
        letter-spacing: 0.4px;
    }

    .information-badge::before {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--auth-accent);
        content: "";
    }

    .information-content h1 {
        max-width: 540px;
        margin: 0 0 18px;
        color: var(--auth-white);
        font-size: clamp(2.2rem, 3.5vw, 3.6rem);
        font-weight: 750;
        line-height: 1.12;
    }

    .information-description {
        max-width: 530px;
        margin: 0 0 30px;
        color: rgba(255, 255, 255, 0.82);
        font-size: 1rem;
        line-height: 1.75;
    }

    .platform-features {
        display: grid;
        gap: 13px;
    }

    .platform-feature {
        display: flex;
        gap: 13px;
        align-items: center;
    }

    .feature-icon {
        display: flex;
        flex: 0 0 40px;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 11px;
        color: var(--auth-primary-dark);
        background-color: var(--auth-accent);
        font-size: 1rem;
    }

    .feature-content strong {
        display: block;
        margin-bottom: 2px;
        color: var(--auth-white);
        font-size: 0.93rem;
        font-weight: 700;
    }

    .feature-content span {
        color: rgba(255, 255, 255, 0.68);
        font-size: 0.82rem;
    }

    /* Right form panel */
    .auth-form-panel {
        position: relative;
        display: flex;
        flex: 1;
        align-items: center;
        justify-content: center;
        padding: 40px 55px;
        overflow-y: auto;
        background-color: #f7fafc;
    }

    .auth-form-panel::before {
        position: absolute;
        top: 0;
        right: 0;
        width: 220px;
        height: 220px;
        border-radius: 0 0 0 100%;
        background-color: var(--auth-primary-light);
        content: "";
    }

    .login-container {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 650px;
        padding: 15px 0;
    }

    .mobile-logo {
        display: none;
        margin-bottom: 22px;
        text-align: center;
    }

    .mobile-logo img {
        width: 135px;
        max-height: 65px;
        object-fit: contain;
    }

    .login-heading {
        margin-bottom: 25px;
    }

    .login-heading h2 {
        margin: 0 0 9px;
        color: var(--auth-text);
        font-size: 2rem;
        font-weight: 750;
    }

    .login-heading p {
        margin: 0;
        color: var(--auth-muted);
        line-height: 1.6;
    }

    /* Alerts */
    .login-alert {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 22px;
        padding: 14px 16px;
        border: 1px solid #f2c5c5;
        border-radius: 12px;
        color: #a12b2b;
        background-color: var(--auth-danger-light);
        font-size: 0.88rem;
    }

    .login-alert-icon {
        flex-shrink: 0;
        margin-top: 2px;
    }

    .login-alert strong {
        display: block;
        margin-bottom: 5px;
    }

    .login-alert ul {
        margin: 0;
        padding-left: 18px;
    }

    /* Form */
    .form-field {
        margin-bottom: 17px;
    }

    .login-label {
        display: block;
        margin-bottom: 8px;
        color: var(--auth-text);
        font-size: 0.88rem;
        font-weight: 650;
    }

    .required-mark {
        color: var(--auth-danger);
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        top: 50%;
        left: 16px;
        z-index: 2;
        color: #83919d;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .login-control {
        display: block;
        width: 100%;
        height: 50px;
        padding: 10px 16px 10px 45px;
        border: 1px solid var(--auth-border);
        border-radius: 11px;
        outline: none;
        color: var(--auth-text);
        background-color: var(--auth-white);
        font-size: 0.93rem;
        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease;
    }

    select.login-control {
        cursor: pointer;
    }

    .login-control::placeholder {
        color: #9aa5ae;
    }

    /* Remove number input arrows in Chrome, Edge, Safari and Opera */
    .login-control[type="number"]::-webkit-outer-spin-button,
    .login-control[type="number"]::-webkit-inner-spin-button {
        margin: 0;
        -webkit-appearance: none;
    }

    /* Remove number input arrows in Firefox */
    .login-control[type="number"] {
        appearance: textfield;
        -moz-appearance: textfield;
    }

    .login-control:hover {
        border-color: #a9bbc8;
    }

    .login-control:focus {
        border-color: var(--auth-primary);
        box-shadow: 0 0 0 4px rgba(0, 101, 168, 0.10);
    }

    .login-control.is-invalid {
        border-color: var(--auth-danger);
    }

    .field-error {
        display: block;
        margin-top: 6px;
        color: var(--auth-danger);
        font-size: 0.8rem;
    }

    .password-control {
        padding-right: 52px;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        padding: 0;
        border: 0;
        border-radius: 9px;
        color: #697884;
        background: transparent;
        cursor: pointer;
        transform: translateY(-50%);
        transition:
            color 0.2s ease,
            background-color 0.2s ease;
    }

    .password-toggle:hover {
        color: var(--auth-primary);
        background-color: var(--auth-primary-light);
    }

    .form-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .remember-wrapper {
        display: inline-flex;
        gap: 8px;
        align-items: center;
        margin: 0;
        color: var(--auth-muted);
        font-size: 0.9rem;
        cursor: pointer;
    }

    .remember-wrapper input {
        width: 17px;
        height: 17px;
        margin: 0;
        accent-color: var(--auth-primary);
        cursor: pointer;
    }

    .btn-login {
        display: flex;
        gap: 10px;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 52px;
        padding: 10px 20px;
        border: 0;
        border-radius: 12px;
        color: var(--auth-white);
        background: linear-gradient(
            135deg,
            var(--auth-primary),
            var(--auth-primary-dark)
        );
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 0.4px;
        cursor: pointer;
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .btn-login:hover {
        color: var(--auth-white);
        box-shadow: 0 10px 24px rgba(0, 76, 128, 0.25);
        transform: translateY(-2px);
    }

    .btn-login:active {
        box-shadow: none;
        transform: translateY(0);
    }

    .btn-login:disabled {
        cursor: not-allowed;
        opacity: 0.7;
        transform: none;
    }

    .register-link {
        margin: 18px 0 0;
        color: var(--auth-muted);
        font-size: 0.86rem;
        text-align: center;
    }

    .register-link a {
        color: var(--auth-primary);
        font-weight: 700;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    .login-support {
        margin: 22px 0 0;
        color: var(--auth-muted);
        font-size: 0.85rem;
        line-height: 1.6;
        text-align: center;
    }

    .login-support i {
        margin-right: 5px;
        color: var(--auth-primary);
    }

    /* Tablet */
    @media (max-width: 991.98px) {
        .auth-information {
            flex-basis: 42%;
            padding: 45px 35px;
        }

        .information-content h1 {
            font-size: 2.5rem;
        }

        .auth-form-panel {
            padding: 40px 35px;
        }
    }

    /* Mobile */
    @media (max-width: 767.98px) {
        .auth-page {
            display: block;
        }

        .auth-information {
            display: none;
        }

        .auth-form-panel {
            min-height: 100vh;
            padding: 35px 20px;
        }

        .auth-form-panel::before {
            width: 130px;
            height: 130px;
        }

        .mobile-logo {
            display: block;
        }

        .login-container {
            max-width: 520px;
        }

        .login-heading {
            margin-bottom: 24px;
            text-align: center;
        }

        .login-heading h2 {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 420px) {
        .auth-form-panel {
            align-items: flex-start;
            padding: 25px 15px;
        }

        .login-heading h2 {
            font-size: 1.55rem;
        }

        .login-control,
        .btn-login {
            height: 50px;
        }
    }
</style>

<body>


    <main class="auth-page">
        {{-- ================================================= --}}
        {{-- LEFT INFORMATION PANEL --}}
        {{-- ================================================= --}}
        <section class="auth-information mt-5">

            <div class="information-content">

                {{-- Logo --}}
                <div class="brand-logo-wrapper">
                    <img
                        src="{{ asset('admins/assets/images/logos/logo.png') }}"
                        alt="NUST Sharing Network"
                    >
                </div>


                <div class="information-badge">
                    NUST Community Initiative
                </div>


                <h1>
                    Share More.<br>
                    Support Others.
                </h1>


                <p class="information-description">
                    NUST Sharing Network connects donors with beneficiaries
                    through a secure and transparent platform, helping useful
                    resources reach the people who need them most.
                </p>


                <div class="platform-features">

                    <div class="platform-feature">

                        <div class="feature-icon">
                            <i class="fa fa-shield"></i>
                        </div>

                        <div class="feature-content">
                            <strong>Secure and Verified</strong>

                            <span>
                                Protected access for every registered user
                            </span>
                        </div>

                    </div>


                    <div class="platform-feature">

                        <div class="feature-icon">
                            <i class="fa fa-handshake"></i>
                        </div>

                        <div class="feature-content">
                            <strong>Community Support</strong>

                            <span>
                                Connecting donors with deserving beneficiaries
                            </span>
                        </div>

                    </div>


                    <div class="platform-feature">

                        <div class="feature-icon">
                            <i class="fa fa-gift"></i>
                        </div>

                        <div class="feature-content">
                            <strong>Meaningful Sharing</strong>

                            <span>
                                Give useful items a new purpose
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ================================================= --}}
        {{-- LOGIN PANEL --}}
        {{-- ================================================= --}}
        <section class="auth-form-panel">

            <div class="login-container">

                {{-- Mobile Logo --}}
                <div class="mobile-logo">
                    <img
                        src="{{ asset('admins/assets/images/logos/logo.png') }}"
                        alt="NUST Sharing Network"
                    >
                </div>


                {{-- Heading --}}
                <div class="login-heading">

                    <h2>Welcome Back</h2>

                    <p>
                        Select your role and enter your account details
                        to access the Sharing Network.
                    </p>

                </div>


                {{-- Validation Errors --}}
                @if ($errors->any())

                    <div class="login-alert" role="alert">

                        <i class="fa fa-exclamation-circle login-alert-icon"></i>

                        <div>
                            <strong>
                                Please correct the following:
                            </strong>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                @endif


                {{-- Login Form --}}
                <form
                    method="POST"
                    action="{{ route('login.post') }}"
                    id="loginForm"
                >
                    @csrf


                    {{-- Role --}}
                    <div class="form-field">

                        <label
                            for="role"
                            class="login-label"
                        >
                            Sign in as
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="fa fa-users input-icon"></i>

                            <select
                                name="role"
                                id="role"
                                class="login-control @error('role') is-invalid @enderror"
                                required
                            >
                                <option value="">
                                    Select your role
                                </option>

                                <option
                                    value="beneficiary"
                                    @selected(old('role') === 'beneficiary')
                                >
                                    Beneficiary
                                </option>

                                <option
                                    value="donor"
                                    @selected(old('role') === 'donor')
                                >
                                    Donor
                                </option>

                                <option
                                    value="admin"
                                    @selected(old('role') === 'admin')
                                >
                                    Administrator
                                </option>
                            </select>

                        </div>

                        @error('role')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- Qalam ID --}}
                    <div
                        class="form-field"
                        id="qalamIdField"
                        @if (old('role') !== 'beneficiary')
                            hidden
                        @endif
                    >
                        <label
                            for="qalam_id"
                            class="login-label"
                        >
                            Qalam ID
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="fa fa-id-card input-icon"></i>

                            <input
                                type="number"
                                name="qalam_id"
                                id="qalam_id"
                                value="{{ old('qalam_id') }}"
                                class="login-control @error('qalam_id') is-invalid @enderror"
                                placeholder="Enter your Qalam ID"
                                inputmode="numeric"
                                autocomplete="off"
                                @if (old('role') === 'beneficiary')
                                    required
                                @endif
                            >

                        </div>

                        @error('qalam_id')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- Email --}}
                    <div class="form-field">

                        <label
                            for="email"
                            class="login-label"
                        >
                            Email Address
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="fa fa-envelope input-icon"></i>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="login-control @error('email') is-invalid @enderror"
                                placeholder="Enter your email address"
                                autocomplete="email"
                                required
                            >

                        </div>

                        @error('email')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- Password --}}
                    <div class="form-field">

                        <label
                            for="password"
                            class="login-label"
                        >
                            Password
                            <span class="required-mark">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="fa fa-lock input-icon"></i>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="login-control password-control @error('password') is-invalid @enderror"
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
                                    class="fa fa-eye"
                                    id="passwordIcon"
                                ></i>
                            </button>

                        </div>

                        @error('password')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- Remember Me --}}
                    <div class="form-options">

                        <label class="remember-wrapper">

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                @checked(old('remember'))
                            >

                            <span>
                                Keep me signed in
                            </span>

                        </label>

                    </div>


                    {{-- Submit Button --}}
                    <button
                        type="submit"
                        class="btn-login"
                        id="loginButton"
                    >
                        <span id="loginButtonText">
                            Sign In Securely
                        </span>

                        <i
                            class="fa fa-arrow-right"
                            id="loginButtonIcon"
                        ></i>
                    </button>


                    {{-- Donor Registration Link --}}
                    <p class="register-link">
                        Don&rsquo;t have a donor account?

                        <a href="{{ route('register') }}">
                            Register as a Donor
                        </a>
                    </p>


                    <p class="login-support">
                        <i class="fa fa-lock"></i>

                        Your account information is protected and securely
                        processed.
                    </p>

                </form>

            </div>

        </section>

    </main>


    @include('layouts.admin.script')


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect =
                document.getElementById('role');

            const qalamIdField =
                document.getElementById('qalamIdField');

            const qalamIdInput =
                document.getElementById('qalam_id');

            const passwordInput =
                document.getElementById('password');

            const passwordToggle =
                document.getElementById('passwordToggle');

            const passwordIcon =
                document.getElementById('passwordIcon');

            const loginForm =
                document.getElementById('loginForm');

            const loginButton =
                document.getElementById('loginButton');

            const loginButtonText =
                document.getElementById('loginButtonText');

            const loginButtonIcon =
                document.getElementById('loginButtonIcon');


            /*
            |--------------------------------------------------------------------------
            | Show Qalam ID Only for Beneficiary
            |--------------------------------------------------------------------------
            */

            function updateQalamField() {
                if (
                    !roleSelect ||
                    !qalamIdField ||
                    !qalamIdInput
                ) {
                    return;
                }

                const isBeneficiary =
                    roleSelect.value === 'beneficiary';

                qalamIdField.hidden = !isBeneficiary;
                qalamIdInput.required = isBeneficiary;

                if (!isBeneficiary) {
                    qalamIdInput.value = '';
                }
            }


            if (roleSelect) {
                roleSelect.addEventListener(
                    'change',
                    updateQalamField
                );

                updateQalamField();
            }


            /*
            |--------------------------------------------------------------------------
            | Password Visibility
            |--------------------------------------------------------------------------
            */

            if (
                passwordInput &&
                passwordToggle &&
                passwordIcon
            ) {
                passwordToggle.addEventListener(
                    'click',
                    function () {
                        const passwordIsHidden =
                            passwordInput.type === 'password';

                        passwordInput.type =
                            passwordIsHidden
                                ? 'text'
                                : 'password';

                        passwordIcon.classList.toggle(
                            'fa-eye',
                            !passwordIsHidden
                        );

                        passwordIcon.classList.toggle(
                            'fa-eye-slash',
                            passwordIsHidden
                        );

                        passwordToggle.setAttribute(
                            'aria-label',
                            passwordIsHidden
                                ? 'Hide password'
                                : 'Show password'
                        );
                    }
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Prevent Multiple Login Submissions
            |--------------------------------------------------------------------------
            */

            if (
                loginForm &&
                loginButton &&
                loginButtonText &&
                loginButtonIcon
            ) {
                loginForm.addEventListener(
                    'submit',
                    function () {
                        loginButton.disabled = true;

                        loginButtonText.textContent =
                            'Signing In...';

                        loginButtonIcon.className =
                            'fa fa-spinner fa-spin';
                    }
                );
            }
        });
    </script>

</body>

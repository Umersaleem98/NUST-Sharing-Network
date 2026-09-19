@include('layouts.admin.head')

<title>Forgot Password | NUST Sharing Network</title>

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
        --auth-success: #198754;
        --auth-success-light: #effaf3;
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
    button,
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
        background: var(--auth-background);
    }

    .auth-page {
        display: flex;
        min-height: 100vh;
        overflow: hidden;
    }

    .auth-information {
        position: relative;
        display: flex;
        flex: 0 0 42%;
        align-items: center;
        padding: 55px 65px;
        overflow: hidden;
        color: #fff;
        background:
            linear-gradient(
                135deg,
                rgba(0, 63, 107, 0.97),
                rgba(0, 101, 168, 0.90)
            ),
            url('{{ asset('admins/assets/images/backgrounds/nust-campus.jpg') }}')
            center center / cover no-repeat;
    }

    .auth-information::before {
        position: absolute;
        top: -180px;
        right: -130px;
        width: 420px;
        height: 420px;
        border: 70px solid rgba(255, 255, 255, 0.06);
        border-radius: 50%;
        content: "";
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
        background: rgba(255, 255, 255, 0.96);
    }

    .brand-logo-wrapper img {
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
        background: rgba(255, 255, 255, 0.10);
        font-size: 0.84rem;
        font-weight: 600;
    }

    .information-content h1 {
        max-width: 540px;
        margin: 0 0 18px;
        color: #fff;
        font-size: clamp(2.1rem, 3.5vw, 3.4rem);
        font-weight: 750;
        line-height: 1.12;
    }

    .information-description {
        max-width: 530px;
        margin: 0;
        color: rgba(255, 255, 255, 0.82);
        line-height: 1.75;
    }

    .auth-form-panel {
        position: relative;
        display: flex;
        flex: 1;
        align-items: center;
        justify-content: center;
        padding: 40px 55px;
        overflow-y: auto;
        background: #f7fafc;
    }

    .auth-form-panel::before {
        position: absolute;
        top: 0;
        right: 0;
        width: 220px;
        height: 220px;
        border-radius: 0 0 0 100%;
        background: var(--auth-primary-light);
        content: "";
    }

    .auth-container {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 610px;
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

    .auth-heading {
        margin-bottom: 25px;
    }

    .auth-heading h2 {
        margin: 0 0 9px;
        color: var(--auth-text);
        font-size: 2rem;
        font-weight: 750;
    }

    .auth-heading p {
        margin: 0;
        color: var(--auth-muted);
        line-height: 1.65;
    }

    .security-notice {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 22px;
        padding: 14px 16px;
        border: 1px solid #d8e7f2;
        border-radius: 12px;
        color: #41586a;
        background: #f5faff;
        font-size: 0.86rem;
        line-height: 1.6;
    }

    .auth-alert {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 20px;
        padding: 14px 16px;
        border-radius: 12px;
        font-size: 0.87rem;
    }

    .auth-alert-danger {
        border: 1px solid #f2c5c5;
        color: #a12b2b;
        background: var(--auth-danger-light);
    }

    .auth-alert-success {
        border: 1px solid #b9e1c8;
        color: #146c43;
        background: var(--auth-success-light);
    }

    .auth-alert ul {
        margin: 5px 0 0;
        padding-left: 18px;
    }

    .form-field {
        margin-bottom: 18px;
    }

    .auth-label {
        display: block;
        margin-bottom: 8px;
        color: var(--auth-text);
        font-size: 0.88rem;
        font-weight: 650;
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

    .auth-control {
        width: 100%;
        height: 50px;
        padding: 10px 16px 10px 45px;
        border: 1px solid var(--auth-border);
        border-radius: 11px;
        outline: none;
        color: var(--auth-text);
        background: #fff;
        font-size: 0.93rem;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .auth-control:focus {
        border-color: var(--auth-primary);
        box-shadow: 0 0 0 4px rgba(0, 101, 168, 0.10);
    }

    .auth-control.is-invalid {
        border-color: var(--auth-danger);
    }

    .field-error {
        display: block;
        margin-top: 6px;
        color: var(--auth-danger);
        font-size: 0.8rem;
    }

    .btn-auth {
        display: flex;
        gap: 10px;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 52px;
        border: 0;
        border-radius: 12px;
        color: #fff;
        background: linear-gradient(
            135deg,
            var(--auth-primary),
            var(--auth-primary-dark)
        );
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .btn-auth:hover {
        color: #fff;
        box-shadow: 0 10px 24px rgba(0, 76, 128, 0.25);
        transform: translateY(-2px);
    }

    .btn-auth:disabled {
        cursor: not-allowed;
        opacity: .7;
        transform: none;
    }

    .back-link {
        margin-top: 20px;
        text-align: center;
    }

    .back-link a {
        color: var(--auth-primary);
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
    }

    .back-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 991.98px) {
        .auth-information {
            padding: 45px 35px;
        }

        .auth-form-panel {
            padding: 40px 35px;
        }
    }

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

        .mobile-logo {
            display: block;
        }

        .auth-heading {
            text-align: center;
        }
    }
</style>

<body>

    <main class="auth-page">

        <section class="auth-information">

            <div class="information-content">

                <div class="brand-logo-wrapper">
                    <img
                        src="{{ asset('admins/assets/images/logos/logo.png') }}"
                        alt="NUST Sharing Network"
                    >
                </div>

                <div class="information-badge">
                    Secure Account Recovery
                </div>

                <h1>
                    Recover Access.<br>
                    Stay Secure.
                </h1>

                <p class="information-description">
                    Enter your registered email address. We will send a secure
                    password reset link that lets you create a new password.
                </p>

            </div>

        </section>


        <section class="auth-form-panel">

            <div class="auth-container">

                <div class="mobile-logo">
                    <img
                        src="{{ asset('admins/assets/images/logos/logo.png') }}"
                        alt="NUST Sharing Network"
                    >
                </div>


                <div class="auth-heading">
                    <h2>Forgot Password?</h2>

                    <p>
                        Enter the email address registered with your NUST Sharing
                        Network account.
                    </p>
                </div>


                <div class="security-notice">
                    <i class="fa fa-shield mt-1"></i>

                    <div>
                        For your security, the password can only be changed after
                        opening the reset link sent to your registered email.
                    </div>
                </div>


                @if (session('status'))

                    <div class="auth-alert auth-alert-success">
                        <i class="fa fa-check-circle mt-1"></i>

                        <div>
                            {{ session('status') }}
                        </div>
                    </div>

                @endif


                @if ($errors->any())

                    <div class="auth-alert auth-alert-danger">
                        <i class="fa fa-exclamation-circle mt-1"></i>

                        <div>
                            <strong>Please correct the following:</strong>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('password.email') }}"
                    id="forgotPasswordForm"
                >
                    @csrf

                    <div class="form-field">

                        <label
                            for="email"
                            class="auth-label"
                        >
                            Registered Email Address
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="fa fa-envelope input-icon"></i>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', session('email')) }}"
                                class="auth-control @error('email') is-invalid @enderror"
                                placeholder="Enter your registered email"
                                autocomplete="email"
                                required
                                autofocus
                            >

                        </div>

                        @error('email')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <button
                        type="submit"
                        class="btn-auth"
                        id="resetLinkButton"
                    >
                        <span id="resetLinkText">
                            Send Password Reset Link
                        </span>

                        <i
                            class="fa fa-paper-plane"
                            id="resetLinkIcon"
                        ></i>
                    </button>

                </form>


                <div class="back-link">
                    <a href="{{ route('login') }}">
                        <i class="fa fa-arrow-left me-1"></i>
                        Back to Sign In
                    </a>
                </div>

            </div>

        </section>

    </main>


    @include('layouts.admin.script')


    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function () {
                const form =
                    document.getElementById(
                        'forgotPasswordForm'
                    );

                const button =
                    document.getElementById(
                        'resetLinkButton'
                    );

                const buttonText =
                    document.getElementById(
                        'resetLinkText'
                    );

                const buttonIcon =
                    document.getElementById(
                        'resetLinkIcon'
                    );


                if (
                    form &&
                    button &&
                    buttonText &&
                    buttonIcon
                ) {
                    form.addEventListener(
                        'submit',
                        function () {
                            button.disabled = true;

                            buttonText.textContent =
                                'Sending Reset Link...';

                            buttonIcon.className =
                                'fa fa-spinner fa-spin';
                        }
                    );
                }
            }
        );
    </script>

</body>

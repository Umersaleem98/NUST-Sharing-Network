@include('layouts.admin.head')

<title>Reset Password | NUST Sharing Network</title>

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
        padding: 38px 55px;
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
        max-width: 620px;
        padding: 15px 0;
    }

    .mobile-logo {
        display: none;
        margin-bottom: 20px;
        text-align: center;
    }

    .mobile-logo img {
        width: 135px;
        max-height: 65px;
        object-fit: contain;
    }

    .auth-heading {
        margin-bottom: 22px;
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
        line-height: 1.6;
    }

    .auth-alert {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 18px;
        padding: 14px 16px;
        border: 1px solid #f2c5c5;
        border-radius: 12px;
        color: #a12b2b;
        background: var(--auth-danger-light);
        font-size: 0.87rem;
    }

    .auth-alert ul {
        margin: 5px 0 0;
        padding-left: 18px;
    }

    .form-field {
        margin-bottom: 16px;
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
        padding: 10px 50px 10px 45px;
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
    }

    .password-toggle:hover {
        color: var(--auth-primary);
        background: var(--auth-primary-light);
    }

    .password-requirements {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
        margin: 10px 0 18px;
        padding: 14px;
        border: 1px solid var(--auth-border);
        border-radius: 12px;
        background: #fff;
    }

    .requirement {
        display: flex;
        gap: 7px;
        align-items: center;
        color: var(--auth-muted);
        font-size: 0.78rem;
    }

    .requirement i {
        width: 14px;
        color: #98a2b3;
        text-align: center;
    }

    .requirement.valid {
        color: #146c43;
    }

    .requirement.valid i {
        color: var(--auth-success);
    }

    .strength-box {
        margin-bottom: 18px;
    }

    .strength-track {
        height: 7px;
        overflow: hidden;
        border-radius: 999px;
        background: #e9eef2;
    }

    .strength-bar {
        width: 0;
        height: 100%;
        border-radius: 999px;
        background: var(--auth-danger);
        transition: width .2s ease, background .2s ease;
    }

    .strength-label {
        margin-top: 6px;
        color: var(--auth-muted);
        font-size: 0.78rem;
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

    .btn-auth:hover:not(:disabled) {
        color: #fff;
        box-shadow: 0 10px 24px rgba(0, 76, 128, 0.25);
        transform: translateY(-2px);
    }

    .btn-auth:disabled {
        cursor: not-allowed;
        opacity: .55;
    }

    .back-link {
        margin-top: 18px;
        text-align: center;
    }

    .back-link a {
        color: var(--auth-primary);
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
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
            padding: 30px 20px;
        }

        .mobile-logo {
            display: block;
        }

        .auth-heading {
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .password-requirements {
            grid-template-columns: 1fr;
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
                    Secure Password Reset
                </div>

                <h1>
                    Create a Stronger<br>
                    Password.
                </h1>

                <p class="information-description">
                    Choose a new password that is difficult to guess and unique to
                    your NUST Sharing Network account.
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
                    <h2>Reset Password</h2>

                    <p>
                        Enter and confirm your new password below.
                    </p>
                </div>


                @if ($errors->any())

                    <div class="auth-alert">

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
                    action="{{ route('password.update') }}"
                    id="resetPasswordForm"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="token"
                        value="{{ $token }}"
                    >


                    <div class="form-field">

                        <label
                            for="email"
                            class="auth-label"
                        >
                            Account Email
                        </label>

                        <div class="input-wrapper">

                            <i class="fa fa-envelope input-icon"></i>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $email) }}"
                                class="auth-control @error('email') is-invalid @enderror"
                                placeholder="Enter your registered email"
                                autocomplete="email"
                                required
                                @if (! empty($email))
                                    readonly
                                @endif
                            >

                        </div>

                        @error('email')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <div class="form-field">

                        <label
                            for="password"
                            class="auth-label"
                        >
                            New Password
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="fa fa-lock input-icon"></i>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="auth-control @error('password') is-invalid @enderror"
                                placeholder="Create a strong password"
                                autocomplete="new-password"
                                required
                                autofocus
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-password-target="password"
                                aria-label="Show password"
                            >
                                <i class="fa fa-eye"></i>
                            </button>

                        </div>

                        @error('password')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <div class="password-requirements">

                        <div
                            class="requirement"
                            id="requirementLength"
                        >
                            <i class="fa fa-circle"></i>
                            At least 8 characters
                        </div>

                        <div
                            class="requirement"
                            id="requirementUpper"
                        >
                            <i class="fa fa-circle"></i>
                            One uppercase letter
                        </div>

                        <div
                            class="requirement"
                            id="requirementLower"
                        >
                            <i class="fa fa-circle"></i>
                            One lowercase letter
                        </div>

                        <div
                            class="requirement"
                            id="requirementNumber"
                        >
                            <i class="fa fa-circle"></i>
                            One number
                        </div>

                        <div
                            class="requirement"
                            id="requirementSymbol"
                        >
                            <i class="fa fa-circle"></i>
                            One special character
                        </div>

                        <div
                            class="requirement"
                            id="requirementMatch"
                        >
                            <i class="fa fa-circle"></i>
                            Passwords match
                        </div>

                    </div>


                    <div class="strength-box">

                        <div class="strength-track">
                            <div
                                class="strength-bar"
                                id="strengthBar"
                            ></div>
                        </div>

                        <div
                            class="strength-label"
                            id="strengthLabel"
                        >
                            Password strength: not entered
                        </div>

                    </div>


                    <div class="form-field">

                        <label
                            for="password_confirmation"
                            class="auth-label"
                        >
                            Confirm New Password
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-wrapper">

                            <i class="fa fa-lock input-icon"></i>

                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="auth-control"
                                placeholder="Re-enter your new password"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-password-target="password_confirmation"
                                aria-label="Show password"
                            >
                                <i class="fa fa-eye"></i>
                            </button>

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="btn-auth"
                        id="resetPasswordButton"
                        disabled
                    >
                        <span id="resetPasswordButtonText">
                            Reset Password
                        </span>

                        <i
                            class="fa fa-shield"
                            id="resetPasswordButtonIcon"
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

                const password =
                    document.getElementById(
                        'password'
                    );

                const confirmation =
                    document.getElementById(
                        'password_confirmation'
                    );

                const form =
                    document.getElementById(
                        'resetPasswordForm'
                    );

                const submitButton =
                    document.getElementById(
                        'resetPasswordButton'
                    );

                const submitText =
                    document.getElementById(
                        'resetPasswordButtonText'
                    );

                const submitIcon =
                    document.getElementById(
                        'resetPasswordButtonIcon'
                    );

                const strengthBar =
                    document.getElementById(
                        'strengthBar'
                    );

                const strengthLabel =
                    document.getElementById(
                        'strengthLabel'
                    );


                const requirements = {
                    length:
                        document.getElementById(
                            'requirementLength'
                        ),

                    upper:
                        document.getElementById(
                            'requirementUpper'
                        ),

                    lower:
                        document.getElementById(
                            'requirementLower'
                        ),

                    number:
                        document.getElementById(
                            'requirementNumber'
                        ),

                    symbol:
                        document.getElementById(
                            'requirementSymbol'
                        ),

                    match:
                        document.getElementById(
                            'requirementMatch'
                        ),
                };


                function setRequirement(
                    element,
                    valid
                ) {
                    if (!element) {
                        return;
                    }

                    element.classList.toggle(
                        'valid',
                        valid
                    );

                    const icon =
                        element.querySelector('i');

                    if (icon) {
                        icon.className =
                            valid
                                ? 'fa fa-check-circle'
                                : 'fa fa-circle';
                    }
                }


                function validatePassword() {
                    const value =
                        password
                            ? password.value
                            : '';

                    const confirmationValue =
                        confirmation
                            ? confirmation.value
                            : '';

                    const rules = {
                        length:
                            value.length >= 8,

                        upper:
                            /[A-Z]/.test(value),

                        lower:
                            /[a-z]/.test(value),

                        number:
                            /[0-9]/.test(value),

                        symbol:
                            /[^A-Za-z0-9]/.test(value),

                        match:
                            value.length > 0
                            &&
                            value === confirmationValue,
                    };


                    Object.keys(rules).forEach(
                        function (key) {
                            setRequirement(
                                requirements[key],
                                rules[key]
                            );
                        }
                    );


                    const strengthCount = [
                        rules.length,
                        rules.upper,
                        rules.lower,
                        rules.number,
                        rules.symbol,
                    ].filter(Boolean).length;


                    const strengthPercent =
                        strengthCount * 20;

                    if (strengthBar) {
                        strengthBar.style.width =
                            strengthPercent + '%';

                        if (strengthCount <= 2) {
                            strengthBar.style.background =
                                '#dc3545';
                        } else if (strengthCount <= 4) {
                            strengthBar.style.background =
                                '#f59f00';
                        } else {
                            strengthBar.style.background =
                                '#198754';
                        }
                    }


                    if (strengthLabel) {
                        if (value.length === 0) {
                            strengthLabel.textContent =
                                'Password strength: not entered';
                        } else if (strengthCount <= 2) {
                            strengthLabel.textContent =
                                'Password strength: weak';
                        } else if (strengthCount <= 4) {
                            strengthLabel.textContent =
                                'Password strength: medium';
                        } else {
                            strengthLabel.textContent =
                                'Password strength: strong';
                        }
                    }


                    const allValid =
                        rules.length
                        && rules.upper
                        && rules.lower
                        && rules.number
                        && rules.symbol
                        && rules.match;


                    if (submitButton) {
                        submitButton.disabled =
                            ! allValid;
                    }

                    return allValid;
                }


                if (password) {
                    password.addEventListener(
                        'input',
                        validatePassword
                    );
                }


                if (confirmation) {
                    confirmation.addEventListener(
                        'input',
                        validatePassword
                    );
                }


                document
                    .querySelectorAll(
                        '[data-password-target]'
                    )
                    .forEach(function (button) {

                        button.addEventListener(
                            'click',
                            function () {

                                const targetId =
                                    this.getAttribute(
                                        'data-password-target'
                                    );

                                const input =
                                    document.getElementById(
                                        targetId
                                    );

                                const icon =
                                    this.querySelector('i');

                                if (!input) {
                                    return;
                                }

                                const hidden =
                                    input.type ===
                                    'password';

                                input.type =
                                    hidden
                                        ? 'text'
                                        : 'password';

                                if (icon) {
                                    icon.className =
                                        hidden
                                            ? 'fa fa-eye-slash'
                                            : 'fa fa-eye';
                                }

                                this.setAttribute(
                                    'aria-label',
                                    hidden
                                        ? 'Hide password'
                                        : 'Show password'
                                );
                            }
                        );

                    });


                if (form) {
                    form.addEventListener(
                        'submit',
                        function (event) {

                            if (!validatePassword()) {
                                event.preventDefault();
                                return;
                            }

                            if (submitButton) {
                                submitButton.disabled =
                                    true;
                            }

                            if (submitText) {
                                submitText.textContent =
                                    'Resetting Password...';
                            }

                            if (submitIcon) {
                                submitIcon.className =
                                    'fa fa-spinner fa-spin';
                            }
                        }
                    );
                }


                validatePassword();
            }
        );
    </script>

</body>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Verify your email address to activate your NUST Sharing Network account."
    >

    <title>
        Verify Email | NUST Sharing Network
    </title>


    {{-- =========================================================
        BOOTSTRAP
    ========================================================== --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- =========================================================
        BOOTSTRAP ICONS
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <style>

        /*
        |--------------------------------------------------------------------------
        | NUST THEME
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

            color: var(--nust-text);

            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #edf5fa 0%,
                    #f9fbfd 45%,
                    #e8f2f8 100%
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Page Wrapper
        |--------------------------------------------------------------------------
        */

        .verification-wrapper {

            position: relative;

            min-height: 100vh;

            display: flex;

            align-items: center;

            padding: 45px 0;

            overflow: hidden;
        }


        .verification-wrapper::before {

            content: "";

            position: absolute;

            width: 420px;

            height: 420px;

            top: -190px;

            left: -160px;

            border-radius: 50%;

            background:
                rgba(
                    0,
                    85,
                    140,
                    0.07
                );
        }


        .verification-wrapper::after {

            content: "";

            position: absolute;

            width: 480px;

            height: 480px;

            right: -200px;

            bottom: -250px;

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
        | Card
        |--------------------------------------------------------------------------
        */

        .verification-card {

            position: relative;

            z-index: 2;

            width: 100%;

            max-width: 650px;

            margin: 0 auto;

            background: var(--white);

            border: 0;

            border-radius: 20px;

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
        | Top Accent
        |--------------------------------------------------------------------------
        */

        .top-accent {

            height: 5px;

            background: var(--nust-green);
        }


        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */

        .verification-header {

            position: relative;

            padding: 34px 40px 30px;

            text-align: center;

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    var(--nust-primary-dark),
                    var(--nust-primary),
                    var(--nust-secondary)
                );
        }


        .brand-badge {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 7px 14px;

            margin-bottom: 17px;

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

            font-size: 12px;
        }


        .verification-header h1 {

            margin: 0;

            font-size: 26px;

            font-weight: 700;
        }


        .verification-header p {

            margin: 8px 0 0;

            color:
                rgba(
                    255,
                    255,
                    255,
                    0.82
                );

            font-size: 14px;
        }


        /*
        |--------------------------------------------------------------------------
        | Main Content
        |--------------------------------------------------------------------------
        */

        .verification-body {

            padding: 40px 45px;
        }


        /*
        |--------------------------------------------------------------------------
        | Mail Icon
        |--------------------------------------------------------------------------
        */

        .mail-icon {

            width: 88px;

            height: 88px;

            margin: 0 auto 24px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            color: var(--nust-primary);

            background: var(--nust-light);

            font-size: 38px;

            box-shadow:
                0 8px 20px
                rgba(
                    0,
                    85,
                    140,
                    0.08
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Content
        |--------------------------------------------------------------------------
        */

        .content-title {

            margin-bottom: 10px;

            text-align: center;

            color: var(--nust-primary-dark);

            font-size: 28px;

            font-weight: 700;
        }


        .content-description {

            max-width: 500px;

            margin: 0 auto;

            text-align: center;

            color: var(--nust-muted);

            font-size: 14px;

            line-height: 1.75;
        }


        /*
        |--------------------------------------------------------------------------
        | Email Box
        |--------------------------------------------------------------------------
        */

        .email-box {

            margin: 25px 0;

            padding: 17px 20px;

            border:
                1px solid
                var(--nust-border);

            border-radius: 10px;

            background: var(--nust-soft);

            text-align: center;
        }


        .email-box-label {

            margin-bottom: 5px;

            color: #7d8b96;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 0.4px;
        }


        .email-address {

            color: var(--nust-primary);

            font-size: 15px;

            font-weight: 700;

            word-break: break-word;
        }


        /*
        |--------------------------------------------------------------------------
        | Steps
        |--------------------------------------------------------------------------
        */

        .verification-steps {

            margin: 28px 0;

            padding: 20px;

            border-radius: 12px;

            background: #f8fafc;
        }


        .step-item {

            display: flex;

            align-items: flex-start;

            gap: 13px;

            padding: 9px 0;
        }


        .step-number {

            width: 30px;

            height: 30px;

            min-width: 30px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            color: #ffffff;

            background: var(--nust-primary);

            font-size: 12px;

            font-weight: 700;
        }


        .step-content strong {

            display: block;

            margin-bottom: 2px;

            color: #34495e;

            font-size: 14px;
        }


        .step-content span {

            color: #7a8994;

            font-size: 12px;

            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | Expiry Notice
        |--------------------------------------------------------------------------
        */

        .expiry-notice {

            display: flex;

            align-items: flex-start;

            gap: 12px;

            margin: 25px 0;

            padding: 14px 16px;

            border:
                1px solid
                #f0dc9b;

            border-radius: 9px;

            background: #fff9e8;

            color: #735d23;

            font-size: 13px;

            line-height: 1.6;
        }


        .expiry-notice i {

            margin-top: 1px;

            color: #d49a12;

            font-size: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | Resend Area
        |--------------------------------------------------------------------------
        */

        .resend-area {

            margin-top: 30px;

            padding-top: 27px;

            border-top:
                1px solid
                #e6edf1;
        }


        .resend-title {

            margin-bottom: 6px;

            color: #34495e;

            font-size: 15px;

            font-weight: 700;

            text-align: center;
        }


        .resend-text {

            margin-bottom: 18px;

            color: #7c8994;

            font-size: 13px;

            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | Buttons
        |--------------------------------------------------------------------------
        */

        .btn-resend {

            min-height: 50px;

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
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }


        .btn-resend:hover {

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


        .login-link {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            color: var(--nust-primary);

            font-size: 13px;

            font-weight: 600;

            text-decoration: none;
        }


        .login-link:hover {

            color: var(--nust-primary-dark);

            text-decoration: underline;
        }


        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        .verification-footer {

            padding: 20px 30px;

            text-align: center;

            border-top:
                1px solid
                #e7edf1;

            background: #f8fafc;

            color: #8a98a5;

            font-size: 11px;

            line-height: 1.7;
        }


        .verification-footer strong {

            color: #536575;
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

        @media (max-width: 767.98px) {

            .verification-wrapper {

                padding: 25px 15px;
            }


            .verification-card {

                border-radius: 15px;
            }


            .verification-header {

                padding: 30px 22px 26px;
            }


            .verification-header h1 {

                font-size: 22px;
            }


            .verification-body {

                padding: 32px 24px;
            }


            .content-title {

                font-size: 24px;
            }


            .mail-icon {

                width: 78px;

                height: 78px;

                font-size: 33px;
            }

        }

    </style>

</head>


<body>


<div class="verification-wrapper">

    <div class="container">

        <div class="verification-card">


            {{-- =========================================================
                TOP ACCENT
            ========================================================== --}}

            <div class="top-accent"></div>



            {{-- =========================================================
                HEADER
            ========================================================== --}}

            <div class="verification-header">


                <div class="brand-badge">

                    <i class="bi bi-share-fill"></i>

                    NUST Sharing Network

                </div>


                <h1>
                    Account Verification
                </h1>


                <p>
                    Secure your account by confirming your email address.
                </p>

            </div>



            {{-- =========================================================
                MAIN BODY
            ========================================================== --}}

            <div class="verification-body">


                {{-- Mail Icon --}}

                <div class="mail-icon">

                    <i class="bi bi-envelope-check"></i>

                </div>


                {{-- Heading --}}

                <h2 class="content-title">

                    Check Your Email

                </h2>


                <p class="content-description">

                    We have sent a secure verification link to your
                    registered email address. Open the email and click
                    the verification button to activate your
                    NUST Sharing Network account.

                </p>



                {{-- =====================================================
                    EMAIL ADDRESS
                ====================================================== --}}

                <div class="email-box">

                    <div class="email-box-label">

                        Verification Email Sent To

                    </div>


                    <div class="email-address">

                        {{
                            session('verification_email')
                                ?: 'Your registered email address'
                        }}

                    </div>

                </div>



                {{-- =====================================================
                    SUCCESS
                ====================================================== --}}

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



                {{-- =====================================================
                    WARNING
                ====================================================== --}}

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



                {{-- =====================================================
                    ERRORS
                ====================================================== --}}

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
                                    Unable to process your request.
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



                {{-- =====================================================
                    VERIFICATION STEPS
                ====================================================== --}}

                <div class="verification-steps">


                    {{-- Step 1 --}}

                    <div class="step-item">

                        <div class="step-number">
                            1
                        </div>


                        <div class="step-content">

                            <strong>
                                Open Your Email
                            </strong>


                            <span>

                                Check your inbox for an email from
                                NUST Sharing Network.

                            </span>

                        </div>

                    </div>


                    {{-- Step 2 --}}

                    <div class="step-item">

                        <div class="step-number">
                            2
                        </div>


                        <div class="step-content">

                            <strong>
                                Click the Verification Button
                            </strong>


                            <span>

                                Open the email and select
                                “Verify Email Address”.

                            </span>

                        </div>

                    </div>


                    {{-- Step 3 --}}

                    <div class="step-item">

                        <div class="step-number">
                            3
                        </div>


                        <div class="step-content">

                            <strong>
                                Activate Your Account
                            </strong>


                            <span>

                                After successful verification, you can
                                continue to your NUST Sharing Network account.

                            </span>

                        </div>

                    </div>

                </div>



                {{-- =====================================================
                    EXPIRY NOTICE
                ====================================================== --}}

                <div class="expiry-notice">

                    <i class="bi bi-clock-history"></i>


                    <div>

                        <strong>
                            Verification link expires in 60 minutes.
                        </strong>

                        <br>

                        If the link expires, you can request a new
                        verification email below.

                    </div>

                </div>



                {{-- =====================================================
                    RESEND EMAIL
                ====================================================== --}}

                <div class="resend-area">

                    <div class="resend-title">

                        Didn't receive the email?

                    </div>


                    <div class="resend-text">

                        Check your spam or junk folder first.
                        You can also request another verification email.

                    </div>


                    <form
                        method="POST"
                        action="{{ route('verification.resend') }}"
                        id="resendVerificationForm"
                    >

                        @csrf


                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-resend"
                                id="resendButton"
                            >

                                <span id="resendButtonContent">

                                    <i class="bi bi-arrow-clockwise me-2"></i>

                                    Resend Verification Email

                                </span>


                                <span
                                    id="resendButtonLoading"
                                    style="display:none;"
                                >

                                    <span
                                        class="spinner-border spinner-border-sm me-2"
                                        role="status"
                                    ></span>

                                    Sending...

                                </span>

                            </button>

                        </div>

                    </form>



                    {{-- =================================================
                        LOGIN
                    ================================================== --}}

                    <div class="text-center mt-4">

                        <a
                            href="{{ route('login') }}"
                            class="login-link"
                        >

                            <i class="bi bi-arrow-left"></i>

                            Back to Login

                        </a>

                    </div>

                </div>

            </div>



            {{-- =========================================================
                FOOTER
            ========================================================== --}}

            <div class="verification-footer">

                <strong>
                    NUST Sharing Network
                </strong>

                <br>

                National University of Sciences & Technology

                <br>

                <span>

                    © {{ date('Y') }}
                    NUST Sharing Network.
                    All rights reserved.

                </span>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
    BOOTSTRAP JS
========================================================== --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>



{{-- =========================================================
    RESEND BUTTON
========================================================== --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById(
                'resendVerificationForm'
            );


        const button =
            document.getElementById(
                'resendButton'
            );


        const normalContent =
            document.getElementById(
                'resendButtonContent'
            );


        const loadingContent =
            document.getElementById(
                'resendButtonLoading'
            );


        /*
        |--------------------------------------------------------------------------
        | Prevent Multiple Submissions
        |--------------------------------------------------------------------------
        */

        form.addEventListener(
            'submit',
            function () {

                button.disabled =
                    true;


                normalContent.style.display =
                    'none';


                loadingContent.style.display =
                    'inline';

            }
        );

    }
);

</script>


</body>

</html>
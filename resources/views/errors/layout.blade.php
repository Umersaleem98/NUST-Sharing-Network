<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="robots"
        content="noindex, nofollow, noarchive"
    >

    <meta
        name="referrer"
        content="strict-origin-when-cross-origin"
    >

    <title>
        @yield('code') | NUST Sharing Network
    </title>


    <style>

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }


        body {
            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px 20px;

            background:
                linear-gradient(
                    135deg,
                    #f5f9fc 0%,
                    #eef5f9 50%,
                    #ffffff 100%
                );

            color: #243746;

            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Arial,
                sans-serif;
        }


        /* =========================================================
           BACKGROUND
        ========================================================== */

        .error-background {
            position: fixed;
            inset: 0;

            overflow: hidden;

            pointer-events: none;

            z-index: 0;
        }


        .error-circle {
            position: absolute;

            border-radius: 50%;

            background:
                rgba(
                    0,
                    85,
                    140,
                    0.05
                );
        }


        .error-circle-one {
            width: 400px;
            height: 400px;

            top: -170px;
            right: -140px;
        }


        .error-circle-two {
            width: 300px;
            height: 300px;

            bottom: -150px;
            left: -120px;

            background:
                rgba(
                    130,
                    178,
                    149,
                    0.08
                );
        }


        /* =========================================================
           WRAPPER
        ========================================================== */

        .error-wrapper {
            position: relative;

            z-index: 2;

            width: 100%;

            max-width: 700px;
        }


        /* =========================================================
           CARD
        ========================================================== */

        .error-card {
            overflow: hidden;

            border:
                1px solid
                #dce6ec;

            border-radius: 22px;

            background: #ffffff;

            box-shadow:
                0 25px 70px
                rgba(
                    18,
                    59,
                    96,
                    0.12
                );
        }


        .error-top-border {
            height: 5px;

            background:
                linear-gradient(
                    90deg,
                    #00558c,
                    #0072bc,
                    #82b295
                );
        }


        /* =========================================================
           HEADER
        ========================================================== */

        .error-header {
            padding: 26px 35px;

            background:
                linear-gradient(
                    135deg,
                    #00558c,
                    #003f69
                );

            text-align: center;

            color: #ffffff;
        }


        .error-brand {
            margin: 0;

            font-size: 21px;

            font-weight: 700;
        }


        .error-brand-subtitle {
            display: block;

            margin-top: 5px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    0.72
                );

            font-size: 12px;
        }


        /* =========================================================
           CONTENT
        ========================================================== */

        .error-content {
            padding:
                48px
                40px
                40px;

            text-align: center;
        }


        .error-icon {
            width: 88px;
            height: 88px;

            margin:
                0
                auto
                25px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: #eef6fb;

            color: #00558c;

            font-size: 34px;

            font-weight: 700;
        }


        .error-code {
            margin:
                0
                0
                8px;

            color: #00558c;

            font-size:
                clamp(
                    48px,
                    10vw,
                    76px
                );

            font-weight: 800;

            line-height: 1;
        }


        .error-title {
            margin:
                0
                0
                12px;

            color: #243746;

            font-size:
                clamp(
                    23px,
                    5vw,
                    31px
                );

            font-weight: 700;
        }


        .error-message {
            max-width: 500px;

            margin:
                0
                auto;

            color: #6c7a89;

            font-size: 14px;

            line-height: 1.8;
        }


        /* =========================================================
           SECURITY NOTE
        ========================================================== */

        .error-security-note {
            max-width: 500px;

            margin:
                24px
                auto
                0;

            padding:
                13px
                16px;

            border:
                1px solid
                #e4ebef;

            border-radius: 10px;

            background: #f8fafb;

            color: #71808c;

            font-size: 11px;

            line-height: 1.6;
        }


        /* =========================================================
           BUTTONS
        ========================================================== */

        .error-actions {
            display: flex;

            align-items: center;

            justify-content: center;

            flex-wrap: wrap;

            gap: 10px;

            margin-top: 30px;
        }


        .error-btn {
            min-width: 145px;

            padding:
                12px
                22px;

            border-radius: 50px;

            font-size: 13px;

            font-weight: 600;

            text-decoration: none;

            cursor: pointer;

            transition:
                0.25s ease;
        }


        .error-btn-primary {
            border:
                1px solid
                #00558c;

            background: #00558c;

            color: #ffffff;
        }


        .error-btn-primary:hover {
            background: #003f69;

            border-color: #003f69;

            color: #ffffff;

            transform:
                translateY(-2px);
        }


        .error-btn-secondary {
            border:
                1px solid
                #d8e1e7;

            background: #ffffff;

            color: #405363;
        }


        .error-btn-secondary:hover {
            background: #f6f9fb;

            border-color: #bbc9d2;

            transform:
                translateY(-2px);
        }


        /* =========================================================
           FOOTER
        ========================================================== */

        .error-footer {
            padding:
                18px
                25px;

            border-top:
                1px solid
                #edf1f4;

            background: #f9fbfc;

            text-align: center;

            color: #8b98a3;

            font-size: 10px;
        }


        /* =========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 575.98px) {

            body {
                padding:
                    20px
                    12px;
            }


            .error-header {
                padding:
                    22px
                    18px;
            }


            .error-content {
                padding:
                    38px
                    22px
                    32px;
            }


            .error-icon {
                width: 72px;
                height: 72px;

                font-size: 28px;
            }


            .error-actions {
                flex-direction: column;
            }


            .error-btn {
                width: 100%;
            }

        }

    </style>

</head>


<body>


<div class="error-background">

    <div
        class="error-circle error-circle-one"
    ></div>

    <div
        class="error-circle error-circle-two"
    ></div>

</div>


<div class="error-wrapper">

    <div class="error-card">


        <div class="error-top-border"></div>


        <div class="error-header">

            <h1 class="error-brand">
                NUST Sharing Network
            </h1>


            <span class="error-brand-subtitle">

                Secure Resource Sharing Platform

            </span>

        </div>


        <div class="error-content">


            <div class="error-icon">

                @yield('icon')

            </div>


            <div class="error-code">

                @yield('code')

            </div>


            <h2 class="error-title">

                @yield('title')

            </h2>


            <p class="error-message">

                @yield('message')

            </p>


            <div class="error-security-note">

                For security reasons, technical details about
                this error are not displayed publicly.

            </div>


            <div class="error-actions">


                <a
                    href="{{ url('/') }}"
                    class="error-btn error-btn-primary"
                >

                    Return to Home

                </a>


                <button
                    type="button"
                    class="error-btn error-btn-secondary"
                    onclick="history.back()"
                >

                    Go Back

                </button>

            </div>

        </div>


        <div class="error-footer">

            &copy; {{ date('Y') }}
            NUST Sharing Network.
            All rights reserved.

        </div>

    </div>

</div>


</body>

</html>
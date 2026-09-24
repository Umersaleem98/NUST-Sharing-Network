<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        http-equiv="Content-Type"
        content="text/html; charset=UTF-8"
    >

    <title>
        Verify Your Email | NUST Sharing Network
    </title>

</head>


<body
    style="
        margin: 0;
        padding: 0;
        width: 100%;
        background-color: #f3f6f9;
        font-family: Arial, Helvetica, sans-serif;
        color: #243746;
        -webkit-font-smoothing: antialiased;
    "
>


{{-- =========================================================
    EMAIL WRAPPER
========================================================== --}}

<table
    width="100%"
    cellspacing="0"
    cellpadding="0"
    border="0"
    role="presentation"
    style="
        width: 100%;
        margin: 0;
        padding: 0;
        background-color: #f3f6f9;
    "
>

    <tr>

        <td
            align="center"
            style="
                padding: 40px 15px;
            "
        >


            {{-- =================================================
                MAIN EMAIL CONTAINER
            ================================================== --}}

            <table
                width="100%"
                cellspacing="0"
                cellpadding="0"
                border="0"
                role="presentation"
                style="
                    width: 100%;
                    max-width: 640px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
                "
            >


                {{-- =================================================
                    TOP ACCENT
                ================================================== --}}

                <tr>

                    <td
                        style="
                            height: 5px;
                            background-color: #82b295;
                            font-size: 0;
                            line-height: 0;
                        "
                    >
                        &nbsp;
                    </td>

                </tr>


                {{-- =================================================
                    HEADER
                ================================================== --}}

                <tr>

                    <td
                        align="center"
                        style="
                            background-color: #00558c;
                            padding: 34px 30px 30px 30px;
                        "
                    >


                        {{-- Logo --}}

                        @if(!empty($logoUrl))

                            <img
                                src="{{ $logoUrl }}"
                                alt="NUST Sharing Network"
                                width="90"
                                style="
                                    display: block;
                                    width: 90px;
                                    max-width: 90px;
                                    height: auto;
                                    margin: 0 auto 18px auto;
                                    border: 0;
                                    outline: none;
                                    text-decoration: none;
                                "
                            >

                        @endif


                        {{-- Project Name --}}

                        <div
                            style="
                                color: #ffffff;
                                font-size: 23px;
                                line-height: 1.4;
                                font-weight: 700;
                                letter-spacing: 0.2px;
                            "
                        >
                            NUST Sharing Network
                        </div>


                        {{-- Subtitle --}}

                        <div
                            style="
                                margin-top: 7px;
                                color: #dbeaf3;
                                font-size: 13px;
                                line-height: 1.5;
                            "
                        >
                            Secure Account Verification
                        </div>

                    </td>

                </tr>



                {{-- =================================================
                    MAIN CONTENT
                ================================================== --}}

                <tr>

                    <td
                        style="
                            padding: 42px 42px 35px 42px;
                        "
                    >


                        {{-- Icon --}}

                        <table
                            width="100%"
                            cellspacing="0"
                            cellpadding="0"
                            border="0"
                            role="presentation"
                        >

                            <tr>

                                <td
                                    align="center"
                                    style="
                                        padding-bottom: 20px;
                                    "
                                >

                                    <div
                                        style="
                                            display: inline-block;
                                            width: 58px;
                                            height: 58px;
                                            line-height: 58px;
                                            text-align: center;
                                            background-color: #eaf4f9;
                                            border-radius: 50%;
                                            color: #00558c;
                                            font-size: 28px;
                                            font-weight: 700;
                                        "
                                    >
                                        ✓
                                    </div>

                                </td>

                            </tr>

                        </table>


                        {{-- Heading --}}

                        <h1
                            style="
                                margin: 0 0 18px 0;
                                padding: 0;
                                text-align: center;
                                color: #243746;
                                font-size: 25px;
                                line-height: 1.4;
                                font-weight: 700;
                            "
                        >
                            Verify Your Email Address
                        </h1>


                        {{-- Greeting --}}

                        <p
                            style="
                                margin: 0 0 15px 0;
                                color: #566573;
                                font-size: 15px;
                                line-height: 1.8;
                            "
                        >
                            Dear

                            <strong
                                style="
                                    color: #243746;
                                "
                            >
                                {{ $user->name }}
                            </strong>,
                        </p>


                        {{-- Intro --}}

                        <p
                            style="
                                margin: 0 0 15px 0;
                                color: #566573;
                                font-size: 15px;
                                line-height: 1.8;
                            "
                        >

                            Thank you for registering with

                            <strong
                                style="
                                    color: #00558c;
                                "
                            >
                                NUST Sharing Network
                            </strong>.

                            To complete your registration and securely activate
                            your account, please verify your email address using
                            the button below.

                        </p>



                        {{-- =================================================
                            ACCOUNT DETAILS
                        ================================================== --}}

                        <table
                            width="100%"
                            cellspacing="0"
                            cellpadding="0"
                            border="0"
                            role="presentation"
                            style="
                                width: 100%;
                                margin: 28px 0;
                                background-color: #f7fafc;
                                border: 1px solid #e1e8ed;
                                border-radius: 8px;
                            "
                        >


                            <tr>

                                <td
                                    colspan="2"
                                    style="
                                        padding: 15px 20px;
                                        border-bottom: 1px solid #e1e8ed;
                                        color: #00558c;
                                        font-size: 14px;
                                        font-weight: 700;
                                    "
                                >
                                    Account Information
                                </td>

                            </tr>


                            {{-- Name --}}

                            <tr>

                                <td
                                    width="35%"
                                    style="
                                        padding: 14px 10px 8px 20px;
                                        color: #7b8a97;
                                        font-size: 13px;
                                        vertical-align: top;
                                    "
                                >
                                    Full Name
                                </td>


                                <td
                                    style="
                                        padding: 14px 20px 8px 10px;
                                        color: #243746;
                                        font-size: 13px;
                                        font-weight: 600;
                                    "
                                >
                                    {{ $user->name }}
                                </td>

                            </tr>


                            {{-- Email --}}

                            <tr>

                                <td
                                    style="
                                        padding: 8px 10px 8px 20px;
                                        color: #7b8a97;
                                        font-size: 13px;
                                        vertical-align: top;
                                    "
                                >
                                    Email Address
                                </td>


                                <td
                                    style="
                                        padding: 8px 20px 8px 10px;
                                        color: #243746;
                                        font-size: 13px;
                                        font-weight: 600;
                                        word-break: break-word;
                                    "
                                >
                                    {{ $user->email }}
                                </td>

                            </tr>


                            {{-- Account Type --}}

                            <tr>

                                <td
                                    style="
                                        padding: 8px 10px 14px 20px;
                                        color: #7b8a97;
                                        font-size: 13px;
                                        vertical-align: top;
                                    "
                                >
                                    Account Type
                                </td>


                                <td
                                    style="
                                        padding: 8px 20px 14px 10px;
                                        color: #243746;
                                        font-size: 13px;
                                        font-weight: 600;
                                    "
                                >
                                    {{ ucfirst($user->role) }}
                                </td>

                            </tr>


                            {{-- Beneficiary Qalam ID --}}

                            @if(
                                $user->role === 'beneficiary' &&
                                !empty($user->qalam_id)
                            )

                                <tr>

                                    <td
                                        style="
                                            padding: 0 10px 14px 20px;
                                            color: #7b8a97;
                                            font-size: 13px;
                                            vertical-align: top;
                                        "
                                    >
                                        Qalam ID
                                    </td>


                                    <td
                                        style="
                                            padding: 0 20px 14px 10px;
                                            color: #243746;
                                            font-size: 13px;
                                            font-weight: 600;
                                        "
                                    >
                                        {{ $user->qalam_id }}
                                    </td>

                                </tr>

                            @endif

                        </table>



                        {{-- =================================================
                            VERIFICATION BUTTON
                        ================================================== --}}

                        <table
                            width="100%"
                            cellspacing="0"
                            cellpadding="0"
                            border="0"
                            role="presentation"
                            style="
                                margin: 32px 0;
                            "
                        >

                            <tr>

                                <td align="center">

                                    <table
                                        cellspacing="0"
                                        cellpadding="0"
                                        border="0"
                                        role="presentation"
                                    >

                                        <tr>

                                            <td
                                                align="center"
                                                bgcolor="#00558c"
                                                style="
                                                    border-radius: 7px;
                                                "
                                            >

                                                <a
                                                    href="{{ $verificationUrl }}"
                                                    target="_blank"
                                                    style="
                                                        display: inline-block;
                                                        padding: 15px 34px;
                                                        color: #ffffff;
                                                        background-color: #00558c;
                                                        border-radius: 7px;
                                                        text-decoration: none;
                                                        font-size: 15px;
                                                        line-height: 1.2;
                                                        font-weight: 700;
                                                    "
                                                >
                                                    Verify Email Address
                                                </a>

                                            </td>

                                        </tr>

                                    </table>

                                </td>

                            </tr>

                        </table>



                        {{-- =================================================
                            SECURITY / EXPIRY NOTICE
                        ================================================== --}}

                        <table
                            width="100%"
                            cellspacing="0"
                            cellpadding="0"
                            border="0"
                            role="presentation"
                            style="
                                margin: 25px 0;
                                background-color: #fff9e9;
                                border: 1px solid #f5df9a;
                                border-radius: 7px;
                            "
                        >

                            <tr>

                                <td
                                    width="45"
                                    valign="top"
                                    align="center"
                                    style="
                                        padding: 15px 0 15px 15px;
                                        color: #b7791f;
                                        font-size: 20px;
                                    "
                                >
                                    !
                                </td>


                                <td
                                    style="
                                        padding: 15px 15px 15px 10px;
                                        color: #765c24;
                                        font-size: 13px;
                                        line-height: 1.6;
                                    "
                                >

                                    <strong>
                                        Important:
                                    </strong>

                                    This verification link will expire in

                                    <strong>
                                        60 minutes
                                    </strong>.

                                    For your security, please do not share this
                                    verification link with anyone.

                                </td>

                            </tr>

                        </table>



                        {{-- =================================================
                            FALLBACK LINK
                        ================================================== --}}

                        <p
                            style="
                                margin: 25px 0 10px 0;
                                color: #657785;
                                font-size: 13px;
                                line-height: 1.7;
                            "
                        >

                            If the verification button does not work, copy and
                            paste the following address into your web browser:

                        </p>


                        <div
                            style="
                                padding: 13px 15px;
                                background-color: #f7fafc;
                                border: 1px solid #e1e8ed;
                                border-radius: 6px;
                                color: #00558c;
                                font-size: 11px;
                                line-height: 1.7;
                                word-break: break-all;
                            "
                        >

                            <a
                                href="{{ $verificationUrl }}"
                                target="_blank"
                                style="
                                    color: #00558c;
                                    text-decoration: none;
                                "
                            >
                                {{ $verificationUrl }}
                            </a>

                        </div>



                        {{-- =================================================
                            UNREQUESTED ACCOUNT NOTICE
                        ================================================== --}}

                        <p
                            style="
                                margin: 28px 0 0 0;
                                color: #7c8994;
                                font-size: 13px;
                                line-height: 1.7;
                            "
                        >

                            If you did not create an account with NUST Sharing
                            Network, no action is required. You may safely ignore
                            this email.

                        </p>



                        {{-- =================================================
                            SIGNATURE
                        ================================================== --}}

                        <p
                            style="
                                margin: 28px 0 0 0;
                                color: #566573;
                                font-size: 14px;
                                line-height: 1.7;
                            "
                        >

                            Regards,

                            <br>

                            <strong
                                style="
                                    color: #243746;
                                "
                            >
                                NUST Sharing Network Team
                            </strong>

                        </p>

                    </td>

                </tr>



                {{-- =================================================
                    SUPPORT SECTION
                ================================================== --}}

                <tr>

                    <td
                        align="center"
                        style="
                            padding: 20px 30px;
                            background-color: #eef5f8;
                            border-top: 1px solid #dce6ec;
                        "
                    >

                        <div
                            style="
                                color: #526574;
                                font-size: 12px;
                                line-height: 1.7;
                            "
                        >

                            This is an automated account verification email.

                            <br>

                            Please do not share your verification link
                            with anyone.

                        </div>

                    </td>

                </tr>



                {{-- =================================================
                    FOOTER
                ================================================== --}}

                <tr>

                    <td
                        align="center"
                        style="
                            padding: 28px 25px;
                            background-color: #243746;
                        "
                    >


                        <div
                            style="
                                color: #ffffff;
                                font-size: 15px;
                                line-height: 1.5;
                                font-weight: 700;
                            "
                        >
                            NUST Sharing Network
                        </div>


                        <div
                            style="
                                margin-top: 7px;
                                color: #c2ccd4;
                                font-size: 12px;
                                line-height: 1.6;
                            "
                        >
                            National University of Sciences & Technology
                        </div>


                        <div
                            style="
                                width: 45px;
                                height: 2px;
                                margin: 15px auto;
                                background-color: #82b295;
                                font-size: 0;
                                line-height: 0;
                            "
                        >
                            &nbsp;
                        </div>


                        <div
                            style="
                                color: #9eabb5;
                                font-size: 11px;
                                line-height: 1.6;
                            "
                        >

                            © {{ date('Y') }} NUST Sharing Network.

                            <br>

                            All rights reserved.

                        </div>

                    </td>

                </tr>


            </table>



            {{-- =================================================
                OUTSIDE FOOTER
            ================================================== --}}

            <table
                width="100%"
                cellspacing="0"
                cellpadding="0"
                border="0"
                role="presentation"
                style="
                    width: 100%;
                    max-width: 640px;
                "
            >

                <tr>

                    <td
                        align="center"
                        style="
                            padding: 18px 20px 0 20px;
                            color: #98a5af;
                            font-size: 10px;
                            line-height: 1.6;
                        "
                    >

                        This email was sent because an account was registered
                        using this email address on NUST Sharing Network.

                    </td>

                </tr>

            </table>


        </td>

    </tr>

</table>


</body>

</html>
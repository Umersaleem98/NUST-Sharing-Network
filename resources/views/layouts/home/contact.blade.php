{{-- ============================================================
     CONTACT US SECTION
============================================================ --}}

<style>

    /* =========================================================
       CONTACT SECTION
    ========================================================= */

    .contact-section {
        padding: 90px 0;
        background: #ffffff;
    }

    .contact-section-heading {
        max-width: 720px;
        margin: 0 auto 45px;
        text-align: center;
    }

    .contact-section-label {
        display: inline-block;
        margin-bottom: 9px;
        color: #d99b24;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.6px;
        text-transform: uppercase;
    }

    .contact-section-heading h2 {
        margin-bottom: 13px;
        color: #123b60;
        font-size: clamp(28px, 4vw, 40px);
        font-weight: 800;
        line-height: 1.2;
    }

    .contact-section-heading p {
        max-width: 640px;
        margin: 0 auto;
        color: #6f7f90;
        font-size: 14px;
        line-height: 1.8;
    }


    /* =========================================================
       WRAPPER
    ========================================================= */

    .contact-wrapper {
        overflow: hidden;
        border: 1px solid #e3e9ef;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 20px 55px rgba(18, 59, 96, .08);
    }


    /* =========================================================
       CONTACT INFO
    ========================================================= */

    .contact-info-panel {
        position: relative;
        height: 100%;
        overflow: hidden;
        padding: 48px 38px;

        background:
            linear-gradient(
                145deg,
                #082944,
                #123b60
            );

        color: #ffffff;
    }

    .contact-info-panel::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        right: -130px;
        top: -130px;
        border: 45px solid rgba(250, 188, 77, .07);
        border-radius: 50%;
    }

    .contact-info-panel::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        left: -90px;
        bottom: -100px;
        border-radius: 50%;
        background: rgba(250, 188, 77, .06);
    }

    .contact-info-content {
        position: relative;
        z-index: 2;
    }

    .contact-info-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 13px;
        color: #fabc4d;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .contact-info-panel h3 {
        margin-bottom: 14px;
        color: #ffffff;
        font-size: 30px;
        font-weight: 800;
        line-height: 1.2;
    }

    .contact-info-description {
        margin-bottom: 32px;
        color: rgba(255, 255, 255, .70);
        font-size: 14px;
        line-height: 1.8;
    }

    .contact-info-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .contact-info-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 17px;
        border: 1px solid rgba(255, 255, 255, .10);
        border-radius: 14px;
        background: rgba(255, 255, 255, .055);
        transition: .3s ease;
    }

    .contact-info-item:hover {
        background: rgba(255, 255, 255, .09);
        border-color: rgba(250, 188, 77, .25);
        transform: translateX(4px);
    }

    .contact-info-icon {
        flex: 0 0 42px;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #fabc4d;
        color: #082944;
        font-size: 16px;
    }

    .contact-info-item h6 {
        margin: 0 0 5px;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
    }

    .contact-info-item p {
        margin: 0;
        color: rgba(255, 255, 255, .70);
        font-size: 13px;
        line-height: 1.7;
    }

    .contact-info-item a {
        color: rgba(255, 255, 255, .75);
        font-size: 13px;
        line-height: 1.7;
        text-decoration: none;
    }

    .contact-info-item a:hover {
        color: #fabc4d;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .contact-form-panel {
        padding: 48px 42px;
        background: #ffffff;
    }

    .contact-form-heading {
        margin-bottom: 28px;
    }

    .contact-form-heading h3 {
        margin-bottom: 7px;
        color: #123b60;
        font-size: 27px;
        font-weight: 800;
    }

    .contact-form-heading p {
        margin: 0;
        color: #6f7f90;
        font-size: 13px;
        line-height: 1.7;
    }

    .contact-form-group {
        margin-bottom: 19px;
    }

    .contact-form-label {
        display: block;
        margin-bottom: 7px;
        color: #25384b;
        font-size: 13px;
        font-weight: 700;
    }

    .contact-required {
        color: #c53b3b;
    }

    .contact-input-wrapper {
        position: relative;
    }

    .contact-input-icon {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: #9aa6b1;
        font-size: 13px;
        pointer-events: none;
        z-index: 2;
    }

    .contact-form-control {
        width: 100%;
        height: 49px;
        padding: 11px 15px 11px 43px;
        border: 1px solid #dce3ea;
        border-radius: 11px;
        background: #ffffff;
        color: #25384b;
        font-size: 13px;
        outline: none;
        transition: .25s ease;
    }

    .contact-form-control::placeholder {
        color: #9aa6b1;
    }

    .contact-form-control:focus {
        border-color: #123b60;
        box-shadow: 0 0 0 3px rgba(18, 59, 96, .08);
    }

    .contact-form-control.is-invalid {
        border-color: #c53b3b;
    }

    select.contact-form-control {
        cursor: pointer;
    }

    textarea.contact-form-control {
        min-height: 145px;
        height: auto;
        padding: 14px 15px 14px 43px;
        resize: vertical;
    }

    .contact-textarea-wrapper .contact-input-icon {
        top: 17px;
        transform: none;
    }

    .contact-error {
        display: block;
        margin-top: 6px;
        color: #c53b3b;
        font-size: 12px;
        line-height: 1.5;
    }


    /* =========================================================
       VALIDATION ALERT
    ========================================================= */

    .contact-alert-danger {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 24px;
        padding: 16px 18px;
        border: 1px solid rgba(197, 59, 59, .20);
        border-radius: 12px;
        background: rgba(197, 59, 59, .06);
        color: #a83232;
        font-size: 13px;
        line-height: 1.6;
    }

    .contact-alert-danger ul {
        margin: 7px 0 0;
        padding-left: 18px;
    }


    /* =========================================================
       PRIVACY
    ========================================================= */

    .contact-privacy {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin: 4px 0 22px;
    }

    .contact-privacy input {
        flex: 0 0 16px;
        width: 16px;
        height: 16px;
        margin-top: 3px;
        accent-color: #123b60;
        cursor: pointer;
    }

    .contact-privacy label {
        margin: 0;
        color: #6f7f90;
        font-size: 12px;
        line-height: 1.6;
        cursor: pointer;
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .contact-submit-btn {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 14px 25px;
        border: none;
        border-radius: 50px;
        background: #123b60;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: .3s ease;
    }

    .contact-submit-btn:hover {
        background: #082944;
        color: #fabc4d;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(18, 59, 96, .18);
    }

    .contact-submit-btn:disabled {
        opacity: .75;
        cursor: not-allowed;
        transform: none;
    }

    .contact-submit-spinner {
        display: none;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, .35);
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: contactSpinner .7s linear infinite;
    }

    .contact-submit-btn.is-loading .contact-submit-spinner {
        display: inline-block;
    }

    .contact-submit-btn.is-loading .contact-submit-icon {
        display: none;
    }

    @keyframes contactSpinner {
        to {
            transform: rotate(360deg);
        }
    }


    /* =========================================================
       SUCCESS POPUP
    ========================================================= */

    .contact-success-overlay {
        position: fixed;
        inset: 0;
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;

        background: rgba(5, 25, 42, .72);

        backdrop-filter: blur(7px);
        -webkit-backdrop-filter: blur(7px);

        opacity: 0;
        visibility: hidden;

        transition:
            opacity .35s ease,
            visibility .35s ease;
    }

    .contact-success-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .contact-success-modal {
        position: relative;
        width: 100%;
        max-width: 470px;
        padding: 48px 38px 36px;
        overflow: hidden;

        border-radius: 26px;
        background: #ffffff;

        text-align: center;

        box-shadow:
            0 30px 80px rgba(4, 30, 52, .30);

        transform: translateY(35px) scale(.90);
        opacity: 0;

        transition:
            transform .45s cubic-bezier(.2, .8, .2, 1),
            opacity .35s ease;
    }

    .contact-success-overlay.active .contact-success-modal {
        transform: translateY(0) scale(1);
        opacity: 1;
    }

    .contact-success-close {
        position: absolute;
        top: 15px;
        right: 15px;

        width: 36px;
        height: 36px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: 1px solid #e5ebf0;
        border-radius: 50%;

        background: #f7f9fb;
        color: #68798a;

        cursor: pointer;

        transition: .25s ease;
    }

    .contact-success-close:hover {
        background: #123b60;
        color: #ffffff;
        border-color: #123b60;
        transform: rotate(90deg);
    }

    .contact-success-icon-wrap {
        position: relative;

        width: 92px;
        height: 92px;

        margin: 0 auto 24px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background:
            linear-gradient(
                145deg,
                #fabc4d,
                #e6aa36
            );

        box-shadow:
            0 15px 35px
            rgba(250, 188, 77, .28);
    }

    .contact-success-check {
        width: 38px;
        height: 22px;

        border-left: 5px solid #082944;
        border-bottom: 5px solid #082944;

        transform: rotate(-45deg) scale(0);
        opacity: 0;
    }

    .contact-success-overlay.active
    .contact-success-check {
        animation:
            contactCheckAnimation
            .45s .25s forwards;
    }

    @keyframes contactCheckAnimation {

        from {
            transform: rotate(-45deg) scale(0);
            opacity: 0;
        }

        to {
            transform: rotate(-45deg) scale(1);
            opacity: 1;
        }

    }

    .contact-success-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        margin-bottom: 10px;

        color: #d99b24;

        font-size: 11px;
        font-weight: 800;

        letter-spacing: 1.4px;
        text-transform: uppercase;
    }

    .contact-success-title {
        margin: 0 0 10px;

        color: #123b60;

        font-size: 28px;
        font-weight: 800;
    }

    .contact-success-message {
        max-width: 360px;
        margin: 0 auto 25px;

        color: #6f7f90;

        font-size: 14px;
        line-height: 1.75;
    }

    .contact-success-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        min-width: 160px;

        padding: 12px 24px;

        border: none;
        border-radius: 50px;

        background: #123b60;
        color: #ffffff;

        font-size: 13px;
        font-weight: 700;

        cursor: pointer;

        transition: .3s ease;
    }

    .contact-success-btn:hover {
        background: #082944;
        color: #fabc4d;
        transform: translateY(-2px);
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .contact-section {
            padding: 70px 0;
        }

        .contact-info-panel,
        .contact-form-panel {
            padding: 40px 32px;
        }

    }

    @media (max-width: 767.98px) {

        .contact-section {
            padding: 58px 0;
        }

        .contact-info-panel,
        .contact-form-panel {
            padding: 32px 24px;
        }

    }

    @media (max-width: 575.98px) {

        .contact-wrapper {
            border-radius: 18px;
        }

        .contact-info-panel,
        .contact-form-panel {
            padding: 28px 20px;
        }

        .contact-success-modal {
            padding: 45px 22px 30px;
        }

        .contact-success-btn {
            width: 100%;
        }

    }

</style>


<section class="contact-section" id="contact">

    <div class="container">

        {{-- =====================================================
             HEADING
        ====================================================== --}}

        <div class="contact-section-heading">

            <span class="contact-section-label">
                Contact Us
            </span>

            <h2>
                Get in Touch With the NUST Sharing Network
            </h2>

            <p>
                Have a question about donations, beneficiary support,
                your account, or the NUST Sharing Network platform?
                Contact our team and we will be happy to assist you.
            </p>

        </div>


        <div class="contact-wrapper">

            <div class="row g-0">


                {{-- =================================================
                     CONTACT INFORMATION
                ================================================== --}}

                <div class="col-lg-5">

                    <div class="contact-info-panel">

                        <div class="contact-info-content">

                            <span class="contact-info-label">

                                <i class="fas fa-headset"></i>

                                We're Here to Help

                            </span>


                            <h3>
                                Contact Information
                            </h3>


                            <p class="contact-info-description">

                                Reach out to the University Advancement
                                Office for inquiries related to the NUST
                                Sharing Network, donor support,
                                beneficiary assistance, or general
                                information.

                            </p>


                            <div class="contact-info-list">


                                <div class="contact-info-item">

                                    <div class="contact-info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>

                                    <div>

                                        <h6>
                                            Address
                                        </h6>

                                        <p>
                                            NUST Main Campus, H-12,
                                            Islamabad, Pakistan
                                        </p>

                                    </div>

                                </div>


                                <div class="contact-info-item">

                                    <div class="contact-info-icon">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>

                                    <div>

                                        <h6>
                                            Contact Numbers
                                        </h6>

                                        <p>

                                            <a href="tel:+923365317822">
                                                +92 336 5317822
                                            </a>

                                            <br>

                                            <a href="tel:+925190856825">
                                                +92 51 9085 6825
                                            </a>

                                        </p>

                                    </div>

                                </div>


                                <div class="contact-info-item">

                                    <div class="contact-info-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>

                                    <div>

                                        <h6>
                                            Email Address
                                        </h6>

                                        <a href="mailto:advancement@nust.edu.pk">
                                            advancement@nust.edu.pk
                                        </a>

                                    </div>

                                </div>


                                <div class="contact-info-item">

                                    <div class="contact-info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>

                                    <div>

                                        <h6>
                                            Office Hours
                                        </h6>

                                        <p>
                                            Mon - Fri:
                                            9:00 AM - 5:00 PM
                                        </p>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     FORM
                ================================================== --}}

                <div class="col-lg-7">

                    <div class="contact-form-panel">

                        <div class="contact-form-heading">

                            <h3>
                                Send Us a Message
                            </h3>

                            <p>
                                Complete the form below and our team
                                will review your inquiry.
                            </p>

                        </div>


                        {{-- =========================================
                             VALIDATION ERRORS
                        ========================================== --}}

                        @if($errors->any())

                            <div class="contact-alert-danger">

                                <i class="fas fa-exclamation-circle"></i>

                                <div>

                                    <strong>
                                        Please correct the following:
                                    </strong>

                                    <ul>

                                        @foreach($errors->all() as $error)

                                            <li>
                                                {{ $error }}
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        @endif


                        <form
                            id="contactForm"
                            action="{{ route('contact.store') }}"
                            method="POST"
                        >

                            @csrf


                            <div class="row">


                                {{-- NAME --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="contact_name"
                                            class="contact-form-label"
                                        >
                                            Full Name
                                            <span class="contact-required">*</span>
                                        </label>

                                        <div class="contact-input-wrapper">

                                            <i class="fas fa-user contact-input-icon"></i>

                                            <input
                                                type="text"
                                                id="contact_name"
                                                name="name"
                                                value="{{ old('name') }}"
                                                class="contact-form-control @error('name') is-invalid @enderror"
                                                placeholder="Enter your full name"
                                                maxlength="150"
                                                required
                                            >

                                        </div>

                                        @error('name')
                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                </div>


                                {{-- EMAIL --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="contact_email"
                                            class="contact-form-label"
                                        >
                                            Email Address
                                            <span class="contact-required">*</span>
                                        </label>

                                        <div class="contact-input-wrapper">

                                            <i class="fas fa-envelope contact-input-icon"></i>

                                            <input
                                                type="email"
                                                id="contact_email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                class="contact-form-control @error('email') is-invalid @enderror"
                                                placeholder="Enter your email address"
                                                maxlength="255"
                                                required
                                            >

                                        </div>

                                        @error('email')
                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                </div>


                                {{-- PHONE --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="contact_phone"
                                            class="contact-form-label"
                                        >
                                            Phone Number
                                        </label>

                                        <div class="contact-input-wrapper">

                                            <i class="fas fa-phone-alt contact-input-icon"></i>

                                            <input
                                                type="text"
                                                id="contact_phone"
                                                name="phone"
                                                value="{{ old('phone') }}"
                                                class="contact-form-control @error('phone') is-invalid @enderror"
                                                placeholder="+92 300 1234567"
                                                maxlength="30"
                                            >

                                        </div>

                                        @error('phone')
                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                </div>


                                {{-- USER TYPE --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="contact_user_type"
                                            class="contact-form-label"
                                        >
                                            I Am A
                                        </label>

                                        <div class="contact-input-wrapper">

                                            <i class="fas fa-user-tag contact-input-icon"></i>

                                            <select
                                                id="contact_user_type"
                                                name="user_type"
                                                class="contact-form-control @error('user_type') is-invalid @enderror"
                                            >

                                                <option value="">
                                                    Select user type
                                                </option>

                                                <option
                                                    value="donor"
                                                    {{ old('user_type') === 'donor' ? 'selected' : '' }}
                                                >
                                                    Donor
                                                </option>

                                                <option
                                                    value="beneficiary"
                                                    {{ old('user_type') === 'beneficiary' ? 'selected' : '' }}
                                                >
                                                    Beneficiary / Student
                                                </option>

                                                <option
                                                    value="visitor"
                                                    {{ old('user_type') === 'visitor' ? 'selected' : '' }}
                                                >
                                                    Visitor
                                                </option>

                                                <option
                                                    value="other"
                                                    {{ old('user_type') === 'other' ? 'selected' : '' }}
                                                >
                                                    Other
                                                </option>

                                            </select>

                                        </div>

                                        @error('user_type')
                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                </div>


                                {{-- SUBJECT --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="contact_subject"
                                            class="contact-form-label"
                                        >
                                            Subject
                                            <span class="contact-required">*</span>
                                        </label>

                                        <div class="contact-input-wrapper">

                                            <i class="fas fa-heading contact-input-icon"></i>

                                            <input
                                                type="text"
                                                id="contact_subject"
                                                name="subject"
                                                value="{{ old('subject') }}"
                                                class="contact-form-control @error('subject') is-invalid @enderror"
                                                placeholder="Enter inquiry subject"
                                                maxlength="255"
                                                required
                                            >

                                        </div>

                                        @error('subject')
                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                </div>


                                {{-- INQUIRY TYPE --}}
                                <div class="col-md-6">

                                    <div class="contact-form-group">

                                        <label
                                            for="contact_inquiry_type"
                                            class="contact-form-label"
                                        >
                                            Inquiry Type
                                            <span class="contact-required">*</span>
                                        </label>

                                        <div class="contact-input-wrapper">

                                            <i class="fas fa-list contact-input-icon"></i>

                                            <select
                                                id="contact_inquiry_type"
                                                name="inquiry_type"
                                                class="contact-form-control @error('inquiry_type') is-invalid @enderror"
                                                required
                                            >

                                                <option value="">
                                                    Select inquiry type
                                                </option>

                                                <option
                                                    value="general"
                                                    {{ old('inquiry_type') === 'general' ? 'selected' : '' }}
                                                >
                                                    General Inquiry
                                                </option>

                                                <option
                                                    value="donor_support"
                                                    {{ old('inquiry_type') === 'donor_support' ? 'selected' : '' }}
                                                >
                                                    Donor Support
                                                </option>

                                                <option
                                                    value="beneficiary_support"
                                                    {{ old('inquiry_type') === 'beneficiary_support' ? 'selected' : '' }}
                                                >
                                                    Beneficiary Support
                                                </option>

                                                <option
                                                    value="account_support"
                                                    {{ old('inquiry_type') === 'account_support' ? 'selected' : '' }}
                                                >
                                                    Account Support
                                                </option>

                                                <option
                                                    value="technical"
                                                    {{ old('inquiry_type') === 'technical' ? 'selected' : '' }}
                                                >
                                                    Technical Issue
                                                </option>

                                                <option
                                                    value="feedback"
                                                    {{ old('inquiry_type') === 'feedback' ? 'selected' : '' }}
                                                >
                                                    Feedback / Suggestion
                                                </option>

                                                <option
                                                    value="other"
                                                    {{ old('inquiry_type') === 'other' ? 'selected' : '' }}
                                                >
                                                    Other
                                                </option>

                                            </select>

                                        </div>

                                        @error('inquiry_type')
                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                </div>


                                {{-- MESSAGE --}}
                                <div class="col-12">

                                    <div class="contact-form-group">

                                        <label
                                            for="contact_message"
                                            class="contact-form-label"
                                        >
                                            Message
                                            <span class="contact-required">*</span>
                                        </label>

                                        <div class="contact-input-wrapper contact-textarea-wrapper">

                                            <i class="fas fa-comment-alt contact-input-icon"></i>

                                            <textarea
                                                id="contact_message"
                                                name="message"
                                                class="contact-form-control @error('message') is-invalid @enderror"
                                                rows="6"
                                                placeholder="Please describe your inquiry in detail..."
                                                maxlength="3000"
                                                required
                                            >{{ old('message') }}</textarea>

                                        </div>

                                        @error('message')
                                            <span class="contact-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                </div>


                                {{-- PRIVACY --}}
                                <div class="col-12">

                                    <div class="contact-privacy">

                                        <input
                                            type="checkbox"
                                            id="contact_privacy"
                                            name="privacy"
                                            value="1"
                                            {{ old('privacy') ? 'checked' : '' }}
                                            required
                                        >

                                        <label for="contact_privacy">

                                            I confirm that the information
                                            provided is accurate and agree
                                            that the NUST Sharing Network
                                            team may use these details to
                                            contact me regarding this inquiry.

                                        </label>

                                    </div>

                                    @error('privacy')
                                        <span class="contact-error d-block mb-3">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>


                                {{-- BUTTON --}}
                                <div class="col-12">

                                    <button
                                        type="submit"
                                        id="contactSubmitBtn"
                                        class="contact-submit-btn"
                                    >

                                        <span class="contact-submit-spinner"></span>

                                        <span class="contact-submit-text">
                                            Send Message
                                        </span>

                                        <i class="fas fa-paper-plane contact-submit-icon"></i>

                                    </button>

                                </div>


                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ============================================================
     SUCCESS MODAL
============================================================ --}}

@if(session('success'))

    <div
        class="contact-success-overlay"
        id="contactSuccessModal"
    >

        <div class="contact-success-modal">

            <button
                type="button"
                id="contactSuccessClose"
                class="contact-success-close"
            >
                <i class="fas fa-times"></i>
            </button>


            <div class="contact-success-icon-wrap">

                <div class="contact-success-check"></div>

            </div>


            <span class="contact-success-badge">

                <i class="fas fa-check-circle"></i>

                Message Submitted

            </span>


            <h3 class="contact-success-title">
                Thank You!
            </h3>


            <p class="contact-success-message">
                {{ session('success') }}
            </p>


            <button
                type="button"
                id="contactSuccessOkay"
                class="contact-success-btn"
            >

                Done

                <i class="fas fa-check"></i>

            </button>

        </div>

    </div>

@endif


{{-- ============================================================
     JAVASCRIPT
============================================================ --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | Submit Loading Animation
        |--------------------------------------------------------------------------
        */

        const contactForm =
            document.getElementById('contactForm');

        const contactSubmitBtn =
            document.getElementById('contactSubmitBtn');


        if (contactForm && contactSubmitBtn) {

            contactForm.addEventListener(
                'submit',
                function () {

                    if (!contactForm.checkValidity()) {
                        return;
                    }

                    contactSubmitBtn.classList.add(
                        'is-loading'
                    );

                    contactSubmitBtn.disabled = true;


                    const buttonText =
                        contactSubmitBtn.querySelector(
                            '.contact-submit-text'
                        );


                    if (buttonText) {

                        buttonText.textContent =
                            'Submitting...';

                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Success Modal
        |--------------------------------------------------------------------------
        */

        const successModal =
            document.getElementById(
                'contactSuccessModal'
            );

        const closeButton =
            document.getElementById(
                'contactSuccessClose'
            );

        const okayButton =
            document.getElementById(
                'contactSuccessOkay'
            );


        if (successModal) {

            setTimeout(function () {

                successModal.classList.add(
                    'active'
                );

                document.body.style.overflow =
                    'hidden';

            }, 150);


            function closeSuccessModal() {

                successModal.classList.remove(
                    'active'
                );

                document.body.style.overflow = '';

                setTimeout(function () {

                    successModal.style.display =
                        'none';

                }, 350);

            }


            if (closeButton) {

                closeButton.addEventListener(
                    'click',
                    closeSuccessModal
                );

            }


            if (okayButton) {

                okayButton.addEventListener(
                    'click',
                    closeSuccessModal
                );

            }


            successModal.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target === successModal
                    ) {

                        closeSuccessModal();

                    }

                }
            );


            document.addEventListener(
                'keydown',
                function (event) {

                    if (
                        event.key === 'Escape'
                    ) {

                        closeSuccessModal();

                    }

                }
            );

        }

    }
);

</script>
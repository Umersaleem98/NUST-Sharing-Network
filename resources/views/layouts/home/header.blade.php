<style>
    /* =========================
       NAVBAR
    ========================== */
    .navbar {
        background: #fff;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        padding: 10px 0;
        transition: all 0.3s ease;
    }

    .navbar.scrolled {
        padding: 8px 0;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.12);
    }

    /* =========================
       BRAND / LOGO
    ========================== */
    .navbar-brand {
        display: flex;
        align-items: center;
        flex-shrink: 0;
        margin-right: 0;
    }

    .navbar-brand-img {
        width: 150px;
        height: 80px;
        object-fit: contain;
    }

    /* =========================
       CENTER MENU
    ========================== */
    .navbar-nav-center {
        align-items: center;
        gap: 6px;
    }

    .navbar-nav-center .nav-link {
        position: relative;
        padding: 8px 12px !important;
        color: var(--dark-color) !important;
        font-size: 15px;
        font-weight: 600;
        white-space: nowrap;
        transition: color 0.3s ease;
    }

    .navbar-nav-center .nav-link::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 12px;
        width: 0;
        height: 3px;
        border-radius: 20px;
        background: var(--secondary-color);
        transition: width 0.3s ease;
    }

    .navbar-nav-center .nav-link:hover {
        color: var(--primary-color) !important;
    }

    .navbar-nav-center .nav-link:hover::after,
    .navbar-nav-center .nav-link.active::after {
        width: calc(100% - 24px);
    }

    /* =========================
       AUTH BUTTONS
    ========================== */
    .navbar-auth {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-auth {
        min-width: 76px;
        padding: 7px 15px !important;
        border: 2px solid var(--primary-color);
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.2;
        text-align: center;
        transition: all 0.3s ease;
    }

    .btn-login-nav {
        background: transparent;
        color: var(--primary-color) !important;
    }

    .btn-login-nav:hover {
        background: var(--primary-color);
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 113, 184, 0.25);
    }

    .btn-register-nav {
        border-color: var(--secondary-color);
        background: var(--secondary-color);
        color: var(--dark-color) !important;
    }

    .btn-register-nav:hover {
        border-color: var(--primary-color);
        background: var(--primary-color);
        color: #fff !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 113, 184, 0.25);
    }

    /* =========================
       DESKTOP
    ========================== */
    @media (min-width: 992px) {
        .navbar > .container {
            position: relative;
        }

        .navbar-collapse {
            display: flex !important;
            align-items: center;
        }

        /* Keep navigation links in the exact center */
        .navbar-menu {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Keep buttons on the right */
        .navbar-auth {
            margin-left: auto;
        }
    }

    /* =========================
       MOBILE / TABLET
    ========================== */
    @media (max-width: 991.98px) {
        .navbar {
            padding: 7px 0;
        }

        .navbar-brand-img {
            width: 120px;
            height: 60px;
        }

        .navbar-toggler {
            padding: 5px 8px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            box-shadow: none !important;
        }

        .navbar-collapse {
            max-height: calc(100vh - 100px);
            margin-top: 10px;
            padding: 16px;
            overflow-y: auto;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .navbar-menu {
            position: static;
            transform: none;
            width: 100%;
        }

        .navbar-nav-center {
            width: 100%;
            text-align: center;
        }

        .navbar-nav-center .nav-link {
            padding: 10px 12px !important;
        }

        .navbar-nav-center .nav-link::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .navbar-nav-center .nav-link:hover::after,
        .navbar-nav-center .nav-link.active::after {
            width: 45px;
        }

        .navbar-auth {
            justify-content: center;
            width: 100%;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        .btn-auth {
            width: auto;
            min-width: 90px;
        }
    }

    /* =========================
       SMALL MOBILE
    ========================== */
    @media (max-width: 400px) {
        .navbar-brand-img {
            width: 105px;
            height: 55px;
        }

        .navbar-collapse {
            padding: 14px 12px;
        }

        .btn-auth {
            min-width: 82px;
            padding: 7px 12px !important;
        }
    }
</style>

<!-- =========================
     NAVBAR
========================= -->
<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
    <div class="container px-lg-4 px-3">

        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img
                src="{{ asset('admins/assets/images/logos/logo1.png') }}"
                alt="NUST Gift Store"
                class="navbar-brand-img"
            >
        </a>

        <!-- Mobile Toggle -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Center Links -->
            <div class="navbar-menu">
                <ul class="navbar-nav navbar-nav-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">
                            How It Works
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">
                            Stories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Right-Side Buttons -->
            <div class="navbar-auth">
                <a
                    class="btn btn-sm btn-auth btn-login-nav"
                    href="{{ route('login') }}"
                >
                    Login
                </a>

                <a
                    class="btn btn-sm btn-auth btn-register-nav"
                    href="{{ route('register') }}"
                >
                    Register as Donor
                </a>
            </div>

        </div>
    </div>
</nav>
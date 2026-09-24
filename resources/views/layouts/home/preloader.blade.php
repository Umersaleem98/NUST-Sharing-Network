<style>
    :root {
        --white: #ffffff;
    }

    /* =========================
       PRELOADER
    ========================== */
    .loader {
        position: fixed;
        inset: 0;
        width: 100%;
        height: 100%;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        overflow: hidden;
        transition: opacity 0.6s ease, visibility 0.6s ease;
    }

    /* Hide Loader */
    .loader.hidden {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    /* Logo Animation */
    .loader-logo {
        width: 180px;
        height: 180px;
        object-fit: contain;

        /* LEFT TO CENTER + FADE */
        opacity: 0;
        transform: translateX(-250px);

        animation: logoMove 1.5s ease forwards;
    }

    @keyframes logoMove {

        0% {
            opacity: 0;
            transform: translateX(-250px);
        }

        60% {
            opacity: 1;
            transform: translateX(20px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<!-- =========================
     PRELOADER
========================= -->
<div class="loader" id="loader">

    <img src="{{ asset('admins/images/logos/logo.png') }}" alt="Logo" class="loader-logo">

</div>

<!-- =========================
     SCRIPT
========================= -->
<script>
    window.addEventListener('load', function() {

        const loader = document.getElementById('loader');

        setTimeout(() => {
            loader.classList.add('hidden');
        }, 1500);

    });
</script>

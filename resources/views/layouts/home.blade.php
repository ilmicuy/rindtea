<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rind Tea Apps</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}" />

    <style>
        :root {
            --primary: #f9ca7a;
            --bg: #010101;
            --text-color: #fff;
            --border-color: #666;
            --highlight-color: var(--primary);
            --highlight-hover-color: #d1a860;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Override Bootstrap styles */
        .navbar-dark {
            background-color: rgba(1, 1, 1, 0.8) !important;
            border-bottom: 1px solid #a6803e;
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: 700;
            font-style: italic;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-primary:hover {
            background-color: var(--highlight-hover-color) !important;
            border-color: var(--highlight-hover-color) !important;
        }

        .bg-dark {
            background-color: var(--bg) !important;
        }

        #home {
            background-image: linear-gradient(rgba(0, 0, 5, 0.5), rgba(0, 0, 5, 0.5)),
                url("{{ asset('assets/img/hero-flip.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        #home::after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 30%;
            background: linear-gradient(
                0deg,
                rgba(1, 1, 3, 1) 8%,
                rgba(255, 255, 255, 0) 50%
            );
            bottom: 0;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-color);
        }

        .card-body {
            color: var(--text-color);
        }

        .nav-link {
            color: var(--text-color) !important;
            font-size: 1.3rem;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .nav-link::after {
            content: "";
            display: block;
            padding-bottom: 0.5rem;
            border-bottom: 0.1rem solid var(--primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
        }

        .form-control {
            background-color: var(--bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .form-control:focus {
            background-color: var(--bg);
            border-color: var(--primary);
            color: var(--text-color);
            box-shadow: 0 0 0 0.25rem rgba(249, 202, 122, 0.25);
        }

        .input-group-text {
            background-color: var(--bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }

        footer {
            background-color: var(--primary);
            margin-top: auto;
        }

        footer a {
            transition: color 0.3s;
        }

        footer a:hover {
            color: var(--bg) !important;
        }

        /* Animation for cards */
        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Modal styling */
        .modal-content {
            background-color: var(--bg);
            border: 1px solid var(--border-color);
        }

        .modal-header {
            border-bottom-color: var(--border-color);
        }

        .modal-footer {
            border-top-color: var(--border-color);
        }

        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Smooth Scroll Behavior */
        html {
            scroll-behavior: smooth;
        }

        /* AOS Custom Animations */
        [data-aos] {
            pointer-events: none;
        }
        [data-aos].aos-animate {
            pointer-events: auto;
        }

        /* Custom Animation Classes */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }

        .fade-up.aos-animate {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfRlVGUObDiUnSXJl7cS0GJw5yHJNSX8&libraries=places"></script> -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/src/app.js') }}"></script>
</head>

<body>
    <!-- Navbar -->
    @include('includes.navbar')

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('includes.footer')

    <!-- Modal Box Item Detal -->

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/+6281234567890" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script>
        feather.replace();
    </script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script>
        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(number);
        };

        document.addEventListener("DOMContentLoaded", function() {
            const priceElements = document.querySelectorAll('.rupiah');
            priceElements.forEach(function(element) {
                const rawPrice = element.getAttribute('data-price');
                const formattedPrice = rupiah(rawPrice);
                element.innerText = formattedPrice;
            });
        });

        @if(session('successLogin'))
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran Akun Berhasil!',
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        @endif
    </script>

    @stack('myscript')

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false,
            offset: 50
        });

        // Refresh AOS on dynamic content changes
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                AOS.refresh();
            }, 500);
        });

        // Smooth scroll for all anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rind Tea Apps</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}" />

    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="{{ asset('assets/src/app.js') }}"></script>
</head>

<body>
    <!-- Navbar -->
    @include('includes.navbar')

    <div class="container mt-5">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('includes.footer')

    <!-- JavaScript -->
    <script>
        feather.replace();
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(number);
        };

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.rupiah').forEach(function (element) {
                const rawPrice = element.getAttribute('data-price');
                element.innerText = rupiah(rawPrice);
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
</body>
</html>

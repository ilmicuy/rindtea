<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rind Tea Apps</title>
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfRlVGUObDiUnSXJl7cS0GJw5yHJNSX8&libraries=places"></script> -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/src/app.js') }}"></script>
</head>

<body>
    <!-- Navbar -->
    @include('includes.navbar')

    @yield('content')

    <!-- Footer -->
    @include('includes.footer')

    <!-- Modal Box Item Detal -->


    <script>
        feather.replace();
    </script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
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
    </script>

    @stack('myscript')
</body>

</html>
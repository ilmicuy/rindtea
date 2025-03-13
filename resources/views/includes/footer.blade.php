<footer class="text-light py-4 py-md-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-12 mb-3 mb-md-4">
                <div class="socials d-flex flex-wrap justify-content-center gap-3 gap-md-4">
                    <a href="https://www.instagram.com/rind.tea/" class="text-light fs-5 fs-md-4">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/@RindTea" class="text-light fs-5 fs-md-4">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.facebook.com/people/Rind-Tea/pfbid0UxHAzsWFjBAFYuMDtgjyVQud6FkJ7Tpo5ijnjqogPhvCaXQRLkfm9ggXxkSFSfsVl/" class="text-light fs-5 fs-md-4">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://shopee.co.id/rindtea" class="text-light fs-5 fs-md-4">
                        <i class="fas fa-shopping-bag"></i>
                    </a>
                    <a href="https://www.tiktok.com/@rind.tea" class="text-light fs-5 fs-md-4">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <div class="col-12 mb-3 mb-md-4">
                <div class="links d-flex flex-wrap justify-content-center gap-2 gap-md-4">
                    <a href="{{ route('home') }}" class="text-light text-decoration-none px-2 py-1 {{ request()->is('/') ? 'active' : '' }}">Home</a>
                    <a href="{{ request()->routeIs('home') ? '#about' : route('home') . '#about' }}" class="text-light text-decoration-none px-2 py-1">Tentang Kami</a>
                    <a href="{{ request()->routeIs('home') ? '#menu' : route('home') . '#menu' }}" class="text-light text-decoration-none px-2 py-1">Menu</a>
                    <a href="{{ request()->routeIs('home') ? '#products' : route('home') . '#products' }}" class="text-light text-decoration-none px-2 py-1">Produk</a>
                    <a href="{{ request()->routeIs('home') ? '#contact' : route('home') . '#contact' }}" class="text-light text-decoration-none px-2 py-1">Kontak</a>
                </div>
            </div>

            <div class="col-12">
                <div class="credit">
                    <p class="mb-0 small">Copyright &copy; {{ date('Y') }} Rind Tea Apps</p>
                </div>
            </div>
        </div>
    </div>
</footer>

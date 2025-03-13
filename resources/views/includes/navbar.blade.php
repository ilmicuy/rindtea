<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" x-data="{ mobileMenuOpen: false, userDropdownOpen: false }">
    <div class="container">
        <a href="/" class="navbar-brand">Rind <span class="text-primary">Tea</span></a>

        <!-- Desktop Navigation Links -->
        <div class="navbar-nav d-none d-lg-flex">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-scroll" href="/" data-section="home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-scroll" href="{{ request()->routeIs('home') ? '#about' : route('home') . '#about' }}" data-section="about">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-scroll" href="{{ request()->routeIs('home') ? '#menu' : route('home') . '#menu' }}" data-section="menu">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-scroll" href="{{ request()->routeIs('home') ? '#products' : route('home') . '#products' }}" data-section="products">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-scroll" href="{{ request()->routeIs('home') ? '#contact' : route('home') . '#contact' }}" data-section="contact">Kontak</a>
                </li>
            </ul>
        </div>

        <!-- Mobile Navigation Buttons -->
        <div class="d-flex d-lg-none align-items-center">
            <a href="{{ route('shop') }}" class="mobile-nav-button">
                <i class="fas fa-store"></i>
            </a>
            @auth
            <a href="{{ route('cart') }}" class="mobile-nav-button">
                <i class="fas fa-shopping-cart"></i>
            </a>
            @endauth
            <button id="mobile-menu-toggle" class="mobile-nav-button" aria-label="Toggle mobile menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu">
            <div class="container">
                <ul class="mobile-nav-list">
                    <li class="mobile-nav-item">
                        <a href="{{ route('home') }}" class="mobile-nav-link">Home</a>
                    </li>
                    <li class="mobile-nav-item">
                        <a href="{{ request()->routeIs('home') ? '#about' : route('home') . '#about' }}" class="mobile-nav-link">Tentang Kami</a>
                    </li>
                    <li class="mobile-nav-item">
                        <a href="{{ request()->routeIs('home') ? '#menu' : route('home') . '#menu' }}" class="mobile-nav-link">Menu</a>
                    </li>
                    <li class="mobile-nav-item">
                        <a href="{{ request()->routeIs('home') ? '#products' : route('home') . '#products' }}" class="mobile-nav-link">Produk</a>
                    </li>
                    <li class="mobile-nav-item">
                        <a href="{{ request()->routeIs('home') ? '#contact' : route('home') . '#contact' }}" class="mobile-nav-link">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Desktop Navigation Buttons -->
        <div class="d-none d-lg-flex align-items-center">
            <a href="{{ route('shop') }}" class="btn btn-link text-light me-3">
                <i class="fas fa-store"></i>
            </a>

            @auth
                <a href="{{ route('cart') }}" class="btn btn-link text-light position-relative me-3">
                    <i class="fas fa-shopping-cart"></i>
                    @php
                        $user = Auth::user();
                        $carts = \App\Models\Cart::where('users_id', $user->id)->sum('qty');
                    @endphp
                    @if ($carts > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $carts }}
                        </span>
                    @endif
                </a>
            @endauth

            <div class="dropdown">
                <button class="btn btn-link text-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    @if (Route::has('login'))
                        @auth
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    Hi, {{ Auth::user()->name }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('order') }}">
                                    Order List
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </li>
                        @else
                            <li>
                                <a class="dropdown-item" href="{{ route('login') }}">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>

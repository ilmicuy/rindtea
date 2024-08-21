<nav class="navbar" x-data>
    <a href="/" class="navbar-logo">Rind <span>Tea</span></a>
    <div class="navbar-nav">
        <a href="/">Home</a>
        <a href="{{ request()->routeIs('home') ? '#about' : route('home') . '#about' }}">Tentang Kami</a>
        <a href="{{ request()->routeIs('home') ? '#menu' : route('home') . '#menu' }}">Menu</a>
        <a href="{{ request()->routeIs('home') ? '#products' : route('home') . '#products' }}">Produk</a>
        <a href="{{ request()->routeIs('home') ? '#contact' : route('home') . '#contact' }}">Kontak</a>
    </div>
    <div class="navbar-extra">
        <a href="{{ route('shop') }}"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                <path
                    d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
            </svg></a>
        {{-- <a href="#" id="search-button"><i data-feather="search"></i></a> --}}
        @auth
            <a href="{{ route('cart') }}"><i data-feather="shopping-cart"></i>
                @php
                    $user = Auth::user();
                    $carts = \App\Models\Cart::where('users_id', $user->id)->sum('qty');
                @endphp
                @if ($carts > 0)
                    <span class="">
                        {{ $carts }}
                    </span>
                @else
                    <span class="">
                        0
                    </span>
                @endif
            </a>
        @endauth

        <div class="dropdown">
            <button class="dropdown-button dropdown-toggle" data-bs-toggle="dropdown"><i
                    data-feather="user"></i></button>
            <div class="dropdown-content">
                @if (Route::has('login'))
                    <nav class="dropdown-menu dropdown-menu-dark" style="margin-top: -10px;">
                        @auth
                            <x-dropdown-link :href="route('profile.edit')" class="dropdown-item">
                                Hi, {{ Auth::user()->name }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('order')" class="dropdown-item">
                                Order List
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" class="dropdown-item"
                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="dropdown-item">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="dropdown-item">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
    </div>

    <!-- Search -->
    {{-- <div class="search-form">
        <input type="search" id="search-box" placeholder="Cari..." />
        <label for="search-box"><i data-feather="search"></i></label>
    </div> --}}

</nav>

<nav class="main-sidebar ps-menu">
    <div class="sidebar-header">
        <div class="text">
            <h3>Rind Tea Apps</h3>
        </div>
        <div class="close-sidebar action-toggle">
            <i class="fas fa-times"></i>
        </div>
    </div>
    <div class="sidebar-content">
        <ul>

            @hasanyrole('owner|keuangan')
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @endhasanyrole

            @hasanyrole('owner|produksi|marketing')
            <li class="menu-category">
                <span>Product</span>
            </li>

            <li class="{{ request()->routeIs('product.*') && !request()->routeIs('product.productTransactions') ? 'active' : '' }}">
                <a href="{{ route('product.index') }}" class="link">
                    <i class="fas fa-box"></i>
                    <span>Product</span>
                </a>
            </li>
            @endhasanyrole

            @hasrole('owner')
            <li class="{{ request()->routeIs('product.productTransactions') ? 'active' : '' }}">
                <a href="{{ route('product.productTransactions') }}" class="link">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Product Transaction</span>
                </a>
            </li>
            @endhasrole

            @hasanyrole('owner|marketing|produksi')
            <li class="{{ request()->routeIs('requestProduct.*') ? 'active' : '' }}">
                <a href="{{ route('requestProduct.index') }}" class="link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Request Product</span>
                </a>
            </li>
            @endhasanyrole

            @hasanyrole('owner|produksi|keuangan')
            <li class="menu-category">
                <span>Bahan Baku</span>
            </li>

            <li class="{{ request()->routeIs('ingredient.*') ? 'active' : '' }}">
                <a href="{{ route('ingredient.index') }}" class="link">
                    <i class="fas fa-cubes"></i>
                    <span>Bahan Baku</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('requestIngredient.index') ? 'active' : '' }}">
                <a href="{{ route('requestIngredient.index') }}" class="link">
                    <i class="fas fa-cube"></i>
                    <span>Request Bahan Baku</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('requestIngredient.logs') ? 'active' : '' }}">
                <a href="{{ route('requestIngredient.logs') }}" class="link">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Log Request Bahan Baku</span>
                </a>
            </li>
            @endhasanyrole

            @hasanyrole('owner|keuangan|marketing')
            <li class="menu-category">
                <span>Transaction</span>
            </li>
            <li class="{{ request()->routeIs('transaction.*') ? 'active' : '' }}">
                <a href="{{ route('transaction.index') }}" class="link">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Transaction</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('transactionLogs.*') ? 'active' : '' }}">
                <a href="{{ route('transactionLogs.index') }}" class="link">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Transaction Log</span>
                </a>
            </li>
            @endhasanyrole

            {{-- @hasanyrole('owner|marketing|produksi')
            <li class="{{ request()->routeIs('reviews.index') ? 'active' : '' }}">
                <a href="{{ route('reviews.index') }}" class="link">
                    <i class="fas fa-star"></i>
                    <span>Reviews</span>
                </a>
            </li>
            @endhasanyrole --}}

            <li class="menu-category">
                <span>Tools</span>
            </li>
            <li class="{{ request()->routeIs('cekResi') ? 'active' : '' }}">
                <a href="{{ route('cekResi') }}" class="link">
                    <i class="fas fa-shipping-fast"></i>
                    <span>Cek Resi</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('inbox.*') ? 'active' : '' }}">
                <a href="{{ route('inbox.index') }}" class="link">
                    <i class="fas fa-envelope"></i>
                    <span>Inbox</span>
                </a>
            </li>

            {{-- @hasanyrole('owner')
            <li>
                <a href="#" class="main-menu has-dropdown">
                    <i class="fas fa-globe"></i>
                    <span>Landing Page</span>
                </a>
                <ul class="sub-menu {{ request()->is('herosection') || request()->is('about') || request()->is('menu') ? 'show' : '' }}">
                    <li>
                        <a href="{{ route('herosection') }}" class="link {{ request()->is('herosection') ? 'active' : '' }}">
                            <span>Hero Section</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="link {{ request()->is('about') ? 'active' : '' }}">
                            <span>About</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('menu') }}" class="link {{ request()->is('menu') ? 'active' : '' }}">
                            <span>Menu</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endhasanyrole --}}

        </ul>
    </div>
</nav>

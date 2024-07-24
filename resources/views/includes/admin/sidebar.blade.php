<nav class="main-sidebar ps-menu">
    <!-- <div class="sidebar-toggle action-toggle">
                <a href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </div> -->
    <!-- <div class="sidebar-opener action-toggle">
                <a href="#">
                    <i class="ti-angle-right"></i>
                </a>
            </div> -->
    <div class="sidebar-header">
        <div class="text">
            <h3>Rind Tea Apps</h3>
        </div>
        <div class="close-sidebar action-toggle">
            <i class="ti-close"></i>
        </div>
    </div>
    <div class="sidebar-content">
        <ul>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="link">
                    <i class="ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @hasanyrole('owner|produksi')
            <li class="menu-category">
                <span class="">Product</span>
            </li>

            <li class="{{ request()->routeIs('product.*') && !request()->routeIs('product.productTransactions') ? 'active' : '' }}">
                <a href="{{ route('product.index') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Product</span>
                </a>
            </li>
            @endhasanyrole

            @hasrole('owner')
            <li class="{{ request()->routeIs('product.productTransactions') ? 'active' : '' }}">
                <a href="{{ route('product.productTransactions') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Product Transaction</span>
                </a>
            </li>
            @endhasrole

            @hasanyrole('owner|marketing')
            <li class="{{ request()->routeIs('requestProduct.*') ? 'active' : '' }}">
                <a href="{{ route('requestProduct.index') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Request Product</span>
                </a>
            </li>
            @endhasanyrole

            @hasanyrole('owner|produksi|keuangan')
            <li class="menu-category">
                <span class="">Bahan Baku</span>
            </li>

            <li class="{{ request()->routeIs('ingredient.*') ? 'active' : '' }}">
                <a href="{{ route('ingredient.index') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Bahan Baku</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('requestIngredient.*') ? 'active' : '' }}">
                <a href="{{ route('requestIngredient.index') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Request Bahan Baku</span>
                </a>
            </li>
            @endhasanyrole

            @hasanyrole('owner|keuangan')
            <li class="menu-category">
                <span class="">Transaction</span>
            </li>
            <li class="{{ request()->routeIs('transaction.*') ? 'active' : '' }}">
                <a href="{{ route('transaction.index') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Transaction</span>
                </a>
            </li>
            @endhasanyrole

            @hasanyrole('owner|marketing|produksi')
            <li class="{{ request()->routeIs('reviews.index') ? 'active' : '' }}">
                <a href="{{ route('reviews.index') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Reviews</span>
                </a>
            </li>
            @endhasanyrole


            <li class="menu-category">
                <span class="">Tools</span>
            </li>
            <li class="{{ request()->routeIs('cekResi') ? 'active' : '' }}">
                <a href="{{ route('cekResi') }}" class="link {{ request()->is('cekResi') ? 'active' : '' }}">
                    <i class="ti-package"></i>
                    <span>Cek Resi</span>
                </a>
            </li>

            @hasanyrole('owner')
            <li>
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-desktop"></i>
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
            @endhasanyrole

        </ul>
    </div>
</nav>

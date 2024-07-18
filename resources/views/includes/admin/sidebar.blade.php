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
            <li class="active">
                <a href="{{ route('dashboard') }}" class="link">
                    <i class="ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-category">
                <span>User Interface</span>
            </li>
            <li>
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-desktop"></i>
                    <span>Landing Page</span>
                </a>
                <ul
                    class="sub-menu {{ request()->is('herosection') || request()->is('about') || request()->is('menu') ? 'show' : '' }}">
                    <li>
                        <a href="{{ route('herosection') }}"
                            class="link {{ request()->is('herosection') ? 'active' : '' }}">
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
            <li class="menu-category">
                <span class="">Utilities</span>
            </li>
            <li>
                <a href="{{ route('product') }}" class="link {{ request()->is('product') ? 'active' : '' }}">
                    <i class="ti-package"></i>
                    <span>Product</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaction') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Transaction</span>
                </a>
            </li>
            <li>
                <a href="{{ route('reviews') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Reviews</span>
                </a>
            </li>

        </ul>
    </div>
</nav>

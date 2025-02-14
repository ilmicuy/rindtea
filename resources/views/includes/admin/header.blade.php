<header class="header-navbar fixed">
    <div class="header-wrapper">
        <div class="header-left">
            <div class="sidebar-toggle action-toggle"><i class="fas fa-bars"></i></div>
        </div>
        <div class="header-content">
            <div class="theme-switch-icon"></div>
            <div class="notification dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-envelope"></i>
                    @if ($unreadInboxes > 0)
                    <span class="badge">{{ $unreadInboxes }}</span>
                    @endif
                </a>
                <ul class="dropdown-menu medium">
                    <li class="menu-header">
                        <a class="dropdown-item" href="#">Message</a>
                    </li>
                    <li class="menu-content ps-menu">
                        @forelse ($inboxes as $inbox)
                            <a href="{{ route('inbox.show', $inbox->id) }}">
                                <div class="message-image">
                                    <img src="{{ asset('admin/assets/images/avatar1.png') }}" class="rounded-circle w-100" alt="user">
                                </div>
                                <div class="message-content {{ $inbox->is_read == 1 ? 'read' : '' }}">
                                    <div class="subject">
                                        {{ $inbox->sender->name }}
                                    </div>
                                    <div class="body">
                                        {{ $inbox->message }}
                                    </div>
                                    <div class="time">{{ $inbox->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        @empty
                            <a href="javascript:void(0);" class="text-center">
                                Tidak ada message
                            </a>
                        @endforelse
                    </li>
                </ul>
            </div>
            <div class="notification dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-bell"></i>
                    @if ($getProductRequest + $getIngredientRequest + $hasLowStock != 0)
                    <span class="badge">{{ $getProductRequest + $getIngredientRequest + $hasLowStock }}</span>
                    @endif
                </a>
                <ul class="dropdown-menu medium">
                    <li class="menu-header">
                        <a class="dropdown-item" href="#">Notification</a>
                    </li>
                    <li class="menu-content ps-menu">

                        @if ($getProductRequest != 0)
                        <a href="{{ route('requestProduct.index') }}">
                            <div class="message-icon text-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="message-content">
                                <div class="body">
                                    Ada {{ $getProductRequest }} pending request produk yang perlu ditinjau.
                                </div>
                                <div class="time">Harap segera tanggapi</div>
                            </div>
                        </a>
                        @endif

                        @if ($getIngredientRequest != 0)
                        <a href="{{ route('requestIngredient.index') }}">
                            <div class="message-icon text-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="message-content">
                                <div class="body">
                                    Ada {{ $getIngredientRequest }} pending request bahan baku yang perlu ditinjau.
                                </div>
                                <div class="time">Harap segera tanggapi</div>
                            </div>
                        </a>
                        @endif

                        @if ($hasLowStock)
                            <a href="{{ route('requestProduct.index') }}">
                                <div class="message-icon text-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="message-content">
                                    <div class="body">
                                        Ada beberapa produk dengan stok hampir habis (di bawah 10):
                                        @php
                                            $lowStockString = $lowStockProducts->map(function ($product) {
                                                return $product->name . ' (Stok: ' . $product->quantity . ')';
                                            })->implode(', ');
                                        @endphp
                                        {{ $lowStockString }}
                                    </div>
                                </div>
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
            <div class="dropdown dropdown-menu-end">
                <a href="#" class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="label">
                        <span></span>
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                    <img class="img-user" src="{{ asset('admin/assets/images/avatar1.png') }}" alt="user">
                </a>
                <ul class="dropdown-menu small">
                    <li class="menu-content ps-menu">
                        <a href="#">
                            <div class="description">
                                <i class="ti-user"></i> Profile
                            </div>
                        </a>
                        <a href="#">
                            <div class="description">
                                <i class="ti-settings"></i> Setting
                            </div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
                                <div class="description">
                                    <i class="ti-power-off"></i> Logout
                                </div>
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

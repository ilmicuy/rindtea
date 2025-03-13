@extends('layouts.home')

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5" style="background-color: var(--primary);" data-aos="fade-down">
        <div class="container">
            <h1 class="page-title mb-3">Shopping Cart</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <!-- Cart Page Start -->
    <div class="modern-checkout">
        <div class="container">
            @if (count($carts) > 0)
                <div class="row g-4">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="checkout-card">
                            <div class="card-body">
                                <h5 class="card-title d-flex align-items-center mb-4">
                                    <i class="fas fa-shopping-bag me-2"></i>
                                    Cart Items
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Total</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total = 0 @endphp
                                            @foreach ($carts as $cart)
                                                <tr>
                                                    <td>
                                                        <div class="product-info">
                                                            <div class="product-image">
                                                                <img src="{{ Storage::url($cart->product->photos) }}"
                                                                    alt="{{ $cart->product->name }}">
                                                            </div>
                                                            <div>
                                                                <h6 class="product-name">{{ $cart->product->name }}</h6>
                                                                <small class="product-weight">Weight: {{ $cart->product->weight }}g</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="rupiah" data-price="{{ $cart->product->price }}"></span>
                                                    </td>
                                                    <td>
                                                        <div class="quantity-wrapper" style="width: 120px;">
                                                            <div class="input-group">
                                                                <button class="btn btn-outline-secondary btn-sm btn-minus" type="button" data-id="{{ $cart->id }}">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                                <input type="number" class="form-control form-control-sm text-center qty-input"
                                                                    value="{{ $cart->qty }}" min="1" data-id="{{ $cart->id }}">
                                                                <button class="btn btn-outline-secondary btn-sm btn-plus" type="button" data-id="{{ $cart->id }}">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @php $total = $cart->product->price * $cart->qty @endphp
                                                    <td>
                                                        <span class="rupiah" data-price="{{ $total }}"></span>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('cart-delete', $cart->id) }}" method="POST" class="d-inline">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-link text-danger p-0">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="order-summary">
                            <h5 class="mb-4">Cart Summary</h5>
                            @php $subtotal = 0; @endphp
                            @foreach ($carts as $cart)
                                @php $subtotal += $cart->product->price * $cart->qty; @endphp
                            @endforeach

                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span class="rupiah" data-price="{{ $subtotal }}"></span>
                            </div>

                            <div class="summary-item">
                                <span>Shipping</span>
                                <span>Calculated at checkout</span>
                            </div>

                            <div class="summary-item border-0">
                                <strong>Total</strong>
                                <strong class="rupiah" data-price="{{ $subtotal }}"></strong>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ route('checkout') }}" class="btn w-100 py-3" style="background-color: var(--primary); color: var(--bg); border: none; border-radius: 8px;">
                                    <i class="fas fa-shopping-cart me-2"></i> Proceed to Checkout
                                </a>
                                <a href="/shop" class="btn w-100 py-2" style="background: transparent; color: #0d6efd; border: 1px solid #0d6efd; border-radius: 8px;">
                                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="checkout-card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x mb-4 text-muted"></i>
                        <h3>Your cart is empty</h3>
                        <p class="text-muted mb-4">Add some products to your cart and come back here to complete your purchase.</p>
                        <a href="/shop" class="btn-checkout">
                            <i class="fas fa-store me-2"></i> Start Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

@push('myscript')
<script>
$(document).ready(function() {
    // Format rupiah
    $('.rupiah').each(function() {
        var price = $(this).data('price');
        $(this).text(new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price));
    });

    // Quantity buttons
    $('.btn-plus').click(function() {
        var id = $(this).data('id');
        var qtyInput = $(this).closest('.input-group').find('.qty-input');
        var qty = parseInt(qtyInput.val()) + 1;
        updateCartQuantity(id, qty);
    });

    $('.btn-minus').click(function() {
        var id = $(this).data('id');
        var qtyInput = $(this).closest('.input-group').find('.qty-input');
        var qty = Math.max(1, parseInt(qtyInput.val()) - 1);
        updateCartQuantity(id, qty);
    });

    // Update cart quantity via AJAX
    function updateCartQuantity(cartId, qty) {
        $.ajax({
            url: '{{ route("cart.add-quantity") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId,
                qty: qty
            },
            success: function(response) {
                if (response.success) {
                    // Update the quantity in the UI
                    $('.qty-input[data-id="' + cartId + '"]').val(qty);
                    // Refresh the page to update all totals
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again.'
                });
            }
        });
    }

    // Prevent manual input beyond limits
    $('.qty-input').on('change', function() {
        var id = $(this).data('id');
        var qty = parseInt($(this).val());
        if (qty < 1) {
            $(this).val(1);
            qty = 1;
        }
        updateCartQuantity(id, qty);
    });

    // Confirm delete
    $('form[action*="cart-delete"]').on('submit', function(e) {
        e.preventDefault();
        var form = this;

        Swal.fire({
            title: 'Remove Item?',
            text: "Are you sure you want to remove this item from your cart?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush

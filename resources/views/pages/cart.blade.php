@extends('layouts.home')


@section('content')

    <!-- Single Page Header start -->
    <div class="single-page-header">
        <h1 class="page-title">Keranjang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            {{-- <li class="breadcrumb-item"><a href="#">Pages</a></li> --}}
            <li class="breadcrumb-item active">Keranjang</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="cart-page">
        <div class="">
            <div class="">
                <table class="">
                    <thead>
                        <tr>
                            <th scope="col">Produk</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @foreach ($carts as $cart)
                            <tr>
                                <td>
                                    <div class="cart-item">
                                        <img src="{{ Storage::url($cart->product->photos) }}" alt="">
                                    </div>
                                </td>
                                <td>
                                    <p class="cart-item-name">{{ $cart->product->name }}</p>
                                </td>
                                <td>
                                    <p class="cart-item-price rupiah" data-price="{{ $cart->product->price }}"></p>
                                </td>
                                {{-- <td>
                                    <p class="cart-item-qty">{{ $cart->qty }} Pcs</p>
                                </td> --}}
                                <td>
                                    <div class="product-details">
                                        <div class="mb-5 input-group quantity">
                                            <div class="input-group-btn">
                                                <button class="border btn btn-sm btn-minus rounded-circle bg-light"
                                                    type="button" data-id="{{ $cart->id }}">
                                                    <i data-feather="minus"></i>
                                                </button>
                                            </div>
                                            <input type="number" class="form-control text-center qty-input" value="{{ $cart->qty }}"
                                                min="1" data-id="{{ $cart->id }}">
                                            <div class="input-group-btn">
                                                <button class="border btn btn-sm btn-plus rounded-circle bg-light"
                                                    type="button" data-id="{{ $cart->id }}">
                                                    <i data-feather="plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @php $total = $cart->product->price * $cart->qty @endphp
                                <td>
                                    <p class="cart-item-total rupiah" data-price="{{ $total }}"></p>
                                </td>
                                <td>
                                    <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="cart-item-action">
                                            <i data-feather="x-circle"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (count($carts) > 0)
                <div class="cart-summary">
                    <div class="">
                        @php $subtotal = 0; @endphp
                        @foreach ($carts as $cart)
                            @php $subtotal += $cart->product->price * $cart->qty; @endphp
                        @endforeach
                        <h5 class="">Total</h5>
                        <p class="rupiah" data-price="{{ $subtotal }}"></p>
                    </div>
                    <a href="{{ route('checkout') }}" class="checkout-button" type="button">Proses Checkout</a>
                </div>
            @endif
        </div>
    </div>
    <!-- Cart Page End -->
@endsection


@push('myscript')
<script>
    $(document).ready(function () {
        // Plus button click
        $('.btn-plus').click(function () {
            var id = $(this).data('id');
            var qtyInput = $(this).closest('.quantity').find('.qty-input');
            var qty = parseInt(qtyInput.val()) + 1;
            updateCartQuantity(id, qty);
        });

        // Minus button click
        $('.btn-minus').click(function () {
            var id = $(this).data('id');
            var qtyInput = $(this).closest('.quantity').find('.qty-input');
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
                success: function (response) {
                    if (response.success) {
                        // Update the quantity in the UI
                        $('.qty-input[data-id="' + cartId + '"]').val(qty);
                        // Update the total price in the UI
                        $('.cart-item-total[data-id="' + cartId + '"]').text(response.newTotal);
                        $('.cart-summary .rupiah').text(response.subtotal);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
</script>
@endpush

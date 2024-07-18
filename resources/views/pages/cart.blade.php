@extends('layouts.home')


@section('content')
    
    <!-- Single Page Header start -->
    <div class="single-page-header">
        <h1 class="page-title">Keranjang</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
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
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
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
                                <td>
                                    <p class="cart-item-qty">{{ $cart->qty }} Pcs</p>
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
                    <a href="{{ route('checkout') }}" class="checkout-button" type="button">Proceed to Checkout</a>
                </div>
            @endif
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

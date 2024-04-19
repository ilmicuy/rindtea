@extends('layouts.home')

@section('title')
    Cart | Point Sebelas
@endsection

@section('content')
    <!-- Single Page Header start -->
    <div class="py-5 container-fluid page-header">
        <h1 class="text-center text-white display-6">Cart</h1>
        <ol class="mb-0 breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="text-white breadcrumb-item active">Cart</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="py-5 container-fluid">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">
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
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ Storage::url($cart->product->photos) }}" class="img-fluid me-5 rounded-circle"
                                            style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mt-4 mb-0">{{$cart->product->name}}</p>
                                </td>
                                <td>
                                    <p class="mt-4 mb-0">Rp.{{number_format($cart->product->price)}}</p>
                                </td>
                                <td>
                                    <p class="mt-4 mb-0">{{$cart->qty}} Pcs</p>
                                </td>
                                @php $total = $cart->product->price * $cart->qty @endphp
                                <td>
                                    <p class="mt-4 mb-0">{{number_format($total)}}</p>
                                </td>
                                <td>
                                    <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="mt-4 border btn btn-md rounded-circle bg-light">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(count($carts) > 0)
              
      
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="rounded bg-light">
                            @php $subtotal = 0; @endphp
                            @foreach ($carts as $cart)
                                @php $subtotal += $cart->product->price * $cart->qty; @endphp
                            @endforeach
                            <div class="py-4 mb-4 border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4">Rp.{{ number_format($subtotal) }}</p>
                            </div>
                            <a href="{{ route('checkout') }}"
                                class="px-4 py-3 mb-4 btn border-secondary rounded-pill text-primary text-uppercase ms-4"
                                type="button">Proceed Checkout
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <!-- Cart Page End -->
@endsection

@extends('layouts.home')

@section('title')
    Checkout | Point Sebelas
@endsection

@section('content')
    <!-- Single Page Header start -->
    <div class="py-5 container-fluid page-header">
        <h1 class="text-center text-white display-6">Checkout</h1>
        <ol class="mb-0 breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="text-white breadcrumb-item active">Checkout</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="py-5 container-fluid">
        <div class="container py-5">
            <h1 class="mb-4">Billing details</h1>
            <form method="post" action="{{ route('checkout.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="my-3 form-label">First Name<sup>*</sup></label>
                                    <input type="text" name="first_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="my-3 form-label">Last Name<sup>*</sup></label>
                                    <input type="text" name="last_name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="my-3 form-label">Address <sup>*</sup></label>
                            <input type="text" name="address" class="form-control" placeholder="House Number Street Name">
                        </div>
                        <div class="form-item">
                            <label class="my-3 form-label">Town/City<sup>*</sup></label>
                            <input type="text" name="city" class="form-control">
                        </div>
                        <div class="form-item">
                            <label class="my-3 form-label">Country<sup>*</sup></label>
                            <input type="text" name="country" class="form-control">
                        </div>
                        <div class="form-item">
                            <label class="my-3 form-label">Postcode/Zip<sup>*</sup></label>
                            <input type="text" name="zip_code" class="form-control">
                        </div>
                        <div class="form-item">
                            <label class="my-3 form-label">Mobile Phone<sup>*</sup></label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                        {{-- <div class="mt-5">
                            <input type="text" class="py-3 mb-4 rounded border-1 me-5" placeholder="  Coupon Code">
                            <button class="px-4 py-3 btn border-secondary rounded-pill text-primary" type="button">Apply
                                Coupon</button>
                        </div> --}}
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Products</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp
                                    @foreach ($checkouts as $checkout)
                                    @php $total = $checkout->product->price * $checkout->qty @endphp
                                        <tr>
                                            <th scope="row">
                                                <div class="mt-2 d-flex align-items-center">
                                                    <img src="{{Storage::url($checkout->product->photos) }}" class="img-fluid rounded-circle"
                                                        style="width: 90px; height: 90px;" alt="">
                                                </div>
                                            </th>
                                            <td class="py-5">{{$checkout->product->name}}</td>
                                            <td class="py-5">Rp.{{number_format($checkout->product->price)}}</td>
                                            <td class="py-5">{{$checkout->qty}}</td>
                                            <input type="hidden" name="qty" value={{$checkout->qty}}>
                                            <td class="py-5">{{number_format($total)}}</td>
                                        </tr>
                                    @endforeach
                                   
                                    <tr>
                                        @php $totalPrice = 0 @endphp
                                        @foreach ($checkouts as $checkout)
                                            @php $totalPrice += $checkout->product->price * $checkout->qty @endphp
                                        @endforeach
                                        <th scope="row">
                                        </th>
                                        <td class="py-5">
                                            <p class="py-3 mb-0 text-dark text-uppercase">TOTAL + PPN 10%</p>
                                        </td>
                                        <td class="py-5"></td>
                                        <td class="py-5"></td>
                                        <td class="py-5">
                                            <input type="hidden" name="total_price" value={{$totalPrice}}>
                                            <div class="py-3 border-bottom border-top">
                                                <p name='total_price' class="mb-0 text-dark">Rp.{{number_format($totalPrice)}}</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td class="py-5">
                                            <p class="py-4 mb-0 text-dark">Shipping</p>
                                        </td>
                                        <td colspan="3" class="py-5">
                                            <div class="form-check text-start">
                                                <input type="checkbox" class="border-0 form-check-input bg-primary"
                                                    id="Shipping-1" name="Shipping-1" value="Shipping">
                                                <label class="form-check-label" for="Shipping-1">Free Shipping</label>
                                            </div>
                                            <div class="form-check text-start">
                                                <input type="checkbox" class="border-0 form-check-input bg-primary"
                                                    id="Shipping-2" name="Shipping-1" value="Shipping">
                                                <label class="form-check-label" for="Shipping-2">Flat rate: $15.00</label>
                                            </div>
                                            <div class="form-check text-start">
                                                <input type="checkbox" class="border-0 form-check-input bg-primary"
                                                    id="Shipping-3" name="Shipping-1" value="Shipping">
                                                <label class="form-check-label" for="Shipping-3">Local Pickup:
                                                    $8.00</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="py-3 text-center row g-4 align-items-center justify-content-center border-bottom">
                            <div class="col-12">
                                <div class="my-3 form-check text-start">
                                    <input type="checkbox" class="border-0 form-check-input bg-primary" id="Transfer-1"
                                        name="Transfer" value="Transfer">
                                    <label class="form-check-label" for="Transfer-1">Direct Bank Transfer</label>
                                </div>
                                <p class="text-start text-dark">Make your payment directly into our bank account. Please
                                    use your Order ID as the payment reference. Your order will not be shipped until the
                                    funds have cleared in our account.</p>
                            </div>
                        </div>
                        <div class="py-3 text-center row g-4 align-items-center justify-content-center border-bottom">
                            <div class="col-12">
                                <div class="my-3 form-check text-start">
                                    <input type="checkbox" class="border-0 form-check-input bg-primary" id="Delivery-1"
                                        name="Delivery" value="Delivery">
                                    <label class="form-check-label" for="Delivery-1">Cash On Delivery</label>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 text-center row g-4 align-items-center justify-content-center">
                            <button type="submit"
                                class="px-4 py-3 btn border-secondary text-uppercase w-100 text-primary">Place
                                Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Checkout Page End -->
@endsection

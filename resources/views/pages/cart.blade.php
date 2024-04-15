@extends('layouts.home')

@section('title')
    Contact | Point Sebelas
@endsection

@section('content')
    <!-- Single Page Header start -->
    <div class="py-5 container-fluid page-header">
        <h1 class="text-center text-white display-6">Cart</h1>
        <ol class="mb-0 breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="img/vegetable-item-3.png" class="img-fluid me-5 rounded-circle"
                                        style="width: 80px; height: 80px;" alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mt-4 mb-0">Big Banana</p>
                            </td>
                            <td>
                                <p class="mt-4 mb-0">2.99 $</p>
                            </td>
                            <td>
                                <div class="mt-4 input-group quantity" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="border btn btn-sm btn-minus rounded-circle bg-light">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="text-center border-0 form-control form-control-sm"
                                        value="1">
                                    <div class="input-group-btn">
                                        <button class="border btn btn-sm btn-plus rounded-circle bg-light">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mt-4 mb-0">2.99 $</p>
                            </td>
                            <td>
                                <button class="mt-4 border btn btn-md rounded-circle bg-light">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </td>

                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="img/vegetable-item-5.jpg" class="img-fluid me-5 rounded-circle"
                                        style="width: 80px; height: 80px;" alt="" alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mt-4 mb-0">Potatoes</p>
                            </td>
                            <td>
                                <p class="mt-4 mb-0">2.99 $</p>
                            </td>
                            <td>
                                <div class="mt-4 input-group quantity" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="border btn btn-sm btn-minus rounded-circle bg-light">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="text-center border-0 form-control form-control-sm"
                                        value="1">
                                    <div class="input-group-btn">
                                        <button class="border btn btn-sm btn-plus rounded-circle bg-light">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mt-4 mb-0">2.99 $</p>
                            </td>
                            <td>
                                <button class="mt-4 border btn btn-md rounded-circle bg-light">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center">
                                    <img src="img/vegetable-item-2.jpg" class="img-fluid me-5 rounded-circle"
                                        style="width: 80px; height: 80px;" alt="" alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mt-4 mb-0">Awesome Brocoli</p>
                            </td>
                            <td>
                                <p class="mt-4 mb-0">2.99 $</p>
                            </td>
                            <td>
                                <div class="mt-4 input-group quantity" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="border btn btn-sm btn-minus rounded-circle bg-light">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="text-center border-0 form-control form-control-sm"
                                        value="1">
                                    <div class="input-group-btn">
                                        <button class="border btn btn-sm btn-plus rounded-circle bg-light">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mt-4 mb-0">2.99 $</p>
                            </td>
                            <td>
                                <button class="mt-4 border btn btn-md rounded-circle bg-light">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-5">
                <input type="text" class="py-3 mb-4 border-0 rounded border-bottom me-5" placeholder="Coupon Code">
                <button class="px-4 py-3 btn border-secondary rounded-pill text-primary" type="button">Apply
                    Coupon</button>
            </div>
            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="rounded bg-light">
                        <div class="p-4">
                            <h1 class="mb-4 display-6">Cart <span class="fw-normal">Total</span></h1>
                            <div class="mb-4 d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0">$96.00</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Shipping</h5>
                                <div class="">
                                    <p class="mb-0">Flat rate: $3.00</p>
                                </div>
                            </div>
                            <p class="mb-0 text-end">Shipping to Ukraine.</p>
                        </div>
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p class="mb-0 pe-4">$99.00</p>
                        </div>
                        <a href="{{ route('checkout') }}"
                            class="px-4 py-3 mb-4 btn border-secondary rounded-pill text-primary text-uppercase ms-4"
                            type="button">Proceed Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

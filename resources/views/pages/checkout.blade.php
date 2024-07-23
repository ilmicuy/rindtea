@extends('layouts.home')

@section('content')
<!-- Single Page Header start -->
<div class="single-page-header">
    <h1 class="page-title">Checkout</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active">Checkout</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Checkout Page Start -->
<div class="checkout-page">
    <div class="container">
        <h1 class="title">Billing details</h1>
        <form method="post" id="frmCheckout" action="{{ route('checkout.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="order-summary">
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
                        @php
                        $total = 0;
                        $weight = 0;
                        $is_local_courier_only = false;
                        @endphp
                        @foreach ($checkouts as $checkout)
                        @php
                        $weight = $checkout->product->weight * $checkout->qty;
                        $total = $checkout->product->price * $checkout->qty;

                        if($checkout->product->is_local_courier_only){
                        $is_local_courier_only = true;
                        }

                        @endphp
                        <tr>
                            <input type="hidden" id="weight" name="weight" value="{{ $weight }}">
                            <th scope="row">
                                <div class="product-image">
                                    <img src="{{ Storage::url($checkout->product->photos) }}" class="product-img" alt="">
                                </div>
                            </th>
                            <td class="product-name">{{ $checkout->product->name }}</td>
                            <td class="product-price">
                                <p class="rupiah" data-price="{{ $checkout->product->price }}"></p>
                            </td>
                            <td class="product-quantity">{{ $checkout->qty }}</td>
                            <input type="hidden" name="qty" value="{{ $checkout->qty }}">
                            <td class="product-total">
                                <p class="rupiah" data-price="{{ $total }}"></p>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Shipping and Total Section -->
                <div class="checkout-summary">
                    <div class="shipping-section">
                        <div class="shipping-header">
                            <h5 class="shipping-title"><i class='bx bx-map'></i> Delivery Address</h5>
                            <a href="{{ route('address') }}" class="btn btn-outline-secondary btn-sm">Add a new
                                address</a>
                        </div>
                        <div class="address-list">
                            <div class="row">
                                @forelse ($addresses as $address)
                                <div class="col-lg-6 col-12 mb-4 address-card">
                                    <div class="card card-body p-3">
                                        <div class="form-check mb-4">
                                            <input class="form-check-input delivery-address" value="{{ $address->id }}" type="radio" name="address_id" class="homeRadio">
                                            <label class="form-check-label" for="homeRadio">{{ $address->label }}</label>
                                        </div>
                                        <address>
                                            <strong>{{ $address->fullname }}</strong><br>
                                            {{ $address->address }}<br>
                                            {{ $address->regency_name }}<br>
                                            {{ $address->province_name }}<br>
                                            {{ $address->postcode }}<br>
                                            <abbr title="Phone">P: {{ $address->phone }}</abbr>
                                        </address>
                                        <span class="text-danger">Default address</span>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <p>No address found</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        <h5 class="shipping-title"><i class='bx bxs-truck'></i> Delivery Service</h5>
                        <div class="courier-options d-flex justify-content-start">
                            @if($is_local_courier_only == false)
                            <div class="shipping-option d-flex align-items-center mr-4">
                                <input class="courier-code" type="radio" name="courier" id="inlineRadio1" value="jne">
                                <label class="courier-label ml-2" for="inlineRadio1">JNE</label>
                            </div>
                            {{-- <div class="shipping-option d-flex align-items-center mr-4">
                                <input class="courier-code" type="radio" name="courier" id="inlineRadio2" value="pos">
                                <label class="courier-label ml-2" for="inlineRadio2">POS</label>
                            </div>
                            <div class="shipping-option d-flex align-items-center">
                                <input class="courier-code" type="radio" name="courier" id="inlineRadio3" value="tiki">
                                <label class="courier-label ml-2" for="inlineRadio3">TIKI</label>
                            </div> --}}
                            @endif

                            <div class="shipping-option d-flex align-items-center">
                                <input class="courier-code" type="radio" name="courier" id="inlineRadio4" value="lokal_kurir">
                                <label class="courier-label ml-2" for="inlineRadio4">Lokal Kurir</label>
                            </div>


                            <!-- <div class="">
                                <a href="{{ route('delivery') }}" id="btn-lokal-kurir">Lokal Kurir</a>
                            </div> -->

                        </div>
                        <div class="available-services-container">
                            <p>Available services:</p>
                            @if($is_local_courier_only)
                                <p>Produk ini hanya menerima pengiriman Lokal Kurir</p>
                            @else
                                <ul class="available-services" style="display: none;"></ul>
                            @endif

                        </div>
                        <div class="shipping-cost">
                            <h3>Shipping fee</h3>
                            <p class="rupiah" data-price="0"></p>
                        </div>

                        <div class="total-section">
                            @php
                            $totalPrice = 0;
                            @endphp
                            @foreach ($checkouts as $checkout)
                            @php $totalPrice += $checkout->product->price * $checkout->qty @endphp
                            @endforeach
                            <div class="total-summary">
                                <div class="total-label">
                                    <h3>TOTAL</h3>
                                </div>
                                <div class="total-amount">
                                    <p class="rupiah" data-price="{{ $totalPrice }}">Rp
                                        {{ number_format($totalPrice) }}
                                    </p>
                                    <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- <div class="payment-options">
                        <h3>Payment Option</h3>
                        <div class="payment-option">
                            <input type="checkbox" class="checkbox" id="payment-option" name="Transfer"
                                value="Transfer">
                            <label class="label" for="Transfer-1">Direct Bank Transfer</label>
                        </div>
                        <div class="payment-option">
                            <input type="checkbox" class="checkbox" id="payment-option" name="cod" value="cod">
                            <label class="label" for="Delivery-1">Cash On Delivery</label>
                        </div>
                    </div> -->
                <div class="place-order">
                    <button type="submit" class="btn-submit" id="">Checkout</button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="modal" id="modal-showmap">
    <div class="modal-container">
        <a href="#" class="close-icon" data-dismiss="modal"><i data-feather="x"></i></a>
        <div class="modal-content" id="modal-content">
            <div id="map" style="height: 500px; width: 100%;"></div>
        </div>
    </div>
</div>
<!-- Checkout Page End -->
@endsection
@push('myscript')
<script>
    $("#frmCheckout").submit(function(event) {
        // var address = $(".homeRadio").is(":checked");
        var address = $("input[name='address_id']:checked").val();
        var courier = $(".courier-code").is(":checked");

        if (!address) {
            alert('Please select a delivery address.');
            event.preventDefault();
            return false;
        }

        if (!courier) {
            alert('Please select a delivery option.');
            event.preventDefault();
            return false;
        }
    });



    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('.delivery-address').change(function() {
                $('.courier-code').prop('checked', false);
                $('.available-services').hide();
                $('.available-services').html('');
            });

            $('.courier-code').click(function() {
                let courier = $(this).val();
                let weight = $('#weight').val();
                let addressID = $('.delivery-address:checked').val();

                let totalPriceInput = $("input[name='total_price']").val();

                if (addressID) {
                    $.ajax({
                        url: "{{ route('shippingfee') }}",
                        method: "POST",
                        data: {
                            address_id: addressID,
                            courier: courier,
                            weight: weight,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(result) {
                            // console.log(lokal_kurir);
                            if(courier == 'lokal_kurir'){
                                // total_price =
                                let lokal_kurir_price = result.total;

                                $('.available-services').show();
                                $('.available-services').html(`
                                    <table>
                                        <tr>
                                            <th>Ongkos Kirim Lokal Kurir</th>
                                            <td>${rupiah(result.tarif_lokal_kurir_per_km)}/Km</td>
                                        </tr>
                                        <tr>
                                            <th>Jarak Kirim</th>
                                            <td>${result.distance_in_km}Km</td>
                                        </tr>
                                        <tr>
                                            <th>Total Ongkos Kirim</th>
                                            <td>${rupiah(lokal_kurir_price)}</td>
                                        </tr>
                                    </table>
                                `);

                                var originalTotalPrice = parseFloat($(".total-amount .rupiah").attr('data-price')) || 0;

                                var currentShippingCost = parseFloat($(".shipping-cost .rupiah").attr('data-price')) || 0;

                                var newTotalPrice = originalTotalPrice - currentShippingCost + lokal_kurir_price;

                                $(".shipping-cost .rupiah").attr('data-price', lokal_kurir_price).text(rupiah(lokal_kurir_price));

                                $(".total-amount .rupiah").attr('data-price', newTotalPrice).text(rupiah(
                                newTotalPrice));

                                $("input[name='total_price']").val(newTotalPrice);
                            }else{
                                $('.available-services').show();
                                $('.available-services').html(result);
                            }
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    });
                } else {
                    alert('Please select a delivery address first.');
                }


                if(courier == 'lokal_kurir') {
                    $('.available-services').hide();
                    $('.available-services').html('');
                }else{
                    // console.log(courier);
                }

            });
        });

    });
</script>
@endpush

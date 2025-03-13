@extends('layouts.home')

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5" style="background-color: var(--primary);" data-aos="fade-down">
        <div class="container">
            <h1 class="page-title mb-3">Checkout</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/cart">Cart</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <!-- Checkout Page Start -->
    <div class="modern-checkout">
        <div class="container">
            <form method="post" id="frmCheckout" action="{{ route('checkout.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <!-- Order Summary -->
                        <div class="checkout-card mb-4">
                            <div class="card-body">
                                <h5 class="card-title d-flex align-items-center mb-4">
                                    <i class="fas fa-shopping-bag me-2"></i>
                                    Order Summary
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                                $weight = 0;
                                                $only_instant_shipping = false;
                                            @endphp
                                            @foreach ($checkouts as $checkout)
                                                @php
                                                    $weight = $checkout->product->weight * $checkout->qty;
                                                    $total = $checkout->product->price * $checkout->qty;
                                                    $opsiPengiriman = json_decode($checkout->product->opsi_pengiriman, true);
                                                    if (count($opsiPengiriman) === 1 && in_array('Instant', $opsiPengiriman)) {
                                                        $only_instant_shipping = true;
                                                    }
                                                @endphp
                                                <tr>
                                                    <input type="hidden" id="weight" name="weight" value="{{ $weight }}">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="product-image me-3">
                                                                <img src="{{ Storage::url($checkout->product->photos) }}"
                                                                    alt="{{ $checkout->product->name }}">
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-1">{{ $checkout->product->name }}</h6>
                                                                <small class="text-muted">Weight: {{ $checkout->product->weight }}g</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="rupiah" data-price="{{ $checkout->product->price }}"></span>
                                                    </td>
                                                    <td>{{ $checkout->qty }}</td>
                                                    <input type="hidden" name="qty" value="{{ $checkout->qty }}">
                                                    <td>
                                                        <span class="rupiah" data-price="{{ $total }}"></span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Address -->
                        <div class="checkout-card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-map-marker-alt me-2"></i> Delivery Address
                                    </h5>
                                    <a href="{{ route('address') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-plus me-1"></i> Add New Address
                                    </a>
                                </div>

                                <div class="row g-3">
                                    @forelse ($addresses as $address)
                                        <div class="col-md-6">
                                            <div class="address-card {{ $address->is_default ? 'selected' : '' }}">
                                                <div class="p-3">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input delivery-address"
                                                            type="radio"
                                                            name="address_id"
                                                            value="{{ $address->id }}"
                                                            {{ $address->is_default ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-bold">
                                                            {{ $address->label }}
                                                            @if($address->is_default)
                                                                <span class="badge bg-primary ms-2">Default</span>
                                                            @endif
                                                        </label>
                                                    </div>
                                                    <address class="mb-0">
                                                        <strong>{{ $address->fullname }}</strong><br>
                                                        {{ $address->address }}<br>
                                                        {{ $address->regency_name }}, {{ $address->province_name }}<br>
                                                        {{ $address->postcode }}<br>
                                                        <i class="fas fa-phone me-1"></i> {{ $address->phone }}
                                                    </address>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-warning mb-0">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                No address found. Please add a delivery address.
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Service -->
                        <div class="checkout-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">
                                    <i class="fas fa-truck me-2"></i> Delivery Service
                                </h5>

                                <div class="delivery-options mb-4">
                                    @if(!$only_instant_shipping)
                                        <div class="delivery-option">
                                            <div class="form-check">
                                                <input class="form-check-input courier-code" type="radio" name="courier" id="jne" value="jne">
                                                <label class="form-check-label d-flex align-items-center" for="jne">
                                                    <img src="{{ asset('assets/img/jne.png') }}" alt="JNE" height="30" class="me-3">
                                                    <span>JNE Express</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="delivery-option">
                                        <div class="form-check">
                                            <input class="form-check-input courier-code" type="radio" name="courier" id="lokal_kurir" value="lokal_kurir">
                                            <label class="form-check-label d-flex align-items-center" for="lokal_kurir">
                                                <i class="fas fa-motorcycle me-3 fa-lg"></i>
                                                <span>Local Courier</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="delivery-option">
                                        <div class="form-check">
                                            <input class="form-check-input courier-code" type="radio" name="courier" id="ambil_ditempat" value="ambil_ditempat">
                                            <label class="form-check-label d-flex align-items-center" for="ambil_ditempat">
                                                <i class="fas fa-store me-3 fa-lg"></i>
                                                <span>Pick Up at Store</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="available-services-container">
                                    @if($only_instant_shipping)
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            This product is only available for Local Courier or Pick Up delivery.
                                        </div>
                                    @else
                                        <div class="available-services" style="display: none;"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Sidebar -->
                    <div class="col-lg-4">
                        <div class="order-summary">
                            <h5 class="mb-4">Order Total</h5>

                            @php
                                $totalPrice = 0;
                                foreach ($checkouts as $checkout) {
                                    $totalPrice += $checkout->product->price * $checkout->qty;
                                }
                            @endphp

                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span class="rupiah" data-price="{{ $totalPrice }}"></span>
                            </div>

                            <div class="summary-item">
                                <span>Shipping Fee</span>
                                <span class="rupiah shipping-cost" data-price="0">-</span>
                            </div>

                            <div class="summary-item">
                                <strong>Total</strong>
                                <strong class="rupiah total-amount" data-price="{{ $totalPrice }}"></strong>
                            </div>

                            <input type="hidden" name="total_price" value="{{ $totalPrice }}">

                            <button type="submit" class="btn-checkout mt-4">
                                <i class="fas fa-lock me-2"></i> Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Checkout Page End -->
@endsection

@push('myscript')
<script>
$(document).ready(function() {
    // Format rupiah
    function formatRupiah(price) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price);
    }

    $('.rupiah').each(function() {
        var price = $(this).data('price');
        $(this).text(formatRupiah(price));
    });

    // Form validation
    $("#frmCheckout").submit(function(event) {
        var address = $("input[name='address_id']:checked").val();
        var courier = $("input[name='courier']:checked").val();

        if (!address) {
            Swal.fire({
                icon: 'warning',
                title: 'Address Required',
                text: 'Please select a delivery address to continue.',
            });
            event.preventDefault();
            return false;
        }

        if (!courier) {
            Swal.fire({
                icon: 'warning',
                title: 'Delivery Service Required',
                text: 'Please select a delivery service to continue.',
            });
            event.preventDefault();
            return false;
        }
    });

    // Delivery address selection
    $('.delivery-address').change(function() {
        $('.courier-code').prop('checked', false);
        $('.available-services').hide().html('');
        updateTotalAmount(0);

        // Update selected state
        $('.address-card').removeClass('selected');
        $(this).closest('.address-card').addClass('selected');
    });

    // Courier selection
    $('.courier-code').click(function() {
        let courier = $(this).val();
        let weight = $('#weight').val();
        let addressID = $('.delivery-address:checked').val();

        // Update selected state
        $('.delivery-option').removeClass('selected');
        $(this).closest('.delivery-option').addClass('selected');

        if (!addressID) {
            Swal.fire({
                icon: 'warning',
                title: 'Address Required',
                text: 'Please select a delivery address first.',
            });
            $(this).prop('checked', false);
            return;
        }

        if (courier === 'lokal_kurir' || courier === 'ambil_ditempat') {
            handleLocalDelivery(courier);
        } else {
            getShippingCost(addressID, courier, weight);
        }
    });

    // Handle local delivery options
    function handleLocalDelivery(type) {
        $('.available-services').hide().html('');

        if (type === 'lokal_kurir') {
            $.ajax({
                url: "{{ route('shippingfee') }}",
                method: "POST",
                data: {
                    address_id: $('.delivery-address:checked').val(),
                    courier: type,
                    weight: $('#weight').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    updateLocalDeliveryUI(result);
                },
                error: handleAjaxError
            });
        } else {
            // Pick up option
            updateTotalAmount(0);
            $('.available-services').show().html(`
                <div class="alert alert-success mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    No delivery fee for pick up orders
                </div>
            `);
        }
    }

    // Get shipping cost for regular couriers
    function getShippingCost(addressID, courier, weight) {
        $.ajax({
            url: "{{ route('shippingfee') }}",
            method: "POST",
            data: {
                address_id: addressID,
                courier: courier,
                weight: weight,
                _token: '{{ csrf_token() }}'
            },
            success: function(result) {
                $('.available-services').show().html(result);
            },
            error: handleAjaxError
        });
    }

    // Update UI for local delivery
    function updateLocalDeliveryUI(result) {
        let localPrice = result.total;
        updateTotalAmount(localPrice);

        $('.available-services').show().html(`
            <div class="shipping-info">
                <table class="table-sm mb-0">
                    <tr>
                        <th>Local Delivery Fee</th>
                        <td class="text-end">${formatRupiah(result.tarif_lokal_kurir_per_km)}/Km</td>
                    </tr>
                    <tr>
                        <th>Distance</th>
                        <td class="text-end">${result.distance_in_km} Km</td>
                    </tr>
                    <tr class="border-top">
                        <th>Total Delivery Fee</th>
                        <td class="text-end">${formatRupiah(localPrice)}</td>
                    </tr>
                </table>
            </div>
        `);
    }

    // Update total amount
    function updateTotalAmount(shippingCost) {
        let subtotal = parseFloat($(".total-amount").attr('data-price')) || 0;
        let currentShipping = parseFloat($(".shipping-cost").attr('data-price')) || 0;
        let newTotal = subtotal - currentShipping + shippingCost;

        $(".shipping-cost").attr('data-price', shippingCost).text(formatRupiah(shippingCost));
        $(".total-amount").attr('data-price', newTotal).text(formatRupiah(newTotal));
        $("input[name='total_price']").val(newTotal);
    }

    // Handle AJAX errors
    function handleAjaxError() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Please try again.'
        });
    }
});
</script>
@endpush

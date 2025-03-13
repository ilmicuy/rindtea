@extends('layouts.home')

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5" style="background-color: var(--primary);" data-aos="fade-down">
        <div class="container">
            <h1 class="page-title mb-3">Product Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/shop">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <!-- Product Detail Start -->
    <div class="modern-checkout py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Product Image -->
                <div class="col-lg-5">
                    <div class="checkout-card h-100">
                        <div class="card-body p-0">
                            <div class="product-image-wrapper position-relative">
                                <div class="main-image">
                                    <img src="{{ Storage::url($product->photos) }}" class="img-fluid w-100" alt="{{ $product->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-7">
                    <div class="checkout-card h-100">
                        <div class="card-body">
                            <h2 class="product-title mb-3">{{ $product->name }}</h2>

                            <div class="d-flex align-items-center mb-4">
                                <div class="product-rating me-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                    <span class="ms-2">(4.5)</span>
                                </div>
                                <div class="product-stock ms-4">
                                    <i class="fas fa-box me-2"></i>
                                    <span>Stock: {{ $product->quantity }} items</span>
                                </div>
                            </div>

                            <div class="product-price mb-4">
                                <span class="rupiah h3" data-price="{{ $product->price }}"></span>
                            </div>

                            <div class="product-description mb-4">
                                <p class="lead text-white">{!! $product->thumb_description !!}</p>
                            </div>

                            <form id="add-to-cart-form" action="{{ route('add-to-cart', $product->id) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="quantity-wrapper d-flex align-items-center mb-4">
                                    <label class="me-3 fw-bold">Quantity:</label>
                                    <div class="input-group" style="width: 200px;">
                                        <button type="button" class="btn btn-outline-primary btn-minus">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="qty" class="form-control text-center" value="1" min="1" max="{{ $product->quantity }}">
                                        <button type="button" class="btn btn-outline-primary btn-plus">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex gap-3">
                                    @auth
                                        <button type="submit" class="btn btn-lg px-5" style="background-color: var(--primary); color: var(--bg);">
                                            <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-lg">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-lg" style="background-color: var(--primary); color: var(--bg);">
                                            <i class="fas fa-sign-in-alt me-2"></i> Login to Purchase
                                        </a>
                                    @endauth
                                </div>
                            </form>

                            <!-- Product Details -->
                            <div class="product-details mt-5">
                                <div class="checkout-card">
                                    <div class="card-body">
                                        <h5 class="mb-4">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Product Information
                                        </h5>
                                        <div class="row g-4">
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-shipping-fast me-2"></i>
                                                    <strong>Shipping Options:</strong>
                                                    <p class="mb-0 mt-2">{{ implode(' / ', json_decode($product->opsi_pengiriman, true)) }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-weight-hanging me-2"></i>
                                                    <strong>Weight:</strong>
                                                    <p class="mb-0 mt-2">{{ $product->weight }}g</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-globe-asia me-2"></i>
                                                    <strong>Origin:</strong>
                                                    <p class="mb-0 mt-2">{{ $product->country_of_origin }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="info-item">
                                                    <i class="fas fa-certificate me-2"></i>
                                                    <strong>Quality:</strong>
                                                    <p class="mb-0 mt-2">{{ $product->quality }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Detail End -->
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
    $('.btn-minus').click(function() {
        var input = $(this).closest('.input-group').find('input');
        var value = parseInt(input.val());
        if (value > 1) {
            input.val(value - 1);
        }
    });

    $('.btn-plus').click(function() {
        var input = $(this).closest('.input-group').find('input');
        var value = parseInt(input.val());
        var max = {{ $product->quantity }};
        if (value < max) {
            input.val(value + 1);
        }
    });

    // Prevent manual input beyond limits
    $('input[name="qty"]').on('change', function() {
        var value = parseInt($(this).val());
        var max = {{ $product->quantity }};
        if (value < 1) $(this).val(1);
        if (value > max) $(this).val(max);
    });

    // Image zoom effect
    $('.main-image').on('mousemove', function(e) {
        const x = e.clientX - $(this).offset().left;
        const y = e.clientY - $(this).offset().top;

        $(this).find('img').css({
            'transform-origin': `${x}px ${y}px`,
            'transform': 'scale(1.2)'
        });
    }).on('mouseleave', function() {
        $(this).find('img').css({
            'transform': 'scale(1)'
        });
    });

    // Add to cart animation
    $('#add-to-cart-form').on('submit', function(e) {
        e.preventDefault();
        const form = this;

        $(form).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin me-2"></i> Adding...');

        setTimeout(function() {
            form.submit();
        }, 500);
    });
});
</script>
@endpush

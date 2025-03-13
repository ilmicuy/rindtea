@extends('layouts.home')

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5 mb-4" data-aos="fade-down">
        <div class="container">
            <h1 class="page-title">Our Products</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <!-- Shop Start -->
    <div class="modern-checkout py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Product Grid -->
                <div class="col-12">
                    <div class="row g-4">
                        @foreach ($products as $item)
                            <div class="col-md-6 col-lg-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="{{ Storage::url($item->photos) }}" alt="{{ $item->name }}">
                                        <div class="product-icons">
                                            <a href="/shop-detail/{{ $item->id }}" class="view-details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3>{{ $item->name }}</h3>
                                        <div class="product-stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <div class="product-price">
                                            <span class="rupiah" data-price="{{ $item->price }}"></span>
                                        </div>
                                        <p class="product-description">
                                            {!! $item->thumb_description !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop End -->
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
});
</script>
@endpush

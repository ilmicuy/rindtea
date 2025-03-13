@extends('layouts.home')

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5 mb-1" data-aos="fade-down">
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
                <!-- Variant Filter -->
                <div class="col-12 mb-4">
                    <div class="variant-filter">
                        <div class="d-flex flex-wrap gap-2 variant-buttons">
                            <button class="btn btn-outline-primary active" data-variant="all">All Products</button>
                            @php
                                $uniqueVariants = $products->pluck('variant_grouping')->filter()->unique();
                            @endphp
                            @foreach($uniqueVariants as $variant)
                                <button class="btn btn-outline-primary" data-variant="{{ $variant }}">{{ $variant }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="col-12">
                    <div class="row g-4">
                        @php
                            $groupedProducts = $products->groupBy('variant_grouping');
                        @endphp

                        @foreach ($groupedProducts as $groupName => $items)
                            @if($groupName)
                                <div class="col-12">
                                    <h2 class="variant-group-title mb-4">{{ $groupName }}</h2>
                                </div>
                            @endif

                            @foreach ($items as $item)
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
                                            @if($item->variant_grouping)
                                                <div class="variant-label mb-2">
                                                    <span class="badge bg-info">{{ str_replace($item->variant_grouping . ' ', '', $item->name) }}</span>
                                                </div>
                                            @endif
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

    // Variant filtering
    $('.variant-buttons .btn').click(function() {
        // Update active state
        $('.variant-buttons .btn').removeClass('active');
        $(this).addClass('active');

        const selectedVariant = $(this).data('variant');

        if (selectedVariant === 'all') {
            // Show all products and variant groups
            $('.variant-group-title').parent().show();
            $('.product-card').parent().show();
        } else {
            // Hide all products and variant groups first
            $('.variant-group-title').parent().hide();
            $('.product-card').parent().hide();

            // Show only the selected variant group and its products
            $('.variant-group-title').each(function() {
                if ($(this).text().trim() === selectedVariant) {
                    $(this).parent().show();
                    $(this).parent().nextUntil('.col-12').show();
                }
            });
        }
    });
});
</script>
@endpush

<style>
.variant-filter {
    background: rgba(255, 255, 255, 0.05);
    padding: 20px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.variant-filter h4 {
    color: #FFF;
    margin-bottom: 15px;
}

.variant-buttons .btn {
    border-radius: 20px;
    padding: 8px 20px;
    transition: all 0.3s ease;
}

.variant-buttons .btn.active {
    background-color: var(--primary);
    color: var(--bg);
    border-color: var(--primary);
}

.variant-buttons .btn:hover {
    background-color: var(--primary);
    color: var(--bg);
    border-color: var(--primary);
}

.variant-group-title {
    color: #FFF;
    font-size: 1.5rem;
    padding-bottom: 0.5rem;
    margin: 20px 0;
    border-bottom: 2px solid #eee;
}

.variant-label {
    font-size: 0.9rem;
}

.variant-label .badge {
    font-weight: normal;
}
</style>

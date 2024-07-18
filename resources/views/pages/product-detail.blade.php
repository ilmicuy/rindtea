<img src="{{ Storage::url($product->photos) }}" alt="{{ $product->name }}" />
<div id="product-content" class="product-content">
    <h3>{{ $product->name }}</h3>
    <p>
        {{ $product->thumb_description }}
    </p>
    <div class="product-stars">
        <i data-feather="star" class="star"></i>
        <i data-feather="star" class="star"></i>
        <i data-feather="star" class="star"></i>
        <i data-feather="star" class="star"></i>
        <i data-feather="star" class="star"></i>
    </div>
    <div class="product-price">
        <span><strong>Rp {{ number_format($product->price) }}</strong></span>
    </div>
    <a href="{{ route('shop') }}"><i data-feather="shopping-cart"></i> <span>view to shop</span></a>
</div>

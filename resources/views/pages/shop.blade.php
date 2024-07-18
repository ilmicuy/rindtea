@extends('layouts.home')

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header">
        <h1 class="page-title">Shop </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active">Shop </li>
        </ol>
    </div>
    <!-- Single Page Header End -->
    <!-- Shop Start -->
    <div class="shop-container">
        <div class="shop-content">
            <div class="product-list">
                @foreach ($products as $item)
                    <div class="product-item">
                        <a href="{{ route('shop-detail', $item->id) }}" class="product-link rounded position-relative">
                            <div class="product-img">
                                <img src="{{ Storage::url($item->photos) }}" class="img-fluid w-100 rounded-top"
                                    alt="">
                            </div>
                            <div class="product-overlay"></div>
                            <div class="product-info">
                                <h4 class="product-name">{{ $item->name }}</h4>
                                <strong>
                                    <h4 class="product-price"><span class="rupiah" data-price="{{ $item->price }}"></span>
                                    </h4>
                                </strong>
                                <p class="product-description">{!! $item->thumb_description !!}</p>
                                <div class="product-button">
                                    <button type="submit" class="btn-detail">Detail</button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                <div class="pagination-container">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Shop End -->
@endsection

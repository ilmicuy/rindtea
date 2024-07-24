@extends('layouts.home')

@section('content')
    <div class="single-page-header">
        <h1 class="page-title">Shop Detail</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active">Shop Detail</li>
        </ol>
    </div>

    <!-- Single Product Start -->
    <div class="single-product">
        <div class="container">
            <div class="product-wrapper">
                <div class="product-image-container">
                    <div class="product-gallery">
                        <div class="product-image">
                            <a href="#">
                                <img src="{{ Storage::url($product->photos) }}" class="img-fluid" alt="Image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="product-details-container">
                    <div class="product-details">
                        <h4 class="product-name">{{ $product->name }}</h4>
                        <h5 class="rupiah" data-price="{{ $product->price }}"></h5>
                        <div class="product-rating">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <p class="product-description">{!! $product->thumb_description !!}</p>
                        <p class="product-quantity">Qty: {{ $product->quantity }}</p>
                        <form id="add-to-cart-form" action="{{ route('add-to-cart', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            <div class="mb-5 input-group quantity">
                                <div class="input-group-btn">
                                    <button id="btn-minus" class="border btn btn-sm btn-minus rounded-circle bg-light"
                                        type="button">
                                        <i data-feather="minus"></i>
                                    </button>
                                </div>
                                <input id="qty-input" type="number" name="qty" class="form-control text-center"
                                    value="1" min="1" max="{{ $product->quantity }}">
                                <div class="input-group-btn">
                                    <button id="btn-plus" class="border btn btn-sm btn-plus rounded-circle bg-light"
                                        type="button">
                                        <i data-feather="plus"></i>
                                    </button>
                                </div>
                            </div>
                            @auth
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-shopping-bag me-2 text-white"></i> Add to cart
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                            @endauth
                        </form>
                    </div>
                </div>
                <div class="product-tabs">
                    <nav>
                        <div class="mb-3 nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-about-tab" data-bs-target="#nav-about" type="button"
                                role="tab" aria-controls="nav-about" aria-selected="true">Description</button>
                            <button class="nav-link" id="nav-missions-tab" data-bs-target="#nav-missions" type="button"
                                role="tab" aria-controls="nav-missions" aria-selected="false">Reviews</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-about" role="tabpanel"
                            aria-labelledby="nav-description-tab">
                            <p>{!! $product->thumb_description !!}</p>
                            <div class="product-info">
                                <div class="info-item">
                                    <p class="info-label">Min Weight</p>
                                    <p class="info-value">{{ $product->weight }}</p>
                                </div>
                                <div class="info-item">
                                    <p class="info-label">Country of Origin</p>
                                    <p class="info-value">{{ $product->country_of_origin }}</p>
                                </div>
                                <div class="info-item">
                                    <p class="info-label">Quality</p>
                                    <p class="info-value">{{ $product->quality }}</p>
                                </div>
                                <div class="info-item">
                                    <p class="info-label">Сheck</p>
                                    <p class="info-value">{{ $product->check }}</p>
                                </div>
                                <div class="info-item">
                                    <p class="info-label">Name</p>
                                    <p class="info-value">{{ $product->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="nav-missions" role="tabpanel" aria-labelledby="nav-missions-tab">
                            @foreach ($review as $item)
                                <div class="d-flex">
                                    <img src="{{ asset('img/avatar.jpg') }}" class="p-3 img-fluid rounded-circle"
                                        style="width: 100px; height: 100px;" alt="">
                                    <div class="flex justify-between">
                                        <div class="flex flex-col">
                                            <p class="mb-2 text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</p>
                                            <h5 class="text-lg font-semibold">{{ $item->user->name }}</h5>
                                            <div class="flex items-center">
                                                <div class="mb-3 flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $item->rating)
                                                            <i class="fa fa-star text-secondary"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <p>{{ $item->description_review }}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Single Product End -->
@endsection


@push('myscript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.nav-tabs button');
            const tabContents = document.querySelectorAll('.tab-pane');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    // Hide all tab contents
                    tabContents.forEach(content => content.classList.remove('show', 'active'));

                    // Add active class to the clicked tab
                    this.classList.add('active');
                    // Show the corresponding tab content
                    const target = document.querySelector(this.getAttribute('data-bs-target'));
                    target.classList.add('show', 'active');
                });
            });
        });

        $('.quantity button').on('click', function() {
            var button = $(this);
            var oldValue = button.parent().parent().find('input').val();
            if (button.hasClass('btn-plus')) {
                var newVal = parseFloat(oldValue) + 1;
            } else {
                if (oldValue > 0) {
                    var newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = 0;
                }
            }

            if(newVal > {{ $product->quantity }}){
                return false;
            }

            button.parent().parent().find('input').val(newVal);
        });
    </script>
@endpush

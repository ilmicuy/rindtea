@extends('layouts.home')

@section('title')
    Shop Detail | Pointsebelas
@endsection

@section('content')
    <!-- Single Page Header start -->
    <div class="py-5 container-fluid page-header">
        <h1 class="text-center text-white display-6">Shop Detail</h1>
        <ol class="mb-0 breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="text-white breadcrumb-item active">Shop Detail</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Single Product Start -->
    <div class="py-5 mt-5 container-fluid">
        <div class="container py-5">
            <div class="mb-5 row g-4">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="{{ Storage::url($product->photos) }}" class="rounded img-fluid" alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="mb-3 fw-bold">{{ $product->name }}</h4>
                            <p class="mb-3">Category: {{ $product->category->name }}</p>
                            <h5 class="mb-3 fw-bold">Rp.{{ number_format($product->price) }}</h5>
                            <div class="mb-4 d-flex">
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p class="mb-4">{{ $product->short_description }}</p>
                            <p class="mb-3">Qty: {{ $product->quantity }}</p>
                            <form id="add-to-cart-form" action="{{ route('add-to-cart', $product->id) }}" method="POST" enctype="multipart/form-data">
                                <div class="mb-5 input-group quantity" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button id="btn-minus" class="border btn btn-sm btn-minus rounded-circle bg-light" type="button">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input id="qty-input" type="text" name="qty" class="text-center border-0 form-control form-control-sm" value="1">
                                    <div class="input-group-btn">
                                        <button id="btn-plus" class="border btn btn-sm btn-plus rounded-circle bg-light" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                @auth
                                    @csrf
                                    <button type="submit" class="x-4 py-2 mb-4 border btn border-secondary rounded-pill text-primary">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="x-4 py-2 mb-4 border btn border-secondary rounded-pill text-primary">
                                        Login 
                                    </a>
                                @endauth
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="mb-3 nav nav-tabs">
                                    <button class="border-white nav-link active border-bottom-0" type="button"
                                        role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">Description</button>
                                    <button class="border-white nav-link border-bottom-0" type="button" role="tab"
                                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                        aria-controls="nav-mission" aria-selected="false">Reviews</button>
                                </div>
                            </nav>
                            <div class="mb-5 tab-content">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <p>{{$product->long_description}}</p>
                                    <div class="px-2">
                                        <div class="row g-4">
                                            <div class="col-6">
                                                <div
                                                    class="py-2 text-center row bg-light align-items-center justify-content-center">
                                                    <div class="col-6">
                                                        <p class="mb-0">Weight</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">{{$product->weight}} kg</p>
                                                    </div>
                                                </div>
                                                <div class="py-2 text-center row align-items-center justify-content-center">
                                                    <div class="col-6">
                                                        <p class="mb-0">Country of Origin</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">{{$product->country_of_origin}}</p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="py-2 text-center row bg-light align-items-center justify-content-center">
                                                    <div class="col-6">
                                                        <p class="mb-0">Quality</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">{{$product->quality}}</p>
                                                    </div>
                                                </div>
                                                <div class="py-2 text-center row align-items-center justify-content-center">
                                                    <div class="col-6">
                                                        <p class="mb-0">Сheck</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">{{$product->check}}</p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="py-2 text-center row bg-light align-items-center justify-content-center">
                                                    <div class="col-6">
                                                        <p class="mb-0">Name</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">{{$product->name}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                    <div class="d-flex">
                                        <img src="{{asset('img/avatar.jpg')}}" class="p-3 img-fluid rounded-circle"
                                            style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Jason Smith</h5>
                                                <div class="mb-3 d-flex">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p>The generated Lorem Ipsum is therefore always free from repetition injected
                                                humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <img src="{{asset('img/avatar.jpg')}}" class="p-3 img-fluid rounded-circle"
                                            style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Sam Peters</h5>
                                                <div class="mb-3 d-flex">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark">The generated Lorem Ipsum is therefore always free from
                                                repetition injected humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-vision" role="tabpanel">
                                    <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor
                                        sit. Aliqu diam
                                        amet diam et eos labore. 3</p>
                                    <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos
                                        labore.
                                        Clita erat ipsum et lorem et sit</p>
                                </div>
                            </div>
                        </div>
                        <form action="#">
                            <h4 class="mb-5 fw-bold">Leave a Reply</h4>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="rounded border-bottom">
                                        <input type="text" class="border-0 form-control me-4"
                                            placeholder="Yur Name *">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="rounded border-bottom">
                                        <input type="email" class="border-0 form-control" placeholder="Your Email *">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="my-4 rounded border-bottom">
                                        <textarea name="" id="" class="border-0 form-control" cols="30" rows="8"
                                            placeholder="Your Review *" spellcheck="false"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="py-3 mb-5 d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 me-3">Please rate:</p>
                                            <div class="d-flex align-items-center" style="font-size: 12px;">
                                                <i class="fa fa-star text-muted"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <a href="#"
                                            class="px-4 py-3 border btn border-secondary text-primary rounded-pill"> Post
                                            Comment</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <div class="col-lg-12">
                            <div class="mx-auto mb-4 input-group w-100 d-flex">
                                <input type="search" class="p-3 form-control" placeholder="keywords"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="p-3 input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <div class="mb-4">
                                <h4>Categories</h4>
                                <ul class="list-unstyled fruite-categorie">
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Apples</a>
                                            <span>(3)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Oranges</a>
                                            <span>(5)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Strawbery</a>
                                            <span>(2)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Banana</a>
                                            <span>(8)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Pumpkin</a>
                                            <span>(5)</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h4 class="mb-4">Featured products</h4>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded" style="width: 100px; height: 100px;">
                                    <img src="{{asset('img/featur-1.jpg')}}" class="rounded img-fluid" alt="Image">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="mb-2 d-flex">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="mb-2 d-flex">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded" style="width: 100px; height: 100px;">
                                    <img src="{{asset('img/featur-2.jpg')}}" class="rounded img-fluid" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="mb-2 d-flex">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="mb-2 d-flex">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded" style="width: 100px; height: 100px;">
                                    <img src="{{asset('img/featur-3.jpg')}}" class="rounded img-fluid" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="mb-2 d-flex">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="mb-2 d-flex">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded me-4" style="width: 100px; height: 100px;">
                                    <img src="{{asset('img/vegetable-item-4.jpg')}}" class="rounded img-fluid" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="mb-2 d-flex">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="mb-2 d-flex">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded me-4" style="width: 100px; height: 100px;">
                                    <img src="{{asset('img/vegetable-item-5.jpg')}}" class="rounded img-fluid" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="mb-2 d-flex">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="mb-2 d-flex">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded me-4" style="width: 100px; height: 100px;">
                                    <img src="{{asset('img/vegetable-item-6.jpg')}}" class="rounded img-fluid" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="mb-2 d-flex">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="mb-2 d-flex">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="my-4 d-flex justify-content-center">
                                <a href="{{route('shop')}}"
                                    class="px-4 py-3 border btn border-secondary rounded-pill text-primary w-100">View
                                    More</a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="position-relative">
                                <img src="{{asset('img/banner-fruits.jpg')}}" class="rounded img-fluid w-100" alt="">
                                <div class="position-absolute"
                                    style="top: 50%; right: 10px; transform: translateY(-50%);">
                                    <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->
@endsection

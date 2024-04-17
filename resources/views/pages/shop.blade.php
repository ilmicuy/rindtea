@extends('layouts.home')

@section('title')
    Shop | Point Sebelas
@endsection

@section('content')
    <!-- Single Page Header start -->
    <div class="py-5 container-fluid page-header">
        <h1 class="text-center text-white display-6">Shop</h1>
        <ol class="mb-0 breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="text-white breadcrumb-item active">Shop</li>
        </ol>
    </div>
    <!-- Single Page Header End -->
    <!-- Fruits Shop Start-->
    <div class="py-5 container-fluid fruite">
        <div class="container py-5">
            <h1 class="mb-4">Fresh fruits shop</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <div class="mx-auto input-group w-100 d-flex">
                                <input type="search" class="p-3 form-control" placeholder="keywords"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="p-3 input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-xl-3">
                            <div class="py-3 mb-4 rounded bg-light ps-3 d-flex justify-content-between">
                                <label for="fruits">Default Sorting:</label>
                                <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3"
                                    form="fruitform">
                                    <option value="volvo">Nothing</option>
                                    <option value="saab">Popularity</option>
                                    <option value="opel">Organic</option>
                                    <option value="audi">Fantastic</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Favorite Product</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            @foreach ($products as $item)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="#"><i class="fas fa-apple-alt me-2"></i>{{$item->name}}</a>
                                                        <span>({{$item->quantity}})</span>
                                                    </div>
                                                </li>
                                                
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4 class="mb-2">Price</h4>
                                        <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput"
                                            min="0" max="500" value="0"
                                            oninput="amount.value=rangeInput.value">
                                        <output id="amount" name="amount" min-velue="0" max-value="500"
                                            for="rangeInput">0</output>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Categories</h4>
                                        @foreach ($categories as $item)
                                            <div class="mb-2">
                                                <input type="radio" class="me-2" id="Categories-{{$item->id}}" name="Categories-{{$item->id}}"
                                                    value="Beverages">
                                                <label for="Categories-{{$item->id}}"> {{$item->name}}</label>
                                            </div>
                                         @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <h4 class="mb-3">Featured products</h4>
                                    @foreach ($products as $item)
                                        <div class="d-flex align-items-center justify-content-start">
                                            <div class="rounded me-4" style="width: 75px; height: 90px;">
                                                <img src={{ Storage::url($item->photos) }} class="rounded img-fluid" alt="">
                                            </div>
                                            <div>
                                                <h6 class="mb-2">{{$item->name}}</h6>
                                                <div class="mb-2 d-flex">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="mb-2 d-flex">
                                                    <h5 class="fw-bold me-2">Rp.{{ number_format($item->price)}}</h5>
                                                    <h5 class="text-danger fw-normal">-5%</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="my-4 d-flex justify-content-center">
                                        <a href="{{route('shop')}}"
                                            class="px-4 py-3 border btn border-secondary rounded-pill text-primary w-100">View
                                            More</a>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="img/banner-fruits.jpg" class="rounded img-fluid w-100" alt="">
                                        <div class="position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%);">
                                            <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 justify-content-center">
                                @foreach ($products as $item)
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <a href="{{ route('shop-detail', $item->id) }}"
                                            class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="{{ Storage::url($item->photos) }}"
                                                    class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="px-3 py-1 text-white rounded bg-secondary position-absolute"
                                                style="top: 10px; left: 10px;">{{ $item->category->name }}</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ $item->name }}</h4>
                                                <small class="mb-1 text-dark fw-bold">Rp.{{ number_format($item->price) }}
                                                    / kg</small>
                                                <p style="color: #747d88 !important">{!! $item->thumb_description !!}</p>
                                                <div class="d-flex justify-content-center flex-lg-wrap">
                                                    <button type="submit"
                                                        class="x-4 py-2 mb-4 border btn border-secondary rounded-pill text-primary">
                                                        Detail
                                                    </button>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                                <div class="text-center">
                                    {{$products->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
@endsection

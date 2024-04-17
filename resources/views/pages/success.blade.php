@extends('layouts.success')

@section('title')
  Success | Point Sebelas
@endsection

@section('content')

  <!-- Hero Start -->
  <div class="py-5 mb-5 container-fluid hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3 text-secondary">100% Organic Foods</h4>
                <h1 class="mb-5 display-3 text-primary">Transaksi Kamu Sedang Di Proses</h1>
            </div>
            <div class="col-md-12 col-lg-5">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="rounded carousel-item active">
                            <img src="img/hero-img-1.png" class="rounded img-fluid w-100 h-100 bg-secondary"
                                alt="First slide">
                            <a href="#" class="px-4 py-2 text-white rounded btn">Fruites</a>
                        </div>
                        <div class="rounded carousel-item">
                            <img src="img/hero-img-2.jpg" class="rounded img-fluid w-100 h-100" alt="Second slide">
                            <a href="#" class="px-4 py-2 text-white rounded btn">Vesitables</a>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->

@endsection


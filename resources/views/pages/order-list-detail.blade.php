@extends('layouts.home')

@section('title')
    Order List Detail | Point Sebelas
@endsection

@section('content')
    <!-- Single Page Header start -->
    <div class="py-5 container-fluid page-header">
        <h1 class="text-center text-white display-6">Order List Detail</h1>
        <ol class="mb-0 breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="text-white breadcrumb-item active">Order List Detail</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Order List Page Start -->
    <div class="py-5 container-fluid">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price / Item</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($query as $item)
                            <tr>
                                <td>
                                    <p class="mt-4 mb-0">
                                        #
                                    </p>
                                </td>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <a href="{{route('shop-detail', $item->product->id)}}">
                                            <img src="{{ Storage::url($item->product->photos) }}" class="img-fluid me-5 rounded-circle"
                                                style="width: 80px; height: 80px;" alt="">
                                        </a>
                                    </div>
                                </th>
                                <td>
                                    <p class="mt-4 mb-0" >{{ $item->product->name }}</p>
                                </td>
                                <td>
                                    <p class="mt-4 mb-0" >{{ $item->qty }}</p>
                                </td>
                                <td>
                                    <p class="mt-4 mb-0" >Rp.{{ number_format($item->product->price) }}</p>
                                </td>
                                <td>
                                    <a href="{{route('shop-detail', $item->product->id)}}" class="mt-3 border btn btn-md bg-success" style="color:white">
                                        Beli lagi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

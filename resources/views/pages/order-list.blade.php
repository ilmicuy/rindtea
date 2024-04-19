@extends('layouts.home')

@section('title')
    Order List | Point Sebelas
@endsection

@section('content')
    <!-- Single Page Header start -->
    <div class="py-5 container-fluid page-header">
        <h1 class="text-center text-white display-6">Order List</h1>
        <ol class="mb-0 breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="text-white breadcrumb-item active">Order List</li>
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
                            <th scope="col">No</th>
                            <th scope="col">Pesanan Dibuat</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Transaction Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($query as $key => $item)
                            <tr>
                                <td>
                                    <p class="mt-4 mb-0">
                                        {{$key + 1}}
                                    </p>
                                </td>
                                <td>
                                    <p class="mt-4 mb-0">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i:s') }}
                                    </p>
                                </td>
                                <td>
                                    <p class="mt-4 mb-0">Rp.{{number_format($item->total_price)}}</p>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = '';
                                        switch ($item->transaction_status) {
                                            case 'completed':
                                                $badgeClass = 'badge bg-success';
                                                break;
                                            case 'pending':
                                                $badgeClass = 'badge bg-warning';
                                                break;
                                            case 'failed':
                                                $badgeClass = 'badge bg-danger';
                                                break;
                                            default:
                                                $badgeClass = 'badge bg-secondary';
                                                break;
                                        }
                                    @endphp
                                    <p class="mt-4 mb-0" style="font-size: 1.2rem"><span class="{{ $badgeClass }}">{{ $item->transaction_status }}</span></p>
                                </td>
                              
                                <td>
                                    <a href="{{ route('order.detail', $item->id) }}" class="mt-4 border btn btn-md rounded-circle bg-light">
                                        <i class="fa fa-eye text-success"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

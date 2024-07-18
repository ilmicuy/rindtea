@extends('layouts.home')


@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header">
        <h1 class="page-title">Order List</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active">Order List</li>
        </ol>
    </div>
    <!-- Single Page Header End -->



    <!-- Order List Page Start -->
    <div class="order-list-page">
        <div class="">
            <div class="">
                <table class="">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Pesanan Dibuat</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Status Transaksi</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($query as $key => $item)
                            <tr>
                                <td>
                                    <p class="">{{ $key + 1 }}</p>
                                </td>
                                <td>
                                    <p class="">{{ \Carbon\Carbon::parse($item->update_at)->format('d M Y H:i:s') }}
                                    </p>
                                </td>
                                <td>
                                    <p class="">Rp.{{ number_format($item->total_price) }}</p>
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
                                    <p class=""><span
                                            class="{{ $badgeClass }}">{{ $item->transaction_status }}</span></p>
                                </td>

                                <td>
                                    <a href="{{ route('order.detail', $item->id) }}">
                                        <i data-feather="eye"></i>
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

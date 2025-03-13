@extends('layouts.home')

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5" style="background-color: var(--primary);" data-aos="fade-down">
        <div class="container">
            <h1 class="page-title mb-3">Daftar Pesanan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Pesanan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <!-- Order List Page Start -->
    <div class="modern-checkout py-5">
        <div class="container">
            <div class="checkout-card">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-4">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Riwayat Pesanan
                    </h5>

                    @if(count($query) > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col">Pesanan Dibuat</th>
                                        <th scope="col" class="text-end">Total Harga</th>
                                        <th scope="col" class="text-center">Status Transaksi</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($query as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->update_at)->format('d M Y H:i:s') }}</td>
                                            <td class="text-end">Rp.{{ number_format($item->total_price) }}</td>
                                            <td class="text-center">
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
                                                <span class="{{ $badgeClass }}">{{ ucfirst($item->transaction_status) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('order.detail', $item->id) }}" class="btn btn-sm" style="background-color: var(--primary); color: var(--bg);">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag fa-3x mb-3 text-muted"></i>
                            <h5 class="text-muted mb-4">Belum ada pesanan</h5>
                            <a href="{{ route('shop') }}" class="btn" style="background-color: var(--primary); color: var(--bg);">
                                <i class="fas fa-store me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Order List Page End -->
@endsection

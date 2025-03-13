@extends('layouts.home')

@section('content')
    <!-- Single Page Header start -->
    <div class="single-page-header py-5" style="background-color: var(--primary);" data-aos="fade-down">
        <div class="container">
            <h1 class="page-title mb-3">Detail Pesanan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/order-list">Daftar Pesanan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pesanan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <!-- Order Detail Page Start -->
    <div class="modern-checkout py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Status Transaksi Card -->
                <div class="col-12">
                    <div class="checkout-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Status Transaksi
                                </h5>
                                <div class="text-end">
                                    @if($transaction->refund_status != null)
                                        <div class="badge bg-danger mb-2">REFUND {{ strtoupper(str_replace('_',' ',$transaction->refund_status)) }}</div>
                                        <form action="{{ route('order.update', $transaction->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" name="refund_no_rek" class="form-control" placeholder="Contoh: BCA (1233398231)"
                                                    value="{{ $transaction->refund_no_rek }}" required
                                                    {{ $transaction->refund_status != 'belum_diproses' ? 'readonly' : '' }}>
                                                @if ($transaction->refund_status == 'belum_diproses')
                                                    <button type="submit" class="btn" style="background-color: var(--primary); color: var(--bg);">Proses Refund</button>
                                                @endif
                                            </div>
                                        </form>
                                    @else
                                        @if($transaction->paid_at)
                                            <div class="badge bg-success">LUNAS</div>
                                        @else
                                            <div class="badge bg-danger mb-2">BELUM LUNAS</div>
                                            <button type="button" id="pay-button" class="btn" style="background-color: var(--primary); color: var(--bg);">
                                                <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items Table -->
                <div class="col-12">
                    <div class="checkout-card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fas fa-shopping-bag me-2"></i>Detail Produk
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col" class="text-center">Jumlah</th>
                                            <th scope="col" class="text-end">Harga / Item</th>
                                            <th scope="col" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($query as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td>
                                                    <a href="{{ route('shop-detail', $item->product->id) }}">
                                                        <img src="{{ Storage::url($item->product->photos) }}"
                                                            class="rounded"
                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                            alt="{{ $item->product->name }}">
                                                    </a>
                                                </td>
                                                <td>{{ $item->product->name }}</td>
                                                <td class="text-center">{{ $item->qty }}</td>
                                                <td class="text-end">Rp.{{ number_format($item->product->price) }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $badgeClass = '';
                                                        switch ($item->transaction->transaction_status) {
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
                                                    <span class="{{ $badgeClass }}">
                                                        {{ ucfirst($item->transaction->transaction_status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction History -->
                @if (count($transaction->transactionStatusLogs) > 0)
                    <div class="col-12">
                        <div class="checkout-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">
                                    <i class="fas fa-history me-2"></i>Riwayat Transaksi
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>Waktu</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaction->transactionStatusLogs as $log)
                                                @if ($log->column_name == 'transaction_status')
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i:s') }}</td>
                                                        <td>Pesanan {{ \App\Helpers\TransactionHelper::translateStatus($log->new_value) }}</td>
                                                    </tr>
                                                @elseif ($log->column_name == 'paid_at')
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i:s') }}</td>
                                                        <td>Pesanan Dibayar</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Shipping Details -->
                @if ($transaction->transactionShipment()->latest()->first())
                    <div class="col-12">
                        <div class="checkout-card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">
                                    <i class="fas fa-truck me-2"></i>Detail Pengiriman
                                </h5>

                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <div class="shipping-info">
                                            <p class="mb-2"><strong>Nomor Resi:</strong> {{ $transaction->transactionShipment()->latest()->first()->awb }}</p>
                                            <p class="mb-2"><strong>Kurir:</strong> {{ $transaction->transactionShipment()->latest()->first()->courier }}</p>
                                            <p class="mb-2"><strong>Layanan:</strong> {{ $transaction->transactionShipment()->latest()->first()->service }}</p>
                                            <p class="mb-2"><strong>Status:</strong> {{ $transaction->transactionShipment()->latest()->first()->status }}</p>
                                            <p class="mb-2"><strong>Tanggal Kirim:</strong> {{ $transaction->transactionShipment()->latest()->first()->date }}</p>
                                            <p class="mb-0"><strong>Deskripsi:</strong> {{ $transaction->transactionShipment()->latest()->first()->description }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="shipping-info">
                                            <p class="mb-2"><strong>Amount:</strong> {{ $transaction->transactionShipment()->latest()->first()->amount }}</p>
                                            <p class="mb-2"><strong>Weight:</strong> {{ $transaction->transactionShipment()->latest()->first()->weight }}</p>
                                            <p class="mb-2"><strong>Pengirim:</strong> {{ $transaction->transactionShipment()->latest()->first()->origin }}</p>
                                            <p class="mb-2"><strong>Destinasi:</strong> {{ $transaction->transactionShipment()->latest()->first()->destination }}</p>
                                            <p class="mb-2"><strong>Shipper:</strong> {{ $transaction->transactionShipment()->latest()->first()->shipper }}</p>
                                            <p class="mb-0"><strong>Receiver:</strong> {{ $transaction->transactionShipment()->latest()->first()->receiver }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-dark table-hover align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th width="25%">Tanggal Status</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($transaction->transactionShipment()->latest()->first()->transactionShipmentHistory as $history)
                                                <tr>
                                                    <td>{{ $history->history_date }}</td>
                                                    <td>{{ $history->description }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center">Tidak ada history pengiriman</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Order Detail Page End -->
@endsection

@push('myscript')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        @if($transaction->paid_at == null && $transaction->snap_token != null && $transaction->refund_status == null)
            function snapPay() {
                snap.pay('{{ $transaction->snap_token }}', {
                    onSuccess: function(result) {
                        window.location.reload();
                    },
                    onPending: function(result) {
                        // Handle pending
                    },
                    onError: function(result) {
                        // Handle error
                    }
                });
            }

            snapPay();

            document.getElementById('pay-button').onclick = function() {
                snapPay();
            };
        @endif
    </script>
@endpush

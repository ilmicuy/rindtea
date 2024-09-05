@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Riwayat Transaksi
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                @hasanyrole('marketing')
                    @if ($transactionPending > 0)
                        <div class="alert alert-warning" role="alert">
                            Terdapat <a href="javascript:void(0)" class="alert-link"><b>{{ $transactionPending }}</b></a> Order dengan status Pending
                        </div>
                    @endif
                @endhasanyrole

                <!-- Total Transaction Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaction</h5>
                        <p class="card-text">Rp.{{ number_format($totalTransaction) }}</p>
                    </div>
                </div>

                <!-- Transaction Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tanggal Checkout</th>
                                        <th>Total Price</th>
                                        <th>Status Transaksi</th>
                                        <th>Status Keuangan</th>
                                        @hasanyrole('marketing')
                                        <th>Aksi</th>
                                        @endhasanyrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($query as $key => $transaction)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $transaction->kode_transaksi }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->updated_at)->format('d M Y H:i:s') }}</td>
                                            <td>Rp.{{ number_format($transaction->total_price) }}</td>
                                            <td>
                                                @php
                                                    $status = $transaction->transaction_status;
                                                    $badgeColor = '';

                                                    switch ($status) {
                                                        case 'pending':
                                                            $badgeColor = 'bg-warning';
                                                            break;
                                                        case 'failed':
                                                            $badgeColor = 'bg-danger';
                                                            break;
                                                        case 'completed':
                                                            $badgeColor = 'bg-success';
                                                            break;
                                                        default:
                                                            $badgeColor = 'bg-secondary';
                                                            break;
                                                    }
                                                @endphp

                                                <span class="px-2 inline-flex leading-5 text-base font-semibold rounded-full {{ $badgeColor }} text-white">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusPelunasan = ($transaction->paid_at != null ? 'Lunas' : 'Belum Lunas');
                                                    $badgeColorPelunasan = '';

                                                    switch($statusPelunasan){
                                                        case 'Lunas':
                                                            $badgeColorPelunasan = "bg-success";
                                                            break;
                                                        case 'Belum Lunas':
                                                            $badgeColorPelunasan = "bg-danger";
                                                            break;
                                                    }
                                                @endphp

                                                <span class="px-2 inline-flex leading-5 text-base font-semibold rounded-full {{ $badgeColorPelunasan }} text-white">
                                                    {{ $statusPelunasan }}
                                                </span>
                                            </td>

                                            @hasanyrole('marketing')
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn btn-primary">
                                                        Edit
                                                    </a>
                                                </div>
                                            </td>
                                            @endhasanyrole
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <p>Tidak ada data terbaru</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $query->links('pagination::bootstrap-4')  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

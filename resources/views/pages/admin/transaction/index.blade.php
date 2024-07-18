
@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Transaction History
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Checkout</th>
                                        <th>Total Price</th>
                                        <th>Status Transaction</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($query as $key => $transaction)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->update_at)->format('d M Y H:i:s') }}
                                            </td>
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

                                                <span
                                                    class="px-2 inline-flex leading-5 text-base font-semibold rounded-full {{ $badgeColor }} text-white">
                                                    {{ $status }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('transaction.edit', $transaction->id) }}"
                                                        class="btn btn-primary">
                                                        Edit
                                                    </a>
                                                </div>
                                            </td>
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
                        {{ $query->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

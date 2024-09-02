@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Riwayat Transaksi Produk
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('product.downloadPdf') }}" class="btn btn-primary mt-3">Download Detail PDF</a>

                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Tipe Transaksi</th>
                                        <th>Role</th>
                                        <th>Jumlah</th>
                                        <th>Jumlah Lama</th>
                                        <th>Jumlah Baru</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $transactions->total() - ($transactions->currentPage() - 1) * $transactions->perPage() - $key }}</td>
                                            <td>{{ $transaction->product->name }}</td>
                                            <td>{{ ucfirst($transaction->transaction_type) }}</td>
                                            <td>{{ $transaction->user->getRoleNames()->implode(', ') }}</td> <!-- Role of the user -->
                                            <td>{{ $transaction->quantity }}</td>
                                            <td>{{ $transaction->old_quantity }}</td>
                                            <td>{{ $transaction->new_quantity }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y H:i:s') }}</td>
                                            <td>{{ $transaction->description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9">
                                                <p>No transactions found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $transactions->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

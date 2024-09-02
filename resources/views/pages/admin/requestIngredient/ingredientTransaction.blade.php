@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Riwayat Transaksi Bahan Baku
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
                                        <th>Nama Bahan Baku</th>
                                        <th>Tipe Transaksi</th>
                                        <th>Jumlah</th>
                                        <th>Jumlah Lama</th>
                                        <th>Jumlah Baru</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>User</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ingredientTransactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $ingredientTransactions->total() - ($ingredientTransactions->currentPage() - 1) * $ingredientTransactions->perPage() - $key }}</td>
                                            <td>{{ $transaction->ingredient->nama_bahan_baku }}</td>
                                            <td>{{ ucfirst($transaction->transaction_type) }}</td>
                                            <td>{{ $transaction->quantity }}</td>
                                            <td>{{ $transaction->old_quantity }}</td>
                                            <td>{{ $transaction->new_quantity }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y H:i:s') }}</td>
                                            <td>{{ $transaction->user->name }}</td>
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
                        {{ $ingredientTransactions->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

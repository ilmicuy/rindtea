@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Product Transaction History
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
                                        <th>Product Name</th>
                                        <th>Transaction Type</th>
                                        <th>Quantity</th>
                                        <th>Old Quantity</th>
                                        <th>New Quantity</th>
                                        <th>Transaction Date</th>
                                        <th>User</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $transaction->product->name }}</td>
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
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

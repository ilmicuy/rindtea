<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Transaction History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Product Name</th>
                                                <th>Buyer Name</th>
                                                <th>Total Price</th>
                                                <th>Quality</th>
                                                <th>Tanggal Checkout</th>
                                                <th>Status Transaction</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $key => $transaction)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $transaction->product->name }}</td>
                                                    <td>{{ $transaction->first_name }} {{ $transaction->last_name }}</td>
                                                    <td>Rp.{{ number_format($transaction->transaction->total_price) }}</td>
                                                    <td>{{ $transaction->qty}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($transaction->transaction->created_at)->format('d M Y H:i:s') }}</td>
                                                    <td>{{ $transaction->transaction->transaction_status }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('transaction.edit', $transaction->id) }}" class="mb-1 mr-1 btn btn-primary">
                                                                Edit
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>


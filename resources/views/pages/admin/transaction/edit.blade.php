<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Transaction Edit') }}
        </h2>
    </x-slot>

    <form method="post" action="{{ route('transaction.update', $items->transaction->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pb-3">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-4">
                            <h1 class="pb-2 font-semibold">Nama Pembeli </h1>
                            <div class="text-gray-900 dark:text-gray-100">
                                {{ $items->first_name }} {{ $items->last_name }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-4">
                            <h1 class="pb-2 font-semibold">Address </h1>
                            <div class="text-gray-900 dark:text-gray-100">
                                {{ $items->address }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-4">
                            <h1 class="pb-2 font-semibold">Phone Number </h1>
                            <div class="text-gray-900 dark:text-gray-100">
                                {{ $items->phone }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-4">
                            <h1 class="pb-2 font-semibold">Transaction Status </h1>
                            <select id="transaction_status" name="transaction_status"
                                class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md">
                                <option value="pending" @if (old('transaction_status', $items->transaction->transaction_status) == 'pending') selected @endif>Pending
                                </option>
                                <option value="completed" @if (old('transaction_status', $items->transaction->transaction_status) == 'completed') selected @endif>Completed
                                </option>
                                <option value="failed" @if (old('transaction_status', $items->transaction->transaction_status) == 'failed') selected @endif>Failed</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="text-xl mb-3 font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                        {{ __('Transaction Detail') }}
                                    </h2>
                                    <div class="table-responsive">
                                        <table class="table table-hover scroll-horizontal-vertical w-100"
                                            id="crudTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Product</th>
                                                    <th>Tanggal Checkout</th>
                                                    <th>Price / Item</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($itemDetails as $key => $itemDetail)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <th scope="row">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ Storage::url($itemDetail->product->photos) }}"
                                                                    class="img-fluid me-5"
                                                                    style="width: 25px; height: 25px;" alt="">
                                                            </div>
                                                        </th>
                                                        <td>{{ \Carbon\Carbon::parse($itemDetail->created_at)->format('d M Y H:i:s') }}
                                                        </td>
                                                        <td>Rp.{{ number_format($itemDetail->product->price) }}</td>
                                                        <td>{{ $itemDetail->qty }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <a class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                            style="text-decoration: none;" href="{{ route('transaction') }}">
                                            {{ __('Cancel') }}
                                        </a>

                                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>

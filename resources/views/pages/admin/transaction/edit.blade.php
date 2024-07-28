{{-- <x-app-layout>
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
                                {{ $items->fullname }}
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
</x-app-layout> --}}
@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Transaction Edit
        </div>
        <form method="post" action="{{ route('transaction.update', $items->transaction->id) }}" class="mt-6 space-y-6"
            enctype="multipart/form-data">
            @csrf
            <div class="content-wrapper">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="bg-white rounded-lg shadow-md">
                                <div class="p-4">
                                    <h4 class="pb-2 font-semibold">Nama Pembeli </h4>
                                    <div class="text-gray-900 dark:text-gray-100">
                                        {{ $items->transaction->user->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white rounded-lg shadow-md">
                                <div class="p-4">
                                    <h4 class="pb-2 font-semibold">Phone Number </h4>
                                    <div class="text-gray-900 dark:text-gray-100">
                                        {{ $items->transaction->address->phone}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white rounded-lg shadow-md">
                                <div class="p-4">
                                    <h4 class="pb-2 font-semibold">Transaction Status </h4>

                                    <select id="transaction_status" name="transaction_status" class="form-control">
                                        <option value="pending" @if (old('transaction_status', $items->transaction->transaction_status) == 'pending') selected @endif>Pending
                                        </option>
                                        <option value="shipping" @if (old('transaction_status', $items->transaction->transaction_status) == 'shipping') selected @endif>
                                            Shipping
                                        </option>
                                        <option value="completed" @if (old('transaction_status', $items->transaction->transaction_status) == 'completed') selected @endif>
                                            Completed
                                        </option>
                                        <option value="failed" @if (old('transaction_status', $items->transaction->transaction_status) == 'failed') selected @endif>Failed
                                        </option>
                                    </select>
                                    <br>
                                    <input type="text" name="no_resi" class="form-control" style="{{ $transaction->transactionShipment()->latest()->first() ? '' : 'display: none;' }}" placeholder="Masukkan No. Resi Pengiriman" value="{{ $transaction->transactionShipment()->latest()->first()->awb ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="transaction-details-tab" data-toggle="tab" href="#transaction-details" role="tab" aria-controls="transaction-details" aria-selected="true">Transaction Details</a>
                                </li>
                                @if ($transaction->transactionShipment()->latest()->first())
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="shipping-details-tab" data-toggle="tab" href="#shipping-details" role="tab" aria-controls="shipping-details" aria-selected="false">Shipping Details</a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <!-- Transaction Details Tab -->
                                <div class="tab-pane fade show active" id="transaction-details" role="tabpanel" aria-labelledby="transaction-details-tab">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
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
                                                                    class="img-fluid me-5" style="width: 25px; height: 25px;" alt="">
                                                            </div>
                                                        </th>
                                                        <td>{{ \Carbon\Carbon::parse($itemDetail->created_at)->format('d M Y H:i:s') }}</td>
                                                        <td>Rp.{{ number_format($itemDetail->product->price) }}</td>
                                                        <td>{{ $itemDetail->qty }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                @if ($transaction->transactionShipment()->latest()->first())
                                <!-- Shipping Details Tab -->
                                <div class="tab-pane fade" id="shipping-details" role="tabpanel" aria-labelledby="shipping-details-tab">
                                    <div class="mt-3">
                                        @if ($transaction->transactionShipment()->latest()->first())
                                            <p><strong>AWB:</strong> {{ $transaction->transactionShipment()->latest()->first()->awb }}</p>
                                            <p><strong>Courier:</strong> {{ $transaction->transactionShipment()->latest()->first()->courier }}</p>
                                            <p><strong>Service:</strong> {{ $transaction->transactionShipment()->latest()->first()->service }}</p>
                                            <p><strong>Status:</strong> {{ $transaction->transactionShipment()->latest()->first()->status }}</p>
                                            <p><strong>Date:</strong> {{ $transaction->transactionShipment()->latest()->first()->date }}</p>
                                            <p><strong>Description:</strong> {{ $transaction->transactionShipment()->latest()->first()->description }}</p>
                                            <p><strong>Amount:</strong> {{ $transaction->transactionShipment()->latest()->first()->amount }}</p>
                                            <p><strong>Weight:</strong> {{ $transaction->transactionShipment()->latest()->first()->weight }}</p>
                                            <p><strong>Origin:</strong> {{ $transaction->transactionShipment()->latest()->first()->origin }}</p>
                                            <p><strong>Destination:</strong> {{ $transaction->transactionShipment()->latest()->first()->destination }}</p>
                                            <p><strong>Shipper:</strong> {{ $transaction->transactionShipment()->latest()->first()->shipper }}</p>
                                            <p><strong>Receiver:</strong> {{ $transaction->transactionShipment()->latest()->first()->receiver }}</p>
                                            <p><strong>Last Crawl At:</strong> {{ $transaction->transactionShipment()->latest()->first()->last_crawl_at }}</p>
                                        @else
                                            <p>No shipping details available.</p>
                                        @endif
                                    </div>

                                    <div class="table-responsive mt-3">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Location</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($transaction->transactionShipment()->latest()->first())
                                                    @forelse ($transaction->transactionShipment()->latest()->first()->transactionShipmentHistory as $history)
                                                        <tr>
                                                            <td>{{ $history->history_date }}</td>
                                                            <td>{{ $history->description }}</td>
                                                            <td>{{ $history->location }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-center">Tidak ada history pengiriman</td>
                                                        </tr>
                                                    @endforelse
                                                @else
                                                    <tr>
                                                        <td colspan="3">No shipping history available.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif

                            </div>
                            <a class="btn btn-secondary" href="{{ route('transaction.index') }}">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary"> Save</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
<script>
    $("select[name='transaction_status']").on('change', function() {
        if($(this).val() == 'shipping') {
            $("input[name='no_resi']").show();
        }else{
            $("input[name='no_resi']").hide();
        }
    });
</script>
@endpush

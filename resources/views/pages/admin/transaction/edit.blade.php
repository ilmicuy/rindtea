@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Edit Transaksi
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
                                        {{ $items->transaction->user->name }} ({{ $items->transaction->user->email }})
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white rounded-lg shadow-md">
                                <div class="p-4">
                                    <h4 class="pb-2 font-semibold">No. Telepon </h4>
                                    <div class="text-gray-900 dark:text-gray-100">
                                        {{ $items->transaction->address->phone}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white rounded-lg shadow-md">
                                <div class="p-4">
                                    <h4 class="pb-2 font-semibold">Status Transaksi </h4>

                                    <select id="transaction_status" name="transaction_status" class="form-control"
                                    @hasanyrole('owner')
                                    disabled
                                    @endhasanyrole
                                    >
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
                                    <a class="nav-link active" id="transaction-details-tab" data-toggle="tab" href="#transaction-details" role="tab" aria-controls="transaction-details" aria-selected="true">Detil Transaksi</a>
                                </li>
                                {{-- @if ($transaction->transactionShipment()->latest()->first()) --}}
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="shipping-details-tab" data-toggle="tab" href="#shipping-details" role="tab" aria-controls="shipping-details" aria-selected="false">Detil Pengiriman</a>
                                    </li>
                                {{-- @endif --}}
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="log-transaksi-tab" data-toggle="tab" href="#log-transaksi" role="tab" aria-controls="log-transaksi" aria-selected="false">Log Transaksi</a>
                                </li>

                                @if ($transaction->refund_status != null)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="refund-tab" data-toggle="tab" href="#refund" role="tab" aria-controls="refund" aria-selected="false">Refund</a>
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
                                                    <th>Produk</th>
                                                    <th>Tanggal Checkout</th>
                                                    <th>Harga / Item</th>
                                                    <th>Jumlah</th>
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

                                {{-- @if ($transaction->transactionShipment()->latest()->first()) --}}
                                <!-- Shipping Details Tab -->
                                <div class="tab-pane fade" id="shipping-details" role="tabpanel" aria-labelledby="shipping-details-tab">
                                    <div class="mt-3">
                                        <div class="form-group">
                                          <label>Jenis Pengiriman Yang Dipilih</label>
                                          <input type="text" class="form-control" value="{{ $transaction->shipment_courier }}" disabled>
                                        </div>
                                        <div class="form-group">
                                          <label>Ongkos Kirim</label>
                                          <input type="text" class="form-control" value="Rp.{{ number_format($transaction->shipment_cost, 0, 0, '.') }}" disabled>
                                        </div>


                                        @if ($transaction->addressChoosen->latitude != null && $transaction->addressChoosen->longitude != null)
                                            <div class="form-group">
                                            <label>Kordinat Pengiriman</label>
                                            <input type="text" class="form-control" value="{{ $transaction->addressChoosen->latitude }}, {{ $transaction->addressChoosen->longitude }}" disabled>
                                            </div>

                                            <div id="map" style="width: 100%; height: 400px;"></div>
                                        @endif

                                        @if ($transaction->addressChoosen)
                                        <div class="form-group">
                                          <label>Alamat Kirim</label>
                                          <textarea rows="3" class="form-control" disabled>{{ $transaction->addressChoosen->address }}</textarea>
                                        </div>
                                        @endif
                                        <hr>
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
                                            <p>Tidak ada data pengiriman. (Nomor Resi / Pengiriman belum di-input)</p>
                                        @endif
                                    </div>

                                    <div class="table-responsive mt-3">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Deskripsi</th>
                                                    <th>Lokasi</th>
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
                                {{-- @endif --}}

                                <!-- Log Transaksi Tab -->
                                <div class="tab-pane fade" id="log-transaksi" role="tabpanel" aria-labelledby="log-transaksi-tab">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Timestamp</th>
                                                    <th>Kolom</th>
                                                    <th>Data Sebelum</th>
                                                    <th>Data Sesudah</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($transaction->transactionStatusLogs as $key => $log)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i:s') }}</td>
                                                        <td>{{ $log->column_name }}</td>
                                                        <td>{{ $log->old_value }}</td>
                                                        <td>{{ $log->new_value }}</td>
                                                        <td>{{ $log->description }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                 <!-- Transaction Details Tab -->
                                <div class="tab-pane fade" id="refund" role="tabpanel" aria-labelledby="refund-tab">

                                    <div class="mb-4">

                                        <div class="form-group">
                                          <label>Status Refund</label>
                                          <input type="text" class="form-control" value="{{ strtoupper(str_replace('_', ' ', $transaction->refund_status)) }}" disabled>
                                        </div>

                                        <div class="form-group">
                                          <label>No. Rekening Refund</label>
                                          <input type="text" class="form-control" value="{{ $transaction->refund_no_rek ?? "(Belum Ada)" }}" disabled>
                                        </div>

                                        @hasanyrole('marketing')
                                        @if ($transaction->refund_status == 'pending')
                                            <div class="form-group">
                                                <button type="button" id="process-refund-button" class="btn btn-success btn-block">Proses Refund</button>
                                            </div>
                                        @endif
                                        @endhasanyrole

                                    </div>

                                </div>

                            </div>
                            <a class="btn btn-secondary" href="{{ route('transaction.index') }}">
                                {{ __('Cancel') }}
                            </a>
                            @hasanyrole('marketing')
                            <button type="submit" class="btn btn-primary"> Save</button>
                            @endhasanyrole
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <style>
        .delivery-marker {
            background-color: #4a90e2;
            border: 2px solid #fff;
            border-radius: 50%;
            width: 12px;
            height: 12px;
        }
    </style>
@endsection

@push('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('status_updated'))
    <script>
        Swal.fire({
            title: 'Success',
            text: '{{ session('status_updated') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if ($transaction->addressChoosen->latitude != null && $transaction->addressChoosen->longitude != null)
    <script>
        function initMap() {
            const latitude = {{ $transaction->addressChoosen->latitude }};
            const longitude = {{ $transaction->addressChoosen->longitude }};

            // Initialize map
            const map = L.map('map').setView([latitude, longitude], 15);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add delivery location marker
            const deliveryIcon = L.divIcon({
                className: 'delivery-marker',
                iconSize: [12, 12]
            });
            L.marker([latitude, longitude], {
                icon: deliveryIcon
            }).bindPopup('Lokasi Pengiriman').addTo(map);
        }

        // Initialize map when document is ready
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>
@endif

<script>
    $("select[name='transaction_status']").on('change', function() {
        if($(this).val() == 'shipping') {
            $("input[name='no_resi']").show();
        }else{
            $("input[name='no_resi']").hide();
        }
    });
</script>

<script>
document.getElementById('process-refund-button').addEventListener('click', function() {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak dapat mengubah status refund setelah diproses!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, proses refund!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('transaction.processRefund', $transaction->id) }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
@endpush

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

                        <!-- Filter Form -->
                        <form action="{{ route('requestIngredient.logs') }}" method="GET" class="form-inline mb-4">
                            <div class="form-group mr-3">
                                <label for="date_range" class="mr-2">Filter by Date</label>
                                <input type="text" name="date_range" id="date_range" class="form-control" placeholder="Select Date Range" value="{{ request()->get('date_range') }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>

                        {{-- <a href="{{ route('ingredient.downloadPdf') }}" class="btn btn-primary mt-3">Download Detail PDF</a> --}}

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

    @push('css')
    <!-- Include Daterangepicker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet">
    @endpush

    @push('js')
    <!-- Include Moment.js and Daterangepicker JS -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(function() {
            $('#date_range').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 90 Days': [moment().subtract(89, 'days'), moment()],
                },
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    @endpush
@endsection

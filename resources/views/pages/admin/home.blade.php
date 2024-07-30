@extends('layouts.app-old')

@push('css')
    <link rel="stylesheet" href="{{ asset('admin') }}/vendor/chart.js/Chart.min.css">
@endpush

@section('content')
    <div class="main-content">
        <div class="title">
            Dashboard
        </div>

        @hasanyrole('owner|keuangan')
            <div class="content-wrapper">
                <div class="row same-height">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Total Product</h4>
                            </div>
                            <div class="card-body">
                                <div class="text-gray-900 dark:text-gray-100">
                                    {{ $productCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Revenue</h4>
                            </div>
                            <div class="card-body">
                                <div class="text-gray-900 dark:text-gray-100">
                                    Rp.{{ number_format($revenue) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pending Transactions</h4>
                            </div>
                            <div class="card-body">
                                <div class="text-gray-900 dark:text-gray-100">
                                    {{ $transactionPending }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row same-height mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistik Penjualan Bulanan</h4>
                                <p>Berdasarkan Produk</p>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" height="642" width="1388"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="header-statistics">
                                <h5>Statistik Penjualan Bulanan</h5>
                                <p>Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table small-font table-striped table-hover table-sm">
                                        <tbody>
                                            @foreach($salesStatistics as $index => $stat)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $stat['product_name'] }}</td>
                                                <td>{{ $stat['current_month_sales'] }}</td>
                                                <td>
                                                    @if($stat['trend'] === 'up')
                                                    <i class="fa fa-caret-up text-success"></i>
                                                    @elseif($stat['trend'] === 'down')
                                                    <i class="fa fa-caret-down text-danger"></i>
                                                    @else
                                                    <i class="fa fa-minus text-secondary"></i>
                                                    @endif
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
        @endhasanyrole
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin') }}/vendor/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var salesData = @json($salesData);

        var labels = Object.keys(salesData);
        var datasets = [];
        var productNames = new Set();

        // Collect all product names
        Object.values(salesData).forEach(monthlyData => {
            Object.values(monthlyData).forEach(product => {
                productNames.add(product.name);
            });
        });

        productNames = Array.from(productNames);

        // Initialize datasets for each product
        productNames.forEach(productName => {
            datasets.push({
                label: productName,
                data: Array(labels.length).fill(0),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            });
        });

        // Fill datasets with data
        labels.forEach((month, monthIndex) => {
            Object.values(salesData[month]).forEach(product => {
                var productIndex = productNames.indexOf(product.name);
                if (productIndex !== -1) {
                    datasets[productIndex].data[monthIndex] = product.qty;
                }
            });
        });

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush

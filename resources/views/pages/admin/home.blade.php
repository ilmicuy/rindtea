@extends('layouts.app-old')

@push('css')
    <link rel="stylesheet" href="{{ asset('admin') }}/vendor/chart.js/Chart.min.css">
@endpush

@section('content')
    <div class="main-content">
        <div class="title">
        @hasanyrole('owner|keuangan')
            Dashboard
        @elsehasanyrole('marketing|produksi')
            Selamat Datang
        @endhasanyrole
        </div>

        @hasanyrole('marketing')
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        @if ($transactionPending > 0)
                        <div class="alert alert-warning" role="alert">
                            Terdapat <a href="/transaction" class="alert-link"><b>{{ $transactionPending }}</b></a> Order dengan status Pending
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endhasanyrole

        @hasanyrole('owner|keuangan')
            <div class="content-wrapper">
                <div class="row same-height">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Total Produk</h4>
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
                                <h4>Pendapatan</h4>
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
                                <h4>Transaksi Pending</h4>
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

        var colors = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ];

        var borderColors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ];

        // Collect all product names
        Object.values(salesData).forEach(monthlyData => {
            Object.values(monthlyData).forEach(product => {
                productNames.add(product.name);
            });
        });

        productNames = Array.from(productNames);

        // Initialize datasets for each product
        productNames.forEach((productName, index) => {
            datasets.push({
                label: productName,
                data: Array(labels.length).fill(0),
                backgroundColor: colors[index % colors.length],
                borderColor: borderColors[index % borderColors.length],
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

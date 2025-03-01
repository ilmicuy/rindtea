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
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pendapatan Total</h4>
                            </div>
                            <div class="card-body">
                                <div class="text-gray-900 dark:text-gray-100">
                                    Rp.{{ number_format($revenue) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pendapatan Bersih</h4>
                            </div>
                            <div class="card-body">
                                <div class="text-gray-900 dark:text-gray-100">
                                    Rp.{{ number_format($netRevenue) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
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

                <!-- FILTER FORM & TOP 5 TABLE -->
                <div class="row same-height mt-4">
                    <div class="col-md-12">
                        <!-- FORM FILTER TANGGAL -->
                        <!-- NOTE: We remove the action/method so we can intercept with JS -->
                        <form id="filterForm" class="row mb-3">
                            <div class="col-md-3">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ $startDate }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ $endDate }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    Filter
                                </button>
                            </div>
                        </form>

                        <!-- TABEL 5 PRODUK -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Top 5 Produk (Periode <span id="dateRangeLabel">{{ $startDate }} s/d {{ $endDate }}</span>)</h4>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table small-font table-striped table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga Jual</th>
                                            <th>Terjual (qty)</th>
                                            <th>Pendapatan Kotor</th>
                                            <th>Pendapatan Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody id="topProductsTableBody">
                                        @foreach($topProducts as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>Rp. {{ number_format($item['selling_price'], 0, ',', '.') }}</td>
                                                <td>{{ $item['total_qty'] }}</td>
                                                <td>Rp. {{ number_format($item['gross_revenue'], 0, ',', '.') }}</td>
                                                <td>Rp. {{ number_format($item['net_revenue'], 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot id="topProductsTableFooter">
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th>{{ $totals['total_qty'] }}</th>
                                            <th>Rp. {{ number_format($totals['gross_revenue'], 0, ',', '.') }}</th>
                                            <th>Rp. {{ number_format($totals['net_revenue'], 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
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
        // ==================================================
        // 1) INITIAL CHART RENDER
        // ==================================================
        var ctx = document.getElementById('myChart').getContext('2d');
        var initialSalesData = @json($salesData);

        var chartInstance = null; // We'll store Chart.js instance globally

        function renderChart(salesData) {
            // If there's already a chart, destroy it before re-creating
            if (chartInstance) {
                chartInstance.destroy();
            }

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

            chartInstance = new Chart(ctx, {
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
        }

        // Render chart on page load
        renderChart(initialSalesData);


        // ==================================================
        // 2) AJAX FILTER HANDLER
        // ==================================================
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var start_date = document.querySelector('input[name="start_date"]').value;
            var end_date = document.querySelector('input[name="end_date"]').value;

            // Make AJAX request
            fetch("{{ route('dashboard') }}?start_date=" + start_date + "&end_date=" + end_date, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                // Update table date range label
                document.getElementById('dateRangeLabel').textContent = data.startDate + ' s/d ' + data.endDate;

                // 1) Update the table body
                var tableBody = document.getElementById('topProductsTableBody');
                tableBody.innerHTML = ''; // Clear existing rows

                data.topProducts.forEach(function(item) {
                    var row = `
                        <tr>
                            <td>${item.name}</td>
                            <td>Rp. ${new Intl.NumberFormat('id-ID').format(item.selling_price)}</td>
                            <td>${item.total_qty}</td>
                            <td>Rp. ${new Intl.NumberFormat('id-ID').format(item.gross_revenue)}</td>
                            <td>Rp. ${new Intl.NumberFormat('id-ID').format(item.net_revenue)}</td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });

                // 2) Update the table footer
                var tableFooter = document.getElementById('topProductsTableFooter');
                tableFooter.innerHTML = `
                    <tr>
                        <th colspan="2">Total</th>
                        <th>${data.totals.total_qty}</th>
                        <th>Rp. ${new Intl.NumberFormat('id-ID').format(data.totals.gross_revenue)}</th>
                        <th>Rp. ${new Intl.NumberFormat('id-ID').format(data.totals.net_revenue)}</th>
                    </tr>
                `;

                // 3) Update the chart with new data
                renderChart(data.salesData);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
        });
    </script>
@endpush

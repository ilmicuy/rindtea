<div class="card">
    <div class="card-header">
        <h4>Top 5 Produk (Periode {{ $startDate }} s/d {{ $endDate }})</h4>
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
            <tbody>
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
            <tfoot>
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

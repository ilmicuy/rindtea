<!DOCTYPE html>
<html>
<head>
    <title>Ingredient Transaction Log</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi Bahan Baku</h1>
    <p>
        <b>Laporan Dibuat: </b> Bag. Logistik
    </p>
    <p>
        <b>Laporan di-Download: </b> {{ \Carbon\Carbon::now() }}
    </p>
    <p>
        <b>Laporan Tanggal: </b> {{ str_replace('to', 'ke', $dateRangeRaw) }}
    </p>

    <table>
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
            @foreach ($ingredientTransaction as $key => $transaction)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $transaction->ingredient->nama_bahan_baku }}</td>
                    <td>{{ ucfirst($transaction->transaction_type) }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ $transaction->old_quantity }}</td>
                    <td>{{ $transaction->new_quantity }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y H:i:s') }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

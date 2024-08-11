<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Baru</title>
</head>
<body>
    <h1>Order Baru</h1>

    <p>Halo Tim Marketing,</p>

    <p>Terdapat order baru dengan rincian sebagai berikut:</p>

    <ul>
        @foreach ($items as $item)
            <li>{{ $item['name'] }} - {{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</li>
        @endforeach
    </ul>

    <p><strong>Total Harga:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>

    <p>Terima Kasih.</p>
</body>
</html>

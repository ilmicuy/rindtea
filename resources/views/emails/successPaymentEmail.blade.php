<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Anda Berhasil di Rind Tea!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #4CAF50;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #45a049;
        }
        .label {
            display: block;
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
            background-color: #ff0000;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pembayaran Anda Berhasil di Rind Tea!</h1>
        </div>
        <div class="content">
            <div class="label">Lunas</div>
            <h2>Hai, {{ $user->name }}!</h2>
            <p>Terima kasih telah melakukan pembayaran pemesanan nomor #{{ $transaction->id }}. Berikut adalah rincian pesanan Anda:</p>
            <ul>
                @foreach ($items as $item)
                    <li>{{ $item['name'] }} - {{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</li>
                @endforeach
            </ul>
            <p>Total Harga: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            <p>Pesanan Anda sedang diproses dan akan segera kami kirim.</p>
            <p>Hormat Kami,<br>Tim Rind Tea</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Rind Tea. All rights reserved.
        </div>
    </div>
</body>
</html>

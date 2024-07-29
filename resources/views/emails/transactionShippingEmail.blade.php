<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Produk Anda Telah Dikirim</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Produk Anda Telah Dikirim</h1>
        </div>
        <div class="content">
            <h2>Hai, {{ $user->name }}!</h2>
            <p>Pesanan anda dengan nomor #{{ $transaction->id }} telah dikirim dengan Nomor Resi {{ $trackingNumber }}. Silakan cek status pengiriman melalui situs kami.</p>
            <p>Hormat Kami,<br>Tim Rind Tea</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Rind Tea. All rights reserved.
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang di Rind Tea!</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Selamat Datang di Rind Tea!</h1>
        </div>
        <div class="content">
            <h2>Selamat Datang, {{ $user->name }}!</h2>
            <p>Terimakasih sudah melakukan registrasi di website Rind Tea. Kini anda dapat melakukan pemesanan produk Rind Tea melalui website <a href="https://rindtea.biz.id/">rindtea.biz.id</a>.</p>
            <p>Hormat Kami,<br>Tim Rind Tea</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Rind Tea. All rights reserved.
        </div>
    </div>
</body>
</html>

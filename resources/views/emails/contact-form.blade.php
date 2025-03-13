<!DOCTYPE html>
<html>
<head>
    <title>Pesan Baru dari Form Kontak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f9ca7a;
            color: #000;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
        .info-item {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pesan Baru dari Form Kontak Website</h1>
        </div>
        <div class="content">
            <div class="info-item">
                <span class="label">Nama:</span>
                <p>{{ $name }}</p>
            </div>
            <div class="info-item">
                <span class="label">Email:</span>
                <p>{{ $email }}</p>
            </div>
            <div class="info-item">
                <span class="label">No. Telepon:</span>
                <p>{{ $phone }}</p>
            </div>
            <div class="info-item">
                <span class="label">Pesan:</span>
                <p>{{ $message }}</p>
            </div>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis dari website Rind Tea</p>
        </div>
    </div>
</body>
</html>

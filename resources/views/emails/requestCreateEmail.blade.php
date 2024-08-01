<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $type }} Baru</title>
</head>
<body>
    <h1>{{ $type }} Baru</h1>

    <p>Halo {{ $user->name }},</p>

    @if ($type == "Request Bahan Baku")
        <p>Terdapat {{ $type }} untuk <strong>{{ $modelRequest->ingredient->nama_bahan_baku }}</strong> dengan jumlah <strong>{{ $modelRequest->qty_request }}</strong>. Mohon untuk segera menanggapi request ini.</p>
    @else
        <p>Terdapat {{ $type }} untuk <strong>{{ $modelRequest->product->name }}</strong> dengan jumlah <strong>{{ $modelRequest->qty_requested }}</strong>. Mohon untuk segera menanggapi request ini.</p>
    @endif

    <p>Terima Kasih.</p>
</body>
</html>

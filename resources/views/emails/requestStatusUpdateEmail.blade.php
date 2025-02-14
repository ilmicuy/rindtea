<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $type }} Status Update</title>
</head>
<body>
    <h1>Status Update untuk {{ $type }}</h1>

    <p>Halo {{ $user->name }},</p>

    @if ($type == "Request Bahan Baku")
        <p>{{ $type }} untuk <strong>{{ $modelRequest->ingredient->nama_bahan_baku }}</strong> dengan jumlah <strong>{{ $modelRequest->qty_request }}</strong> telah <strong>{{ $statusName }}</strong>.</p>
    @else
        <p>{{ $type }} untuk <strong>{{ $modelRequest->product->name }}</strong> dengan jumlah <strong>{{ $modelRequest->qty_requested }}</strong> telah <strong>{{ $statusName }}</strong>.</p>
    @endif

    <p>Terima Kasih.</p>
</body>
</html>

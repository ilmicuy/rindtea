@extends('emails.layouts.mail')

@section('content')
<h1 style="font-size: 24px; margin-bottom: 20px;">Order Baru</h1>

<div style="background: #f8f9fa; border-left: 4px solid #f9ca7a; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <h2 style="margin-top: 0; color: #212529;">Status: Pesanan Baru Masuk</h2>
</div>

<p>Halo Tim Marketing,</p>

<p>Terdapat order baru dengan rincian sebagai berikut:</p>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr style="background: #f8f9fa;">
            <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Produk</th>
            <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Jumlah</th>
            <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">{{ $item['name'] }}</td>
            <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">{{ $item['quantity'] }}</td>
            <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p>Total Harga: <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></p>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('admin.transactions.show', $transaction->id) }}"
       style="background-color: #f9ca7a;
              color: #212529;
              padding: 12px 25px;
              text-decoration: none;
              border-radius: 4px;
              display: inline-block;
              font-weight: bold;">
        Lihat Detail Order
    </a>
</div>

<p>Terima Kasih.</p>

{{ config('app.name') }} © {{ date('Y') }}
@endsection

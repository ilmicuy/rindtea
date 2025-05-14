@extends('emails.layouts.mail')

@section('content')
<h1 style="font-size: 24px; margin-bottom: 20px;">Pesanan Anda Telah Sampai!</h1>

<div style="background: #f8f9fa; border-left: 4px solid #28a745; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <h2 style="margin-top: 0; color: #212529;">Status: Pesanan Selesai</h2>
</div>

<p>Hai {{ $user->name }},</p>

<p>Pesanan Anda dengan kode transaksi #{{ $transaction->kode_transaksi }} telah sampai di tujuan.</p>

<p>Terima kasih telah berbelanja di Rind Tea. Kami harap Anda puas dengan produk dan layanan kami.</p>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('order.detail', $transaction->id) }}"
       style="background-color: #f9ca7a;
              color: #212529;
              padding: 12px 25px;
              text-decoration: none;
              border-radius: 4px;
              display: inline-block;
              font-weight: bold;">
        Lihat Detail Pesanan
    </a>
</div>

<p>Hormat Kami,<br>
Tim Rind Tea</p>

{{ config('app.name') }} © {{ date('Y') }}
@endsection

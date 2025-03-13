@extends('emails.layouts.mail')

@section('content')
<h1 style="font-size: 24px; margin-bottom: 20px;">Pemesanan Produk Gagal</h1>

<div style="background: #f8f9fa; border-left: 4px solid #dc3545; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <h2 style="margin-top: 0; color: #dc3545;">Status: Gagal</h2>
</div>

<p>Hai {{ $user->name }},</p>

<p>Mohon maaf, pemesanan produk Anda dengan kode transaksi #{{ $transaction->kode_transaksi }} tidak dapat diproses.</p>

<p>Silakan coba melakukan pemesanan kembali atau hubungi tim support kami jika Anda membutuhkan bantuan.</p>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ config('app.url') }}"
       style="background-color: #dc3545;
              color: #ffffff;
              padding: 12px 25px;
              text-decoration: none;
              border-radius: 4px;
              display: inline-block;
              font-weight: bold;">
        Kembali ke Website
    </a>
</div>

<p>Hormat Kami,<br>
Tim Rind Tea</p>

{{ config('app.name') }} © {{ date('Y') }}
@endsection

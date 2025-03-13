@extends('emails.layouts.mail')

@section('content')
<h1 style="font-size: 24px; margin-bottom: 20px;">Selamat Datang di Rind Tea!</h1>

<div style="background: #f8f9fa; border-left: 4px solid #28a745; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <h2 style="margin-top: 0; color: #212529;">Akun Anda Telah Aktif</h2>
</div>

<p>Hai {{ $user->name }},</p>

<p>Terimakasih sudah melakukan registrasi di website Rind Tea. Kini anda dapat melakukan pemesanan produk Rind Tea melalui website kami.</p>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ config('app.url') }}"
       style="background-color: #f9ca7a;
              color: #212529;
              padding: 12px 25px;
              text-decoration: none;
              border-radius: 4px;
              display: inline-block;
              font-weight: bold;">
        Kunjungi Website
    </a>
</div>

<p>Hormat Kami,<br>
Tim Rind Tea</p>

{{ config('app.name') }} © {{ date('Y') }}
@endsection

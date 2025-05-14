@extends('emails.layouts.mail')

@section('content')
<h1 style="font-size: 24px; margin-bottom: 20px;">Pesan Baru dari Form Kontak</h1>

<div style="background: #f8f9fa; border-left: 4px solid #f9ca7a; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <div style="margin-bottom: 10px;">
        <strong style="display: block; color: #212529;">Nama:</strong>
        <p style="margin: 5px 0;">{{ $name }}</p>
    </div>
    <div style="margin-bottom: 10px;">
        <strong style="display: block; color: #212529;">Email:</strong>
        <p style="margin: 5px 0;">{{ $email }}</p>
    </div>
    <div style="margin-bottom: 0;">
        <strong style="display: block; color: #212529;">No. Telepon:</strong>
        <p style="margin: 5px 0;">{{ $phone }}</p>
    </div>
</div>

<h2 style="font-size: 20px; color: #212529; margin-top: 20px;">Pesan:</h2>
<p style="background: #f8f9fa; padding: 15px; border-radius: 4px;">{{ $message }}</p>

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

<p style="color: #6c757d; font-style: italic;">Email ini dikirim secara otomatis dari website Rind Tea</p>

{{ config('app.name') }} © {{ date('Y') }}
@endsection

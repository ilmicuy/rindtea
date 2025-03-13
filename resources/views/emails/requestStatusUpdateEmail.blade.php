@extends('emails.layouts.mail')

@section('content')
<h1 style="font-size: 24px; margin-bottom: 20px;">Status Update untuk {{ $type }}</h1>

<div style="background: #f8f9fa; border-left: 4px solid #f9ca7a; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <h2 style="margin-top: 0; color: #212529;">Status: {{ $statusName }}</h2>
    @if ($type == "Request Bahan Baku")
        <p style="margin-bottom: 0;">Bahan Baku: {{ $modelRequest->ingredient->nama_bahan_baku }}<br>
        Jumlah: {{ $modelRequest->qty_request }}</p>
    @else
        <p style="margin-bottom: 0;">Produk: {{ $modelRequest->product->name }}<br>
        Jumlah: {{ $modelRequest->qty_requested }}</p>
    @endif
</div>

<p>Halo {{ $user->name }},</p>

@if ($type == "Request Bahan Baku")
    <p>{{ $type }} untuk <strong>{{ $modelRequest->ingredient->nama_bahan_baku }}</strong> dengan jumlah <strong>{{ $modelRequest->qty_request }}</strong> telah <strong>{{ $statusName }}</strong>.</p>
@else
    <p>{{ $type }} untuk <strong>{{ $modelRequest->product->name }}</strong> dengan jumlah <strong>{{ $modelRequest->qty_requested }}</strong> telah <strong>{{ $statusName }}</strong>.</p>
@endif

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ config('app.url') }}"
       style="background-color: #f9ca7a;
              color: #212529;
              padding: 12px 25px;
              text-decoration: none;
              border-radius: 4px;
              display: inline-block;
              font-weight: bold;">
        Lihat Detail
    </a>
</div>

<p>Terima Kasih.</p>

{{ config('app.name') }} © {{ date('Y') }}
@endsection

@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Message Detail
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p><strong>From:</strong> {{ $message->sender->name }}</p>
                        <p><strong>Received At:</strong> {{ \Carbon\Carbon::parse($message->created_at)->format('d M Y H:i:s') }}</p>
                        <p><strong>Message:</strong></p>
                        <p>{{ $message->message }}</p>
                        <a href="{{ route('inbox.index') }}" class="btn btn-primary">Back to Inbox</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

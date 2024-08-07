@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Inbox
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <a href="{{ route('inbox.create') }}" class="mb-3 btn btn-primary">
                            Kirim Pesan
                        </a>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sender</th>
                                        <th>Message</th>
                                        <th>Received At</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($inbox as $key => $message)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $message->sender->name }}</td>
                                            <td><a href="{{ route('inbox.show', $message->id) }}">{{ Str::limit($message->message, 50) }}</a></td>
                                            <td>{{ \Carbon\Carbon::parse($message->created_at)->format('d M Y H:i:s') }}</td>
                                            <td>
                                                @if($message->is_read)
                                                    <span class="badge badge-success">Read</span>
                                                @else
                                                    <span class="badge badge-warning">Unread</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No messages found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $inbox->links('pagination::bootstrap-4')  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

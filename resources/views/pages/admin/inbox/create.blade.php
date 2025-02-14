@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Compose Message
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('inbox.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="receiver_id">To</label>
                                <select name="receiver_id" id="receiver_id" class="form-control" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

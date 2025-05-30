@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Create Menu
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('menu.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tagline" class="form-label">tagline</label>
                                        <input type="text" class="form-control" id="tagline" name="tagline" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="thumbnail" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
                                    </div>
                                </div>
                                <div class="">
                                    <a class="btn btn-secondary" href="{{ route('menu') }}">
                                        {{ __('Cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary"> Save</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

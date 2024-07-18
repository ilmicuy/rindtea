@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Create Hero Section
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('herosection.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="span" class="form-label">Span</label>
                                        <input type="text" class="form-control" id="span" name="span"
                                            autocomplete="span" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="heading" class="form-label">Heading</label>
                                        <input type="text" class="form-control" id="heading" name="heading" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="subheading" class="form-label">Subheading</label>
                                        <input type="text" class="form-control" id="subheading" name="subheading">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="banner" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="banner" name="banner" required>
                                    </div>
                                </div>
                                <div class="">
                                    <a class="btn btn-secondary" href="{{ route('herosection') }}">
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

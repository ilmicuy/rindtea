{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('About Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="{{ route('about.update', $about) }}" class="mt-6 space-y-6"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <x-input-label for="name" :value="__('name')" />
                                        <x-text-input id="name" name="name" type="text"
                                            class="block w-full mt-1" autocomplete="name" :value="old('name', $about->name)" />
                                    </div>
                                    <div>
                                        <x-input-label for="thumbnail" :value="__('image')" />
                                        <x-text-input id="thumbnail" name="thumbnail" type="file"
                                            class="block w-full mt-1" autofocus autocomplete="thumbnail" />
                                        <img class="mt-3" src="{{ Storage::url($about->thumbnail) }}"
                                            style="max-width: 250px;" />
                                    </div>

                                    <div class="flex flex-col gap-y-5">
                                        <x-input-label for="keypoints" :value="__('keypoints')" />
                                        @forelse ($about->keypoints as $keypoint)
                                            <textarea name="keypoints[]" id="keypoints" cols="30" rows="3"
                                                class="border border-slate-300 rounded-xl w-full">{{ $keypoint->keypoint }}</textarea>
                                        @empty
                                            <p>Tidak ada data keypoint</p>
                                        @endforelse
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <a class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                            style="text-decoration: none;" href="{{ route('about') }}">
                                            {{ __('Cancel') }}
                                        </a>
                                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Edit About
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('about.update', $about) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="name" value="{{ $about->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="thumbnail" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                                    </div>
                                    <img src="{{ Storage::url($about->thumbnail) }}" class="img-fluid mb-3" alt=""
                                        width="200px">
                                </div>
                                <div class="col-md-12">
                                    @forelse ($about->keypoints as $keypoint)
                                        <div class="mb-3">
                                            <textarea name="keypoints[]" id="keypoints" cols="30" rows="3" class="form-control">{{ $keypoint->keypoint }}</textarea>
                                        </div>
                                    @empty
                                        <p>Tidak ada data keypoint</p>
                                    @endforelse
                                </div>
                                <div class="">
                                    <a class="btn btn-secondary" href="{{ route('about') }}">
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

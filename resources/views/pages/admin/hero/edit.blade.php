{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Hero Section Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="{{ route('herosection.update', $hero) }}"
                                    class="mt-6 space-y-6" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <x-input-label for="span" :value="__('span')" />
                                        <x-text-input id="span" name="span" type="text"
                                            class="block w-full mt-1" autocomplete="span" :value="old('span', $hero->span)" />
                                    </div>
                                    <div>
                                        <x-input-label for="heading" :value="__('heading')" />
                                        <x-text-input id="heading" name="heading" type="text"
                                            class="block w-full mt-1" autocomplete="heading" :value="old('heading', $hero->heading)" />
                                    </div>
                                    <div>
                                        <x-input-label for="subheading" :value="__('subheading')" />
                                        <x-text-input id="subheading" name="subheading" type="text"
                                            class="block w-full mt-1" autocomplete="subheading" :value="old('subheading', $hero->subheading)" />
                                    </div>
                                    <div>
                                        <x-input-label for="banner" :value="__('image')" />
                                        <x-text-input id="banner" name="banner" type="file"
                                            class="block w-full mt-1" autocomplete="banner" />
                                        <img class="mt-3" src="{{ Storage::url($hero->banner) }}"
                                            style="max-width: 250px;" />
                                    </div>


                                    <div class="flex items-center gap-4">
                                        <a class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                            style="text-decoration: none;" href="{{ route('herosection') }}">
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
            Edit Hero Section
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('herosection.update', $hero) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="span" class="form-label">Span</label>
                                        <input type="text" class="form-control" id="span" name="span" value="{{ $hero->span }}"
                                            autocomplete="span" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="heading" class="form-label">Heading</label>
                                        <input type="text" class="form-control" id="heading" name="heading" required value="{{ $hero->heading }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="subheading" class="form-label">Subheading</label>
                                        <textarea type="text" class="form-control" id="subheading" name="subheading" >{{ $hero->subheading  }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="banner" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="banner" name="banner" >
                                    </div>
                                    <img src="{{ Storage::url($hero->banner) }}" class="img-fluid" alt="" width="200px">
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

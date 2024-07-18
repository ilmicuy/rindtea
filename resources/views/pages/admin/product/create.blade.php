{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Product Create') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="{{ route('product.store') }}" class="mt-6 space-y-6"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <x-input-label for="name" :value="__('Product Name')" />
                                        <x-text-input id="name" name="name" type="text"
                                            class="block w-full mt-1" autocomplete="name" :value="old('name')" />
                                    </div>
                                    <div>
                                        <x-input-label for="quantity" :value="__('Quantity')" />
                                        <x-text-input id="quantity" name="quantity" type="number"
                                            class="block w-full mt-1" autocomplete="quantity" :value="old('quantity')"/>
                                    </div>
                                    <div>
                                        <x-input-label for="quality" :value="__('Quality')" />
                                        <x-text-input id="quality" name="quality" type="text"
                                            class="block w-full mt-1" autocomplete="quality" :value="old('quality')" />
                                    </div>
                                    <div>
                                        <x-input-label for="check" :value="__('Check')" />
                                        <x-text-input id="check" name="check" type="text"
                                            class="block w-full mt-1" autocomplete="check" :value="old('check')"/>
                                    </div>
                                    <div>
                                        <x-input-label for="country_of_origin" :value="__('Country Of Origin')" />
                                        <x-text-input id="country_of_origin" name="country_of_origin" type="text"
                                            class="block w-full mt-1" autocomplete="country_of_origin" :value="old('country_of_origin')"/>
                                    </div>
                                    <div>
                                        <x-input-label for="price" :value="__('Price')" />
                                        <x-text-input id="price" name="price" type="number"
                                            class="block w-full mt-1" autocomplete="price" :value="old('price')"/>
                                    </div>
                                    <div>
                                        <x-input-label for="weight" :value="__('Weight')" />
                                        <x-text-input id="weight" name="weight" type="text"
                                            class="block w-full mt-1" autocomplete="weight" :value="old('weight')"/>
                                    </div>
                                    <div>
                                        <x-input-label for="thumb_description" :value="__('Description')" />
                                        <textarea id="thumb_description" name="thumb_description"
                                            class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                            autocomplete="thumb_description"></textarea>
                                    </div>
                                    <div>
                                        <x-input-label for="photos" :value="__('Photos')" />
                                        <x-text-input id="photos" name="photos" type="file"
                                            class="block w-full mt-1" autocomplete="photos" />
                                    </div>

                                    <div class="flex items-center gap-4">
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
            Create Product
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="quality" class="form-label">Quality</label>
                                        <input type="text" class="form-control" id="quality" name="quality">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="check" class="form-label">Check</label>
                                        <input type="text" class="form-control" id="check" name="check">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="country_of_origin" class="form-label">Country_of_origin</label>
                                        <input type="text" class="form-control" id="country_of_origin"
                                            name="country_of_origin">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="price" name="price">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="weight" class="form-label">Weight</label>
                                        <input type="number" class="form-control" id="weight" name="weight">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="photos" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="photos" name="photos" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="thumb_description" class="form-label">Description</label>
                                        <textarea name="thumb_description" id="thumb_description" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="">
                                    <a class="btn btn-secondary" href="{{ route('product') }}">
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

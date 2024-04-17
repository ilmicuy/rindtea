<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Product Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="{{ route('product.update', $item->id) }}"
                                    class="mt-6 space-y-6" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <x-input-label for="categories_id" :value="__('Category')" />
                                        <select id="categories_id" name="categories_id"
                                            class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">Choose Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $item->categories_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <x-input-label for="name" :value="__('Product Name')" />
                                        <x-text-input id="name" name="name" type="text"
                                            class="block w-full mt-1" autocomplete="name" :value="old('name', $item->name)" />
                                    </div>
                                    <div>
                                        <x-input-label for="quantity" :value="__('Quantity')" />
                                        <x-text-input id="quantity" name="quantity" type="number"
                                            class="block w-full mt-1" autocomplete="quantity" :value="old('quantity', $item->quantity)" />
                                    </div>
                                    <div>
                                        <x-input-label for="quality" :value="__('Quality')" />
                                        <x-text-input id="quality" name="quality" type="text"
                                            class="block w-full mt-1" autocomplete="quality" :value="old('quality', $item->quality)" />
                                    </div>
                                    <div>
                                        <x-input-label for="check" :value="__('Check')" />
                                        <x-text-input id="check" name="check" type="text"
                                            class="block w-full mt-1" autocomplete="check" :value="old('check', $item->check)" />
                                    </div>
                                    <div>
                                        <x-input-label for="country_of_origin" :value="__('Country Of Origin')" />
                                        <x-text-input id="country_of_origin" name="country_of_origin" type="text"
                                            class="block w-full mt-1" autocomplete="country_of_origin"
                                            :value="old('country_of_origin', $item->country_of_origin)" />
                                    </div>
                                    <div>
                                        <x-input-label for="price" :value="__('Price')" />
                                        <x-text-input id="price" name="price" type="number"
                                            class="block w-full mt-1" autocomplete="price" :value="old('price', $item->price)" />
                                    </div>
                                    <div>
                                        <x-input-label for="weight" :value="__('Weight')" />
                                        <x-text-input id="weight" name="weight" type="text"
                                            class="block w-full mt-1" autocomplete="weight" :value="old('weight', $item->weight)" />
                                    </div>
                                    <div>
                                        <x-input-label for="thumb_description" :value="__('Thumbnail Description')" />
                                        <textarea id="thumb_description" name="thumb_description"
                                            class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                            autocomplete="thumb_description">{{ $item->thumb_description }}</textarea>
                                    </div>
                                    <div>
                                        <x-input-label for="short_description" :value="__('Short Description')" />
                                        <textarea id="editor2" name="short_description"
                                            class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                            autocomplete="short_description">{{ $item->short_description }}</textarea>
                                    </div>
                                    <div>
                                        <x-input-label for="long_description" :value="__('Long Description')" />
                                        <textarea id="editor3" name="long_description"
                                            class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                            autocomplete="long_description">{{ $item->long_description }}</textarea>
                                    </div>
                                    <div>
                                        <x-input-label for="photos" :value="__('Photos')" />
                                        <x-text-input id="photos" name="photos" type="file"
                                            class="block w-full mt-1" autocomplete="photos" />
                                        <img class="mt-3" src="{{ Storage::url($item->photos) }}"
                                            style="max-width: 250px;" />
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <a class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                            style="text-decoration: none;" href="{{ route('product') }}">
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
</x-app-layout>

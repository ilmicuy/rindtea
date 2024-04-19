<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Reviews Edit') }}
        </h2>
    </x-slot>

    <form method="post" action="{{ route('review.update', $item->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <x-input-label for="description_review" :value="__('Description Review')" />
                                        <textarea id="description_review" name="description_review" cols="30" rows="10"
                                            class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                            autocomplete="description_review">{{ $item->description_review }}</textarea>
                                    </div>
                                    <div class="flex items-center mt-3 gap-4">
                                        <a class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                            style="text-decoration: none;" href="{{ route('reviews') }}">
                                            {{ __('Cancel') }}
                                        </a>
                                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>

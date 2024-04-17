<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Transaction Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="{{ route('transaction.update', $item->transaction->id) }}"
                                    class="mt-6 space-y-6" enctype="multipart/form-data">
                                    @csrf
                                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                        {{ __('Transaction') }}
                                    </h2>
                                    <hr>

                                    <div>
                                        <x-input-label for="name" :value="__('Product Name')" />
                                        <x-text-input id="name" name="name" type="text" readonly
                                            class="block w-full mt-1" autocomplete="name" :value="old('name', $item->product->name)" />
                                    </div>
                                    <div>
                                        <x-input-label for="qty" :value="__('Product Quantity')" />
                                        <x-text-input id="qty" name="qty" type="text" readonly
                                            class="block w-full mt-1" autocomplete="qty" :value="old('qty', $item->qty)" />
                                    </div>
                                    <div>
                                        <x-input-label for="transaction_status" :value="__('Transaction Status')" />
                                        <select id="transaction_status" name="transaction_status" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="pending" @if(old('transaction_status', $item->transaction->transaction_status) == 'pending') selected @endif>Pending</option>
                                            <option value="completed" @if(old('transaction_status', $item->transaction->transaction_status) == 'completed') selected @endif>Completed</option>
                                            <option value="failed" @if(old('transaction_status', $item->transaction->transaction_status) == 'failed') selected @endif>Failed</option>
                                        </select>
                                    </div>
                                    
                                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                        {{ __('Transaction Detail') }}
                                        <hr>
                                    </h2>
                                    <div>
                                        <x-input-label for="first_name" :value="__('First Name')" />
                                        <x-text-input id="first_name" name="first_name" type="text" readonly
                                            class="block w-full mt-1" autocomplete="first_name" :value="old('first_name', $item->first_name)" />
                                    </div>
                                    <div>
                                        <x-input-label for="last_name" :value="__('Last Name')" />
                                        <x-text-input id="last_name" name="last_name" type="text" readonly
                                            class="block w-full mt-1" autocomplete="last_name" :value="old('last_name', $item->last_name)" />
                                    </div>
                                    <div>
                                        <x-input-label for="address" :value="__('Address')" />
                                        <x-text-input id="address" name="address" type="text" readonly
                                            class="block w-full mt-1" autocomplete="address" :value="old('address', $item->address)" />
                                    </div>
                                    <div>
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input id="city" name="city" type="text" readonly
                                            class="block w-full mt-1" autocomplete="city" :value="old('city', $item->city)" />
                                    </div>
                                    <div>
                                        <x-input-label for="country" :value="__('Country')" />
                                        <x-text-input id="country" name="country" type="text" readonly
                                            class="block w-full mt-1" autocomplete="country" :value="old('country', $item->country)" />
                                    </div>
                                    <div>
                                        <x-input-label for="zip_code" :value="__('Zip Code')" />
                                        <x-text-input id="zip_code" name="zip_code" type="text" readonly
                                            class="block w-full mt-1" autocomplete="zip_code" :value="old('zip_code', $item->zip_code)" />
                                    </div>
                                    <div>
                                        <x-input-label for="phone" :value="__('Mobile Phone')" />
                                        <x-text-input id="phone" name="phone" type="text" readonly
                                            class="block w-full mt-1" autocomplete="phone" :value="old('phone', $item->phone)" />
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

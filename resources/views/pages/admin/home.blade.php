<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-4 ">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
        <div class="py-3">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-4 pb-3 ">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <a href="{{ route('product') }}" style="text-decoration: none">
                        <div class="bg-white rounded-lg shadow-md">
                            <div class="p-4">
                                <h1 class="pb-2">Total Product</h1>
                                <div class="text-gray-900 dark:text-gray-100">
                                    {{ $product }}
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('transaction') }}" style="text-decoration: none">
                        <div class="bg-white rounded-lg shadow-md">
                            <div class="p-4">
                                <h1 class="pb-2">Revenue</h1>
                                <div class="text-gray-900 dark:text-gray-100">
                                    Rp.{{ number_format($revenue) }}
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('transaction') }}" style="text-decoration: none">
                        <div class="bg-white rounded-lg shadow-md">
                            <div class="p-4">
                                <h1 class="pb-2">Pending Transaction</h1>
                                <div class="text-gray-900 dark:text-gray-100">
                                    {{ $transactionPending }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

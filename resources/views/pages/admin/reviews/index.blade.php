<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Transaction History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="">
                                    <x-text-input id="weight" name="weight" type="text" placeholder="Search" class="block w-52 m-3" autocomplete="weight" />
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Review</th>
                                                <th>Nama User</th>
                                                <th>Product</th>
                                                <th>Rating</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $key => $review)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</td>
                                                    <td>{{ $review->user->name }}</td>
                                                    <td>{{ $review->product->name }}</td>
                                                    <td>{{ $review->rating}} Bintang</td>                                                    
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('reviews.edit', $review->id) }}" class="mb-1 mr-1 btn btn-primary">
                                                                Edit
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- {{$query->links()}} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>


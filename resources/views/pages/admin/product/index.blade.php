<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('product.create') }}" class="mb-3 btn btn-primary">
                                    + Tambah Product Baru
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Quality</th>
                                                <th>Country Of Origin</th>
                                                <th>Min Weight</th>
                                                <th>Photo</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $key => $product)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->category->name }}</td>
                                                    <td>Rp.{{ number_format($product->price) }}</td>
                                                    <td>{{ $product->quantity }} Pcs</td>
                                                    <td>{{ $product->quality }}</td>
                                                    <td>{{ $product->country_of_origin }}</td>
                                                    <td>{{ $product->weight }}</td>
                                                    <td><img src="{{ Storage::url($product->photos) }}" style="max-width: 40px;"></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('product.edit', $product->id) }}" class="mb-1 mr-1 btn btn-primary">
                                                                Edit
                                                            </a>
                                                            <form id="deleteForm{{ $product->id }}" action="{{ route('product.destroy', $product->id) }}" method="POST">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="submit" class="mb-1 mr-1 btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{$query->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>


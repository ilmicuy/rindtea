@extends('layouts.app-old')
@section('content')

    @hasanyrole('marketing')
    <!-- Modal Buat Request Product -->
    <div class="modal fade" id="buatRequestProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Request Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('requestProduct.store') }}" id="buatRequestProductForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-4">
                          <label>Pilih Product</label>
                          <select class="form-control" name="pilih_product">
                                <option value="">== Pilih Product ==</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                          </select>
                        </div>

                        <div class="form-group mb-4">
                          <label>Quantity Permintaan</label>
                          <input type="number" name="qty_requested" class="form-control" min="1" value="1">
                        </div>

                        <div class="form-group">
                          <label>Notes</label>
                          <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#buatRequestProductForm').submit()">Buat Reqeust</button>
                </div>
            </div>
        </div>
    </div>
    @endhasanyrole


    <div class="main-content">
        <div class="title">
            Request Product
        </div>
        <div class="content-wrapper">
            @if ($hasLowStock)
                <div class="alert alert-danger">
                    <h4 class="alert-heading">Produk Hampir Habis! (stok dibawah 10)</h4>
                    Mohon untuk melakukan request produk berikut:
                    <ul style="margin-left: 1.2em;">
                        @foreach ($lowStockProducts as $product)
                            <li>{{ $product->name }} - Stok: {{ $product->quantity }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @hasanyrole('marketing')
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#buatRequestProductModal">
                            Buat Request Product
                        </button>
                        @endhasanyrole

                        {{-- <a href="{{ route('ingredient.create') }}" class="mb-3 btn btn-primary">
                            Buat Request Product
                        </a> --}}
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        {{-- <th>Stok Tersedia</th> --}}
                                        <th>Quantity Permintaan</th>
                                        <th>Notes</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($productRequest as $key => $req)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $req->product->name }}</td>
                                            {{-- <td>{{ $req->product->quantity }}</td> --}}
                                            <td>{{ $req->qty_requested }} pax</td>
                                            <td>{{ $req->notes }}</td>
                                            <td>{{ ucwords($req->status) }}</td>

                                            <td width="100px">
                                                @hasanyrole('marketing')
                                                @if ($req->status == 'processing')
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-success btn-sm" onclick="statusEdit({{ $req->id }}, 'confirm')">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" onclick="statusEdit({{ $req->id }}, 'cancel')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                        {{-- <form id="deleteForm{{ $ingredient->id }}"
                                                            action="{{ route('ingredient.destroy', $ingredient->id) }}"
                                                            method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </form> --}}

                                                    </div>
                                                @endif
                                                @endhasanyrole

                                                @hasanyrole('produksi')
                                                @if ($req->status == 'pending')
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-success btn-sm" onclick="statusEdit({{ $req->id }}, 'processing')">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" onclick="statusEdit({{ $req->id }}, 'cancel')">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                        {{-- <form id="deleteForm{{ $ingredient->id }}"
                                                            action="{{ route('ingredient.destroy', $ingredient->id) }}"
                                                            method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </form> --}}

                                                    </div>
                                                @endif
                                                @endhasanyrole
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <p>Tidak ada data terbaru</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $productRequest->links('pagination::bootstrap-4')  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
<script>

function statusEdit(id, status)
{
    if(status == 'processing'){
        $.ajax({
            type: 'GET',
            url: "/request-product/" + id,
            cache: false,
            success: function (response) {
                let data = response.data;
                console.log(data);

                if(data.kekurangan_bahan.length > 0){
                    let kekurangan_bahan_html = ``;

                    $.each(data.kekurangan_bahan, function(index, val) {
                        kekurangan_bahan_html += `
                        <tr>
                            <td>${val.bahan_baku}</td>
                            <td>${val.kekurangan_bahan_baku} ${val.satuan}</td>
                        </tr>
                        `;
                    });

                    let kekurangan_bahan_table = `
                        <p>Produk tidak dapat ditambah karena stop bahan baku tidak cukup.</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Bahan Baku</th>
                                    <th>Kekurangannya</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${kekurangan_bahan_html}
                            </tbody>
                        </table>
                    `;


                    Swal.fire({
                        title: "Stok Bahan Baku Tidak Mencukupi!",
                        html: kekurangan_bahan_table,
                        icon: "error",
                        showCancelButton: false,
                    });

                }else{
                    Swal.fire({
                        title: `Proses penambahan Stok Produk?`,
                        html: `Apakah anda yakin ingin memproses menambahkan stok produk <b>"${data.request_product.product.name}"</b> sebanyak <b>${data.request_product.qty_requested} pax</b>`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya"
                    }).then((result) => {

                        if (result.isConfirmed) {
                            confirmAction(id, 'processing');
                        }
                    });
                }
                // displayTrackingResult(response);
            },
            error: function (data) {
                console.log('error:', data);
            }
        });

    }else if(status == 'confirm'){
        Swal.fire({
            title: `Konfirmasi Penambahan Stok Produk?`,
            html: `Apakah anda yakin ingin menambahkan stok produk?"`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya"
        }).then((result) => {

            if (result.isConfirmed) {
                confirmAction(id, 'confirm');
            }
        });
    }else{
        Swal.fire({
            title: `Batal Request Penambahan Stok Produk?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya"
        }).then((result) => {
            if (result.isConfirmed) {
                confirmAction(id, 'cancel');
            }
        });
    }

}

function confirmAction(id, action)
{
    $.ajax({
        type: 'POST',
        url: "{{ route('requestProduct.statusEdit') }}",
        data: {
            id: id,
            action: action
        },
        cache: false,
        success: function (response) {
            let actionName = '';
            switch(action){
                case 'confirm':
                    actionName = 'Konfirmasi';
                    break;
                case 'processing':
                    actionName = 'Memproses';
                    break;
                default:
                    actionName = 'Membatalkan';
                    break;
            }

            Swal.fire({
                title: `Berhasil ${actionName} Penambahan Stok Produk!`,
                icon: "success"
            }).then((result) => {
                window.location.reload();
            });

            console.log(response);
        },
        error: function (data) {
            console.log('error:', data);
        }
    });
}
</script>
@endpush

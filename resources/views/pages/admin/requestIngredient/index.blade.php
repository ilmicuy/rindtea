@extends('layouts.app-old')
@section('content')


@hasanyrole('produksi')
<!-- Modal Buat Request Product -->
<div class="modal fade" id="buatRequestIngredientModal" tabindex="-1" aria-labelledby="buatRequestIngredientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Request Bahan Baku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('requestIngredient.store') }}" id="buatRequestIngredientForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label>Pilih Bahan Baku</label>
                        <select class="form-control" name="pilih_bahan_baku">
                            <option value="">== Pilih Bahan Baku ==</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->nama_bahan_baku }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label>Quantity Permintaan</label>
                        <input type="number" name="qty_request" class="form-control" min="1" value="1">
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="validateAndSubmitForm()">Buat Request</button>
            </div>
        </div>
    </div>
</div>
@endhasanyrole

    <div class="main-content">
        <div class="title">
            Request Bahan Baku
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                @if ($hasLowStock)
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Bahan Baku Hampir Habis! (stok rendah)</h4>
                        Mohon untuk melakukan pengadaan bahan baku berikut:
                        <ul style="margin-left: 1.2em;">
                            @foreach ($lowStockIngredients as $ingredient)
                                <li>{{ $ingredient->nama_bahan_baku }} - Stok: {{ $ingredient->qty }} {{ $ingredient->satuan }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        @hasanyrole('produksi')
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#buatRequestIngredientModal">
                                Buat Request Bahan Baku
                            </button>
                        @endhasanyrole
                        <div class="table-responsive">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan Baku</th>
                                        <th>Stok Tersedia</th>
                                        <th>Quantity Permintaan</th>
                                        <th>Notes</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse  ($ingredientRequest as $key => $req)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $req->ingredient->nama_bahan_baku }}</td>
                                            <td>{{ $req->ingredient->qty }} {{ $req->ingredient->satuan }}</td>
                                            <td>{{ $req->qty_request }} {{ $req->ingredient->satuan }}</td>
                                            <td>{{ $req->notes }}</td>
                                            <td>
                                                @if ($req->status == "pending")
                                                    @if ($req->approved_by_owner == null)
                                                        Pending Approval Owner
                                                    @else
                                                        {{ ucwords($req->status) }}
                                                    @endif
                                                @else
                                                    {{ ucwords($req->status) }}
                                                @endif
                                            </td>
                                            <td width="100px">
                                                @hasanyrole('produksi')
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

                                                @hasanyrole('keuangan')
                                                @if ($req->status == 'pending')
                                                    @if ($req->approved_by_owner != null)
                                                        <div class="d-flex justify-content-between">
                                                            <button class="btn btn-success btn-sm" onclick="statusEdit({{ $req->id }}, 'processing')">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="statusEdit({{ $req->id }}, 'cancel')">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                                @endhasanyrole

                                                @hasanyrole('owner')
                                                    @if ($req->approved_by_owner == null && $req->status == 'pending')
                                                        <div class="d-flex justify-content-between">
                                                            <button class="btn btn-success btn-sm" onclick="statusEdit({{ $req->id }}, 'owner_approval')">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm" onclick="statusEdit({{ $req->id }}, 'owner_approval_cancel')">
                                                                <i class="fa fa-times"></i>
                                                            </button>
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
                        {{ $ingredientRequest->links('pagination::bootstrap-4')  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
<script>
    function validateAndSubmitForm() {
        // Get form fields
        const bahanBaku = document.querySelector('[name="pilih_bahan_baku"]').value;
        const qtyRequest = document.querySelector('[name="qty_request"]').value;

        // Validate form fields
        if (bahanBaku.trim() === '') {
            alert('Pilih Bahan Baku is required.');
            return;
        }

        if (qtyRequest === '' || isNaN(qtyRequest) || parseInt(qtyRequest) < 1) {
            alert('Quantity Permintaan must be at least 1.');
            return;
        }

        // Submit the form if all validations pass
        document.getElementById('buatRequestIngredientForm').submit();
    }
</script>

<script>

function statusEdit(id, status)
{
    if(status == 'processing'){

        Swal.fire({
            title: `Proses Penambahan Stok Bahan Baku?`,
            html: `Apakah anda yakin ingin memproses penambahan bahan baku`,
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

    } else if(status == 'confirm'){

        Swal.fire({
            title: `Konfirmasi Penambahan Stok Bahan Baku?`,
            html: `Apakah anda yakin ingin menambahkan bahan baku`,
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

    } else if(status == 'owner_approval'){

        Swal.fire({
            title: `Setujui Penambahan Stok Bahan Baku?`,
            html: `Apakah anda yakin ingin menyetujui request bahan baku`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya"
        }).then((result) => {
            if (result.isConfirmed) {
                confirmAction(id, 'owner_approval');
            }
        });

    } else if(status == 'owner_approval_cancel'){

        Swal.fire({
            title: `Batalkan Penambahan Stok Bahan Baku?`,
            html: `Apakah anda yakin ingin membatalkan request bahan baku`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya"
        }).then((result) => {
            if (result.isConfirmed) {
                confirmAction(id, 'owner_approval_cancel');
            }
        });

    } else {
        Swal.fire({
            title: `Batal Request Penambahan Stok Bahan Baku?`,
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
        url: "{{ route('requestIngredient.statusEdit') }}",
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
                case 'owner_approval':
                    actionName = 'Menyetujui Request';
                    break;
                case 'owner_approval_cancel':
                    actionName = 'Menolak Request';
                    break;
                default:
                    actionName = 'Membatalkan';
                    break;
            }

            Swal.fire({
                title: `Berhasil ${actionName} Penambahan Stok Bahan Baku!`,
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

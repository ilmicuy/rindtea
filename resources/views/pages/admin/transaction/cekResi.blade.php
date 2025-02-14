@extends('layouts.app-old')
@section('content')
    <div class="main-content">
        <div class="title">
            Cek Resi
        </div>
        <div class="content-wrapper">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-4">
                          <label>Pilih Kurir</label>
                          <select name="courier" class="form-control">
                            <option value="jne">JNE</option>
                          </select>
                        </div>

                        <div class="form-group mb-4">
                          <label>No. Resi (AWB)</label>
                          <input type="text" name="awb" id="awb" class="form-control" placeholder="Masukkan Nomor Resi">
                        </div>

                        <div>
                            <button class="btn btn-success" onclick="cekResi()">Cek Resi</button>
                        </div>

                        <div id="tracking-result" class="mt-5"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function cekResi() {
        if ($("input[name='awb']").val() == "") {
            alert('Silahkan isi Nomor Resi Terlebih dahulu!');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: "{{ route('cekResiProcess') }}",
            data: {
                courier: $("select[name='courier']").val(),
                awb: $("input[name='awb']").val(),
            },
            cache: false,
            success: function (response) {
                console.log(response);
                displayTrackingResult(response);
            },
            error: function (data) {
                console.log('error:', data);
            }
        });
    }

    function displayTrackingResult(response) {
        if(response.status === 200) {
            const data = response.data;
            let html = `
                <div class="card">
                    <div class="card-header">
                        Tracking Result
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Summary</h5>
                        <p><strong>AWB:</strong> ${data.summary.awb}</p>
                        <p><strong>Courier:</strong> ${data.summary.courier}</p>
                        <p><strong>Service:</strong> ${data.summary.service}</p>
                        <p><strong>Status:</strong> ${data.summary.status}</p>
                        <p><strong>Date:</strong> ${data.summary.date}</p>
                        <p><strong>Description:</strong> ${data.summary.desc}</p>
                        <p><strong>Weight:</strong> ${data.summary.weight}</p>

                        <h5 class="card-title">Detail</h5>
                        <p><strong>Origin:</strong> ${data.detail.origin}</p>
                        <p><strong>Destination:</strong> ${data.detail.destination}</p>
                        <p><strong>Shipper:</strong> ${data.detail.shipper}</p>
                        <p><strong>Receiver:</strong> ${data.detail.receiver}</p>

                        <h5 class="card-title">History</h5>
                        <ul class="list-group">
            `;
            data.history.forEach(function (item) {
                html += `<li class="list-group-item">${item.date} - ${item.desc}</li>`;
            });
            html += `
                        </ul>
                    </div>
                </div>
            `;
            $('#tracking-result').html(html);
        } else {
            $('#tracking-result').html('<div class="alert alert-danger">Error: ' + response.message + '</div>');
        }
    }
</script>
@endpush

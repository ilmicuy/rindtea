@extends('layouts.home')

@section('content')

<style>
    #map {
        height: 500px;
        width: 100%;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
</style>

<!-- Link to Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Single Page Header start -->
<div class="single-page-header py-5" style="background-color: var(--primary);" data-aos="fade-down">
    <div class="container">
        <h1 class="page-title mb-3">Alamat Pengiriman</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/checkout">Checkout</a></li>
                <li class="breadcrumb-item active" aria-current="page">Alamat</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Single Page Header End -->

<div class="modern-checkout py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="checkout-card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('address.store') }}" class="address-form">
                            @csrf
                            <!-- Label Options -->
                            <div class="mb-4">
                                <h5 class="mb-3">Jenis Alamat</h5>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input id="kantor" class="form-check-input" type="radio" name="label" value="Kantor">
                                        <label class="form-check-label" for="kantor">
                                            <i class="fas fa-building me-2"></i>Kantor
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input id="rumah" class="form-check-input" type="radio" name="label" value="Rumah">
                                        <label class="form-check-label" for="rumah">
                                            <i class="fas fa-home me-2"></i>Rumah
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Info -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullname" class="form-label">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('fullname') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">No Telepon</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="number" id="phone" name="phone" class="form-control" placeholder="Masukkan nomor telepon" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Info -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province_id" class="form-label">Provinsi</label>
                                        <select id="province_id" name="province_id" class="form-select select2">
                                            <option value="" disabled selected>Pilih Provinsi</option>
                                            @foreach ($provinces as $province)
                                            <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="regency_id" class="form-label">Kota/Kabupaten</label>
                                        <select id="regency_id" name="regency_id" class="form-select select2" disabled>
                                            <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="province_name">
                            <input type="hidden" name="regency_name">

                            <!-- Additional Info -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="postcode" class="form-label">Kode Pos</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="number" id="postcode" name="postcode" class="form-control" placeholder="Masukkan kode pos" value="{{ old('postcode') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="distance_in_km" class="form-label">Jarak (KM)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-route"></i></span>
                                            <input type="number" id="distance_in_km" name="distance_in_km" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Details -->
                            <div class="form-group mb-4">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map"></i></span>
                                    <textarea id="address" name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <!-- Map Coordinates -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude" class="form-label">Latitude</label>
                                        <input type="number" id="latitude" name="latitude" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude" class="form-label">Longitude</label>
                                        <input type="number" id="longitude" name="longitude" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Map Section -->
                            <div class="mb-4">
                                <h5 class="mb-3">
                                    <i class="fas fa-map-marked-alt me-2"></i>
                                    Pilih Lokasi di Peta
                                </h5>
                                <div id="map" class="rounded-3 border border-1 border-light"></div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="button" onclick="window.location='/checkout';" class="btn btn-outline-danger px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    @if($errors->any())
        let errorMessages = '';
        @foreach ($errors->all() as $error)
            errorMessages += `<li style="list-style-position: inside; padding-left: 0;">{{ ucwords($error) }}</li>`;
        @endforeach

        Swal.fire({
            title: 'Terjadi Kesalahan!',
            html: `<ul>${errorMessages}</ul>`,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif

    let map;
    let marker;
    const sellerLocation = {
        lat: -6.862265474370653,
        lng: 107.5936457665463
    };
    let maxDistanceKm = 10;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: sellerLocation,
            zoom: 14,
            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [{"color": "#242f3e"}]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#746855"}]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [{"color": "#242f3e"}]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#d59563"}]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [{"color": "#38414e"}]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry.stroke",
                    "stylers": [{"color": "#212a37"}]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#9ca5b3"}]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{"color": "#17263c"}]
                }
            ]
        });

        // Seller marker with custom icon
        new google.maps.Marker({
            position: sellerLocation,
            map: map,
            title: 'Lokasi Penjual',
            icon: {
                url: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
            }
        });

        // Add delivery radius circle
        new google.maps.Circle({
            map: map,
            radius: 10000, // 10 km
            fillColor: '#AA0000',
            strokeColor: '#AA0000',
            strokeOpacity: 0.5,
            fillOpacity: 0.2,
            center: sellerLocation,
            clickable: false
        });

        // User location marker with custom icon
        let userMarker = new google.maps.Marker({
            map: map,
            title: 'Lokasi Anda',
            icon: {
                url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            }
        });

        // Click listener for map
        map.addListener("click", (mapsMouseEvent) => {
            let lat = mapsMouseEvent.latLng.lat();
            let lng = mapsMouseEvent.latLng.lng();

            let distanceInKm = calculateDistanceInKm(sellerLocation.lat, sellerLocation.lng, lat, lng);

            userMarker.setPosition(mapsMouseEvent.latLng);
            userMarker.setTitle(`Lat: ${lat}, Lng: ${lng}`);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('distance_in_km').value = distanceInKm;
        });
    }

    function calculateDistanceInKm(lat1, lon1, lat2, lon2) {
        const earthRadius = 6371;
        const dLat = degreesToRadians(lat2 - lat1);
        const dLon = degreesToRadians(lon2 - lon1);

        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(degreesToRadians(lat1)) * Math.cos(degreesToRadians(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = earthRadius * c;

        return Math.round(distance * 100) / 100;
    }

    function degreesToRadians(degrees) {
        return degrees * (Math.PI / 180);
    }

    function loadGoogleMapsAPI() {
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfRlVGUObDiUnSXJl7cS0GJw5yHJNSX8&callback=initMap`;
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }

    loadGoogleMapsAPI();

    // Province and City selection handlers
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'default',
            width: '100%',
            placeholder: 'Pilih opsi'
        });

        // Province change handler
        $('#province_id').on('change', function() {
            const provinceId = $(this).val();
            const provinceName = $(this).find(':selected').text();
            $("input[name='province_name']").val(provinceName);

            // Reset and disable city select
            $('#regency_id').empty().prop('disabled', true);
            $('#regency_id').append('<option value="" disabled selected>Loading...</option>');

            // Fetch cities
            $.ajax({
                url: '{{ route("get.cities") }}',
                type: 'GET',
                data: {
                    province_id: provinceId
                },
                success: function(cities) {
                    $('#regency_id').empty().prop('disabled', false);
                    $('#regency_id').append('<option value="" disabled selected>Pilih Kota/Kabupaten</option>');

                    cities.forEach(function(city) {
                        $('#regency_id').append(
                            `<option value="${city.city_id}">${city.type} ${city.city_name}</option>`
                        );
                    });

                    // Refresh Select2
                    $('#regency_id').trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cities:', error);
                    $('#regency_id').empty().prop('disabled', true);
                    $('#regency_id').append('<option value="" disabled selected>Error loading cities</option>');
                }
            });
        });

        // City change handler
        $('#regency_id').on('change', function() {
            const cityName = $(this).find(':selected').text();
            $("input[name='regency_name']").val(cityName);
        });
    });
</script>

<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $('#province_id').on('change', function() {
        //     let id_provinsi = $(this).val();

        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ route('getkota') }}",
        //         data: {
        //             id_provinsi: id_provinsi
        //         },
        //         cache: false,

        //         success: function(msg) {
        //             $('#regency_id').html(msg);

        //         },
        //         error: function(data) {
        //             console.log('error:', data);
        //         }
        //     });
        // });

        // $('#regency_id').on('change', function() {
        //     let id_kota = $(this).val();

        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ route('getkecamatan') }}",
        //         data: {
        //             id_kota: id_kota
        //         },
        //         cache: false,

        //         success: function(msg) {
        //             $('#district_id').html(msg);
        //         },
        //         error: function(data) {
        //             console.log('error:', data);
        //         }
        //     });
        // });
        // $('#district_id').on('change', function() {
        //     let id_kecamatan = $(this).val();

        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ route('getdesa') }}",
        //         data: {
        //             id_kecamatan: id_kecamatan
        //         },
        //         cache: false,

        //         success: function(msg) {
        //             $('#village_id').html(msg);
        //         },
        //         error: function(data) {
        //             console.log('error:', data);
        //         }
        //     });
        // });


    });
</script>
@endpush

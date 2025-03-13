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
    .leaflet-popup-content {
        margin: 8px;
        text-align: center;
    }
    .store-marker {
        background-color: #ffd700;
        border: 2px solid #fff;
        border-radius: 50%;
        width: 12px;
        height: 12px;
    }
    .user-marker {
        background-color: #4a90e2;
        border: 2px solid #fff;
        border-radius: 50%;
        width: 12px;
        height: 12px;
    }

    /* Add these styles for clickable radio cards */
    .radio-card {
        cursor: pointer;
        padding: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .radio-card:hover {
        background-color: rgba(255, 255, 255, 0.08);
        border-color: var(--primary);
    }

    .radio-card.selected {
        background-color: rgba(249, 202, 122, 0.1);
        border-color: var(--primary);
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
                                    <div class="radio-card">
                                        <div class="form-check">
                                            <input id="kantor" class="form-check-input" type="radio" name="label" value="Kantor">
                                            <label class="form-check-label" for="kantor">
                                                <i class="fas fa-building me-2"></i>Kantor
                                            </label>
                                        </div>
                                    </div>
                                    <div class="radio-card">
                                        <div class="form-check">
                                            <input id="rumah" class="form-check-input" type="radio" name="label" value="Rumah">
                                            <label class="form-check-label" for="rumah">
                                                <i class="fas fa-home me-2"></i>Rumah
                                            </label>
                                        </div>
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
    let userMarker;
    const sellerLocation = {
        lat: -6.986817,
        lng: 110.454872
    };
    let maxDistanceKm = 10;

    function initMap() {
        // Initialize map
        map = L.map('map').setView([sellerLocation.lat, sellerLocation.lng], 14);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add seller marker
        const sellerIcon = L.divIcon({
            className: 'store-marker',
            iconSize: [12, 12]
        });
        L.marker([sellerLocation.lat, sellerLocation.lng], {
            icon: sellerIcon
        }).bindPopup('Lokasi Toko').addTo(map);

        // Add delivery radius circle
        L.circle([sellerLocation.lat, sellerLocation.lng], {
            radius: 10000, // 10 km in meters
            color: '#AA0000',
            fillColor: '#AA0000',
            fillOpacity: 0.2,
            weight: 1
        }).addTo(map);

        // Create user marker but don't add to map yet
        const userIcon = L.divIcon({
            className: 'user-marker',
            iconSize: [12, 12]
        });
        userMarker = L.marker([0, 0], {
            icon: userIcon
        });

        // Click listener for map
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            const distanceInKm = calculateDistanceInKm(
                sellerLocation.lat,
                sellerLocation.lng,
                lat,
                lng
            );

            userMarker.setLatLng([lat, lng])
                .bindPopup(`Lokasi Anda<br>Jarak: ${distanceInKm} km`)
                .addTo(map)
                .openPopup();

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

    // Initialize map when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });

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

        // Add this code for radio card functionality
        $('.radio-card').click(function() {
            // Find the radio input within this card
            const radio = $(this).find('input[type="radio"]');

            // Check the radio
            radio.prop('checked', true);

            // Remove selected class from all cards and add to clicked one
            $('.radio-card').removeClass('selected');
            $(this).addClass('selected');
        });

        // Initialize selected state if a radio is already checked
        $('input[type="radio"]:checked').closest('.radio-card').addClass('selected');
    });
</script>

<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@endpush

@extends('layouts.home')

@section('content')
    <style>
        /* Kontainer utama untuk halaman pengiriman */
        .delivery-lokal {
            padding: 2rem 7%;
            background-color: var(--bg);
            color: var(--text-color);
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Styling untuk judul */
        .delivery-lokal h1 {
            font-size: 2rem;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        #map {
            height: 500px;
            width: 100%;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            color: #fff;
            background-color: var(--highlight-color);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn:hover {
            background-color: var(--highlight-hover-color);
        }

        .btn:focus {
            outline: none;
        }

        #result {
            font-size: 18px;
            color: var(--text-color);
            text-align: center;
            margin-top: 1.5rem;
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
    </style>
    <div class="single-page-header">
        <h1 class="page-title">Lokal Kurir</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active">Lokal Kurir</li>
        </ol>
    </div>
    <div class="delivery-lokal">
        <h1 class="mt-5">Pilih Lokasi Pengiriman dan Hitung Ongkos Kirim</h1>
        <div id="map" style="height: 500px; width: 100%;" class="mb-3"></div>
        <input type="hidden" id="user-latitude" name="user-latitude" value="">
        <input type="hidden" id="user-longitude" name="user-longitude" value="">
        <button id="get-location" class="btn btn-primary mb-3">Dapatkan Lokasi Saya</button>
        <button id="calculate-cost" class="btn btn-primary mb-3">Hitung Ongkos Kirim</button>
        <div id="result"></div>
    </div>
@endsection
@push('myscript')
    <script>
        let map;
        let userMarker;
        const sellerLocation = {
            lat: -6.986817,
            lng: 110.454872
        };

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
                radius: 5000, // 5km in meters
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

            // Listen for clicks on the map to place a marker
            map.on('click', function(e) {
                placeMarker(e.latlng);
            });
        }

        function placeMarker(latlng) {
            const lat = latlng.lat;
            const lng = latlng.lng;

            userMarker.setLatLng([lat, lng])
                .bindPopup('Lokasi Anda')
                .addTo(map)
                .openPopup();

            // Update the hidden input fields with the user's location
            $('#user-latitude').val(lat);
            $('#user-longitude').val(lng);

            // Log the values to the console for debugging
            console.log('Latitude:', lat);
            console.log('Longitude:', lng);
        }

        // Initialize map when document is ready
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });

        $('#get-location').click(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // Place marker at user's location
                    placeMarker({ lat, lng });

                    // Center the map on the user's location
                    map.setView([lat, lng], 14);

                }, function(error) {
                    alert('Error getting location. Please check your browser settings.');
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });

        $('#calculate-cost').click(function() {
            const userLatitude = $('#user-latitude').val();
            const userLongitude = $('#user-longitude').val();

            if (!userLatitude || !userLongitude) {
                alert('Silakan dapatkan lokasi Anda terlebih dahulu.');
                return;
            }

            $.ajax({
                url: '/calculate-distance',
                method: 'POST',
                data: {
                    latitude: userLatitude,
                    longitude: userLongitude,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#result').html('Jarak: ' + response.distance + ' km<br>Ongkos Kirim: Rp ' +
                            response.cost);
                    } else {
                        $('#result').html(response.message);
                    }
                },
                error: function(xhr) {
                    $('#result').html('Error calculating the distance.');
                }
            });
        });
    </script>
@endpush

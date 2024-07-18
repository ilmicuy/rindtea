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
        let marker;
        const sellerLocation = {
            lat: -6.862265474370653,
            lng: 107.5936457665463
        };

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: sellerLocation,
                zoom: 14,
            });

            // Place a marker at the seller's location
            new google.maps.Marker({
                position: sellerLocation,
                map: map,
                title: 'Lokasi Penjual'
            });

            // Add a circle around the seller's location
            new google.maps.Circle({
                map: map,
                radius: 10000, // 10 km
                fillColor: '#AA0000',
                strokeColor: '#AA0000',
                strokeOpacity: 0.5,
                fillOpacity: 0.2,
                center: sellerLocation
            });

            // Listen for clicks on the map to place a marker
            map.addListener('click', function(event) {
                placeMarker(event.latLng);
            });
        }

        function placeMarker(location) {
            // Check if location is a google.maps.LatLng object
            if (location instanceof google.maps.LatLng) {
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                    });
                }

                // Update the hidden input fields with the user's location
                $('#user-latitude').val(location.lat());
                $('#user-longitude').val(location.lng());

                // Log the values to the console for debugging
                console.log('Latitude:', location.lat());
                console.log('Longitude:', location.lng());
            } else {
                console.error('Invalid location object:', location);
            }
        }

        function loadGoogleMapsAPI() {
            const script = document.createElement('script');
            script.src =
                `https://maps.googleapis.com/maps/api/js?key=AIzaSyCCfRlVGUObDiUnSXJl7cS0GJw5yHJNSX8&callback=initMap`;
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        }

        loadGoogleMapsAPI();

        $('#get-location').click(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords
                        .longitude);

                    // Place marker at user's location
                    placeMarker(userLatLng);

                    // Center the map on the user's location
                    map.setCenter(userLatLng);

                    // Update hidden input fields with user's latitude and longitude
                    $('#user-latitude').val(position.coords.latitude);
                    $('#user-longitude').val(position.coords.longitude);
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

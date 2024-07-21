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

<!-- Single Page Header start -->
<div class="single-page-header">
    <h1 class="page-title">Alamat</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active">Alamat</li>
    </ol>
</div>
<!-- Single Page Header End -->
<section class="login" id="login">
    <div class="inner-page">
        <div class="login-container">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                {{ $error }}
            </div>
            @endforeach
            @endif
            <form method="POST" action="{{ route('address.store') }}">
                @csrf
                <div>
                    <x-input-label for="kantor" value="Kantor" />
                    <x-text-input id="kantor" class="" type="radio" name="label" value="Kantor" />

                    <x-input-label for="rumah" value="Rumah" />
                    <x-text-input id="rumah" class="" type="radio" name="label" value="Rumah" />
                </div>

                <div>
                    <x-text-input id="fullname" class="login-input" type="text" name="fullname" :value="old('fullname')" autofocus autocomplete="fullname" placeholder="Nama Lengkap" />
                    <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                </div>
                <div>
                    <x-text-input id="phone" class="login-input" type="number" name="phone" :value="old('phone')" autofocus autocomplete="phone" placeholder="No Telepon" />
                    <x-input-error :messages="$errors->get('nohp')" class="mt-2" />
                </div>
                <div>
                    <select id="province_id" class="login-input" name="province_id" autofocus autocomplete="province_id">
                        <option value="" disabled selected>Pilih Provinsi</option>
                        @foreach ($provinces as $province)
                        <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('province_id')" class="mt-2" />
                </div>
                <div>
                    <select id="regency_id" class="login-input" name="regency_id" autofocus autocomplete="regency_id">
                        @foreach ($cities as $city)
                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('regency_id')" class="mt-2" />
                </div>
                {{-- <div>
                        <select id="district_id" class="login-input" name="district_id" autofocus
                            autocomplete="district_id">

                        </select>
                        <x-input-error :messages="$errors->get('district_id')" class="mt-2" />
                    </div> --}}
                {{-- <div>
                        <select id="village_id" class="login-input" name="village_id" autofocus autocomplete="village_id">
                        </select>
                        <x-input-error :messages="$errors->get('village_id')" class="mt-2" />
                    </div> --}}
                <div>
                    <x-text-input id="postcode" class="login-input" type="number" name="postcode" :value="old('postcode')" autofocus autocomplete="postcode" placeholder="Kode Pos" />
                    <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
                </div>
                <div>
                    <textarea id="address" class="login-input" name="address" autofocus autocomplete="address" placeholder="Masukkan Alamat">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <div>
                    <x-text-input id="latitude" class="login-input" type="number" name="latitude" :value="old('latitude')" autocomplete="latitude" placeholder="Latitude" readonly/>
                </div>

                <div>
                    <x-text-input id="longitude" class="login-input" type="number" name="longitude" :value="old('longitude')" autocomplete="longitude" placeholder="Longitude" readonly />
                </div>

                <div>
                    <x-text-input id="distance_in_km" class="login-input" type="number" name="distance_in_km" :value="old('distance_in_km')" autofocus autocomplete="distance_in_km" placeholder="Jarak (Dalam KM)" readonly/>
                </div>


                <button class="login-button" type="submit">Submit</button>
            </form>
        </div>
    </div>

    <h2>Klik Di Peta Untuk Lokasi Anda</h2>
    <div id="map" style="height: 500px; width: 100%;" class="mb-3"></div>
</section>
@endsection
@push('myscript')
<script>
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
        });

        // Place a static marker at the seller's location with a yellow icon
        new google.maps.Marker({
            position: sellerLocation,
            map: map,
            title: 'Lokasi Penjual',
            icon: {
                url: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
            }
        });

        // Add a circle around the seller's location
        new google.maps.Circle({
            map: map,
            radius: 10000, // 10 km
            fillColor: '#AA0000',
            strokeColor: '#AA0000',
            strokeOpacity: 0.5,
            fillOpacity: 0.2,
            center: sellerLocation,
            clickable: false // Make the circle non-clickable
        });

        // Create a marker variable for the user's dynamic location with a blue icon
        let userMarker = new google.maps.Marker({
            map: map,
            title: 'User Location',
            icon: {
                url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            }
        });

        // Configure the click listener.
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

    // Helper method to calculate distance between two points
    function calculateDistanceInKm(lat1, lon1, lat2, lon2) {
        const earthRadius = 6371; // Radius of Earth in kilometers

        const dLat = degreesToRadians(lat2 - lat1);
        const dLon = degreesToRadians(lon2 - lon1);

        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(degreesToRadians(lat1)) * Math.cos(degreesToRadians(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        const distance = earthRadius * c; // Distance in kilometers

        // Pembulatan ke 2 tempat desimal
        const roundedDistance = Math.round(distance * 100) / 100;

        return roundedDistance;
    }

    // Helper function to convert degrees to radians
    function degreesToRadians(degrees) {
        return degrees * (Math.PI / 180);
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

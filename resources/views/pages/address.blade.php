@extends('layouts.home')

@section('content')
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
                        <x-text-input id="fullname" class="login-input" type="text" name="fullname" :value="old('fullname')"
                            autofocus autocomplete="fullname" placeholder="Nama Lengkap" />
                        <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                    </div>
                    <div>
                        <x-text-input id="phone" class="login-input" type="number" name="phone" :value="old('phone')"
                            autofocus autocomplete="phone" placeholder="No Telepon" />
                        <x-input-error :messages="$errors->get('nohp')" class="mt-2" />
                    </div>
                    <div>
                        <select id="province_id" class="login-input" name="province_id" autofocus
                            autocomplete="province_id">
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
                        <x-text-input id="postcode" class="login-input" type="number" name="postcode" :value="old('postcode')"
                            autofocus autocomplete="postcode" placeholder="Kode Pos" />
                        <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
                    </div>
                    <div>
                        <textarea id="address" class="login-input" name="address" autofocus autocomplete="address"
                            placeholder="Masukkan Alamat">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <button class="login-button" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('myscript')
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

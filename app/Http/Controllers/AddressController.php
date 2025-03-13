<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AlamatRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::withHeaders([
            'key' => env('API_ONGKIR_KEY')
        ])->get(env('API_ONGKIR_BASE_URL') . 'province');
        $provinces = $response['rajaongkir']['results'];

        $id = Auth::id();
        $address = Address::where('users_id', $id)->get();
        return view('pages.address', ['provinces' => $provinces, 'address' => $address]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlamatRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $userId = Auth::id();
            $validated['users_id'] = $userId;
            $newAddress = Address::create($validated);
        });

        return redirect()->route('checkout')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        //
    }

    /**
     * Get cities based on province ID
     */
    public function getCities(Request $request)
    {
        $provinceId = $request->province_id;

        $response = Http::withHeaders([
            'key' => env('API_ONGKIR_KEY')
        ])->get(env('API_ONGKIR_BASE_URL') . 'city', [
            'province' => $provinceId
        ]);

        return response()->json($response['rajaongkir']['results']);
    }

    // public function getkota(Request $request)
    // {
    //     $id_provinsi = $request->id_provinsi;
    //     $kotas = Regency::where('province_id', $id_provinsi)->get();
    //     $option = "<option>Pilih Kota/Kabupaten</option>";
    //     foreach ($kotas as $kota) {
    //         $option .= "<option value='$kota->id'>$kota->name</option>";
    //     }
    //     return $option;
    // }

    // public function getkecamatan(Request $request)
    // {
    //     $id_kota = $request->id_kota;
    //     $kecamatans = District::where('regency_id', $id_kota)->get();
    //     $option = "<option>Pilih Kecamatan</option>";
    //     foreach ($kecamatans as $kecamatan) {
    //         $option .= "<option value='$kecamatan->id'>$kecamatan->name</option>";
    //     }
    //     return $option;
    // }

    // public function getdesa(Request $request)
    // {
    //     $id_kecamatan = $request->id_kecamatan;
    //     $desas = Village::where('district_id', $id_kecamatan)->get();
    //     $option = "<option>Pilih Desa</option>";
    //     foreach ($desas as $desa) {
    //         $option .= "<option value='$desa->id'>$desa->name</option>";
    //     }
    //     return $option;
    // }
}

<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory, SoftDeletes, HasUuids;
    protected $fillable = [

        'fullname',
        'users_id',
        'province_id',
        'regency_id',
        'label',
        'phone',
        'address',
        'postcode',
        'latitude',
        'longitude',
        'distance_in_km',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id');
    }

    // public function province()
    // {
    //     $response = Http::withHeaders([
    //         'key' => env('API_ONGKIR_KEY')
    //     ])->get(env('API_ONGKIR_BASE_URL') . 'province');

    //     if ($response->successful()) {
    //         return $response['rajaongkir']['results'];
    //     }

    //     return null;
    // }

    // public function regency()
    // {
    //     $response = Http::withHeaders([
    //         'key' => env('API_ONGKIR_KEY')
    //     ])->get(env('API_ONGKIR_BASE_URL') . 'city');

    //     if ($response->successful()) {
    //         return $response['rajaongkir']['results'];
    //     }

    //     return null;
    // }
}

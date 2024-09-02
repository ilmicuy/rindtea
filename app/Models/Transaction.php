<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    // use HasFactory;

    use SoftDeletes, HasUuids;


    protected $fillable = [
        'kode_transaksi',
        'users_id',
        'transaction_status',
        'total_price',
        'snap_token',
        'paid_at',
        'paid_payload',
        'payment_method',
        'shipment_courier',
        'shipment_cost',
        'shipment_address_id',
        'refund_status',
        'refund_no_rek',
    ];

    protected $hidden = [];

    public function generateKodeTransaksi()
    {
        // Get the last Ingredient code from the database
        $lastTransaksi = self::latest('kode_transaksi')->first();

        // Extract the numeric part from the last kode_produk (e.g., TRX-20240822-0001 -> 1)
        if ($lastTransaksi) {
            $lastNumber = intval(substr($lastTransaksi->kode_transaksi, 13));
        } else {
            $lastNumber = 0;
        }

        // Increment the number by 1
        $newNumber = $lastNumber + 1;

        // Format the new number with leading zeros (e.g., 1 -> 0001)
        $newKodeTransaksi = 'TRX-' . Carbon::now()->format('Ymd') . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return $newKodeTransaksi;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'transactions_id', 'id');
    }

    public function addressChoosen()
    {
        return $this->belongsTo(Address::class, 'shipment_address_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'users_id', 'users_id');
    }

    public function transactionShipment()
    {
        return $this->hasMany(TransactionShipment::class);
    }
}

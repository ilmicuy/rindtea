<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionShipmentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_shipment_id', 'history_date', 'description', 'location'
    ];

    public function transactionShipment()
    {
        return $this->belongsTo(TransactionShipment::class);
    }
}

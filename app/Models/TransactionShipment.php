<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionShipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'awb', 'courier', 'service', 'status', 'date', 'description',
        'amount', 'weight', 'origin', 'destination', 'shipper', 'receiver', 'is_crawlable', 'last_crawl_at'
    ];

    public function transactionShipmentHistory()
    {
        return $this->hasMany(TransactionShipmentHistory::class);
    }
}

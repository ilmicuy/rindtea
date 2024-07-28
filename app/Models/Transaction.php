<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    // use HasFactory;

    use SoftDeletes, HasUuids;


    protected $fillable = [
        'users_id',
        'transaction_status',
        'total_price',
        'snap_token',
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'id', 'transaction_detail_id');
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

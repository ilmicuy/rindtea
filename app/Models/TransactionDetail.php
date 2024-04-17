<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    // use HasFactory;

    use SoftDeletes, HasUuids;

    protected $fillable = [
        'transactions_id',
        'products_id',
        'first_name',
        'last_name', 
        'address', 
        'city', 
        'country' , 
        'zip_code',
        'phone',
        'qty'
    ];
    protected $hidden = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transactions_id');
    }
}

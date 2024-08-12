<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    public $fillable = [
        'product_id',
        'qty_requested',
        'notes',
        'status',
        'approved_by_owner',
        'success_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function logs()
    {
        return $this->morphMany(TransactionLog::class, 'loggable');
    }
}

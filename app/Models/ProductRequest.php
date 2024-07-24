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
        'success_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

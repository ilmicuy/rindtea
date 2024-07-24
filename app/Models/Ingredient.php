<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bahan_baku',
        'qty',
        'satuan',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty_needed');
    }
}

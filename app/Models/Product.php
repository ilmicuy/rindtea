<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    // use HasFactory;

    use SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'photos',
        'quantity',
        'quality',
        'thumb_description',
        'price',
        'weight',
        'check',
        'country_of_origin',
        'opsi_pengiriman',
    ];

    protected $hidden = [];

    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'categories_id', 'id');
    // }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('qty_needed');
    }

    /**
     * Get the product transactions for the product.
     */
    public function productTransactions()
    {
        return $this->hasMany(ProductTransaction::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    // use HasFactory;

    use HasUuids;

    protected $fillable = [
        'kode_produk',
        'name',
        'variant_grouping',
        'slug',
        'photos',
        'quantity',
        'quality',
        'thumb_description',
        'raw_price',
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
    public function generateKodeProduk()
    {
        // Get the last product code from the database
        $lastProduct = self::latest('kode_produk')->first();

        // Extract the numeric part from the last kode_produk (e.g., PRD-0001 -> 1)
        if ($lastProduct) {
            $lastNumber = intval(substr($lastProduct->kode_produk, 4));
        } else {
            $lastNumber = 0;
        }

        // Increment the number by 1
        $newNumber = $lastNumber + 1;

        // Format the new number with leading zeros (e.g., 1 -> 0001)
        $newKodeProduk = 'PRD-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return $newKodeProduk;
    }


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

    public function getPendapatanBersihAttribute()
    {
        return $this->price - $this->raw_price;
    }

    /**
     * Get all products that belong to the same variant group
     */
    public function getVariantGroupProducts()
    {
        if (!$this->variant_grouping) {
            return collect([$this]);
        }

        return self::where('variant_grouping', $this->variant_grouping)
                  ->where('id', '!=', $this->id)
                  ->get();
    }
}

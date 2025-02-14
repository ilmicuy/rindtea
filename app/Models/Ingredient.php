<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_bahan_baku',
        'nama_bahan_baku',
        'qty',
        'satuan',
    ];


    public function generateKodeBahanBaku()
    {
        // Get the last product code from the database
        $lastBahanBaku = self::latest('kode_bahan_baku')->first();

        // Extract the numeric part from the last kode_bahan_baku (e.g., ING-0001 -> 1)
        if ($lastBahanBaku) {
            $lastNumber = intval(substr($lastBahanBaku->kode_bahan_baku, 4));
        } else {
            $lastNumber = 0;
        }

        // Increment the number by 1
        $newNumber = $lastNumber + 1;

        // Format the new number with leading zeros (e.g., 1 -> 0001)
        $newKodeBahanBaku = 'ING-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        return $newKodeBahanBaku;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('qty_needed');
    }
}

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
        'categories_id', 
        'slug', 
        'photos',
        'quantity', 
        'quality',
        'thumb_description', 
        'short_description', 
        'long_description', 
        'price' , 
        'weight',
        'check',
        'country_of_origin'
    ];

    protected $hidden = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }
}

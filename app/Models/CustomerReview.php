<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerReview extends Model
{
    // use HasFactory;
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'products_id', 
        'transactions_id', 
        'users_id',
        'description_review',
        'rating',
    ];

    protected $hidden = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}


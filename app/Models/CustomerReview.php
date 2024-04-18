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
        'name_reviewer',
        'description_review',
        'rating',
    ];

    protected $hidden = [];
}


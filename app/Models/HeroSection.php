<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeroSection extends Model
{
    use HasFactory , SoftDeletes, HasUuids;

    protected $fillable = [
        'heading',
        'subheading',
        'banner',
        'span'
    ];
}

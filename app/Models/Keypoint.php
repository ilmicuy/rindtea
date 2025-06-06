<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keypoint extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'about_id',
        'keypoint',
    ];
}

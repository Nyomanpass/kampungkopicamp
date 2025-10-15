<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $table = 'products';

    protected $fillable = [
        'name',
        'type',
        'price',
        'capacity_per_unit',
        'max_participant',
        'duration_type',
        'images',
        'facilities',
        'is_active',
    ];
}

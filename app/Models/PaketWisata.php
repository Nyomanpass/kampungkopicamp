<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    use HasFactory;

    protected $table = 'paket_wisata';

    protected $fillable = [
        'title',
        'description',
        'price',
        'max_person',
        'location',
        'duration',
        'main_image',
        'gallery',
        'fasilitas',
        'category_id',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'gallery' => 'array',
        'fasilitas' => 'array',
        
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


}

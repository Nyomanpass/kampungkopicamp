<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // Kalau mau relasi ke PaketWisata:
    public function paketWisata()
    {
        return $this->hasMany(PaketWisata::class, 'category_id');
    }

}

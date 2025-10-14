<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'title',
        'description',
        'main_image',
        'published_at'
    ];

    


    protected $casts = [
        'published_at' => 'datetime',
        'title' => 'array',
        'description' => 'array',
    ];

    // Hubungan ke blog_content
    public function contents()
    {
        return $this->hasMany(BlogContent::class, 'blog_id');
    }

    // Accessor untuk menampilkan tanggal dengan format d M Y
    public function getPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : null;
    }
}

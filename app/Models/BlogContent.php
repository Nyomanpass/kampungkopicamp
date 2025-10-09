<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogContent extends Model
{
    use HasFactory;

    protected $table = 'blog_content'; // karena tabelnya bernama blog_content

    protected $fillable = [
        'blog_id',
        'content',
        'image'
    ];

    // Hubungan ke blog
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }
}

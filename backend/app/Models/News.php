<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class News extends Model
{
    //
    use Uuid;

    public $incrementing = false;
    protected $keytype = "string";

    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'published_at'
    ];

    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (!$news->slug) {
                $news->slug = Str::slug($news->title) . '-' . uniqid();
            }
        });
    }
}

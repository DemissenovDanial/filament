<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'preview_text',
        'detail_text',
        'preview_image',
        'detail_image',
        'category_id',
        'published_at',
        'active'
    ];
    protected $casts = [
        'published_at' => 'datetime',
        'active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function getFormatedPublishedAtAttribute()
    {
        return Carbon::parse($this->published_at)->translatedFormat('j F Y');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'article_user_likes');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}

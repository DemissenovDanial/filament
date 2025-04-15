<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'title',
        'slug',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tags');
    }
}

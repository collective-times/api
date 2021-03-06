<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'title',
        'feed_url',
        'source_url',
        'crawlable',
        'type',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}

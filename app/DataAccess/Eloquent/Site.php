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
        'class',
    ];

    public function articles()
    {
        return $this->hasMany(Site::class);
    }
}

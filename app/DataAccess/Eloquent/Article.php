<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'description',
        'publish_date',
        'article_url',
        'source_url',
        'image_url',
        'favicon_url',
    ];
}

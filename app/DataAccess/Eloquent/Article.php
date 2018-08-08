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

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function getShortDescriptionAttribute()
    {
        return mb_substr(strip_tags($this->description), 0, 200);
    }
}

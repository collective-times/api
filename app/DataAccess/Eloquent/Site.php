<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'feed_url',
        'source_url',
        'format',
    ];
}

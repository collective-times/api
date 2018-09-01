<?php

namespace App\DataAccess\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ArticleUser extends Model
{
    protected $table = 'article_user';
    protected $fillable = ['user_id', 'article_id'];
}

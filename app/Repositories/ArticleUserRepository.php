<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ArticleUserRepository
{
    public function fetchAll()
    {
        return DB::table('article_user')
            ->join('articles', 'article_user.article_id', '=', 'articles.id')
            ->join('sites', 'articles.site_id', '=', 'sites.id')
            ->select('articles.*', 'sites.title as sourceTitle')
            ->paginate(10);
    }
}
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\DataAccess\Eloquent\Article;

class ArticleController extends Controller
{
    public function index()
    {
        // MEMO: pageクエリパラメーターは、Laravelが自動判別する
        // refs: https://readouble.com/laravel/5.6/ja/pagination.html
        $articles = Article::orderBy('publish_date', 'desc')->paginate(10);

        return response()->json(['articles' => $articles->map(function($article) {
            return [
                'key' => $article->id,
                'title' => $article->title,
                'description' => $article->description,
                'date' => $article->publish_date,
                'articleUrl' => $article->article_url,
                'sourceUrl' => $article->source_url,
                'imageUrl' => $article->image_url,
                'faviconUrl' => $article->favicon_url,
            ];
        })]);
    }
}

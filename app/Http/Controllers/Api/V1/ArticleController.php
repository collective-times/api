<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\DataAccess\Eloquent\Article;

class ArticleController extends Controller
{
    public function index()
    {
        // TODO: ページネーション
        $articles = Article::all();

        return response()->json(['articles' => $articles->map(function($article) {
            return [
                'title' => $article->title,
                'description' => $article->description,
                'date' => $article->publish_date,
                'articleUrl' => $article->article_url,
                'sourceUrl' => $article->source_url,
                'imageUrl' => $article->image_url,
                'faviconUrl' => $article->faviron_url,
            ];
        })]);
    }
}

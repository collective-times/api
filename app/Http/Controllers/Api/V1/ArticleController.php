<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\DataAccess\Eloquent\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->page ?? 1;
        $key = 'articles_page_' . $page;

        if (Cache::has($key)) {
            $articles = Cache::get($key);
        } else {
            // MEMO: pageクエリパラメーターは、Laravelが自動判別する
            // refs: https://readouble.com/laravel/5.6/ja/pagination.html
            $articles = Article::orderBy('publish_date', 'desc')->paginate(10);

            Cache::put($key, $articles, now()->addMinutes(10));
        }

        return response()->json(['articles' => $articles->map(function($article) {
            return [
                'key' => $article->id,
                'title' => $article->title,
                'description' => $article->short_description,
                'date' => $article->publish_date,
                'articleUrl' => $article->article_url,
                'sourceTitle' => $article->site->title ?? null,
                'sourceUrl' => $article->source_url,
                'imageUrl' => $article->image_url,
                'faviconUrl' => $article->favicon_url,
            ];
        })]);
    }
}

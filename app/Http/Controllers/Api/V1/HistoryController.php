<?php

namespace App\Http\Controllers\Api\V1;

use App\DataAccess\Eloquent\ArticleUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ArticleUserRepository;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ArticleUserRepository $repository)
    {
        $articles = $repository->fetchAll();

        return response()->json(['histories' => $articles->map(function ($article) {
            return [
                'article' => [
                    'key' => $article->id,
                    'title' => $article->title,
                    // TODO: Entityクラスへの処理の移譲
                    'description' => mb_substr(trim(strip_tags($article->description)), 0, 200),
                    'date' => $article->publish_date,
                    'articleUrl' => $article->article_url,
                    'sourceTitle' => $article->site->title ?? $article->sourceTitle,
                    'sourceUrl' => $article->source_url,
                    'imageUrl' => $article->image_url,
                    'faviconUrl' => $article->favicon_url,
                ],
                'user' => [
                    'name' => Auth::user()->name ?? 'だれか'
                ]
            ];
        })]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if (Auth::check()) {
            Auth::user()->articles()->attach($request->article_id);
        } else {
             ArticleUser::create([
                 'article_id' => $request->article_id
             ]);
        }

        return response()->json([
            'article_id' => $request->article_id,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $articleId
     * @return \Illuminate\Http\Response
     */
    public function destroy($articleId)
    {
        Auth::user()->articles()->detach($articleId);

        return response()->json(null, 204);
    }
}

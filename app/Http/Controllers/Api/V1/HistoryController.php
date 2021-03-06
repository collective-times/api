<?php

namespace App\Http\Controllers\Api\V1;

use App\DataAccess\Eloquent\ArticleUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ArticleUserRepository;
use Firebase\JWT\JWT;

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
        $authorization = $request->header('Authorization');
        if ($authorization) {
            $jwt = substr($authorization, 7);
            // phodotenv で複数行の公開鍵を「\\n」の改行コードで管理している都合で、通常の公開鍵として利用できるように普通の改行コードに戻す
            // refs: https://qiita.com/hypermkt/items/6ad0c9535dd1b22ca3be
            $newLinedPublicKey = str_replace('\\n', "\n", config('passport.public_key'));
            $payload = JWT::decode($jwt, $newLinedPublicKey, ['RS256']);
        }

        ArticleUser::create([
            'user_id' => $payload->sub ?? null,
            'article_id' => $request->article_id
        ]);

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

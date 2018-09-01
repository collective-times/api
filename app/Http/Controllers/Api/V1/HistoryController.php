<?php

namespace App\Http\Controllers\Api\V1;

use App\DataAccess\Eloquent\ArticleUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $articles = Auth::user()->articles()->get();
        } else {

        }

        return response()->json(['histories' => $articles->map(function ($article) {
            return [
                'article' => [
                    'key' => $article->id,
                    'title' => $article->title,
                    'description' => $article->short_description,
                    'date' => $article->publish_date,
                    'articleUrl' => $article->article_url,
                    'sourceTitle' => $article->site->title ?? null,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

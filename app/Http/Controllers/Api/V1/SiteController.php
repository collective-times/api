<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiteRequest;
use Illuminate\Http\Request;
use App\DataAccess\Eloquent\Site;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::all();
        return response()->json(['sites' => $sites->map(function ($site) {
            return [
                'id' => $site->id,
                'title' => $site->title,
                'feedUrl' => $site->feed_url,
                'sourceUrl' => $site->source_url,
                'crawlable' => (boolean)$site->crawlable,
                'class' => $site->class,
            ];
        })]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteRequest $request)
    {
        $site = Site::create([
            'title' => $request->title,
            'feed_url' => $request->feedUrl,
            'source_url' => $request->sourceUrl,
            'crawlable' => $request->crawlable,
            'class' => $request->input('class'),
        ]);

        return response()->json([
            'id' => $site->id,
            'title' => $site->title,
            'feedUrl' => $site->feed_url,
            'sourceUrl' => $site->source_url,
            'crawlable' => (boolean) $site->crawlable,
            'class' => $site->class,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $site = Site::findOrFail($id);

        return response()->json(['site' => [
            'id' => $site->id,
            'title' => $site->title,
            'feedUrl' => $site->feed_url,
            'sourceUrl' => $site->source_url,
            'crawlable' => (boolean) $site->crawlable,
            'class' => $site->class,
        ]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $site = Site::findOrFail($id);
        $site->title = $request->title;
        $site->feed_url = $request->feedUrl;
        $site->source_url = $request->sourceUrl;
        $site->crawlable = $request->crawlable;
        $site->class = $request->input('class');
        $site->save();

        return response()->json([
            'id' => $site->id,
            'title' => $site->title,
            'feedUrl' => $site->feed_url,
            'sourceUrl' => $site->source_url,
            'crawlable' => (boolean) $site->crawlable,
            'class' => $site->class,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $site = Site::findOrFail($id);
        $site->delete();

        return response()->json(null, 204);
    }
}

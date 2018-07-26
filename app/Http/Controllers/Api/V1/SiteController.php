<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
                'feedUrl' => $site->feed_url,
                'sourceUrl' => $site->source_url,
                'format' => $site->format,
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
        $site = Site::create([
            'feed_url' => $request->feed_url,
            'source_url' => $request->source_url,
            'format' => $request->input('format'),
        ]);

        return response()->json([
            'id' => $site->id,
            'feedUrl' => $site->feed_url,
            'sourceUrl' => $site->source_url,
            'format' => $site->format,
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
            'feedUrl' => $site->feed_url,
            'sourceUrl' => $site->source_url,
            'format' => $site->format,
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
        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(null, 204);
    }
}

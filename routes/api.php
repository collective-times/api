<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->namespace('Api\V1')->group(function() {
    Route::get('articles', 'ArticleController@index');
    Route::get('contents-parsers', 'ContentsParserController@index');
    Route::post('android/devices', 'Android\DeviceController@store');
    Route::resource('histories', 'HistoryController', ['only' => ['index', 'store']]);

    Route::middleware('auth:api')->group(function () {
        Route::resource('sites', 'SiteController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
        Route::delete('histories', 'HistoryController@destroy');
    });
});

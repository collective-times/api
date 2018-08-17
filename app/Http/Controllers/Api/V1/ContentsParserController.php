<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class ContentsParserController extends Controller
{
    public function index()
    {
        return response()->json(['contents-parsers' => collect(config('contentsparser'))->map(function($parser) {
            return [
                'type' => $parser['type'],
                'class' => $parser['class'],
            ];
        })]);
    }
}

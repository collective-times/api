<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ContentsParserController extends Controller
{
    public function index()
    {
dd(File::files(app_path() . '/ContentsParser/Entity/'));
        return response()->json(['contents-parsers' => []]);
    }
}

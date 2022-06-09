<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Video"
            ],
            "data"  => $videos
        ], 200);
    }

    public function videoHomePage()
    {
        $videos = Video::latest()->take(2)->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Video Homepage"
            ],
            "data"  => $videos
        ], 200);
    }
}

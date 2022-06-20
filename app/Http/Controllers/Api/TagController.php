<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data tags"
            ],
            "data"  => $tags
        ], 200);
    }

    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if($tag){
            return response()->json([
                "response"  => [
                    "status"    => 200,
                    "message"   => "Detail Data Agenda " . $tag->name
                ],
                "data"  => $tag->posts()->latest()->paginate(6)
            ], 200);
        }
        else {
            return response()->json([
                "response"  => [
                    "status"    => 404,
                    "message"   => "Data Agenda Tidak Ditemukan"
                ],
                "data"  => null
            ], 404);
        };
    }
}

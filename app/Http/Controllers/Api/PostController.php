<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Posts"
            ],
            "data"  => $posts
        ], 200);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if($post){
            return response()->json([
                "response"  => [
                    "status"    => 200,
                    "message"   => "Detail Data Post"
                ],
                "data"  => $post
            ], 200);
        }
        else {
            return response()->json([
                "response"  => [
                    "status"    => 404,
                    "message"   => "Data Post Tidak Ditemukan"
                ],
                "data"  => null
            ], 404);
        };
    }

    public function postHomePage()
    {
        $posts = Post::latest()->take(6)->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Posts Homepage"
            ],
            "data"  => $posts
        ], 200);
    }
}

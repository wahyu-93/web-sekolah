<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Kategori"
            ],
            "data"  => $categories
        ], 200);
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if($category){
            return response()->json([
                "response"  => [
                    "status"    => 200,
                    "message"   => "Detail Data Kategori"
                ],
                "data"  => $category->posts()->latest()->paginate(6)
            ], 200);
        }
        else {
            return response()->json([
                "response"  => [
                    "status"    => 404,
                    "message"   => "Data Kategori Tidak Ditemukan"
                ],
                "data"  => null
            ], 404);
        };
    }
}

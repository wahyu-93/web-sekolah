<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:posts.index|posts.create|posts.edit|posts.delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->when(request()->q, function($posts){
            $posts = $posts->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();

        return view('admin.post.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title'         => 'required|unique:posts',
            'category_id'   => 'required', 
            'content'       => 'required'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        // simpan posts
        $post = Post::create([
            'image'         => $image->hashName(),
            'title'         => $request->input('title'),
            'slug'          => Str::slug($request->input('title'), '-'),
            'category_id'   => $request->input('category_id'),
            'content'       => $request->input('content')
        ]);

        // assign tags to post
        $post->tags()->attach($request->input('tags'));
        $post->save();

        if($post){
            return redirect()->route('admin.post.index')->with(['message' => 'Data Berhasil Disimpan']);
        }
        else {
            return redirect()->route('admin.post.index')->with(['message' => 'Data Gagal Disimpan']);
        };
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();

        return view('admin.post.edit', compact('tags', 'categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            'title'         => 'required|unique:posts',
            'category_id'   => 'required', 
            'content'       => 'required'   
        ]);

        // simpan foto 
        if ($request->file('image') == ''){
            // jika foto tidak diubah jalan kan ini 
            $data = [
                'title'         => $request->input('title'),
                'slug'          => Str::slug($request->input('title'), '-'),
                'category_id'   => $request->input('category_id'),
                'content'       => $request->input('content')
            ];
        }
        else {
            // remove foto lama
            Storage::disk('local')->delete('public/post/' . $post->image);

            // upload image baru
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            $data = [
                'image'         => $image->hashName(),
                'title'         => $request->input('title'),
                'slug'          => Str::slug($request->input('title'), '-'),
                'category_id'   => $request->input('category_id'),
                'content'       => $request->input('content')
            ];
        };

        $post->update($data);

        if($post){
            return redirect()->route('admin.post.index')->with(['message' => 'Data Berhasil Diupdate']);
        }
        else {
            return redirect()->route('admin.post.index')->with(['message' => 'Data Gagal Diupdate']);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Storage::disk('local')->delete('public/posts/'.basename($post->image));
        $post->delete();

        if($post){
            return response()->json([
                'status'    => 'success'
            ]);
        }
        else {
            return response()->json([
                'status'    => 'error'
            ]);
        }


    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:videos.index|videos.create|videos.edit|videos.edit|videos.delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::latest()->when(request()->q, function($videos){
            $videos = $videos->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.video.create');
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
            'title'     => 'required',
            'embed'     => 'required'
        ]);

        $embed = str_replace('watch?v=', 'embed/', $request->input('embed'));

        $video = Video::create([
            'title'     => $request->input('title'),
            'embed'     => $embed
        ]);

        if($video){
            return redirect()->route('admin.video.index')->with(['success' => 'Data Berhasil Disimpan']);
        }
        else {
            return redirect()->route('admin.video.index')->with(['error' => 'Data Gagal Disimpan']);
        };
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('admin.video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $this->validate($request, [
            'title'     => 'required',
            'embed'     => 'required'
        ]);

        $video->update([
            'title'     => $request->input('title'),
            'embed'     => $request->input('embed')
        ]);

        if($video){
            return redirect()->route('admin.video.index')->with(['success' => 'Data Berhasil Diubah']);
        }
        else {
            return redirect()->route('admin.video.index')->with(['error' => 'Data Gagal Diubah']);
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
        $video = Video::findOrFail($id);
        $video->delete();

        if($video){
            return response()->json(['status' => 'success']);
        }
        else {
            return response()->json(['status' => 'error']);
        };
    }
}

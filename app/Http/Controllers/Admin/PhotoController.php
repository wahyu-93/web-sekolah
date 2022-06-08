<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest()->when(request()->q, function($photos){
            $photos = $photos->where('caption', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.photo.index', compact('photos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'image'     => 'required|image|mimes:jpg,jpeg,png'
            'caption'   => 'required'
        ]);

        // upload foto
        $image = $request->file('image');
        $image->storeAs('publi/photos', $image->hashName());
        
        $photo = Photo::create([
            'image'     => $image->hashName(),
            'caption'   => $request->input('caption')
        ]);

        if($photo){
            return redirect()->route('admin.photo.index')->with(['success' => 'Data Berhasil Disimpan']);
        }
        else {
            return redirect()->route('admin.photo.index')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        Storage::disk('local')->delete('/public/photos/' . $photo->image);
        $photo->delete();

        if($photo){
            return response()->json([
                'status'    => 'success'
            ]);
        }
        else {
            return response()->json([
                'status'    => 'error'
            ]);
        };
    }
}

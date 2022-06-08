<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:sliders.index|sliders.create|sliders.delete']);
    }

    public function index()
    {
        $sliders = Slider::latest()->paginate(10);

        return view('admin.slider.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'image'     => 'required|image|mimes:jpeg,jpg,png'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        $slider = Slider::create([
            'image' => $image->hashName()
        ]);

        if ($slider){
            return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Disimpan']);
        }
        else {
            return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        Storage::disk('local')->delete('public/sliders/', $slider->image);
        $slider->delete();

        if($slider){
            return response()->json(['status' => 'success']);
        }
        else {
            return response()->json(['status' => 'error']);
        }
    }
}

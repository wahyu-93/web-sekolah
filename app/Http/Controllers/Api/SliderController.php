<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->paginate(10);
        return response()->json([
            "response"  => [
                "status"    => 202,
                "message"   => "List Data Slider"
            ],
            "data"  => $sliders
        ], 200);
    }
}

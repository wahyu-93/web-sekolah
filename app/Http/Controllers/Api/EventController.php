<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data events"
            ],
            "data"  => $events
        ], 200);
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->first();
        if($event){
            return response()->json([
                "response"  => [
                    "status"    => 200,
                    "message"   => "Detail Data Agenda"
                ],
                "data"  => $event
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

    public function eventHomePage()
    {
        $events = Event::latest()->take(6)->get();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "List Data Agenda Homepage"
            ],
            "data"  => $events
        ], 200);
    }
}

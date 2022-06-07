<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:events.index|events.create|events.edit|events.delete']);    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::latest()->when(request()->q, function($events){
            $events = $events->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.event.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event.create');
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
            'title'     => 'required',
            'content'   => 'required',
            'location'  => 'required',
            'date'      => 'required'
        ]);

        $event = Event::create([
            'title'     => $request->input('title'),
            'slug'      => Str::slug($request->input('title'), '-'),
            'content'   => $request->input('content'),
            'location'  => $request->input('location'),
            'date'      => $request->input('date')
        ]);

        if($event){
            return redirect()->route('admin.event.index')->with(['success' => 'Data Berhasil Disimpan']);
        }
        else {
            return redirect()->route('admin.event.index')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('admin.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->validate($request,[
            'title'     => 'required',
            'content'   => 'required',
            'location'  => 'required',
            'date'      => 'required'
        ]);

        $event->update([
            'title'     => $request->input('title'),
            'slug'      => Str::slug($request->input('title'), '-'),
            'content'   => $request->input('content'),
            'location'  => $request->input('location'),
            'date'      => $request->input('date')
        ]);

        if($event){
            return redirect()->route('admin.event.index')->with(['success' => 'Data Berhasil Disimpan']);
        }
        else {
            return redirect()->route('admin.event.index')->with(['error' => 'Data Gagal Disimpan']);
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
        $event = Event::findOrFail($id);
        $event->delete();

        if($event){
            return response()->json([
                'status'   => 'success'
            ]);
        }
        else {
            return response()->json([
                'status'   => 'error'
            ]);
        };
    }
}

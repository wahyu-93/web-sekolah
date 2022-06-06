<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:categories.index|categories.create|categories.edit|categories.delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = Category::latest()->when(request()->q, function($categorys){
            $categorys = $categorys->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.category.index', compact('categorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'name'  => 'required|unique:categories',
        ]);

        $category = Category::create([
            'name'  => $request->input('name'),
            'slug'  => Str::slug($request->input('q'),'-')
        ]);

        if($category){
            return redirect()->route('admin.category.index')->with(['message' => 'Data Berhasil Disimpan']);
        }
        else {
            return redirect()->route('admin.category.index')->with(['message' => 'Data Gagal Disimpan']);
        };
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request,[
            'name'  => 'required|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name'  => $request->input('name'),
            'slug'  => Str::slug($request->input('q'),'-')
        ]);

        if($category){
            return redirect()->route('admin.category.index')->with(['message' => 'Data Berhasil Disimpan']);
        }
        else {
            return redirect()->route('admin.category.index')->with(['message' => 'Data Gagal Disimpan']);
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
        $category = Category::findOrFail($id);
        $category->delete();

        if($category){
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

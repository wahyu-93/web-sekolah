<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:roles.index|roles.create|roles.edit|roles.delete']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::latest()->when(request()->q, function($roles){
            $roles = $roles->where('name', 'like', '%' . request()->q .'%');
        })->paginate(5);

        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::latest();

        return view('admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi role 
        $this->validate($request,[
            'name'  => 'required|unique:roles'
        ]);

        $role = Role::create([
            'name'  => $request->input('name')
        ]);

        // assign permission to role
        $role->syncPermissions($request->input('permissions'));

        if($role){
            // redirect pesan success
            return redirect()->route('admin.role.index')->with(['success' => 'Data Berhasil Disimpan']);
        }
        else{
            // redirect pesan error
            return redirect()->route('admin.role.index')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::latest()->get();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request,[
            'name'  => 'required|unique:roles,name'.$role->id
        ]);

        $role = Role::findOrFail($role->id);
        $role->update([
            'name'  => $request->input('name')
        ]);

        // assign Permission to role
        $role->syncPermissions($request->input('permissions'));
        if($role){
            // redirect pesan success
            return redirect()->route('admin.role.index')->with(['success' => 'Data Berhasil Diupdate']);
        }
        else{
            // redirect pesan error
            return redirect()->route('admin.role.index')->with(['error' => 'Data Gagal Diupdate']);
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
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        $role->revokePermissions($permissions);
        $role->delete;

        if($role){
            return response()->json([
                'status' => 'success'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Activitylog\Traits\LogsActivity;

class HakaksionsController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('backend.pages.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('backend.pages.permission.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'group_name' => 'required|max:50',
        ]);

        // Create New User
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->guard_name = 'admin';
        $permission->group_name = $request->group_name;
        $permission->save();

        session()->flash('success', 'Permission has been created !!');
        return redirect()->route('admin.hakaksions.index');
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
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('backend.pages.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $request->validate([
            'name' => 'required|max:50',
            'group_name' => 'required|max:50',
        ]);

        $permission->update([
            'name'         => $request->name,
            'guard_name'   => 'admin',
            'group_name'   => $request->group_name
        ]);
        session()->flash('success', 'Permission has been update !!');
        return redirect()->route('admin.hakaksions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        if (!is_null($permission)) {
            $permission->delete();
        }

        session()->flash('success', 'Permission has been deleted !!');
        return back();
    }
}

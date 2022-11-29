<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Library\TraitFloorPermission;
use App\Models\Master\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FloorController extends Controller
{
    use TraitFloorPermission;

    /**
     * Variable to store user data
     */
    public $user;

    /**
     * Constructor function
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Checking permission 
         */
        $this->isAuthenticated($this->user, Floor::PERMISSION_VIEW);

        $floors = Floor::orderBy('id', 'asc')->get();
        return view('backend.pages.floor.index', compact('floors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         * Checking permission 
         */
        $this->isAuthenticated($this->user, Floor::PERMISSION_CREATE);

        return view('backend.pages.floor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Checking permission 
         */
        $this->isAuthenticated($this->user, Floor::PERMISSION_CREATE);

        /**
         * Validation requests
         */
        $request->validate(Floor::$rules);

        /**
         * If floor has been soft deleted, then make deleted is false and update it
         */
        $floor_trashed = Floor::where([
            'id' => data_get($request, 'number'),
        ])->withTrashed()->first();

        if (!is_null($floor_trashed)) {
            $floor_trashed->update([
                Floor::ID => data_get($request, 'number'),
                Floor::NAME => data_get($request, Floor::NAME),
                Floor::CREATED_BY   => $this->user->id,
                Floor::UPDATED_BY   => $this->user->id,
                Floor::DELETED_BY => NULL,
                Floor::DELETED_AT => NULL,
                Floor::IS_DELETED => 0,
            ]);
        } else {
            /**
             * Create Floor without trashed data
             */
            Floor::updateOrCreate([
                Floor::ID => data_get($request, 'number'),
            ], [
                Floor::ID => data_get($request, 'number'),
                Floor::NAME => data_get($request, Floor::NAME),
                Floor::CREATED_BY   => $this->user->id,
                Floor::UPDATED_BY   => $this->user->id,
            ]);
        }

        session()->flash('success', 'Floor has been created !!');
        return redirect()->route('admin.floor.index');
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
        /**
         * Checking permission 
         */
        $this->isAuthenticated($this->user, Floor::PERMISSION_EDIT);

        $floor = Floor::find($id);
        return view('backend.pages.floor.edit', compact('floor'));
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
        /**
         * Checking permission 
         */
        $this->isAuthenticated($this->user, Floor::PERMISSION_EDIT);

        /**
         * Validation requests
         */
        $request->validate(Floor::$rules);

        $floor = Floor::findOrFail($id);
        $floor->update([
            Floor::ID => data_get($request, 'number'),
            Floor::NAME => data_get($request, Floor::NAME),
            Floor::UPDATED_BY   => $this->user->id
        ]);

        session()->flash('success', 'Floor has been updated !!');
        return redirect()->route('admin.floor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * Checking permission 
         */
        $this->isAuthenticated($this->user, Floor::PERMISSION_DELETE);

        $floor = Floor::findOrFail($id);
        if (!is_null($floor)) {
            $floor->delete();
        }

        session()->flash('success', 'Floor has been deleted !!');
        return back();
    }
}

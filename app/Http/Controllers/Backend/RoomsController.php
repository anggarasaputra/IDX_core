<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Library\TraitRoomsPermission;
use App\Models\Master\Floor;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RoomsController extends Controller
{
    use TraitRoomsPermission;

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
        $this->isAuthenticated($this->user, Rooms::PERMISSION_VIEW);

        $rooms = Rooms::orderBy('id', 'asc')->get();
        return view('backend.pages.rooms.index', compact('rooms'));
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
        $this->isAuthenticated($this->user, Rooms::PERMISSION_CREATE);

        $floors = Floor::select([Floor::ID, Floor::NAME])->orderBy('id', 'asc')->get();
        return view('backend.pages.rooms.create', compact('floors'));
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
        $this->isAuthenticated($this->user, Rooms::PERMISSION_CREATE);

        $request->validate(Rooms::$rules);

        try {
            $gambar_path = '';
            if ($request->hasFile('gambar')) {
                $filenameWithExt = $request->file('gambar')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('gambar')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $gambar_path     = $request->file('gambar')->storeAs('gambar', $fileNameToStore, ['disk' => 'public']);
            }

            Rooms::create([
                Rooms::NAMA_RUANGAN => $request->nama_ruangan,
                Rooms::ID_LANTAI    => $request->id_lantai,
                Rooms::DESKRIPSI    => $request->deskripsi,
                Rooms::KAPASITAS    => $request->kapasitas,
                Rooms::GAMBAR       => $gambar_path,
                Rooms::CREATED_BY   => $this->user->id,
                Rooms::UPDATED_BY   => $this->user->id,
            ]);

            session()->flash('success', 'Rooms has been created !!');
            return redirect()->route('admin.rooms.index');
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage() ?? 'Something went wrong while processing data');
            return back();
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
    public function edit($id)
    {
        /**
         * Checking permission 
         */
        $this->isAuthenticated($this->user, Rooms::PERMISSION_EDIT);

        $room = Rooms::find($id);
        $floors = Floor::select([Floor::ID, Floor::NAME])->orderBy('id', 'asc')->get();

        return view('backend.pages.rooms.edit', compact('room', 'floors'));
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
        $this->isAuthenticated($this->user, Rooms::PERMISSION_EDIT);

        $request->validate(
            array_merge(Rooms::$rules, [
                Rooms::GAMBAR => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048'
            ])
        );

        $room = Rooms::findOrFail($id);

        try {
            $gambar_path = $room->gambar;
            if ($request->hasFile('gambar')) {
                $filenameWithExt = $request->file('gambar')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('gambar')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $gambar_path     = $request->file('gambar')->storeAs('gambar', $fileNameToStore, ['disk' => 'public']);

                $gambar_delete = Storage::path('public/' . $room->gambar);
            }

            $room->update([
                Rooms::NAMA_RUANGAN => $request->nama_ruangan,
                Rooms::ID_LANTAI    => $request->id_lantai,
                Rooms::DESKRIPSI    => $request->deskripsi,
                Rooms::KAPASITAS    => $request->kapasitas,
                Rooms::GAMBAR       => $gambar_path,
                Rooms::CREATED_BY   => $this->user->id,
                Rooms::UPDATED_BY   => $this->user->id,
            ]);

            if (isset($gambar_delete) && File::exists($gambar_delete)) File::delete($gambar_delete);

            session()->flash('success', 'Rooms has been updated !!');
            return redirect()->route('admin.rooms.index');
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage() ?? 'Something went wrong while processing data');
            return back();
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
        /**
         * Checking permission 
         */
        $this->isAuthenticated($this->user, Rooms::PERMISSION_DELETE);

        $room = Rooms::findOrFail($id);

        $gambar_delete = Storage::path('public/' . data_get($room, 'gambar'));
        if (isset($gambar_delete) && File::exists($gambar_delete)) {
            File::delete($gambar_delete);
        }

        if (!is_null($room)) {
            $room->delete();
        }

        session()->flash('success', 'Room has been deleted !!');
        return back();
    }
}

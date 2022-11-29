<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public $user;


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
    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('gallery.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any gallery !');
        }

        $galleries = Gallery::all();
        return view('backend.pages.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('gallery.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any gallery !');
        }
        
        return view('backend.pages.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('gallery.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any gallery !');
        }

        // Validation Data
        $request->validate(Gallery::$rules_create);

        // Get Image File
        $gambar_path = '';
        if ($request->hasFile('gambar')) {
            $filenameWithExt = $request->file('gambar')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('gambar')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $gambar_path     = $request->file('gambar')->storeAs('gambar', $fileNameToStore, ['disk' => 'public']);
        }

        // Process Data
        Gallery::create([
            Gallery::NAMA_RUANGAN => $request->nama_ruangan, 
            Gallery::TIPE         => $request->tipe,
            Gallery::DESKRIPSI    => $request->deskripsi, 
            Gallery::KAPASITAS    => $request->kapasitas, 
            Gallery::GAMBAR       => $gambar_path, 
            Gallery::CREATED_BY   => $this->user->id,
            Gallery::UPDATED_BY   => $this->user->id,
        ]);

        session()->flash('success', 'Gallery has been created !!');
        return back();
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
        if (is_null($this->user) || !$this->user->can('gallery.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any gallery !');
        }

        $gallery = Gallery::find($id);
        return view('backend.pages.gallery.edit', compact('gallery'));
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
        if (is_null($this->user) || !$this->user->can('gallery.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any gallery !');
        }

        // Validation Data
        $request->validate(Gallery::$rules_update);

        $gallery = Gallery::findOrFail($id);

        $gambar_path = '';
        if ($request->hasFile('gambar')) {
            $filenameWithExt = $request->file('gambar')->getClientOriginalName();
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('gambar')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $gambar_path  = $request->file('gambar')->storeAs('gambar', $fileNameToStore, ['disk' => 'public']);

            $gambar_delete = Storage::path('public/' . $gallery->gambar);
        }

        $gallery->update([
            Gallery::NAMA_RUANGAN => $request->nama_ruangan, 
            Gallery::TIPE         => $request->tipe,
            Gallery::DESKRIPSI    => $request->deskripsi, 
            Gallery::KAPASITAS    => $request->kapasitas, 
            Gallery::GAMBAR       => $gambar_path, 
            Gallery::UPDATED_BY   => $this->user->id,
        ]);

        if (isset($gambar_delete) && File::exists($gambar_delete)) File::delete($gambar_delete);

        session()->flash('success', 'Gallery has been updated !!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('gallery.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any gallery !');
        }


        $gallery = Gallery::findOrFail($id);
        if (!is_null($gallery)) {
            $gallery->delete();
        }

        session()->flash('success', 'Gallery has been deleted !!');
        return back();
    }
}

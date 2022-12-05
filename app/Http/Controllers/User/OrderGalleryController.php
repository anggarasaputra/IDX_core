<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderGallery;
use App\Models\Gallery;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderGalleryController extends Controller
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
     * Display a listing User of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('user_gallery.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view list gallery !');
        }

        $galleries = Gallery::orderBy('id', 'asc')->get();
        return view('backend.pages.order-gallery-user.index', compact('galleries'));
    }
}

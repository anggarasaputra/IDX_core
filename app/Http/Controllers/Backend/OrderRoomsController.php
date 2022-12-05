<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderRooms;
use App\Models\Rooms;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderRoomsController extends Controller
{

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
     * Display a listing User of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('user_rooms.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view list meeting room !');
        }

        $rooms = Rooms::with('lantai')->orderBy('id', 'asc')->get();
        return view('backend.pages.order-rooms.index', compact('rooms'));
    }
}

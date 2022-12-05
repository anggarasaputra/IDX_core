<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderGallery;
use App\Models\Order\OrderRooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('dashboard_user.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        } else if (!$this->user->hasRole('user')) {
            return redirect()->route('admin.dashboard');
        }

        $total_room_book = OrderRooms::where(OrderRooms::STATUS, OrderRooms::STATUS_APPROVE)
            ->where(OrderRooms::ID_USER, $this->user->id)
            ->count();
        $total_room_done = OrderRooms::where(OrderRooms::STATUS, OrderRooms::STATUS_DONE)
            ->where(OrderRooms::ID_USER, $this->user->id)
            ->count();
        $total_gallery_book = OrderGallery::where(OrderGallery::STATUS, OrderGallery::STATUS_APPROVE)
            ->where(OrderGallery::ID_USER, $this->user->id)
            ->count();
        $total_gallery_done = OrderGallery::where(OrderGallery::STATUS, OrderGallery::STATUS_DONE)
            ->where(OrderGallery::ID_USER, $this->user->id)
            ->count();

        $last_order_rooms = OrderRooms::with('room')
            ->where(OrderRooms::ID_USER, $this->user->id)
            ->orderBy(OrderRooms::CREATED_AT, 'DESC')
            ->limit(5)
            ->get();
        $last_order_gallery = OrderGallery::with('gallery')
            ->where(OrderGallery::ID_USER, $this->user->id)
            ->orderBy(OrderGallery::CREATED_AT, 'DESC')
            ->limit(5)
            ->get();

        return view('backend.pages.dashboard-user.index', compact('total_room_book', 'total_room_done', 'total_gallery_book', 'total_gallery_done', 'last_order_rooms', 'last_order_gallery'));
    }
}

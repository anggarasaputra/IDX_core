<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderGallery;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('order_gallery.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any gallery !');
        }

        $orderGalleries = OrderGallery::orderBy(OrderGallery::CREATED_AT, 'DESC')
            ->get();
        return view('backend.pages.order-gallery.index', compact('orderGalleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
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
        // 
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
        // 
    }

    /**
     * Approve the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('order_gallery.approve')) {
            abort(403, 'Sorry !! You are Unauthorized to approve any order gallery !');
        }

        $orderGallery = OrderGallery::findOrFail($id);

        $orderGallery->update([
            OrderGallery::STATUS => OrderGallery::STATUS_APPROVE,
            OrderGallery::UPDATED_BY   => $this->user->id,
        ]);

        session()->flash('success', 'Order Gallery has been approved !!');
        return redirect()->route('admin.order-gallery.index');
    }

    /**
     * Reject the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('order_gallery.reject')) {
            abort(403, 'Sorry !! You are Unauthorized to reject any order gallery !');
        }

        $orderGallery = OrderGallery::findOrFail($id);

        $orderGallery->update([
            OrderGallery::STATUS => OrderGallery::STATUS_REJECT,
            OrderGallery::UPDATED_BY   => $this->user->id,
        ]);

        session()->flash('success', 'Order Gallery has been rejected !!');
        return redirect()->route('admin.order-gallery.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
    }
}

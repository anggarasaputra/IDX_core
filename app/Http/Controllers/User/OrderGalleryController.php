<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order\OrderGallery;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

    /**
     * Display a listing User of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderIndex(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('user_gallery.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view list gallery !');
        }

        $orderGalleries = OrderGallery::where(OrderGallery::ID_USER, $this->user->id)
            ->orderBy(OrderGallery::CREATED_AT, 'DESC')
            ->get();
        return view('backend.pages.order-gallery-user.order', compact('orderGalleries'));
    }

    public function qrcode(Request $request, Gallery $gallery)
    {
        return view('backend.pages.order-gallery-user.qr-code', compact('gallery'));
    }

    public function qrcodeAjax(Request $request)
    {
        if (isset($request->url)) {
            parse_str(parse_url($request->url, PHP_URL_QUERY), $query);
            $id = $query['token'] ?? null;
            $kode_ruang = $id ? base64_decode(urldecode($id)) : '';
            $kode = explode('|', trim($kode_ruang));

            if (count($kode) !== 2 || $kode[0] !== 'G') {
                session()->flash('error', 'QR Code Tidak Valid! (salah qr & tipe)');
                return redirect()->back();
            }
            

            $room_id  = $kode[1];
            $order = OrderGallery::with('gallery')
                ->where(OrderGallery::STATUS, OrderGallery::STATUS_APPROVE)
                ->where(OrderGallery::ID_ROOM, $room_id)
                ->where(OrderGallery::ID_USER, $this->user->id)
                ->first();

            if (!$order) {
                session()->flash('error', 'QR Code Tidak Valid! (tidak ada order)');
                return redirect()->back();
            }

            $dateNow = date('Y-m-d H:i:s');
            $order_start = date('Y-m-d H:i:s', strtotime($order->awal));
            $order_end = date('Y-m-d H:i:s', strtotime($order->akhir));

            if (!($order_start <= $dateNow && $order_end >= $dateNow)) {
                session()->flash('error', 'Waktu Validasi Tidak Sesuai Dengan Waktu Order!');
                return redirect()->back();
            }

            $order->update(['status' => OrderGallery::STATUS_DONE]);

            session()->flash('success', 'Order Gallery Validated.');
            return redirect()->route('user.gallery.order-index');
        }
    }

    public function calendar(Request $request, Gallery $gallery)
    {
        return view('backend.pages.order-gallery-user.calendar', compact('gallery'));
    }

    public function calendarAjax(Request $request)
    {
        $room_id = $request->room_id;
        $start = date('Y-m-d H:i:s', strtotime($request->start));
        $end = date('Y-m-d H:i:s', strtotime($request->end));;
        $events = [];

        $orderGallery = OrderGallery::with('user')
            ->where(OrderGallery::ID_ROOM, $room_id)
            ->where(OrderGallery::AWAL, '>=', $start)
            ->where(OrderGallery::AKHIR, '<=', $end)
            ->get();

        foreach ($orderGallery as $order) {
            $events[] = [
                'title' => 'Acara oleh ' . $order->user->name,
                'start' => $order->awal,
                'end' => $order->akhir,
            ];
        }

        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, Gallery $gallery)
    {
        $next_order = OrderGallery::where(OrderGallery::ID_ROOM, $gallery->id)
            ->whereIn(OrderGallery::STATUS, [OrderGallery::STATUS_APPROVE, OrderGallery::STATUS_DONE])
            ->where(OrderGallery::AWAL, '>=', date('Y-m-d H:i:s'))
            ->get();
        return view('backend.pages.order-gallery-user.detail', compact('gallery', 'next_order'));
    }

    private function kodeBookingGallery()
    {
        //jumlah panjang karakter angka dan huruf.
        $length_abjad = "2";
        $length_angka = "3";

        //huruf yg dimasukan, kecuali I,L dan O
        $huruf = "ABCDEFGHJKMNPRSTUVWXYZ";

        //mulai proses generate huruf
        $i = 1;
        $txt_abjad = "";
        while ($i <= $length_abjad) {
            $txt_abjad .= $huruf[mt_rand(0, strlen($huruf) - 1)];
            $i++;
        }

        //mulai proses generate angka
        $datejam = date("His");
        $time_md5 = rand(time(), $datejam);
        $cut = substr($time_md5, 0, $length_angka);

        //mennggabungkan dan mengacak hasil generate huruf dan angka
        $acak = str_shuffle($txt_abjad . $cut);

        return 'G' . $acak;
    }

    /**
     * Store a newly order resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
        // Validation Data
        $request->validate(OrderGallery::$rules);

        $check = 1;
        while ($check > 0) {
            $kode_booking = $this->kodeBookingGallery();
            $check = OrderGallery::where(OrderGallery::KODE_BOOKING, $kode_booking)->count();
        }

        // validate waktu order dengan yang sudah ada.
        $checkOrder = OrderGallery::whereIn(OrderGallery::STATUS, [OrderGallery::STATUS_APPROVE, OrderGallery::STATUS_DONE])
            ->where(function ($query) use ($request) {
                $query->whereBetween(OrderGallery::AWAL, [$request->awal, $request->akhir])
                    ->orWhereBetween(OrderGallery::AKHIR, [$request->awal, $request->akhir])
                    ->orWhere(function ($query) use ($request) {
                        $query->where(OrderGallery::AWAL, '<=', $request->awal)
                            ->where(OrderGallery::AKHIR, '>=', $request->akhir);
                    });
            })->count();
        if ($checkOrder > 0) {
            throw ValidationException::withMessages(['awal' => "Waktu Order tidak tersedia!"]);
        }

        // Process Data
        OrderGallery::create([
            OrderGallery::ID_ROOM => $request->id_room,
            OrderGallery::ID_USER => $this->user->id,
            OrderGallery::AWAL => $request->awal,
            OrderGallery::AKHIR => $request->akhir,
            OrderGallery::KODE_BOOKING => $kode_booking,
            OrderGallery::STATUS => OrderGallery::STATUS_DRAFT,
            OrderGallery::CREATED_BY => $this->user->id,
            OrderGallery::UPDATED_BY => $this->user->id,
        ]);

        session()->flash('success', 'Order Gallery has been created !!');
        return redirect()->route('user.gallery');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderGallery = OrderGallery::findOrFail($id);
        // cek apakah order ada dan dibuat oleh user tersebut.
        if (!is_null($orderGallery) && $orderGallery->{ORDERGallery::CREATED_BY} == $this->user->id) {
            $orderGallery->delete();
            session()->flash('success', 'Order Gallery has been deleted !!');
        } else {
            session()->flash('eroror', 'Order Gallery not found !!');
        }

        return back();
    }
}

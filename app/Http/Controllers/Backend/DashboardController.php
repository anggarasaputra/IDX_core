<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Order\OrderGallery;
use App\Models\Order\OrderRooms;
use App\Models\Rooms;
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


    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        } else if (!$this->user->hasRole(['superadmin'])) {
            return redirect()->route('user.dashboard');
        }

        $total_room_book = OrderRooms::count();
        $total_room_done = OrderRooms::whereIn(OrderRooms::STATUS, [OrderRooms::STATUS_APPROVE, OrderRooms::STATUS_DONE])->count();
        $total_room_reject = OrderRooms::whereIn(OrderRooms::STATUS, [OrderRooms::STATUS_REJECT])->count();
        $total_gallery_book = OrderGallery::count();
        $total_gallery_done = OrderGallery::whereIn(OrderGallery::STATUS, [OrderGallery::STATUS_APPROVE, OrderGallery::STATUS_DONE])->count();
        $total_gallery_reject = OrderGallery::whereIn(OrderGallery::STATUS, [OrderGallery::STATUS_REJECT])->count();

        $last_order_rooms = OrderRooms::with('room')
            ->orderBy(OrderRooms::CREATED_AT, 'DESC')
            ->limit(5)
            ->get();
        $last_order_gallery = OrderGallery::with('gallery')
            ->orderBy(OrderGallery::CREATED_AT, 'DESC')
            ->limit(5)
            ->get();

        $qrcode_url = $this->createUrl();
        $rand_booking = $this->kodeBooking();
        return view('backend.pages.dashboard.index', compact('total_room_book', 'total_room_done', 'total_room_reject', 'total_gallery_book', 'total_gallery_done', 'total_gallery_reject', 'last_order_rooms', 'last_order_gallery', 'qrcode_url', 'rand_booking'));
    }

    public function indexUser()
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

    public function qrcode(Request $request)
    {
        if (isset($request->url)) {
            parse_str(parse_url($request->url, PHP_URL_QUERY), $query);
            $id = $query['token'] ?? null;
            $kode_ruang = $id ? base64_decode(urldecode($id)) : '-';
            session()->flash('success', 'QR Code: ' . $request->url . ' | Kode Ruang: ' . $kode_ruang);
            return redirect()->back();
        }
    }

    public function createUrl()
    {
        $type = (['G', 'M'])[rand(0, 1)];
        if ($type == 'M') {
            $randRooms = Rooms::inRandomOrder()->first();
        } else {
            $randRooms = Gallery::inRandomOrder()->first();
        }
        $id = $randRooms ? $randRooms->id : rand(0, 100);
        $kode_ruang = $type . '|' . $id;
        $encryptId = urlencode(base64_encode($kode_ruang));
        $url = route('cheked.qrcode') . '?token=' . $encryptId;

        return [
            'kode_ruang' => $kode_ruang,
            'url' => $url,
        ];
    }

    public function event(Request $request)
    {
        $room_id = $request->room_id;
        $start = date('Y-m-d H:i:s', strtotime($request->start));
        $end = date('Y-m-d H:i:s', strtotime($request->end));;
        $events = [
            [
                'title' => 'Makan Siang',
                'start' => '2022-11-03 13:00:00',
                'end' => '2022-11-03 14:00:00',
            ],
            [
                'title' => 'Rapat',
                'start' => '2022-11-13 11:00:00',
                'end' => '2022-11-13 12:00:00',
            ],
            [
                'title' => 'Kumpulan',
                'start' => '2022-11-18 11:00:00',
                'end' => '2022-11-20 11:00:00'
            ],
            [
                'title' => 'Pesta',
                'start' => '2022-11-29 20:00:00',
                'end' => '2022-11-29 22:00:00'
            ],
        ];

        return response()->json($events);
    }

    public function kodeBooking()
    {
        //jumlah panjang karakter angka dan huruf.
        $length_abjad = "2";
        $length_angka = "4";

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

        return $acak;
    }
}

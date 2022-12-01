<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        }

        $total_roles = count(Role::select('id')->get());
        $total_admins = count(Admin::select('id')->get());
        $total_permissions = count(Permission::select('id')->get());

        $qrcode_url = $this->createUrl();
        $rand_booking = $this->kodeBooking();
        return view('backend.pages.dashboard.index', compact('total_admins', 'total_roles', 'total_permissions', 'qrcode_url', 'rand_booking'));
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
        $id = rand(1, 100);
        $type = (['G', 'M'])[rand(0, 1)];
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
            $txt_abjad .= $huruf[mt_rand(0, strlen($huruf))];
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

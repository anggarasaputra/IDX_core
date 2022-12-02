<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $token = $request->input('token') ?? null;
        $kode_ruang = $token ? base64_decode(urldecode($token)) : null;
        $valid_data = false;
        $data = array(
            'room_id' => null,
            'tipe'    => null,
            'ruangan' => null,
        );
        if ($kode_ruang) {
            $kode = explode('|', trim($kode_ruang));
            if (count($kode) == 2) {
                $data['tipe']     = $kode[0];
                $data['room_id']  = $kode[1];
                if ($kode[0] == 'M') {
                    $data['ruangan'] = Rooms::first();
                } else if ($kode[0] == 'G') {
                    $data['ruangan'] = Gallery::first();
                }
                if ($data['ruangan']) $valid_data = true;
            }
        }

        return view('cheked', compact('kode_ruang', 'valid_data', 'data'));
    }

    public function validateBooking(Request $request)
    {
        $request->validate([
            'room_id'      => 'required|integer',
            'tipe'         => 'required|in:M,G',
            'kode_booking' => 'required|min:6|max:6',
        ]);

        $room_id = $request->room_id;
        $tipe = $request->tipe;
        $kode_booking = $request->kode_booking;

        /**
         * Untuk nantinya trow error jika
         * 1. kode booking tidak ditemukan
         * 2. salah ruangan dengan kode booking yang diinput
         * 3. salah waktu validasi tidak sesuai order
         */
        // throw ValidationException::withMessages(['room_id' => 'Ruangan / Tipe Tidak ditemukan !!']);

        session()->flash('success', 'Kode Booking has been validated !!');
        return redirect()->route('cheked.success', $kode_booking);
    }

    public function successValidate(Request $request, $kode_booking)
    {
        // Nantinya bawa kode booking.
        // Untuk bisa menampilkan pesanan siapa, jam berapa dan ruang yang dipesan
        return view('success');
    }
}

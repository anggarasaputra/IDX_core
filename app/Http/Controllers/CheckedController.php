<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Order\OrderGallery;
use App\Models\Order\OrderRooms;
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
                    $data['ruangan'] = Rooms::with('lantai')->where(Rooms::ID, $data['room_id'])->first();
                } else if ($kode[0] == 'G') {
                    $data['ruangan'] = Gallery::where(Gallery::ID, $data['room_id'])->first();
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

        if ($tipe == 'M') {
            $order = OrderRooms::with('room')
                ->where(OrderRooms::STATUS, OrderRooms::STATUS_APPROVE)
                ->where(OrderRooms::ID_ROOM, $room_id)
                ->where(OrderRooms::KODE_BOOKING, $kode_booking)
                ->first();
        } else {
            $order = OrderGallery::with('gallery')
                ->where(OrderGallery::STATUS, OrderGallery::STATUS_APPROVE)
                ->where(OrderGallery::ID_ROOM, $room_id)
                ->where(OrderGallery::KODE_BOOKING, $kode_booking)
                ->first();
        }

        if (!$order)
            throw ValidationException::withMessages(['kode_booking' => 'Kode Booking Tidak Ditemukan!']);

        $dateNow = date('Y-m-d H:i:s');
        $order_start = date('Y-m-d H:i:s', strtotime($order->awal));
        $order_end = date('Y-m-d H:i:s', strtotime($order->akhir));

        if (!($order_start <= $dateNow && $order_end >= $dateNow))
            throw ValidationException::withMessages(['kode_booking' => "Waktu Validasi Tidak Sesuai Dengan Waktu Order!"]);

        $order->update(['status' => OrderRooms::STATUS_DONE]);

        $token = urlencode(base64_encode($tipe . '|' . $kode_booking));

        session()->flash('success', 'Kode Booking has been validated !!');
        return redirect()->route('cheked.success', $token);
    }

    public function successValidate(Request $request, $token)
    {
        // Nantinya bawa kode booking.
        // Untuk bisa menampilkan pesanan siapa, jam berapa dan ruang yang dipesan
        $kode = $token ? base64_decode(urldecode($token)) : null;
        $valid_data = false;
        $order = null;

        if ($kode) {
            $kode = explode('|', trim($kode));
            if (count($kode) == 2) {
                $tipe = $kode[0];
                $kode_booking = $kode[1];
                if ($tipe == 'M') {
                    $order = OrderRooms::with(['user', 'room'])
                        ->where(OrderRooms::KODE_BOOKING, $kode_booking)
                        ->first();
                } else {
                    $order = OrderGallery::with(['user', 'gallery'])
                        ->where(OrderGallery::KODE_BOOKING, $kode_booking)
                        ->first();
                }
                if ($order) $valid_data = true;
            }
        }
        return view('success', compact('valid_data', 'order'));
    }
}

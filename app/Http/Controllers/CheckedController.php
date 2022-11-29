<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $token = $request->input('token') ?? '';
        $kode_ruang = base64_decode(urldecode($token));

        return view('cheked', compact('kode_ruang'));
    }
}

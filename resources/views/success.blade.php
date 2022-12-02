@extends('layouts.master')

@section('title')
    Success Cheked QR COde | IDX
@endsection

@section('styles')
    <style type="text/css">
        .login-box form {
            margin: auto;
            width: 650px;
            max-width: 100%;
            background: #fff;
            border-radius: 3px;
        }
    </style>
@endsection

@section('content')
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                @if ($valid_data)
                    <form>
                        <div class="login-form-head">
                            <h1><i class="fa fa-check text-white"></i></h1>
                            <h4>{{ __('Sukses Validasi Ruangan') }}</h4>
                            <p>Terimakasih telah validasi, silahkan menggunakan ruangan anda sampai batas pemesanan!</p>
                        </div>
                        <div class="login-form-body">
                            @if ($order)
                                @php
                                    $tipe = isset($order->room) ? 'M' : 'G';
                                    $ruangan = $tipe == 'M' ? $order->room : $order->gallery;
                                @endphp
                                <div class="card card-bordered">
                                    <img class="card-img-top img-fluid" src="{{ url('/storage/' . $ruangan->gambar) }}"
                                        alt="gambar ruangan">
                                    <div class="card-body">
                                        <h5 class="title">Nama Pemesan : {{ $order->user->name }}</h5>
                                        <h5 class="title">Waktu Mulai : {{ \Carbon\Carbon::parse($order->awal)->translatedFormat('d F Y H:i') }}</h5>
                                        <h5 class="title">Waktu Selesai : {{ \Carbon\Carbon::parse($order->akhir)->translatedFormat('d F Y H:i') }}</h5>
                                        <h5 class="title">Nama {{ $tipe == 'M' ? 'Meeting Room' : 'Gallery' }} :
                                            {{ $ruangan->nama_ruangan }}</h5>
                                        @if ($tipe == 'M')
                                            <h5 class="title">Lantai : {{ $ruangan->lantai->name }}</h5>
                                        @else
                                            <h5 class="title">Tipe : {{ $ruangan->tipe }}</h5>
                                        @endif
                                        <h5 class="title">Kapasitas : {{ $ruangan->kapasitas }}</h5>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        </div>
                    </form>
                @else
                    <form>
                        <div class="login-form-head">
                            <h4>{{ __('Not Valid QR Code') }}</h4>
                            <p>QR Code yang anda scan tidak valid!</p>
                            <p>Coba scan kembali.</p>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

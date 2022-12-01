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
                <form>
                    <div class="login-form-head">
                        <h1><i class="fa fa-check text-white"></i></h1>
                        <h4>{{ __('Sukses Validasi Ruangan') }}</h4>
                        <p>Terimakasih telah validasi, silahkan menggunakan ruangan anda sampai batas pemesanan!</p>
                    </div>
                    <div class="login-form-body">
                        @include('layouts.partials.messages')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

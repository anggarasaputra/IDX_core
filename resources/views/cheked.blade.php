@extends('layouts.master')

@section('title')
    Cheked QR COde | IDX
@endsection

@section('content')
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <div class="col-md-12">
                    <div class="card card-bordered">
                        <div class="card-header">{{ __('Checked QR Code') }}</div>

                        <div class="card-body">
                                <div class="alert alert-success" role="alert">
                                    Kode Ruang : {{ $kode_ruang }}
                                </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

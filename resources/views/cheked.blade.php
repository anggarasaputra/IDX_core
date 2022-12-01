@extends('layouts.master')

@section('title')
    Cheked QR COde | IDX
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

        input[type="text"] {
            font-size: 24px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                @if ($valid_data)
                    <form method="POST" action="{{ route('cheked.validate') }}">
                        @csrf
                        <div class="login-form-head">
                            <h4>{{ __('Validasi Kode Booking') }}</h4>
                            <p>Masukan Kode Booking Ruang Yang Anda Pesan!</p>
                        </div>
                        <div class="login-form-body">
                            <div class="alert alert-success" role="alert">
                                Kode Ruang : {{ $kode_ruang ?? '-' }}
                            </div>
                            @if ($data['ruangan'])
                                <div class="card card-bordered">
                                    <img class="card-img-top img-fluid"
                                        src="{{ url('/storage/gambar/digital-talent-expanding-gap_1669626945.jpg') }}"
                                        alt="gambar ruangan">
                                    <div class="card-body">
                                        <h5 class="title">{{ $data['ruangan']->nama_ruangan }}</h5>
                                        <span>
                                            <span class="badge badge-success">
                                                {{ $data['tipe'] == 'M' ? $data['ruangan']->lantai : $data['ruangan']->tipe }}
                                            </span>
                                            <span class="badge badge-info">
                                                <i class="fa fa-user"></i> {{ $data['ruangan']->kapasitas }}
                                            </span>
                                        </span>
                                        <p class="card-text">
                                            {{ $data['ruangan']->deskripsi }}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            @include('layouts.partials.messages')
                            <br>
                            <div class="form-gp">
                                <label for="kode_booking">Kode Booking</label>
                                <input type="hidden" id="room_id" name="room_id" value="{{ $data['room_id'] }}">
                                <input type="hidden" id="tipe" name="tipe" value="{{ $data['tipe'] }}">
                                <input type="text" id="kode_booking" name="kode_booking" maxlength="6"
                                    value="{{ old('kode_booking') }}" class="@error('kode_booking') is-invalid @enderror">
                                <i class="ti-key"></i>
                                <div class="text-danger">
                                    @error('kode_booking')
                                        {{ $message }}
                                    @enderror
                                </div>

                            </div>
                            <div class="submit-btn-area">
                                <button id="form_submit" type="submit">Validasi <i class="ti-arrow-right"></i></button>
                            </div>
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

@section('scripts')
    <script>
        $('#kode_booking').keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });
    </script>
@endsection

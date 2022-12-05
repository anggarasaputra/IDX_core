@extends('backend.layouts.master')

@section('title')
    Dashboard Page - Admin Panel
@endsection


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Dashboard</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><span>Dashboard</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 clearfix">
                @include('backend.layouts.partials.logout')
            </div>
        </div>
    </div>
    <!-- page title area end -->

    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4 mt-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <a href="{{ route('admin.roles.index') }}">
                                    <div class="p-4 d-flex justify-content-between align-items-center">
                                        <div class="seofct-icon"><i class="fa fa-users"></i> Meeting Room Book</div>
                                        <h2>{{ $total_room_book }}</h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-md-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg2">
                                <a href="{{ route('admin.admins.index') }}">
                                    <div class="p-4 d-flex justify-content-between align-items-center">
                                        <div class="seofct-icon"><i class="fa fa-user"></i> Meeting Room Done</div>
                                        <h2>{{ $total_room_done }}</h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-md-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg3">
                                <a href="{{ route('admin.admins.index') }}">
                                    <div class="p-4 d-flex justify-content-between align-items-center">
                                        <div class="seofct-icon"><i class="fa fa-user"></i> Meeting Room Reject</div>
                                        <h2>{{ $total_room_reject }}</h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-md-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="fa fa-users"></i> Gallery Book</div>
                                    <h2>{{ $total_gallery_book }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-md-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg2">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="fa fa-user"></i> Gallery Done</div>
                                    <h2>{{ $total_gallery_done }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-md-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg3">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="fa fa-user"></i> Gallery Reject</div>
                                    <h2>{{ $total_gallery_reject }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4 class="header-title mb-0">Meeting Terakhir</h4>
                        </div>
                        <div class="member-box">
                            @if (count($last_order_rooms) > 0)
                                @foreach ($last_order_rooms as $order_room)
                                    @php
                                        $waktu_awal = \Carbon\Carbon::parse($order_room->awal)->translatedFormat('d F Y H:i');
                                        $waktu_akhir = \Carbon\Carbon::parse($order_room->akhir)->translatedFormat('d F Y H:i');
                                    @endphp
                                    <div class="s-member">
                                        <div class="media align-items-center">
                                            <div class="media-body ml-5">
                                                <p>{{ $waktu_awal . ' sampai ' . $waktu_akhir . ' Di ruang ' . $order_room->room->nama_ruangan }}
                                                </p>
                                            </div>
                                            <div class="tm-social">
                                                {{ $order_room->statusName }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="s-member">
                                    <div class="media align-items-center">
                                        <div class="media-body ml-5">
                                            <span>Kosong</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4 class="header-title mb-0">Gallery Terakhir</h4>
                        </div>
                        <div class="member-box">
                            @if (count($last_order_gallery) > 0)
                                @foreach ($last_order_gallery as $order_gallery)
                                    @php
                                        $waktu_awal = \Carbon\Carbon::parse($order_gallery->awal)->translatedFormat('d F Y H:i');
                                        $waktu_akhir = \Carbon\Carbon::parse($order_gallery->akhir)->translatedFormat('d F Y H:i');
                                    @endphp
                                    <div class="s-member">
                                        <div class="media align-items-center">
                                            <div class="media-body ml-5">
                                                <p>{{ $waktu_awal . ' sampai ' . $waktu_akhir . ' Di ruang ' . $order_gallery->gallery->nama_ruangan }}
                                                </p>
                                            </div>
                                            <div class="tm-social">
                                                {{ $order_gallery->statusName }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="s-member">
                                    <div class="media align-items-center">
                                        <div class="media-body ml-5">
                                            <span>Kosong</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- Untuk Plugins Webcodecamjquery --}}
            <div class="col-md-6 mt-5 mb-3">
                <div class="card card-bordered">
                    <div class="card-header">
                        <h3>Scan QR Code Ruang Meeting</h3>
                    </div>
                    <div class="card-body">
                        @include('backend.layouts.partials.messages')
                        <div onload="myFunction()" class="body">
                            <div class="form-group">
                                <label>Pilih Kamera</label>
                                <select class="form-control" id="camera-select"></select>
                            </div>
                            <hr>
                            <center>
                                <canvas width="320" height="240" id="webcodecam-canvas"></canvas>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5 mb-3">
                <div class="card card-bordered">
                    <div class="card-header">
                        <h3>Download QR Code Ruang Meeting</h3>
                    </div>
                    <div class="card-body">
                        <div class="seo-fact sbg1">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-key"></i> Random Kode Booking</div>
                                <h2>{{ $rand_booking }}</h2>
                            </div>
                        </div><br>
                        <div class="seo-fact sbg4">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-list-alt"></i> Random Kode Ruang</div>
                                <h2>{{ $qrcode_url['kode_ruang'] }}</h2>
                            </div>
                        </div>
                        <div class="alert alert-success" role="alert">
                            Url QR Code : <a href="{{ $qrcode_url['url'] }}" target="_blank">{{ $qrcode_url['url'] }}</a>
                        </div>
                        @php
                            $google_url = 'https://chart.googleapis.com/chart?chs=450x450&cht=qr&chl=' . $qrcode_url['url'] . '&chld=Q';
                        @endphp
                        <center>
                            <a href="{{ $google_url }}" download="qrcode-{{ $qrcode_url['kode_ruang'] }}.jpg"
                                target="_blank">
                                <img src="{{ $google_url }}" alt="QR code">
                            </a>
                        </center>
                    </div>
                </div>
            </div>
            {{-- Untuk Plugins Fullcalendar --}}
            <div class="col-md-12 mt-5 mb-3">
                <div class="card card-bordered">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    {{-- Untuk Plugins Webcodecamjquery --}}
    <style>
        canvas {
            height: 100%;
            width: 100%;
            background: #f2f2f2;
        }
    </style>
    {{-- Untuk Plugins Fullcalendar --}}
    <link href="{{ asset('plugins/fullcalendar/main.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    {{-- Untuk Plugins Webcodecamjquery --}}
    <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/qrcodelib.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/webcodecamjquery.js') }}"></script>
    <script type="text/javascript">
        var arg = {
            width: 640,
            height: 480,
            resultFunction: function(result) {
                var redirect = '{{ route('admin.dashboard.qrcode') }}';
                $.redirectPost(redirect, {
                    url: result.code
                });
            }
        };

        var decoder = $("#webcodecam-canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
        // decoder.buildSelectMenu("#camera-select");
        /* Select environment camera if available */
        decoder.buildSelectMenu('#camera-select', 'environment|back');
        decoder.play();

        $('#camera-select').on('change', function() {
            decoder.stop().play();
        });

        // jquery extend function
        $.extend({
            redirectPost: function(location, args) {
                var form = '<input type="hidden" name="_token" value="{{ csrf_token() }}" />';
                $.each(args, function(key, value) {
                    form += '<input type="hidden" name="' + key + '" value="' + value + '">';
                });
                $('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body')
                    .submit();
            }
        });
    </script>
    {{-- Untuk Plugins Fullcalendar --}}
    <script type="text/javascript" src="{{ asset('plugins/fullcalendar/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/fullcalendar/locales-all.js') }}"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                locale: 'id',
                navLinks: true, // can click day/week names to navigate views
                businessHours: true, // display business hours
                fixedWeekCount: false,
                eventSources: [{
                    url: '{{ route('admin.dashboard.event') }}',
                    method: 'POST',
                    extraParams: {
                        _token: '{{ csrf_token() }}',
                        room_id: '1',
                    },
                    failure: function() {
                        alert('terjadi kesalahan saat mengambil acara!');
                    },
                }, ],
            });
            calendar.render();
        });
    </script>
@endsection

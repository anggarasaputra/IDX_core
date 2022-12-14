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
                        <li><a href="index.html">Home</a></li>
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
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6 mt-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <a href="{{ route('admin.roles.index') }}">
                                    <div class="p-4 d-flex justify-content-between align-items-center">
                                        <div class="seofct-icon"><i class="fa fa-users"></i> Roles</div>
                                        <h2>{{ $total_roles }}</h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-md-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg2">
                                <a href="{{ route('admin.admins.index') }}">
                                    <div class="p-4 d-flex justify-content-between align-items-center">
                                        <div class="seofct-icon"><i class="fa fa-user"></i> Admins</div>
                                        <h2>{{ $total_admins }}</h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 mb-lg-0">
                        <div class="card">
                            <div class="seo-fact sbg3">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon">Permissions</div>
                                    <h2>{{ $total_permissions }}</h2>
                                </div>
                            </div>
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
                        <div class="seo-fact sbg4">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-list-alt"></i> Kode Ruang</div>
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

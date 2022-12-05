@extends('backend.layouts.master')

@section('title')
    Qr Code Page - User Panel
@endsection


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Dashboard</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('user.gallery.order-index') }}">All Order Gallery</a></li>
                        <li><span>Scan Order Gallery</span></li>
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
            {{-- Untuk Plugins Webcodecamjquery --}}
            <div class="col-md-6 mt-5 mb-3">
                <div class="card card-bordered">
                    <div class="card-header">
                        <h3>Scan QR Code Gallery {{ $gallery->nama_ruangan }}</h3>
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
                        <hr>
                        <a class="btn btn-info btn-block text-white"
                            href="{{ route('user.gallery.order-index') }}">Kembali</a>
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
                var redirect = '{{ route('user.gallery.qr-code-ajax') }}';
                $.redirectPost(redirect, {
                    room_id: {{ $gallery->id }},
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
@endsection

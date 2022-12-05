@extends('backend.layouts.master')

@section('title')
    Dashboard Page - User Panel
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
                    <div class="col-md-6 mt-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg1">
                                <a href="{{ route('admin.roles.index') }}">
                                    <div class="p-4 d-flex justify-content-between align-items-center">
                                        <div class="seofct-icon"><i class="fa fa-users"></i> Meeting Room</div>
                                        <h2>{{ $total_room_book }}</h2>
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
                                        <div class="seofct-icon"><i class="fa fa-user"></i> Meeting Room Done</div>
                                        <h2>{{ $total_room_done }}</h2>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-md-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg3">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="fa fa-users"></i> Gallery</div>
                                    <h2>{{ $total_gallery_book }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-md-5 mb-3">
                        <div class="card">
                            <div class="seo-fact sbg4">
                                <div class="p-4 d-flex justify-content-between align-items-center">
                                    <div class="seofct-icon"><i class="fa fa-user"></i> Gallery Done</div>
                                    <h2>{{ $total_gallery_done }}</h2>
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
    </div>
@endsection

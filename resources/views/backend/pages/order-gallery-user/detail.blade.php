@extends('backend.layouts.master')

@section('title')
    Order Gallery Page - User Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Gallery</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('user.gallery') }}">List Gallery</a></li>
                        <li><span>Order Gallery</span></li>
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
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Order Gallery</h4>
                        <hr>
                        <div class="row">
                            <div class="col-lg-5 col-md-5 mt-5">
                                <img class="card-img-top img-fluid" src="{{ url('/storage/' . $gallery->gambar) }}"
                                    alt="image">
                            </div>
                            <div class="col-lg-7 col-md-7 mt-5">
                                <form action="{{ route('user.gallery.order') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Nama Ruangan</label>
                                        <input type="hidden" name="id_room" value="{{ $gallery->id }}">
                                        <input type="text" value="{{ $gallery->nama_ruangan }}" class="form-control"
                                            readonly>
                                        @error('id_room')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Tipe</label>
                                        <input type="text" value="{{ $gallery->tipe }}" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Kapasitas</label>
                                        <input type="text" value="{{ $gallery->kapasitas }}" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Deskripsi</label>
                                        <input type="text" value="{{ $gallery->deskripsi }}" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Kapan Mau Booking ?</label>
                                        <div class="input-group">
                                            <input type="datetime-local" id="awal" name="awal"
                                                value="{{ old('awal') ?? date('Y-m-d H:i') }}"
                                                class="form-control @error('awal') is-invalid @enderror">
                                            <input type="datetime-local" id="akhir" name="akhir"
                                                value="{{ old('akhir') ?? date('Y-m-d H:i', strtotime('+1 hours')) }}"
                                                class="form-control @error('akhir') is-invalid @enderror">

                                            @error('awal')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            @error('akhir')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <span class="float-right">
                                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Booking</button>
                                    </span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4 class="header-title mb-0">Next Event</h4>
                        </div>
                        <hr>
                        @if (count($next_order) > 0)
                            @php
                                $group_date = null;
                            @endphp
                            @foreach ($next_order as $key => $order)
                                @php
                                    $awal = date('Y-m-d', strtotime($order->awal));
                                    $waktu_awal = \Carbon\Carbon::parse($order->awal)->translatedFormat('H:i');
                                @endphp
                                @if ($awal !== $group_date)
                                    @php
                                        $group_date = $awal;
                                    @endphp
                                    <div class="d-sm-flex justify-content-between align-items-center">
                                        <h4 class="header-title mb-0">
                                            {{ \Carbon\Carbon::parse($group_date)->translatedFormat('d F Y') }}</h4>
                                    </div>
                                @endif

                                <div class="member-box">
                                    <div class="s-member">
                                        <div class="media align-items-center">
                                            <div class="media-body ml-5">
                                                <p>Digunakan oleh : {{ $order->user->name }}</p>
                                            </div>
                                            <div class="tm-social">
                                                {{ $waktu_awal }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="member-box">
                                <div class="s-member">
                                    <div class="media align-items-center">
                                        <div class="media-body ml-5">
                                            <span>Kosong</span>
                                        </div>
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


@section('scripts')
@endsection

@extends('backend.layouts.master')

@section('title')
    Meeting Rooms Page - User Panel
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
                    <h4 class="page-title pull-left">Meeting Rooms</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                        <li><span>List Meeting Rooms</span></li>
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
                        <h4 class="header-title float-left">List Meeting Rooms</h4>
                        @foreach ($rooms as $room)
                            <div class="col-lg-4 col-md-6 mt-5">
                                <div class="card card-bordered">
                                    <img class="card-img-top img-fluid" src="{{ url('/storage/' . $room->gambar) }}"
                                        alt="image">
                                    <div class="card-body">
                                        <h5 class="title">{{ $room->nama_ruangan }}</h5>
                                        <span>
                                            <span class="badge badge-success">
                                                Lantai : {{ $room->lantai->name }}
                                            </span>
                                            <span class="badge badge-info">
                                                <i class="fa fa-user"></i> {{ $room->kapasitas }}
                                            </span>
                                        </span>
                                        <p class="card-text">{{ $room->deskripsi }}</p>
                                        <a href="#" class="btn btn-primary">Booking</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
@endsection
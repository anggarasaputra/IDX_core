@extends('backend.layouts.master')

@section('title')
    Floor Create - Admin Panel
@endsection

@section('styles')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }
    </style>
@endsection


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Floor Create</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.floor.index') }}">All Gallerys</a></li>
                        <li><span>Create Floor</span></li>
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
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Create New Floor</h4>
                        @include('backend.layouts.partials.messages')

                        <form action="{{ route('admin.floor.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="number">Floor Number</label>
                                <input type="number" class="form-control @error('number') is-invalid @enderror"
                                    id="number" value="{{ old('number') }}" name="number"
                                    placeholder="Enter a floor number" autocomplete="off">

                                @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Floor Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" value="{{ old('name') }}" name="name"
                                    placeholder="Enter a floor name" autocomplete="off">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Floor</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection

@section('scripts')
    @include('backend.pages.floor.partials.scripts')
@endsection

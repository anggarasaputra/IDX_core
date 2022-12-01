@extends('backend.layouts.master')

@section('title')
    Rooms Edit - Admin Panel
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
                    <h4 class="page-title pull-left">Rooms Edit - {{ $room->name }}</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.rooms.index') }}">All Gallerys</a></li>
                        <li><span>Edit Rooms</span></li>
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
                        <h4 class="header-title">Edit Rooms</h4>
                        @include('backend.layouts.partials.messages')

                        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label for="nama_ruangan">Nama Ruangan</label>
                                <input type="text" class="form-control @error('nama_ruangan') is-invalid @enderror"
                                    id="nama_ruangan" value="{{ old('nama_ruangan', $room->nama_ruangan) }}"
                                    name="nama_ruangan" placeholder="Enter a Nama Ruangan" autocomplete="off">

                                @error('nama_ruangan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="id_lantai">Lantai</label>
                                <select class="form-control select2 @error('id_lantai') is-invalid @enderror" id="id_lantai"
                                    value="{{ old('id_lantai') }}" name="id_lantai" placeholder="Enter lantai"
                                    autocomplete="off">
                                    <option value="">Select lantai</option>
                                    @foreach ($floors as $floor)
                                        <option value="{{ $floor->id }}"
                                            {{ $room->id_lantai == $floor->id ? 'selected' : '' }}>{{ $floor->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('id_lantai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                    placeholder="Enter a Deskripsi" autocomplete="off">{{ old('deskripsi', $room->deskripsi) }}</textarea>

                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kapasitas">Kapasitas</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user"></i> </div>
                                    </div>
                                    <input type="number" class="form-control @error('kapasitas') is-invalid @enderror"
                                        id="kapasitas" value="{{ old('kapasitas', $room->kapasitas) }}" name="kapasitas"
                                        placeholder="Enter a Kapasitas" autocomplete="off">

                                    @error('kapasitas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Gambar</label>
                                <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                    id="gambar" name="gambar" accept="image/png, image/jpg, image/jpeg">
                                <img class="mt-3 mb-3" src="{{ url('/storage/' . $room->gambar) }}">

                                @error('gambar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update Rooms</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection


@section('scripts')
    @include('backend.pages.rooms.partials.scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script>
        $('.select2').select2({
            placeholder: "Select lantai",
            allowClear: true,
            closeOnSelect: false
        });
    </script>
@endsection

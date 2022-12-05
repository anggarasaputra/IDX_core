@extends('backend.layouts.master')

@section('title')
    Callendar Page - User Panel
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
                        <li><span>Calendar Gallery</span></li>
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
            {{-- Untuk Plugins Fullcalendar --}}
            <div class="col-md-12 mt-5 mb-3">
                <div class="card card-bordered">
                    <div class="card-header">
                        <h3>Calendar Gallery {{ $gallery->nama_ruangan }}</h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
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
    {{-- Untuk Plugins Fullcalendar --}}
    <link href="{{ asset('plugins/fullcalendar/main.css') }}" rel="stylesheet">
@endsection

@section('scripts')
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
                    url: '{{ route('user.gallery.calendar-ajax') }}',
                    method: 'POST',
                    extraParams: {
                        _token: '{{ csrf_token() }}',
                        room_id: {{ $gallery->id }},
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

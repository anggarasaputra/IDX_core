
@extends('backend.layouts.master')

@section('title')
Role Create - Admin Panel
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
                <h4 class="page-title pull-left">Role Create</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.hakaksions.index') }}">All Roles</a></li>
                    <li><span>Create Role</span></li>
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
                    <h4 class="header-title">Create New Role</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.hakaksions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Permission Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter a Permission Name">
                        </div>
                        <div class="form-group">
                            <label for="name">Group Name</label>
                            <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter a Group Name">
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Permission</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection
@extends('errors.errors_layout')

@section('title')
    500 - Internal Server Error
@endsection

@section('error-content')
    <h2>500</h2>
    <p>Internal Server Error!</p>
    <a href="{{ route('auth.login') }}">Back !</a>
@endsection
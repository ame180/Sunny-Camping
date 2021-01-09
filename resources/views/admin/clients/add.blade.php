@extends('layouts.admin')

@section('input')
    @include('admin.clients.client_form')
@endsection

@section('main')
    <div class="container">
        @yield('input')
    </div>
@endsection

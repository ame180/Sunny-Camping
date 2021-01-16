@extends('layouts.admin')

@section('input')
    <clients-form :id="{{ $id ?? 'null'}}" :mode="'{{ $mode }}'"></clients-form>
@endsection

@section('main')
    @yield('input')
@endsection

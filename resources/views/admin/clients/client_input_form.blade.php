@extends('layouts.admin')

@section('input')
    <div data-vue-component="clients-form" data-props="{{ json_encode(['id' => isset($id) ? (int) $id : null, 'mode' => $mode]) }}"></div>
@endsection

@section('main')
    <div class="container">
        @yield('input')
    </div>
@endsection

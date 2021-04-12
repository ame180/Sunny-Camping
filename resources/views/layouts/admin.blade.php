@extends('voyager::master')
@push('css')
    <link rel="stylesheet" href="{{mix('css/app.css')}}"/>
@endpush
@push('javascript')
    <script>
        window.baseUrl = '{{ config('app.url') }}';
    </script>
    <script src="{{mix('js/app.js')}}"></script>
@endpush
@section('content')
    <div id="app" class="container-fluid">
        @yield('main')
    </div>
@endsection

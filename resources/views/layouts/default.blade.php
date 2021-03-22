<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <title>@yield('title', 'Słoneczny Camping - Wicie')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('head')
</head>
<body>
@yield('navbar')
@yield('main')
@yield('footer')
@section('scripts')
    <script>
        window.baseUrl = '{{ config('app.url') }}';
    </script>
    @stack('scripts')
@show
</body>
</html>

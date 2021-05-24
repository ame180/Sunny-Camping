<html>
<head>
    @section('head')
        <title>@yield('title', 'Słoneczny Camping - Wicie')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <link rel="stylesheet" href="{{mix('css/app.css')}}"/>
        @stack('head')
    @show
</head>
<body>
<div id="app">
    @section('navbar')
        <custom-admin-menu :items="{{ menu('admin', '_json') }}"></custom-admin-menu>
    @show
    <div class="container">
        @yield('main')
    </div>
</div>
@section('scripts')
    <script>
        window.baseUrl = '{{ config('app.url') }}';
    </script>
    <script src="{{mix('js/app.js')}}"></script>
    @stack('scripts')
@show
</body>
</html>

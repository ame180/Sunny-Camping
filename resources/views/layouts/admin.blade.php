<html>
<head>
    @section('head')
        <title>@yield('title', 'Słoneczny Camping - Wicie')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{mix('css/app.css')}}"/>
        @stack('head')
    @show
</head>
<body>
@section('navbar')
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="{{env('APP_URL')}}/admin/dashboard">Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @foreach($nav_items as $key => $value)
                    @include('admin.templates.nav_item')
                @endforeach
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{env('APP_URL')}}">Strona główna</a>
                </li>
            </ul>
        </div>
    </nav>
@show
<div class="container">
    @yield('main')
</div>
@section('scripts')
    <script src="{{mix('js/app.js')}}"></script>
    @stack('scripts')
@show
</body>
</html>

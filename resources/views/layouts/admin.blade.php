<html>
<head>
    <title>@yield('title', 'Słoneczny Camping - Wicie')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/all.css')}}"/>
    @yield('head')
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
                @foreach($nav_items as $nav_item)
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
@yield('main')
@yield('footer')
@section('scripts')
    <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    @stack('scripts')
@show
</body>
</html>

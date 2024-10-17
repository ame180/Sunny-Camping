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
<body class="layout-fixed">
<div id="app" class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form class="form-inline mb-0" action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link">
                        Wyloguj
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.clients') }}" class="brand-link">
            <img src="{{mix('images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-sidebar nav-pills flex-column" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.clients') }}" class="nav-link {{ Route::is('admin.clients') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            Klienci
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="content-wrapper p-3 h-auto">
        @yield('main')
    </div>
</div>
<footer class="main-footer">
    <strong>Copyright © 2020-2024.</strong> All rights reserved.
</footer>
@section('scripts')
    <script>
        window.baseUrl = '{{ config('app.url') }}';
    </script>
    <script src="{{mix('js/app.js')}}"></script>
    @stack('scripts')
@show
</body>
</html>

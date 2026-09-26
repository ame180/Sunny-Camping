<html>
<head>
    @section('head')
        <title>@yield('title', 'Słoneczny Camping - Wicie')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
        @stack('head')
    @show
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form class="mb-0" action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link">
                            Wyloguj
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="{{ route('admin.clients', ['departure_date' => now()->toDateString()]) }}" class="brand-link">
                <img src="{{ asset('images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
                <span class="brand-text fw-light">AdminLTE 3</span>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" role="navigation" aria-label="Main navigation">
                    <li class="nav-item">
                        <a href="{{ route('admin.clients', ['departure_date' => now()->toDateString()]) }}" class="nav-link {{ Route::is('admin.clients') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Klienci</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Raporty</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <main class="app-main">
        <div class="app-content p-3">
            @yield('main')
        </div>
    </main>
    <footer class="app-footer">
        <strong>Copyright © 2020-2024.</strong> All rights reserved.
    </footer>
</div>
@section('scripts')
    <script>
        window.baseUrl = '{{ config('app.url') }}';
    </script>
    @stack('scripts')
@show
</body>
</html>

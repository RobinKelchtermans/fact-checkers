<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel sticky-top">
            @include('partials.navbar')
        </nav>
        <main class="py-3 mb-4">
            @include('partials.toasts')
            @yield('content')
        </main>
        <nav class="navbar fixed-bottom navbar-light bg-light" id="footer-navbar">
            @include('partials.footer')
        </nav>
    </div>
</body>
@include('partials.google')
@include('partials.error')
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel sticky-top" data-step="2" data-intro="Hier kan je navigeren. Na de tutorial kan je hier zelf wat zoeken.">
            @include('partials.navbar')
        </nav>
        <main class="py-3">
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

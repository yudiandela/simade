<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-script.header></x-script.header>
    @stack('styles')
</head>
<body>
    <div id="app">
        <x-navbar></x-navbar>
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <x-script.footer></x-script.footer>
    @stack('scripts')
</body>
</html>

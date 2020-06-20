<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Simade - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="bg">
        <img src="{{ asset('images/logo-telkom-01.png') }}" class="logo">
        <div class="login-box">
            <div class="img-box">
                <img class="img-responsive" src="{{ asset('images/simade-logo.png') }}">
            </div>
            @yield('form')
        </div>
    </div>
</body>
</html>

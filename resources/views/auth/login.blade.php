<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simade - Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="bg">
        <img src="{{ asset('images/logo-telkom-indonesia.png') }}" class="logo">
        <div class="login-box">
            <div class="img-box">
                <img class="img-responsive" src="{{ asset('images/simade-logo.png') }}">
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" class="login-form" placeholder="Email">
                <input type="password" name="password" class="login-form" placeholder="Password">
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>

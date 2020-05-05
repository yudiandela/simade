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
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
                    @error('email')
                        <strong class="text-error">{{ $message }}</strong>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>

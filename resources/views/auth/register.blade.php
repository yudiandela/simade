<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simade - Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="bg">
        <img src="{{ asset('images/logo-telkom-indonesia.png') }}" class="logo">
        <div class="login-box">
            <div class="img-box">
                <img class="img-responsive" src="{{ asset('images/simade-logo.png') }}">
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required autocomplete="name" autofocus>
                    @error('name')
                        <strong class="text-error">{{ $message }}</strong>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    @error('email')
                        <strong class="text-error">{{ $message }}</strong>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    @error('password')
                        <strong class="text-error">{{ $message }}</strong>
                    @enderror
                </div>

                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control" placeholder="Konfirmasi Password" name="password_confirmation" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</body>
</html>

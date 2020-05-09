@extends('layouts.auth')

@section('title', 'Login')

@section('form')
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
@endsection

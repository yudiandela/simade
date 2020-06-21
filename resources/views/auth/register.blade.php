@extends('layouts.auth')

@section('title', 'Register')

@section('form')
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

    <div class="form-group">
        <select id="role" name="role" class="form-control">
            <option value="verificator">Verificator</option>
            <option value="deployment">Deployment</option>
            <option value="manager cs">Manager CS</option>
        </select>
    </div>

    <button type="submit" class="btn btn-p btn-primary">Register</button>
</form>
@endsection

@extends('layouts.error')

@section('title', '404 Not Found')

@section('content')
<div class="text-center">
    <h1>404</h1>
    <h4>Oops... Sepertinya kamu kehilangan arah!</h4>
    <a href="{{ route('survey.index') }}">Kembali ke halaman survey</a>
</div>
@endsection

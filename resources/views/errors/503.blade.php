@extends('layouts.error')

@section('title', '503 ' . __($exception->getMessage() ?: 'Service Unavailable'))

@section('content')
<div class="text-center">
    <h1>503</h1>
    <h4>{{ __($exception->getMessage() ?: 'Service Unavailable') }}</h4>
</div>
@endsection

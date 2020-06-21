@extends('layouts.app')

@section('content')
<div class="px-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('task.nav-tab', ['active' => 'overview'])

                <div class="card rounded-0">
                    <div class="card-body">
                        Kontent Tab Information
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

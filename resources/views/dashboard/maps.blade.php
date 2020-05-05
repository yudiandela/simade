@extends('layouts.app')

@section('content')
<div class="px-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <form class="form-inline">
                    <img src="{{ asset('images/icon/menu.png') }}" width="32" class="d-inline mr-2">
                    <input type="text" name="search" class="form-control" placeholder="Search Location">
                </form>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div id="googleMap" style="width:100%; height:520px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let iconBase = '{{ asset('images/icon/simade-logo-icon-64.png') }}';
    let map = new GMaps({
        div: '#googleMap',
        zoom: 10,
        click: function(e) {
            console.log(e.latLng.lat)
        }
    });


    @foreach($surveys as $survey)
    map.setCenter({{ $survey->latitude }}, {{ $survey->longitude }});
    map.addMarker({
        lat: {{ $survey->latitude }},
        lng: {{ $survey->longitude }},
        icon: iconBase,
        infoWindow: {
            content: `
            <table>
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $survey->name }}</td>
                    </tr>
                    <tr>
                        <td>No KTP</td>
                        <td>:</td>
                        <td>123456789</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $survey->address }}</td>
                    </tr>
                    <tr>
                        <td>Longitude</td>
                        <td>:</td>
                        <td>{{ $survey->longitude }}</td>
                    </tr>
                    <tr>
                        <td>Status Hunian</td>
                        <td>:</td>
                        <td>Milik Sendiri</td>
                    </tr>
                </tbody>
            </table>
            `
        }
    });
    @endforeach
</script>
@endpush

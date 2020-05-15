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
let iconRed = `{{ asset('images/icon/pin-red.png') }}`;
let iconYellow = `{{ asset('images/icon/pin-yellow.png') }}`;
let iconGreen = `{{ asset('images/icon/pin-green.png') }}`;
let iconBlack = `{{ asset('images/icon/pin-black.png') }}`;
let spaces = [];
let customStyle = [{
    featureType: "poi",
    elementType: "labels",
    stylers: [{
        visibility: "off"
    }]
}];

let map = new GMaps({
    div: '#googleMap',
    zoom: 15,
    styles: customStyle,
    mapTypeId: 'satellite',
    click: function(e) {
        console.log(e.latLng.lat)
    }
});

fetch(`{{ route('api.obs') }}`)
    .then((res) => res.json())
    .then(function(data) {
        data.data.forEach(function (value, index) {
            map.setCenter(value.locn_x, value.locn_y);
            map.addMarker({
                lat: value.locn_x,
                lng: value.locn_y,
                icon: value.status == 'Red Occ' ? iconRed : value.status == 'Yellow Occ' ? iconYellow : value.status == 'Green Occ' ? iconGreen : iconBlack,
                infoWindow: {
                    content: `
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><strong>DATEL</strong></td>
                                <td>${value.datel}</td>
                            </tr>
                            <tr>
                                <td><strong>LATITUDE</strong></td>
                                <td>${value.locn_x}</td>
                            </tr>
                            <tr>
                                <td><strong>LONGITUDE</strong></td>
                                <td>${value.locn_y}</td>
                            </tr>
                            <tr>
                                <td><strong>NAMA ODP</strong></td>
                                <td>${value.nama_odp}</td>
                            </tr>
                            <tr>
                                <td><strong>REAL ISISKA AVAI</strong></td>
                                <td>${value.real_isiska_avai}</td>
                            </tr>
                            <tr>
                                <td><strong>REAL ISISKA TOTAL</strong></td>
                                <td>${value.real_isiska_total}</td>
                            </tr>
                            <tr>
                                <td><strong>REAL OCCUPANCY</strong></td>
                                <td>${value.real_occupancy}</td>
                            </tr>
                            <tr>
                                <td><strong>STATUS</strong></td>
                                <td>${value.status}</td>
                            </tr>
                            <tr>
                                <td><strong>STO</strong></td>
                                <td>${value.sto}</td>
                            </tr>
                            <tr>
                                <td><strong>WITEL</strong></td>
                                <td>${value.witel}</td>
                            </tr>
                        </tbody>
                    </table>
                    `
                }
            });
        });
    });

let iconBase = '{{ asset('images/icon/simade-logo-icon-64.png') }}';
fetch(`{{ route('api.surveys') }}`)
    .then((res) => res.json())
    .then(function(data) {
        data.data.forEach(function (value, index) {
            map.addMarker({
                lat: value.latitude,
                lng: value.longitude,
                icon: iconBase,
                infoWindow: {
                    content: `
                    <table>
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>${value.name}</td>
                            </tr>
                            <tr>
                                <td>No KTP</td>
                                <td>:</td>
                                <td>123456789</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>${value.address}</td>
                            </tr>
                            <tr>
                                <td>Longitude</td>
                                <td>:</td>
                                <td>${value.longitude}</td>
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
        });
    });
</script>
@endpush

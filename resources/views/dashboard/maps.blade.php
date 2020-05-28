@extends('layouts.app')

@push('styles')
    <style>
        #search-result {
            position: absolute;
            width: 100%;
            max-width:870px;
            cursor: pointer;
            overflow-y: auto;
            max-height: 400px;
            box-sizing: border-box;
            z-index: 1001;
        }

        .link-class:hover{
            background-color:#f1f1f1;
        }
    </style>
@endpush

@section('content')
<div class="px-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search Location">
                <ul class="list-group" id="search-result"></ul>
            </div>
            <div class="col-md-4">
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="redOcc">
                    <label class="custom-control-label" for="redOcc">Red OCC</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="yellowOcc">
                    <label class="custom-control-label" for="yellowOcc">Yellow OCC</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="greenOcc">
                    <label class="custom-control-label" for="greenOcc">Green OCC</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="blackOcc">
                    <label class="custom-control-label" for="blackOcc">Black OCC</label>
                </div>
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
<script>
    var iconRed = `{{ asset('images/icon/pin-red.png') }}`;
    var iconYellow = `{{ asset('images/icon/pin-yellow.png') }}`;
    var iconGreen = `{{ asset('images/icon/pin-green.png') }}`;
    var iconBlack = `{{ asset('images/icon/pin-black.png') }}`;
    var iconBase = `{{ asset('images/icon/simade-logo-icon-64.png') }}`;
    var features = [];
    var map, customStyle, infowindow, markers;

    async function initMap() {
        customStyle = [{
            featureType: "poi",
            elementType: "labels",
            stylers: [{
                visibility: "off"
            }]
        }];

        map = new google.maps.Map(document.getElementById("googleMap"), {
            zoom: 15,
            styles: customStyle,
            mapTypeId: 'satellite',
        });

        infowindow = new google.maps.InfoWindow();

        await fetchDataObs(`{{ route('api.obs') }}`);
        await fetchDataSurveys(`{{ route('api.surveys') }}`);

        @if(request()->has('lat') and request()->has('lng'))
            map.setCenter(new google.maps.LatLng({{ request()->lat }}, {{ request()->lng }}));
        @else
            map.setCenter(features[0].position);
        @endif

        // Create markers.
        for (var i = 0; i < features.length; i++) {
            markers = new google.maps.Marker({
                position: features[i].position,
                icon: features[i].icon,
                map: map,
                html: features[i].content
            });

            google.maps.event.addListener(markers, 'click', function() {
                infowindow.close(); // Close previously opened infowindow
                infowindow.setContent(this.html);
                infowindow.open(map, this);
            });
        };
    }

    function fetchDataObs(url) {
        return fetch(url)
            .then((res) => res.json())
            .then(function(data) {
                data.data.forEach(function (value, index) {
                    features.push({
                        position: new google.maps.LatLng(value.locn_x, value.locn_y),
                        icon: value.status == 'Red Occ' ? iconRed : value.status == 'Yellow Occ' ? iconYellow : value.status == 'Green Occ' ? iconGreen : iconBlack,
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
                                        <td><a href="{{ route('inbox.maps') }}?lat=${value.locn_x}&lng=${value.locn_y}">${value.nama_odp}</a></td>
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
                    });
                });
            });
    }

    function fetchDataSurveys(url) {
        return fetch(url)
            .then((res) => res.json())
            .then(function(data) {
                data.data.forEach(function (value, index) {
                    features.push({
                        position: new google.maps.LatLng(value.latitude, value.longitude),
                        icon: iconBase,
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
                                        <td>Lokasi</td>
                                        <td>:</td>
                                        <td><a href="{{ route('inbox.maps') }}?lat=${value.latitude}&lng=${value.longitude}">${value.latitude} | ${value.longitude}</a></td>
                                    </tr>
                                    <tr>
                                        <td>Status Hunian</td>
                                        <td>:</td>
                                        <td>Milik Sendiri</td>
                                    </tr>
                                </tbody>
                            </table>
                        `
                    });
                });
            });
    }

    $(document).ready(function() {
        $.ajaxSetup({ cache: false });
        $('#search').keyup(function() {
            let result = $('#search-result');

            let searchField = $(this).val();
            let expression = new RegExp(searchField, "i");

            $.getJSON('{{ route('api.surveys') }}', function(data) {
                result.html('');
                $.each(data.data, function(key, value) {
                    if (value.address.search(expression) != -1 || value.name.search(expression) != -1) {
                        result.append(`<li class="list-group-item link-class"><a href="{{ route('inbox.maps') }}?lat=${value.latitude}&lng=${value.longitude}">
                        <span class="text-muted">${value.name} | ${value.address}</span>
                        </a></li>`);
                    }
                });
            });
        });
    });
</script>
@endpush

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

        .link-class a:hover {
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
<div class="px-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" id="search" class="form-control" autocomplete="off" placeholder="Masukkan nama ODP">
                <ul class="list-group" id="search-result"></ul>
            </div>
            <div class="col-md-4">
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input checkbox" id="redOcc" value="red" checked>
                    <label class="custom-control-label" for="redOcc">Red OCC</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input checkbox" id="yellowOcc" value="yellow" checked>
                    <label class="custom-control-label" for="yellowOcc">Yellow OCC</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input checkbox" id="greenOcc" value="green" checked>
                    <label class="custom-control-label" for="greenOcc">Green OCC</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input checkbox" id="blackOcc" value="black" checked>
                    <label class="custom-control-label" for="blackOcc">Black OCC</label>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <div id="googleMap" style="width:100%; height:693px;"></div>
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
    var markers = [];
    var map, customStyle, infowindow;

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
            var windowLatLng = new google.maps.LatLng({{ request()->lat }}, {{ request()->lng }});

            map.setZoom(20);
            map.setCenter(windowLatLng);
            infowindow.setOptions({
                @if(request()->type == 'survey')
                    content: `
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td class="align-top">Nama</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">{{ $detail->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Handphone</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">{{ $detail->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Alamat</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">{{ $detail->address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Lokasi</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top"><a href="{{ route('inbox.maps') }}?lat={{ $detail->latitude }}&lng={{ $detail->longitude }}&id={{ $detail->id }}&type=survey">{{ $detail->latitude }} | {{ $detail->longitude }}</a></td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Hunian</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">Milik Sendiri</td>
                                    </tr>
                                </tbody>
                            </table>
                        `,
                @else
                    content: `
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="align-top"><strong>DATEL</strong></td>
                                        <td class="align-top">{{ $detail->datel }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>LATITUDE</strong></td>
                                        <td class="align-top">{{ $detail->locn_x }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>LONGITUDE</strong></td>
                                        <td class="align-top">{{ $detail->locn_y }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>NAMA ODP</strong></td>
                                        <td class="align-top"><a href="{{ route('inbox.maps') }}?lat={{ $detail->locn_x }}&lng={{ $detail->locn_y }}&id={{ $detail->id }}&type=odb">{{ $detail->nama_odp }}</a></td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>REAL ISISKA AVAI</strong></td>
                                        <td class="align-top">{{ $detail->real_isiska_avai }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>REAL ISISKA TOTAL</strong></td>
                                        <td class="align-top">{{ $detail->real_isiska_total }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>REAL OCCUPANCY</strong></td>
                                        <td class="align-top">{{ $detail->real_occupancy }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>STATUS</strong></td>
                                        <td class="align-top">{{ $detail->status }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>STO</strong></td>
                                        <td class="align-top">{{ $detail->sto }}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>WITEL</strong></td>
                                        <td class="align-top">{{ $detail->witel }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        `,
                @endif
                position: windowLatLng,
            });
            infowindow.open(map);
        @else
            map.setCenter(features[0].position);
        @endif

        // Create markers.
        for (var i = 0; i < features.length; i++) {
            var marker = new google.maps.Marker({
                position: features[i].position,
                icon: features[i].icon,
                map: map,
                type: features[i].type,
                html: features[i].content
            });

            markers.push(marker);

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.close(); // Close previously opened infowindow
                infowindow.setContent(this.html);
                infowindow.open(map, this);
            });
        };
    }

    function show(type) {
        for (var i = 0; i < features.length; i++) {
            if (features[i].type == type) {
                markers[i].setVisible(true);
            }
        }
    }

    function hide(type) {
        for (var i = 0; i < features.length; i++) {
            if (features[i].type == type) {
                markers[i].setVisible(false);
            }
        }
    }

    $(".checkbox").click( function () {
        var cat = $(this).attr("value");
        if ($(this).is(":checked")) {
            show(cat);
        } else {
            hide(cat);
        }
    });

    function fetchDataObs(url) {
        return fetch(url)
            .then((res) => res.json())
            .then(function(data) {
                data.data.forEach(function (value, index) {
                    features.push({
                        position: new google.maps.LatLng(value.locn_x, value.locn_y),
                        icon: value.status == 'Red Occ' ? iconRed : value.status == 'Yellow Occ' ? iconYellow : value.status == 'Green Occ' ? iconGreen : iconBlack,
                        type: value.status == 'Red Occ' ? 'red' : value.status == 'Yellow Occ' ? 'yellow' : value.status == 'Green Occ' ? 'green' : 'black',
                        content: `
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="align-top"><strong>DATEL</strong></td>
                                        <td class="align-top">${value.datel}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>LATITUDE</strong></td>
                                        <td class="align-top">${value.locn_x}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>LONGITUDE</strong></td>
                                        <td class="align-top">${value.locn_y}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>NAMA ODP</strong></td>
                                        <td class="align-top"><a href="{{ route('inbox.maps') }}?lat=${value.locn_x}&lng=${value.locn_y}&id=${value.id}&type=odb">${value.nama_odp}</a></td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>REAL ISISKA AVAI</strong></td>
                                        <td class="align-top">${value.real_isiska_avai}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>REAL ISISKA TOTAL</strong></td>
                                        <td class="align-top">${value.real_isiska_total}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>REAL OCCUPANCY</strong></td>
                                        <td class="align-top">${value.real_occupancy}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>STATUS</strong></td>
                                        <td class="align-top">${value.status}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>STO</strong></td>
                                        <td class="align-top">${value.sto}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>WITEL</strong></td>
                                        <td class="align-top">${value.witel}</td>
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
                        type: 'user',
                        content: `
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td class="align-top">Nama</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">${value.name}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Handphone</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">${value.phone}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Alamat</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">${value.address}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Lokasi</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top"><a href="{{ route('inbox.maps') }}?lat=${value.latitude}&lng=${value.longitude}&id=${value.id}&type=survey">${value.latitude} | ${value.longitude}</a></td>
                                    </tr>
                                    <tr>
                                        <td class="align-top">Hunian</td>
                                        <td class="align-top">:</td>
                                        <td class="align-top">Milik Sendiri</td>
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
            var result = $('#search-result');

            var searchField = $(this).val();
            var expression = new RegExp(searchField, "i");

            $.getJSON('{{ route('api.obs') }}', function(data) {
                result.html('');
                $.each(data.data, function(key, value) {
                    if (value.nama_odp.search(expression) != -1) {
                        result.append(`<li class="list-group-item link-class"><a href="{{ route('inbox.maps') }}?lat=${value.locn_x}&lng=${value.locn_y}&id=${value.id}&type=odb">
                        <span class="text-muted">${value.nama_odp} | ${value.datel} | ${value.status}</span>
                        </a></li>`);
                    }
                });
            });
        });
    });
</script>
@endpush

@extends('layouts.app')

@section('content')
<div class="px-5">
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Edit Data Survey</h2>
                        <hr>
                        <form action="{{ route('survey.update', $survey->id) }}" method="post">
                            @csrf
                            @method('put')

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="name">
                                    * Nama Lengkap <br>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" id="name" name="name" value="{{ old('name', $survey->name) }}" class="form-control @error('name') is-invalid @enderror" autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="address">
                                    * Alamat Lengkap <br>
                                    (Diambil otomatis dari google)
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" id="textAddress" readonly class="form-control-plaintext">
                                    <input type="hidden" id="address" name="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="phone">
                                    * No Handphone <br>
                                    (Pastikan dapat dihubungi)
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $survey->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="ktp">
                                    * No KTP <br>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" id="ktp" name="ktp" value="{{ old('ktp', $survey->ktp) }}" class="form-control @error('ktp') is-invalid @enderror">
                                    @error('ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="price">
                                    * Range harga yang diinginkan <br>
                                </label>
                                <div class="col-sm-8">
                                    <select name="price" class="form-control @error('price') is-invalid @enderror">
                                        <option value="300,500" {{ old('price', $survey->price_from == 300 ?? 'selected') == "300,500" ? 'selected' : '' }}>300 rb - 500 rb</option>
                                        <option value="500,700" {{ old('price', $survey->price_from == 500 ?? 'selected') == "500,700" ? 'selected' : '' }}>500 rb - 700 rb</option>
                                        <option value="700,1000" {{ old('price', $survey->price_from == 700 ?? 'selected') == "700,1000" ? 'selected' : '' }}>700 rb - 1 juta</option>
                                        <option value="1000" {{ old('price', $survey->price_from == 1000 ?? 'selected') == "1000" ? 'selected' : '' }}>> 1 juta</option>
                                    </select>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    * Lokasi <br>
                                    (Aktifkan GPS) Geser pin pada koordinat yang dituju.
                                </label>
                                <div class="col-sm-12">
                                    <div id="googleMap" style="width:100%;height:380px;"></div>
                                    <input id="lat" type="hidden" name="latitude">
                                    <input id="lng" type="hidden" name="longitude">
                                    <input id="pos" type="hidden" name="position">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-block btn-primary btn-lg">
                                Update Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input id="pac-input" class="controls form-control" type="text" placeholder="Cari Lokasi..." style="width: 433px; padding: 1.4rem; margin-top: 10px;">
</div>
@endsection

@push('scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"></script>
    <script>
    var map, infoWindow, pos, marker, geocoder;
    function initMap() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                pos = {
                    lat: {{ old('latitude', $survey->latitude) }},
                    lng: {{ old('longitude', $survey->longitude) }}
                };

                geocoder = new google.maps.Geocoder;
                geocoder.geocode({'location': pos}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
                            $('#textAddress').val(results[0].formatted_address);
                        } else {
                            window.alert('No results found');
                        }
                    } else {
                        window.alert('Geocoder failed due to: ' + status);
                    }
                });

                map = new google.maps.Map(document.getElementById('googleMap'), {
                    center: pos,
                    zoom: 15
                });
                infoWindow = new google.maps.InfoWindow;

                $('#lat').val(pos.lat.toFixed(5));
                $('#lng').val(pos.lng.toFixed(5));

                marker = new google.maps.Marker({
                    position: pos,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    map: map
                });

                marker.addListener('dragend', function() {
                    pos = {
                        lat: this.position.lat(),
                        lng: this.position.lng()
                    };

                    $('#lat').val(pos.lat.toFixed(5));
                    $('#lng').val(pos.lng.toFixed(5));

                    geocoder.geocode({'location': pos}, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                $('#address').val(results[0].formatted_address);
                                $('#textAddress').val(results[0].formatted_address);
                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });
                });

                // Create the search box and link it to the UI element.
                input = document.getElementById('pac-input');
                searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                // Bias the SearchBox results towards current map's viewport.
                map.addListener('bounds_changed', function() {
                    searchBox.setBounds(map.getBounds());
                });

                searchBox.addListener('places_changed', function() {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    marker.setMap(null);
                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {
                        if (!place.geometry) {
                            return;
                        }

                        $('#address').val(place.formatted_address);
                        $('#textAddress').val(place.formatted_address);

                        $('#lat').val(place.geometry.location.lat().toFixed(5));
                        $('#lng').val(place.geometry.location.lng().toFixed(5));

                        marker = new google.maps.Marker({
                            position: place.geometry.location,
                            draggable: true,
                            animation: google.maps.Animation.DROP,
                            map: map
                        });

                        marker.addListener('dragend', function() {
                            pos = {
                                lat: this.position.lat(),
                                lng: this.position.lng()
                            };

                            $('#lat').val(pos.lat.toFixed(5));
                            $('#lng').val(pos.lng.toFixed(5));

                            geocoder.geocode({'location': pos}, function(results, status) {
                                if (status === 'OK') {
                                    if (results[0]) {
                                        $('#address').val(results[0].formatted_address);
                                        $('#textAddress').val(results[0].formatted_address);
                                    } else {
                                        alert('Tidak ada hasil yang ditemukan');
                                    }
                                } else {
                                    alert('Geocoder gagal karena: ' + status);
                                }
                            });
                        });

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);
                });
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                                'Error: The Geolocation service failed.' :
                                'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

    function last(array, n) {
        if (array == null) {
            return void 0;
        }

        if (n == null) {
            return array[array.length - 1];
        }

        return array[array.length - n];
    }
    </script>
@endpush

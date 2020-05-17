<!DOCTYPE html>
<html lang="en">
<head>
    <x-script.header></x-script.header>
</head>
<body>
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <img src="{{ asset('images/logo-telkom-01.png') }}" alt="" class="img-fluid mx-auto d-block pb-3 mb-4" width="250">

                {{-- <h4 class="text-center pb-3">Form Survey</h4> --}}

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('survey.store') }}" method="post">
                            @csrf

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="name">* Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="address">* Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="phone">* No Handphone</label>
                                <div class="col-sm-8">
                                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="occupant">* Jumlah Penghuni</label>
                                <div class="col-sm-8">
                                    <input type="number" id="occupant" name="occupant" min="1" value="1" class="form-control @error('occupant') is-invalid @enderror">
                                    @error('occupant')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="children_education">* Pendidikan Anak</label>
                                <div class="col-sm-8">
                                    <input type="text" id="children_education" name="children_education" class="form-control @error('children_education') is-invalid @enderror">
                                    @error('children_education')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    * Lokasi <br>
                                    (Aktifkan GPS) Geser pin pada koordinat anda.
                                </label>
                                <div class="col-sm-12">
                                    <div id="googleMap" style="width:100%;height:380px;"></div>
                                    <input id="lat" type="hidden" name="latitude">
                                    <input id="lng" type="hidden" name="longitude">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-block btn-primary btn-lg">
                                Submit Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-script.footer></x-script.footer>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
    <script>
    var map, infoWindow, pos, marker;
    function initMap() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

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
                    $('#lat').val(this.position.lat().toFixed(5));
                    $('#lng').val(this.position.lng().toFixed(5));
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
    </script>
</body>
</html>

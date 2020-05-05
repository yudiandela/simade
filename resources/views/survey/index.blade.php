<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Survey Pelanggan 2020</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <img src="{{ asset('images/logo-telkom-indonesia.png') }}" alt="" class="img-fluid mx-auto d-block pb-3 mb-4" width="250">

                <h4 class="text-center pb-3">Form Survey</h4>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('survey.store') }}" method="post">
                            @csrf

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="name">* Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text" id="name" name="name" class="form-control">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="address">* Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" id="address" name="address" class="form-control">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="phone">* No Handphone</label>
                                <div class="col-sm-8">
                                    <input type="text" id="phone" name="phone" class="form-control">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="occupant">* Jumlah Penghuni</label>
                                <div class="col-sm-8">
                                    <input type="number" id="occupant" name="occupant" class="form-control">
                                    @error('occupant')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="children_education">* Pendidikan Anak</label>
                                <div class="col-sm-8">
                                    <input type="text" id="children_education" name="children_education" class="form-control" >
                                    @error('children_education')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    * Lokasi <br>
                                    (Aktifkan GPS)
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

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="//maps.googleapis.com/maps/api/js"></script>
    <script src="{{ asset('js/gmaps.js') }}"></script>
    <script>
        var map = new GMaps({
            div: '#googleMap',
            click: function(e) {
                console.log(e.latLng.lat)
            },
        });
        GMaps.geolocate({
            success: function(position) {
                let lat = position.coords.latitude;
                let lng = position.coords.longitude;

                $('#lat').val(lat);
                $('#lng').val(lng);

                map.setCenter(lat, lng);
                map.addMarker({
                    lat: lat,
                    lng: lng,
                    draggable: true,
                    dragend: function(event) {
                        var lat = event.latLng.lat();
                        var lng = event.latLng.lng();
                        $('#lat').val(lat);
                        $('#lng').val(lng);
                    },
                    infoWindow: {
                        content: '<p>Data yang ingin di tampilkan</p>'
                    }
                });
            },
            error: function(error) {
                alert("Lokasi Anda Tidak Ditemukan");
            },
            not_supported: function() {
                alert("Browser Anda Tidak Support Geolokasi");
            },
            always: function(e) {

            }
        });
    </script>
</body>
</html>

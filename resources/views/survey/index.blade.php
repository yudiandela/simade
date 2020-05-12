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

                $('#lat').val(lat.toFixed(5));
                $('#lng').val(lng.toFixed(5));

                map.setCenter(lat, lng);
                map.addMarker({
                    lat: lat,
                    lng: lng,
                    draggable: true,
                    dragend: function(event) {
                        var lat = event.latLng.lat();
                        var lng = event.latLng.lng();
                        $('#lat').val(lat.toFixed(5));
                        $('#lng').val(lng.toFixed(5));
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

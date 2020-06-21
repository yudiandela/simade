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
                                <label class="col-sm-4 col-form-label" for="name">
                                    * Nama Lengkap <br>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" autofocus>
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
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
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
                                    <input type="text" id="ktp" name="ktp" value="{{ old('ktp') }}" class="form-control @error('ktp') is-invalid @enderror">
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
                                        <option value="300,500" {{ old('price') == "300,500" ? 'selected' : '' }}>300 rb - 500 rb</option>
                                        <option value="500,700" {{ old('price') == "500,700" ? 'selected' : '' }}>500 rb - 700 rb</option>
                                        <option value="700,1000" {{ old('price') == "700,1000" ? 'selected' : '' }}>700 rb - 1 juta</option>
                                        <option value="1000" {{ old('price') == "1000" ? 'selected' : '' }}>> 1 juta</option>
                                    </select>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
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
                            </div> --}}

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    * Lokasi <br>
                                    (Aktifkan GPS) Geser pin pada koordinat anda.
                                </label>
                                <div class="col-sm-12">
                                </div>
                                    <div id="googleMap" style="width:100%;height:380px;"></div>
                                    <input id="lat" type="hidden" name="latitude">
                                    <input id="lng" type="hidden" name="longitude">
                                    {{-- <input id="pos" type="text" name="position"> --}}
                            </div>

                            <button id="submitBtn" type="submit" disabled="disabled" class="btn btn-block btn-secondary btn-lg">
                                Submit Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <button id="open-chat" class="open-chat btn btn-success rounded-circle">Chat</button>

    <div class="chat-popup" id="myForm">
        <form action="/" class="form-chat-container">
            <h2>Chat</h2>

            <label for="msg"><b>Message</b></label>
            <textarea placeholder="Type message.." name="msg" required></textarea>

            <button type="submit" class="btn btn-success">Send</button>
            <button id="close-chat" type="button" class="btn cancel">Close</button>
        </form>
    </div> --}}

    <div class="fab-container">
        <div class="fab fab-icon-holder">
            <i class="fas fa-comments"></i>
        </div>
        <ul class="fab-options">
            <li>
                <a href="https://wa.me/6282398569858" target="_blank">
                    {{-- <span class="fab-label">Feedback</span> --}}
                    <div class="fab-icon-holder">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                </a>
            </li>
            <li>
                <a href="https://t.me/AndriIrawanZ" target="_blank">
                    {{-- <span class="fab-label">Feedback</span> --}}
                    <div class="fab-icon-holder">
                        <i class="fab fa-telegram"></i>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <input id="pac-input" class="controls form-control" type="text" placeholder="Cari Lokasi..." style="width: 473px; padding: 1.4rem; margin-top: 10px;">

    <x-script.footer></x-script.footer>

    <!-- Live Chat Widget powered by https://keyreply.com/chat/ -->
    <!-- Advanced options: -->
    <!-- data-align="left" -->
    <!-- data-overlay="true" -->
    {{-- <script data-align="right" data-overlay="false" id="keyreply-script" src="//keyreply.com/chat/widget.js" data-color="#FF9800" data-apps="JTdCJTIycGhvbmUlMjI6JTIyMDg1MjYyNTI1NTkzJTIyLCUyMnRlbGVncmFtJTIyOiUyMkB5dWRpYW5kZWxhJTIyJTdE"></script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var s,t; s = document.createElement('script'); s.type = 'text/javascript';
            s.src = 'https://s3-ap-southeast-1.amazonaws.com/qiscus-sdk/public/qismo/qismo-v3.js'; s.async = true;
            s.onload = s.onreadystatechange = function() { new Qismo("lyta-zcnbqwu1t2x3fvhi"); }
            t = document.getElementsByTagName('script')[0]; t.parentNode.insertBefore(s, t);
        });
    </script> --}}

    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap"></script>
    <script>
    (function() {
        $('input.form-control').keyup(function() {
            var empty = false;
            $('form > div > div > input').each(function() {
                if ($(this).val() == '') {
                    empty = true;
                }
            });

            if (empty) {
                $('#submitBtn').attr('disabled', 'disabled');
                $('#submitBtn').removeClass('btn-primary');
                $('#submitBtn').addClass('btn-secondary');
            } else {
                $('#submitBtn').removeAttr('disabled');
                $('#submitBtn').removeClass('btn-secondary');
                $('#submitBtn').addClass('btn-primary');
            }
        });
    })()

    $("#open-chat").click( function() {
        $("#myForm").css("display", "block");
    });

    $("#close-chat").click( function() {
        $("#myForm").css("display", "none");
    });

    var map, infoWindow, pos, marker, geocoder, input, searchBox;
    function initMap() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                pos = {
                    lat: {{ old('latitude', 'position.coords.latitude') }},
                    lng: {{ old('longitude', 'position.coords.longitude') }}
                };

                geocoder = new google.maps.Geocoder();
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
                                alert('Tidak ada hasil yang ditemukan');
                            }
                        } else {
                            alert('Geocoder gagal karena: ' + status);
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
                $('#textAddress').val('Lokasi tidak ditemukan.');
                alert('{{ config('app.name') }} tidak memiliki izin untuk menggunakan lokasi anda.');
            });
        } else {
            // Browser doesn't support Geolocation
            $('#textAddress').val('Lokasi tidak ditemukan.');
            alert('Browser anda tidak support Geolocation.');
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
</body>
</html>

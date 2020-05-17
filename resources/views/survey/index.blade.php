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
                                    <input id="pos" type="hidden" name="position">
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

    <x-script.footer></x-script.footer>

    <!-- Live Chat Widget powered by https://keyreply.com/chat/ -->
    <!-- Advanced options: -->
    <!-- data-align="left" -->
    <!-- data-overlay="true" -->
    {{-- <script data-align="right" data-overlay="false" id="keyreply-script" src="//keyreply.com/chat/widget.js" data-color="#FF9800" data-apps="JTdCJTIycGhvbmUlMjI6JTIyMDg1MjYyNTI1NTkzJTIyLCUyMnRlbGVncmFtJTIyOiUyMkB5dWRpYW5kZWxhJTIyJTdE"></script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var s,t; s = document.createElement('script'); s.type = 'text/javascript';
            s.src = 'https://s3-ap-southeast-1.amazonaws.com/qiscus-sdk/public/qismo/qismo-v3.js'; s.async = true;
            s.onload = s.onreadystatechange = function() { new Qismo("lyta-zcnbqwu1t2x3fvhi"); }
            t = document.getElementsByTagName('script')[0]; t.parentNode.insertBefore(s, t);
        });
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
    <script>
    $("#open-chat").click( function() {
        $("#myForm").css("display", "block");
    });

    $("#close-chat").click( function() {
        $("#myForm").css("display", "none");
    });

    var map, infoWindow, pos, marker, geocoder;
    function initMap() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                geocoder = new google.maps.Geocoder;
                geocoder.geocode({'location': pos}, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
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
                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });
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

@extends('layouts.dashboard')

@section('title', $title)

@push('style')
    <link rel="stylesheet" href="{{ asset('v3/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="card mb-4">
                <div class="card-header header-elements">
                    <h3 class="mb-0 me-2">{{ $title }}</h3>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="card">
                    <form id="fileForm" action="{{ route('profil-bisnis.update', $profilBisnis) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Nama Desa</label>
                                        <input type="text"
                                            class="form-control @error('nama_client') is-invalid @enderror"
                                            name="nama_client" value="{{ old('nama_client', $profilBisnis->nama_client) }}"
                                            autocomplete="off">
                                        @error('nama_client')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control @error('desc_app') is-invalid @enderror" data-height="90" name="desc_app">{{ old('desc_app', $profilBisnis->desc_app) }}</textarea>
                                        @error('desc_app')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Alamat</label>
                                        <textarea class="form-control @error('alamat_client') is-invalid @enderror" data-height="90" name="alamat_client">{{ old('alamat_client', $profilBisnis->alamat_client) }}</textarea>
                                        @error('alamat_client')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group mb-4">
                                                <label>Email</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email', $profilBisnis->email) }}" autocomplete="off">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group mb-4">
                                                <label>Phone</label>
                                                <input type="text"
                                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                    value="{{ old('phone', $profilBisnis->phone) }}" autocomplete="off">
                                                @error('phone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Kepala Desa</label>
                                        <input type="text" class="form-control @error('signature') is-invalid @enderror"
                                            name="signature" value="{{ old('signature', $profilBisnis->signature) }}"
                                            autocomplete="off">
                                        @error('signature')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Catatan kaki</label>
                                        <textarea class="form-control @error('footnot') is-invalid @enderror" data-height="70" name="footnot">{{ old('footnot', $profilBisnis->footnot) }}</textarea>
                                        @error('footnot')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Rekening Bank</label>
                                        <textarea class="form-control @error('bank') is-invalid @enderror" rows="4" name="bank">{{ old('bank', $profilBisnis->bank) }}</textarea>
                                        @error('bank')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label>Latitude</label>
                                                <input type="text" class="form-control" name="latitude"
                                                    value="{{ old('latitude', $profilBisnis->latitude) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label>Longitude</label>
                                                <input type="text" class="form-control" name="longitude"
                                                    value="{{ old('longitude', $profilBisnis->longitude) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @foreach ($medsos as $item)
                                        <div class="form-group mb-4">
                                            <label>{{ $item->keterangan }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $item->url_ext==null ? 'https://' . strtolower($item->keterangan) . '.com' : $item->url_ext }}"
                                                readonly>
                                        </div>
                                    @endforeach
                                    <div class="mb-5 text-end">
                                        <a href="{{ route('link.index') }}" class="btn btn-sm btn-warning mb-5">edit medsos</a>
                                    </div>
                                    
                                    {{-- <div class="form-group mb-4">
                                        <label>Facebook</label>
                                        <input type="text" class="form-control @error('facebook') is-invalid @enderror"
                                            name="facebook" value="{{ old('facebook', $profilBisnis->facebook) }}"
                                            autocomplete="off" placeholder="https://facebook.com/">
                                        @error('facebook')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Youtube</label>
                                        <input type="text" class="form-control @error('youtube') is-invalid @enderror"
                                            name="youtube" value="{{ old('youtube', $profilBisnis->youtube) }}"
                                            autocomplete="off" placeholder="https://youtube.com/">
                                        @error('youtube')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Twitter</label>
                                        <input type="text" class="form-control @error('twitter') is-invalid @enderror"
                                            name="twitter" value="{{ old('twitter', $profilBisnis->twitter) }}"
                                            autocomplete="off" placeholder="https://twitter.com/">
                                        @error('twitter')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Instagram</label>
                                        <input type="text"
                                            class="form-control @error('instagram') is-invalid @enderror"
                                            name="instagram" value="{{ old('instagram', $profilBisnis->instagram) }}"
                                            autocomplete="off" placeholder="https://instagram.com/">
                                        @error('instagram')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group mb-4 d-none">
                                        <label>Endpoint SID</label>
                                        <input type="hidden"
                                            class="form-control @error('endpoint') is-invalid @enderror" name="endpoint"
                                            value="{{ old('endpoint', $profilBisnis->endpoint) }}" autocomplete="off"
                                            placeholder="https://endpoint.com/api">
                                        @error('endpoint')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4 d-none">
                                        <label>API key SID</label>
                                        <input type="hidden" class="form-control @error('apikey') is-invalid @enderror"
                                            name="apikey" value="{{ old('apikey', $profilBisnis->apikey) }}"
                                            autocomplete="off">
                                        @error('apikey')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <div class="d-block text-center gap-6">
                                                    {{-- <img src="{{ Str::contains(klien('logo'), 'image') ? '/' . klien('image_icon') : Storage::url(klien('logo')) }}" --}}
                                                    <img src="{{ Str::contains(klien('logo'), 'profile') ? Storage::url(klien('logo'))  : Storage::url('thumbs/' . klien('logo')) }}"
                                                        alt="" class="w-px-100 h-px-100 rounded"
                                                        id="uploadedAvatar" />
                                                    <div class="button-wrapper">
                                                        <label for="image-upload" class="btn btn-sm btn-info my-2"
                                                            tabindex="0">
                                                            <span class="d-none d-sm-block">Upload logo</span>
                                                            <i class="ti ti-upload d-block d-sm-none"></i>
                                                            <input type="file" name="logo" id="image-upload"
                                                                class="account-file-input @error('logo') is-invalid @enderror"
                                                                hidden />
                                                        </label>
                                                        <div class="account-image-reset d-none"></div>
                                                    </div>
                                                    @error('logo')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-1">
                                                <div class="d-block text-center  gap-6">
                                                    <img src="{{ Str::contains(klien('image_icon'), 'image') ? '/' . klien('image_icon') : Storage::url(klien('image_icon')) }}"
                                                        alt="" class="w-px-100 h-px-100 rounded"
                                                        id="uploadedAvatar2" />
                                                    <div class="button-wrapper">
                                                        <label for="image-upload-2" class="btn btn-sm btn-info my-2"
                                                            tabindex="0">
                                                            <span class="d-none d-sm-block">Upload Favicon</span>
                                                            <i class="ti ti-upload d-block d-sm-none"></i>
                                                            <input type="file" id="image-upload-2" name="image_icon"
                                                                class="account-file-input-2 @error('image_icon') is-invalid @enderror"
                                                                hidden />
                                                        </label>
                                                        <div class="account-image-reset-2 d-none"></div>
                                                    </div>
                                                    @error('image_icon')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div id="map"></div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <button id="checkSize" type="submit" class="btn btn-lg btn-primary"><i
                                    class="ti ti-device-floppy me-2"></i> Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('v3/assets/js/pages-account-settings-account.js') }}"></script>
    <script src="{{ asset('v3/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('v3/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('v3/assets/js/forms-selects.js') }}"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    {{-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script> --}}

    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtYsdRWWefWWL5FDJQjlUI3DxQZ1Rbb7w&callback=initialize" async defer></script> --}}
    <script>
        $(document).on("change", "#image-upload", function(e) {
            e.preventDefault()
            let jmlFiles = $("#image-upload")[0].files
            let maxSize = 2
            let totFiles = jmlFiles[0].size
            let filesize = totFiles / 1000 / 1000;
            filesize = filesize.toFixed(1);
            if (filesize > maxSize) {
                showWarningAlert('File foto max. ' + maxSize + ' MB, Total size : ' + filesize + ' MB')
                $("#image-upload").val('')
                $('#checkSize').prop('disabled', true);
            } else {
                $('#checkSize').prop('disabled', false);
            }
        });
        $(document).on("change", "#image-upload-2", function(e) {
            e.preventDefault()
            let jmlFiles = $("#image-upload-2")[0].files
            let maxSize = 1
            let totFiles = jmlFiles[0].size
            let filesize = totFiles / 1000 / 1000;
            filesize = filesize.toFixed(1);
            if (filesize > maxSize) {
                showWarningAlert('File foto max. ' + maxSize + ' MB, Total size : ' + filesize + ' MB')
                $("#image-upload-2").val('')
                $('#checkSize').prop('disabled', true);
            } else {
                $('#checkSize').prop('disabled', false);
            }
        });
    </script>
    {{-- <script type="text/javascript">
        var marker;

        function initialize() {
            var infoWindow = new google.maps.InfoWindow;
            var mapOptions = {
                mapTypeId: google.maps.MapTypeId.HYBRID, // SATELLITE or  ROADMAP
                zoom: 15
            }
            var peta = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
            var bounds = new google.maps.LatLngBounds();
            addMarker({{ $profilBisnis->latitude }}, {{ $profilBisnis->longitude }}, '{{ $profilBisnis->nama_client }}<br>{{ $profilBisnis->latitude }}, {{ $profilBisnis->longitude }}');

            function addMarker(lat, lng, info) {
                var lokasi = new google.maps.LatLng(lat, lng);
                bounds.extend(lokasi);
                var marker = new google.maps.Marker({
                    map: peta,
                    position: lokasi
                });
                peta.fitBounds(bounds);
                bindInfoWindow(marker, peta, infoWindow, info);
            }

            function bindInfoWindow(marker, peta, infoWindow, html) {
                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(html);
                    infoWindow.open(peta, marker);
                });
            }
        }
    </script> --}}
    <script>
        var mymap = L.map('map').setView([{{ $profilBisnis->latitude }}, {{ $profilBisnis->longitude }}], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        var marker = L.marker([{{ $profilBisnis->latitude }}, {{ $profilBisnis->longitude }}]).addTo(mymap);
        marker.bindPopup("<b>Lokasi</b>").openPopup();
    </script>
    {{-- <script>
        var mymap = L.map('map').setView([{{ $profilBisnis->latitude }}, {{ $profilBisnis->longitude }}], 18);

        L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-v9/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFzam9lbCIsImEiOiJja2N3cjZnN2QwZDQxMnVueWp2azVsNWFhIn0.RIpbHnkNMnF-b7-sQYHGYQ', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 25
        }).addTo(mymap);

        var marker = L.marker([{{ $profilBisnis->latitude }}, {{ $profilBisnis->longitude }}]).addTo(mymap);
        marker.bindPopup("<b>Lokasi</b>").openPopup();
    </script> --}}
    {{-- <script>
        var mymap = L.map('map').setView([{{ $profilBisnis->latitude }}, {{ $profilBisnis->longitude }}], 18);

        L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFzam9lbCIsImEiOiJja2N3cjZnN2QwZDQxMnVueWp2azVsNWFhIn0.RIpbHnkNMnF-b7-sQYHGYQ', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 25
        }).addTo(mymap);

        var marker = L.marker([{{ $profilBisnis->latitude }}, {{ $profilBisnis->longitude }}]).addTo(mymap);
        marker.bindPopup("<b>Lokasi</b>").openPopup();
    </script> --}}
@endpush

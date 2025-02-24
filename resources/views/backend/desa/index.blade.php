@extends('layouts.dashboard')

@section('title', 'Profile')

@push('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 360px;
            width: 100%;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="card">
                <div class="card-header header-elements">
                    <h3 class="mb-0 me-2">{{ $title }}</h3>
                    <div class="card-header-elements ms-auto">
                        <span class="text text-muted d-flex">
                            <small>
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-7 col-lg-7">
                        <div class="card">
                            <div class="card-header header-elements">
                                <h5 class="mb-0 me-2">Detail</h5>
                                <div class="card-header-elements ms-auto">
                                    <a href="{{ route('link.index') }}" class="btn btn-info waves-effect waves-light"><i
                                            class="ti ti-link me-2"></i>Medsos & Link eksternal</a>
                                    <a href="{{ route('profil-bisnis.edit', infodesa('id')) }}"
                                        class="btn btn-warning waves-effect waves-light"><i
                                            class="ti ti-edit me-2"></i>Edit</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="150">Nama </td>
                                            <td width="10">:</td>
                                            <td>{{ infodesa('nama_client') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>:</td>
                                            <td>{{ infodesa('alamat_client') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>{{ infodesa('email') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Telpon</td>
                                            <td>:</td>
                                            <td>{{ infodesa('phone') }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td>Ketua</td>
                                            <td>:</td>
                                            <td>{{ infodesa('kades') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sekretaris</td>
                                            <td>:</td>
                                            <td>{{ infodesa('sekretaris') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bendahara</td>
                                            <td>:</td>
                                            <td>{{ infodesa('bendahara') }}</td>
                                        </tr> --}}
                                        <tr>
                                            <td>Website</td>
                                            <td>:</td>
                                            <td>{{ infodesa('web') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: top">Data Bank</td>
                                            <td style="vertical-align: top">:</td>
                                            <td style="vertical-align: top">{!! nl2br(infodesa('bank')) !!}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Logo</label>
                                            <div class="mt-3">
                                                <img src="{{ Str::contains(infodesa('logo'), 'image') ? infodesa('logo') : Storage::url('thumbs/' . infodesa('logo')) }}"
                                                    width="100" height="auto" alt="" srcset="">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Foto Ketua</label>
                                            <div class="mt-3">
                                                <img src="{{ Str::contains(infodesa('photo'), 'image') ? infodesa('photo') : Storage::url('thumbs/' . infodesa('photo')) }}"
                                                    width="100" height="auto" alt="" srcset="">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Favicon</label>
                                            <div class="mt-3">
                                                <img src="{{ Str::contains(infodesa('image_icon'), 'image') ? infodesa('image_icon') : Storage::url(infodesa('image_icon')) }}"
                                                    width="100" height="auto" alt="" srcset="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card mt-3">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Peta</label>
                                    <div id="map"></div>
                                    <div id="mapLink"></div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var lat = "{{ infodesa('latitude') }}";
        var lng = "{{ infodesa('longitude') }}";
        var mymap = L.map('map').setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        var marker = L.marker([lat, lng]).addTo(mymap);
        marker.bindPopup("<b>Lokasi</b>").openPopup();
        var mapUrl = `https://www.google.com/maps/@${lat},${lng},18z`;
        document.getElementById('mapLink').innerHTML = `<a href="${mapUrl}" target="_blank">lihat di google map</a>`;
    </script>
@endpush

@extends('layouts.dashboard')

@section('title', 'Profile')

@push('style')
    <link rel="stylesheet" href="{{ asset('v3/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 300px;
            width: 100%;
        }

        image-preview {
            width: 150px !important;
            height: 150px !important;
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
                                <nav>
                                    <ol class="breadcrumb breadcrumb-style1">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('profil-bisnis.index') }}">Detail</a>
                                        </li>
                                        <li class="breadcrumb-item active">Edit {{ $title }}</li>
                                    </ol>
                                </nav>
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <form id="fileForm" method="post" action="{{ route('profil-bisnis.update', $profil_bisni) }}"
                    class="needs-validation" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-7 col-lg-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mb-4">
                                        <label>Nama </label>
                                        <input type="text"
                                            class="form-control @error('nama_client') is-invalid @enderror"
                                            name="nama_client"
                                            value="{{ old('nama_client', $profil_bisni->nama_client) }}">
                                        @error('nama_client')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name='kodedesa'
                                        class="form-control @error('kodedesa') is-invalid @enderror"
                                        value="{{ old('kodedesa', $profil_bisni->kodedesa) }}">
                                    {{-- <div class="form-group mb-4 d-none">
                                        <label>Ketua</label>
                                        <input type="hidden" name='kades'
                                            class="form-control @error('kades') is-invalid @enderror"
                                            value="{{ old('kades', $profil_bisni->kades) }}">
                                        @error('kades')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Sekretaris</label>
                                        <input type="text" name='sekretaris'
                                            class="form-control @error('sekretaris') is-invalid @enderror"
                                            value="{{ old('sekretaris', $profil_bisni->sekretaris) }}">
                                        @error('sekretaris')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Bendahara</label>
                                        <input type="text" name='bendahara'
                                            class="form-control @error('bendahara') is-invalid @enderror"
                                            value="{{ old('bendahara', $profil_bisni->bendahara) }}">
                                        @error('bendahara')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group mb-4">
                                        <label>Alamat</label>
                                        <textarea name='alamat_client' data-height="70" class="form-control @error('alamat_client') is-invalid @enderror">{{ old('alamat_client', $profil_bisni->alamat_client) }}</textarea>
                                        @error('alamat_client')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label>Telpon</label>
                                                <input type="text" name='phone'
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    value="{{ old('phone', $profil_bisni->phone) }}" placeholder="+62">
                                                @error('phone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label>Email</label>
                                                <input type="email" name='email'
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $profil_bisni->email) }}"
                                                    placeholder="email@profil-bisnis.com">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Website</label>
                                        <input type="text" name='web'
                                            class="form-control @error('web') is-invalid @enderror"
                                            value="{{ old('web', $profil_bisni->web) }}" placeholder="https://">
                                        @error('web')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label>Latitude</label>
                                                <input type="text" name='latitude'
                                                    class="form-control @error('latitude') is-invalid @enderror"
                                                    value="{{ old('latitude', $profil_bisni->latitude) }}">
                                                @error('latitude')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label>Longitude</label>
                                                <input type="text" name='longitude'
                                                    class="form-control @error('longitude') is-invalid @enderror"
                                                    value="{{ old('longitude', $profil_bisni->longitude) }}">
                                                @error('longitude')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label>Catatan kaki</label>
                                            <textarea name='footnot' data-height="70" class="form-control @error('footnot') is-invalid @enderror">{{ old('footnot', $profil_bisni->footnot) }}</textarea>
                                            @error('footnot')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <input type="hidden" id='apikey' name='apikey' class="form-control mb-1"
                                            value="{{ old('apikey', $profil_bisni->apikey) }}" readonly>
                                        <input type="hidden" id='urlserver' name='urlserver' class="form-control mb-1"
                                            value="{{ old('urlserver', $profil_bisni->urlserver) }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-md-5 col-lg-5">
                            <div class="card">
                                <div class="card-body">
                                    {{-- <div class="form-group mb-4">
                                        <label>Provinsi</label>
                                        <select class="form-control select2" name="provinsi_id" id="provinsi">
                                            <option value="0">- pilih Provinsi -</option>
                                            @foreach ($provinsi as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $profil_bisni->provinsi_id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Kabupaten</label>
                                        <select class="form-control select2" name="kabupaten_id" id="kabupaten">
                                            @foreach ($kabupaten as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $profil_bisni->kabupaten_id ? 'selected' : '' }}>
                                                    {{ $item->type . ' ' . $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Kecamatan</label>
                                        <select class="form-control select2" name="kecamatan_id" id="kecamatan">
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $profil_bisni->kecamatan_id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Kelurahan</label>
                                        <select class="form-control select2" name="kelurahan_id" id="kelurahan">
                                            @foreach ($kelurahan as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $profil_bisni->kelurahan_id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="form-group mb-3">
                                        <div class="d-flex align-items-start align-items-sm-center gap-6">
                                            <img src="{{ Str::contains(infodesa('logo'), 'image') ? '/' . infodesa('logo') : Storage::url('thumbs/' . infodesa('logo')) }}"
                                                alt="" class="d-block w-px-100 h-px-100 rounded"
                                                id="uploadedAvatar" />
                                            <div class="button-wrapper">
                                                <label for="image-upload" class="btn btn-primary me-3 mb-4"
                                                    tabindex="0">
                                                    <span class="d-none d-sm-block">Logo</span>
                                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                                    <input type="file" id="image-upload" name="logo"
                                                        class="account-file-input @error('logo') is-invalid @enderror"
                                                        hidden accept="image/png, image/jpeg" />
                                                </label>
                                                <button type="button"
                                                    class="btn btn-label-secondary account-image-reset mb-4">
                                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">x</span>
                                                </button>
                                            </div>
                                            @error('logo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="form-group mb-3">
                                        <div class="d-flex align-items-start align-items-sm-center gap-6">
                                            <img src="{{ Str::contains(infodesa('photo'), 'image') ? '/' . infodesa('photo') : Storage::url('thumbs/' . infodesa('photo')) }}"
                                                alt="" class="d-block w-px-100 h-px-100 rounded"
                                                id="uploadedAvatar2" />
                                            <div class="button-wrapper">
                                                <label for="image-upload-2" class="btn btn-primary me-3 mb-4"
                                                    tabindex="0">
                                                    <span class="d-none d-sm-block">Foto Ketua</span>
                                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                                    <input type="file" id="image-upload-2" name="photo"
                                                        class="account-file-input-2 @error('photo') is-invalid @enderror"
                                                        hidden accept="image/png, image/jpeg" />
                                                </label>
                                                <button type="button"
                                                    class="btn btn-label-secondary account-image-reset-2 mb-4">
                                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">x</span>
                                                </button>
                                            </div>
                                            @error('photo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="form-group mb-3">
                                        <div class="d-flex align-items-start align-items-sm-center gap-6">
                                            <img src="{{ Str::contains(infodesa('image_icon'), 'image') ? '/' . infodesa('image_icon') : Storage::url('thumbs/' . infodesa('image_icon')) }}"
                                                alt="" class="d-block w-px-100 h-px-100 rounded"
                                                id="uploadedAvatar3" />
                                            <div class="button-wrapper">
                                                <label for="image-upload-3" class="btn btn-primary me-3 mb-4"
                                                    tabindex="0">
                                                    <span class="d-none d-sm-block">Favicon</span>
                                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                                    <input type="file" id="image-upload-3" name="image_icon"
                                                        class="account-file-input-3 @error('image_icon') is-invalid @enderror"
                                                        hidden accept="image/png, image/jpeg" />
                                                </label>
                                                <button type="button"
                                                    class="btn btn-label-secondary account-image-reset-3 mb-4">
                                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">x</span>
                                                </button>
                                            </div>
                                            @error('image_icon')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mt-5">
                                        <label>Peta</label>
                                        <div id="map"></div>
                                        <div id="mapLink"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group mb-4">
                                    <button id="checkSize" class="btn btn-lg btn-primary" type="submit"><i
                                            class="ti ti-device-floppy ti-lg me-2"></i>Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('v3/assets/js/pages-account-settings-account.js') }}"></script>
    <script src="{{ asset('v3/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('v3/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('v3/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('v3/assets/js/forms-selects.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js"></script>
    <script type="text/javascript">
        $(document).on("change", "#provinsi", function(e) {
            e.preventDefault()
            let provinsiId = this.value;
            let kabupatenSelect = document.getElementById('kabupaten');
            kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';

            if (!provinsiId) {
                return;
            }
            fetch('/api/kabupaten/' + provinsiId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        var option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.type + ' ' + item.name;
                        kabupatenSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        });
        $(document).on("change", "#kabupaten", function(e) {
            e.preventDefault()
            let kabupatenId = this.value;
            let kecamatanSelect = document.getElementById('kecamatan');
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

            if (!kabupatenId) {
                return;
            }
            fetch('/api/kecamatan/' + kabupatenId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        var option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        kecamatanSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        });
        $(document).on("change", "#kecamatan", function(e) {
            e.preventDefault()
            let kecamatanId = this.value;
            let kelurahanSelect = document.getElementById('kelurahan');
            kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';

            if (!kecamatanId) {
                return;
            }
            fetch('/api/kelurahan/' + kecamatanId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        var option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        kelurahanSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        });
        $(document).on("click", "#generate", function(e) {
            e.preventDefault()
            var generate = uuid.v1()
            $("#apikey").val(generate)
        })

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
            let maxSize = 2
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
        $(document).on("change", "#image-upload-3", function(e) {
            e.preventDefault()
            let jmlFiles = $("#image-upload-3")[0].files
            let maxSize = 1
            let totFiles = jmlFiles[0].size
            let filesize = totFiles / 1000 / 1000;
            filesize = filesize.toFixed(1);
            if (filesize > maxSize) {
                showWarningAlert('File foto max. ' + maxSize + ' MB, Total size : ' + filesize + ' MB')
                $("#image-upload-3").val('')
                $('#checkSize').prop('disabled', true);
            } else {
                $('#checkSize').prop('disabled', false);
            }
        });
    </script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var lat = '{{ $profil_bisni->latitude }}';
        var lng = '{{ $profil_bisni->longitude }}';
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

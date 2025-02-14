@extends('layouts.dashboard')

@section('title', $title)

@push('style')
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('v3/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/libs/bootstrap-select/bootstrap-select.css') }}" />
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="card mb-4">
                <div class="card-header header-elements">
                    <h3 class="mb-0 me-2">{{ $title }}</h3>
                    <div class="card-header-elements ms-auto">
                        <span class="text text-muted d-flex">
                            <small>
                                @include('backend.lapak-desa.suplier.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <form id="fileForm" action="{{ route('lapak-desa-suplier.update', $supliers) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-4">
                                                <label>NIK</label>
                                                <select id="select-nik" class="form-control select2">
                                                    <option value="">- pilih Warga -</option>
                                                    @if (count($penduduk) > 0)
                                                        @foreach ($penduduk as $item)
                                                            <option
                                                                value="{{ $item->id . '|' . $item->nama . '|' . $item->telpon . '|' . $item->alamat . '|' . $item->nik }}"
                                                                {{ $supliers->ktp == $item->nik ? 'selected' : '' }}>
                                                                {{ $item->nik . ' - ' . $item->nama }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <input type="hidden" name="user_id" id="input-penduduk_id"
                                                value="{{ $supliers->user_id }}">
                                            <input type="hidden" name="ktp" id="input-nik"
                                                value="{{ $supliers->ktp }}">
                                            <div class="form-group mb-4">
                                                <label>Nama lengkap</label>
                                                <input type="text" class="form-control" name="nama" id="input-nama"
                                                    readonly value="{{ $supliers->nama }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Handphone</label>
                                                <input type="text" class="form-control" name="telpon" id="input-telpon"
                                                    value="{{ $supliers->telpon }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Alamat</label>
                                                <input type="text" class="form-control" name="alamat" id="input-alamat"
                                                    readonly value="{{ $supliers->alamat }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Catatan</label>
                                                <textarea class="form-control @error('keterangan') is-invalid @enderror" data-height="70" name="keterangan">{{ old('keterangan', $supliers->keterangan) }}</textarea>
                                                @error('keterangan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label>Foto Profil</label>
                                                <div class="col-sm-12 col-md-9">
                                                    <div class="d-block text-left">
                                                        <img src="{{ $supliers->photo == null ? asset('img/example-image.jpg') : Storage::url($supliers->photo) }}"
                                                            alt="" class="w-px-100 h-px-100 rounded"
                                                            id="uploadedAvatar" />
                                                        <div class="button-wrapper">
                                                            <label for="image-upload" class="btn btn-sm btn-info my-2"
                                                                tabindex="0">
                                                                <span class="d-none d-sm-block">Upload Image</span>
                                                                <i class="ti ti-upload d-block d-sm-none"></i>
                                                                <input type="file" name="photo" id="image-upload"
                                                                    class="account-file-input @error('photo') is-invalid @enderror"
                                                                    hidden />
                                                            </label>
                                                            <div class="account-image-reset d-none"></div>
                                                        </div>
                                                        @error('photo')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mb-4">
                                        <label>Nama Usaha/UMKM</label>
                                        <input type="text" class="form-control" name="nama_usaha"
                                            value="{{ $supliers->nama_usaha }}">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Jenis Usaha</label>
                                        <select id="select-jenis-usaha" name="jenis_usaha" class="form-control select2">
                                            <option value="">- pilih jenis usaha -</option>
                                            @if (count($kegiatanUsaha) > 0)
                                                @foreach ($kegiatanUsaha as $dt)
                                                    <option value="{{ $dt->id }}"
                                                        {{ $supliers->kegiatan_usaha_id == $dt->id ? 'selected' : '' }}>
                                                        {{ $dt->nama }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Bentuk Usaha</label>
                                        <select id="select-bentuk-usaha" name="bentuk_usaha" class="form-control select2">
                                            <option value="">- pilih bentuk usaha -</option>
                                            @if (count($bentukUsaha) > 0)
                                                @foreach ($bentukUsaha as $dt)
                                                    <option value="{{ $dt->id }}"
                                                        {{ $supliers->bentuk_usaha_id == $dt->id ? 'selected' : '' }}>
                                                        {{ $dt->nama }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label><b>Memiliki izin usaha</b></label>
                                        <div class="d-flex mt-2">
                                            <label class="selectgroup-item me-5">
                                                <input type="radio" name="izin_usaha" value="ya"
                                                    class="form-check-input"
                                                    {{ $supliers->izin_usaha == 'ya' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Ya</span>
                                            </label>
                                            <label class="selectgroup-item me-5">
                                                <input type="radio" name="izin_usaha" value="tidak"
                                                    class="form-check-input"
                                                    {{ $supliers->izin_usaha == 'tidak' || $supliers->izin_usaha == null ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group mb-4">
                                        <label>Keterangan Usaha</label>
                                        <textarea class="form-control @error('keterangan_usaha') is-invalid @enderror" data-height="70"
                                            name="keterangan_usaha">{{ $supliers->keterangan_usaha }}</textarea>
                                        @error('keterangan_usaha')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> --}}
                                </div>
                                <div class="card-footer text-end">
                                    <button id="checkSize" type="submit" class="btn btn-primary btn-lg"><i
                                            class="ti ti-device-floppy me-2"></i> Simpan</button>
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
    <script src="{{ asset('library/summernote/dist/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('v3/libs/select2/select2.js') }}"></script>
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
        $(document).on("change", "#select-nik", function(e) {
            e.preventDefault()
            let dtWarga = this.value.split('|')
            $("#input-penduduk_id").val(dtWarga[0])
            $("#input-nama").val(dtWarga[1])
            $("#input-telpon").val(dtWarga[2])
            $("#input-alamat").val(dtWarga[3])
            $("#input-nik").val(dtWarga[4])
        })
    </script>
@endpush

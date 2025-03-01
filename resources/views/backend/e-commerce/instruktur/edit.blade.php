@extends('layouts.dashboard')

@section('title', $title)

@push('style')
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-lite.min.css') }}">
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
                                @include('backend.e-commerce.instruktur.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <form id="fileForm" action="{{ route('instruktur.update', $instruktur) }}" method="POST"
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
                                                <label>Nama lengkap</label>
                                                <input type="text" class="form-control" name="nama" id="input-nama"
                                                    value="{{ $instruktur->nama }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Handphone</label>
                                                <input type="text" class="form-control" name="telpon" id="input-telpon"
                                                    value="{{ $instruktur->telpon }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Alamat</label>
                                                <input type="text" class="form-control" name="alamat"
                                                    value="{{ $instruktur->alamat }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Catatan</label>
                                                <textarea class="form-control @error('keterangan') is-invalid @enderror" data-height="70" name="keterangan">{{ old('keterangan', $instruktur->keterangan) }}</textarea>
                                                @error('keterangan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Status</label>
                                                <div class="d-flex mt-2">
                                                    <label class="selectgroup-item me-5">
                                                        <input type="radio" name="approval" value="pending"
                                                            class="form-check-input"
                                                            {{ old('approval', $instruktur->approval) == 'pending' ? 'checked' : '' }}>
                                                        <span class="selectgroup-button">Pending</span>
                                                    </label>
                                                    <label class="selectgroup-item me-5">
                                                        <input type="radio" name="approval" value="approved"
                                                            class="form-check-input"
                                                            {{ old('approval', $instruktur->approval) == 'approved' ? 'checked' : '' }}>
                                                        <span class="selectgroup-button">Approved</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label>Foto Profil</label>
                                                <div class="col-sm-12 col-md-9">
                                                    <div class="d-block text-left">
                                                        <img src="{{ $instruktur->photo == null ? asset('img/example-image.jpg') : Storage::url($instruktur->photo) }}"
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
    <script src="{{ asset('library/summernote/dist/summernote-lite.min.js') }}"></script>
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
    </script>
@endpush

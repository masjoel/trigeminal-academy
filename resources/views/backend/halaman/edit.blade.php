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
                                @include('backend.halaman.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="card">
                    <form action="{{ route('halaman.update', $artikel) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                name="title" value="{{ old('title', $artikel->title) }}">
                                            @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control select2" name="idkategori">
                                                @foreach ($kategori as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('idkategori', $artikel->idkategori) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                        <div class="col-sm-12 col-md-7 d-flex">
                                            <label class="selectgroup-item me-5">
                                                <input type="radio" name="status" value="draft" class="form-check-input"
                                                    {{ $artikel->status == 'draft' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Draft</span>
                                            </label>
                                            <label class="selectgroup-item me-5">
                                                <input type="radio" name="status" value="published"
                                                    class="form-check-input"
                                                    {{ $artikel->status == 'published' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Publish</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="summernote" name="deskripsi">{{ $artikel->deskripsi }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mt-5 mb-1">
                                        <div class="d-block text-left">
                                            <img src="{{ $artikel->foto_unggulan == null ? asset('img/example-image.jpg') : Storage::url($artikel->foto_unggulan) }}"
                                                alt="" class="w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                            <div class="button-wrapper">
                                                <label for="image-upload" class="btn btn-sm btn-info my-2" tabindex="0">
                                                    <span class="d-none d-sm-block">Upload Image</span>
                                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                                    <input type="file" name="foto_unggulan" id="image-upload"
                                                        class="account-file-input @error('foto_unggulan') is-invalid @enderror"
                                                        hidden />
                                                </label>
                                                <div class="account-image-reset d-none"></div>
                                            </div>
                                            @error('foto_unggulan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7 d-grid">
                                    <input type="hidden" name="slug" value="{{ $artikel->slug }}">
                                    <button type="submit" class="btn btn-lg btn-primary"><i
                                            class="ti ti-device-floppy me-2"></i> Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

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

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
                                @include('backend.galeri-video.breadcrumb')
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
                    <form action="{{ route('galeri-video.update', $galeri_video) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Title</label>
                                        <div class="col-sm-12 col-md-9">
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                name="title" value="{{ old('title', $galeri_video->title) }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">URL
                                            Video</label>
                                        <div class="col-sm-12 col-md-9">
                                            <input class="form-control" name="excerpt"
                                                value="{{ old('excerpt', $galeri_video->excerpt) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Status</label>
                                        <div class="col-sm-12 col-md-9">
                                            <div class="d-flex mt-2">
                                                <label class="selectgroup-item me-5">
                                                    <input type="radio" name="status" value="draft"
                                                        class="form-check-input"
                                                        {{ $galeri_video->status == 'draft' ? 'checked' : '' }}>
                                                    <span class="selectgroup-button">Draft</span>
                                                </label>
                                                <label class="selectgroup-item me-5">
                                                    <input type="radio" name="status" value="published"
                                                        class="form-check-input"
                                                        {{ $galeri_video->status == 'published' ? 'checked' : '' }}>
                                                    <span class="selectgroup-button">Publish</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Cover
                                            Image</label>
                                        <div class="col-sm-12 col-md-9">
                                            <div class="d-block text-left">
                                                <img src="{{ $galeri_video->foto_unggulan == null ? asset('img/example-image.jpg') : Storage::url($galeri_video->foto_unggulan) }}"
                                                    alt="" class="w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                                <div class="button-wrapper">
                                                    <label for="image-upload" class="btn btn-sm btn-info my-2"
                                                        tabindex="0">
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
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2"></label>
                                        <div class="col-sm-12 col-md-9 d-grid">
                                            <button id="checkSize" type="submit" class="btn btn-primary btn-lg"><i
                                                    class="ti ti-device-floppy me-2"></i> Update</button>
                                        </div>
                                    </div>

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
    </script>
@endpush

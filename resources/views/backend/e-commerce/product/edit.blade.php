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
                                @include('backend.e-commerce.product.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <div class="card">
                    <form id="fileForm" action="{{ route('course.update', $course) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-2">
                                                <label>Judul</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name', $course->name) }}" autocomplete="off">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label>Instruktur</label>
                                                <select class="form-control select2" name="instructor_id">
                                                    @foreach ($instruktur as $mentor)
                                                        <option value="{{ $mentor->id }}"
                                                            {{ old('instructor_id', $course->instructor_id) == $mentor->id ? 'selected' : '' }}>
                                                            {{ $mentor->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label>Kategori</label>
                                                <select class="form-control select2" name="category_id">
                                                    @foreach ($category as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('category_id', $course->category_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label>Harga </label>
                                                <input type="text"
                                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                                    value="{{ old('price', $course->price) }}" autocomplete="off">
                                                @error('price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label>Discount (%)</label>
                                                <input type="text"
                                                    class="form-control @error('discount') is-invalid @enderror"
                                                    name="discount" value="{{ old('discount', $course->discount) }}"
                                                    autocomplete="off">
                                                @error('discount')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label>Status</label>
                                                <div class="d-flex mt-2">
                                                    <label class="selectgroup-item me-5">
                                                        <input type="radio" name="publish" value="1"
                                                            class="form-check-input"
                                                            {{ old('publish', $course->publish) == 1 ? 'checked' : '' }}>
                                                        <span class="selectgroup-button">Publish</span>
                                                    </label>
                                                    <label class="selectgroup-item me-5">
                                                        <input type="radio" name="publish" value="0"
                                                            class="form-check-input"
                                                            {{ old('publish', $course->publish) == 0 ? 'checked' : '' }}>
                                                        <span class="selectgroup-button">Draft</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-4">
                                                <label>Level</label>
                                                <select class="form-control select2" name="level">
                                                    <option value="pemula"
                                                        {{ old('level', $course->level) == 'pemula' ? 'selected' : '' }}>
                                                        Pemula
                                                    </option>
                                                    <option value="menengah"
                                                        {{ old('level', $course->level) == 'menengah' ? 'selected' : '' }}>
                                                        Menengah
                                                    </option>
                                                    <option value="terampil"
                                                        {{ old('level', $course->level) == 'terampil' ? 'selected' : '' }}>
                                                        Terampil
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-4">
                                                <label>Keterangan singkat</label>
                                                <textarea class="form-control @error('excerpt') is-invalid @enderror" name="excerpt">{{ old('excerpt', $course->excerpt) }}</textarea>
                                                @error('excerpt')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Deskripsi</label>
                                        <textarea class="summernote" name="description">{{ $course->description }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-1">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Penyimpanan</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="storage_type" id="select_storage_type"
                                                    class="form-control select2">
                                                    <option value="youtube"
                                                        {{ old('storage_type', $course->storage_type) == 'youtube' ? 'selected' : '' }}>
                                                        YouTube</option>
                                                    <option value="slide"
                                                        {{ old('storage_type', $course->storage_type) == 'slide' ? 'selected' : '' }}>
                                                        Google Slide</option>
                                                    <option value="upload"
                                                        {{ old('storage_type', $course->storage_type) == 'upload' ? 'selected' : '' }}>
                                                        Upload</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <div id="label_wrapper">
                                            <label for="video_input">Video</label>
                                        </div>
                                        <div id="video_input_wrapper">
                                            <input type="text" class="form-control" name="video_url" id="video_url"
                                                placeholder="Masukkan URL YouTube"
                                                value="{{ old('video_url', $course->video_url) }}">
                                        </div>
                                    </div>
                                    {{-- video duration --}}
                                    <div class="form-group mb-4">
                                        <div id="label_duration">
                                            <label for="video_duration">Durasi Video (menit)</label>
                                        </div>
                                        <div id="video_duration_wrapper">
                                            <input type="text"
                                                class="form-control @error('video_duration') is-invalid @enderror"
                                                name="video_duration" id="video_duration" placeholder="5"
                                                value="{{ old('video_duration', $course->video_duration) }}">
                                            @error('video_duration')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <div class="cursor-pointer">
                                            @if ($course->video_url)
                                                @if ($course->storage_type == 'youtube')
                                                    <iframe class="w-100" height="200" src="{{ $course->video_url }}"
                                                        title="YouTube video player" frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                        referrerpolicy="strict-origin-when-cross-origin"
                                                        allowfullscreen></iframe>
                                                @elseif ($course->storage_type == 'slide')
                                                    <iframe class="w-100" height="200"
                                                        src="https://docs.google.com/presentation/d/{{ $course->video_url }}/embed?start=false&loop=false&delayms=5000"
                                                        allowfullscreen="true" mozallowfullscreen="true"
                                                        webkitallowfullscreen="true"></iframe>
                                                @else
                                                    <video class="w-100"
                                                        poster="{{ asset('storage/' . $course->image_url) }}"
                                                        id="plyr-video-player" playsinline controls
                                                        controlsList="nodownload">
                                                        <source
                                                            src="{{ $course->storage_type == 'youtube' ? $course->video_url : asset('storage/' . $course->video_url) }}"
                                                            type="video/mp4" />
                                                    </video>
                                                @endif
                                                {{-- https://www.youtube.com/embed/0hS47NtMlGA?si=0NGtE_GuE1VRw0qR --}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Thumbnail</label>
                                        <div class="col-sm-12 col-md-9">
                                            <div class="d-block text-left">
                                                <img src="{{ $course->image_url == null ? asset('img/example-image.jpg') : Storage::url('thumb/' . $course->image_url) }}"
                                                    alt="" class="w-px-100 h-px-100 rounded"
                                                    id="uploadedAvatar" />
                                                <div class="button-wrapper">
                                                    <label for="image-upload" class="btn btn-sm btn-info my-2"
                                                        tabindex="0">
                                                        <span class="d-none d-sm-block">Upload Image</span>
                                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                                        <input type="file" name="image_url" id="image-upload"
                                                            class="account-file-input @error('image_url') is-invalid @enderror"
                                                            hidden />
                                                    </label>
                                                    <div class="account-image-reset d-none"></div>
                                                </div>
                                                @error('image_url')
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
        $(document).ready(function() {
            function updateVideoInput() {
                var selectedValue = $("#select_storage_type").val();
                var labelWrapper = $("#label_wrapper");
                var labelDuration = $("#label_duration");
                var videoInputWrapper = $("#video_input_wrapper");

                videoInputWrapper.empty(); // Kosongkan elemen

                if (selectedValue === "upload") {
                    videoInputWrapper.append(
                        '<input type="file" class="form-control" name="video_file" id="video_file" value="{{ $course->video_file }}">');
                    labelWrapper.html('<label for="video_input">Video</label>');
                    labelDuration.html('<label for="video_duration">Durasi Video (menit)</label>');
                } else if (selectedValue === "slide") {
                    videoInputWrapper.append(
                        '<input type="text" class="form-control" name="video_url" id="video_url" value="{{ $course->video_url }}" placeholder="Masukkan ID Slide">'
                    );
                    labelWrapper.html('<label for="video_input">Slide</label>');
                    labelDuration.html('<label for="video_duration">Durasi Slide (menit)</label>');
                } else {
                    videoInputWrapper.append(
                        '<input type="text" class="form-control" name="video_url" id="video_url"  value="{{ $course->video_url }}" placeholder="Masukkan URL YouTube">'
                    );
                    labelWrapper.html('<label for="video_input">Video</label>');
                    labelDuration.html('<label for="video_duration">Durasi Video (menit)</label>');
                }
            }

            // Event listener saat select berubah
            $("#select_storage_type").change(updateVideoInput);

            // Jalankan fungsi saat halaman pertama kali dimuat (default YouTube)
            updateVideoInput();
        });
    </script>
@endpush

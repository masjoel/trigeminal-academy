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
                                @include('backend.e-commerce.product.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row g-6">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-6 gap-2">
                                        <div class="me-1">
                                            <h5 class="mb-0">{{ $course->name }}</h5>
                                            <p class="mb-0"><span class="fw-medium text-heading">
                                                    {{ $course->instruktur->nama }}</span></p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-label-danger">{{ $course->productCategory->name }}</span>
                                            {{-- <i class="ti ti-share ti-lg mx-4"></i> --}}
                                            {{-- <i class="ti ti-bookmarks ti-lg"></i> --}}
                                        </div>
                                    </div>
                                    <div class="card academy-content shadow-none border">
                                        <div class="p-2">
                                            @if ($course->video_url)
                                                <video class="w-100" poster="{{ asset('storage/' . $course->image_url) }}"
                                                    id="plyr-video-player" playsinline controls controlsList="nodownload">
                                                    <source
                                                        src="{{ $course->storage_type == 'youtube' ? $course->video_url : asset('storage/' . $course->video_url) }}"
                                                        type="video/mp4" />
                                                </video>
                                            @endif
                                        </div>
                                        <div class="card-body pt-4">
                                            <h5>Tentang Kelas</h5>
                                            <p class="mb-0">
                                                {{ $course->excerpt }}
                                            </p>
                                            <hr class="my-6" />
                                            <h5>Statistik</h5>
                                            <div class="d-flex flex-wrap row-gap-2">
                                                <div class="me-12">
                                                    <p class="text-nowrap mb-2">
                                                        <i class="ti ti-check me-2 align-bottom"></i>Skill level:
                                                        {{ ucwords($course->level) }}
                                                    </p>
                                                    <p class="text-nowrap mb-2"><i
                                                            class="ti ti-users me-2 align-top"></i>Students:
                                                        {{ $totStudent }}</p>
                                                    {{-- <p class="text-nowrap mb-2">
                                                        <i class="ti ti-world me-2 align-bottom"></i>Languages: English
                                                    </p> --}}
                                                    {{-- <p class="text-nowrap mb-0"><i class="ti ti-file me-2 align-bottom"></i>Captions: Yes</p> --}}
                                                </div>
                                                <div>
                                                    {{-- <p class="text-nowrap mb-2">
                                                        <i class="ti ti-video me-2 align-top ms-50"></i>Lectures: 19
                                                    </p> --}}
                                                    <p class="text-nowrap mb-0">
                                                        <i class="ti ti-clock me-2 align-top"></i>Video:
                                                        {{ $course->video_duration }} menit
                                                    </p>
                                                </div>
                                            </div>
                                            <hr class="my-6" />
                                            <h5>Deskripsi</h5>
                                            <p class="mb-6">
                                                {!! nl2br($course->description) !!}
                                            </p>
                                            <hr class="my-6" />
                                            <h5>Instruktur</h5>
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                                <div class="avatar-wrapper">
                                                    <div class="avatar me-4">
                                                        @if ($course->instruktur->photo)
                                                            <img src="{{ Storage::url($course->instruktur->photo) }}"
                                                                class="rounded-circle" alt="Avatar">
                                                        @else
                                                            <i class="far fa-image fa-2x"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1">{{ $course->instruktur->nama }}</h6>
                                                    <small>{{ $course->instruktur->keterangan }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-4">
                            <div class="accordion stick-top accordion-custom-button" id="courseContent">
                                <div class="accordion-item active mb-0">
                                    <div class="accordion-header" id="headingOne">
                                        <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#chapterOne" aria-expanded="true" aria-controls="chapterOne">
                                            <span class="d-flex flex-column">
                                                <span class="h5 mb-0">Course Content</span>
                                                <span class="text-body fw-normal">2 / 5 | 4.4 min</span>
                                            </span>
                                        </button>
                                    </div>
                                    <div id="chapterOne" class="accordion-collapse collapse show"
                                        data-bs-parent="#courseContent">
                                        <div class="accordion-body py-4">
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"
                                                    checked="" />
                                                <label for="defaultCheck1" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">1. Welcome to this course</span>
                                                    <small class="text-body d-block">2.4 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"
                                                    checked="" />
                                                <label for="defaultCheck2" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">2. Watch before you start</span>
                                                    <small class="text-body d-block">4.8 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                <label for="defaultCheck3" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">3. Basic design theory</span>
                                                    <small class="text-body d-block">5.9 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                <label for="defaultCheck4" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">4. Basic fundamentals</span>
                                                    <small class="text-body d-block">3.6 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-0">
                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                <label for="defaultCheck5" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">5. What is ui/ux</span>
                                                    <small class="text-body d-block">10.6 min</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header" id="headingTwo">
                                        <button type="button" class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#chapterTwo" aria-expanded="false"
                                            aria-controls="chapterTwo">
                                            <span class="d-flex flex-column">
                                                <span class="h5 mb-0">Web Design for Web Developers</span>
                                                <span class="text-body fw-normal">1 / 4 | 4.4 min</span>
                                            </span>
                                        </button>
                                    </div>
                                    <div id="chapterTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#courseContent">
                                        <div class="accordion-body py-4">
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck1"
                                                    checked="" />
                                                <label for="defCheck1" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">1. How to use Pages in Figma</span>
                                                    <small class="text-body d-block">8:31 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck2" />
                                                <label for="defCheck2" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">2. What is Lo Fi Wireframe</span>
                                                    <small class="text-body d-block">2 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck3" />
                                                <label for="defCheck3" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">3. How to use color in Figma</span>
                                                    <small class="text-body d-block">5.9 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-0">
                                                <input class="form-check-input" type="checkbox" id="defCheck4" />
                                                <label for="defCheck4" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">4. Frames vs Groups in Figma</span>
                                                    <small class="text-body d-block">3.6 min</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header" id="headingThree">
                                        <button type="button" class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#chapterThree"
                                            aria-expanded="false" aria-controls="chapterThree">
                                            <span class="d-flex flex-column">
                                                <span class="h5 mb-0">Build Beautiful Websites!</span>
                                                <span class="text-body fw-normal">0 / 6 | 4.4 min</span>
                                            </span>
                                        </button>
                                    </div>
                                    <div id="chapterThree" class="accordion-collapse collapse"
                                        data-bs-parent="#courseContent">
                                        <div class="accordion-body py-4">
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck-01" />
                                                <label for="defCheck-01" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">1. Section & Div Block</span>
                                                    <small class="text-body d-block">8:31 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck-02" />
                                                <label for="defCheck-02" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">2. Read-Only Version of Chat App</span>
                                                    <small class="text-body d-block">8 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck-03" />
                                                <label for="defCheck-03" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">3. Webflow Autosave</span>
                                                    <small class="text-body d-block">2.9 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck-04" />
                                                <label for="defCheck-04" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">4. Canvas Settings</span>
                                                    <small class="text-body d-block">7.6 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck-05" />
                                                <label for="defCheck-05" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">5. HTML Tags</span>
                                                    <small class="text-body d-block">10 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-0">
                                                <input class="form-check-input" type="checkbox" id="defCheck-06" />
                                                <label for="defCheck-06" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">6. Footer (Chat App)</span>
                                                    <small class="text-body d-block">9.10 min</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header" id="headingFour">
                                        <button type="button" class="accordion-button collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#chapterFour" aria-expanded="false"
                                            aria-controls="chapterFour">
                                            <span class="d-flex flex-column">
                                                <span class="h5 mb-0">Final Project</span>
                                                <span class="text-body fw-normal">2 / 3 | 4.4 min</span>
                                            </span>
                                        </button>
                                    </div>
                                    <div id="chapterFour" class="accordion-collapse collapse"
                                        data-bs-parent="#courseContent">
                                        <div class="accordion-body py-4">
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck-101"
                                                    checked="" />
                                                <label for="defCheck-101" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">1. Responsive Blog Site</span>
                                                    <small class="text-body d-block">10:0 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                                <input class="form-check-input" type="checkbox" id="defCheck-102"
                                                    checked="" />
                                                <label for="defCheck-102" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">2. Responsive Portfolio</span>
                                                    <small class="text-body d-block">13:00 min</small>
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-1 mb-0">
                                                <input class="form-check-input" type="checkbox" id="defCheck-103" />
                                                <label for="defCheck-103" class="form-check-label ms-4">
                                                    <span class="mb-0 h6">3. Responsive eCommerce Website</span>
                                                    <small class="text-body d-block">15 min</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
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
        $(document).ready(function() {
            function updateVideoInput() {
                var selectedValue = $("#select_storage_type").val();
                var videoInputWrapper = $("#video_input_wrapper");

                videoInputWrapper.empty(); // Kosongkan elemen

                if (selectedValue === "upload") {
                    videoInputWrapper.append(
                        '<input type="file" class="form-control" name="video_file" id="video_file">');
                } else {
                    videoInputWrapper.append(
                        '<input type="text" class="form-control" name="video_url" id="video_url" placeholder="Masukkan URL YouTube">'
                    );
                }
            }

            // Event listener saat select berubah
            $("#select_storage_type").change(updateVideoInput);

            // Jalankan fungsi saat halaman pertama kali dimuat (default YouTube)
            updateVideoInput();
        });
    </script>
@endpush

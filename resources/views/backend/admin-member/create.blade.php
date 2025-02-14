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
                                @include('backend.admin-member.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-8">
                        <div class="card">
                            <form action="{{ route('admin-member.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <label for="nama">Nama lengkap</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text"
                                                            class="form-control @error('nama') is-invalid @enderror"
                                                            name="nama" id="nama" value="{{ old('nama') }}"
                                                            required>
                                                        @error('nama')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg">
                                                    <label for="telpon">No.Telp/HP</label>
                                                    <div class="input-group mb-3">
                                                        <input type="number"
                                                            class="form-control @error('telpon') is-invalid @enderror"
                                                            name="telpon" id="telpon" value="{{ old('telpon') }}">
                                                        @error('telpon')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg">
                                                    <label for="email">Email</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" id="email" value="{{ old('email') }}">
                                                        @error('email')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-4">
                                                    <label for="gender">Jenis Kelamin</label>
                                                    <div class="input-group mb-3">
                                                        <select class="form-select @error('gender') is-invalid @enderror"
                                                            name="gender" id="gender" aria-label="Pilih jenis kelamin"
                                                            required>
                                                            @foreach ($jenis_kelamin as $dt)
                                                                <option value="{{ $dt }}"
                                                                    {{ old('gender') == $dt ? 'selected' : '' }}>
                                                                    {{ ucwords($dt) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('gender')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-4">
                                                    <label for="pilih-pendidikan">Pendidikan</label>
                                                    <div class="input-group mb-3">
                                                        <select
                                                            class="form-select @error('pendidikan') is-invalid @enderror"
                                                            name="pendidikan" id="pilih-pendidikan"
                                                            aria-label="Pilih pendidikan" required>
                                                            <option selected value="" disabled>- pilih -</option>
                                                            @foreach ($pendidikan as $dt)
                                                                <option value="{{ $dt }}"
                                                                    {{ old('pendidikan') == $dt ? 'selected' : '' }}>
                                                                    {{ strtoupper($dt) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('pendidikan')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-4">
                                                    <label for="pilih-pekerjaan">Pekerjaan</label>
                                                    <div class="input-group mb-3">
                                                        <select name="pekerjaan"
                                                            class="form-select @error('pekerjaan') is-invalid @enderror"
                                                            id="pilih-pekerjaan" aria-label="Pilih pekerjaan" required>
                                                            <option selected value="" disabled>- pilih -</option>
                                                            @foreach ($pekerjaan as $dt)
                                                                <option value="{{ $dt }}"
                                                                    {{ old('pekerjaan') == $dt ? 'selected' : '' }}>
                                                                    {{ strtoupper($dt) }}
                                                                </option>
                                                            @endforeach
                                                            <option value="lainnya">Lainnya
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group
                                                    mb-3"
                                                        id="input-pekerjaan-lainnya" style="display: none;">
                                                        <input type="text"
                                                            class="form-control @error('pekerjaan') is-invalid @enderror"
                                                            id="pekerjaan-lainnya" placeholder="Masukkan pekerjaan Anda"
                                                            value="{{ old('pekerjaan') }}">
                                                        @error('pekerjaan')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" name="pekerjaan_lain" id="pekerjaan-value"
                                                        value="{{ old('pekerjaan_lain') }}" required>
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="alamat">Alamat rumah</label>
                                                    <div class="input-group mb-3">
                                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat">{{ old('alamat') }}</textarea>
                                                        @error('alamat')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="keterangan">Status</label>
                                                    <div class="input-group my-3">
                                                        <div class="col-sm-12 col-md-7 d-flex">
                                                            <label class="selectgroup-item me-5">
                                                                <input type="radio" name="status" value="pending"
                                                                    class="form-check-input">
                                                                <span class="selectgroup-button">Pending</span>
                                                            </label>
                                                            <label class="selectgroup-item me-5">
                                                                <input type="radio" name="status" value="aktif"
                                                                    class="form-check-input" checked="">
                                                                <span class="selectgroup-button">Aktif</span>
                                                            </label>
                                                            <label class="selectgroup-item me-5">
                                                                <input type="radio" name="status" value="non aktif"
                                                                    class="form-check-input">
                                                                <span class="selectgroup-button">Non Aktif</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div>
                                        <div class="col-lg"> --}}
                                            
                                            {{-- <div class="row">
                                                <div class="col-lg">
                                                    <div class="d-block text-left">
                                                        <img src="{{ asset('image/icon-foto.png') }}" alt=""
                                                            class="w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                                        <div class="button-wrapper">
                                                            <label for="image-upload" class="btn btn-sm btn-info my-2"
                                                                tabindex="0">
                                                                <span class="d-none d-sm-block">Upload Foto</span>
                                                                <i class="ti ti-upload d-block d-sm-none"></i>
                                                                <input type="file" name="image" id="image-upload"
                                                                    class="account-file-input @error('image') is-invalid @enderror"
                                                                    hidden />
                                                            </label>
                                                            <div class="account-image-reset d-none"></div>
                                                        </div>
                                                        @error('image')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="form-group row my-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                            <div class="col-sm-12 col-md-7 d-grid">
                                                <button id="checkSize" type="submit" class="btn btn-primary btn-lg"><i
                                                        class="ti ti-device-floppy me-2"></i> Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
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
        $(document).ready(function() {
            $('#pilih-pekerjaan').change(function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'lainnya') {
                    $('#input-pekerjaan-lainnya').show();
                    $('#pekerjaan-lainnya').attr('required', true);
                    $('#pekerjaan-value').val('');
                } else {
                    $('#input-pekerjaan-lainnya').hide();
                    $('#pekerjaan-lainnya').attr('required', false);
                    $('#pekerjaan-value').val(selectedValue);
                }
            });

            $('#pekerjaan-lainnya').on('input', function() {
                var pekerjaanLainnya = $(this).val().trim();
                var isValid = pekerjaanLainnya.length > 0 && /[a-zA-Z0-9]/.test(pekerjaanLainnya);

                if (isValid) {
                    $('#pekerjaan-value').val(pekerjaanLainnya);
                    $(this).removeClass('is-invalid');
                } else {
                    $('#pekerjaan-value').val('');
                    $(this).addClass('is-invalid');
                }
            });
        });
    </script>
@endpush

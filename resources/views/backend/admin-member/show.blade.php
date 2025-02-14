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
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="card">
                    <form action="{{ route('admin-member.update', $anggota) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-7">
                                            <label for="nama">Nama lengkap</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror" name="nama"
                                                    id="nama" value="{{ old('nama', $anggota->nama) }}" required>
                                                @error('nama')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-5">
                                            <label for="paspor">NRA</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('paspor') is-invalid @enderror"
                                                    name="paspor" id="paspor"
                                                    value="{{ old('paspor', $anggota->paspor) }}" required>
                                                @error('paspor')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <label for="nama">Nama lengkap</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            name="nama" id="nama" value="{{ old('nama', $anggota->nama) }}"
                                            required>
                                        @error('nama')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-md-12 col-lg-8">
                                            <label for="nik">NIK</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('nik') is-invalid @enderror" name="nik"
                                                    id="nik" value="{{ old('nik', $anggota->nik) }}" required>
                                                @error('nik')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <label for="gender">Jenis Kelamin</label>
                                            <div class="input-group mb-3">
                                                <select class="form-select @error('gender') is-invalid @enderror"
                                                    name="gender" id="gender" aria-label="Pilih jenis kelamin" required>
                                                    @foreach ($jenis_kelamin as $dt)
                                                        <option value="{{ $dt }}"
                                                            {{ $dt == $anggota->gender ? 'selected' : '' }}>
                                                            {{ ucwords($dt) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('gender')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="tempat-lahir">Tempat lahir</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                    name="tempat_lahir" id="tempat_lahir"
                                                    value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}" required>
                                                @error('tempat_lahir')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <label for="tgl-lahir">Tgl. lahir</label>
                                            <div class="input-group mb-3">
                                                <input type="date"
                                                    class="form-control @error('tgl_lahir') is-invalid @enderror"
                                                    name="tgl_lahir" id="tgl_lahir"
                                                    value="{{ old('tgl_lahir', $anggota->tgl_lahir) }}" required>
                                                @error('tgl_lahir')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="agama">Agama</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('agama') is-invalid @enderror" name="agama"
                                                    id="agama" value="{{ old('agama', $anggota->agama) }}" required>
                                                @error('agama')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <label for="pilih-pendidikan">Pendidikan</label>
                                            <div class="input-group mb-3">
                                                <select class="form-select @error('pendidikan') is-invalid @enderror"
                                                    name="pendidikan" id="pilih-pendidikan" aria-label="Pilih pendidikan"
                                                    required>
                                                    <option selected value="" disabled>- pilih -</option>
                                                    @foreach ($pendidikan as $dt)
                                                        <option value="{{ $dt }}"
                                                            {{ $dt == $anggota->pendidikan ? 'selected' : '' }}>
                                                            {{ strtoupper($dt) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('pendidikan')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <label for="pilih-pekerjaan">Pekerjaan</label>
                                            <div class="input-group mb-3">
                                                <select name="pekerjaan"
                                                    class="form-select @error('pekerjaan') is-invalid @enderror"
                                                    id="pilih-pekerjaan" aria-label="Pilih pekerjaan" required>
                                                    <option selected value="" disabled>- pilih -</option>
                                                    @foreach ($pekerjaan as $dt)
                                                        <option value="{{ $dt }}"
                                                            {{ $dt == $anggota->pekerjaan ? 'selected' : '' }}>
                                                            {{ strtoupper($dt) }}
                                                        </option>
                                                    @endforeach
                                                    <option value="lainnya">Lainnya
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="input-group mb-3" id="input-pekerjaan-lainnya"
                                                style="display: none;">
                                                <input type="text"
                                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                                    id="pekerjaan-lainnya" placeholder="Masukkan pekerjaan Anda"
                                                    value="{{ old('pekerjaan', $anggota->pekerjaan) }}">
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
                                                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat">{{ old('alamat', $anggota->alamat) }}</textarea>
                                                @error('alamat')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="keterangan">Status</label>
                                            <div class="input-group my-3 d-flex">
                                                <label class="selectgroup-item me-5">
                                                    <input type="radio" name="status" value="pending"
                                                        class="form-check-input"
                                                        {{ $anggota->status == 'pending' ? 'checked' : '' }}>
                                                    <span class="selectgroup-button">Pending</span>
                                                </label>
                                                <label class="selectgroup-item me-5">
                                                    <input type="radio" name="status" value="aktif"
                                                        class="form-check-input"
                                                        {{ $anggota->status == 'aktif' ? 'checked' : '' }}>
                                                    <span class="selectgroup-button">Aktif</span>
                                                </label>
                                                <label class="selectgroup-item me-5">
                                                    <input type="radio" name="status" value="non aktif"
                                                        class="form-check-input"
                                                        {{ $anggota->status == 'non aktif' ? 'checked' : '' }}>
                                                    <span class="selectgroup-button">Non Aktif</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="telpon">No.Telp/HP</label>
                                            <div class="input-group mb-3">
                                                <input type="number"
                                                    class="form-control @error('telpon') is-invalid @enderror"
                                                    name="telpon" id="telpon"
                                                    value="{{ old('telpon', $anggota->telpon) }}">
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
                                                    name="email" id="email"
                                                    value="{{ old('email', $anggota->email) }}">
                                                @error('email')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h5>Keterwakilan</h5>
                                        <div class="col-lg">
                                            <label for="wakil_dpp">DPP</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('wakil_dpp') is-invalid @enderror"
                                                    name="wakil_dpp" id="wakil_dpp"
                                                    value="{{ old('wakil_dpp', $anggota->wakil_dpp) }}">
                                                @error('wakil_dpp')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <label for="wakil_dpw">DPW</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('wakil_dpw') is-invalid @enderror"
                                                    name="wakil_dpw" id="wakil_dpw"
                                                    value="{{ old('wakil_dpw', $anggota->wakil_dpw) }}">
                                                @error('wakil_dpw')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <label for="wakil_dpd">DPD</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('wakil_dpd') is-invalid @enderror"
                                                    name="wakil_dpd" id="wakil_dpd"
                                                    value="{{ old('wakil_dpd', $anggota->wakil_dpd) }}">
                                                @error('wakil_dpd')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="wakil_dpc">DPC</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('wakil_dpc') is-invalid @enderror"
                                                    name="wakil_dpc" id="wakil_dpc"
                                                    value="{{ old('wakil_dpc', $anggota->wakil_dpc) }}">
                                                @error('wakil_dpc')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <label for="wakil_dpac">DPAC</label>
                                            <div class="input-group mb-3">
                                                <input type="text"
                                                    class="form-control @error('wakil_dpac') is-invalid @enderror"
                                                    name="wakil_dpac" id="wakil_dpac"
                                                    value="{{ old('wakil_dpac', $anggota->wakil_dpac) }}">
                                                @error('wakil_dpac')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <div class="d-block text-left">
                                                <img src="{{ $anggota->image == null ? asset('image/icon-foto.png') : Storage::url($anggota->image) }}"
                                                    alt="" class="w-px-100 h-px-100 rounded"
                                                    id="uploadedAvatar" />
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
                                        <div class="col-lg">
                                            <div class="d-block text-left">
                                                <img src="{{ $anggota->image_ktp == null ? asset('image/icon-foto.png') : Storage::url($anggota->image_ktp) }}"
                                                    alt="" class="w-px-100 h-px-100 rounded"
                                                    id="uploadedAvatar2" />
                                                <div class="button-wrapper">
                                                    <label for="image-upload-2" class="btn btn-sm btn-info my-2"
                                                        tabindex="0">
                                                        <span class="d-none d-sm-block">Upload Foto KTP</span>
                                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                                        <input type="file" name="image_ktp" id="image-upload-2"
                                                            class="account-file-input-2 @error('image_ktp') is-invalid @enderror"
                                                            hidden />
                                                    </label>
                                                    <div class="account-image-reset-2 d-none"></div>
                                                </div>
                                                @error('image_ktp')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
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

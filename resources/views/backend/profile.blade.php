@extends('layouts.dashboard')

@section('title', 'Profile')

@push('style')
@endpush

@section('main')
    @php
        use App\Models\Student;
    $user = Student::where('user_id', auth()->user()->id)->first(); @endphp
    <div class="main-content">
        <section class="section">
            <div class="card mb-4">
                <div class="card-header header-elements">
                    <h3 class="mb-0 me-2">Profile</h3>
                    <div class="card-header-elements ms-auto">
                        <span class="text text-muted d-flex">
                            <small>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-style1">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item">Profile</li>
                                    </ol>
                                </nav>
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-5">
                        <div class="card mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <img alt="image"
                                    src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('img/avatar/avatar-1.png') }}"
                                    class="ms-5 rounded-circle" height="100" width="100">
                                <div class="row">
                                    <div class="col-12"><b>{{ auth()->user()->name }}</b></div>
                                    <div class="col-12">
                                        <span class="text-success">{!! auth()->user()->username !!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <form method="post" action="{{ route('user-password.update') }}" class="needs-validation"
                                novalidate="" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>Edit Password</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group mb-4 col-md-5 col-12">
                                            <label>Current Pasword</label>
                                            <input type="password"
                                                class="form-control @error('current_password', 'updatePassword')
                                                is-invalid
                                            @enderror"
                                                name="current_password">
                                            @error('current_password', 'updatePassword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-4 col-md-6 col-12">
                                            <label>New Password</label>
                                            <input type="password" name='password'
                                                class="form-control @error('password', 'updatePassword')
                                                is-invalid
                                            @enderror">
                                            @error('password', 'updatePassword')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4 col-md-6 col-12">
                                            <label>Password Confirmation</label>
                                            <input type="password" class="form-control" name='password_confirmation'>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-lg btn-primary" type="submit">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="card">
                            <form id="fileForm" method="post" action="{{ route('user-profile-information.update') }}"
                                class="needs-validation" novalidate="" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-4">
                                                <label>Name</label>
                                                <input type="text" name='name'
                                                    class="form-control @error('name', 'updateProfileInformation')
                                                is-invalid
                                            @enderror"
                                                    value="{{ old('name', auth()->user()->name) }}">
                                                @error('name', 'updateProfileInformation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Email</label>
                                                <input type="email"
                                                    class="form-control @error('email', 'updateProfileInformation')
                                            is-invalid
                                            @enderror"
                                                    name='email' value="{{ old('email', auth()->user()->email) }}"
                                                    required="">
                                                @error('email', 'updateProfileInformation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Phone</label>
                                                <input type="tel"
                                                    class="form-control @error('phone', 'updateProfileInformation')
                                                is-invalid
                                            @enderror"
                                                    value="{{ old('phone', auth()->user()->phone) }}" name="phone">
                                                @error('phone', 'updateProfileInformation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            @if (auth()->user()->role == 'user')
                                                <div class="form-group mb-4">
                                                    <label>Alamat</label>
                                                    <textarea name="alamat" class="form-control" data-height="40">{{ old('alamat', $user->alamat) }}</textarea>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label>Catatan</label>
                                                    <textarea name="keterangan" class="form-control" data-height="60">{{ old('keterangan', $user->keterangan) }}</textarea>
                                                </div>
                                            @else
                                                <input type="hidden" name="alamat" value="address">
                                                <input type="hidden" name="keterangan" value="keterangan">
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-4 mb-2">
                                                <label>Avatar</label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('img/avatar/avatar-1.png') }}"
                                                        alt="" class="w-px-100 h-px-100 rounded"
                                                        id="uploadedAvatar" />
                                                    <div class="button-wrapper">
                                                        <label for="image-upload" class="btn btn-sm btn-info my-2"
                                                            tabindex="0">
                                                            <span class="d-none d-sm-block">Upload Image</span>
                                                            <i class="ti ti-upload d-block d-sm-none ti-lg"></i>
                                                            <input type="file" name="avatar" id="image-upload"
                                                                class="account-file-input @error('avatar') is-invalid @enderror"
                                                                hidden />
                                                        </label>
                                                        <div class="account-image-reset d-none"></div>
                                                    </div>
                                                    @error('avatar')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input type="hidden" name="bio">
                                        <div class="form-group mb-4 text-right mt-5">
                                            <button id="checkSize" class="btn btn-lg btn-primary" type="submit">Save
                                                Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('v3/assets/js/pages-account-settings-account.js') }}"></script>
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

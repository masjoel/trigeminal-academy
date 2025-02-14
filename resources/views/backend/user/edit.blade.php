@extends('layouts.dashboard')

@section('title', $title)

@push('style')
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
                                @include('backend.user.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form id="fileForm" action="{{ route('user.update', $user) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-4">
                                                <label>Nama</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name', $user->name) }}" autocomplete="off">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label>Username</label>
                                                        <input id="username" type="text"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            name="username" value="{{ old('username', $user->username) }}"
                                                            autocomplete="off">
                                                        @error('username')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label>Password</label>
                                                        <input type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" placeholder="********">
                                                        @error('password')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label>Email</label>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" value="{{ old('email', $user->email) }}">
                                                        @error('email')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-4">
                                                        <label>Phone</label>
                                                        <input type="text"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            name="phone" value="{{ old('phone', $user->phone) }}">
                                                        @error('phone')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label class="form-label">Roles</label>
                                                <select name="role" class="form-control select2">
                                                    @foreach ($roles as $item)
                                                        <option value="{{ $item->name }}"
                                                            {{ $user->role == $item->name ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="d-flex align-items-start align-items-sm-center gap-6">
                                                    <img src="{{ $user->avatar == null ? asset('img/example-image.jpg') : Storage::url('thumbs/' . $user->avatar) }}"
                                                        alt="" class="d-block w-px-100 h-px-100 rounded"
                                                        id="uploadedAvatar" />
                                                    <div class="button-wrapper">
                                                        <label for="upload" class="btn btn-primary me-3 mb-4"
                                                            tabindex="0">
                                                            <span class="d-none d-sm-block">Upload Foto</span>
                                                            <i class="ti ti-upload d-block d-sm-none"></i>
                                                            <input type="file" id="upload" name="avatar"
                                                                class="account-file-input @error('avatar') is-invalid @enderror"
                                                                hidden accept="image/png, image/jpeg" />
                                                        </label>
                                                        <button type="button"
                                                            class="btn btn-label-secondary account-image-reset mb-4">
                                                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">x</span>
                                                        </button>
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

                                </div>
                                <div class="card-footer text-right">
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button id="checkSize" type="submit" class="btn btn-lg btn-primary"><i
                                            class="ti ti-device-floppy me-2"></i> Simpan</button>
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
    <script src="{{ asset('v3/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('v3/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('v3/assets/js/forms-selects.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#username').on('input', function() {
                var inputValue = $(this).val();
                inputValue = inputValue.toLowerCase();
                inputValue = inputValue.replace(/[^a-z0-9]/g, '.');
                $(this).val(inputValue);
            });
        });
    </script>
@endpush

@extends('layouts.auth-v3')

@section('title', 'Lupa Password')

@push('style')
    <link rel="stylesheet" href="{{ asset('v3/libs/@form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/css/pages/page-auth.css') }}" />
@endpush

@section('main')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-0">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-9">
                            <a title="Logo" href="{{ route('home') }}" class="site__brand__logo">
                                @if (infodesa('logo') == null)
                                    Desaku
                                @else
                                    <img src="{{ infodesa('logo') == 'image/icon-lkp2mpd.png' ? klien('logo') : Storage::url(infodesa('logo')) }}"
                                        style="max-height:80px; height:auto; max-width:350px"
                                        alt="{{ infodesa('nama_client') }}" class="">
                                @endif
                            </a>
                        </div>
                        <div class="app-brand justify-content-start mb-0">
                            <h5 class="text-primary">Lupa Password</h5>
                        </div>
                        <p class="">Link untuk reset password akan terkirim ke email</p>
                        <!-- /Logo -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email"><b>Email</b></label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" autofocus />
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="my-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Lupa Password</button>
                            </div>
                            <div class="mb-6">
                                <div class="d-flex justify-content-start">
                                    Sudah punya akun ? &nbsp;<a href="{{ route('login') }}">Login disini</a>
                                </div>
                            </div>
                        </form>
                        <div class="text-center text-muted">
                            <small>Copyright &copy; {{ date('Y') }}</small>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('v3/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('v3/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('v3/libs/@form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('v3/assets/js/pages-auth.js') }}"></script>
@endpush

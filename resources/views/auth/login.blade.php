@extends('layouts.auth-v3')

@section('title', 'Login')

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
                        <!-- /Logo -->
                        @if ($cek1 == 0 || $cek2 == 0)
                            <div class="form-group mb-4">
                                Kirim kode <span
                                    class="text-primary"><b>{{ substr(strtoupper(md5($mcad)), 0, 9) }}</b></span>
                                via
                                SMS/WA
                                ke nomor: <strong>0813 2487 9254</strong>
                                untuk mendapatkan <i>
                                    <span class="text-danger">KODE AKTIVASI</span>
                                </i> <br>
                                <form method="POST" action="{{ route('aktivasi') }}" class="needs-validation"
                                    novalidate="">
                                    @csrf
                                    <div class="form-group my-3">
                                        <input class="form-control" placeholder="Masukkan Kode Aktivasi" name="kode"
                                            type="text" autocomplete="off" autofocus>
                                    </div>
                                    <div class="form-group d-grid">
                                        <button type="submit" class="btn btn-warning btn-lg btn-block" tabindex="4">
                                            AKTIFKAN
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <form class="mb-0 needs-validation" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="email" class="">Email or Username</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" autofocus />
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-4 form-password-toggle">
                                    <label class="" for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password" />
                                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="my-4">
                                    <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                                </div>
                                <div class="mb-6">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('password.request') }}">
                                            <p class="mb-0">Lupa Password ?</p>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        @endif
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

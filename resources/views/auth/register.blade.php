{{-- @extends('layouts.auth')

@section('title', 'Register')

@push('style')
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="card card-primary">
    <div class="card-header">
        <h4>Register</h4>
    </div>

    <div class="card-body">
        <form method="POST">
            @csrf
            <div class="form-group mb-1">
                <label for="frist_name">Nama Outlet</label>
                <input id="frist_name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" autocomplete="off" autofocus>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group my-1">
                <label for="username">Username</label>
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                    name="username" value="{{ old('username') }}" autocomplete="off">
                @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group my-1">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group my-1">
                <label for="password" class="d-block">Password</label>
                <input id="password" type="password" class="form-control @error('password')
                        is-invalid @enderror" name="password">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group my-1">
                <label for="password2" class="d-block">Password Confirmation</label>
                <input id="password2" type="password" class="form-control" name="password_confirmation">
            </div>

            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Register
                </button>
            </div>
            Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>
<script src="{{ asset('js/page/auth-register.js') }}"></script>
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
@endpush --}}
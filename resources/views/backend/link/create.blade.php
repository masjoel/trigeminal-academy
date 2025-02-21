@extends('layouts.dashboard')

@section('title', 'All ' . $title . 's')

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
                                @include('backend.link.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <form action="{{ route('link.store') }}" method="POST">
                    @csrf
                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-8 col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mb-4">
                                        <label>URL</label>
                                        <input type="text" name="url_ext"
                                            class="form-control @error('url_ext') is-invalid @enderror"
                                            value="{{ old('url_ext') }}" placeholder="https://example.com/" autofocus>
                                        @error('url_ext')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>Keterangan</label>
                                        <input type="text" name="keterangan"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            value="{{ old('keterangan') }}">
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-4">
                                            <label>Tipe</label>
                                            <select name="tipe" class="form-select @error('tipe') is-invalid @enderror">
                                                <option value="medsos" {{ old('tipe') == 'medsos' ? 'selected' : '' }}>Media
                                                    Sosial</option>
                                                <option value="external" {{ old('tipe') == 'external' ? 'selected' : '' }}>
                                                    Link
                                                    Eksternal</option>
                                            </select>
                                            @error('tipe')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-lg btn-primary"><i
                                            class="ti ti-device-floppy me-2"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('v3/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('v3/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('v3/assets/js/forms-selects.js') }}"></script>
@endpush

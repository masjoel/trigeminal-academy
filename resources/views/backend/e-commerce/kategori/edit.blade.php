@extends('layouts.dashboard')

@section('title', $title)

@push('style')
    <link rel="stylesheet" href="{{ asset('v3/libs/select2/select2.css') }}" />
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
                                @include('backend.e-commerce.kategori.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <div class="card">
                    <form action="{{ route('kategori-kursus.update', $category) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Nama Kategori</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name', $category->name) }}" autocomplete="off">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Colour</label>
                                        <select name="warna" class="form-control select2">
                                            <option value="primary" {{ $category->warna == 'primary' ? 'selected' : '' }}>
                                                Primary</option>
                                            <option value="secondary"
                                                {{ $category->warna == 'secondary' ? 'selected' : '' }}>Secondary</option>
                                            <option value="success" {{ $category->warna == 'success' ? 'selected' : '' }}>
                                                Success</option>
                                            <option value="danger" {{ $category->warna == 'danger' ? 'selected' : '' }}>
                                                Danger</option>
                                            <option value="warning" {{ $category->warna == 'warning' ? 'selected' : '' }}>
                                                Warning</option>
                                            <option value="info" {{ $category->warna == 'info' ? 'selected' : '' }}>Info
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="ti ti-device-floppy me-2"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('v3/libs/select2/select2.js') }}"></script>
@endpush

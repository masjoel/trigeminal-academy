@extends('layouts.dashboard')

@section('title', $title)

@push('style')
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
                                @include('backend.category.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <div class="card">
                    <form action="{{ route('category.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Nama Kategori</label>
                                        <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                                            name="kategori" value="{{ old('kategori', $category->kategori) }}"
                                            autocomplete="off" required>
                                        @error('kategori')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-4">
                                        <label><b>Status</b></label>
                                        <div class="d-flex mt-2">
                                            <label class="selectgroup-item me-5">
                                                <input type="radio" name="status" value="draft" class="form-check-input"
                                                    {{ $category->status == 'draft' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Draft</span>
                                            </label>
                                            <label class="selectgroup-item me-5">
                                                <input type="radio" name="status" value="publish"
                                                    class="form-check-input"
                                                    {{ $category->status == 'publish' ? 'checked' : '' }}>
                                                <span class="selectgroup-button">Publish</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="checkSize" type="submit" class="btn btn-primary btn-lg"><i
                                    class="ti ti-device-floppy me-2"></i> Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush

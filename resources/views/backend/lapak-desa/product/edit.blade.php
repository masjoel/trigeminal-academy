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
                                @include('backend.lapak-desa.product.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <div class="card">
                    <form id="fileForm" action="{{ route('lapak-desa-produk.update', $product) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-2">
                                                <label>Nama Barang</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name', $product->name) }}" autocomplete="off">
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label>Satuan</label>
                                                <select class="form-control select2" name="lapak_satuan_product_id">
                                                    <option value="0">-</option>
                                                    @foreach ($satuan as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('lapak_satuan_product_id', $product->lapak_satuan_product_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" data-height="90" name="description">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label>Harga Pokok</label>
                                                <input type="text"
                                                    class="form-control @error('budget') is-invalid @enderror"
                                                    name="budget" value="{{ old('budget', $product->budget) }}"
                                                    autocomplete="off">
                                                @error('budget')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label>Harga Jual</label>
                                                <input type="text"
                                                    class="form-control @error('price') is-invalid @enderror" name="price"
                                                    value="{{ old('price', $product->price) }}" autocomplete="off">
                                                @error('price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-2">
                                                <label>Stock</label>
                                                <input type="text"
                                                    class="form-control @error('stock') is-invalid @enderror" name="stock"
                                                    value="{{ old('stock', $product->stock) }}" autocomplete="off">
                                                @error('stock')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label>Stock selalu tersedia</label>
                                                <div class="d-flex mt-2">
                                                    <label class="selectgroup-item me-5">
                                                        <input type="radio" name="in_stock" value="1"
                                                            class="form-check-input"
                                                            {{ old('in_stock', $product->in_stock) == 1 ? 'checked' : '' }}>
                                                        <span class="selectgroup-button">Ya</span>
                                                    </label>
                                                    <label class="selectgroup-item me-5">
                                                        <input type="radio" name="in_stock" value="0"
                                                            class="form-check-input"
                                                            {{ old('in_stock', $product->in_stock) == 0 ? 'checked' : '' }}>
                                                        <span class="selectgroup-button">Tidak</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label>Status</label>
                                                <div class="d-flex mt-2">
                                                    <label class="selectgroup-item me-5">
                                                        <input type="radio" name="publish" value="1"
                                                            class="form-check-input"
                                                            {{ old('publish', $product->publish) == 1 ? 'checked' : '' }}>
                                                        <span class="selectgroup-button">Publish</span>
                                                    </label>
                                                    <label class="selectgroup-item me-5">
                                                        <input type="radio" name="publish" value="0"
                                                            class="form-check-input"
                                                            {{ old('publish', $product->publish) == 0 ? 'checked' : '' }}>
                                                        <span class="selectgroup-button">Draft</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label>Kategori</label>
                                        <select class="form-control select2" name="lapak_category_id">
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('lapak_category_id', $product->lapak_category_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Suplier</label>
                                        <select class="form-control select2" name="lapak_suplier_id">
                                            @foreach ($suplier as $suply)
                                                <option value="{{ $suply->id }}"
                                                    {{ old('lapak_suplier_id', $product->lapak_suplier_id) == $suply->id ? 'selected' : '' }}>
                                                    {{ $suply->nama }}
                                                    @if ($suply->nama_usaha != null)
                                                        ({{ $suply->nama_usaha }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Image</label>
                                        <div class="col-sm-12 col-md-9">
                                            <div class="d-block text-left">
                                                <img src="{{ $product->image_url == null ? asset('img/example-image.jpg') : Storage::url('thumb/' . $product->image_url) }}"
                                                    alt="" class="w-px-100 h-px-100 rounded"
                                                    id="uploadedAvatar" />
                                                <div class="button-wrapper">
                                                    <label for="image-upload" class="btn btn-sm btn-info my-2"
                                                        tabindex="0">
                                                        <span class="d-none d-sm-block">Upload Image</span>
                                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                                        <input type="file" name="image_url" id="image-upload"
                                                            class="account-file-input @error('image_url') is-invalid @enderror"
                                                            hidden />
                                                    </label>
                                                    <div class="account-image-reset d-none"></div>
                                                </div>
                                                @error('image_url')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-end">
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
    </script>
@endpush

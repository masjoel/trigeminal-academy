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
                                {{-- @include('backend.e-commerce.instruktur.breadcrumb') --}}
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <form id="fileForm" action="{{ route('konfirmasi.pembayaran') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group mb-4">
                                                <label>Kelas : {{ $order->orderItems[0]->product->name }}</label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Instruktur : {{ $order->orderItems[0]->product->instruktur->nama }}</label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Harga : Rp. {{ number_format($order->total_price) }}</label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Bukti Transfer</label>
                                                <div class="col-sm-12 col-md-9">
                                                    <div class="d-block text-left">
                                                        <img src="{{ $order->bukti_bayar == null ? asset('img/example-image.jpg') : Storage::url($order->bukti_bayar) }}"
                                                            alt="" class="w-px-100 h-px-100 rounded"
                                                            id="uploadedAvatar" />
                                                        <div class="button-wrapper">
                                                            <label for="image-upload" class="btn btn-sm btn-info my-2"
                                                                tabindex="0">
                                                                <span class="d-none d-sm-block">Upload Bukti transfer</span>
                                                                <i class="ti ti-upload d-block d-sm-none"></i>
                                                                <input type="file" name="bukti_bayar" id="image-upload"
                                                                    class="account-file-input @error('bukti_bayar') is-invalid @enderror"
                                                                    hidden />
                                                            </label>
                                                            <div class="account-image-reset d-none"></div>
                                                        </div>
                                                        @error('bukti_bayar')
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
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <button id="checkSize" type="submit" class="btn btn-primary btn-lg"><i
                                            class="ti ti-device-floppy me-2"></i> Upload</button>
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
    <script src="{{ asset('v3/assets/js/pages-account-settings-account.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('v3/libs/select2/select2.js') }}"></script>
    <script>
        $(document).on("change", "#image-upload", function(e) {
            e.preventDefault()
            let jmlFiles = $("#image-upload")[0].files
            let maxSize = 4
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

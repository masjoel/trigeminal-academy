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
                                @include('backend.e-commerce.order.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">

                <div class="card">
                    <form id="fileForm" action="{{ route('lapak-desa-order.update', $order) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>{{ $order->customer->nama }}</h4>
                                    <p class="mb-3">{{ $order->customer->alamat }}<br>{{ $order->customer->telpon }}</p>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between">
                                        <label class="text-nowrap me-2">Status Order</label>
                                        <select class="form-control select2" name="payment_status" id="select-status">
                                            <option value="1" {{ $order->payment_status == '1' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="2" {{ $order->payment_status == '2' ? 'selected' : '' }}>
                                                Diproses</option>
                                            <option value="3" {{ $order->payment_status == '3' ? 'selected' : '' }}>
                                                Dikirim</option>
                                            <option value="4" {{ $order->payment_status == '4' ? 'selected' : '' }}>
                                                Selesai</option>
                                            <option value="5" {{ $order->payment_status == '5' ? 'selected' : '' }}>
                                                Batal</option>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <label>Status Bayar : </label>
                                        @if ($order->bukti_bayar == null && $order->payment_status != 4)
                                            <span class="ms-2 badge bg-warning">Belum Bayar</span>
                                        @else
                                            <span class="ms-2 badge bg-success">Sudah Bayar</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-8">
                                    <div class="table-responsive mt-4">
                                        <table class="table-striped table table-md" id="main-table">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th class="text-right">Harga</th>
                                                    <th class="text-right">Jumlah</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cart-content">
                                                @php $grantotal = $total_budget = 0; @endphp
                                                @foreach ($detail as $item)
                                                    @php
                                                        $total_budget += $item->product->budget * $item->quantity;
                                                        $grantotal += $item->product->price * $item->quantity;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td class="text-right">{{ number_format($item->product->price) }}
                                                        </td>
                                                        <td class="text-right">{{ $item->quantity }}</td>
                                                        <td class="text-right">
                                                            {{ number_format($item->product->price * $item->quantity) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4" class="text-left">
                                                        <h5>TOTAL : Rp.{{ number_format($grantotal) }}</h5>
                                                        <input type="hidden" name="total_budget"
                                                            value="{{ $total_budget }}">
                                                        <input type="hidden" name="total_price"
                                                            value="{{ $grantotal }}">
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <div class="form-group my-2">
                                        <label><b>Bukti Pembayaran</b></label>
                                        <div class="d-block text-left">
                                            <img src="{{ $order->bukti_bayar == null ? asset('img/example-image.jpg') : Storage::url('thumb/' . $order->bukti_bayar) }}"
                                                alt="" class="w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                            <div class="button-wrapper">
                                                <label for="image-upload" class="btn btn-sm btn-info my-2" tabindex="0">
                                                    <span class="d-none d-sm-block">Upload Image</span>
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
                        <div class="card-footer text-end">
                            @if ($order->payment_status !== '4')
                                <a href="#" class="me-2 btn btn-lg btn-danger" id="delete-data"
                                    data-id="{{ $order->id }}" title="Hapus"><i class="fa fa-trash-alt me-2"></i>
                                    Hapus</a>
                            @endif
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
        $(document).on("click", "a#delete-data", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup('{{ url('') }}/lapak-desa-order/' + id, '{{ csrf_token() }}',
                '{{ url('') }}/lapak-desa-order');
        });
    </script>
@endpush

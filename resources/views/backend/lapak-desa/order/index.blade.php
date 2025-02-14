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
                                @include('backend.lapak-desa.order.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="card mb-6">
                    <div class="card-widget-separator-wrapper">
                        <div class="card-body card-widget-separator">
                            <div class="row gy-4 gy-sm-1">
                                <div class="col-sm-6 col-lg-3">
                                    <div
                                        class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                                        <div>
                                            <h5 class="mb-0">Rp. {{ number_format($tot_pending) }}</h5>
                                            <p class="mb-0">Pending</p>
                                        </div>
                                        <span class="avatar me-sm-6">
                                            <span class="avatar-initial bg-label-secondary rounded text-heading bg-danger">
                                                <i class="ti-26px ti ti-calendar-stats text-white"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <hr class="d-none d-sm-block d-lg-none me-6" />
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <div
                                        class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                                        <div>
                                            <h5 class="mb-0">Rp. {{ number_format($tot_batal) }}</h5>
                                            <p class="mb-0">Batal</p>
                                        </div>

                                        <span class="avatar p-2 me-lg-6">
                                            <span class="avatar-initial bg-label-secondary rounded"><i
                                                    class="ti-26px ti ti-alert-octagon text-danger"></i></span>
                                        </span>
                                    </div>
                                    <hr class="d-none d-sm-block d-lg-none" />
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div
                                        class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                                        <div>
                                            <h5 class="mb-0">Rp. {{ number_format($tot_finish) }}</h5>
                                            <p class="mb-0">Selesai</p>
                                        </div>

                                        <span class="avatar p-2 me-sm-6">
                                            <span class="avatar-initial bg-label-secondary rounded bg-primary"><i
                                                    class="ti-26px ti ti-checks text-white"></i></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-0">Rp. {{ number_format($tot_pending + $tot_finish) }}</h5>
                                            <p class="mb-0">Omzet</p>
                                        </div>
                                        <span class="avatar p-2">
                                            <span class="avatar-initial bg-label-secondary rounded bg-success"><i
                                                    class="ti-26px ti ti-wallet text-white"></i></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="alert alert-solid-info d-flex align-items-center" role="alert">
                            <span class="alert-icon rounded">
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            Rp. {{ number_format($tot_pending) }}
                            <br>Pesanan Baru
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="alert alert-solid-secondary d-flex align-items-center" role="alert">
                            <span class="alert-icon rounded">
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            Rp. {{ number_format($tot_batal) }}
                            <br>Pesanan Batal
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="alert alert-solid-success d-flex align-items-center" role="alert">
                            <span class="alert-icon rounded">
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            Rp. {{ number_format($tot_finish) }}
                            <br>Pesanan Selesai
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="alert alert-solid-primary d-flex align-items-center" role="alert">
                            <span class="alert-icon rounded">
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            Rp. {{ number_format($tot_pending + $tot_finish) }}
                            <br>OMZET
                        </div>
                    </div>
                </div> --}}

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header header-elements">
                                <div class="card-header-elements ms-auto">
                                    <form method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Cari..."
                                                aria-describedby="button-addon2" />
                                            <button class="btn btn-primary" type="submit" id="button-addon2"><i
                                                    class="ti ti-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Invoice</th>
                                            <th>Pelanggan</th>
                                            <th>No. HP</th>
                                            <th class="text-right">Total</th>
                                            <th class="text-nowrap">Bukti bayar</th>
                                            <th>Proses</th>
                                            @can(['lapak-desa-order.edit', 'lapak-desa-order.delete'])
                                                <th class="text-center" width="120">Action</th>
                                            @endcan
                                        </tr>
                                        @php $i=$nomor; @endphp
                                        @foreach ($products as $index => $item)
                                            <tr>
                                                <td width="50">{{ $i++ }}</td>
                                                <td class="text-nowrap">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                                <td>{{ $item->number }}</td>
                                                <td>{{ $item->customer->nama }}</td>
                                                <td class="text-nowrap">{{ $item->customer->telpon }}
                                                    @if (Str::length($item->customer->telpon) > 10 && Str::length($item->customer->telpon) < 13)
                                                        <a href="http://wa.me/62{{ $item->customer->telpon }}"
                                                            class="ml-2 btn btn-sm btn-success text-white"
                                                            style="border-radius: 50px" title="Whatsapp" target="_blank"><i
                                                                class="fa fa-phone"></i></a>
                                                    @endif
                                                </td>
                                                <td class="text-right" width="100">
                                                    {{ number_format($item->total_price) }}</td>
                                                <td class="text-nowrap text-center" width="150">
                                                    @if ($item->bukti_bayar != null)
                                                        <a href="#" id="show-image" data-id="{{ $item->id }}"
                                                            data-image="{{ $item->bukti_bayar }}" target="_blank">
                                                            <i class="fa fa-image text-danger fa-2x"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="text-nowrap text-center" width="120">
                                                    @switch($item->payment_status)
                                                        @case(1)
                                                            <span class="badge bg-danger">pending</span>
                                                        @break

                                                        @case(2)
                                                            <span class="badge bg-info">diproses</span>
                                                        @break

                                                        @case(3)
                                                            <span class="badge bg-primary">dikirim</span>
                                                        @break

                                                        @case(4)
                                                            <span class="badge bg-success">selesai</span>
                                                        @break

                                                        @case(5)
                                                            <span class="badge bg-dark">batal</span>
                                                        @break

                                                        @default
                                                    @endswitch
                                                </td>
                                                @can(['lapak-desa-order.edit', 'lapak-desa-order.delete'])
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            @can('lapak-desa-order.edit')
                                                                <a href="{{ route('lapak-desa-order.edit', $item->id) }}"
                                                                    class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                    id="edit-data" title="Detil Order"><i
                                                                        class="fas fa-edit me-2"></i>
                                                                    Detil</a>
                                                            @endcan
                                                            @can('lapak-desa-order.delete')
                                                                <a href="#" class="ml-2 btn btn-sm btn-danger"
                                                                    id="delete-data" data-id="{{ $item->id }}" title="Hapus"
                                                                    data-toggle="tooltip"><i class="fa fa-trash-alt"></i></a>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="mt-5">
                                    {{ $products->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="view-modal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="tampil-image"></div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let asset = '{{ Storage::url('') }}';
        $(document).on("click", "a#show-image", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let image = $(this).data('image');
            $('#tampil-image').html('<img src="' + asset + image + '" class="img-fluid">');
            $('#view-modal').modal('show');
        });

        $(document).on("click", "a#delete-data", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup('{{ url('') }}/lapak-desa-order/' + id, '{{ csrf_token() }}', '', '',
                '{{ url('') }}/lapak-desa-order');
        });
    </script>
@endpush

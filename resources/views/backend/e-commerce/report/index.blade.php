@extends('layouts.dashboard')

@section('title', $title)

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="card mb-4">
                <div class="card-header header-elements">
                    <h3 class="mb-0 me-2">Laporan {{ $title }}</h3>
                    <div class="card-header-elements ms-auto">
                        <span class="text text-muted d-flex">
                            <small>
                                @include('backend.e-commerce.report.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">
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
                                <div class="table-responsive table-sm">
                                    <table class="table-sm table">
                                        <tr class="bg-light">
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Nama Barang</th>
                                            <th class="text-right">Qty</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">Jumlah</th>
                                        </tr>
                                        @php
                                            $currentDate = null;
                                            $currentTanggalJam = null;
                                            $total = 0;
                                        @endphp
                                        @foreach ($products as $index => $item)
                                            <tr>
                                                @if ($currentTanggalJam != $item->tanggal_jam)
                                                    @php
                                                        if ($currentTanggalJam !== null) {
                                                            echo '<tr class="bg-light"><td colspan="5" class="text-right"><strong>Total :</strong></td><td class="text-right"><strong>' .
                                                                number_format($total, 0, ',', '.') .
                                                                '</strong></td></tr>';
                                                            $total = 0;
                                                        }
                                                        // $currentDate = $item->tanggal;
                                                        $currentTanggalJam = $item->tanggal_jam;
                                                    @endphp
                                                    <td class="text-nowrap" width="150">
                                                        @if ($currentDate != $item->tanggal)
                                                            {{ hari($item->tanggal) . ', ' . tgldmY($item->tanggal) }}
                                                            @php
                                                                $currentDate = $item->tanggal;
                                                            @endphp
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ substr($item->tanggal_jam, 11) }}
                                                    </td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                <td>{{ $item->name }}</td>
                                                <td class="text-right">{{ $item->qty }}</td>
                                                <td class="text-right">{{ number_format($item->price) }}</td>
                                                <td class="text-right">{{ number_format($item->jumlah) }}</td>
                                            </tr>
                                            @php
                                                $total += $item->jumlah;
                                            @endphp
                                            @if ($loop->last)
                                                <tr class="bg-light">
                                                    <td colspan="5" class="text-right"><strong>Total :</strong></td>
                                                    <td class="text-right">
                                                        <strong>{{ number_format($total, 0, ',', '.') }}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        {{-- @if (count($products) > 0)
                                            <tr>
                                                <td colspan="5" class="text-right"><strong>Total :</strong></td>
                                                <td class="text-right">
                                                    <strong>{{ number_format($total, 0, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                        @endif --}}
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>

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
            showDeletePopup('{{ url('') }}/order/' + id, '{{ csrf_token() }}',
                '{{ url('') }}/order');
        });

        function showDeletePopup(url, token, reload) {
            swal({
                    title: 'Hapus data',
                    text: 'Yakin data akan dihapus?',
                    icon: 'error',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                                url: url,
                                "headers": {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                type: "DELETE"
                            })
                            .done(function(data) {
                                if (data.status == 'success') {
                                    swal('Data telah dihapus', {
                                        icon: 'success',
                                    });
                                    setTimeout(function() {
                                        swal.close()
                                        window.location.replace(reload);
                                    }, 1000);
                                } else {
                                    swal("Error!", data.message, "error");
                                }
                            })
                            .fail(function(data) {
                                swal("Oops...!", "Terjadi kesalahan pada server!", "error");
                            });
                    }
                });
        }
    </script>
@endpush

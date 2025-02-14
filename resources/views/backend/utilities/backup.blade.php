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
                                <nav>
                                    <ol class="breadcrumb breadcrumb-style1">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('backup-data.index') }}">{{ $title }}</a>
                                        </li>
                                    </ol>
                                </nav>
                            </small>
                        </span>
                    </div>
                </div>
            </div>

            <div class="section-body">
                {{-- @include('backend.utilities.menu-utility') --}}
                <div class="card">
                    <div class="card-header">
                        <div class="section-header-button">
                            <a href="#" type="button" id="backup-create" class="btn btn-info float-left"
                                title="Backup Data"><i class="fa fa-copy me-2"></i> {{ $title }} </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="d-none">id</th>
                                        <th>Nama</th>
                                        <th class="text-right">Size</th>
                                        <th>Tanggal </th>
                                        <th>Jam </th>
                                        <th>Opr </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recs as $r)
                                        <tr>
                                            <td class="d-none">{{ $r->id }}</td>
                                            <td>{{ $r->nama }}<a href="{{ route('download-db', $r->nama) }}"
                                                    target="_blank" class="ms-4 badge bg-success text-white">Download</a> <a
                                                    class="ms-1 badge bg-warning text-white" href="#" type="button"
                                                    id="restore" data-id="{{ $r->nama }}" title="">Restore</a>
                                            </td>
                                            <td class="text-right">{{ $r->ket . ' MB' }}</td>
                                            <td>{{ $r->created_at->format('d-m-Y') }}</td>
                                            <td>{{ $r->created_at->format('H:i:s') }}</td>
                                            <td>{{ $r->username }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $recs->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    {{-- <script src="{{ asset('library/sweetalert2/sweetalert2.min.js') }}"></script> --}}
    <script type="text/javascript">
        // --- Fungsi ---
        $(document).on('click', 'a#backup-create', function(e) {
            e.preventDefault();
            $.ajax({
                url: BASE_URL + "/backup-data/create",
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function() {
                    showLoading('Backup Data', 'proses sedang berlangsung...');
                },
                success: function(data, textStatus, jqXHR) {
                    Swal.close();
                    showAlertOnSubmit(data, '', '', BASE_URL + '/backup-data');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let pesan = ''
                    $.each(jqXHR.responseJSON.errors, function(item, data) {
                        pesan += data[0]
                    })
                    showWarningAlert(pesan)
                },
            });
        })
        $(document).on('click', 'a#restore', function(e) {
            e.preventDefault();
            let nama = $(this).data('id');
            $.ajax({
                url: BASE_URL + "/restore-db/" + nama,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function() {
                    showLoading('Restore Data', 'proses sedang berlangsung...');
                },
                success: function(data, textStatus, jqXHR) {
                    Swal.close();
                    showAlertOnSubmit(data, '', '', BASE_URL + '/restore-data');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let pesan = ''
                    $.each(jqXHR.responseJSON.errors, function(item, data) {
                        pesan += data[0]
                    })
                    showWarningAlert(pesan)
                },
            });
        })

        // $("#main-table").addClass('nowrap').DataTable({
        //     "destroy": true,
        //     "dom": 'ftip',
        //     "order": [0, 'DESC'],
        //     "pageLength": 50,
        //     "language": {
        //         "decimal": "",
        //         "emptyTable": "Data tidak ditemukan",
        //         "info": "Data _START_ s/d _END_ dari _TOTAL_",
        //         "infoEmpty": "Tidak ada data",
        //         "infoFiltered": "(tersaring dari _MAX_)",
        //         "infoPostFix": "",
        //         "thousands": ",",
        //         "lengthMenu": "_MENU_  data per hlm",
        //         "search": "Cari:",
        //         "zeroRecords": "Tidak ada data ditemukan",
        //         "aria": {
        //             "sortAscending": ": aktifkan untuk mengurutkan naik",
        //             "sortDescending": ": aktifkan untuk mengurutkan turun"
        //         }
        //     }
        // })
    </script>
@endpush

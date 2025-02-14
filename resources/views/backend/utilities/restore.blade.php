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
                                            <a href="{{ route('restore-data') }}">{{ $title }}</a>
                                        </li>
                                    </ol>
                                </nav>
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <form id="backup-upload" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <input type="file" name="file_restore" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-primary waves-effect waves-light">Restore Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="main-table" class="table table-striped">
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
                                                    <td>{{ $r->nama }}</td>
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
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
        $('form#backup-upload').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData(this);

            $.ajax({
                type: 'post',
                url: BASE_URL + "/upload-db",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    showLoading('Restore Data', 'proses sedang berlangsung...');
                },
                success: function(data) {
                    Swal.close();
                    showAlertOnSubmit(data, '', '', BASE_URL + '/restore-data');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let pesan = ''
                    $.each(jqXHR.responseJSON.errors, function(item, data) {
                        pesan += data[0]
                    })
                    showWarningAlert(pesan)
                }
            })
        });
    </script>
@endpush

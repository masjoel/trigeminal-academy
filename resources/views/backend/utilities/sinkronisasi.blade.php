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
                                            <a href="{{ route('sinkronisasi') }}">{{ $title }}</a>
                                        </li>
                                    </ol>
                                </nav>
                            </small>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-inline" action="{{ route('sinkronisasi-save') }}" method="POST">
                        @csrf
                        <div class="row mb-5">
                            <div class="col-md-4 col-lg-4  mb-2">
                                <div class="form-group">
                                    <label>Endpoint Server</label>
                                    <input type="text" class="form-control" name="endpoint"
                                        value="{{ klien('endpoint_kecamatan') }}">
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-5  mb-0">
                                <div class="form-group">
                                    <label>Api Key</label>
                                    <input type="text" class="form-control" name="apikey"
                                        value="{{ klien('apikey_kecamatan')  }}">
                                </div>
                            </div>
                            <div class="col-md-auto mb-2">
                                <label></label>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-success"><i
                                            class="ti ti-device-floppy me-2"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header header-elements">
                        
                        <div class="card-header-elements ms-auto">
                            @if (total_sync() > 0 && total_sync() < 500)
                                <a href="#" type="button" id="sync" data-url="all-data" class="btn btn-primary"
                                    title="Sync Data"><i class="fa fa-refresh me-2"></i> {{ $title }} </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Last Sync </th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tabel as $r)
                                        <tr>
                                            <td>{{ $r['label'] }}</td>
                                            <td>{{ $r['lastSync'] == null ? '-' : tgljam($r['lastSync']) }}</td>
                                            <td>
                                                @if ($r['record'] > 0)
                                                    <a href="#" id="sync" data-url="{{ $r['linkUrl'] }}"
                                                        class="btn btn-sm btn-success"><i class="fas fa-refresh"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5">
                            {{ $tabel->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).on('click', 'a#sync', function(e) {
            e.preventDefault();
            $.ajax({
                url: BASE_URL + "/sync/" + $(this).data('url'),
                type: 'GET',
                beforeSend: function() {
                    showLoading('Sinkronisasi', 'proses sedang berlangsung...');
                },
                success: function(data, textStatus, jqXHR) {
                    Swal.close();
                    Swal.fire({
                        title: "Sukses",
                        text: "Sinkronisasi data telah berhasil",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: true
                    })
                    window.location.replace(BASE_URL + '/sinkronisasi');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let pesan = 'Sinkronisasi data gagal'
                    showWarningAlert(pesan)
                },
            });
        })
    </script>
@endpush
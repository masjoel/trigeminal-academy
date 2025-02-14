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
                                @include('backend.admin-member.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header header-elements">
                                {{-- @can('admin-member.create') --}}
                                {{-- <a href="{{ route('admin-member.create') }}" class="btn btn-primary me-2"><i
                                        class="fas fa-plus me-2"></i>
                                    {{ $title }}</a> --}}
                                {{-- @endcan --}}
                                <div class="card-header-elements ms-auto">
                                    <form method="GET" action="{{ route('admin-member.index') }}">
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
                                            <th scope="col">#</th>
                                            <th scope="col">Pict</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">Pendidikan</th>
                                            <th scope="col">Pekerjaan</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">HP/Telpon</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Status</th>
                                            {{-- @can(['admin-member.edit', 'admin-member.delete']) --}}
                                            <th class="text-center" scope="col" width="120">Action</th>
                                            {{-- @endcan --}}
                                        </tr>
                                        @foreach ($anggota as $index => $item)
                                            <tr>
                                                <td width="50" nowrap>{{ $index + $anggota->firstItem() }}
                                                    @if ($item->feature == 'y')
                                                        <i class="fa fa-star" style="color:gold"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->image !== null)
                                                        <img class="rounded-circle mr-3" width="50" height="50"
                                                            src="{{ Storage::url('thumb/' . $item->image) }}"
                                                            alt="avatar">
                                                    @else
                                                        <img class="rounded-circle mr-3" width="50"
                                                            src="{{ asset('img/example-image-50.jpg') }}" alt="avatar">
                                                    @endif
                                                </td>
                                                <td nowrap>{{ $item->nama }}</td>
                                                <td nowrap>{{ ucfirst($item->gender) }}</td>
                                                <td>{{ $item->pendidikan }}</td>
                                                <td>{{ $item->pekerjaan }}</td>
                                                <td>{{ ellipsis($item->alamat) }}</td>
                                                <td>{{ $item->telpon }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    @if (strtolower($item->status) == 'aktif')
                                                        <span class="badge bg-success">Aktif</span>
                                                    @elseif (strtolower($item->status) == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @else
                                                        <span class="badge bg-danger">Non Aktif</span>
                                                    @endif
                                                </td>
                                                {{-- @can(['admin-member.edit', 'admin-member.delete']) --}}
                                                <td>
                                                    <div class="d-flex justify-content-end text-nowrap">
                                                        {{-- <a href="#" class="btn btn-sm btn-secondary me-1"
                                                            id="qrcode" data-id="{{ $item->id }}"><i
                                                                class="fas fa-qrcode me-2"></i> QR code</a> --}}
                                                        {{-- @can('admin-member.edit') --}}
                                                        <a href="{{ route('admin-member.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                            id="edit-data" title="Edit"><i class="fas fa-edit me-2"></i>
                                                            Edit</a>
                                                        {{-- @endcan
                                                            @can('admin-member.delete') --}}
                                                        <a href="#" class="ml-2 btn btn-sm btn-danger"
                                                            id="delete-data" data-id="{{ $item->id }}" title="Hapus"
                                                            data-toggle="tooltip"><i class="fa fa-trash-alt"></i></a>
                                                        {{-- @endcan --}}
                                                    </div>
                                                </td>
                                                {{-- @endcan --}}
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="mt-5">
                                    {{ $anggota->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade modal-utama" id="modal-qrcode" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-3 text-muted">
                        Scan QR-Code untuk melihat detail anggota
                    </p>
                    <img id="qr-code-img" class="card-img-top text-center w-50" alt="QR Code">
                    <div class="form-group" id="show-profil">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).on("click", "a#qrcode", function(e) {
            e.preventDefault();
            $('h4.modal-title').text('QR Code');
            $('#modal-qrcode').modal('show');
            let id = $(this).data('id');
            $.ajax({
                url: BASE_URL + '/admin-member/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    $('#qr-code-img').attr('src', 'data:image/png;base64,' + data.qrCodeBase64);
                    $('#show-profil').html('<br>' + data.nama + '<br>NIK: ' + data.nik);
                }
            })
        });
        $(document).on("click", "a#delete-data", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup(BASE_URL + '/admin-member/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/admin-member');
        });
    </script>
@endpush

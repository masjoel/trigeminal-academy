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
                                @include('backend.student.breadcrumb')
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
                                {{-- @can('student.create')
                                    <a href="{{ route('student.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus me-2"></i>
                                        {{ $title }}</a>
                                @endcan --}}
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
                                            <th scope="col">#</th>
                                            <th scope="col">Pict</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Telp.</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-center">QR Code</th>
                                            @can(['student.edit', 'student.delete'])
                                                <th class="text-center" width="120">Action</th>
                                            @endcan
                                        </tr>
                                        @foreach ($student as $index => $item)
                                            <tr>
                                                <td width="50">{{ $index + $student->firstItem() }}</td>
                                                <td width="50">
                                                    @if ($item->photo)
                                                        <figure class="avatar avatar-md mr-2 bg-transparent">
                                                            <img src="{{ Storage::url($item->photo) }}"
                                                                class="direct-chat-img">
                                                        </figure>
                                                    @else
                                                        <i class="far fa-image fa-2x"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->telpon }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>
                                                    @if ($item->approval == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($item->approval == 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" id="qrcode"
                                                        data-id="{{ $item->id }}"><i class="fas fa-qrcode me-2"></i></a>
                                                </td>
                                                @can(['student.edit', 'student.delete'])
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            @can('student.edit')
                                                                <a href="{{ route('student.edit', $item->id) }}"
                                                                    class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                    id="edit-data" title="Edit"><i class="fas fa-edit me-2"></i>
                                                                    Edit</a>
                                                            @endcan
                                                            @can('student.delete')
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
                                    {{ $student->withQueryString()->links() }}
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
                    {{-- <p class="mb-3 text-muted">
                        Scan QR-Code untuk melihat detail anggota
                    </p> --}}
                    <img id="qr-code-img" class="card-img-top text-center w-50" alt="QR Code">
                    <div class="form-group text-start" id="show-profil">

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
                url: BASE_URL + '/student/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    $('#qr-code-img').attr('src', 'data:image/png;base64,' + data.qrCodeBase64);
                    $('#show-profil').html('<br>' + data.name + '<br>Username: ' + data.username + '<br>Email: ' + data.email + '<br>Phone: ' + data.phone);
                }
            })
        });
        $(document).on("click", "a#delete-data", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup(BASE_URL + '/student/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/student');
        });
    </script>
@endpush

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
                                @include('backend.e-commerce.satuan.breadcrumb')
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
                                @can('lapak-desa-satuan.create')
                                    <a href="{{ route('lapak-desa-satuan.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus me-2"></i>
                                        {{ $title }}</a>
                                @endcan
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
                                            <th width="50">#</th>
                                            <th scope="col">Satuan</th>
                                            <th scope="col">Deskripsi</th>
                                            @can(['lapak-desa-satuan.edit', 'lapak-desa-satuan.delete'])
                                                <th class="text-center" scope="col" width="120">Action</th>
                                            @endcan
                                        </tr>
                                        @foreach ($satuanProduk as $index => $item)
                                            <tr>
                                                <td width="50">{{ $index + $satuanProduk->firstItem() }}</td>
                                                <td nowrap>{{ $item->name }}</td>
                                                <td nowrap>{{ $item->description }}</td>

                                                @can(['lapak-desa-satuan.edit', 'lapak-desa-satuan.delete'])
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            @can('lapak-desa-satuan.edit')
                                                                <a href="{{ route('lapak-desa-satuan.edit', $item->id) }}"
                                                                    class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                    id="edit-data" title="Edit"><i class="fas fa-edit me-2"></i>
                                                                    Edit</a>
                                                            @endcan
                                                            @can('lapak-desa-satuan.delete')
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
                                    {{ $satuanProduk->withQueryString()->links() }}
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
    <script>
        $(document).on("click", "a#delete-data", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup(BASE_URL + '/lapak-desa-satuan/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/lapak-desa-satuan');
        });
    </script>
@endpush

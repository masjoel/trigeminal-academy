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
                                @include('backend.lapak-desa.customer.breadcrumb')
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
                                {{-- @can('lapak-desa-kategori.create')
                                    <a href="{{ route('lapak-desa-kategori.create') }}" class="btn btn-primary"><i
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
                                <div class="float-right">
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Telp.</th>
                                                <th scope="col">Alamat</th>
                                                <th class="text-right">Order</th>
                                                <th class="text-right">Total Item</th>
                                                <th class="text-right">Total Nilai</th>
                                                @can(['lapak-desa-customer.edit', 'lapak-desa-customer.delete'])
                                                    <th class="text-center" scope="col" width="120">Action</th>
                                                @endcan
                                            </tr>
                                            @php $i=$nomor; @endphp
                                            @foreach ($customers as $index => $item)
                                                <tr>
                                                    <td width="50">{{ $index + $customers->firstItem() }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->telpon }}</td>
                                                    <td>{{ $item->alamat }}</td>
                                                    <td class="text-right">{{ $item->total_order }}x</td>
                                                    <td class="text-right">{{ number_format($item->total_item) }}</td>
                                                    <td class="text-right">{{ number_format($item->total_price) }}</td>
                                                    @can(['lapak-desa-customer.edit', 'lapak-desa-customer.delete'])
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                @can('lapak-desa-customer.edit')
                                                                    <a href="{{ route('lapak-desa-customer.edit', $item->id) }}"
                                                                        class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                        id="edit-data" title="Edit"><i
                                                                            class="fas fa-edit me-2"></i>
                                                                        Edit</a>
                                                                @endcan
                                                                @can('lapak-desa-customer.delete')
                                                                    <a href="#" class="ml-2 btn btn-sm btn-danger"
                                                                        id="delete-data" data-id="{{ $item->id }}"
                                                                        title="Hapus" data-toggle="tooltip"><i
                                                                            class="fa fa-trash-alt"></i></a>
                                                                @endcan
                                                            </div>
                                                        </td>
                                                    @endcan
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="mt-5">
                                        {{ $customers->withQueryString()->links() }}
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
            showDeletePopup(BASE_URL + '/lapak-desa-customer/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/lapak-desa-customer');
        });
    </script>
@endpush

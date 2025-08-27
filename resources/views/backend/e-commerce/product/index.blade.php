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
                                @include('backend.e-commerce.product.breadcrumb')
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
                                @can('course.create')
                                    <a href="{{ route('course.create') }}" class="btn btn-primary"><i
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
                                            <th scope="col">#</th>
                                            <th scope="col">Pict</th>
                                            <th scope="col">Nama product</th>
                                            <th class="text-right" scope="col">Harga</th>
                                            <th class="text-right" scope="col">Disc.</th>
                                            <th scope="col">Instruktur</th>
                                            <th scope="col">Peserta</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Level</th>
                                            <th scope="col">Status</th>
                                            @can(['course.edit', 'course.delete'])
                                                <th class="text-center" scope="col" width="120">Action</th>
                                            @endcan
                                        </tr>
                                        @php $i=$nomor; @endphp
                                        @foreach ($products as $index => $item)
                                            <tr>
                                                <td width="50">{{ $i++ }}</td>
                                                <td width="50">
                                                    @if ($item->image_url)
                                                        <figure class="avatar avatar-md mr-2 bg-transparent">
                                                            <img src="{{ Storage::url('thumb/' . $item->image_url) }}"
                                                                class="direct-chat-img">
                                                        </figure>
                                                    @else
                                                        <i class="far fa-image fa-2x"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td class="text-right" width="100">{{ number_format($item->price) }}</td>
                                                <td class="text-right" width="100">{{ number_format($item->discount) }}%
                                                </td>
                                                <td>{{ $item->instruktur == null ? '' : $item->instruktur->nama }}</td>
                                                <td class="text-end text-nowrap">{{ $item->jumlahpeserta }}
                                                    @if ($item->jumlahpeserta > 0)
                                                        <a href="{{ route('lihat-peserta', $item->id) }}" class="ms-2"
                                                            title="Lihat data Peserta"><i
                                                                class="fas fa-eye text-warning"></i></a>
                                                        <a href="#" id="export-peserta" data-id="{{ $item->id }}"
                                                            class="ms-2" title="Download email Peserta"><i
                                                                class="fas fa-download text-success"></i></a>
                                                    @endif
                                                </td>
                                                <td>{{ $item->productCategory->name }}</td>
                                                <td>{{ ucwords($item->level) }}</td>
                                                <td class="text-center" width="120"><span
                                                        class="badge bg-{{ $item->publish == 0 ? 'secondary' : 'primary' }}">{{ $item->publish == 0 ? 'Draft' : 'Published' }}</span>
                                                </td>
                                                @can(['course.edit', 'course.delete'])
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            @can('course.edit')
                                                                <a href="{{ route('course.show', $item->id) }}"
                                                                    class="btn btn-sm btn-warning waves-effect waves-light mx-1"
                                                                    id="detil-data" title="Detil"><i class="fas fa-eye me-2"></i>
                                                                    Detil</a>
                                                                <a href="{{ route('course.edit', $item->id) }}"
                                                                    class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                    id="edit-data" title="Edit"><i class="fas fa-edit me-2"></i>
                                                                    Edit</a>
                                                            @endcan
                                                            @can('course.delete')
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
@endsection

@push('scripts')
    <script>
        $(document).on("click", "a#delete-data", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup(BASE_URL + '/course/' + id, '{{ csrf_token() }}',
                BASE_URL + '/course');
        });
        // buatkan fungsi untuk export data peserta
        $(document).on("click", "a#export-peserta", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            window.open(BASE_URL + '/export-peserta/' + id, '_blank');
        })
    </script>
@endpush

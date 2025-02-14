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
                                @include('backend.artikel.breadcrumb')
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
                                @can('artikel.create')
                                    <a href="{{ route('artikel.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus me-2"></i>
                                        {{ $title }}</a>
                                @endcan
                                <div class="card-header-elements ms-auto">
                                    <form method="GET" action="{{ route('artikel.index') }}">
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
                                            <th scope="col">Title</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Status</th>
                                            @can(['artikel.edit', 'artikel.delete'])
                                                <th class="text-center" scope="col" width="120">Action</th>
                                            @endcan
                                        </tr>
                                        @foreach ($artikel as $index => $item)
                                            <tr>
                                                <td width="50" nowrap>{{ $index + $artikel->firstItem() }}
                                                    @if ($item->feature == '1')
                                                        <i class="fa fa-star" style="color:gold"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->foto_unggulan !== null)
                                                        <img class="rounded-circle mr-3" width="50" height="50"
                                                            src="{{ Storage::url('thumb/' . $item->foto_unggulan) }}"
                                                            alt="avatar">
                                                    @else
                                                        <img class="rounded-circle mr-3" width="50"
                                                            src="{{ asset('img/example-image-50.jpg') }}" alt="avatar">
                                                    @endif
                                                </td>
                                                <td nowrap>{{ $item->title }}</td>
                                                <td><span class="badge bg-info">{{ $item->category->kategori }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $item->status == 'published' ? 'success' : 'danger' }}">{{ $item->status }}</span>
                                                </td>
                                                @can(['artikel.edit', 'artikel.delete'])
                                                    <td>
                                                        <div class="d-flex justify-content-end">
                                                            @can('artikel.edit')
                                                                <a href="{{ route('artikel.edit', $item->slug) }}"
                                                                    class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                    id="edit-data" title="Edit"><i class="fas fa-edit me-2"></i>
                                                                    Edit</a>
                                                            @endcan
                                                            @can('artikel.delete')
                                                                <a href="#" class="ml-2 btn btn-sm btn-danger"
                                                                    id="delete-data" data-id="{{ $item->slug }}" title="Hapus"
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
                                    {{ $artikel->withQueryString()->links() }}
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
            showDeletePopup(BASE_URL + '/artikel/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/artikel');
        });
    </script>
@endpush

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
                                @include('backend.galeri-foto.breadcrumb')
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
                                @can('galeri-foto.create')
                                    <a href="{{ route('galeri-foto.create') }}" class="btn btn-primary"><i
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
                                <div class="row">
                                    @foreach ($artikel as $item)
                                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body pb-0" id="show-data" data-id="{{ $item->id }}">
                                                    @if ($item->foto_unggulan !== null)
                                                        <img class="img-fluid"
                                                            src="{{ Storage::url('thumb/' . $item->foto_unggulan) }}"
                                                            alt="foto">
                                                    @else
                                                        <img class="img-fluid" src="{{ asset('img/example-image-50.jpg') }}"
                                                            alt="foto">
                                                    @endif
                                                </div>
                                                <h6 class="px-2">{{ $item->title }}</h6>
                                                <span
                                                    class="mx-5 mb-2 badge bg-{{ $item->status == 'published' ? 'success' : 'danger' }}">{{ $item->status }}</span>
                                                <div class="card-footer pt-0 mt-0">
                                                    <div class="modal-footer justify-content-between p-0">
                                                        @can('galeri-foto.edit')
                                                            <a href="{{ route('galeri-foto.edit', $item->slug) }}"
                                                                class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                id="edit-data" title="Edit"><i class="fas fa-edit me-2"></i>
                                                                Edit</a>
                                                        @endcan
                                                        @can('galeri-foto.delete')
                                                            <a href="#" class="ml-2 btn btn-sm btn-danger"
                                                                id="delete-data" data-id="{{ $item->slug }}" title="Hapus"
                                                                data-toggle="tooltip"><i class="fa fa-trash-alt"></i></a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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

    <!-- Modal -->

    {{-- Modal Filter --}}
@endsection

@push('scripts')
    <script>
        $(document).on("click", "a#delete-data", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup(BASE_URL + '/galeri-foto/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/galeri-foto');
        });
    </script>
@endpush

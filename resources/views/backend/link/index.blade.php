@extends('layouts.dashboard')

@section('title', 'All ' . $title)

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
                                @include('backend.link.breadcrumb')
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
                                <a href="{{ route('profil-bisnis.index') }}" class="btn btn-warning mb-1 me-1"><i
                                        class="fas fa-arrow-left me-2"></i>Profil Bisnis</a>
                                <a href="{{ route('link.create') }}" class="btn btn-primary mb-1 me-1"><i
                                        class="fas fa-plus me-2"></i>{{ $title }}</a>
                                <div class="card-header-elements ms-auto">
                                    <form method="GET" action="{{ route('link.index') }}">
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
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="50">No.</th>
                                            <th width="1" nowrap>Tipe</th>
                                            <th>Link</th>
                                            <th>URL</th>
                                            <th class="text-center" width="150">
                                                @can('seting-profil-bisnis.edit')
                                                    Action
                                                @elsecan('seting-profil-bisnis.delete')
                                                    Action
                                                @endcan
                                            </th>
                                        </tr>
                                        @foreach ($link as $index => $r)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td nowrap>
                                                    @if ($r->tipe == 'medsos')
                                                        Media Sosial
                                                    @else
                                                        Link Eksternal
                                                    @endif
                                                </td>
                                                <td>
                                                    <i class="{{ $r->icon }} fa-fw"></i>&nbsp;&nbsp;
                                                    {{ $r->keterangan }}
                                                </td>
                                                <td>
                                                    {{ $r->url_ext }}
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex justify-content-center">
                                                        @can('seting-profil-bisnis.edit')
                                                            <a href='{{ route('link.edit', $r->id) }}'
                                                                class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                id="edit-data" title="Edit"><i class="fas fa-edit me-2"></i>
                                                                Edit</a>
                                                        @endcan
                                                        @can('seting-profil-bisnis.edit')
                                                            <button class="ml-2 btn btn-sm btn-danger btn-icon confirm-delete"
                                                                id="delete" data-id="{{ $r->id }}" title="Hapus"
                                                                data-toggle="tooltip">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="mt-5">
                                    {{ $link->withQueryString()->links() }}
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
        $(document).on("click", "button#delete", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup(BASE_URL + '/link/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/link');
        });
    </script>
@endpush

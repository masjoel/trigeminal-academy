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
                                @include('backend.banner.breadcrumb')
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
                                @can('slide-banner.create')
                                    <a href="{{ route('slidebanner.create') }}" class="btn btn-primary"><i
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
                                            <th scope="col">Image</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Status</th>
                                            @can(['slide-banner.edit', 'slide-banner.delete'])
                                                <th class="text-center" scope="col" width="120">Action</th>
                                            @endcan
                                        </tr>
                                        @foreach ($slidebanners as $index => $item)
                                            <tr>
                                                <td width="50">{{ $index + $slidebanners->firstItem() }}</td>
                                                <td><img class="rounded-circle mr-3" width="50"
                                                        src="{{ Storage::url('thumb/' . $item->image) }}" alt="avatar">
                                                </td>
                                                <td nowrap>{{ $item->title }}</td>
                                                <td>
                                                    <span
                                                        class="badge rounded-pill bg-{{ $item->status == 'publish' ? 'success' : 'danger' }}">{{ $item->status }}</span>
                                                </td>

                                                @can(['slide-banner.edit', 'slide-banner.delete'])
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            @can('slide-banner.edit')
                                                                <a href="{{ route('slidebanner.edit', $item->slug) }}"
                                                                    class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                    id="edit-data" title="Edit"><i class="fas fa-edit me-2"></i>
                                                                    Edit</a>
                                                            @endcan
                                                            @can('slide-banner.delete')
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
                                    {{ $slidebanners->withQueryString()->links() }}
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
            showDeletePopup(BASE_URL + '/slidebanner/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/slidebanner');
        });
    </script>
@endpush

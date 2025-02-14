@extends('layouts.dashboard')

@section('title', 'All ' . $title . 's')

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
                                @include('backend.roles.breadcrumb')
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
                        {{-- @include('backend.utilities.menu-utility') --}}
                        <div class="card">
                            <div class="card-header header-elements">
                                @if (Auth::user()->username == 'admin' || Auth::user()->username == 'superadmin')
                                    <a href="{{ route('roles.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus me-2"></i>
                                        {{ $title }}</a>
                                @endif
                                <div class="card-header-elements ms-auto">
                                    <form method="GET" action="{{ route('roles.index') }}">
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
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table" id="main-table">
                                        <tr>

                                            <th>Name</th>
                                            <th>Created At</th>
                                            @if (Auth::user()->username == 'admin' || Auth::user()->username == 'superadmin')
                                                <th width="150">Action</th>
                                            @endif
                                        </tr>
                                        @foreach ($roles as $role)
                                            @if ($role->roles !== 'superadmin')
                                                <tr>
                                                    <td>{{ ucwords($role->name) }}</td>
                                                    <td>{{ $role->created_at }}</td>
                                                    @if (Auth::user()->username == 'admin' || Auth::user()->roles == 'superadmin')
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href='{{ route('roles.edit', $role->id) }}'
                                                                    class="btn btn-sm btn-info waves-effect waves-light mx-1"
                                                                    id="edit-data" title="Edit"><i
                                                                        class="fas fa-edit me-2"></i> Edit</a>
                                                                <button
                                                                    class="ml-2 btn btn-sm btn-danger btn-icon confirm-delete"
                                                                    id="delete" data-id="{{ $role->id }}"
                                                                    title="Hapus" data-toggle="tooltip">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </div>
                                <div class="mt-5">
                                    {{ $roles->withQueryString()->links() }}
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script>
        $(document).on("click", "button#delete", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup(BASE_URL + '/roles/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/roles');
        });
    </script>
@endpush

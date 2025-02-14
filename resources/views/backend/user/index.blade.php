@extends('layouts.dashboard')

@section('title', 'All ' . $title . 's')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="card mb-4">
                <div class="card-header header-elements">
                    <h3 class="mb-0 me-2">All {{ $title }}</h3>
                    <div class="card-header-elements ms-auto">
                        <span class="text text-muted d-flex">
                            <small>
                                @include('backend.user.breadcrumb')
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
                                @if (Auth::user()->username == 'admin' || Auth::user()->username == 'superadmin')
                                    <a href="{{ route('user.create') }}" class="btn btn-primary"><i
                                            class="fas fa-plus me-2"></i>
                                        New {{ $title }}</a>
                                @endif
                                <div class="card-header-elements ms-auto">
                                    <form method="GET" action="{{ route('user.index') }}">
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
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Level</th>
                                                @if (Auth::user()->username == 'admin' || Auth::user()->roles == 'superadmin')
                                                    <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($users as $user)
                                                @if ($user->roles !== 'superadmin')
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->username }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td>{{ $user->role }}</td>
                                                        @if (Auth::user()->username == 'admin' || Auth::user()->roles == 'superadmin')
                                                            <td class="text-nowrap">
                                                                <div class="d-flex justify-content-center">
                                                                    <a href='{{ route('user.permission', $user->id) }}'
                                                                        class="btn btn-sm btn-warning waves-effect waves-light">
                                                                        <i class="fas fa-list me-2"></i>
                                                                        Permission
                                                                    </a>
                                                                    <a href='{{ route('user.edit', $user->id) }}'
                                                                        class="btn btn-sm btn-info waves-effect waves-light mx-1">
                                                                        <i class="fas fa-edit me-2"></i>
                                                                        Edit
                                                                    </a>
                                                                    <button
                                                                        class="btn btn-sm btn-danger waves-effect waves-light confirm-delete"
                                                                        id="delete" data-id="{{ $user->id }}"
                                                                        title="Hapus" data-toggle="tooltip">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-5">
                                    {{ $users->withQueryString()->links() }}
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
    <script src="{{ asset('v3/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('v3/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('v3/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('v3/assets/js/tables-datatables-basic.js') }}"></script>
    <script>
        $(document).on("click", "button#delete", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup(BASE_URL + '/user/' + id, '{{ csrf_token() }}', '', '',
                BASE_URL + '/user');
        });
    </script>
@endpush

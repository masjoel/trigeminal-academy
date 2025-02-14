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
                                @include('backend.user.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>

            <div class="section-body">

                <div class="card">
                    <form action="{{ route('user.updatepermission', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <div class="form-group mb-2">Nama : <b>{{ $user->name }}</b></div>
                                <div class="form-group">Username : <b>{{ $user->username }}</b></div>
                            </div>
                            <div class="form-group mt-4">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Permission</th>
                                        <th class="text-center">View</th>
                                        <th class="text-center">Create</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                    </tr>
                                    @php $i=0; @endphp
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td><input type="checkbox"
                                                    class="checkall{{ $i }} form-check-input mr-2">
                                                {{ ucwords(str_replace('-', ' ', $permission->name)) }}</td>
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input check-it{{ $i }}"
                                                    name="user_permission[{{ $permission->name }}]"
                                                    {{ in_array($permission->name, $permissionUsers) ? 'checked' : '' }}>
                                            </td>
                                            @foreach ($permissionChilds as $child)
                                                @php
                                                    $pos = strpos($child->name, '.');
                                                    $namaMenu = substr($child->name, 0, $pos);
                                                    $namaPermission = substr($child->name, $pos + 1);
                                                @endphp
                                                @if ($namaMenu == $permission->name)
                                                    <td class="text-center">
                                                        <input type="checkbox"
                                                            class="form-check-input check-it{{ $i }}"
                                                            name="user_permission[{{ $child->name }}]"
                                                            {{ in_array($child->name, $permissionUsers) ? 'checked' : '' }}>
                                                    </td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                </table>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button class="btn btn-lg btn-primary"><i class="ti ti-device-floppy me-2"></i> Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $("[class^='checkall']").change(function() {
            var classPrefix = $(this).attr("class").split(" ")[0]; // Mengambil awalan kelas (contoh: checkall)
            var checked = $(this).is(":checked");
            var suffix = classPrefix.replace("checkall", "");
            $(".check-it" + suffix).each(function() {
                $(this).prop("checked", checked);
            });
        });
    </script>
@endpush

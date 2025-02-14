<nav>
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('seting-jabatan.index') }}">Jabatan</a>
        </li>
        @if (Request::is('*create'))
            <li class="breadcrumb-item active">Add Jabatan</li>
        @elseif (Request::is('*edit'))
            <li class="breadcrumb-item active">Edit Jabatan</li>
        @else
            <li class="breadcrumb-item d-none"></li>
        @endif
    </ol>
</nav>
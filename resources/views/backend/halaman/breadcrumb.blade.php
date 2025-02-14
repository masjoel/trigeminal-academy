<nav>
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('halaman.index') }}">Halaman</a>
        </li>
        @if (Request::is('*create'))
            <li class="breadcrumb-item active">Add Halaman</li>
        @elseif (Request::is('*edit'))
            <li class="breadcrumb-item active">Edit Halaman</li>
        @else
            <li class="breadcrumb-item d-none"></li>
        @endif
    </ol>
</nav>
<nav>
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('artikel.index') }}">Artikel</a>
        </li>
        @if (Request::is('*create'))
            <li class="breadcrumb-item active">Add Artikel</li>
        @elseif (Request::is('*edit'))
            <li class="breadcrumb-item active">Edit Artikel</li>
        @else
            <li class="breadcrumb-item d-none"></li>
        @endif
    </ol>
</nav>
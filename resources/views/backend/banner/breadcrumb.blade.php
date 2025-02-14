<nav>
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('slidebanner.index') }}">Slide</a>
        </li>
        @if (Request::is('*create'))
            <li class="breadcrumb-item active">Add Slide</li>
        @elseif (Request::is('*edit'))
            <li class="breadcrumb-item active">Edit Slide</li>
        @else
            <li class="breadcrumb-item d-none"></li>
        @endif
    </ol>
</nav>
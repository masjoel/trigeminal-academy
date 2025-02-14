<nav>
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('user.index') }}">Users</a>
        </li>
        @if (Request::is('*create'))
            <li class="breadcrumb-item active">{{ $title }}</li>
        @elseif (Request::is('*edit'))
            <li class="breadcrumb-item active">{{ $title }}</li>
        @else
            <li class="breadcrumb-item d-none"></li>
        @endif
    </ol>
</nav>

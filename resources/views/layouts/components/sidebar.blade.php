<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="menu-text fw-bold">Trigeminal Academy</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        @include('layouts.components.web-menu')

        <li
            class="menu-item {{ Request::is('profil-bisnis*', 'link*', 'backup*', 'user*', 'restore*', 'roles*', 'permissions*', 'bentuk-usaha*', 'kegiatan-usaha*') ? 'active open' : '' }}">
            @if (Str::contains(Auth::user()->getPermissionNames(), 'seting'))
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon ti ti-tool"></i>
                    <div>Setting</div>
                </a>
                <ul class="menu-sub">
                    @if (Str::contains(Auth::user()->getPermissionNames(), 'seting-profil-bisnis'))
                        <li class="menu-item {{ Request::is('profil-bisnis*', 'link*') ? 'active' : '' }}">
                            <a href="{{ route('profil-bisnis.index') }}" class="menu-link "><span>Business Profile</span></a>
                        </li>
                    @endif
                    @if (Str::contains(Auth::user()->getPermissionNames(), 'seting-user'))
                        <li class="menu-item {{ Request::is('user*') ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}" class="menu-link ">
                                <span>User</span></a>
                        </li>
                    @endif
                    @if (Str::contains(Auth::user()->getPermissionNames(), 'seting-backup'))
                        <li class="menu-item {{ Request::is('backup-data*') ? 'active' : '' }}">
                            <a href="{{ route('backup-data.index') }}" class="menu-link ">
                                <span>Data Backup</span></a>
                        </li>
                    @endif
                    @if (Str::contains(Auth::user()->getPermissionNames(), 'seting-restore'))
                        <li class="menu-item {{ Request::is('restore-data*') ? 'active' : '' }}">
                            <a href="{{ route('restore-data') }}" class="menu-link ">
                                <span>Data Restore</span></a>
                        </li>
                    @endif
                    @if (Str::contains(Auth::user()->getPermissionNames(), 'seting-roles'))
                        <li class="menu-item {{ Request::is('roles*') ? 'active' : '' }}">
                            <a href="{{ route('roles.index') }}" class="menu-link ">
                                <span>Roles</span></a>
                        </li>
                    @endif
                </ul>
            @endif
        </li>
        <li class="menu-header small">
            <div></div>
        </li>
        <li class="menu-item mb-5">
            <a href="#" class="menu-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                    class="menu-icon ti ti-logout text-danger"></i>
                <div>Logout</div>
            </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="post">@csrf</form>
    </ul>
</aside>

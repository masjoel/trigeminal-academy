{{-- @can('dashboard-webdesa') --}}
    <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link "><i class="menu-icon ti ti-dashboard"></i><div>Dashboard</div></a>
    </li>
    <li class="menu-item {{ Request::is('admin-member') ? 'active' : '' }}">
        <a href="{{ route('admin-member.index') }}" class="menu-link "><i class="menu-icon ti ti-users"></i><div>Member</div></a>
    </li>
{{-- @endcan --}}
@if (Str::contains(Auth::user()->getPermissionNames(), 'halaman') ||
        Str::contains(Auth::user()->getPermissionNames(), 'artikel') ||
        Str::contains(Auth::user()->getPermissionNames(), 'category-artikel'))
    <li class="menu-item {{ Request::is('halaman*', 'category*', 'artikel*') ? 'active open' : '' }}">
        <a href="#" class="menu-link menu-toggle"><i class="menu-icon ti ti-news"></i><div>Posting</div></a>
        <ul class="menu-sub">
            @can('halaman')
                <li class="menu-item {{ Request::is('halaman*') ? 'active' : '' }}">
                    <a href="{{ route('halaman.index') }}" class="menu-link "><div>Halaman</div></a>
                </li>
            @endcan
            @can('artikel')
                <li class="menu-item {{ Request::is('artikel*') ? 'active' : '' }}">
                    <a href="{{ route('artikel.index') }}" class="menu-link "><div>Artikel</div></a>
                </li>
            @endcan
            @can('category-artikel')
                <li class="menu-item {{ Request::is('category*') ? 'active' : '' }}">
                    <a href="{{ route('category.index') }}" class="menu-link "><div>Kategori
                            Artikel</div></a>
                </li>
            @endcan
        </ul>
    </li>
@endif
@if (Str::contains(Auth::user()->getPermissionNames(), 'galeri-foto') ||
        Str::contains(Auth::user()->getPermissionNames(), 'galeri-video'))
    <li class="menu-item {{ Request::is('galeri*') ? 'active open' : '' }}">
        <a href="#" class="menu-link menu-toggle"><i class="menu-icon ti ti-camera"></i><div>Galeri</div></a>
        <ul class="menu-sub">
            @can('galeri-foto')
                <li class="menu-item {{ Request::is('galeri-foto*') ? 'active' : '' }}">
                    <a href="{{ route('galeri-foto.index') }}" class="menu-link "><div>Foto</div></a>
                </li>
            @endcan
            @can('galeri-video')
                <li class="menu-item {{ Request::is('galeri-video*') ? 'active' : '' }}">
                    <a href="{{ route('galeri-video.index') }}" class="menu-link "><div>Video</div></a>
                </li>
            @endcan
        </ul>
    </li>
@endif

{{-- @if (Str::contains(Auth::user()->getPermissionNames(), 'admin-struktur') ||
        Str::contains(Auth::user()->getPermissionNames(), 'admin-pengurus'))
    <li class="menu-item {{ Request::is('admin-struktur*', 'admin-pengurus*', 'admin-lembaga*','absensi/admin-pengurus*') ? 'active open' : '' }}">
        <a href="#" class="menu-link menu-toggle"><i class="menu-icon ti ti-building"></i><div>Pengurus</div></a>
        <ul class="menu-sub">
            @can('admin-struktur-organisasi')
                <li class="menu-item {{ Request::is('admin-struktur-organisasi*') ? 'active' : '' }}">
                    <a href="{{ route('admin-struktur-organisasi.index') }}" class="menu-link "><div>Struktur
                            Organisasi</div></a>
                </li>
            @endcan
            @can('admin-pengurus')
                <li class="menu-item {{ Request::is('admin-pengurus*','absensi/admin-pengurus*') ? 'active' : '' }}">
                    <a href="{{ route('admin-pengurus.index') }}" class="menu-link "><div>Anggota Pengurus</div></a>
                </li>
            @endcan
        </ul>
    </li>
@endif --}}

@can('slide-banner')
    <li class="menu-item {{ Request::is('slidebanner*') ? 'active' : '' }}">
        <a href="{{ route('slidebanner.index') }}" class="menu-link "><i class="menu-icon ti ti-presentation"></i><div>Slide
                Banner</div></a>
    </li>
@endcan

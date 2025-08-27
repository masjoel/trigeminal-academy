{{-- @can('dashboard-webdesa') --}}
<li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" class="menu-link "><i class="menu-icon ti ti-dashboard"></i>
        <div>Dashboard</div>
    </a>
</li>
@can('student')
    <li class="menu-item {{ Request::is('student*') ? 'active' : '' }}">
        <a href="{{ route('student.index') }}" class="menu-link "><i class="menu-icon ti ti-users"></i>
            <div>Students</div>
        </a>
    </li>
@endcan
@can('instruktur')
    <li class="menu-item {{ Request::is('instruktur*') ? 'active' : '' }}">
        <a href="{{ route('instruktur.index') }}" class="menu-link "><i class="menu-icon ti ti-users"></i>
            <div>Instructor</div>
        </a>
    </li>
@endcan
@if (Str::contains(Auth::user()->getPermissionNames(), 'halaman') ||
        Str::contains(Auth::user()->getPermissionNames(), 'artikel') ||
        Str::contains(Auth::user()->getPermissionNames(), 'category-artikel'))
    <li class="menu-item {{ Request::is('halaman*', 'category*', 'artikel*') ? 'active open' : '' }}">
        <a href="#" class="menu-link menu-toggle"><i class="menu-icon ti ti-news"></i>
            <div>Posting</div>
        </a>
        <ul class="menu-sub">
            @can('halaman')
                <li class="menu-item {{ Request::is('halaman*') ? 'active' : '' }}">
                    <a href="{{ route('halaman.index') }}" class="menu-link ">
                        <div>Page</div>
                    </a>
                </li>
            @endcan
            @can('artikel')
                <li class="menu-item {{ Request::is('artikel*') ? 'active' : '' }}">
                    <a href="{{ route('artikel.index') }}" class="menu-link ">
                        <div>Article</div>
                    </a>
                </li>
            @endcan
            @can('category-artikel')
                <li class="menu-item {{ Request::is('category*') ? 'active' : '' }}">
                    <a href="{{ route('category.index') }}" class="menu-link ">
                        <div>Article Category</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endif
@if (Str::contains(Auth::user()->getPermissionNames(), 'galeri-foto') ||
        Str::contains(Auth::user()->getPermissionNames(), 'galeri-video'))
    <li class="menu-item {{ Request::is('galeri*') ? 'active open' : '' }}">
        <a href="#" class="menu-link menu-toggle"><i class="menu-icon ti ti-camera"></i>
            <div>Galery</div>
        </a>
        <ul class="menu-sub">
            @can('galeri-foto')
                <li class="menu-item {{ Request::is('galeri-foto*') ? 'active' : '' }}">
                    <a href="{{ route('galeri-foto.index') }}" class="menu-link ">
                        <div>Photo</div>
                    </a>
                </li>
            @endcan
            @can('galeri-video')
                <li class="menu-item {{ Request::is('galeri-video*') ? 'active' : '' }}">
                    <a href="{{ route('galeri-video.index') }}" class="menu-link ">
                        <div>Video</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endif

@if (Str::contains(Auth::user()->getPermissionNames(), 'course') ||
        Str::contains(Auth::user()->getPermissionNames(), 'kategori-kursus') ||
        Str::contains(Auth::user()->getPermissionNames(), 'orders') ||
        Str::contains(Auth::user()->getPermissionNames(), 'lihat-peserta'))
    <li
        class="menu-item {{ Request::is('course*', 'kategori-kursus*', 'order*', 'lihat-peserta*') ? 'active open' : '' }}">
        <a href="#" class="menu-link menu-toggle"><i class="menu-icon ti ti-shopping-cart"></i>
            <div>e-Commerce</div>
        </a>
        <ul class="menu-sub">
            @can('course')
                <li class="menu-item {{ Request::is('course*', 'lihat-peserta*') ? 'active' : '' }}">
                    <a href="{{ route('course.index') }}" class="menu-link ">
                        <div>Classroom</div>
                    </a>
                </li>
            @endcan
            @can('kategori-kursus')
                <li class="menu-item {{ Request::is('kategori-kursus*') ? 'active' : '' }}">
                    <a href="{{ route('kategori-kursus.index') }}" class="menu-link ">
                        <div>Category </div>
                    </a>
                </li>
            @endcan
            @can('orders')
                <li class="menu-item {{ Request::is('order*') ? 'active' : '' }}">
                    <a href="{{ route('order.index') }}" class="menu-link ">
                        <div>Order</div>
                    </a>
                </li>
            @endcan
            {{-- 
            @can('lapak-desa-report') --}}
            {{-- <li class="menu-item">
                    <a href="#" class="menu-link "><div>Report</div></a>
                </li> --}}
            {{-- @endcan --}}
        </ul>
    </li>
@endif


@can('slide-banner')
    <li class="menu-item {{ Request::is('slidebanner*') ? 'active' : '' }}">
        <a href="{{ route('slidebanner.index') }}" class="menu-link "><i class="menu-icon ti ti-presentation"></i>
            <div>Banner Slides</div>
        </a>
    </li>
@endcan

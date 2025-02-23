<header class="header-style-six">
    <div id="header-fixed-height"></div>
    <div class="header-top-wrap-four">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="header-top-left-four">
                        <div class="trending-box">
                            <div class="icon"><img src="/assets/img/icon/trending_icon.svg" alt=""></div>
                            <span>Trending</span>
                            <div class="shape">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122 36" preserveAspectRatio="none"
                                    fill="none">
                                    <path
                                        d="M0 18C0 8.05888 8.05887 0 18 0H110L121.26 16.8906C121.708 17.5624 121.708 18.4376 121.26 19.1094L110 36H18C8.05888 36 0 27.9411 0 18Z"
                                        fill="url(#trending_shape)" />
                                    <defs>
                                        <linearGradient id="trending_shape" x1="12" y1="36" x2="132"
                                            y2="36" gradientUnits="userSpaceOnUse">
                                            <stop offset="0" stop-color="#3F6088" />
                                            <stop offset="1" stop-color="#2A4970" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                        <div class="swiper-container ta-trending-slider">
                            <div class="swiper-wrapper">
                                @foreach (trending() as $t)
                                    <div class="swiper-slide">
                                        <div class="trending-content">
                                            <a href="/blog/{{ $t->slug }}">{{ $t->title }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="header-top-social header-top-social-two">
                        {{-- <h5 class="title">Follow Us:</h5> --}}
                        <ul class="list-wrap">
                            <li><a href="{{ klien('facebook') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li><a href="{{ klien('twitter') }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="{{ klien('instagram') }}" target="_blank"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li><a href="{{ klien('youtube') }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-logo-area-four">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="hl-left-side-four">
                        <span class="date"><i class="flaticon-calendar"></i>{{ date('F j, Y', time()) }}</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{-- <div class="text-center"> --}}
                    <div class="text-center tw-flex tw-justify-center">
                        <a href="/"><img
                                src="{{ preg_match('/desa/i', klien('logo')) ? Storage::url(klien('logo')) : asset(klien('logo')) }}"
                                style="height: 50px; width:auto" alt=""></a>
                    </div>
                    {{-- <div class="logo d-none text-center"> --}}
                    <div class="logo d-none text-center tw-flex tw-justify-center">
                        <a href="/"><img
                                src="{{ preg_match('/desa/i', klien('logo')) ? Storage::url(klien('logo')) : asset(klien('logo')) }}"
                                style="height: 50px; width:auto" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{-- <div class="header-action d-none d-md-block"> --}}
                    <div class="header-action hl-right-side-four">
                        <ul class="list-wrap">
                            <li class="header-cart">
                                <a href="#" id="keranjang-belanja-data"><i class="flaticon-basket"></i><span>0</span></a>
                                {{-- <strong>Rp 5.343.500</strong> --}}
                            </li>
                            <li class="header-sine-in">
                                <a href="{{ route('login') }}"><i class="flaticon-user"></i>Sign In</a>
                            </li>
                        </ul>
                    </div>
                    {{-- <div class="hl-right-side-four">
                        <div class="sign-in" id="cart-icon" onclick="showOrderDetails()">
                            <a href="{{ route('login') }}"><i class="flaticon-user"></i>Sign In</a>
                            <img class="text-blue" src="{{ asset('image/icon-cart.png') }}" alt="Keranjang Belanja">
                            <span id="item-count-2">0</span>
                        </div> --}}
                    {{-- <a style="margin-top: -15px;" href="#modalSigninVertical" data-bs-toggle="modal">
                            <i class="fa fa-qrcode fa-2x" style="color: black"></i>
                        </a> --}}
                    {{-- <a href="{{ route('login') }}" style="margin-top: -15px; color: gray"><i class="flaticon-user fa-2x"></i></a> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div id="sticky-header" class="menu-area menu-style-six">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="menu-wrap">
                        <nav class="menu-nav">
                            <div class="logo d-none">
                                <a href="/"><img
                                        src="{{ preg_match('/desa/i', klien('logo')) ? Storage::url(klien('logo')) : asset(klien('logo')) }}"
                                        style="height: 80px !important; width:auto" alt=""></a>
                            </div>
                            <div class="logo d-none white-logo">
                                <a href="/"><img
                                        src="{{ preg_match('/desa/i', klien('logo')) ? Storage::url(klien('logo')) : asset(klien('logo')) }}"
                                        alt=""></a>
                            </div>
                            <div class="offcanvas-toggle border-0">
                                {{-- <a href="javascript:void(0)" class="menu-tigger">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </a> --}}
                            </div>
                            <div class="navbar-wrap main-menu d-none d-lg-flex">
                                <ul class="navigation">
                                    <li><a href="{{ route('home') }}" title="Beranda">Beranda</a></li>
                                    <li><a href="/blog/category/berita" title="Beranda">Blog</a></li>
                                    {{-- <li class="menu-item-has-children"><a href="#">Profil Desa</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('about') }}" title="Tentang Kami">Tentang Kami</a>
                                            </li>
                                            <li><a href="{{ route('visimisi') }}" title="Visi Misi">Visi Misi</a>
                                            </li>
                                            <li><a href="{{ route('sejarah') }}" title="Sejarah Desa">Sejarah
                                                    Desa</a></li>
                                            <li><a href="{{ route('geografis') }}" title="Geografis Desa">Geografis
                                                    Desa</a></li>
                                            <li><a href="{{ route('demografi') }}" title="Demografi Desa">Demografi
                                                    Desa</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children"><a href="#">Pemerintahan</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('sotk') }}" title="Struktur Organisasi">Struktur
                                                    Organisasi</a></li>
                                            <li><a href="{{ route('perangkat') }}" title="Perangkat Desa">Perangkat
                                                    Desa</a></li>
                                            <li><a href="{{ route('lembaga-desa') }}" title="Lembaga Desa">Lembaga
                                                    Desa</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children"><a href="#">Layanan</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('surket') }}" title="Surat Keterangan">Surat
                                                    Keterangan</a></li>
                                            <li><a href="{{ route('lapak-desa') }}" title="Surat Keterangan">Lapak
                                                    Desa</a></li>
                                            <li><a href="{{ route('buku-tamu') }}" title="Surat Keterangan">Buku
                                                    Tamu</a></li>
                                            <li><a href="{{ route('survey-layanan') }}"
                                                    title="Surat Keterangan">Survey Layanan</a></li>
                                        </ul>
                                    </li> --}}
                                    {{-- <li class="menu-item-has-children"><a href="#">Informasi</a>
                                        <ul class="sub-menu">
                                            <li><a href="/blog/category/berita" title="Kabar Berita">Kabar Berita</a>
                                            </li>
                                            <li><a href="/blog/category/pengumuman" title="Pengumuman">Pengumuman</a>
                                            </li>
                                            <li><a href="/blog/category/agenda-kegiatan"
                                                    title="Agenda Kegiatan">Agenda Kegiatan</a></li>
                                            <li><a href="{{ url('/apbdesa') }}" title="APBDesa">APBDesa</a></li>
                                            <li><a href="{{ route('galery') }}" title="Galeri">Galeri</a></li>
                                            <li><a href="{{ url('/perpustakaan-desa') }}"
                                                    title="Perpustakaan Desa">Perpustakaan Desa</a></li>
                                        </ul>
                                    </li> --}}
                                    {{-- <li class="menu-item-has-children"><a href="#">Potensi Desa</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('potensi.penduduk') }}"
                                                    title="Potensi Penduduk">Potensi Penduduk</a></li>
                                            <li><a href="{{ route('potensi.wilayah') }}"
                                                    title="Potensi Wilayah">Potensi Wilayah</a></li>
                                            <li><a href="{{ route('potensi.sarana') }}"
                                                    title="Sarana & Prasarana">Sarana & Prasarana</a></li>
                                        </ul>
                                    </li> --}}
                                    {{-- <li><a href="{{ route('absensi.login') }}" title="Absensi">Absensi</a>
                                    </li>
                                    <li><a href="{{ route('produk.hukum') }}" title="Produk Hukum">Produk Hukum</a>
                                    </li> --}}
                                </ul>

                            </div>
                            <div class="header-search-wrap header-search-wrap-three">
                                {{-- <form action="#">
                                    <input type="text" placeholder="Search here . . .">
                                    <button type="submit"><i class="flaticon-search"></i></button>
                                </form> --}}
                            </div>
                            <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                        </nav>
                    </div>

                    <!-- Mobile Menu  -->
                    <div class="mobile-menu">
                        <nav class="menu-box">
                            <div class="close-btn"><i class="fas fa-times"></i></div>
                            <div class="nav-logo">
                                <a href="/"><img
                                        src="{{ preg_match('/desa/i', klien('logo')) ? Storage::url(klien('logo')) : asset(klien('logo')) }}"
                                        alt="Logo"></a>
                            </div>
                            <div class="nav-logo d-none">
                                <a href="/"><img
                                        src="{{ preg_match('/desa/i', klien('logo')) ? Storage::url(klien('logo')) : asset(klien('logo')) }}"
                                        alt="Logo"></a>
                            </div>
                            <div class="mobile-search mb-3">
                                <div class="header-action hl-right-side-four">
                                    {{-- <form action="#">
                                        <input type="text" placeholder="Search here...">
                                        <button><i class="flaticon-search"></i></button>
                                    </form> --}}
                                    <ul class="list-wrap">
                                        <li class="header-cart">
                                            <a href="javascript:void(0)"><i
                                                    class="flaticon-basket"></i><span>0</span></a>
                                            {{-- <strong>$0.00</strong> --}}
                                        </li>
                                        <li class="header-sine-in">
                                            <a href="{{ route('login') }}"><i class="flaticon-user"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                {{-- <div id="cart-icon" class="float-end" onclick="showOrderDetails()"> --}}
                                {{-- <img class="text-blue" src="{{ asset('image/icon-cart.png') }}"
                                        alt="Keranjang Belanja">
                                    <span id="item-count">0</span> --}}
                                {{-- <a href="javascript:void(0)"><i class="flaticon-basket"></i><span>0</span></a>
                                    <a href="{{ route('login') }}"><i class="flaticon-user fa-2x" style="color: black"></i></a> --}}
                                {{-- <a href="#modalSigninVertical" data-bs-toggle="modal">
                                        <i class="fa fa-qrcode fa-2x" style="color: black"></i>
                                    </a> --}}
                                {{-- </div> --}}
                                {{-- <form action="#">
                                    <input type="text" placeholder="Search here...">
                                    <button><i class="flaticon-search"></i></button>
                                </form> --}}
                            </div>
                            <div class="menu-outer">
                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                            </div>
                            <div class="social-links">
                                <ul class="clearfix list-wrap">
                                    <li><a href="{{ klien('facebook') }}" target="_blank"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="{{ klien('twitter') }}" target="_blank"><i
                                                class="fab fa-twitter"></i></a></li>
                                    <li><a href="{{ klien('instagram') }}" target="_blank"><i
                                                class="fab fa-instagram"></i></a></li>
                                    <li><a href="{{ klien('youtube') }}" target="_blank"><i
                                                class="fab fa-youtube"></i></a></li>
                                    {{-- <li><a href="{{ route('login') }}" style="color:crimson"><i class="fa flaticon-user"></i></a> --}}
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="menu-backdrop"></div>
                    <!-- End Mobile Menu -->

                </div>
            </div>
        </div>
    </div>

    <!-- offCanvas-area -->
    {{-- <div class="offCanvas-wrap">
        <div class="offCanvas-body">
            <div class="offCanvas-toggle">
                <span></span>
                <span></span>
            </div>
            <div class="offCanvas-content">
                <div class="offCanvas-logo logo">
                    <a href="/" class="logo-dark"><img
                            src="{{ preg_match('/desa/i', klien('logo')) ? Storage::url(klien('logo')) : asset(klien('logo')) }}"
                            alt="Logo"></a>
                    <a href="/" class="logo-light"><img
                            src="{{ preg_match('/desa/i', klien('logo')) ? Storage::url(klien('logo')) : asset(klien('logo')) }}"
                            alt="Logo"></a>
                </div>
                <p>The argument in favor of using filler text goes something like this: If you use any real content in
                    the Consulting Process anytime you reach.</p>
                <ul class="offCanvas-instagram list-wrap">
                    <li><a href="assets/img/blog/hr_post01.jpg" class="popup-image"><img
                                src="assets/img/blog/hr_post01.jpg" alt="img"></a></li>
                    <li><a href="assets/img/blog/hr_post02.jpg" class="popup-image"><img
                                src="assets/img/blog/hr_post02.jpg" alt="img"></a></li>
                    <li><a href="assets/img/blog/hr_post03.jpg" class="popup-image"><img
                                src="assets/img/blog/hr_post03.jpg" alt="img"></a></li>
                    <li><a href="assets/img/blog/hr_post04.jpg" class="popup-image"><img
                                src="assets/img/blog/hr_post04.jpg" alt="img"></a></li>
                    <li><a href="assets/img/blog/hr_post05.jpg" class="popup-image"><img
                                src="assets/img/blog/hr_post05.jpg" alt="img"></a></li>
                    <li><a href="assets/img/blog/hr_post06.jpg" class="popup-image"><img
                                src="assets/img/blog/hr_post06.jpg" alt="img"></a></li>
                </ul>
            </div>
            <div class="offCanvas-contact">
                <h4 class="title">Get In Touch</h4>
                <ul class="offCanvas-contact-list list-wrap">
                    <li><i class="fas fa-envelope-open"></i><a href="mailto:info@webmail.com">info@webmail.com</a>
                    </li>
                    <li><i class="fas fa-phone"></i><a href="tel:88899988877">888 999 888 77</a></li>
                    <li><i class="fas fa-map-marker-alt"></i> 12/A, New Booston, NYC</li>
                </ul>
                <ul class="offCanvas-social list-wrap">
                    <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fab fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="offCanvas-overlay"></div> --}}
    <!-- offCanvas-area-end -->
</header>

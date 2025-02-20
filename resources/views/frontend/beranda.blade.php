@extends('frontend.component.main')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('library/owl_carousel/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('library/owl_carousel/css/owl.theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('library/owl_carousel/css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('v3/libs/leaflet/leaflet.min.css') }}" />

    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        #bar {
            width: 0;
            max-width: 100%;
            height: 3px;
            background: #fff;
        }

        #progressBar {
            width: 100%;
            background: #ededed;
        }

        .feature-main {
            padding: 50px 0;
            background-color: #f2eded;
        }

        .heading_border {
            color: #fff;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            margin-bottom: 15px;
            padding: 5px 15px;
        }

        .bg-sukses {
            background-color: #00bc8c !important;
        }

        .box {
            border-radius: 3px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
            padding: 10px 15px;
            text-align: justify;
            display: block;
            margin-top: 60px;
            margin-bottom: 15px;
        }

        .box-icon {
            background-color: transparent;
            /* border: 1px solid #01bc8c; */
            border-radius: 50%;
            display: table;
            height: 80px;
            margin: 0 auto;
            width: 80px;
            margin-top: -61px;
        }

        .header-logo-area-four {
            padding: 15px 0;
        }

        .h3-layanan {
            font-size: 20px;
            margin-top: 10px;
        }

        .icon {
            position: relative;
            right: 0px !important;
            top: 0px !important;
        }

        .icon-layanan {
            position: relative;
            right: -12px;
            top: 14px;
        }
        
        .post-title{
            text-transform: none !important;
        }
        #owl-demo .item img {
            /* display: block; */
            width: 100% !important;
            height: auto;
        }
    </style>
@endpush
@section('title', $title)
@section('main')
    <div id="owl-demo" class="owl-carousel owl-theme">
        @if (count($banner) > 0)
            @foreach ($banner as $banner)
                <div class="item img-fluid">
                    <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}">
                </div>
            @endforeach
        @else
            <div class="item img-fluid">
                <img src="{{ asset('image/bg/bg-slide-1.jpg') }}" class="img-fluid" alt="banner">
            </div>
            <div class="item img-fluid">
                <img src="{{ asset('image/bg/bg-slide-2.jpg') }}" class="img-fluid" alt="banner">
            </div>
        @endif
    </div>

    <section class="banner-post-area-five pt-50 pb-50">
        <div class="container">
            <div class="row mb-4">
                <div class="mb-5 col-md-12 col-sm-12  col-lg-4 wow zoomIn" data-wow-duration="2s">
                    <img src="{{ infodesa('logo') == 'image/icon-foto.png' ? infodesa('logo') : Storage::url(infodesa('logo')) }}"
                        style="height:200px;width:100%;object-fit:contain;" alt="slider-image" class="img-fluid">
                </div>
                <div class="col-md-7 col-sm-12  col-md-12 col-lg-8 wow bounceInLeft" data-wow-duration="2s">
                    <h2 class="warning">{{ $halaman == null ? 'About Trigeminal Academy' : $halaman->title }}</h2>
                    @if ($halaman == null)
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio praesentium aperiam nihil iure
                            adipisci nulla, voluptate quis assumenda recusandae vel ex est enim voluptatum, nostrum
                            repellat, harum earum exercitationem excepturi!</p>
                    @else
                        <p>
                            {!! nl2br($halaman->deskripsi) !!}
                        </p>
                    @endif
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-3 wow bounceInLeft" data-wow-duration="2s">
                    <a href="{{ url('/surat-keterangan') }}" style="text-decoration: none">
                        <div class="box">
                            <div class="box-icon" style="border: 1px solid #FD8A8A">
                                <i class="livicon icon-layanan" data-name="mail" data-size="55" data-loop="true"
                                    data-c="#FD8A8A" data-hc="#FD8A8A"></i>
                            </div>
                            <div class="info">
                                <h3 class="danger text-center h3-layanan">Layanan Masyarakat</h3>
                                <p>Surat Keterangan online untuk memudahkan layanan publik</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-6  col-lg-3 col-12 wow bounceInDown" data-wow-duration="2s"
                    data-wow-delay="0.4s">
                    <a href="{{ url('/lapak-desa') }}" style="text-decoration: none">
                        <div class="box">
                            <div class="box-icon" style="border: 1px solid #418bca">
                                <i class="livicon icon-layanan" data-name="shopping-cart" data-size="55" data-loop="true"
                                    data-c="#418bca" data-hc="#418bca"></i>
                            </div>
                            <div class="info">
                                <h3 class="primary text-center h3-layanan">Lapak Desa</h3>
                                <p>Menumbuhkan perekonomian desa melalui jualan online</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-6  col-lg-3 col-12 wow bounceInUp" data-wow-duration="2s" data-wow-delay="0.8s">
                    <a href="{{ url('/pembangunan-desa') }}" style="text-decoration: none">
                        <div class="box">
                            <div class="box-icon" style="border: 1px solid #f89a14">
                                <i class="livicon icon-layanan" data-name="gears" data-size="55" data-loop="true"
                                    data-c="#f89a14" data-hc="#f89a14"></i>
                            </div>
                            <div class="info">
                                <h3 class="warning text-center h3-layanan">Pembangunan Desa</h3>
                                <p>Monitor pembangunan desa secara online</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3 col-12  wow bounceInRight" data-wow-duration="2s"
                    data-wow-delay="0.8s">
                    <a href="{{ url('/apbdesa') }}" style="text-decoration: none">
                        <div class="box">
                            <div class="box-icon" style="border: 1px solid #01bc8c">
                                <i class="livicon icon-layanan" data-name="money" data-size="55" data-loop="true"
                                    data-c="#01bc8c" data-hc="#01bc8c"></i>
                            </div>
                            <div class="info">
                                <h3 class="success text-center h3-layanan">Keuangan Desa</h3>
                                <p>Transparansi keuangan demi meningkatkan kepercayaan</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div> --}}
        </div>
    </section>

    <section class="trending-post-area-two">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-wrap mb-30">
                        <div class="section-title">
                            <h2 class="title"> </h2>
                        </div>
                        <div class="view-all-btn">
                            <a href="/anggota-pengurus" class="link-btn">Lihat semua
                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10" fill="none">
                                        <path
                                            d="M1.07692 10L0 8.92308L7.38462 1.53846H0.769231V0H10V9.23077H8.46154V2.61538L1.07692 10Z"
                                            fill="currentColor" />
                                        <path
                                            d="M1.07692 10L0 8.92308L7.38462 1.53846H0.769231V0H10V9.23077H8.46154V2.61538L1.07692 10Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                        <div class="section-title-line"></div>
                    </div>
                </div>
            </div>
            <div class="row trending-post-active wow bounceInRight" data-wow-duration="2s">
                @if (count($perangkatdesa) > 0)
                    @foreach ($perangkatdesa as $pd)
                        <div class="col-lg-4">
                            <div class="overlay-post-three overlay-post-four">
                                <div class="overlay-post-thumb-three">
                                    <a href="/anggota-pengurus/{{ $pd->slug }}">
                                        @if ($pd->avatar != null)
                                            <img src="{{ Storage::url($pd->avatar) }}" alt="{{ $pd->nama }}">
                                        @else
                                            <img src="{{ asset('image/icon-foto.png') }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="overlay-post-content-three">
                                    <a href="/anggota-pengurus/{{ $pd->slug }}"
                                        class="post-tag">{{ $pd->jabatan }}</a>
                                    <h2 class="post-title"><a
                                            href="/anggota-pengurus/{{ $pd->slug }}">{{ $pd->nama }}</a></h2>
                                    <div class="blog-post-meta white-blog-meta">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="trending-shape-wrap">
            <img src="assets/img/images/trending_shape01.png" alt="">
            <img src="assets/img/images/trending_shape02.png" alt="">
        </div>
    </section>

    <section class="top-news-post-area pt-50 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="sports-post-wrap">
                    <div class="section-title-wrap mb-30">
                        <div class="section-title section-title-four">
                            <h2 class="title">Blog</h2>
                        </div>
                        <div class="section-title-line"></div>
                    </div>
                    <div class="row">

                        <div class="col-lg-8">
                            <div class="sports-post">
                                @if ($berita != null)
                                    <div class="sports-post-thumb wow zoomIn" data-wow-duration="1s">
                                        <a href="/blog/{{ $berita->slug }}">
                                            @if ($berita->foto_unggulan != null)
                                                <img src="{{ Storage::url($berita->foto_unggulan) }}"
                                                    alt="{{ $berita->title }}" class="w-100">
                                            @else
                                                <img src="{{ asset('img/example-image.jpg') }}" class="img-fluid"
                                                    alt="{{ $berita->title }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="sports-post-content">
                                        {{-- <a href="/blog/category/{{ $berita->category->slug }}" class="post-tag-four">{{ $berita->category->kategori }}</a> --}}
                                        <h4 class="post-title bold-underline"><a
                                                href="/blog/{{ $berita->slug }}">{{ $berita->title }}</a>
                                        </h4>
                                        <div class="blog-post-meta">
                                            <ul class="list-wrap">
                                                <li><i class="flaticon-calendar"></i>{{ kalender($berita->created_at) }}
                                                </li>
                                                <li><i
                                                        class="flaticon-history"></i>{{ $berita->created_at->diffForHumans() }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="sidebar-wrap sidebar-wrap-four">
                                @foreach ($berita3 as $bt3)
                                    <div class="horizontal-post-four horizontal-post-five wow bounceInUp"
                                        data-wow-duration="3s">
                                        <div class="horizontal-post-thumb-four">
                                            <a href="/blog/{{ $bt3->slug }}">
                                                @if ($bt3->foto_unggulan != null)
                                                    <img src="{{ Storage::url('thumb/' . $bt3->foto_unggulan) }}"
                                                        alt="{{ $bt3->title }}">
                                                @else
                                                    <img src="{{ asset('img/example-image.jpg') }}" class="img-fluid"
                                                        alt="{{ $bt3->title }}">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="horizontal-post-content-four">
                                            {{-- <a href="blog.html" class="post-tag-four">basket Ball</a> --}}
                                            <h4 class="post-title"><a
                                                    href="/blog/{{ $bt3->slug }}">{{ $bt3->title }}</a>
                                            </h4>
                                            <div class="blog-post-meta">
                                                <ul class="list-wrap">
                                                    <li><i
                                                            class="flaticon-calendar"></i>{{ $berita->created_at->diffForHumans() }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="editor-post-area-three pt-30" style="padding: 30px">
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-12">
                    <div class="section-title-wrap mb-30">
                        <div class="section-title section-title-four">
                            <h2 class="title">Galery Video</h2>
                            <div class="editor-nav-two"></div>
                        </div>
                        <div class="section-title-line"></div>
                    </div>
                </div>
            </div>
            <div class="row gutter-40 editor-post-active-two">
                @foreach ($video as $v)
                    <div class="col-lg-3 wow bounceInRight" data-wow-duration="3s">
                        <div class="editor-post-three">
                            <div class="editor-post-thumb-three">
                                @if ($v->foto_unggulan != null)
                                    <img src="{{ Storage::url('thumb/' . $v->foto_unggulan) }}"
                                        alt="{{ $v->title }}" class="w-100" style="min-height: 205px">
                                @else
                                    <img src="{{ asset('img/example-image.jpg') }}" class="img-fluid"
                                        alt="{{ $v->title }}">
                                @endif
                                <a href="{{ $v->excerpt }}" class="paly-btn popup-video"><i class="fas fa-play"></i>
                                </a>
                            </div>
                            <div class="editor-post-content-three">
                                <h2 class="post-title"><a href="{{ $v->excerpt }}"
                                        target="_blank">{{ Str::lower($v->title) }}</a></h2>
                                <div class="blog-post-meta">
                                    <ul class="list-wrap">
                                        <li style="font-size: 10px"><i
                                                class="flaticon-calendar"></i>{{ kal($v->created_at) }} </li>
                                        <li style="font-size: 10px"><i
                                                class="flaticon-history"></i>{{ $v->created_at->diffForHumans() }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}
    <section class="editor-post-area-three pt-30" style="padding: 30px">
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-12">
                    <div class="section-title-wrap mb-30">
                        <div class="section-title section-title-four">
                            <h2 class="title">Materi terbaru</h2>
                            <div class="editor-nav-two"></div>
                        </div>
                        <div class="section-title-line"></div>
                    </div>
                </div>
            </div>
            <div class="row gutter-40 editor-post-active-two">
                @foreach ($foto as $v)
                    <div class="col-lg-3 wow bounceInRight" data-wow-duration="3s">
                        <div class="editor-post-three">
                            <div class="editor-post-thumb-three">
                                @if ($v->foto_unggulan != null)
                                    <img src="{{ Storage::url('thumb/' . $v->foto_unggulan) }}"
                                        alt="{{ $v->title }}" class="w-100" style="min-height: 205px">
                                @else
                                    <img src="{{ asset('img/example-image.jpg') }}" class="img-fluid"
                                        alt="{{ $v->title }}">
                                @endif
                                <a href="{{ Storage::url($v->foto_unggulan) }}" class="paly-btn popup-video"><i class="fas fa-camera"></i>
                                </a>
                            </div>
                            <div class="editor-post-content-three">
                                <h2 class="post-title"><a href="{{ $v->excerpt }}"
                                        target="_blank">{{ $v->title }}</a></h2>
                                <div class="blog-post-meta">
                                    <ul class="list-wrap">
                                        <li style="font-size: 10px"><i
                                                class="flaticon-calendar"></i>{{ kal($v->created_at) }} </li>
                                        <li style="font-size: 10px"><i
                                                class="flaticon-history"></i>{{ $v->created_at->diffForHumans() }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="top-news-post-area pt-50">
        <div class="container">
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('js/frontend/lib.js') }}"></script>
    <script type="text/javascript" src="{{ asset('library/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('library/owl_carousel/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/frontend/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('v3/libs/leaflet/leaflet.min.js') }}"></script>
@endpush

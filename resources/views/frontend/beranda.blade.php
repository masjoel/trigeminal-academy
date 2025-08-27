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

        .post-title {
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

    {{-- Mulai Konten tailwindcss --}}
    <section id="tw-sec-1" class="tw-container tw-mx-auto tw-px-4 tw-py-12 md:tw-py-16">
        <div class="tw-flex tw-flex-col-reverse md:tw-flex-row tw-items-center tw-justify-between tw-gap-8">
            {{-- Left Content --}}
            <div class="tw-flex-1 md:tw-text-left tw-text-center">
                <h1 class="tw-text-4xl md:tw-text-5xl tw-font-bold tw-text-[#4A1B7F]">
                    {{ $section1 == null ? 'Lorem ipsum' : $section1->title }}</h1>
                @if ($section1 == null)
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio praesentium aperiam nihil iure
                        adipisci nulla, voluptate quis assumenda recusandae vel ex est enim voluptatum, nostrum
                        repellat, harum earum exercitationem excepturi!</p>
                @else
                    {!! nl2br($section1 == null ? '' : $section1->deskripsi) !!}
                @endif

                <div class="tw-mt-8 tw-flex tw-flex-wrap tw-gap-4 tw-justify-center md:tw-justify-start">
                    <a href="{{ route('login') }}"
                        class="tw-px-6 tw-py-3 tw-bg-[#4A1B7F] tw-text-white tw-rounded-lg hover:tw-bg-[#3B1564] tw-transition tw-font-medium">
                        Login Member
                    </a>
                    <a href="/kelas"
                        class="tw-px-6 tw-py-3 tw-bg-white tw-text-[#4A1B7F] tw-border tw-border-[#4A1B7F] tw-rounded-lg hover:tw-bg-gray-50 tw-transition tw-font-medium">
                        Browse Class
                    </a>
                </div>
            </div>

            {{-- Right Content - Hero Image --}}
            <div class="tw-flex-1 tw-relative tw-w-full">
                <div class="tw-relative">
                    {{-- Main Image Container --}}
                    <div class="tw-rounded-[2.5rem] shadow-1 shadow-gray-300 tw-overflow-hidden tw-relative">
                        <img src="{{ $section1 == null ? infodesa('logo') : Storage::url($section1->foto_unggulan) }}"
                            alt="Students Learning"
                            class="tw-w-full md:tw-max-w-[600px] tw-mx-auto tw-h-auto tw-object-cover tw-rounded-[2.5rem]">
                    </div>
                    <div class="tw-absolute tw-inset-0 tw-bg-purple-300 tw-opacity-20 tw-blur-3xl tw-rounded-full tw--z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="tw-container tw-mx-auto tw-px-4 tw-py-12">
        <div class="tw-grid tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-4 md:tw-gap-6"> --}}
            {{-- C-Suite Programs --}}
            {{-- <div class="tw-relative tw-overflow-hidden tw-group tw-h-[90px] md:tw-h-[140px]">
                <div class="tw-bg-[#4A1B7F] tw-h-full tw-relative" style="border-radius: 34px 40px 80px 5px;">
                    <img src="https://cdn.pixabay.com/photo/2017/08/01/13/36/computer-2565478_1280.jpg"
                        alt="C-Suite Programs" class="tw-w-full tw-h-full tw-object-cover tw-opacity-75"
                        style="border-radius: 34px 40px 80px 5px;">
                    <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-b tw-from-transparent tw-to-[#4A1B7F]/90"
                        style="border-radius: 34px 40px 80px 5px;"></div>
                    <h3 class="tw-absolute tw-bottom-4 tw-left-4 tw-text-sm md:tw-text-xl tw-font-bold tw-text-white">
                        Umum</h3>
                </div>
            </div> --}}

            {{-- Senior Executive Programs --}}
            {{-- <div class="tw-relative tw-overflow-hidden tw-group tw-h-[90px] md:tw-h-[140px]">
                <div class="tw-bg-[#831843] tw-h-full tw-relative" style="border-radius: 34px 40px 80px 5px;">
                    <img src="https://cdn.pixabay.com/photo/2017/03/28/12/11/chairs-2181960_640.jpg"
                        alt="Senior Executive Programs" class="tw-w-full tw-h-full tw-object-cover tw-opacity-75"
                        style="border-radius: 34px 40px 80px 5px;">
                    <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-b tw-from-transparent tw-to-[#831843]/90"
                        style="border-radius: 34px 40px 80px 5px;"></div>
                    <h3 class="tw-absolute tw-bottom-4 tw-left-4 tw-text-sm md:tw-text-xl tw-font-bold tw-text-white">
                        Pemula</h3>
                </div>
            </div> --}}

            {{-- Junior Executive Programs --}}
            {{-- <div class="tw-relative tw-overflow-hidden tw-group tw-h-[90px] md:tw-h-[140px]">
                <div class="tw-bg-[#92400E] tw-h-full tw-relative" style="border-radius: 34px 40px 80px 5px;">
                    <img src="https://cdn.pixabay.com/photo/2017/03/28/12/07/bricks-2181920_640.jpg"
                        alt="Junior Executive Programs" class="tw-w-full tw-h-full tw-object-cover tw-opacity-75"
                        style="border-radius: 34px 40px 80px 5px;">
                    <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-b tw-from-transparent tw-to-[#92400E]/90"
                        style="border-radius: 34px 40px 80px 5px;"></div>
                    <h3 class="tw-absolute tw-bottom-4 tw-left-4 tw-text-sm md:tw-text-xl tw-font-bold tw-text-white">
                        Menengah</h3>
                </div>
            </div> --}}

            {{-- Student Programs --}}
            {{-- <div class="tw-relative tw-overflow-hidden tw-group tw-h-[90px] md:tw-h-[140px]">
                <div class="tw-bg-[#A21CAF] tw-h-full tw-relative" style="border-radius: 34px 40px 80px 5px;">
                    <img src="https://cdn.pixabay.com/photo/2015/01/08/18/26/man-593333_640.jpg" alt="Student Programs"
                        class="tw-w-full tw-h-full tw-object-cover tw-opacity-75"
                        style="border-radius: 34px 40px 80px 5px;">
                    <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-b tw-from-transparent tw-to-[#A21CAF]/90"
                        style="border-radius: 34px 40px 80px 5px;"></div>
                    <h3 class="tw-absolute tw-bottom-4 tw-left-4 tw-text-sm md:tw-text-xl tw-font-bold tw-text-white">
                        Terampil</h3>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="top-news-post-area pt-50 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="sports-post-wrap">
                    <div class="section-title-wrap mb-30">
                        <div class="section-title section-title-four">
                            <h2 class="title">Class</h2>
                        </div>
                        <div class="section-title-line"></div>
                        <div class="view-all-btn">
                            <a href="/kelas" class="link-btn">See all
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
                    </div>

                    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-6">
                        @foreach ($courses as $dt)
                            <a href="{{ route('detail-kelas', $dt->slug) }}" class="tw-block">
                                <div
                                    class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-overflow-hidden tw-h-full tw-transition-all tw-duration-300 hover:tw-brightness-95">
                                    <div class="tw-relative tw-h-48">
                                        <img src="{{ $dt->image_url == null ? asset('img/example-image.jpg') : Storage::url('thumb/' . $dt->image_url) }}"
                                            alt="{{ $dt->name }}" class="tw-w-full tw-h-full tw-object-cover">

                                        {{-- Status Badges --}}
                                        {{-- <div class="tw-absolute tw-top-4 tw-right-4 tw-flex tw-items-center tw-gap-2">
                                                @if ($dt['isNew'])
                                                    <div class="tw-bg-green-500 tw-text-white tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-whitespace-nowrap">
                                                        Baru
                                                    </div>
                                                @endif
                                                @if ($dt['isPopular'])
                                                    <div class="tw-bg-[#4A1B7F] tw-text-white tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-whitespace-nowrap">
                                                        Populer
                                                    </div>
                                                @endif
                                            </div> --}}
                                    </div>

                                    <div class="tw-p-6 tw-pt-6 tw-flex tw-flex-col tw-h-[calc(100%-192px)]">
                                        {{-- Category Badge --}}
                                        <div class="tw-mb-3">
                                            <span
                                                class="tw-bg-[#4A1B7F]/10 tw-text-[#4A1B7F] tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium"
                                                style="background-color: {{ $dt->productCategory->warna }}20; color: {{ $dt->productCategory->warna }};">
                                                {{ $dt->productCategory->name }}
                                            </span>
                                        </div>

                                        <h3 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-2">{{ $dt->name }}
                                        </h3>

                                        <p class="tw-text-gray-600 tw-mb-4 tw-line-clamp-2">{{ $dt->excerpt }}</p>

                                        <div class="tw-flex tw-flex-wrap tw-gap-4 tw-mb-4">
                                            <div class="tw-flex tw-items-center">
                                                <i class="flaticon-history tw-text-[#4A1B7F] tw-mr-2"></i>
                                                <span class="tw-text-sm tw-text-gray-600">{{ $dt->video_duration }}
                                                    Minute</span>
                                            </div>
                                            <div class="tw-flex tw-items-center">
                                                <i class="flaticon-user tw-text-[#4A1B7F] tw-mr-2"></i>
                                                <span class="tw-text-sm tw-text-gray-600">{{ $dt->orderitems->count() }}
                                                    Member</span>
                                            </div>
                                            <div class="tw-flex tw-items-center">
                                                <i class="flaticon-thunder tw-text-[#4A1B7F] tw-mr-2"></i>
                                                <span class="tw-text-sm tw-text-gray-600">{{ ucwords($dt->level) }}</span>
                                            </div>
                                        </div>

                                        <div class="tw-mt-auto">
                                            <div class="tw-mb-4">
                                                @if ($dt['discount'])
                                                    <div class="tw-flex tw-items-center tw-gap-2 tw-mb-1">
                                                        <span class="tw-text-gray-500 tw-line-through">Rp
                                                            {{ number_format($dt->price, 0, ',', '.') }}</span>
                                                        <span
                                                            class="tw-bg-red-100 tw-text-red-600 tw-px-2 tw-py-1 tw-rounded tw-text-xs">{{ $dt->discount }}%
                                                            OFF</span>
                                                    </div>
                                                    <div class="tw-text-[#4A1B7F] tw-font-bold tw-text-2xl">
                                                        Rp
                                                        {{ number_format($dt->price * (1 - $dt->discount / 100), 0, ',', '.') }}
                                                    </div>
                                                @else
                                                    <div class="tw-text-[#4A1B7F] tw-font-bold tw-text-2xl">
                                                        Rp {{ number_format($dt->price, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <button
                                                class="tw-w-full tw-bg-[#4A1B7F] tw-text-white tw-px-4 tw-py-2.5 tw-rounded-lg tw-text-sm hover:tw-bg-[#3A1560] tw-transition-colors">
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End of mainin tailwindcss --}}

    <section class="banner-post-area-five pt-50 pb-50">
        <div class="container">
            <div class="row mb-4">
                <div class="mb-5 col-md-12 col-sm-12  col-lg-4 wow zoomIn" data-wow-duration="2s">
                    <img src="{{ $halaman == null ? infodesa('logo') : Storage::url($halaman->foto_unggulan) }}"
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


    <section class="editor-post-area-three pt-30" style="padding: 30px">
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-12">
                    <div class="section-title-wrap mb-30">
                        <div class="section-title section-title-four">
                            <h2 class="title">FAQ</h2>
                            <div class="editor-nav-two"></div>
                        </div>
                        <div class="section-title-line"></div>
                    </div>
                </div>
            </div>
            <div class="row gutter-40">
                @if ($faq)
                    {!! nl2br($faq->deskripsi) !!}
                @endif
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

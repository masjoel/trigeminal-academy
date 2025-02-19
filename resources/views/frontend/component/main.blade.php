<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="title" content="{{ $title }}">
    <meta name="robots" content="index, follow" />
    <meta name="keywords" content="website desa, web desa" />
    <meta name="description" content="{{ klien('footnot') }}" />
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ klien('nama_client') }}">
    <meta property="og:description" content="{{ isset($posts->title) ? $posts->title : $title }}">
    <meta property="og:url" content="{{ url('') }}">
    <meta property="og:site_name" content="{{ klien('nama_client') }}">
    <meta property="og:image"
        content="{{ klien('logo') == 'image/logo-lkp2mpd.jpg' ? asset('image/logo-lkp2mpd.jpg') : Storage::url(klien('logo')) }}">
    <meta property="og:image:secure_url"
        content="{{ klien('logo') == 'image/logo-lkp2mpd.jpg' ? asset('image/logo-lkp2mpd.jpg') : Storage::url(klien('logo')) }}">
    <meta property="og:updated_time" content="{{ klien('updated_at') }}">
    <meta property="og:image:width" content="250">
    <meta property="og:image:height" content="250">
    <meta property="og:image:alt" content="{{ klien('nama_client') }}">
    <meta property="og:image:type" content="image/jpeg">
    <title>@yield('title')</title>

    <!-- Favicons -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ klien('image_icon') == 'image/icon-lkp2mpd.png' ? asset('image/icon-lkp2mpd.png') : Storage::url(klien('image_icon')) }}">
    <link
        href="{{ klien('image_icon') == 'image/icon-lkp2mpd.png' ? asset('image/icon-lkp2mpd.png') : Storage::url(klien('image_icon')) }}"
        rel="apple-touch-icon">

    <!-- CSS here -->
    @production
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        @endphp
        <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}">
        <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endproduction

    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">

    @stack('style')
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        p {
            text-transform: none !important;
        }

        #cart-icon {
            position: relative;
        }

        #cart-icon img {
            width: 30px;
            margin-right: 5px;
            margin-top: -24px;
        }

        .text-card-custom {
            color: #05a1a3;
        }

        .text-muted {
            color: white !important;
        }

        #item-count {
            position: absolute;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4796c;
            color: var(--tg-white);
            font-size: 11px;
            font-weight: 600;
            border-radius: 50%;
            right: 30px;
            top: -20px;
        }
        #item-count-2 {
            position: absolute;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4796c;
            color: var(--tg-white);
            font-size: 11px;
            font-weight: 600;
            border-radius: 50%;
            right: 0px;
            top: -20px;
        }

        .footer-widget .fw-title {
            font-weight: 300 !important;
            color: rgb(252, 248, 248) !important
        }

        .footer-content {
            font-weight: 300 !important;
            color: rgb(252, 248, 248) !important
        }

        .footer-link-wrap {
            font-weight: 300 !important;
            color: rgb(252, 248, 248) !important
        }

        .header-top-wrap-four {
            background: #4a2077 !important;
        }

        .footer-area {
            background: #4a2077 !important;
        }

        .footer-widget .fw-title::before {
            background: white !important;
        }

        /* a,
        button {
            color: white !important;
        } */
        button-lsm {
            color: white !important;
        }

        .scroll-top {
            color: var(--tg-white);
            background: rgb(148, 182, 240) !important;
        }

        .copyright-text p {
            color: white !important;
        }
        .footer-link-wrap .list-wrap li a {
            text-transform: none !important;
        }

    </style>

</head>

<body>
    <div id="preloader">
        <div class="loader-inner">
            <div id="loader">
                <h2 id="bg-loader">{{ klien('nama_client') }}</span></h2>
                <h2 id="fg-loader">{{ klien('nama_client') }}</span></h2>
            </div>
        </div>
    </div>
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up"></i>
    </button>


    @include('frontend.component.header')

    <main class="fix">
        @yield('main')
    </main>

    @include('frontend.component.footer')


    <!-- JS Files -->
    <script src="{{ asset('assets/frontend/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/swiper-bundle.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/ajax-form.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
    <script src="{{ asset('js/outlet.js') }}"></script>

    <!-- Template Main JS File -->
    <script>
        // let BASE_URL = "{{ url('/') }}";
        let BASE_URL = "http://{{ $_SERVER['HTTP_HOST'] }}";
    </script>
    @stack('scripts')

</body>

</html>

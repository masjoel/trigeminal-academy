<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-template="vertical-menu-template-no-customizer-starter" data-style="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>

    <link rel="shortcut icon"
        href="{{ preg_match('/profile/i', klien('image_icon')) ? Storage::url(klien('image_icon')) : asset(klien('image_icon')) }}"
        type="image/x-icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('v3/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('v3/fonts/fontawesome.css') }}" />

    @stack('style')
    <script src="{{ asset('v3/js/helpers.js') }}"></script>
    <script src="{{ asset('v3/assets/js/config.js') }}"></script>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-0">
                <div class="row">
                    <div class="{{ Request::is('auth-register') ? 'col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2' : 'col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4' }}">
                        @yield('main')
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('v3/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('v3/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('v3/js/bootstrap.js') }}"></script>
    <script src="{{ asset('v3/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('v3/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('v3/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('v3/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('v3/js/menu.js') }}"></script>
    <script src="{{ asset('library/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('v3/assets/js/main.js') }}"></script>
    @stack('scripts')

</body>

</html>

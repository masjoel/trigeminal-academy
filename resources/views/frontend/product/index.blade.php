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
    <style>
        .toast-notification {
            position: fixed;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 1000;
            transition: bottom 0.5s ease-in-out;
            opacity: 0;
            visibility: hidden;
        }

        .toast-notification.show {
            bottom: 24px;
            opacity: 1;
            visibility: visible;
        }
    </style>
@endpush
@section('title', $title)
@section('main')
    <section class="tw-py-8">
        <div class="tw-container tw-mx-auto tw-px-4">
            <!-- Search and Sort Area -->
            <div class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-p-6 tw-mb-8">
                <form method="GET" class="tw-flex tw-flex-col md:tw-flex-row tw-gap-4">
                    <div class="tw-flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kelas..."
                            class="tw-w-full tw-px-4 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-[#4A1B7F] focus:tw-ring-1 focus:tw-ring-[#4A1B7F]">
                    </div>
                    <div class="tw-flex tw-gap-4">
                        <select name="sort"
                            class="tw-px-4 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-[#4A1B7F] focus:tw-ring-1 focus:tw-ring-[#4A1B7F]">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Latest</option>
                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Oldest</option>
                            {{-- <option value="harga_terendah" {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>Harga
                                Terendah</option>
                            <option value="harga_tertinggi" {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>
                                Harga Tertinggi</option> --}}
                        </select>
                        <button type="submit"
                            class="tw-bg-[#4A1B7F] tw-text-white tw-px-6 tw-py-2 tw-rounded-lg hover:tw-bg-[#3A1560] tw-transition-colors">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-5 tw-gap-8">
                <!-- Category Sidebar -->
                <div class="tw-col-span-4 lg:tw-col-span-1">
                    <div class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-p-6 md:tw-sticky md:tw-top-8">
                        <h3 class="tw-text-xl tw-font-bold tw-mb-4">Category</h3>
                        <!-- Mengubah flex-col menjadi flex-row pada mobile dan tambahkan overflow -->
                        <div class="tw-flex tw-flex-row lg:tw-flex-col tw-gap-2 tw-overflow-x-auto tw-pb-2">
                            <a href="{{ route('list-kelas') }}"
                                class="tw-whitespace-nowrap tw-px-4 tw-py-2 tw-rounded-lg {{ !request('category') ? 'tw-bg-[#4A1B7F] tw-text-white' : 'tw-bg-gray-100 hover:tw-bg-gray-200' }}">
                                All Categories
                            </a>
                            @foreach ($categories as $category)
                                <a href="{{ route('list-kelas', ['category' => $category->id] + request()->except('category')) }}"
                                    class="tw-whitespace-nowrap tw-px-4 tw-py-2 tw-rounded-lg {{ request('category') == $category->id ? 'tw-bg-[#4A1B7F] tw-text-white' : 'tw-bg-gray-100 hover:tw-bg-gray-200' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Course Grid -->
                <div class="tw-col-span-4">
                    @if ($courses->isEmpty())
                        <div class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-p-8 tw-text-center">
                            <h3 class="tw-text-xl tw-font-bold tw-text-gray-800">No classes found</h3>
                            <p class="tw-text-gray-600 tw-mt-2">Try changing your search filters or keywords</p>
                        </div>
                    @else
                        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-8">
                            @foreach ($courses as $dt)
                                <div class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-overflow-hidden">
                                    <div class="tw-h-48">
                                        <img src="{{ $dt->image_url == null ? asset('img/example-image.jpg') : Storage::url('thumb/' . $dt->image_url) }}"
                                            alt="{{ $dt->name }}" class="tw-w-full tw-h-full tw-object-cover">
                                    </div>

                                    <div class="tw-p-6 tw-pt-6 tw-flex tw-flex-col tw-h-[calc(100%-192px)]">
                                        <div class="tw-mb-3">
                                            <span
                                                class="tw-bg-[#4A1B7F]/10 tw-text-[#4A1B7F] tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium"
                                                style="background-color: {{ $dt->productCategory->warna }}20; color: {{ $dt->productCategory->warna }};">
                                                {{ $dt->productCategory->name }}
                                            </span>
                                        </div>

                                        <h3 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-2">{{ $dt->name }}
                                        </h3>
                                        <p class="tw-text-gray-600 tw-mb-4 tw-line-clamp-2">{{ $dt->excerpt, 15 }}</p>

                                        <div class="tw-flex tw-flex-wrap tw-gap-4 tw-mb-4">
                                            <div class="tw-flex tw-items-center">
                                                <i class="flaticon-history tw-text-[#4A1B7F] tw-mr-2"></i>
                                                <span class="tw-text-sm tw-text-gray-600">{{ $dt->video_duration }}
                                                    Minute</span>
                                            </div>
                                            <div class="tw-flex tw-items-center">
                                                <i class="flaticon-user tw-text-[#4A1B7F] tw-mr-2"></i>
                                                <span class="tw-text-sm tw-text-gray-600">{{ $dt->orderitems->count() }}
                                                    Participant</span>
                                            </div>
                                            <div class="tw-flex tw-items-center">
                                                <i class="flaticon-thunder tw-text-[#4A1B7F] tw-mr-2"></i>
                                                <span class="tw-text-sm tw-text-gray-600">{{ ucwords($dt->level) }}</span>
                                            </div>
                                        </div>

                                        <div class="tw-mt-auto">
                                            @if ($dt->discount)
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

                                        {{-- <form action="{{ route('cart.add') }}" method="POST" class="tw-grid tw-grid-cols-2 tw-gap-2">
                                        @csrf
                                <input type="hidden" name="product_id" value="{{ $dt->id }}">
                                        <a href="{{ route('detail-kelas', $dt->slug) }}"
                                            class="tw-bg-gray-100 tw-text-gray-800 tw-px-4 tw-py-2.5 tw-rounded-lg tw-text-sm hover:tw-bg-gray-200 tw-transition-colors tw-text-center">
                                            <i class="flaticon-eye tw-mr-2"></i>
                                            Detail
                                        </a>
                                        <button type="submit" class="tw-bg-[#4A1B7F] tw-text-white tw-px-4 tw-py-2.5 tw-rounded-lg tw-text-sm hover:tw-bg-[#3A1560] tw-transition-colors">
                                            <i class="flaticon-shopping-cart tw-mr-2"></i>
                                            <span class="button-text">Beli</span>
                                        </button>
                                    </form> --}}
                                        <form action="{{ route('cart.add') }}" method="POST"
                                            class="tw-grid tw-grid-cols-2 tw-gap-2">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $dt->id }}">

                                            <div class="tw-col-span-2 tw-flex tw-items-center tw-space-x-2">
                                                <!-- Tombol minus -->
                                                <button type="button" onclick="decrementQty(this)"
                                                    class="tw-bg-gray-200 tw-text-gray-700 tw-px-3 tw-py-2 tw-rounded-lg hover:tw-bg-gray-300">
                                                    -
                                                </button>

                                                <!-- Input jumlah -->
                                                <input type="number" name="quantity" value="1" min="1"
                                                    class="tw-w-16 tw-text-center tw-border tw-rounded-lg tw-py-2 tw-px-1 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-purple-500" />

                                                <!-- Tombol plus -->
                                                <button type="button" onclick="incrementQty(this)"
                                                    class="tw-bg-gray-200 tw-text-gray-700 tw-px-3 tw-py-2 tw-rounded-lg hover:tw-bg-gray-300">
                                                    +
                                                </button>
                                            </div>

                                            <a href="{{ route('detail-kelas', $dt->slug) }}"
                                                class="tw-bg-gray-100 tw-text-gray-800 tw-px-4 tw-py-2.5 tw-rounded-lg tw-text-sm hover:tw-bg-gray-200 tw-transition-colors tw-text-center">
                                                <i class="flaticon-eye tw-mr-2"></i>
                                                Detail
                                            </a>

                                            <button type="submit"
                                                class="tw-bg-[#4A1B7F] tw-text-white tw-px-4 tw-py-2.5 tw-rounded-lg tw-text-sm hover:tw-bg-[#3A1560] tw-transition-colors">
                                                <i class="flaticon-shopping-cart tw-mr-2"></i>
                                                <span class="button-text">Buy</span>
                                            </button>
                                        </form>



                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="tw-mt-8">
                            {{ $courses->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="top-news-post-area pt-50">
        <div class="container">
        </div>
    </section>

    <div id="toast" class="toast-notification">
        <span id="toast-message"></span>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('js/frontend/lib.js') }}"></script>
    <script type="text/javascript" src="{{ asset('library/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('library/owl_carousel/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/frontend/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('v3/libs/leaflet/leaflet.min.js') }}"></script>
    <script>
        function incrementQty(el) {
            let input = el.parentElement.querySelector('input[name="quantity"]');
            input.value = parseInt(input.value) + 1;
        }

        function decrementQty(el) {
            let input = el.parentElement.querySelector('input[name="quantity"]');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
@endpush

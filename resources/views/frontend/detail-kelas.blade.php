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

    {{-- <div class="tw-bg-[#F7F7F7] tw-min-h-screen"> --}}
    <div class="tw-bg-white border-1 tw-min-h-screen">
        <div class="tw-container tw-mx-auto tw-px-4 tw-py-8">
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-8">
                <!-- Left Column - Image -->
                <div class="tw-bg-white tw-rounded-2xl tw-overflow-hidden tw-shadow-sm">
                    <img src="{{ Storage::url($course->image_url) }}" alt="{{ $course->name }}"
                        class="tw-w-full tw-aspect-[4/3] tw-h-full tw-object-cover">
                </div>

                <!-- Right Column - Product Info -->
                <div class="tw-space-y-6">
                    <!-- Category Badge -->
                    <div class="tw-space-y-2">
                        <span
                            class="tw-bg-purple-100 tw-text-[#4A1B7F] tw-px-4 tw-py-1.5 tw-rounded-full tw-text-sm tw-font-medium">
                            {{ $course->productCategory->name }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="tw-text-2xl md:tw-text-3xl tw-font-bold tw-text-gray-900">
                        {{ $course->name }}
                    </h1>

                    <!-- Price Section -->
                    <div class="tw-space-y-2">
                        @if ($course->discount)
                            <div class="tw-flex tw-items-center tw-gap-3">
                                <span
                                    class="tw-text-gray-500 tw-line-through tw-text-lg">Rp{{ number_format($course->price, 0, ',', '.') }}</span>
                                <span
                                    class="tw-bg-red-100 tw-text-red-600 tw-px-2 tw-py-1 tw-rounded tw-text-xs tw-font-medium">{{ $course->discount }}%
                                    OFF</span>
                            </div>
                            <div class="tw-text-[#4A1B7F] tw-font-bold tw-text-3xl">
                                Rp{{ number_format(($course->price * (100 - $course->discount)) / 100, 0, ',', '.') }}
                            </div>
                        @else
                            <div class="tw-text-[#4A1B7F] tw-font-bold tw-text-3xl">
                                Rp{{ number_format($course->price, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="tw-prose tw-max-w-none tw-text-gray-600">
                        {{ $course->excerpt }}
                    </div>

                    <!-- Action Buttons and Quantity -->
                    <div class="tw-space-y-4">
                        <div class="tw-flex tw-items-center tw-gap-3">
                            {{-- <div class="tw-w-32"> --}}
                                {{-- <button id="add-cart-button-{{ $course->id }}"
                                    onclick="handleAddToCart({{ json_encode([
                                        'id' => $course->id,
                                        'checkoutUrl' => route('class.process'),
                                    ]) }})"
                                    class="tw-w-full tw-border-2 tw-border-[#4A1B7F] tw-text-[#4A1B7F] tw-py-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#4A1B7F]/10 tw-transition-colors">
                                    <span class="cart-button-text">Add to Cart</span>
                                </button>  --}}
                            {{-- </div> --}}
                            <form action="{{ route('cart.add') }}" method="POST" class="tw-w-full">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $course->id }}">
                            <button type="submit" class="tw-w-full tw-flex-1 tw-bg-[#4A1B7F] tw-text-white tw-py-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#3A1560] tw-transition-colors">
                                Tambah ke Keranjang
                            </button>
                        </form>
                        </div>

                    </div>

                    <!-- Product Info Grid -->
                    <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-3 tw-gap-4 tw-border-t tw-border-gray-200 tw-pt-6">

                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Durasi</span>
                            <p class="tw-font-medium tw-text-gray-900">{{ $course->video_duration }} Menit</p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Peserta</span>
                            <p class="tw-font-medium tw-text-gray-900">{{ number_format($course->orderitems->count()) }}
                            </p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Level</span>
                            <p class="tw-font-medium tw-text-gray-900">{{ ucwords($course->level) }}</p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Bahasa</span>
                            <p class="tw-font-medium tw-text-gray-900">Indonesia</p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Materi</span>
                            <p class="tw-font-medium tw-text-gray-900">{{ $course->productContent->count() }}</p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Caption</span>
                            <p class="tw-font-medium tw-text-gray-900">Yes</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="tw-mt-12">
                <div class="tw-border-b tw-border-gray-200">
                    <nav class="tw-flex tw-space-x-8">
                        <button
                            class="tw-border-b-2 tw-border-[#4A1B7F] tw-py-4 tw-px-1 tw-text-sm tw-font-medium tw-text-[#4A1B7F]">
                            Description
                        </button>
                    </nav>
                </div>

                <div class="tw-prose tw-max-w-none tw-py-8">
                    {!! $course->description !!}

                </div>

                <div class="tw-border-b tw-border-gray-200">
                    <nav class="tw-flex tw-space-x-8">
                        <button
                            class="tw-border-b-2 tw-border-[#4A1B7F] tw-py-4 tw-px-1 tw-text-sm tw-font-medium tw-text-[#4A1B7F]">
                            Instructor
                        </button>
                    </nav>
                </div>

                <div class="tw-prose tw-max-w-none tw-py-8">
                    <div class="tw-flex tw-items-center tw-gap-4">
                        <img src="{{ Storage::url($course->instruktur->photo) }}" alt="{{ $course->instruktur->nama }}"
                            class="tw-w-16 tw-h-16 tw-rounded-full tw-object-cover">
                        <div>
                            <h3 class="tw-font-medium tw-text-lg">{{ $course->instruktur->nama }}</h3>
                            <p class="tw-text-gray-600">{{ $course->instruktur->keterangan }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

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

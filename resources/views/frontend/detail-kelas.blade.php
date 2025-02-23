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
    <section id="detail-class">
        <!-- Hero Section -->
        <div class="tw-relative tw-w-full tw-h-[300px] md:tw-h-[400px]">
            <img src="{{ Storage::url($course->image_url) }}" alt="Course Cover" class="tw-w-full tw-h-full tw-object-cover tw-opacity-50">
            <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-t tw-from-gray-900/80 tw-to-transparent"></div>

            <!-- Course Title & Category -->
            <div class="tw-absolute tw-bottom-0 tw-left-0 tw-right-0 tw-p-6 md:tw-p-10">
                <div class="tw-container tw-mx-auto">
                    <span
                        class="bg-{{ $course->productCategory->warna }} tw-text-white tw-px-4 tw-py-1.5 tw-rounded-full tw-text-sm tw-font-medium tw-mb-4 tw-inline-block">
                        {{ $course->productCategory->name }}
                    </span>
                    <h1 class="tw-text-2xl md:tw-text-4xl tw-font-bold tw-text-white tw-mb-2">
                        {{ $course->name }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Course Details -->
        <div class="tw-container tw-mx-auto tw-px-4 tw-py-8">
            <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-8">
                <div class="tw-col-span-2">
                    <!-- Course Stats -->
                    <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-4 tw-gap-4 tw-mb-8">
                        {{-- @foreach ([['Durasi', $course['duration']], ['Total Materi', $course['total_materials']], ['Peserta', "$course[participants]/$course[max_participants]"], ['Rating', "$course[rating]/5.0"]] as $stat) --}}
                            <div class="tw-bg-white tw-p-4 tw-rounded-xl tw-shadow-sm">
                                <p class="tw-text-sm tw-font-medium tw-text-[#4A1B7F]">Durasi</p>
                                <p class="tw-text-lg tw-font-bold tw-mt-1">{{ $course->video_duration }}</p>
                            </div>
                            <div class="tw-bg-white tw-p-4 tw-rounded-xl tw-shadow-sm">
                                <p class="tw-text-sm tw-font-medium tw-text-[#4A1B7F]">Level</p>
                                <p class="tw-text-lg tw-font-bold tw-mt-1">{{ ucwords($course->level) }}</p>
                            </div>
                            <div class="tw-bg-white tw-p-4 tw-rounded-xl tw-shadow-sm">
                                <p class="tw-text-sm tw-font-medium tw-text-[#4A1B7F]">Peserta</p>
                                <p class="tw-text-lg tw-font-bold tw-mt-1">{{ $totStudent }}</p>
                            </div>
                        {{-- @endforeach --}}
                    </div>

                    <!-- Course Description -->
                    <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-p-6 tw-mb-8">
                        <h2 class="tw-text-xl tw-font-bold tw-mb-4">Deskripsi Kelas</h2>
                        <p class="tw-text-gray-600 tw-mb-4">{{ $course->excerpt }}</p>
                        <p class="tw-text-gray-600">{!! nl2br($course->description) !!}</p>
                    </div>

                    <!-- What You'll Learn -->
                    <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-p-6">
                        <h2 class="tw-text-xl tw-font-bold tw-mb-4">Yang Akan Anda Pelajari</h2>
                        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-2 tw-gap-4">
                            {{-- @foreach ($course['lessons'] as $lesson)
                                <div class="tw-bg-gray-100 tw-rounded-xl tw-p-4 tw-flex tw-items-center tw-shadow-sm">
                                    <i class="{{ $lesson['icon'] }} tw-text-[#4A1B7F] tw-text-2xl tw-mr-3"></i>
                                    <span class="tw-font-medium">{{ $lesson['title'] }}</span>
                                </div>
                            @endforeach --}}
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="tw-col-span-1">
                    <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-p-6 tw-sticky tw-top-4">
                        @if ($course->discount)
                            <div class="tw-flex tw-items-center tw-gap-2 tw-mb-1">
                                <span class="tw-text-gray-500 tw-line-through">Rp
                                    {{ number_format($course->price) }}</span>
                                <span
                                    class="tw-bg-red-100 tw-text-red-600 tw-px-2 tw-py-1 tw-rounded tw-text-xs">{{ $course->discount }}%
                                    OFF</span>
                            </div>
                            <div class="tw-text-[#4A1B7F] tw-font-bold tw-text-3xl tw-mb-4">
                                Rp {{ number_format($course->price * (1 - $course->discount/100)) }}
                            </div>
                        @endif

                        <!-- Enrollment Progress -->
                        <div class="tw-mb-6">
                            <div class="tw-flex tw-justify-between tw-mb-2">
                                <span class="tw-text-sm tw-text-gray-600">Sisa Kuota</span>
                                <span class="tw-text-sm tw-font-medium">{{ $totStudent }} Peserta</span>
                            </div>
                            <div class="tw-w-full tw-bg-gray-200 tw-rounded-full tw-h-2">
                                <div class="tw-bg-[#4A1B7F] tw-h-2 tw-rounded-full"
                                    style="width: {{ $totStudent }}%"></div>
                            </div>
                        </div>

                        <!-- Quantity Select -->
                        <div class="tw-mb-6">
                            <label class="tw-block tw-text-sm tw-font-medium tw-mb-2">Jumlah Peserta</label>
                            <div class="tw-flex tw-items-center tw-border tw-rounded-lg tw-p-1">
                                <button
                                    class="tw-px-3 tw-py-1 tw-text-[#4A1B7F] tw-font-bold hover:tw-bg-[#4A1B7F]/10 tw-rounded">-</button>
                                <input type="number" value="1"
                                    class="tw-w-full tw-text-center tw-border-0 tw-focus:ring-0" readonly>
                                <button
                                    class="tw-px-3 tw-py-1 tw-text-[#4A1B7F] tw-font-bold hover:tw-bg-[#4A1B7F]/10 tw-rounded">+</button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="tw-space-y-3">
                            <button
                                class="tw-w-full tw-bg-[#4A1B7F] tw-text-white tw-py-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#3A1560] tw-transition-colors">
                                {{-- Beli Sekarang --}}
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $course->id }}">
                                    {{-- <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button> --}}
                                    <button type="submit"
                                        class="tw-w-full tw-border-2 tw-border-[#4A1B7F] tw-text-[#4A1B7F] tw-py-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#4A1B7F]/10 tw-transition-colors">
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                                
                            </button>
                        </div>
                    </div>
                </div>
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
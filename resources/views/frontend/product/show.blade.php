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
@php
$courseData = [
    'title' => 'Web Development Fundamentals',
    'category' => 'Web Development',
    'cover_image' => 'https://images.pexels.com/photos/1181671/pexels-photo-1181671.jpeg',
    'description' => 'Pelajari dasar-dasar pengembangan web modern dari awal hingga mahir dengan studi kasus yang komprehensif. Kelas ini dirancang untuk pemula yang ingin memulai karir sebagai web developer.',
    'skillLevel' => 'All Levels',
    'students' => 36500,
    'language' => 'English',
    'captions' => 'Yes',
    'lectures' => 19,
    'videoHours' => '1.5 total hours',
    'price' => 1500000,
    'discount' => 20,
    'remainingSlots' => 24,
    'instructor' => [
        'name' => 'Devonne Wallbridge',
        'role' => 'Web Developer, Designer, and Teacher',
        'image' => 'https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg'
    ]
];
@endphp

<section id="detail-class">
    <!-- Hero Section -->
    <div class="tw-relative tw-w-full tw-h-[300px] md:tw-h-[400px] tw-bg-gray-900">
        <img src="{{ Storage::url('thumb/',$course->image_url) }}" alt="Course Cover" class="tw-w-full tw-h-full tw-object-cover tw-opacity-50">
        <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-t tw-from-gray-900/80 tw-to-transparent"></div>

        <!-- Course Title & Category -->
        <div class="tw-absolute tw-bottom-0 tw-left-0 tw-right-0 tw-p-6 md:tw-p-10">
            <div class="tw-container tw-mx-auto">
                <span class="tw-bg-[#4A1B7F]/10 tw-text-white tw-px-4 tw-py-1.5 tw-rounded-full tw-text-sm tw-font-medium tw-mb-4 tw-inline-block">
                    {{ $course->productCategory->category }}
                </span>
                <h1 class="tw-text-2xl md:tw-text-4xl tw-font-bold tw-text-white tw-mb-2">
                    {{ $courseData['title'] }}
                </h1>
            </div>
        </div>
    </div>

    <!-- Course Details -->
    <div class="tw-container tw-mx-auto tw-px-4 tw-py-8">
        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-3 tw-gap-y-8 md:tw-gap-8">
            <!-- Main Content -->
            <div class="tw-col-span-2">
                <!-- Course Stats -->
                <div class="tw-space-y-3 tw-p-6 tw-mb-8 tw-grid tw-grid-cols-1 md:tw-grid-cols-2">
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <svg class="tw-w-5 tw-h-5 tw-text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="tw-text-gray-600">Skill level: {{ $courseData['skillLevel'] }}</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <svg class="tw-w-5 tw-h-5 tw-text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="tw-text-gray-600">Students: {{ number_format($courseData['students']) }}</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <svg class="tw-w-5 tw-h-5 tw-text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                        </svg>
                        <span class="tw-text-gray-600">Language: {{ $courseData['language'] }}</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <svg class="tw-w-5 tw-h-5 tw-text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <span class="tw-text-gray-600">Captions: {{ $courseData['captions'] }}</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <svg class="tw-w-5 tw-h-5 tw-text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span class="tw-text-gray-600">Lectures: {{ $courseData['lectures'] }}</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <svg class="tw-w-5 tw-h-5 tw-text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="tw-text-gray-600">Video: {{ $courseData['videoHours'] }}</span>
                    </div>
                </div>

                <!-- Course Description -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-p-6 tw-mb-8">
                    <h2 class="tw-text-xl tw-font-bold tw-mb-4">Deskripsi Kelas</h2>
                    <p class="tw-text-gray-600">
                        {{ $courseData['description'] }}
                    </p>
                </div>

                <!-- Instructor -->
                <div class="tw-bg-white tw-rounded-xl tw-shadow-sm tw-p-6">
                    <h2 class="tw-text-xl tw-font-bold tw-mb-4">Instructor</h2>
                    <div class="tw-flex tw-items-center tw-gap-4">
                        <img src="{{ $courseData['instructor']['image'] }}" alt="{{ $courseData['instructor']['name'] }}"
                             class="tw-w-16 tw-h-16 tw-rounded-full tw-object-cover">
                        <div>
                            <h3 class="tw-font-medium tw-text-lg">{{ $courseData['instructor']['name'] }}</h3>
                            <p class="tw-text-gray-600">{{ $courseData['instructor']['role'] }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="tw-col-span-1">
                <div class="tw-bg-white tw-rounded-xl tw-shadow-md tw-border tw-border-[#4A1B7F]-100 tw-p-6 tw-sticky tw-top-4">
                    <div class="tw-mb-6">
                        @if($courseData['discount'])
                            <div class="tw-flex tw-items-center tw-gap-2 tw-mb-1">
                                <span class="tw-text-gray-500 tw-line-through">Rp {{ number_format($courseData['price']) }}</span>
                                <span class="tw-bg-red-100 tw-text-red-600 tw-px-2 tw-py-1 tw-rounded tw-text-xs">{{ $courseData['discount'] }}% OFF</span>
                            </div>
                            <div class="tw-text-[#4A1B7F] tw-font-bold tw-text-3xl tw-mb-4">
                                Rp {{ number_format($courseData['price'] * (100 - $courseData['discount']) / 100) }}
                            </div>
                        @endif
                    </div>

                    <!-- Enrollment Progress -->
                    <div class="tw-mb-6">
                        <div class="tw-flex tw-justify-between tw-mb-2">
                            <span class="tw-text-sm tw-text-gray-600">Sisa Kuota</span>
                            <span class="tw-text-sm tw-font-medium">{{ $courseData['remainingSlots'] }} Peserta</span>
                        </div>
                        <div class="tw-w-full tw-bg-gray-200 tw-rounded-full tw-h-2">
                            <div class="tw-bg-[#4A1B7F] tw-h-2 tw-rounded-full" style="width: 84%"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="tw-space-y-3">
                        <button class="tw-w-full tw-bg-[#4A1B7F] tw-text-white tw-py-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#3A1560] tw-transition-colors">
                            Beli Sekarang
                        </button>
                        <button class="tw-w-full tw-border-2 tw-border-[#4A1B7F] tw-text-[#4A1B7F] tw-py-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#4A1B7F]/10 tw-transition-colors">
                            Tambah ke Keranjang
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

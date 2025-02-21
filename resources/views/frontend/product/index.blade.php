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
<section class="tw-py-8">
    <div class="tw-container tw-mx-auto tw-px-4">
        <!-- Search and Sort Area -->
        <div class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-p-6 tw-mb-8">
            <form method="GET" class="tw-flex tw-flex-col md:tw-flex-row tw-gap-4">
                <div class="tw-flex-1">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari kelas..."
                        class="tw-w-full tw-px-4 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-[#4A1B7F] focus:tw-ring-1 focus:tw-ring-[#4A1B7F]">
                </div>
                <div class="tw-flex tw-gap-4">
                    <select name="sort" class="tw-px-4 tw-py-2 tw-rounded-lg tw-border tw-border-gray-300 focus:tw-border-[#4A1B7F] focus:tw-ring-1 focus:tw-ring-[#4A1B7F]">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="harga_terendah" {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="harga_tertinggi" {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                    <button type="submit" class="tw-bg-[#4A1B7F] tw-text-white tw-px-6 tw-py-2 tw-rounded-lg hover:tw-bg-[#3A1560] tw-transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-5 tw-gap-8">
            <!-- Category Sidebar -->
            <div class="tw-col-span-4 lg:tw-col-span-1">
                <div class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-p-6 md:tw-sticky md:tw-top-8">
                    <h3 class="tw-text-xl tw-font-bold tw-mb-4">Kategori</h3>
                    <div class="tw-flex tw-flex-col tw-gap-2">
                        <a href="{{ route('product.index') }}"
                            class="tw-px-4 tw-py-2 tw-rounded-lg {{ !request('category') ? 'tw-bg-[#4A1B7F] tw-text-white' : 'tw-bg-gray-100 hover:tw-bg-gray-200' }}">
                            Semua Kategori
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('product.index', ['category' => $category->id] + request()->except('category')) }}"
                                class="tw-px-4 tw-py-2 tw-rounded-lg {{ request('category') == $category->id ? 'tw-bg-[#4A1B7F] tw-text-white' : 'tw-bg-gray-100 hover:tw-bg-gray-200' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Course Grid -->
            <div class="tw-col-span-4">
                @if($courses->isEmpty())
                    <div class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-p-8 tw-text-center">
                        <h3 class="tw-text-xl tw-font-bold tw-text-gray-800">Tidak ada kelas yang ditemukan</h3>
                        <p class="tw-text-gray-600 tw-mt-2">Coba ubah filter atau kata kunci pencarian Anda</p>
                    </div>
                @else
                    <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-4 tw-gap-6">
                        @foreach($courses as $dt)
                            <div class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-overflow-hidden">
                                <div class="tw-h-48">
                                    {{-- <img src="#" --}}
                                    <img src="https://picsum.photos/1200/1200?random={{ $dt->id }}"
                                        alt="{{ $dt->name }}"
                                        class="tw-w-full tw-h-full tw-object-cover">
                                </div>

                                <div class="tw-p-6">
                                    <div class="tw-mb-3">
                                        <span class="tw-bg-[#4A1B7F]/10 tw-text-[#4A1B7F] tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium">
                                            {{ $dt->productCategory->name }}
                                        </span>
                                    </div>

                                    <h3 class="tw-text-xl tw-font-bold tw-text-gray-800 tw-mb-2">{{ $dt->name }}</h3>
                                    <p class="tw-text-gray-600 tw-mb-4 tw-line-clamp-2">{{ Str::words($dt->description, 15, '...') }}</p>

                                    <div class="tw-grid tw-grid-cols-2 tw-gap-4 tw-mb-4">
                                        <div class="tw-flex tw-items-center">
                                            <i class="flaticon-history tw-text-[#4A1B7F] tw-mr-2"></i>
                                            <span class="tw-text-sm tw-text-gray-600">{{ $dt->video_duration }} Jam</span>
                                        </div>
                                        <div class="tw-flex tw-items-center">
                                            <i class="flaticon-document tw-text-[#4A1B7F] tw-mr-2"></i>
                                            <span class="tw-text-sm tw-text-gray-600">{{ $dt->productContent->count() }} Materi</span>
                                        </div>
                                    </div>

                                    <div class="tw-mb-4">
                                        @if($dt->discount)
                                            <div class="tw-flex tw-items-center tw-gap-2 tw-mb-1">
                                                <span class="tw-text-gray-500 tw-line-through">Rp {{ number_format($dt->price, 0, ',', '.') }}</span>
                                                <span class="tw-bg-red-100 tw-text-red-600 tw-px-2 tw-py-1 tw-rounded tw-text-xs">{{ $dt->discount }}% OFF</span>
                                            </div>
                                            <div class="tw-text-[#4A1B7F] tw-font-bold tw-text-2xl">
                                                Rp {{ number_format($dt->price * (1 - $dt->discount/100), 0, ',', '.') }}
                                            </div>
                                        @else
                                            <div class="tw-text-[#4A1B7F] tw-font-bold tw-text-2xl">
                                                Rp {{ number_format($dt->price, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="tw-grid tw-grid-cols-2 tw-gap-2">
                                        <a href="{{ route('product.show', $dt->slug) }}"
                                            class="tw-bg-gray-100 tw-text-gray-800 tw-px-4 tw-py-2.5 tw-rounded-lg tw-text-sm hover:tw-bg-gray-200 tw-transition-colors tw-text-center">
                                            <i class="flaticon-eye tw-mr-2"></i>
                                            Lihat Detail
                                        </a>
                                        <button
                                            onclick="addToCart({{ json_encode([
                                                'id' => $dt->id,
                                                'name' => $dt->name,
                                                'price' => $dt->discount ? $dt->price * (1 - $dt->discount/100) : $dt->price,
                                                'image' => "https://picsum.photos/1200/1200?random={$dt->id}"
                                            ]) }})"
                                            class="tw-bg-[#4A1B7F] tw-text-white tw-px-4 tw-py-2.5 tw-rounded-lg tw-text-sm hover:tw-bg-[#3A1560] tw-transition-colors">
                                            <i class="flaticon-shopping-cart tw-mr-2"></i>
                                            Beli Sekarang
                                        </button>
                                    </div>
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
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('js/frontend/lib.js') }}"></script>
    <script type="text/javascript" src="{{ asset('library/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('library/owl_carousel/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/frontend/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('v3/libs/leaflet/leaflet.min.js') }}"></script>
    <script>
        function addToCart(product) {
            let cart = JSON.parse(sessionStorage.getItem('cart') || '[]');

            // Check if product already exists in cart
            const existingProductIndex = cart.findIndex(item => item.id === product.id);

            if (existingProductIndex > -1) {
                cart[existingProductIndex].quantity = (cart[existingProductIndex].quantity || 1) + 1;
            } else {
                cart.push({
                    ...product,
                    quantity: 1
                });
            }

            sessionStorage.setItem('cart', JSON.stringify(cart));

            // Show notification
            alert('Produk berhasil ditambahkan ke keranjang!');
        }
        </script>
@endpush

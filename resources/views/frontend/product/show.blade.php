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
    <div id="toast" class="toast-notification">
        <span id="toast-message"></span>
    </div>

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
                            <div class="tw-w-32">
                                <button id="add-cart-button-{{ $course->id }}"
                                    onclick="handleAddToCart({{ json_encode([
                                        'id' => $course->id,
                                        'checkoutUrl' => route('class.process'),
                                    ]) }})"
                                    class="tw-w-full tw-border-2 tw-border-[#4A1B7F] tw-text-[#4A1B7F] tw-py-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#4A1B7F]/10 tw-transition-colors">
                                    <span class="cart-button-text">TAKE A SEAT</span>
                                </button>
                            </div>
                            <button id="buy-now-button-{{ $course->id }}"
                                onclick="handleBuyNow({{ json_encode([
                                    'id' => $course->id,
                                    'checkoutUrl' => route('class.process'),
                                ]) }})"
                                class="tw-flex-1 tw-bg-[#4A1B7F] tw-text-white tw-py-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#3A1560] tw-transition-colors">
                                TAKE A SEAT
                            </button>
                        </div>

                    </div>

                    <!-- Product Info Grid -->
                    <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-3 tw-gap-4 tw-border-t tw-border-gray-200 tw-pt-6">
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Level</span>
                            <p class="tw-font-medium tw-text-gray-900">{{ ucwords($course->level) }}</p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Member</span>
                            <p class="tw-font-medium tw-text-gray-900">{{ number_format($course->orderitems->count()) }}
                            </p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Language</span>
                            <p class="tw-font-medium tw-text-gray-900">Indonesia</p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Lectures</span>
                            <p class="tw-font-medium tw-text-gray-900">{{ $course->productContent->count() }}</p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Duration</span>
                            <p class="tw-font-medium tw-text-gray-900">{{ $course->video_duration }} Minutes</p>
                        </div>
                        <div>
                            <span class="tw-text-sm tw-text-gray-500">Captions</span>
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
            let toastTimeout;

            function showToast(message, duration = 3000) {
                const toast = document.getElementById('toast');
                const toastMessage = document.getElementById('toast-message');

                clearTimeout(toastTimeout);
                toast.classList.remove('show');
                void toast.offsetWidth;

                toastMessage.textContent = message;
                toast.classList.add('show');

                toastTimeout = setTimeout(() => {
                    toast.classList.remove('show');
                }, duration);
            }

            function updateCartCount() {
                const cart = JSON.parse(localStorage.getItem('cart') || '[]');
                const totalItems = cart.length;
                document.querySelector('#keranjang-belanja-data span').textContent = totalItems;
            }

            function checkProductInCart(productId) {
                const cart = JSON.parse(localStorage.getItem('cart') || '[]');
                return cart.some(item => item.id === productId);
            }

            function updateButtonStates(productId, isInCart) {
                const addCartButton = document.getElementById(`add-cart-button-${productId}`);
                const buyNowButton = document.getElementById(`buy-now-button-${productId}`);

                if (isInCart) {
                    if (addCartButton) {
                        const cartButtonText = addCartButton.querySelector('.cart-button-text');
                        cartButtonText.textContent = 'Checkout';
                        addCartButton.onclick = () => window.location.href = '{{ route('class.process') }}';
                    }
                }
            }

            function handleAddToCart(product) {
                if (checkProductInCart(product.id)) {
                    window.location.href = product.checkoutUrl;
                    return;
                }

                let cart = JSON.parse(localStorage.getItem('cart') || '[]');
                cart.push({
                    ...product,
                    quantity: 1
                });

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                showToast('Product successfully added to cart!');
                updateButtonStates(product.id, true);
            }

            function handleBuyNow(product) {
                if (!checkProductInCart(product.id)) {
                    let cart = JSON.parse(localStorage.getItem('cart') || '[]');
                    cart.push({
                        ...product,
                        quantity: 1
                    });
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartCount();
                }
                window.location.href = product.checkoutUrl;
            }

            // Initialize cart state when page loads
            updateCartCount();
            document.addEventListener('DOMContentLoaded', function() {

                // Check product status in cart
                const cart = JSON.parse(localStorage.getItem('cart') || '[]');
                cart.forEach(item => {
                    updateButtonStates(item.id, true);
                });

                // Check current product
                const currentProductId = {{ $course->id }};
                if (checkProductInCart(currentProductId)) {
                    updateButtonStates(currentProductId, true);
                }
            });
        </script>
    @endpush

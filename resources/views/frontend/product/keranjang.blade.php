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
    <form id="cart-form" method="POST" action="{{ route('keranjang') }}">
        @csrf
        <input type="hidden" name="cart_items" id="cart-items">
    </form>

    <div class="tw-container tw-mx-auto tw-px-4 tw-py-8">
        <div class="tw-bg-white tw-rounded-xl tw-shadow-lg tw-p-6">
            <h1 class="tw-text-2xl tw-font-bold tw-mb-6">Keranjang Belanja</h1>

            <form id="checkout-form" method="POST" action="#">
                @csrf
                <input type="hidden" name="selected_items" id="selected-items">

                @if ($courses->isEmpty())
                    <div class="tw-text-center tw-py-8">
                        <p class="tw-text-gray-600">Keranjang belanja Anda masih kosong.</p>
                        <a href="{{ route('product.index') }}"
                            class="tw-inline-block tw-mt-4 tw-bg-[#4A1B7F] tw-text-white tw-px-6 tw-py-2 tw-rounded-lg hover:tw-bg-[#3A1560] tw-transition-colors">
                            Lihat Kelas
                        </a>
                    </div>
                @else
                    <div class="tw-flex tw-flex-col md:tw-flex-row tw-gap-6">
                        <div class="tw-flex-1">
                            <table class="tw-w-full">
                                <thead>
                                    <tr class="tw-border-b">
                                        <th class="tw-p-3 tw-text-left">
                                            <label class="tw-flex tw-items-center">
                                                <input type="checkbox" id="select-all" checked
                                                    class="tw-rounded tw-border-gray-300 tw-text-[#4A1B7F] focus:tw-ring-[#4A1B7F]">
                                                <span class="tw-ml-2 tw-text-sm">Pilih Semua</span>
                                            </label>
                                        </th>
                                        <th class="tw-p-3 tw-text-left">Kelas</th>
                                        <th class="tw-p-3 tw-text-right">Harga</th>
                                        <th class="tw-p-3 tw-text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $product)
                                        <tr class="tw-border-b" data-product-id="{{ $product->id }}">
                                            <td class="tw-p-3">
                                                <input type="checkbox"
                                                    class="product-checkbox tw-rounded tw-border-gray-300 tw-text-[#4A1B7F] focus:tw-ring-[#4A1B7F]"
                                                    value="{{ $product->id }}" checked>
                                            </td>
                                            <td class="tw-p-3">
                                                <div class="tw-flex tw-items-center tw-gap-3">
                                                    <img src="{{ Storage::url('thumb/' . $product->image_url) }}"
                                                        alt="{{ $product->name }}"
                                                        class="tw-w-12 tw-h-12 tw-rounded-lg tw-object-cover">
                                                    <div>
                                                        <h3 class="tw-font-medium tw-text-sm">{{ $product->name }}</h3>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tw-p-3 tw-text-right">
                                                @if ($product->discount)
                                                    <div class="tw-flex tw-flex-col tw-items-end">
                                                        <span class="tw-text-xs tw-text-gray-500 tw-line-through">Rp
                                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                                        <span class="tw-text-sm tw-font-bold">Rp
                                                            {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }}</span>
                                                    </div>
                                                @else
                                                    <span class="tw-text-sm tw-font-bold">Rp
                                                        {{ number_format($product->price, 0, ',', '.') }}</span>
                                                @endif
                                            </td>
                                            <td class="tw-p-3 tw-text-center">
                                                <button type="button"
                                                    onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')"
                                                    class="tw-text-sm tw-text-red-600 hover:tw-text-red-800 tw-transition-colors">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="md:tw-w-80">
                            <div class="tw-bg-gray-50 tw-rounded-lg tw-p-4">
                                <h3 class="tw-font-bold tw-mb-4">Ringkasan Pesanan</h3>
                                <div class="tw-flex tw-justify-between tw-mb-4">
                                    <span class="tw-text-gray-600">Total</span>
                                    <span id="total-price" class="tw-font-bold tw-text-[#4A1B7F]">Rp 0</span>
                                </div>
                                <button type="submit" id="checkout-button"
                                    class="tw-w-full tw-bg-[#4A1B7F] tw-text-white tw-px-4 tw-py-2 tw-rounded-lg hover:tw-bg-[#3A1560] tw-transition-colors disabled:tw-opacity-50 disabled:tw-cursor-not-allowed">
                                    Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div id="delete-modal" class="tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-hidden">
        <div class="tw-bg-white tw-rounded-xl tw-p-6 tw-max-w-sm tw-w-full tw-mx-4">
            <h3 class="tw-text-lg tw-font-bold tw-mb-2">Konfirmasi Hapus</h3>
            <p id="delete-message" class="tw-text-gray-600 tw-mb-6"></p>
            <div class="tw-flex tw-justify-end tw-gap-3">
                <button onclick="closeDeleteModal()"
                    class="tw-px-4 tw-py-2 tw-text-gray-600 hover:tw-text-gray-800 tw-transition-colors">
                    Batal
                </button>
                <button id="confirm-delete-btn"
                    class="tw-bg-red-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg hover:tw-bg-red-700 tw-transition-colors">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <div id="toast" class="toast-notification">
        <span id="toast-message"></span>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cart = localStorage.getItem('cart');
            let cartItems = [];

            if (cart) {
                try {
                    cartItems = JSON.parse(cart);
                    if (!Array.isArray(cartItems)) {
                        cartItems = [];
                    }
                } catch (e) {
                    cartItems = [];
                }
            }

            let cartIds = cartItems.map(item => item.id);
            document.getElementById('cart-items').value = JSON.stringify(cartIds);

            if (cartIds.length > 0 && !sessionStorage.getItem('cartSubmitted')) {
                sessionStorage.setItem('cartSubmitted', 'true');
                document.getElementById('cart-form').submit();
            } else {
                sessionStorage.removeItem('cartSubmitted');
            }
        });
    </script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const checkoutForm = document.getElementById('checkout-form');
            const selectedItemsInput = document.getElementById('selected-items');
            const deleteModal = document.getElementById('delete-modal');

            function updateTotalPrice() {
                let total = 0;
                productCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        const priceEl = row.querySelector('td:nth-child(3)');
                        const price = priceEl.querySelector('.tw-line-through') ?
                            parseFloat(priceEl.querySelector('.tw-font-bold').textContent.replace(/[^0-9]/g,
                                '')) :
                            parseFloat(priceEl.textContent.replace(/[^0-9]/g, ''));
                        total += price;
                    }
                });

                document.getElementById('total-price').textContent =
                    'Rp ' + total.toLocaleString('id-ID');

                const checkoutButton = document.getElementById('checkout-button');
                checkoutButton.disabled = !Array.from(productCheckboxes).some(cb => cb.checked);
            }

            function updateSelectedItems() {
                const selectedIds = Array.from(productCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
                selectedItemsInput.value = JSON.stringify(selectedIds);
            }

            function showToast(message, duration = 3000) {
                const toast = document.getElementById('toast');
                const toastMessage = document.getElementById('toast-message');

                clearTimeout(window.toastTimeout);
                toast.classList.remove('show');
                void toast.offsetWidth;

                toastMessage.textContent = message;
                toast.classList.add('show');

                window.toastTimeout = setTimeout(() => {
                    toast.classList.remove('show');
                }, duration);
            }

            selectAll?.addEventListener('change', function() {
                productCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateTotalPrice();
                updateSelectedItems();
            });

            productCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
                    if (selectAll) selectAll.checked = allChecked;
                    updateTotalPrice();
                    updateSelectedItems();
                });
            });

            updateTotalPrice();
            updateSelectedItems();

            window.confirmDelete = function(productId, productName) {
                const message = document.getElementById('delete-message');
                message.textContent = `Apakah Anda yakin ingin menghapus "${productName}" dari keranjang?`;

                const confirmBtn = document.getElementById('confirm-delete-btn');
                confirmBtn.onclick = () => removeFromCart(productId);

                deleteModal.classList.remove('tw-hidden');
            };

            window.closeDeleteModal = function() {
                deleteModal.classList.add('tw-hidden');
            };

            window.removeFromCart = function(productId) {
                const cart = JSON.parse(localStorage.getItem('cart') || '[]');
                const updatedCart = cart.filter(item => item.id !== productId);
                localStorage.setItem('cart', JSON.stringify(updatedCart));

                const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                if (row) {
                    row.remove();
                    updateTotalPrice();
                    updateSelectedItems();
                    showToast('Produk berhasil dihapus dari keranjang');
                    closeDeleteModal();

                    const cartCount = document.querySelector('#keranjang-belanja-data span');
                    if (cartCount) {
                        cartCount.textContent = updatedCart.length;
                    }

                    if (updatedCart.length === 0) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                }
            };

            checkoutForm?.addEventListener('submit', function(e) {
                e.preventDefault();
                const selectedIds = JSON.parse(selectedItemsInput.value);
                if (selectedIds.length === 0) {
                    showToast('Pilih minimal satu produk untuk checkout');
                    return;
                }
                this.submit();
            });

            deleteModal?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });
        });
    </script>
@endpush

@extends('frontend.webdesa.main')
@push('style')
    <style>
        .page-item.active .page-link {
            background-color: #197e85 !important;
            border-color: #197e85 !important;
            color: white !important;
        }

        .page-link {
            color: #197e85 !important;
        }
    </style>
@endpush
@section('title', $title)
@section('main')
    @include('pages.lapak-desa.breadcrumb')
    <section class="about-area pt-0 pb-80">
        <div class="container">
            <div class="about-content">
                <section class="latest-post-area pt-30 pb-60">
                    <div class="container">
                        <div class="latest-post-inner-wrap">
                            <div class="row">
                                <div class="col-70">
                                    <div class="section-title-wrap mb-30">
                                        <div class="section-title">
                                            <h2 class="title">{{ $product->name }}</h2>
                                        </div>
                                        <div class="section-title-line"></div>
                                    </div>
                                    <div class="latest-post-item-wrap">
                                        <div class="row">
                                            <div class="col-66">
                                                <div class="featured-post-item latest-post-item big-post">
                                                    <div class="featured-post-thumb">
                                                        <img src="{{ $product->image_url == 'nophoto.jpg' || $product->image_url == null ? asset('img/example-image.jpg') : Storage::url($product->image_url) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="featured-post-content">
                                                        <span class="post-tag">{{ $product->lapakCategory->name }}</span>
                                                        <h2 class="post-title bold-underline">{{ $product->name }}</h2>
                                                        <div class="blog-post-meta">
                                                            {{-- <ul class="list-wrap">
                                                                <li><i class="flaticon-user"></i>by<a
                                                                        href="author.html">Admin</a></li>
                                                                <li><i class="flaticon-calendar"></i>27 August, 2024</li>
                                                                <li><i class="flaticon-history"></i>20 Mins</li>
                                                            </ul> --}}
                                                            <div class="post-price text-danger mb-3">Rp.
                                                                {{ number_format($product->price) }}</div>
                                                            <div class="row mb-3">
                                                                <div class="col-12" style="text-align: center">
                                                                    <button class="btn p-2" onclick="showOrderDetails()"
                                                                        style="margin-right: 20px; background-color: #197e85"><i
                                                                            class="fas fa-shopping-cart"></i></button>
                                                                    <button class="btn p-2 bg-secondary"
                                                                        onclick="removeItemFromCart({{ $product->id }})"><i
                                                                            class="fas fa-minus"></i></button>
                                                                    <button
                                                                        class="btn btn-block p-2 btn-outline-warning text-dark"
                                                                        id="item-qty_{{ $product->id }}"
                                                                        disabled>0</button>
                                                                    <button class=" btn p-2 bg-secondary"
                                                                        onclick="addItemToCart({{ $product->id }})"><i
                                                                            class="fas fa-plus"></i></button>
                                                                    {{-- </div>
                                                                </div> --}}

                                                                    <input type="hidden" value="{{ $product->name }}"
                                                                        id="item-names_{{ $product->id }}">
                                                                    <input type="hidden" value="{{ $product->price }}"
                                                                        id="item-prices_{{ $product->id }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p style="text-align: left">{{ $product->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-34">
                                                <div class="latest-post-wrap">
                                                    <div class="featured-post-item latest-post-item small-post">
                                                        <div class="featured-post-thumb">
                                                            <a href="#"><img src="{{ asset('img/example-image.jpg') }}"
                                                                    alt=""></a>
                                                        </div>
                                                        <div class="featured-post-content">
                                                            <a href="#" class="post-tag">Breakfast</a>
                                                            <h2 class="post-title"><a href="#">The Potentially
                                                                    Dangerous Non-Accessibility Of Cookie</a>
                                                            </h2>
                                                            <div class="blog-post-meta">
                                                                <ul class="list-wrap">
                                                                    <li><i class="flaticon-user"></i>by<a
                                                                            href="author.html">Admin</a></li>
                                                                    <li><i class="flaticon-calendar"></i>27 August, 2024
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="featured-post-item latest-post-item small-post">
                                                        <div class="featured-post-thumb">
                                                            <a href="#"><img src="{{ asset('img/example-image.jpg') }}"
                                                                    alt=""></a>
                                                        </div>
                                                        <div class="featured-post-content">
                                                            <a href="#" class="post-tag">Lunch</a>
                                                            <h2 class="post-title"><a href="#">One-pan baked sausage
                                                                    and lentils</a></h2>
                                                            <div class="blog-post-meta">
                                                                <ul class="list-wrap">
                                                                    <li><i class="flaticon-user"></i>by<a
                                                                            href="author.html">Admin</a></li>
                                                                    <li><i class="flaticon-calendar"></i>27 August, 2024
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-30">
                                    @if ($product->lapakSuplier !== null)
                                        <div class="sidebar-wrap">
                                            <div class="sidebar-widget">
                                                <div class="sidebar-avatar">
                                                    <div class="sidebar-avatar-thumb">
                                                        <img src="{{ $product->lapakSuplier->photo == null ? asset('img/example-image.jpg') : Storage::url($product->lapakSuplier->photo) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="sidebar-avatar-content">
                                                        <h2 class="title">Hai, saya
                                                            {{ Str::title($product->lapakSuplier->nama) }}!</h2>
                                                        @if ($product->lapakSuplier->nama_usaha != null)
                                                            <p>{{ $product->lapakSuplier->nama_usaha }}</p>
                                                            <hr>
                                                        @endif
                                                        @if ($product->lapakSuplier->keterangan == null)
                                                            <p>Terimakasih telah melihat produk yang kami jual di Lapak Desa
                                                                -
                                                                {{ klien('nama_client') }}</p>
                                                        @else
                                                            <p>{!! nl2br($product->lapakSuplier->keterangan) !!}</p>
                                                        @endif
                                                        <div class="avatar-social">
                                                            <ul class="list-wrap">
                                                                @if (Str::length($product->lapakSuplier->telpon) > 10 && Str::length($product->lapakSuplier->telpon) < 13)
                                                                    <li><a href="http://wa.me/62{{ $product->lapakSuplier->telpon }}"
                                                                            target="_blank"
                                                                            style="background-color: #25D366"><i
                                                                                class="fab fa-whatsapp"></i></a></li>
                                                                @endif
                                                                {{-- <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                                            <li><a href="#"><i class="fab fa-youtube"></i></a></li> --}}
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="sidebar-avatar-shape">
                                                        <img src="/assets/webdesa/img/images/avatar_shape01.png" alt="">
                                                        <img src="/assets/webdesa/img/images/avatar_shape02.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="sidebar-widget">
                                            <div class="widget-title mb-25">
                                                <h2 class="title">Subscribe & Followers</h2>
                                                <div class="section-title-line"></div>
                                            </div>
                                            <div class="sidebar-social-wrap">
                                                <ul class="list-wrap">
                                                    <li><a href="#"><i class="fab fa-facebook-f"></i>facebook</a></li>
                                                    <li><a href="#"><i class="fab fa-twitter"></i>twitter</a></li>
                                                    <li><a href="#"><i class="fab fa-instagram"></i>instagram</a></li>
                                                    <li><a href="#"><i class="fab fa-youtube"></i>youtube</a></li>
                                                    <li><a href="#"><i class="fab fa-linkedin-in"></i>LinkedIn</a>
                                                    </li>
                                                    <li><a href="#"><i class="fab fa-pinterest-p"></i>Pinterest</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div> --}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function showOrderDetails() {
            var orderDetails = {
                itemQty: itemQty,
                itemPrices: itemPrices,
                itemNames: itemNames,
            };
            localStorage.setItem('orderDetails', JSON.stringify(orderDetails));
            window.location.href = "{{ route('cart') }}";
        }
    </script>
@endpush

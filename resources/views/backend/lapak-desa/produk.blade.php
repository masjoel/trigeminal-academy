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
    <section class="about-area pt-20 pb-80">
        <div class="container">
            <div class="about-content">
                <div class="mb-0">
                    <form method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name='search' class="form-control" placeholder="cari...">
                            <div class="input-group-append">
                                <button class="btn bg-success"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="clearfix mb-0"></div>
                <div class="col-12" style="display:flex; overflow: auto;">
                    @foreach ($categories as $index => $item)
                        <div class="p-2">
                            <form method="POST">
                                @csrf
                                <input type="hidden" value="{{ $item->name }}" name="search">
                                <button class="btn bg-secondary p-2 text-white">{{ $item->name }}&nbsp;&nbsp; <i
                                        class="fas fa-circle text-warning"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
                <div class="clearfix mb-3"></div>
                <section class="healthy-area pt-10 pb-30">
                    <div class="container">
                        <div class="healthy-inner-wrap">
                            <div class="row">
                                <div class="col-70">
                                    <div class="section-title-wrap mb-30">
                                        <div class="section-title">
                                            <h2 class="title">Produk Desa</h2>
                                        </div>
                                        <div class="section-title-line"></div>
                                    </div>
                                    <div class="row">
                                        @foreach ($products as $item)
                                            <div class="col-lg-4 col-md-6 col-sm-6">
                                                <div class="featured-post-item healthy-post">
                                                    <div class="featured-post-thumb">
                                                        <a href="{{ url('lapak-desa/detail-produk/' . $item->slug) }}"><img
                                                                src="{{ $item->image_url == 'nophoto.jpg' || $item->image_url == null ? asset('img/example-image.jpg') : Storage::url('thumb/' . $item['image_url']) }}"
                                                                class="img-fluid" alt="{{ $item->name }}"></a>
                                                    </div>
                                                    <div class="featured-post-content">
                                                        <span class="post-tag"
                                                            style="text-transform: none; letter-spacing: 0px;">Rp.
                                                            {{ number_format($item->price) }}</span>
                                                        <h2 class="post-title"><a
                                                                href="{{ url('lapak-desa/detail-produk/' . $item->slug) }}">{{ $item->name }}</a></h2>
                                                        <div class="blog-post-meta pt-3">
                                                            <div class="row">
                                                                <div class="col-12" style="text-align: center">
                                                                    <button class="btn p-2" onclick="showOrderDetails()"
                                                                        style="margin-right: 10px; background-color: #197e85"><i
                                                                            class="fas fa-shopping-cart"></i></button>
                                                                {{-- </div>
                                                                <div class="col-6 pr-2"> --}}
                                                                    {{-- <div class="d-flex justify-content-between"> --}}
                                                                        <button class="btn p-2 bg-secondary"
                                                                            onclick="removeItemFromCart({{ $item->id }})"><i
                                                                                class="fas fa-minus"></i></button>
                                                                        <button
                                                                            class="btn btn-block p-2 btn-outline-warning text-dark"
                                                                            id="item-qty_{{ $item->id }}"
                                                                            disabled>0</button>
                                                                        <button class=" btn p-2 bg-secondary"
                                                                            onclick="addItemToCart({{ $item->id }})"><i
                                                                                class="fas fa-plus"></i></button>
                                                                    {{-- </div> --}}
                                                                </div>

                                                                <input type="hidden" value="{{ $item->name }}"
                                                                    id="item-names_{{ $item->id }}">
                                                                <input type="hidden" value="{{ $item->price }}"
                                                                    id="item-prices_{{ $item->id }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-12">
                                        <div class="mt-3" style="float: right">
                                            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-30">
                                    <div class="sidebar-wrap no-sticky">
                                        <div class="sidebar-widget">
                                            <div class="widget-title mb-25">
                                                <h2 class="title">Banyak dicari</h2>
                                                <div class="section-title-line"></div>
                                            </div>
                                            <div class="popular-post-wrap">
                                                @foreach ($terlaris as $item)
                                                    <div class="popular-post">
                                                        <div class="thumb">
                                                            <a href="{{ url('lapak-desa/detail-produk/' . $item->slug) }}"><img
                                                                    src="{{ $item->image_url == 'nophoto.jpg' ? asset('img/example-image.jpg') : Storage::url('thumb/' . $item['image_url']) }}"
                                                                    alt=""></a>
                                                        </div>
                                                        <div class="content">
                                                            <span class="post-tag-two">{{ $item->category }}</span>
                                                            <h2 class="post-title"><a
                                                                    href="{{ url('lapak-desa/detail-produk/' . $item->slug) }}">{{ $item->name }}</a></h2>
                                                            <div class="blog-post-meta">
                                                                <ul class="list-wrap">
                                                                    <li style="text-transform: none; font-weight: 300">
                                                                        Rp.{{ number_format($item->price) }}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
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
    {{-- <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script> --}}
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

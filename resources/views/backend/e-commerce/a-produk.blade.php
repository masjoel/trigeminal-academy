@extends('frontend.webdesa.main')
@section('title', $title)
@push('style')
@endpush

@section('main')
    <form method="POST" class="my-3">
        @csrf
        <div class="input-group">
            <input type="text" name='search' class="form-control p-4" placeholder="cari...">
            <div class="input-group-append">
                <button class="btn btn-warning"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12" style="display:flex; overflow: auto;">
            @foreach ($categories as $index => $item)
                <div class="p-2">
                    <div class="card mb-3" style="min-width: 12rem; min-height: 4rem">
                        <div class="card-body p-1">
                            <form method="POST">
                                @csrf
                                <input type="hidden" value="{{ $item->name }}" name="search">
                                <button class="btn btn-transparent">
                                    <span class="card-title text-nowrap mb-3">{{ $item->name }}
                                        @if ($item->thumbnail)
                                            <img src="{{ Storage::url($item->thumbnail) }}" class="ml-1 img-fluid"
                                                style="height:35px; width:auto">
                                            {{-- @else
                                            <i class="ml-1 far fa-image fa-2x text-secondary"></i> --}}
                                        @endif
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @foreach ($products as $item)
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 custom-col p-2">
                <div class="card h-100">
                    @if ($item['image_url'])
                        <img src="{{ $item['image_url'] == 'nophoto.jpg' ? 'https://source.unsplash.com/600x400/?spagetti' : Storage::url('thumb/'.$item['image_url']) }}"
                            class="card-img-top img-fluid" height="170rem" alt="{{ $item['name'] }}">
                    @else
                        <i class="ml-1 far fa-image fa-2x text-info"></i>
                    @endif
                    <div class="card-body p-2">
                        <div class="card-text mb-1 text-card-custom">{{ $item['name'] }}</div>
                        {{-- <div class="card-text text-small text-muted">{{ $item['description'] }}</div> --}}
                        <div class="card-text mb-0">Rp. {{ number_format($item['price']) }}</div>
                    </div>
                    <div class="card-footer p-2 bg-transparent border-0">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-sm btn-info mr-2 text-nowrap" onclick="showOrderDetails()"><i
                                    class="fa-solid fa-cart-shopping"></i> <span class="text-beli"></span></button>
                            <button class="btn btn-sm btn-danger" onclick="removeItemFromCart({{ $item->id }})"><i
                                    class="fa-solid fa-minus"></i></button>
                            <button class="btn btn-block btn-sm btn-outline-warning text-dark"
                                id="item-qty_{{ $item->id }}" disabled>0</button>
                            <button class=" btn btn-sm btn-danger" onclick="addItemToCart({{ $item->id }})"><i
                                    class="fa-solid fa-plus"></i></button>
                            <input type="hidden" value="{{ $item->name }}" id="item-names_{{ $item->id }}">
                            <input type="hidden" value="{{ $item->price }}" id="item-prices_{{ $item->id }}">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-12">
            <div class="mt-3 float-right">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
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

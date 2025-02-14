@extends('frontend.webdesa.main')
@push('style')
@endpush
@section('title', $title)
@section('main')
@include('pages.lapak-desa.breadcrumb')
<section class="about-area pt-20 pb-80">
        <div class="container">
            <div class="about-content">
                <section class="healthy-area pt-10 pb-30">
                    <div class="container">
                        <div class="healthy-inner-wrap">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="section-title-wrap mb-30">
                                        <div class="section-title" id="nota">
                                            <h2 class="title">Detail pesanan <span id="customer"></span></h2>
                                        </div>
                                        <div class="section-title-line"></div>
                                    </div>
                                    <div id="order-details">
                                        <ul id="order-list">
                                        </ul>
                                        <h4>Total : <span id="total-price">0</span></h4>
                                    </div>
                                    <p id="xmessage">Silakan bayar pesanan Anda, dengan cara transfer ke rekening berikut:</p>
                                        <p>{!! nl2br(klien('bank')) !!}
                                        {{-- <br> 0000 0000 0000 0000
                                        <br> a/n {{ klien('nama_client') }} --}}
                                        <br><br>Pesanan anda segera kami antar
                                    </p>
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
    let checkout =  "{{ route('checkout') }}"
    let token =  '{{ csrf_token() }}'
</script>
<script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('js/checkout.js') }}"></script>
@endpush

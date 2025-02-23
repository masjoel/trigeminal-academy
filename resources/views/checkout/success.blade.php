@extends('frontend.component.main')

@section('main')
    <section class="about-area pt-80 pb-80">
        <div class="container text-center mt-5">
            <h2 class="text-success">🎉 Pembayaran Berhasil!</h2>
            <p>Terima kasih telah melakukan pembelian. Pesanan Anda sedang diproses.</p>

            <a href="{{ route('home') }}" class="mt-3"><i class="fa fa-home me-3"></i>Kembali ke Beranda</a>
        </div>
    </section>
@endsection

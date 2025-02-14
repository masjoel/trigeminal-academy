@extends('frontend.green.main')
@section('style')
@endsection
@section('title', $halaman->title)
@section('main')
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-title">
                <h2>{{ $halaman->title }}</h2>
            </div>
            <div class="row">
                <div class="col-lg-12 pt-4 pt-lg-0 order-2 order-lg-1 content">
                    <p>
                        {!! nl2br($halaman->deskripsi) !!}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

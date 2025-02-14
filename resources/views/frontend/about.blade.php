@extends('frontend.component.main')
@section('style')
@endsection
@section('title', $halaman->title)
@section('main')
    @include('frontend.component.breadcrumb')
    <section class="about-area pt-80 pb-80">
        <div class="container">
            <div class="about-content">
                <div class="section-title-five">
                    {{-- <span class="sub-title">{{ $halaman->title }}</span> --}}
                    <h2 class="title">{{ $halaman == null ? $title : $halaman->title }}</h2>
                </div>
                <p>{!! $halaman == null ? '' : nl2br($halaman->deskripsi) !!}</p>
            </div>
        </div>
    </section>
@endsection

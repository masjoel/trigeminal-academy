@extends('frontend.component.main')
@section('style')
@endsection
@section('title', $title)
@section('main')
    @include('frontend.component.breadcrumb')
    <section class="about-area pt-80 pb-80">
        <div class="container">
            <div class="about-content">
                <div class="section-title-five">
                    <h2 class="title">{{ $halaman == null ? $title : $halaman->title }}</h2>
                </div>
                <p>{!! $halaman == null ? '' : nl2br($halaman->deskripsi) !!}</p>
                @if ($halaman !== null && $halaman->idkategori == 'struktur-organisasi')
                    <img src="{{ Storage::url($halaman->foto_unggulan) }}" alt="{{ $halaman->title }}" class="img-fluid">
                @endif
            </div>
        </div>
    </section>
@endsection

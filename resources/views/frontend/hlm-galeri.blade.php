@extends('frontend.component.main')
@section('style')
@endsection
@section('title', $title)
@section('main')
    @include('frontend.component.breadcrumb')
    <section class="about-area pt-80 pb-30">
        <div class="container">
            <div class="about-content">
                <div class="section-title-five">
                    <h2 class="title">{{ $title }}</h2>
                </div>
                {{-- <p>{!! $halaman == null ? '' : nl2br($halaman->deskripsi) !!}</p> --}}
            </div>
        </div>
    </section>
    <section class="today-post-area">
        <div class="container">
            <div class="section-title-wrap">
                <div class="section-title section-title-four">
                    <h2 class="title">Photo</h2>
                    <div class="section-title-line"></div>
                </div>
            </div>
            <div class="today-post-wrap">
                <div class="row gutter-40 justify-content-left">
                    @foreach ($foto as $ft)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="banner-post-five banner-post-seven">
                                <div class="banner-post-thumb-five">
                                    @if ($ft->foto_unggulan != null)
                                        <img src="{{ Storage::url('thumb/' . $ft->foto_unggulan) }}"
                                            alt="{{ $ft->title }}" class="img-fluid">
                                        <a href="{{ Storage::url($ft->foto_unggulan) }}" class="paly-btn popup-video">
                                            <i class="fas fa-camera"></i>
                                        </a>
                                    @else
                                        <img src="{{ asset('img/example-image.jpg') }}" class="img-fluid"
                                            alt="{{ $ft->title }}">
                                    @endif
                                </div>
                                <div class="banner-post-content-five">
                                    <p style="color:black;font-size:14px">{{ $ft->title }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagination-wrap mt-30">
                    {{ $foto->links() }}
                </div>
            </div>
        </div>
    </section>
    <section class="today-post-area pt-50">
        <div class="container">
            <div class="section-title-wrap">
                <div class="section-title section-title-four">
                    <h2 class="title">Video</h2>
                    <div class="section-title-line"></div>
                </div>
            </div>
            <div class="today-post-wrap">
                <div class="row gutter-40 justify-content-left">
                    @foreach ($video as $v)
                        <div class="col-lg-3 col-md-4">
                            <div class="banner-post-five banner-post-seven">
                                <div class="banner-post-thumb-five">
                                    @if ($v->foto_unggulan != null)
                                        <img src="{{ Storage::url('thumb/' . $v->foto_unggulan) }}"
                                            alt="{{ $v->title }}" class="w-100" style="min-height: 205px">
                                    @else
                                        <img src="{{ asset('img/example-image.jpg') }}" class="img-fluid"
                                            alt="{{ $v->title }}">
                                    @endif
                                    <a href="{{ $v->excerpt }}" class="paly-btn popup-video"><i
                                            class="fas fa-play"></i></a>
                                </div>
                                <div class="banner-post-content-five">
                                    <p style="color:black;font-size:14px">{{ $v->title }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagination-wrap mt-30">
                    {{ $video->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

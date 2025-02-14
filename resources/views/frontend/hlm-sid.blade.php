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
                    <h2 class="title">{{ $posts == null ? $title : $posts->title }}</h2>
                </div>
                @if ($posts->jenis == 'sid')
                    @include('blog.sid')
                @endif
            </div>
        </div>
    </section>
@endsection

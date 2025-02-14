@extends('frontend.component.main')
@section('style')
    <style>
        p {
            text-transform: none !important;
        }
    </style>
@endsection
@section('title', $posts->title)
@section('main')
    <section class="blog-details-area pt-60 pb-60">
        <div class="container">
            <div class="author-inner-wrap">
                <div class="row justify-content-center">
                    <div
                        class="col-{{ $posts->category_id == 0 || $posts->category->slug == 'galeri-foto' || $posts->category->slug == 'galeri-video' ? '100' : '70' }}">
                        <div class="blog-details-wrap">
                            <div class="blog-details-content">
                                <div class="blog-details-content-top">
                                    @if ($posts->category_id > 0)
                                        <a href="/blog/category/{{ $posts->category->slug }}"
                                            class="post-tag">{{ $posts->category->kategori }}</a>
                                    @endif
                                    <h2 class="title">{{ $posts->title }}</h2>
                                    <div class="bd-content-inner">
                                        <div class="blog-post-meta">
                                            <ul class="list-wrap">
                                                <li><i class="flaticon-user"></i>by<a
                                                        href="#">{{ $posts->author->name }}</a></li>
                                                <li><i class="flaticon-calendar"></i>{{ kalender($posts->created_at) }}</li>
                                                <li><i
                                                        class="flaticon-history"></i>{{ $posts->created_at->diffForHumans() }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p class="first-info" style="margin-top: 50px">
                                    @if ($posts->foto_unggulan != null)
                                        <img src="{{ Storage::url($posts->foto_unggulan) }}" alt="">
                                    @endif
                                    {!! nl2br($posts->deskripsi) !!}
                                </p>
                                @if ($posts->jenis == 'sid')
                                    @include('blog.sid')
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($posts->category_id > 0 && $posts->category->slug !== 'galeri-foto' && $posts->category->slug !== 'galeri-video')
                        @include('blog.sidebar')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

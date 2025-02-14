@extends('frontend.component.main')
@section('style')
@endsection
@section('title', $title)
@section('main')
    @include('frontend.component.breadcrumb')
    <section class="blog-area pt-60 pb-60">
        <div class="container">
            <div class="author-inner-wrap">
                <div class="row justify-content-center">
                    <div class="col-70">
                        @foreach ($posts as $item)
                            <div class="weekly-post-item weekly-post-four">
                                <div class="weekly-post-thumb">
                                    <a href="/blog/{{ $item->slug }}">
                                        @if ($item->foto_unggulan != null)
                                            <img src="{{ Storage::url($item->foto_unggulan) }}" alt="{{ $item->title }}"
                                                class="w-100" style="min-height: 205px">
                                        @else
                                            <img src="{{ asset('img/example-image.jpg') }}" class="img-fluid"
                                                alt="{{ $item->title }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="weekly-post-content">
                                    <a href="blog/category/{{ $item->category->slug }}"
                                        class="post-tag">{{ $item->category->kategori }}</a>

                                    <h2 class="post-title"><a href="/blog/{{ $item->slug }}">{{ $item->title }}</a></h2>
                                    <div class="blog-post-meta">
                                        <ul class="list-wrap">
                                            <li><i class="flaticon-calendar"></i>{{ kalender($item->created_at) }}</li>
                                            <li><i class="flaticon-history"></i>{{ $item->created_at->diffForHumans() }}
                                            </li>
                                        </ul>
                                    </div>
                                    <p>{!! nl2br($item->excerpt) !!}</p>
                                    <div class="view-all-btn">
                                        <a href="/blog/{{ $item->slug }}" class="link-btn">Read More
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10" fill="none">
                                                    <path
                                                        d="M1.07692 10L0 8.92308L7.38462 1.53846H0.769231V0H10V9.23077H8.46154V2.61538L1.07692 10Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M1.07692 10L0 8.92308L7.38462 1.53846H0.769231V0H10V9.23077H8.46154V2.61538L1.07692 10Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="pagination-wrap mt-30">
                            {{ $posts->links() }}
                        </div>
                    </div>
                    @include('blog.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

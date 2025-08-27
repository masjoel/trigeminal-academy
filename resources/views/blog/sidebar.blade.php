<div class="col-30">
    <div class="sidebar-wrap">
        <div class="sidebar-widget">
            <div class="sidebar-search">
                <form method="POST" action="{{ route('blog') }}" class="float-right form-inline mr-auto">
                    @csrf
                    <input type="text" name="search" placeholder="Search . . .">
                    <button type="submit"><i class="flaticon-search"></i></button>
                </form>
            </div>
        </div>
        <div class="sidebar-widget sidebar-widget-two">
            <div class="widget-title mb-30">
                <h6 class="title">Category</h6>
                <div class="section-title-line"></div>
            </div>
            <div class="sidebar-categories">
                @foreach ($categories as $categories)
                    <a href="/blog/category/{{ $categories->slug }}">
                        <span class="post-tag">
                            {{ strtolower($categories->kategori) }}
                            ({{ $categories->total_article }})
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="sidebar-widget sidebar-widget-two">
            <div class="widget-title mb-30">
                <h6 class="title">Latest</h6>
                <div class="section-title-line"></div>
            </div>
            <div class="hot-post-wrap">
                @php $i=1; @endphp
                @foreach ($terbaru as $baru)
                    <div class="hot-post-item">
                        @if ($i == 1)
                            <div class="hot-post-thumb">
                                <a href="/blog/{{ $baru->slug }}">
                                    @if ($baru->foto_unggulan != null)
                                        <img src="{{ Storage::url($baru->foto_unggulan) }}" alt="{{ $baru->title }}"
                                            class="w-100" style="min-height: 205px">
                                    @else
                                        <img src="{{ asset('img/example-image.jpg') }}" class="img-fluid"
                                            alt="{{ $baru->title }}">
                                    @endif
                                </a>
                            </div>
                        @endif
                        @php $i++; @endphp
                        <div class="hot-post-content">
                            <a href="/blog/category/{{ $baru->category->slug }}"
                                class="post-tag">{{ $baru->category->kategori }}</a>
                            <h4 class="post-title"><a href="/blog/{{ $baru->slug }}">{{ $baru->title }}</a></h4>
                            <div class="blog-post-meta">
                                <ul class="list-wrap">
                                    <li><i class="flaticon-calendar"></i>{{ kalender($baru->created_at) }}</li>
                                    <li><i class="flaticon-history"></i>{{ $baru->created_at->diffForHumans() }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

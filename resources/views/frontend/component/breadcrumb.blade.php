<div class="breadcrumb-area" style="padding: 10px 0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-content">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($halaman->title) ? $halaman->title : $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

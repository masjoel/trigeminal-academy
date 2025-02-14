<div class="member-statistical mb-4">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="item blue">
                <p class="mb-0">Jumlah Penduduk</p>
                <div class="btn bg-primary btn-size">
                    {{ $statistics == null ? 0 : number_format($statistics->total_pdd) }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="item green">
                <p class="mb-0">Jumlah KK</p>
                <div class="btn bg-danger btn-size">{{ $statistics == null ? 0 : number_format($statistics->total_kk) }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="item yellow">
                <p class="mb-0">Jumlah Pria</p>
                <div class="btn bg-warning btn-size">
                    {{ $statistics == null ? 0 : number_format($statistics->total_lk) }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="item purple">
                <p class="mb-0">Jumlah Wanita</p>
                <div class="btn bg-info btn-size">{{ $statistics == null ? 0 : number_format($statistics->total_pr) }}
                </div>
            </div>
        </div>
    </div>
</div>
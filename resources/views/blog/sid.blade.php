@include('blog.sid-demografi')
@push('style')
    <style>
        .progress-description,
        .info-box-text {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-small {
            font-size: 12px;
            line-height: 20px;
        }

        .text-muted {
            color: #98a6ad !important;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .float-right {
            float: right !important;
        }

        .progress {
            display: flex;
            height: .25rem;
            overflow: hidden;
            font-size: .75rem;
            background-color: #e9ecef;
            border-radius: .25rem;
        }

        .btn-size {
            font-size: 1.1rem;
        }
    </style>
@endpush
<div style="overflow-x: auto;">
    @if ($posts->idkategori == 'data-penduduk')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
                        <canvas id="myChart" height="200"></canvas>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <table class="table-striped mb-0 table">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Usia</th>
                                        <th style="text-align: right" nowrap>L</th>
                                        <th style="text-align: right">P</th>
                                        <th style="text-align: right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data_usia !== null)
                                        @foreach ($data_usia as $item)
                                            <tr>
                                                <td style="text-align: left" nowrap>{{ $item['usia'] }}</td>
                                                <td style="text-align: right">{{ $item['pria'] }}</td>
                                                <td style="text-align: right">{{ $item['wanita'] }}</td>
                                                <td style="text-align: right">{{ $item['total'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($posts->idkategori == 'data-pendidikan')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        @foreach ($data_pendidikan as $item)
                            <div class="mb-4">
                                <div class="text-small font-weight-bold text-muted float-right">
                                    {{ number_format($item['total']) }}</div>
                                <div class="font-weight-bold mb-1">{{ $item['pendidikan'] }}</div>
                                <div class="progress" data-height="3">
                                    <div class="progress-bar {{ $wn[$loop->iteration - 1] }}"
                                        style="width: {{ $statistics == null ? 0 : number_format(($item['total'] / $statistics->total_pdd) * 100, 2) }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="table-responsive">
                            <table class="table table-striped mt-0">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Education</th>
                                        <th style="text-align: right" nowrap>Man</th>
                                        <th style="text-align: right">Woman</th>
                                        <th style="text-align: right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_pendidikan as $item)
                                        <tr>
                                            <td nowrap>{{ $item['pendidikan'] }}</td>
                                            <td style="text-align: right">{{ $item['pria'] }}</td>
                                            <td style="text-align: right">{{ $item['wanita'] }}</td>
                                            <td style="text-align: right">{{ $item['total'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($posts->idkategori == 'data-hub-keluarga')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        @foreach ($data_hub_klg as $item)
                            <div class="mb-4">
                                <div class="text-small font-weight-bold text-muted float-right">
                                    {{ number_format($item['total']) }}</div>
                                <div class="font-weight-bold mb-1">{{ $item['hubungan'] }}</div>
                                <div class="progress" data-height="3">
                                    <div class="progress-bar {{ $wn[$loop->iteration - 1] }}"
                                        style="width: {{ $statistics == null ? 0 : number_format(($item['total'] / $statistics->total_pdd) * 100, 2) }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Family relationship</th>
                                        <th style="text-align: right" nowrap>Man</th>
                                        <th style="text-align: right">Woman</th>
                                        <th style="text-align: right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_hub_klg as $item)
                                        <tr>
                                            <td nowrap>{{ $item['hubungan'] }}</td>
                                            <td style="text-align: right">{{ $item['pria'] }}</td>
                                            <td style="text-align: right">{{ $item['wanita'] }}</td>
                                            <td style="text-align: right">{{ $item['total'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($posts->idkategori == 'data-pekerjaan')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        @foreach ($data_pekerjaan as $item)
                            <div class="mb-4">
                                <div class="text-small font-weight-bold text-muted float-right">
                                    {{ number_format($item['total']) }}</div>
                                <div class="font-weight-bold mb-1">{{ $item['pekerjaan'] }}</div>
                                <div class="progress" data-height="3">
                                    <div class="progress-bar {{ $wn[$loop->iteration - 1] }}"
                                        style="width: {{ $statistics == null ? 0 : number_format(($item['total'] / $statistics->total_pdd) * 100, 2) }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Work</th>
                                        <th style="text-align: right" nowrap>Man</th>
                                        <th style="text-align: right">Woman</th>
                                        <th style="text-align: right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_pekerjaan as $item)
                                        <tr>
                                            <td nowrap>{{ $item['pekerjaan'] }}</td>
                                            <td style="text-align: right">{{ $item['pria'] }}</td>
                                            <td style="text-align: right">{{ $item['wanita'] }}</td>
                                            <td style="text-align: right">{{ $item['total'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($posts->idkategori == 'data-jkn')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 mb-4">
                        <canvas id="myChartJkn" height="150"></canvas>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <table class="table-striped mb-0 table">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Age</th>
                                        <th style="text-align: right" nowrap>Man</th>
                                        <th style="text-align: right">Woman</th>
                                        <th style="text-align: right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_jkn as $item)
                                        <tr>
                                            <td style="text-align: left" nowrap>{{ $item['jkn'] }}</td>
                                            <td style="text-align: right">{{ $item['pria'] }}</td>
                                            <td style="text-align: right">{{ $item['wanita'] }}</td>
                                            <td style="text-align: right">{{ $item['total'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
@push('scripts')
    <script src="{{ asset('library/chart.js/dist/Chart-Old.min.js') }}"></script>
    <script>
        var kategori_graph = "{{ $posts->idkategori }}";
        if (kategori_graph == 'data-penduduk') {
            var label_u0_12 = @json($v_usia);
            var u_lk = @json($u_lk);
            var u_pr = @json($u_pr);
            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: label_u0_12,
                    datasets: [{
                            label: 'Laki-laki',
                            data: u_lk,
                            backgroundColor: '#fc544b',
                        },
                        {
                            label: 'Perempuan',
                            data: u_pr,
                            backgroundColor: '#6777ef',
                        },
                    ]
                },
                options: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                color: '#f2f2f2',
                            },
                        }],
                        xAxes: [{
                            ticks: {
                                display: true
                            },
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                }
            });
        }
        if (kategori_graph == 'data-jkn') {
            var jkn_label = @json($jkn_label);
            var jkn_data = @json($jkn_data);
            var jkn_color = @json($jkn_color);
            var ctx = document.getElementById("myChartJkn").getContext('2d');
            var myChartJkn = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: jkn_label,
                    datasets: [{
                        data: jkn_data,
                        backgroundColor: jkn_color,
                        label: 'Dataset 1'
                    }],
                },
                options: {
                    responsive: true,
                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                }
            });
        }
    </script>
@endpush
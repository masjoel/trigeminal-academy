@extends('layouts.dashboard')

@section('title', 'Lapak Desa')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('v3/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('v3/libs/bootstrap-select/bootstrap-select.css') }}" />
@endpush


@section('main')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header header-elements">
                            @php
                                $months = [
                                    '01' => 'Januari',
                                    '02' => 'Februari',
                                    '03' => 'Maret',
                                    '04' => 'April',
                                    '05' => 'Mei',
                                    '06' => 'Juni',
                                    '07' => 'Juli',
                                    '08' => 'Agustus',
                                    '09' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember',
                                ];
                            @endphp
                            <form method="GET">
                                @csrf
                                <div class="input-group">
                                    <select name="search" class="form-control select2" aria-describedby="button-addon2">
                                        @foreach ($months as $m => $value)
                                            <option value="{{ $m }}" {{ $m == $search ? 'selected' : '' }}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name='year' class="form-control"
                                        value="{{ $year ?? date('Y') }}" style="width: 100px">
                                    <button class="btn btn-primary" type="submit" id="button-addon2"><i
                                            class="ti ti-search"></i></button>
                                </div>
                            </form>
                            <div class="card-header-elements ms-auto">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-danger me-4 p-2 bg-danger">
                                            <i class="ti ti-shopping-cart ti-lg text-white"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">{{ number_format($tot_pending) }}</h5>
                                            <small>Pending</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-info me-4 p-2 bg-info"><i
                                                class="ti ti-refresh ti-lg text-white"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">{{ number_format($tot_proses) }}</h5>
                                            <small>Proses</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-primary me-4 p-2">
                                            <i class="ti ti-truck ti-lg text-white"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">{{ number_format($tot_kirim) }}</h5>
                                            <small>Kirim</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-label-success me-4 p-2 bg-success">
                                            <i class="ti ti-checks ti-lg text-white"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">{{ number_format($tot_finish) }}</h5>
                                            <small>Selesai</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-12 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-primary me-4 p-2">
                                            <i class="ti ti-wallet ti-lg text-white"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">{{ number_format($tot_balance) }}</h5>
                                            <small>Omzet</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-success me-4 p-2"><i
                                                class="ti ti-scale ti-lg text-white"></i>
                                        </div>
                                        <div class="card-success">
                                            <h5 class="mb-0">{{ number_format($tot_balance - $tot_budget) }}
                                                <span class="text-success"
                                                    style="font-size: 12px">{{ $tot_balance > 0 ? number_format((($tot_balance - $tot_budget) / $tot_balance) * 100, 2) : 0 }}%</span>
                                            </h5>
                                            <small>Margin</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-warning me-4 p-2">
                                            <i class="ti ti-shopping-cart ti-lg text-white"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0"> {{ number_format($tot_order) }}</h5>
                                            <small>Total Order</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded bg-info me-4 p-2">
                                            <i class="ti ti-paper-bag ti-lg text-white"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0">{{ number_format($tot_sales) }}</h5>
                                            <small>Produk Terjual</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-7">
                    <div class="card mb-2">
                        <div class="card-header">
                            <h5 class="text-info">Biaya vs Penjualan</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart2" style="height: 100px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    @php
                        $toporder = [
                            date('Y-m-d') => 'Hari ini',
                            date('W') => 'Minggu ini',
                            date('m') => 'Bulan ini',
                            date('Y') => 'Tahun ini',
                        ];
                    @endphp
                    <div class="card mb-2">
                        <div class="card-header header-elements">
                            <h5 class="text-info">5 Produk terlaris</h5>
                            <div class="card-header-elements ms-auto">
                                <form method="GET">
                                    @csrf
                                    <div class="input-group">
                                        <select name="terlaris" class="form-control select2"
                                            aria-describedby="button-addon2">
                                            @foreach ($toporder as $y => $value)
                                                <option value="{{ $y }}"
                                                    {{ $y == $terlaris ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-primary" type="submit" id="button-addon2"><i
                                                class="ti ti-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($bestproducts as $item)
                                @php
                                    $item_sales = $item->total_sales * $item->price;
                                    $item_budget = $item->total_sales * $item->budget;
                                    $tot_pros = $item_sales + $item_budget;
                                    $pros_sales = ($item_sales / $tot_pros) * 100;
                                    $pros_budget = ($item_budget / $tot_pros) * 100;
                                @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('lapak-desa-produk.edit', $item->id) }}">
                                        @if ($item->image_url !== null)
                                            <img class="mr-3 rounded" width="55"
                                                src="{{ Storage::url($item->image_url) }}" alt="product">
                                        @endif
                                    </a>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex w-100 justify-content-between">
                                                {{ $item->name }}
                                                <small>{{ $item->total_sales }} terjual</small>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex w-100 align-items-center gap-2 d-block">
                                                <div class="progress w-100 bg-label-success" style="height: 4px">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ number_format($pros_sales, 2) }}%">
                                                    </div>
                                                </div>
                                                <small
                                                    class="w-px-150 text-end">{{ number_format($item_sales, 0) }}</small>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex w-100 align-items-center gap-2 d-block">
                                                <div class="progress w-100 bg-label-danger" style="height: 4px">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: {{ number_format($pros_budget, 2) }}%">
                                                    </div>
                                                </div>
                                                <small
                                                    class="w-px-150 text-end">{{ number_format($item_budget, 0) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header header-elements">
                            <h5 class="text-info">Invoices</h5>
                            <div class="card-header-elements ms-auto">
                                <a href="{{ route('lapak-desa-order.index') }}" class="btn btn-sm btn-danger">View
                                    More
                                    <i class="fas fa-chevron-right ms-2"></i></a>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                @foreach ($order as $index => $item)
                                    <div class="col-md-6 col-lg-4 p-3">
                                        <div class="bg-light card h-100 mb-3">
                                            <a href="{{ route('lapak-desa-order.edit', $item->id) }}"
                                                class="text-decoration-none text-dark" title="Detil Order">
                                                <div class="bg-info card-header p-3">
                                                    <h5 class="">
                                                        {{ $item->customer == null ? $item->namauser : $item->customer }}
                                                        <small>#{{ $item->number }}</small>
                                                    </h5>
                                                </div>
                                            </a>

                                            <div class="card-body pb-0">
                                                <div class="d-flex justify-content-between">
                                                    <h4 class="">Rp.{{ number_format($item->total_price) }}
                                                    </h4>
                                                    @if ($item->bukti_bayar != null)
                                                        <a href="#" id="show-image" data-id="{{ $item->id }}"
                                                            data-image="{{ $item->bukti_bayar }}" target="_blank">
                                                            <i class="fa fa-image text-info fa-2x"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <small>{{ $item->created_at->format('d-m-Y') }}</small>
                                                    <small>{{ $item->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="card-text">
                                                <div class="d-flex justify-content-between">
                                                    @switch($item->payment_status)
                                                        @case(1)
                                                            <span class="badge bg-warning mr-2">pending</span>
                                                        @break

                                                        @case(2)
                                                            <span class="badge bg-info mr-2">diproses</span>
                                                        @break

                                                        @case(3)
                                                            <span class="badge bg-primary mr-2">dikirim</span>
                                                        @break

                                                        @case(4)
                                                            <span class="badge bg-success mr-2">selesai</span>
                                                        @break

                                                        @case(5)
                                                            <span class="badge bg-dark mr-2">batal</span>
                                                        @break

                                                        @default
                                                    @endswitch

                                                    @if ($item->payment_status == 1 || $item->payment_status == 5)
                                                        <a href="#" class="ms-2 btn btn-sm btn-danger"
                                                            id="delete-data" data-id="{{ $item->id }}"
                                                            title="Hapus" data-toggle="tooltip"><i
                                                                class="fa fa-trash-alt"></i></a>
                                                    @endif
                                                    @if (Str::length($item->telpon) > 10 && Str::length($item->telpon) < 13)
                                                        <a href="http://wa.me/62{{ $item->telpon }}"
                                                            class="ms-2 btn btn-sm btn-success text-white"
                                                            style="border-radius: 50px" title="Whatsapp"
                                                            target="_blank"><i class="fa fa-phone"></i></a>
                                                    @endif
                                                    <a href="{{ route('lapak-desa-order.edit', $item->id) }}"
                                                        class="ms-2 btn btn-sm btn-info text-nowrap"
                                                        title="Detil Order"><i class="fa fa-edit me-2"></i> Detil</a>

                                                </div>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('v3/assets/js/pages-account-settings-account.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('v3/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart-Old.min.js') }}"></script>

    <script>
        let asset = '{{ Storage::url('') }}';
        $(document).on("click", "a#delete-data", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            showDeletePopup('{{ url('') }}/order/' + id, '{{ csrf_token() }}',
                '{{ url('') }}/order');
        });

        var tglBalance = @json($tglBalance);
        var totalBudget = @json($totalBudget);
        var totalBalance = @json($totalBalance);

        var tglTopsTgl = @json($tglTopsTgl);
        var qtyTopsTgl = @json($qtyTopsTgl);

        var jamTopsJam = @json($jamTopsJam);
        var qtyTopsJam = @json($qtyTopsJam);

        var hariTopsHari = @json($hariTopsHari);
        var qtyTopsHari = @json($qtyTopsHari);
        var warnaHari = @json($warnaHari);


        var ctx = document.getElementById("myChart2").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tglBalance,
                datasets: [{
                    label: 'Biaya',
                    data: totalBudget,
                    borderWidth: 2,
                    backgroundColor: '#fc544b',
                    borderColor: '#fc544b',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 4
                }, {
                    label: 'Penjualan',
                    data: totalBalance,
                    borderWidth: 2,
                    backgroundColor: '#6777ef',
                    borderColor: '#6777ef',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 4
                }, ]
            },
            options: {
                legend: {
                    display: false
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
                            display: false
                        },
                        gridLines: {
                            display: false
                        }
                    }]
                },
            }
        });

        var ctx = document.getElementById("myChart3").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: tglTopsTgl,
                datasets: [{
                    label: 'Qty',
                    data: qtyTopsTgl,
                    borderWidth: 2,
                    backgroundColor: 'transparent',
                    borderColor: '#6777ef',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 4
                }, ],
            },
            options: {
                legend: {
                    display: false
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
                            display: false
                        },
                        gridLines: {
                            display: false
                        }
                    }]
                },
            }
        });

        var ctx = document.getElementById("myChart4").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: jamTopsJam,
                datasets: [{
                    label: 'Qty',
                    data: qtyTopsJam,
                    borderWidth: 2,
                    backgroundColor: '#6777ef',
                    borderColor: '#6777ef',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 4
                }, ],
            },
            options: {
                legend: {
                    display: false
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
                            display: false
                        },
                        gridLines: {
                            display: false
                        }
                    }]
                },
            }
        });

        var ctx = document.getElementById("myChart5").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: qtyTopsHari,
                    backgroundColor: warnaHari,
                    label: 'Dataset 1'
                }],
                labels: hariTopsHari,
            },
            options: {
                responsive: true,
                legend: {
                    display: false,
                    position: 'bottom',
                },
            }
        });
    </script>
@endpush

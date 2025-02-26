@extends('layouts.dashboard')

@section('title', $title)

@push('style')
    <link rel="stylesheet" href="{{ asset('v3/libs/apex-charts/apex-charts.css') }}" />
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h2>{{ $title }}</h2>
            </div>
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                            <a href="{{ route('student.index') }}">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar me-4">
                                        <span class="avatar-initial rounded bg-primary"><i
                                                class="ti ti-users ti-28px text-white"></i></span>
                                    </div>
                                    <h4 class="mb-0">{{ number_format($statistics->total_pdd) }}</h4>
                                </div>
                            </a>
                            <p class="mb-1">Jumlah Peserta</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                    <div class="card card-border-shadow-info h-100">
                        <div class="card-body">
                            <a href="{{ route('course.index') }}">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar me-4">
                                        <span class="avatar-initial rounded bg-info"><i
                                                class="ti ti-book ti-28px text-white"></i></span>
                                    </div>
                                    <h4 class="mb-0">{{ number_format($totalCourses) }}</h4>
                                </div>
                            </a>
                            <p class="mb-1">Jumlah Kelas</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                    <div class="card card-border-shadow-danger h-100">
                        <div class="card-body">
                            <a href="{{ route('order.index') }}">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar me-4">
                                        <span class="avatar-initial rounded bg-danger">
                                            <i class="ti-26px ti ti-calendar-stats text-white"></i>
                                        </span>
                                    </div>
                                    <h5 class="mb-0 me-4">Rp. {{ number_format($totalPending) }}</h5>
                                </div>
                            </a>
                            <p class="mb-1">Pending Order : {{ number_format($orderPending) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                    <div class="card card-border-shadow-success h-100">
                        <div class="card-body">
                            <a href="{{ route('order.index') }}">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar me-4">
                                        <span class="avatar-initial rounded bg-success">
                                            <i class="ti-26px ti ti-wallet text-white"></i>
                                        </span>
                                    </div>
                                    <h5 class="mb-0 me-4">Rp. {{ number_format($totalOmzet) }}</h5>
                                </div>
                            </a>
                            <p class="mb-1">Selesai : {{ number_format($orderOmzet) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-6">
                <div class="card-header d-flex flex-wrap justify-content-between gap-4">
                    <div class="card-title mb-0 me-1">
                        <h5 class="mb-0">Kelas terbaru</h5>
                    </div>
                    <div class="form-check form-switch my-2 ms-2">
                        <a href="{{ route('course.index') }}">view all</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gy-6 mb-6">
                        @foreach ($courses as $item)
                            <div class="col-sm-6 col-lg-4">
                                <div class="card p-2 h-100 shadow-none border">
                                    <div class="rounded-2 text-center mb-4">
                                        <a href="{{ route('course.show', $item->id) }}">
                                            @if ($item->image_url !== null)
                                                <img class="img-fluid"
                                                    src="{{ Storage::url('thumb/' . $item->image_url) }}"
                                                    alt="{{ $item->name }}">
                                            @else
                                                <img class="img-fluid" src="{{ asset('img/example-image-50.jpg') }}"
                                                    alt="{{ $item->name }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="card-body p-4 pt-2">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <span
                                                class="badge bg-label-{{ $item->productCategory->warna }}">{{ $item->productCategory->name }}</span>
                                            <p
                                                class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                                                <span class="text-warning">
                                                    @if ($item->discount > 0)
                                                        <span class="fw-normal">disc. {{ $item->discount }}%</span>
                                                    @endif
                                                </span>
                                            </p>
                                        </div>
                                        <a href="app-academy-course-details.html" class="h5">{{ $item->name }}</a>
                                        <p class="mt-1">{{ $item->excerpt }}</p>
                                        <p class="d-flex align-items-center mb-1">
                                            Harga :
                                            @if ($item->discount > 0)
                                                <span
                                                    class="text-decoration-line-through mx-2">Rp.{{ number_format($item->price) }}</span>
                                                <span
                                                    class="text-danger fw-bold">Rp.{{ number_format($item->price - ($item->price * $item->discount) / 100) }}</span>
                                            @else
                                                <span
                                                    class="text-danger fw-bold ms-2">Rp.{{ number_format($item->price) }}</span>
                                            @endif
                                        </p>
                                        <p class="d-flex align-items-center mb-1">
                                            Level : <span class="ms-2">{{ ucwords($item->level) }}</span>
                                        </p>
                                        <p class="d-flex align-items-center mb-1">
                                            <i class="ti ti-clock me-1"></i>{{ $item->video_duration }} menit
                                        </p>
                                        {{-- <div class="progress rounded-pill mb-4" style="height: 8px">
                                            <div class="progress-bar w-75" role="progressbar" aria-valuenow="25"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div> --}}
                                        <div
                                            class="mt-4 d-flex flex-column flex-md-row gap-4 text-nowrap flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                            {{-- <a class="w-100 btn btn-label-secondary d-flex align-items-center"
                                                href="app-academy-course-details.html">
                                                <i
                                                    class="ti ti-rotate-clockwise-2 ti-xs align-middle scaleX-n1-rtl me-2"></i><span>Start
                                                    Over</span>
                                            </a> --}}
                                            <a class="w-100 btn btn-label-primary d-flex align-items-center"
                                                href="{{ route('course.show', $item->id) }}">
                                                <span class="me-2">Detail</span><i
                                                    class="ti ti-chevron-right ti-xs scaleX-n1-rtl"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="text-info">Siswa baru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table-sm mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Pict</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Handphone</th>
                                            <th class="text-nowrap">Posted at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataStudent as $item)
                                            <tr>
                                                <td>
                                                    @if ($item->photo !== null)
                                                        <img class="rounded-circle mr-3" width="40" height="40"
                                                            src="{{ Storage::url('thumb/' . $item->photo) }}"
                                                            alt="avatar">
                                                    @else
                                                        <img class="rounded-circle mr-3" width="40"
                                                            src="{{ asset('img/example-image-50.jpg') }}" alt="avatar">
                                                    @endif
                                                </td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->telpon }}</td>
                                                <td>{{ $item->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="text-info">Artikel terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table-sm mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Pict</th>
                                            <th>Judul</th>
                                            <th>Posted at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataArtikel as $item)
                                            <tr>
                                                <td>
                                                    @if ($item->foto_unggulan !== null)
                                                        <img class="rounded-circle mr-3" width="40" height="40"
                                                            src="{{ Storage::url('thumb/' . $item->foto_unggulan) }}"
                                                            alt="avatar">
                                                    @else
                                                        <img class="rounded-circle mr-3" width="40"
                                                            src="{{ asset('img/example-image-50.jpg') }}" alt="avatar">
                                                    @endif
                                                </td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('v3/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('v3/assets/js/app-academy-dashboard.js') }}"></script>
@endpush

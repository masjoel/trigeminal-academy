@extends('layouts.dashboard')

@section('title', $title)

@push('style')
    <link rel="stylesheet" href="{{ asset('v3/libs/apex-charts/apex-charts.css') }}" />
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                {{-- <h2>{{ $title }}</h2> --}}
                <h5 class="mb-2">Hai <span class="h4"> {{ Auth::user()->name }} 👋🏻</span></h5>
                {{-- <div class="col-12 col-lg-5"> --}}
                <p>Semoga kamu tetap semangat untuk belajar dan siap menunjukkan kemampuanmu !</p>
                {{-- </div> --}}
            </div>
            <div class="card mb-6">
                <div class="card-header d-flex flex-wrap justify-content-between gap-4">
                    <div class="card-title mb-0 me-1">
                        <h5 class="mb-0">Kelas ku</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="row gy-6 mb-6">
                            @foreach ($myCourses as $item)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card p-2 h-100 shadow-none border">
                                        <div class="rounded-2 text-center mb-4">
                                            <a href="{{ route('course.show', $item->product->id) }}">
                                                @if ($item->product->image_url !== null)
                                                    <img class="img-fluid"
                                                        src="{{ Storage::url('thumb/' . $item->product->image_url) }}"
                                                        alt="{{ $item->product->name }}">
                                                @else
                                                    <img class="img-fluid" src="{{ asset('img/example-image-50.jpg') }}"
                                                        alt="{{ $item->product->name }}">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="card-body p-4 pt-2">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <span
                                                    class="badge bg-label-{{ $item->product->productCategory->warna }}">{{ $item->product->productCategory->name }}</span>
                                                <p
                                                    class="d-flex align-items-center justify-content-center fw-medium gap-1 mb-0">
                                                    <span class="text-warning">
                                                        @if ($item->product->discount > 0)
                                                            <span class="fw-normal">disc.
                                                                {{ $item->product->discount }}%</span>
                                                        @endif
                                                    </span>
                                                </p>
                                            </div>
                                            <a href="app-academy-course-details.html"
                                                class="h5">{{ $item->product->name }}</a>
                                            <p class="mt-1">{{ $item->product->excerpt }}</p>
                                            <p class="d-flex align-items-center mb-1">
                                                Harga :
                                                @if ($item->product->discount > 0)
                                                    <span
                                                        class="text-decoration-line-through mx-2">Rp.{{ number_format($item->product->price) }}</span>
                                                    <span
                                                        class="text-danger fw-bold">Rp.{{ number_format($item->product->price - ($item->product->price * $item->product->discount) / 100) }}</span>
                                                @else
                                                    <span
                                                        class="text-danger fw-bold ms-2">Rp.{{ number_format($item->product->price) }}</span>
                                                @endif
                                            </p>
                                            <p class="d-flex align-items-center mb-1">
                                                Level : <span class="ms-2">{{ ucwords($item->product->level) }}</span>
                                            </p>
                                            <p class="d-flex align-items-center mb-1">
                                                <i class="ti ti-clock me-1"></i>{{ $item->product->video_duration }} menit
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
                                                    href="{{ route('course.show', $item->product->id) }}">
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
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="text-info">Kelas yang diikuti</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table-sm mb-0 table">
                                <thead>
                                    <tr>
                                        <th>Pict</th>
                                        <th>Kelas</th>
                                        <th>Instruktur</th>
                                        {{-- <th>Level</th> --}}
                                        {{-- <th>Durasi</th> --}}
                                        <th>Harga</th>
                                        <th>Disc.</th>
                                        <th>Status</th>
                                        <th>Bukti Transfer</th>
                                        <th>Join at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myCourses as $item)
                                        <tr>
                                            <td>
                                                @if ($item->product->image_url !== null)
                                                    <img class="rounded-circle mr-3" width="40" height="40"
                                                        src="{{ Storage::url('thumb/' . $item->product->image_url) }}"
                                                        alt="image">
                                                @else
                                                    <img class="rounded-circle mr-3" width="40"
                                                        src="{{ asset('img/example-image-50.jpg') }}" alt="image">
                                                @endif
                                            </td>
                                            <td><a
                                                    href="{{ route('course.show', $item->product->id) }}">{{ $item->product->name }}</a>
                                            </td>
                                            <td>{{ $item->product->instruktur->nama }}</td>
                                            {{-- <td>{{ ucwords($item->product->level) }}</td> --}}
                                            {{-- <td>{{ $item->product->video_duration }} menit</td> --}}
                                            <td>{{ number_format($item->product->price) }}</td>
                                            <td>{{ number_format($item->product->discount) }} %</td>
                                            <td>
                                                @if ($item->payment_status == '1')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($item->payment_status == '2')
                                                    <span class="badge bg-info">Konfirmasi</span>
                                                @elseif($item->payment_status == '4')
                                                    <span class="badge bg-success">Success</span>
                                                @else
                                                    <span class="badge bg-danger">Batal</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->bukti_bayar != null)
                                                    <a href="#" id="show-image" data-id="{{ $item->id }}"
                                                        data-image="{{ $item->bukti_bayar }}" target="_blank">
                                                        <i class="fa fa-image text-secondary fa-2x"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $item->created_at->diffForHumans() }}
                                                @if ($item->payment_status !== '4')
                                                    <br><a href="/konfirmasi-pembayaran/{{ $item->id }}"
                                                        class="badge bg-primary">konfirmasi pembayaran</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="view-modal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="tampil-image"></div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('v3/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('v3/assets/js/app-academy-dashboard.js') }}"></script>
    <script>
        let asset = '{{ Storage::url('') }}';
        $(document).on("click", "a#show-image", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let image = $(this).data('image');
            $('#tampil-image').html('<img src="' + asset + image + '" class="img-fluid">');
            $('#view-modal').modal('show');
        });
    </script>
@endpush

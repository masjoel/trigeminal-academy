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
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded bg-primary"><i
                                            class="ti ti-users ti-28px text-white"></i></span>
                                </div>
                                <h4 class="mb-0">{{ number_format($statistics->total_pdd) }}</h4>
                            </div>
                            <p class="mb-1">Jumlah Anggota</p>
                            <p class="mb-0">
                                <span class="text-heading fw-medium me-2">100%</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
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
        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('v3/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('v3/assets/js/app-academy-dashboard.js') }}"></script>
@endpush

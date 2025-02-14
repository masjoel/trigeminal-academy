@extends('layouts.dashboard')

@section('title', $title)

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h3>{{ $title }}</h3>
            </div>
            <div class="row">
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
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="text-info">Buku terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table-sm mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Cover</th>
                                            <th>Judul</th>
                                            <th>Posted at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataBuku as $item)
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
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="text-info">Produk terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table-sm mb-0 table">
                                    <thead>
                                        <tr>
                                            <th>Pict</th>
                                            <th>Produk</th>
                                            <th class="text-right">Harga</th>
                                            <th>Kategori</th>
                                            <th>Suplier</th>
                                            <th>Telpon</th>
                                            <th>Posted at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataProduk as $item)
                                            <tr>
                                                <td>
                                                    @if ($item->image_url !== null)
                                                        <img class="rounded-circle mr-3" width="40" height="40"
                                                            src="{{ Storage::url('thumb/' . $item->image_url) }}"
                                                            alt="avatar">
                                                    @else
                                                        <img class="rounded-circle mr-3" width="40"
                                                            src="{{ asset('img/example-image-50.jpg') }}" alt="avatar">
                                                    @endif
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td class="text-right">Rp. {{ number_format($item->price) }}</td>
                                                <td>{{ $item->lapakCategory->name }}</td>
                                                <td>{{ $item->lapakSuplier == null ? '' : $item->lapakSuplier->nama }}</td>
                                                <td>{{ $item->lapakSuplier == null ? '' : $item->lapakSuplier->telpon }}</td>
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/chart.js/dist/Chart-Old.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush

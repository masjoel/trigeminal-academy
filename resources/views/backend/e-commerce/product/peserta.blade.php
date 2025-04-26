@extends('layouts.dashboard')

@section('title', $title)

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="card mb-4">
                <div class="card-header header-elements">
                    <h3 class="mb-0 me-2">{{ $title }}</h3>
                    <div class="card-header-elements ms-auto">
                        <span class="text text-muted d-flex">
                            <small>
                                @include('backend.e-commerce.product.breadcrumb')
                            </small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header header-elements">
                                <div class="card-header-elements ms-auto">
                                    <form method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Cari..."
                                                aria-describedby="button-addon2" />
                                            <button class="btn btn-primary" type="submit" id="button-addon2"><i
                                                    class="ti ti-search"></i></button>
                                        </div>
                                    </form>
                                    <a href="#" id="export-kelas" data-id="{{ $course->id }}" class="ms-2 btn btn-outline-secondary" title="Export Peserta"><i class="fas fa-download text-secondary"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-6 gap-2">
                                    <div class="me-1">
                                        <h5 class="mb-0">{{ $course->name }}</h5>
                                        <p class="mb-0"><span class="fw-medium text-heading">
                                                {{ $course->instruktur->nama }}</span></p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span
                                            class="badge bg-label-{{ $course->productCategory->warna }}">{{ $course->productCategory->name }}</span>
                                    </div>
                                </div>
                                <img class="img-fluid w-20" src="{{ asset('storage/' . $course->image_url) }}"
                                    alt="">
                                <div class="table-responsive mt-5">
                                    <table class="table-striped table">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama Peserta</th>
                                            <th class="text-right" scope="col">Email</th>
                                            <th class="text-right" scope="col">Phone</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                        @php $i=$nomor; @endphp
                                        @foreach ($peserta as $index => $item)
                                            <tr>
                                                <td width="50">{{ $i++ }}</td>
                                                <td>{{ $item->order->customer->name }}</td>
                                                <td>{{ $item->order->customer->email }}</td>
                                                <td>{{ $item->order->customer->phone }}</td>
                                                <td>{{ $item->order->customer->address }}</td>
                                                <td class="text-center" width="120">
                                                    @switch($item->order->payment_status)
                                                        @case(1)
                                                            <span class="badge bg-danger">pending</span>
                                                        @break

                                                        @case(2)
                                                            <span class="badge bg-info">konfirmasi</span>
                                                        @break

                                                        @case(3)
                                                            <span class="badge bg-primary">dikirim</span>
                                                        @break

                                                        @case(4)
                                                            <span class="badge bg-success">selesai</span>
                                                        @break

                                                        @case(5)
                                                            <span class="badge bg-dark">batal</span>
                                                        @break

                                                        @default
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="mt-5">
                                    {{ $peserta->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on("click", "a#export-kelas", function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            window.open(BASE_URL + '/export-kelas/' + id);
        })
    </script>
@endpush

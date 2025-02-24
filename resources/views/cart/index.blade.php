@extends('frontend.component.main')
@section('title', $title)
@section('main')
    <section class="about-area pt-80 pb-80">
        <div class="container">
            <h2>Keranjang Belanja</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (count($cart) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Disc.</th>
                            <th class="text-end">Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td class="text-end">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['discount']) ?? 0 }}%</td>
                                <input type="hidden" name="quantity" value="1">
                                {{-- <td>
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <input type="number" class="text-end" name="quantity" value="{{ $item['quantity'] }}" min="1">
                                        <button type="submit" class="tw-w tw-border-2 tw-border-[#009900] tw-text-[#009900] tw-px-3  tw-rounded-lg tw-font-medium hover:tw-bg-[#4A1B7F]/10 tw-transition-colors">Update</button>
                                    </form>
                                </td> --}}
                                <td class="text-end">Rp {{ number_format(($item['price'] - $item['price'] * $item['discount'] / 100) * $item['quantity'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $id }}">
                                        <button type="submit" class="tw-w-full tw-border-2 tw-border-[#FA0009] tw-text-[#FA0009]  tw-rounded-lg tw-font-medium hover:tw-bg-[#4A1B7F]/10 tw-transition-colors"><i class="fa fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <button type="submit" class="tw-w-full tw-border-2 tw-border-[#4A1B7F] tw-text-[#4A1B7F] tw-py-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#4A1B7F]/10 tw-transition-colors"> --}}
                <a href="{{ route('checkout.index') }}" class="tw-w-full tw-border-2 tw-border-[#4A1B7F] tw-text-[#4A1B7F] tw-p-3 tw-rounded-lg tw-font-medium hover:tw-bg-[#4A1B7F]/10 tw-transition-colors">Lanjut ke Pembayaran</a>
            @else
                <p>Keranjang belanja kosong.</p>
            @endif
        </div>
    </section>
@endsection

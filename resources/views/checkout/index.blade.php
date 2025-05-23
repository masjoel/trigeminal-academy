@extends('frontend.component.main')
@section('title', $title)
@section('main')
    <section class="about-area pt-80 pb-80">
        <div class="container">
            <h2>Checkout</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-7">
                        <h4>Ringkasan Pesanan</h4>
                        <div class="table-responsive">
                            <table class="table mb-5">
                                <thead>
                                    <tr>
                                        <th>Nama Kelas</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Disc.</th>
                                        {{-- <th class="text-end">Jumlah</th> --}}
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp
                                    @foreach ($cart as $id => $item)
                                        @php $total += ($item['price'] - $item['price'] * $item['discount'] / 100) * $item['quantity'] @endphp
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td class="text-nowrap text-end">Rp
                                                {{ number_format($item['price'], 0, ',', '.') }}</td>
                                            <td class="text-end">{{ $item['discount'] }}%</td>
                                            {{-- <td class="text-end">{{ $item['quantity'] }}</td> --}}
                                            <td class="text-nowrap text-end">Rp
                                                {{ number_format(($item['price'] - ($item['price'] * $item['discount']) / 100) * $item['quantity'], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">TOTAL</td>
                                        <td class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <p class="fw-bold">
                            Silakan tranfer ke rekening berikut:
                        </p>
                        {!! nl2br(infodesa('bank')) !!}
                    </div>
                    <div class="col-md-5">
                        <h4>Informasi Peserta</h4>
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control"
                                value="{{ empty(Auth::user()) ? old('username') : Auth::user()->username }}" {{ empty(Auth::user()) ? 'required' : 'readonly' }}>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control"
                                value="{{ empty(Auth::user()) ? old('email') : Auth::user()->email }}" {{ empty(Auth::user()) ? 'required' : 'readonly' }}>
                        </div>
                        @if (empty(Auth::user()))
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" {{ empty(Auth::user()) ? 'required' : 'readonly' }}>
                            </div>
                            Sudah punya akun? <a href="{{ route('login') }}">login disini</a>
                        @else
                            <input type="password" name="password" value="{{ Auth::user()->password }}">
                        @endif
                        <hr>
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ empty(Auth::user()) ? old('name') : Auth::user()->name }}" {{ empty(Auth::user()) ? 'required' : 'readonly' }}>
                        </div>

                        <div class="mb-3">
                            <label>Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ empty(Auth::user()) ? old('phone') : Auth::user()->phone }}" {{ empty(Auth::user()) ? 'required' : 'readonly' }}>
                        </div>

                        <div class="mb-3">
                            <label>Alamat Lengkap</label>
                            <textarea name="address" class="form-control" {{ empty(Auth::user()) ? 'required' : 'readonly' }}>{{ empty(Auth::user()) ? old('address') : Auth::user()->address }}</textarea>
                        </div>

                        <h4>Metode Pembayaran</h4>
                        <div class="mb-3">
                            <select name="payment_method" class="form-control">
                                <option value="transfer">Transfer Bank</option>
                                <option value="ewallet">E-Wallet</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Bayar</button>
                    </div>
                </div>


            </form>
        </div>
    </section>
@endsection

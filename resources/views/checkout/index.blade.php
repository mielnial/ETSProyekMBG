@extends('layouts.app')

@section('title', 'Checkout - Toko Alat Tulis')

@section('content')
    <h2>Checkout</h2>

    <table>
        <thead>
            <tr>
                <th>Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item['product']->nama_barang }}</td>
                    <td>Rp {{ number_format($item['product']->harga, 0, ',', '.') }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">Total bayar: Rp {{ number_format($total, 0, ',', '.') }}</div>
    <p>Ongkos kirim diabaikan.</p>

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <label for="alamat_pengiriman">Alamat pengiriman</label><br>
        <textarea id="alamat_pengiriman" name="alamat_pengiriman" rows="3" style="width:100%;max-width:500px" required>{{ old('alamat_pengiriman', Auth::user()->alamat) }}</textarea>

        @error('alamat_pengiriman')
            <div class="alert err">{{ $message }}</div>
        @enderror

        <p>
            <button type="submit">Buat Pesanan</button>
            <a href="{{ route('keranjang.index') }}">Kembali ke keranjang</a>
        </p>
    </form>
@endsection
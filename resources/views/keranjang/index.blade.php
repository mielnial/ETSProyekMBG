@extends('layouts.app')

@section('title', 'Keranjang - Toko Alat Tulis')

@section('content')
    <h2>Keranjang Belanja</h2>

    @if (count($items) === 0)
        <p>Keranjang kosong. <a href="{{ route('produk.index') }}">Belanja dulu</a></p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['product']->nama_barang }}</td>
                        <td>Rp {{ number_format($item['product']->harga, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('keranjang.ubah', $item['product']->id_barang) }}" class="inline">
                                @csrf
                                <input type="hidden" name="aksi" value="kurang">
                                <button type="submit">-</button>
                            </form>
                            {{ $item['jumlah'] }}
                            <form method="POST" action="{{ route('keranjang.ubah', $item['product']->id_barang) }}" class="inline">
                                @csrf
                                <input type="hidden" name="aksi" value="tambah">
                                <button type="submit">+</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('keranjang.hapus', $item['product']->id_barang) }}" class="inline">
                                @csrf
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">Total: Rp {{ number_format($total, 0, ',', '.') }}</div>
        <p><a href="{{ route('checkout') }}" style="display:inline-block;padding:.5rem 1rem;background:#1a57a0;color:#fff;border-radius:4px;text-decoration:none">Checkout</a></p>
        <form method="POST" action="{{ route('keranjang.kosongkan') }}">
            @csrf
            <button type="submit">Kosongkan keranjang</button>
        </form>
    @endif
@endsection
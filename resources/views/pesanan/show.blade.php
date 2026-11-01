@extends('layouts.app')

@section('title', 'Detail Pesanan - Toko Alat Tulis')

@section('content')
    <h2>Detail Pesanan {{ $order->id_order }}</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y H:i') }}</p>
    <p>Alamat pengiriman: {{ $order->alamat_pengiriman }}</p>

    <table>
        <thead>
            <tr>
                <th>Barang</th>
                <th>Harga satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->details as $d)
                <tr>
                    <td>{{ $d->product?->nama_barang ?? $d->id_barang }}</td>
                    <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $d->jumlah_beli }}</td>
                    <td>Rp {{ number_format($d->harga_satuan * $d->jumlah_beli, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
    <p><a href="{{ route('pesanan.index') }}">&laquo; Kembali ke daftar pesanan</a></p>
@endsection
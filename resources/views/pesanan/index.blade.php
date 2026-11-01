@extends('layouts.app')

@section('title', 'Pesanan Saya - Toko Alat Tulis')

@section('content')
    <h2>Pesanan Saya</h2>

    @if ($orders->isEmpty())
        <p>Belum ada pesanan. <a href="{{ route('produk.index') }}">Belanja dulu</a></p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id_order }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y H:i') }}</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td><a href="{{ route('pesanan.show', $order->id_order) }}">Lihat detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
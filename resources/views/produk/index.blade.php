@extends('layouts.app')

@section('title', 'Toko Alat Tulis')

@section('content')
    <div class="grid">
        @foreach ($products as $p)
            <div class="card">
                <img src="{{ asset('images/produk/' . $p->gambar) }}" alt="{{ $p->nama_barang }}">
                <h3>{{ $p->nama_barang }}</h3>
                <div class="harga">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>

                @if ($p->stok > 0)
                    <div>Stok: {{ $p->stok }}</div>
                    @auth
                        <form method="POST" action="{{ route('keranjang.tambah', $p->id_barang) }}">
                            @csrf
                            <button type="submit">Masukkan ke keranjang</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Login untuk membeli</a>
                    @endauth
                @else
                    <div class="habis">Stok habis</div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
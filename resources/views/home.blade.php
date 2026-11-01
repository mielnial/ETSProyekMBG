@extends('layouts.app')

@section('title', 'Beranda - ' . config('app.name', 'MBG Monitor'))

@section('content')
    <section>
        <h2>Selamat datang</h2>
        <p>Anda berhasil masuk ke {{ config('app.name', 'MBG Monitor') }}.</p>

        @if (auth()->user()->isPelapor())
            <p><a href="{{ route('laporan.index') }}">Laporan Saya</a></p>
        @endif

        @if (auth()->user()->isPemantau() || auth()->user()->isKoordinator())
            <p><a href="{{ route('rekap.index') }}">Lihat Rekap Laporan</a></p>
        @endif
    </section>
@endsection

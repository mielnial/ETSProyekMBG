@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
    <h2>Detail Laporan</h2>

    <dl>
        <dt>Sekolah</dt>
        <dd>{{ $laporan->distribusi->sekolah->nama }}</dd>

        <dt>Tanggal Distribusi</dt>
        <dd>{{ $laporan->distribusi->tanggal_distribusi->format('d-m-Y') }}</dd>

        <dt>Menu</dt>
        <dd>{{ $laporan->distribusi->menu }}</dd>

        <dt>Waktu Kejadian</dt>
        <dd>{{ $laporan->waktu_kejadian->format('d-m-Y H:i') }}</dd>

        <dt>Jumlah Terdampak</dt>
        <dd>{{ $laporan->jumlah_terdampak }}</dd>

        <dt>Gejala</dt>
        <dd>{{ $laporan->gejala }}</dd>

        <dt>Uraian</dt>
        <dd>{{ $laporan->uraian }}</dd>

        <dt>Status</dt>
        <dd>{{ ucfirst(str_replace('_', ' ', $laporan->status)) }}</dd>

        @if (auth()->user()->isPemantau())
            <dt>Pelapor</dt>
            <dd>{{ $laporan->pelapor->nama_lengkap }}</dd>
        @endif
    </dl>

    <a href="{{ auth()->user()->isPelapor() ? route('laporan.index') : route('home') }}">Kembali</a>
@endsection

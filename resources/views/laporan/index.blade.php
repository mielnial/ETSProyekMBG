@extends('layouts.app')

@section('title', 'Laporan Saya')

@section('content')
    <h2>Laporan Saya</h2>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Sekolah</th>
                <th>Tanggal Distribusi</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan as $item)
                <tr>
                    <td>{{ $item->distribusi->sekolah->nama }}</td>
                    <td>{{ $item->distribusi->tanggal_distribusi->format('d-m-Y') }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $item->status)) }}</td>
                    <td><a href="{{ route('laporan.show', $item) }}">Detail</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada laporan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

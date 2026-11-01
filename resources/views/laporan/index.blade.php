@extends('layouts.app')

@section('title', 'Laporan Saya')

@section('content')
    <h2>Laporan Saya</h2>

    <p><a href="{{ route('laporan.create') }}">Buat Laporan</a></p>

    <form method="GET" action="{{ route('laporan.index') }}">
        <div>
            <label for="q">Cari sekolah, menu, gejala, atau uraian</label>
            <input
                id="q"
                type="search"
                name="q"
                value="{{ $filters['q'] ?? '' }}"
                maxlength="100"
            >
        </div>

        <div>
            <label for="status">Filter status</label>
            <select id="status" name="status">
                <option value="">Semua status</option>
                @foreach ($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Cari / Filter</button>
        <a href="{{ route('laporan.index') }}">Reset</a>
    </form>

    <p>Menampilkan {{ $laporan->firstItem() ?? 0 }}–{{ $laporan->lastItem() ?? 0 }} dari {{ $laporan->total() }} laporan.</p>

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
                    <td colspan="4">
                        @if (($filters['q'] ?? '') !== '' || ($filters['status'] ?? '') !== '')
                            Tidak ada laporan yang cocok dengan pencarian atau filter.
                        @else
                            Belum ada laporan.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($laporan->hasPages())
        <nav aria-label="Navigasi halaman laporan">
            @if ($laporan->onFirstPage())
                <span aria-disabled="true">Sebelumnya</span>
            @else
                <a href="{{ $laporan->previousPageUrl() }}">Sebelumnya</a>
            @endif

            <span>Halaman {{ $laporan->currentPage() }} dari {{ $laporan->lastPage() }}</span>

            @if ($laporan->hasMorePages())
                <a href="{{ $laporan->nextPageUrl() }}">Selanjutnya</a>
            @else
                <span aria-disabled="true">Selanjutnya</span>
            @endif
        </nav>
    @endif
@endsection

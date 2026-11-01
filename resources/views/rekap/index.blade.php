@extends('layouts.app')

@section('title', 'Rekap Laporan')

@section('content')
    <h2>Rekap Laporan</h2>

    <p>
        @if (auth()->user()->isKoordinator())
            Rekap ini hanya memuat laporan yang ditandai untuk diteruskan, sudah diteruskan, atau ditutup setelah diteruskan.
        @else
            Ringkasan seluruh laporan yang dapat ditinjau.
        @endif
    </p>

    <form method="GET" action="{{ route('rekap.index') }}">
        <label for="status">Filter status</label>
        <select id="status" name="status">
            <option value="">Semua status yang dapat diakses</option>
            @foreach ($statusLabels as $value => $label)
                <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <button type="submit">Terapkan</button>
        <a href="{{ route('rekap.index') }}">Reset</a>
    </form>

    <h3>Jumlah laporan per status</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ringkasan as $item)
                <tr>
                    <td>{{ $item['label'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Laporan terbaru</h3>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Sekolah</th>
                <th>Tanggal Distribusi</th>
                <th>Waktu Kejadian</th>
                <th>Jumlah Terdampak</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan as $item)
                <tr>
                    <td>{{ $item->distribusi->sekolah->nama }}</td>
                    <td>{{ $item->distribusi->tanggal_distribusi->format('d-m-Y') }}</td>
                    <td>{{ $item->waktu_kejadian->format('d-m-Y H:i') }}</td>
                    <td>{{ $item->jumlah_terdampak }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $item->status)) }}</td>
                    <td><a href="{{ route('laporan.show', $item) }}">Detail</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada laporan yang dapat ditampilkan.</td>
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

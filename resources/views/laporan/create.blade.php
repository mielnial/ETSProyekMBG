@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
    <h2>Buat Laporan</h2>

    <form method="POST" action="{{ route('laporan.store') }}">
        @csrf

        <div>
            <label for="distribusi_id">Sekolah dan Distribusi</label>
            <select id="distribusi_id" name="distribusi_id" required>
                <option value="">Pilih distribusi</option>
                @foreach ($distribusi as $item)
                    <option value="{{ $item->id }}" @selected(old('distribusi_id') == $item->id)>
                        {{ $item->sekolah->nama }},
                        {{ $item->tanggal_distribusi->format('d-m-Y') }},
                        {{ $item->menu }}
                    </option>
                @endforeach
            </select>
            @error('distribusi_id')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="waktu_kejadian">Waktu Kejadian</label>
            <input
                id="waktu_kejadian"
                type="datetime-local"
                name="waktu_kejadian"
                value="{{ old('waktu_kejadian') }}"
                required
            >
            @error('waktu_kejadian')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jumlah_terdampak">Jumlah Terdampak</label>
            <input
                id="jumlah_terdampak"
                type="number"
                name="jumlah_terdampak"
                min="1"
                value="{{ old('jumlah_terdampak') }}"
                required
            >
            @error('jumlah_terdampak')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="gejala">Gejala</label>
            <textarea id="gejala" name="gejala" maxlength="2000" required>{{ old('gejala') }}</textarea>
            @error('gejala')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="uraian">Uraian</label>
            <textarea id="uraian" name="uraian" maxlength="5000" required>{{ old('uraian') }}</textarea>
            @error('uraian')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Kirim Laporan</button>
        <a href="{{ route('laporan.index') }}">Batal</a>
    </form>
@endsection

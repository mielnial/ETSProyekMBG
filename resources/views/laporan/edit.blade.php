@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
    <h2>Edit Laporan</h2>

    @if ($laporan->status === \App\Models\Laporan::STATUS_PERLU_DILENGKAPI)
        <p>Setelah disimpan, laporan ini akan dikirim kembali untuk ditinjau.</p>
    @endif

    <form method="POST" action="{{ route('laporan.update', $laporan) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="distribusi_id">Sekolah dan Distribusi</label>
            <select id="distribusi_id" name="distribusi_id" required>
                @foreach ($distribusi as $item)
                    <option value="{{ $item->id }}" @selected(old('distribusi_id', $laporan->distribusi_id) == $item->id)>
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
            <input id="waktu_kejadian" type="datetime-local" name="waktu_kejadian"
                value="{{ old('waktu_kejadian', $laporan->waktu_kejadian->format('Y-m-d\TH:i')) }}" required>
            @error('waktu_kejadian')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jumlah_terdampak">Jumlah Terdampak</label>
            <input id="jumlah_terdampak" type="number" name="jumlah_terdampak" min="1"
                value="{{ old('jumlah_terdampak', $laporan->jumlah_terdampak) }}" required>
            @error('jumlah_terdampak')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="gejala">Gejala</label>
            <textarea id="gejala" name="gejala" maxlength="2000" required>{{ old('gejala', $laporan->gejala) }}</textarea>
            @error('gejala')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="uraian">Uraian</label>
            <textarea id="uraian" name="uraian" maxlength="5000" required>{{ old('uraian', $laporan->uraian) }}</textarea>
            @error('uraian')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        @if ($laporan->bukti_path)
            <p>Bukti saat ini: <a href="{{ route('laporan.bukti', $laporan) }}">{{ $laporan->bukti_nama_asli }}</a></p>
        @endif

        <div>
            <label for="bukti">Ganti bukti (JPG, JPEG, PNG, atau PDF; maksimal 2 MB)</label>
            <input id="bukti" type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf">
            @error('bukti')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('laporan.show', $laporan) }}">Batal</a>
    </form>
@endsection

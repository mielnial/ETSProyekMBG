@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
    <h2>Buat Laporan</h2>

    <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="sekolah_id">Sekolah</label>
            <select id="sekolah_id" name="sekolah_id" required>
                <option value="">Pilih sekolah</option>
                @foreach ($sekolah as $item)
                    <option value="{{ $item->id }}" @selected(old('sekolah_id') == $item->id)>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
            @error('sekolah_id')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="distribusi_id">Distribusi</label>
            <select
                id="distribusi_id"
                name="distribusi_id"
                data-old-value="{{ old('distribusi_id') }}"
                data-url-template="{{ route('laporan.sekolah.distribusi', ['sekolah' => 'SCHOOL_ID']) }}"
                required
                disabled
            >
                <option value="">Pilih sekolah terlebih dahulu</option>
            </select>
            @error('distribusi_id')
                <p role="alert">{{ $message }}</p>
            @enderror
            <p id="distribusi-loading" role="status" aria-live="polite"></p>
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

        <div>
            <label for="bukti">Bukti (JPG, JPEG, PNG, atau PDF; maksimal 2 MB)</label>
            <input id="bukti" type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf">
            @error('bukti')
                <p role="alert">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Kirim Laporan</button>
        <a href="{{ route('laporan.index') }}">Batal</a>
    </form>

    <script>
        const sekolahSelect = document.getElementById('sekolah_id');
        const distribusiSelect = document.getElementById('distribusi_id');
        const loadingMessage = document.getElementById('distribusi-loading');
        const endpointTemplate = distribusiSelect.dataset.urlTemplate;
        const oldDistribusiId = distribusiSelect.dataset.oldValue;
        let permintaanTerakhir = 0;

        async function muatDistribusi(sekolahId, distribusiTerpilih = '') {
            const nomorPermintaan = ++permintaanTerakhir;
            distribusiSelect.replaceChildren(new Option('Memuat distribusi...', ''));
            distribusiSelect.disabled = true;
            loadingMessage.textContent = '';

            if (!sekolahId) {
                distribusiSelect.replaceChildren(new Option('Pilih sekolah terlebih dahulu', ''));
                return;
            }

            try {
                const url = endpointTemplate.replace('SCHOOL_ID', encodeURIComponent(sekolahId));
                const response = await fetch(url, {
                    headers: { Accept: 'application/json' },
                });

                if (!response.ok) {
                    throw new Error('Daftar distribusi gagal dimuat. Coba pilih sekolah lagi.');
                }

                const daftarDistribusi = await response.json();
                if (nomorPermintaan !== permintaanTerakhir) {
                    return;
                }

                distribusiSelect.replaceChildren(new Option('Pilih distribusi', ''));

                for (const item of daftarDistribusi) {
                    const label = `${item.tanggal}, ${item.menu}, ${item.jumlah_porsi} porsi`;
                    const option = new Option(label, item.id);
                    option.selected = String(item.id) === String(distribusiTerpilih);
                    distribusiSelect.add(option);
                }

                if (daftarDistribusi.length === 0) {
                    distribusiSelect.replaceChildren(new Option('Belum ada distribusi untuk sekolah ini', ''));
                    loadingMessage.textContent = 'Belum ada data distribusi untuk sekolah yang dipilih.';
                }

                distribusiSelect.disabled = daftarDistribusi.length === 0;
            } catch (error) {
                if (nomorPermintaan !== permintaanTerakhir) {
                    return;
                }

                distribusiSelect.replaceChildren(new Option('Distribusi gagal dimuat', ''));
                loadingMessage.textContent = error.message;
            }
        }

        sekolahSelect.addEventListener('change', () => muatDistribusi(sekolahSelect.value));

        if (sekolahSelect.value) {
            muatDistribusi(sekolahSelect.value, oldDistribusiId);
        }
    </script>
@endsection

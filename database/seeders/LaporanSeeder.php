<?php

namespace Database\Seeders;

use App\Models\CatatanPeninjauan;
use App\Models\Distribusi;
use App\Models\Laporan;
use App\Models\PenerusanInformasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $rina = User::where('username', 'rina')->firstOrFail();
        $budi = User::where('username', 'budi')->firstOrFail();
        $dedi = User::where('username', 'dedi')->firstOrFail();
        $sari = User::where('username', 'sari')->firstOrFail();

        $laporanDemo = [
            [
                'kode' => 'R1',
                'pelapor' => $rina,
                'sekolah' => 'SMP Harapan',
                'menu' => 'Nasi ayam sayur',
                'status' => 'dikirim',
                'jumlah_terdampak' => 2,
                'gejala' => 'Mual ringan dan sakit perut.',
                'uraian' => 'Dua penerima menyampaikan keluhan setelah kegiatan makan siang.',
            ],
            [
                'kode' => 'R2',
                'pelapor' => $budi,
                'sekolah' => 'SMP Harapan',
                'menu' => 'Nasi ayam sayur',
                'status' => 'sedang_ditinjau',
                'jumlah_terdampak' => 1,
                'gejala' => 'Sakit perut dan merasa kurang nyaman.',
                'uraian' => 'Satu penerima menyampaikan keluhan setelah makan siang.',
                'catatan' => 'Sedang memeriksa waktu kejadian dan jumlah penerima yang terdampak.',
            ],
            [
                'kode' => 'R3',
                'pelapor' => $rina,
                'sekolah' => 'SDN Mekar Jaya',
                'menu' => 'Nasi ikan sayur',
                'status' => 'perlu_dilengkapi',
                'jumlah_terdampak' => 3,
                'gejala' => 'Mual dan pusing ringan.',
                'uraian' => 'Beberapa penerima menyampaikan keluhan pada hari distribusi.',
                'catatan' => 'Mohon lengkapi perkiraan waktu kejadian agar laporan dapat ditinjau.',
            ],
            [
                'kode' => 'R4',
                'pelapor' => $budi,
                'sekolah' => 'SDN Mekar Jaya',
                'menu' => 'Nasi daging',
                'status' => 'ditandai_untuk_diteruskan',
                'jumlah_terdampak' => 2,
                'gejala' => 'Mual dan sakit perut.',
                'uraian' => 'Dua penerima melaporkan keluhan yang perlu ditindaklanjuti.',
                'catatan' => 'Informasi awal sudah diperiksa dan perlu diteruskan kepada pihak terkait.',
            ],
            [
                'kode' => 'R5',
                'pelapor' => $rina,
                'sekolah' => 'SMP Nusantara',
                'menu' => 'Nasi ayam',
                'status' => 'informasi_diteruskan',
                'jumlah_terdampak' => 4,
                'gejala' => 'Mual dan sakit perut pada beberapa penerima.',
                'uraian' => 'Empat penerima menyampaikan keluhan dan informasi awal telah diteruskan.',
                'penerusan' => [
                    'pihak_tujuan' => 'SPPG',
                    'keterangan' => 'Informasi awal disampaikan untuk ditindaklanjuti.',
                ],
            ],
            [
                'kode' => 'R6',
                'pelapor' => $budi,
                'sekolah' => 'SMP Nusantara',
                'menu' => 'Nasi ayam',
                'status' => 'ditutup',
                'jumlah_terdampak' => 2,
                'gejala' => 'Sakit perut dan mual ringan.',
                'uraian' => 'Dua penerima menyampaikan keluhan yang sudah ditindaklanjuti.',
                'penerusan' => [
                    'pihak_tujuan' => 'fasilitas_kesehatan',
                    'keterangan' => 'Informasi diteruskan untuk tindak lanjut yang sesuai.',
                ],
            ],
            [
                'kode' => 'R7',
                'pelapor' => $rina,
                'sekolah' => 'SMP Nusantara',
                'menu' => 'Nasi tempe',
                'status' => 'ditutup',
                'jumlah_terdampak' => 1,
                'gejala' => 'Merasa kurang nyaman setelah makan.',
                'uraian' => 'Satu penerima menyampaikan keluhan yang sudah ditinjau dan ditutup.',
            ],
            [
                'kode' => 'R8',
                'pelapor' => $budi,
                'sekolah' => 'SMP Harapan',
                'menu' => 'Nasi telur tahu',
                'status' => 'dikirim',
                'jumlah_terdampak' => 1,
                'gejala' => 'Mual ringan.',
                'uraian' => 'Satu penerima menyampaikan keluhan setelah kegiatan makan.',
            ],
        ];

        foreach ($laporanDemo as $item) {
            $distribusi = Distribusi::where('menu', $item['menu'])
                ->whereHas('sekolah', fn ($query) => $query->where('nama', $item['sekolah']))
                ->firstOrFail();

            $laporan = Laporan::firstOrNew([
                'pelapor_id' => $item['pelapor']->id,
                'distribusi_id' => $distribusi->id,
                'uraian' => $item['uraian'],
            ]);

            $laporan->forceFill([
                'waktu_kejadian' => $distribusi->tanggal_distribusi->copy()->setTime(14, 0),
                'jumlah_terdampak' => $item['jumlah_terdampak'],
                'gejala' => $item['gejala'],
                'status' => $item['status'],
                'bukti_path' => null,
                'bukti_nama_asli' => null,
            ])->save();

            if (isset($item['catatan'])) {
                CatatanPeninjauan::firstOrCreate(
                    [
                        'laporan_id' => $laporan->id,
                        'isi_catatan' => $item['catatan'],
                    ],
                    [
                        'pemantau_id' => $dedi->id,
                    ],
                );
            }

            if (isset($item['penerusan'])) {
                PenerusanInformasi::firstOrCreate(
                    [
                        'laporan_id' => $laporan->id,
                        'pihak_tujuan' => $item['penerusan']['pihak_tujuan'],
                    ],
                    [
                        'koordinator_id' => $sari->id,
                        'keterangan' => $item['penerusan']['keterangan'],
                        'tanggal_diteruskan' => $distribusi->tanggal_distribusi->copy()->addDay(),
                    ],
                );
            }
        }
    }
}

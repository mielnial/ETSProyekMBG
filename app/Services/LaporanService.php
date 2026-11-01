<?php

namespace App\Services;

use App\Models\Distribusi;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LaporanService
{
    public function buat(User $pelapor, array $data): Laporan
    {
        return DB::transaction(function () use ($pelapor, $data): Laporan {
            $distribusi = Distribusi::findOrFail($data['distribusi_id']);
            $waktuKejadian = Carbon::parse($data['waktu_kejadian']);

            $laporanAktifSudahAda = Laporan::query()
                ->where('pelapor_id', $pelapor->getKey())
                ->where('distribusi_id', $distribusi->getKey())
                ->where('status', '!=', Laporan::STATUS_DITUTUP)
                ->exists();

            $errors = [];

            if ($laporanAktifSudahAda) {
                $errors['distribusi_id'] = 'Anda masih memiliki laporan aktif untuk distribusi ini. Tunggu sampai laporan tersebut ditutup sebelum mengirim laporan baru.';
            }

            $tanggalDistribusi = $distribusi->tanggal_distribusi
                ->copy()
                ->startOfDay();

            if ($waktuKejadian->lt($tanggalDistribusi)) {
                $errors['waktu_kejadian'] = 'Waktu kejadian tidak boleh lebih awal daripada tanggal distribusi.';
            }

            if ($waktuKejadian->gt(now())) {
                $errors['waktu_kejadian'] = 'Waktu kejadian tidak boleh berada di masa depan.';
            }

            if ($errors !== []) {
                throw ValidationException::withMessages($errors);
            }

            $laporan = new Laporan([
                'distribusi_id' => $distribusi->getKey(),
                'waktu_kejadian' => $waktuKejadian,
                'jumlah_terdampak' => $data['jumlah_terdampak'],
                'gejala' => $data['gejala'],
                'uraian' => $data['uraian'],
            ]);

            $laporan->pelapor_id = $pelapor->getKey();
            $laporan->status = Laporan::STATUS_DIKIRIM;
            $laporan->save();

            return $laporan;
        });
    }
}

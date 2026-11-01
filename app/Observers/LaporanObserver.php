<?php

namespace App\Observers;

use App\Models\Laporan;
use App\Models\LogStatusLaporan;
use Illuminate\Support\Facades\Auth;

class LaporanObserver
{
    public function updated(Laporan $laporan): void
    {
        if (! $laporan->wasChanged('status')) {
            return;
        }

        LogStatusLaporan::query()->create([
            'laporan_id' => $laporan->getKey(),
            'status_lama' => $laporan->getOriginal('status'),
            'status_baru' => $laporan->status,
            'user_id' => Auth::id(),
        ]);
    }
}

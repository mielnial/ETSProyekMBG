<?php

namespace App\Policies;

use App\Models\Laporan;
use App\Models\User;

class LaporanPolicy
{
    public function create(User $user): bool
    {
        return $user->isPelapor();
    }

    public function view(User $user, Laporan $laporan): bool
    {
        if ($user->isPelapor()) {
            return (string) $laporan->pelapor_id === (string) $user->getKey();
        }

        if ($user->isPemantau()) {
            return true;
        }

        if ($user->isKoordinator()) {
            return in_array($laporan->status, [
                Laporan::STATUS_DITANDAI_UNTUK_DITERUSKAN,
                Laporan::STATUS_INFORMASI_DITERUSKAN,
            ], true)
                || (
                    $laporan->status === Laporan::STATUS_DITUTUP
                    && $laporan->pernahDiteruskan()
                );
        }

        return false;
    }

    public function update(User $user, Laporan $laporan): bool
    {
        return $user->isPelapor()
            && (string) $laporan->pelapor_id === (string) $user->getKey()
            && in_array(
                $laporan->status,
                Laporan::STATUSES_EDITABLE_BY_PELAPOR,
                true,
            );
    }
}

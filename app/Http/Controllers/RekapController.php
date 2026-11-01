<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $statusLabels = [
            Laporan::STATUS_DIKIRIM => 'Dikirim',
            Laporan::STATUS_SEDANG_DITINJAU => 'Sedang ditinjau',
            Laporan::STATUS_PERLU_DILENGKAPI => 'Perlu dilengkapi',
            Laporan::STATUS_DITANDAI_UNTUK_DITERUSKAN => 'Ditandai untuk diteruskan',
            Laporan::STATUS_INFORMASI_DITERUSKAN => 'Informasi diteruskan',
            Laporan::STATUS_DITUTUP => 'Ditutup',
        ];

        $filters = $request->validate([
            'status' => ['nullable', Rule::in(array_keys($statusLabels))],
        ]);

        $query = Laporan::query();

        if ($user->isKoordinator()) {
            $query->where(function (Builder $query): void {
                $query->whereIn('status', [
                    Laporan::STATUS_DITANDAI_UNTUK_DITERUSKAN,
                    Laporan::STATUS_INFORMASI_DITERUSKAN,
                ])->orWhere(function (Builder $query): void {
                    $query->where('status', Laporan::STATUS_DITUTUP)
                        ->whereHas('penerusanInformasi');
                });
            });
        }

        $query->when(
            $filters['status'] ?? null,
            fn (Builder $query, string $status) => $query->where('status', $status),
        );

        $jumlahPerStatus = (clone $query)
            ->selectRaw('status, COUNT(*) AS jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $ringkasan = [];
        foreach ($statusLabels as $status => $label) {
            $ringkasan[] = [
                'status' => $status,
                'label' => $label,
                'jumlah' => (int) $jumlahPerStatus->get($status, 0),
            ];
        }

        $laporan = $query
            ->with('distribusi.sekolah')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('rekap.index', compact('laporan', 'ringkasan', 'filters', 'statusLabels'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanRequest;
use App\Http\Requests\UpdateLaporanRequest;
use App\Models\Distribusi;
use App\Models\Laporan;
use App\Models\Sekolah;
use App\Services\LaporanService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $statusOptions = [
            Laporan::STATUS_DIKIRIM => 'Dikirim',
            Laporan::STATUS_SEDANG_DITINJAU => 'Sedang ditinjau',
            Laporan::STATUS_PERLU_DILENGKAPI => 'Perlu dilengkapi',
            Laporan::STATUS_DITANDAI_UNTUK_DITERUSKAN => 'Ditandai untuk diteruskan',
            Laporan::STATUS_INFORMASI_DITERUSKAN => 'Informasi diteruskan',
            Laporan::STATUS_DITUTUP => 'Ditutup',
        ];

        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(array_keys($statusOptions))],
        ]);

        $query = $request->user()->laporan()
            ->with('distribusi.sekolah')
            ->when($filters['q'] ?? null, function (Builder $query, string $search): void {
                $search = trim($search);
                $pattern = "%{$search}%";

                $query->where(function (Builder $query) use ($pattern): void {
                    $query->where('gejala', 'like', $pattern)
                        ->orWhere('uraian', 'like', $pattern)
                        ->orWhereHas('distribusi', function (Builder $query) use ($pattern): void {
                            $query->where('menu', 'like', $pattern)
                                ->orWhereHas('sekolah', fn (Builder $query) => $query->where('nama', 'like', $pattern));
                        });
                });
            })
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->latest();

        $laporan = $query->paginate(5)->withQueryString();

        return view('laporan.index', compact('laporan', 'filters', 'statusOptions'));
    }

    public function create()
    {
        Gate::authorize('create', Laporan::class);

        $sekolah = Sekolah::query()
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return view('laporan.create', compact('sekolah'));
    }

    public function distribusiUntukSekolah(Sekolah $sekolah): JsonResponse
    {
        $distribusi = $sekolah->distribusi()
            ->orderByDesc('tanggal_distribusi')
            ->get(['id', 'tanggal_distribusi', 'menu', 'jumlah_porsi'])
            ->map(fn (Distribusi $item): array => [
                'id' => $item->id,
                'tanggal' => $item->tanggal_distribusi->format('d-m-Y'),
                'menu' => $item->menu,
                'jumlah_porsi' => $item->jumlah_porsi,
            ]);

        return response()->json($distribusi);
    }

    public function edit(Laporan $laporan)
    {
        Gate::authorize('update', $laporan);

        $laporan->load('distribusi.sekolah');

        $distribusi = Distribusi::query()
            ->with('sekolah')
            ->orderByDesc('tanggal_distribusi')
            ->get();

        return view('laporan.edit', compact('laporan', 'distribusi'));
    }

    public function store(StoreLaporanRequest $request, LaporanService $laporanService)
    {
        $laporanService->buat($request->user(), $request->validated());

        return redirect()
            ->route('laporan.index')
            ->with('status', 'Laporan berhasil dikirim.');
    }

    public function update(UpdateLaporanRequest $request, Laporan $laporan, LaporanService $laporanService)
    {
        $laporanService->perbarui($request->user(), $laporan, $request->validated());

        return redirect()
            ->route('laporan.show', $laporan)
            ->with('status', 'Laporan berhasil diperbarui.');
    }

    public function show(Request $request, Laporan $laporan)
    {
        Gate::authorize('view', $laporan);

        $laporan->load('distribusi.sekolah');

        if ($request->user()->isPemantau()) {
            $laporan->load('pelapor');
        }

        return view('laporan.show', compact('laporan'));
    }

    public function downloadBukti(Laporan $laporan)
    {
        Gate::authorize('view', $laporan);

        abort_unless($laporan->bukti_path, 404);

        $disk = Storage::disk('private');
        abort_unless($disk->exists($laporan->bukti_path), 404);

        return $disk->download(
            $laporan->bukti_path,
            $laporan->bukti_nama_asli ?? basename($laporan->bukti_path),
        );
    }
}

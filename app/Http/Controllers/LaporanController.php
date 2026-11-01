<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLaporanRequest;
use App\Models\Distribusi;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $laporan = $request->user()->laporan()
            ->with('distribusi.sekolah')
            ->latest()
            ->get();

        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        Gate::authorize('create', Laporan::class);

        $distribusi = Distribusi::query()
            ->with('sekolah')
            ->orderByDesc('tanggal_distribusi')
            ->get();

        return view('laporan.create', compact('distribusi'));
    }

    public function store(StoreLaporanRequest $request)
    {
        $laporan = new Laporan($request->validated());
        $laporan->pelapor_id = Auth::id();
        $laporan->status = Laporan::STATUS_DIKIRIM;
        $laporan->save();

        return redirect()
            ->route('laporan.index')
            ->with('status', 'Laporan berhasil dikirim.');
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
}

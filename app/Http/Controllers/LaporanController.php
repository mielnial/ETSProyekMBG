<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
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

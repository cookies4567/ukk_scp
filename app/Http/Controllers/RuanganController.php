<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();

        return view('waka.master-data.ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        return view('waka.master-data.ruangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:100',
        ], [
            'nama_ruangan.required' => 'Nama ruangan wajib diisi.',
            'nama_ruangan.string' => 'Nama ruangan harus berupa teks.',
            'nama_ruangan.max' => 'Nama ruangan maksimal 100 karakter.',
        ]);

        Ruangan::create($validated);

        return redirect()
            ->route('waka.master-data.ruangan.index')
            ->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        return view('waka.master-data.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:100',
        ], [
            'nama_ruangan.required' => 'Nama ruangan wajib diisi.',
            'nama_ruangan.string' => 'Nama ruangan harus berupa teks.',
            'nama_ruangan.max' => 'Nama ruangan maksimal 100 karakter.',
        ]);

        $ruangan->update($validated);

        return redirect()
            ->route('waka.master-data.ruangan.index')
            ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()
            ->route('waka.master-data.ruangan.index')
            ->with('success', 'Data ruangan berhasil dihapus.');
    }
}
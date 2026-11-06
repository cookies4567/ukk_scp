<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('waka.master-data.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('waka.master-data.kelas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:100',
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'nama_kelas.string' => 'Nama kelas harus berupa teks.',
            'nama_kelas.max' => 'Nama kelas maksimal 100 karakter.',
        ]);

        Kelas::create($validated);

        return redirect()
            ->route('waka.master-data.kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        return view('waka.master-data.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:100',
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'nama_kelas.string' => 'Nama kelas harus berupa teks.',
            'nama_kelas.max' => 'Nama kelas maksimal 100 karakter.',
        ]);

        $kelas->update($validated);

        return redirect()
            ->route('waka.master-data.kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()
            ->route('waka.master-data.kelas.index')
            ->with('success', 'Data kelas berhasil dihapus.');
    }
}
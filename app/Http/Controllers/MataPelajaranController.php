<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mataPelajaran = MataPelajaran::orderBy('kode_mata_pelajaran')->get();

        return view(
            'waka.master-data.mata-pelajaran.index',
            compact('mataPelajaran')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mata_pelajaran' => 'required|string|max:20|unique:mata_pelajaran,kode_mata_pelajaran',
            'nama_mata_pelajaran' => 'required|string|max:100',
        ], [
            'kode_mata_pelajaran.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mata_pelajaran.string' => 'Kode mata pelajaran harus berupa teks.',
            'kode_mata_pelajaran.max' => 'Kode mata pelajaran maksimal 20 karakter.',
            'kode_mata_pelajaran.unique' => 'Kode mata pelajaran sudah digunakan.',

            'nama_mata_pelajaran.required' => 'Nama mata pelajaran wajib diisi.',
            'nama_mata_pelajaran.string' => 'Nama mata pelajaran harus berupa teks.',
            'nama_mata_pelajaran.max' => 'Nama mata pelajaran maksimal 100 karakter.',
        ]);

        MataPelajaran::create($validated);

        return redirect()
            ->route('waka.master-data.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view(
            'waka.master-data.mata-pelajaran.edit',
            compact('mataPelajaran')
        );
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $validated = $request->validate([
            'kode_mata_pelajaran' => 'required|string|max:20|unique:mata_pelajaran,kode_mata_pelajaran,' . $mataPelajaran->id,
            'nama_mata_pelajaran' => 'required|string|max:100',
        ], [
            'kode_mata_pelajaran.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mata_pelajaran.string' => 'Kode mata pelajaran harus berupa teks.',
            'kode_mata_pelajaran.max' => 'Kode mata pelajaran maksimal 20 karakter.',
            'kode_mata_pelajaran.unique' => 'Kode mata pelajaran sudah digunakan.',

            'nama_mata_pelajaran.required' => 'Nama mata pelajaran wajib diisi.',
            'nama_mata_pelajaran.string' => 'Nama mata pelajaran harus berupa teks.',
            'nama_mata_pelajaran.max' => 'Nama mata pelajaran maksimal 100 karakter.',
        ]);

        $mataPelajaran->update($validated);

        return redirect()
            ->route('waka.master-data.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();

        return redirect()
            ->route('waka.master-data.mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('page-title', 'Mata Pelajaran')

@section('content')

<div class="mapel-page">

    {{-- HEADER --}}
    <div class="mapel-header">

        <div>
            <h2>Mata Pelajaran</h2>

            <p>
                Kelola data mata pelajaran yang digunakan dalam sistem SCP.
            </p>
        </div>

    </div>


    {{-- PESAN BERHASIL --}}
    @if (session('success'))

        <div class="mapel-alert">
            ✓ {{ session('success') }}
        </div>

    @endif


    {{-- GRID UTAMA --}}
    <div class="mapel-grid">


        {{-- =========================
             FORM TAMBAH
        ========================== --}}

        <div class="mapel-card">

            <div class="mapel-card-header">

                <h3>
                    + Tambah Mata Pelajaran
                </h3>

            </div>


            <form
                action="{{ route('waka.master-data.mata-pelajaran.store') }}"
                method="POST"
                class="mapel-form"
            >

                @csrf


                {{-- KODE MAPEL --}}

                <div class="mapel-form-group">

                    <label for="kode_mata_pelajaran">
                        Kode Mapel
                    </label>

                    <input
                        type="text"
                        id="kode_mata_pelajaran"
                        name="kode_mata_pelajaran"
                        value="{{ old('kode_mata_pelajaran') }}"
                        placeholder="Contoh: BIN1"
                        maxlength="20"
                        required
                    >

                    @error('kode_mata_pelajaran')

                        <div class="mapel-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- NAMA MAPEL --}}

                <div class="mapel-form-group">

                    <label for="nama_mata_pelajaran">
                        Nama Mata Pelajaran
                    </label>

                    <input
                        type="text"
                        id="nama_mata_pelajaran"
                        name="nama_mata_pelajaran"
                        value="{{ old('nama_mata_pelajaran') }}"
                        placeholder="Contoh: Bahasa Indonesia"
                        maxlength="100"
                        required
                    >

                    @error('nama_mata_pelajaran')

                        <div class="mapel-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <button
                    type="submit"
                    class="mapel-submit"
                >
                    Simpan Mata Pelajaran
                </button>

            </form>

        </div>


        {{-- =========================
             DAFTAR MATA PELAJARAN
        ========================== --}}

        <div class="mapel-card mapel-list-card">

            <div class="mapel-list-header">

                <h3>
                    Daftar Mata Pelajaran
                    <span>
                        ({{ $mataPelajaran->count() }})
                    </span>
                </h3>

            </div>


            {{-- PENCARIAN --}}

            <div class="mapel-search">

                <input
                    type="text"
                    id="searchMapel"
                    placeholder="Cari mata pelajaran..."
                >

            </div>


            {{-- TABEL --}}

            <div class="mapel-table-wrapper">

                <table class="mapel-table">

                    <thead>

                        <tr>

                            <th width="120">
                                Kode
                            </th>

                            <th>
                                Nama Mata Pelajaran
                            </th>

                            <th width="150">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody id="mapelTableBody">

                        @forelse ($mataPelajaran as $item)

                            <tr>

                                <td class="mapel-code">
                                    {{ $item->kode_mata_pelajaran }}
                                </td>


                                <td class="mapel-name">
                                    {{ $item->nama_mata_pelajaran }}
                                </td>


                                <td>

                                    <div class="mapel-actions">

                                        <a
                                            href="{{ route('waka.master-data.mata-pelajaran.edit', $item->id) }}"
                                            class="mapel-edit"
                                            title="Edit"
                                        >
                                            ✎
                                        </a>


                                        <form
                                            action="{{ route('waka.master-data.mata-pelajaran.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="mapel-delete"
                                                title="Hapus"
                                            >
                                                🗑
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="3"
                                    class="mapel-empty"
                                >
                                    Belum ada data mata pelajaran.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- =========================
     SEARCH
========================== --}}

@push('scripts')

<script>

    const searchMapel =
        document.getElementById('searchMapel');

    const mapelRows =
        document.querySelectorAll(
            '#mapelTableBody tr'
        );


    searchMapel.addEventListener(
        'input',
        function () {

            const keyword =
                this.value.toLowerCase();


            mapelRows.forEach(
                function (row) {

                    const text =
                        row.textContent.toLowerCase();

                    row.style.display =
                        text.includes(keyword)
                            ? ''
                            : 'none';

                }
            );

        }
    );

</script>

@endpush


{{-- =========================
     STYLE
========================== --}}

@push('styles')

<style>

    /* =========================
       HALAMAN
    ========================== */

    .mapel-page {
        width: 100%;
    }


    /* =========================
       HEADER
    ========================== */

    .mapel-header {
        margin-bottom: 20px;
    }

    .mapel-header h2 {
        margin: 0 0 6px;
        font-size: 22px;
        font-weight: 600;
        color: #1f2937;
    }

    .mapel-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }


    /* =========================
       ALERT
    ========================== */

    .mapel-alert {
        margin-bottom: 18px;
        padding: 12px 15px;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        background: #f0fdf4;
        color: #166534;
        font-size: 13px;
    }


    /* =========================
       GRID
    ========================== */

    .mapel-grid {
        display: grid;
        grid-template-columns: 310px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }


    /* =========================
       CARD
    ========================== */

    .mapel-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }


    .mapel-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .mapel-card-header h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
    }


    /* =========================
       FORM
    ========================== */

    .mapel-form {
        padding: 20px;
    }

    .mapel-form-group {
        margin-bottom: 18px;
    }

    .mapel-form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .mapel-form-group input {
        width: 100%;
        padding: 10px 11px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
        color: #1f2937;
        background: #ffffff;
        text-transform: uppercase;
    }

    .mapel-form-group input:focus {
        border-color: #9ca3af;
        box-shadow: 0 0 0 2px rgba(156, 163, 175, 0.15);
    }


    /* =========================
       ERROR
    ========================== */

    .mapel-error {
        margin-top: 6px;
        font-size: 12px;
        color: #dc2626;
    }


    /* =========================
       BUTTON SIMPAN
    ========================== */

    .mapel-submit {
        width: 100%;
        padding: 10px 14px;
        border: none;
        border-radius: 7px;
        background: #1f2937;
        color: #ffffff;
        font-size: 13px;
        cursor: pointer;
    }

    .mapel-submit:hover {
        background: #111827;
    }


    /* =========================
       LIST
    ========================== */

    .mapel-list-card {
        min-width: 0;
    }

    .mapel-list-header {
        padding: 18px 20px 12px;
    }

    .mapel-list-header h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
    }

    .mapel-list-header h3 span {
        color: #9ca3af;
        font-weight: 400;
    }


    /* =========================
       SEARCH
    ========================== */

    .mapel-search {
        padding: 0 20px 15px;
    }

    .mapel-search input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
        background: #f9fafb;
    }

    .mapel-search input:focus {
        background: #ffffff;
        border-color: #9ca3af;
    }


    /* =========================
       TABLE
    ========================== */

    .mapel-table-wrapper {
        overflow-x: auto;
    }

    .mapel-table {
        width: 100%;
        border-collapse: collapse;
    }

    .mapel-table th {
        padding: 11px 20px;
        text-align: left;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #e5e7eb;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
    }

    .mapel-table td {
        padding: 13px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #374151;
    }

    .mapel-table tbody tr:last-child td {
        border-bottom: none;
    }

    .mapel-table tbody tr:hover {
        background: #fafafa;
    }


    /* =========================
       KODE MAPEL
    ========================== */

    .mapel-code {
        font-weight: 600;
        color: #374151 !important;
        white-space: nowrap;
    }


    /* =========================
       NAMA MAPEL
    ========================== */

    .mapel-name {
        font-weight: 500;
        color: #1f2937 !important;
    }


    /* =========================
       ACTION
    ========================== */

    .mapel-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .mapel-actions form {
        margin: 0;
    }

    .mapel-edit,
    .mapel-delete {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        font-size: 13px;
    }

    .mapel-edit {
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #4b5563;
    }

    .mapel-edit:hover {
        background: #f3f4f6;
    }

    .mapel-delete {
        border: 1px solid #fecaca;
        background: #fff5f5;
        color: #dc2626;
    }

    .mapel-delete:hover {
        background: #fee2e2;
    }


    /* =========================
       EMPTY
    ========================== */

    .mapel-empty {
        padding: 30px !important;
        text-align: center;
        color: #9ca3af;
    }


    /* =========================
       RESPONSIVE
    ========================== */

    @media (max-width: 900px) {

        .mapel-grid {
            grid-template-columns: 1fr;
        }

    }

</style>

@endpush

@endsection
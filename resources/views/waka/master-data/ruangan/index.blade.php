@extends('layouts.app')

@section('title', 'Ruangan')

@section('page-title', 'Ruangan')

@section('content')

<div class="ruangan-page">

    {{-- HEADER --}}
    <div class="ruangan-header">

        <div>
            <h2>Ruangan</h2>

            <p>
                Kelola data ruangan yang digunakan dalam sistem SCP.
            </p>
        </div>

    </div>


    {{-- PESAN BERHASIL --}}
    @if (session('success'))

        <div class="ruangan-alert">
            ✓ {{ session('success') }}
        </div>

    @endif


    {{-- GRID UTAMA --}}
    <div class="ruangan-grid">


        {{-- =========================
             FORM TAMBAH RUANGAN
        ========================== --}}

        <div class="ruangan-card">

            <div class="ruangan-card-header">

                <h3>
                    + Tambah Ruangan
                </h3>

            </div>


            <form
                action="{{ route('waka.master-data.ruangan.store') }}"
                method="POST"
                class="ruangan-form"
            >

                @csrf


                <div class="ruangan-form-group">

                    <label for="nama_ruangan">
                        Nama Ruangan
                    </label>

                    <input
                        type="text"
                        id="nama_ruangan"
                        name="nama_ruangan"
                        value="{{ old('nama_ruangan') }}"
                        placeholder="Contoh: Lab Komputer 3"
                        required
                    >

                    @error('nama_ruangan')

                        <div class="ruangan-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <button
                    type="submit"
                    class="ruangan-submit"
                >
                    Simpan Ruangan
                </button>

            </form>

        </div>


        {{-- =========================
             DAFTAR RUANGAN
        ========================== --}}

        <div class="ruangan-card ruangan-list-card">

            <div class="ruangan-list-header">

                <div>

                    <h3>
                        Daftar Ruangan
                        <span>
                            ({{ $ruangan->count() }})
                        </span>
                    </h3>

                </div>

            </div>


            {{-- PENCARIAN --}}

            <div class="ruangan-search">

                <input
                    type="text"
                    id="searchRuangan"
                    placeholder="Cari ruangan..."
                >

            </div>


            {{-- TABEL --}}

            <div class="ruangan-table-wrapper">

                <table class="ruangan-table">

                    <thead>

                        <tr>

                            <th width="70">
                                ID
                            </th>

                            <th>
                                Nama Ruangan
                            </th>

                            <th width="150">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody id="ruanganTableBody">

                       @forelse ($ruangan as $item)

    @php
        $namaRuangan = strtoupper(trim($item->nama_ruangan));

        if (preg_match('/^(LABORATORIUM|LAB).*?(\d+)$/', $namaRuangan, $match)) {
    $kodeRuangan = 'LAB ' . $match[2];
} elseif (preg_match('/RUANG.*?(\d+)$/', $namaRuangan, $match)) {
    $kodeRuangan = 'R-' . $match[1];
} elseif (preg_match('/^R(?:UANG)?\s*(\d+)$/', $namaRuangan, $match)) {
    $kodeRuangan = 'R-' . $match[1];
} else {
    $kodeRuangan = 'R-' . $item->id;
}
    @endphp

    <tr>

        <td class="ruangan-id">
            {{ $kodeRuangan }}
        </td>

        <td class="ruangan-name">
            {{ $item->nama_ruangan }}
        </td>

                                <td>

                                    <div class="ruangan-actions">

                                        <a
                                            href="{{ route('waka.master-data.ruangan.edit', $item->id) }}"
                                            class="ruangan-edit"
                                            title="Edit"
                                        >
                                            ✎
                                        </a>


                                        <form
                                            action="{{ route('waka.master-data.ruangan.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="ruangan-delete"
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
                                    class="ruangan-empty"
                                >
                                    Belum ada data ruangan.
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
     SEARCH RUANGAN
========================== --}}

@push('scripts')

<script>

    const searchInput = document.getElementById('searchRuangan');

    const rows = document.querySelectorAll(
        '#ruanganTableBody tr'
    );


    searchInput.addEventListener('input', function () {

        const keyword = this.value.toLowerCase();


        rows.forEach(function (row) {

            const text = row.textContent.toLowerCase();

            row.style.display =
                text.includes(keyword)
                    ? ''
                    : 'none';

        });

    });

</script>

@endpush


{{-- =========================
     STYLE
========================== --}}

@push('styles')

<style>

    .ruangan-page {
        width: 100%;
    }


    /* HEADER */

    .ruangan-header {
        margin-bottom: 20px;
    }

    .ruangan-header h2 {
        margin: 0 0 6px;
        font-size: 22px;
        font-weight: 600;
        color: #1f2937;
    }

    .ruangan-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }


    /* ALERT */

    .ruangan-alert {
        margin-bottom: 18px;
        padding: 12px 15px;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        background: #f0fdf4;
        color: #166534;
        font-size: 13px;
    }


    /* GRID */

    .ruangan-grid {
        display: grid;
        grid-template-columns: 310px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }


    /* CARD */

    .ruangan-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }


    .ruangan-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .ruangan-card-header h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
    }


    /* FORM */

    .ruangan-form {
        padding: 20px;
    }

    .ruangan-form-group {
        margin-bottom: 18px;
    }

    .ruangan-form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .ruangan-form-group input {
        width: 100%;
        padding: 10px 11px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
        color: #1f2937;
        background: #ffffff;
    }

    .ruangan-form-group input:focus {
        border-color: #9ca3af;
        box-shadow: 0 0 0 2px rgba(156, 163, 175, 0.15);
    }


    /* ERROR */

    .ruangan-error {
        margin-top: 6px;
        font-size: 12px;
        color: #dc2626;
    }


    /* BUTTON SIMPAN */

    .ruangan-submit {
        width: 100%;
        padding: 10px 14px;
        border: none;
        border-radius: 7px;
        background: #1f2937;
        color: #ffffff;
        font-size: 13px;
        cursor: pointer;
    }

    .ruangan-submit:hover {
        background: #111827;
    }


    /* LIST */

    .ruangan-list-card {
        min-width: 0;
    }

    .ruangan-list-header {
        padding: 18px 20px 12px;
    }

    .ruangan-list-header h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
    }

    .ruangan-list-header h3 span {
        color: #9ca3af;
        font-weight: 400;
    }


    /* SEARCH */

    .ruangan-search {
        padding: 0 20px 15px;
    }

    .ruangan-search input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        outline: none;
        font-size: 13px;
        background: #f9fafb;
    }

    .ruangan-search input:focus {
        background: #ffffff;
        border-color: #9ca3af;
    }


    /* TABLE */

    .ruangan-table-wrapper {
        overflow-x: auto;
    }

    .ruangan-table {
        width: 100%;
        border-collapse: collapse;
    }

    .ruangan-table th {
        padding: 11px 20px;
        text-align: left;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #e5e7eb;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
    }

    .ruangan-table td {
        padding: 13px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #374151;
    }

    .ruangan-table tbody tr:last-child td {
        border-bottom: none;
    }

    .ruangan-table tbody tr:hover {
        background: #fafafa;
    }

    .ruangan-id {
    font-weight: 600;
    color: #374151 !important;
    white-space: nowrap;        
    }

    .ruangan-name {
        font-weight: 500;
        color: #1f2937 !important;
    }


    /* ACTION */

    .ruangan-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ruangan-actions form {
        margin: 0;
    }

    .ruangan-edit,
    .ruangan-delete {
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

    .ruangan-edit {
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #4b5563;
    }

    .ruangan-edit:hover {
        background: #f3f4f6;
    }

    .ruangan-delete {
        border: 1px solid #fecaca;
        background: #fff5f5;
        color: #dc2626;
    }

    .ruangan-delete:hover {
        background: #fee2e2;
    }


    /* EMPTY */

    .ruangan-empty {
        padding: 30px !important;
        text-align: center;
        color: #9ca3af;
    }


    /* RESPONSIVE */

    @media (max-width: 900px) {

        .ruangan-grid {
            grid-template-columns: 1fr;
        }

    }

</style>

@endpush

@endsection
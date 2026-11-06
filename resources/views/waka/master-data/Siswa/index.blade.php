
@extends('layouts.app')

@section('page-title', 'Manajemen Siswa')

@section('content')

<style>
    .siswa-page {
        max-width: 1200px;
        margin: auto;
    }

    .siswa-heading {
        margin-bottom: 22px;
    }

    .siswa-heading h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .siswa-heading p {
        color: #718096;
        font-size: 13px;
        margin: 0;
    }

    .siswa-stats {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .siswa-stat-card {
        background: white;
        border: 1px solid #dce3ed;
        border-radius: 10px;
        padding: 18px;
    }

    .siswa-stat-card h4 {
        font-size: 25px;
        font-weight: 700;
        margin: 0 0 5px;
        color: #17365d;
    }

    .siswa-stat-card span {
        color: #718096;
        font-size: 12px;
    }

    .siswa-card {
        background: white;
        border: 1px solid #dce3ed;
        border-radius: 10px;
        overflow: hidden;
    }

    .siswa-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e5eaf1;
    }

    .siswa-card-header h4 {
        font-size: 15px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .siswa-card-header p {
        font-size: 12px;
        color: #718096;
        margin: 0;
    }

    .siswa-filter {
        display: grid;
        grid-template-columns: 1fr 2fr auto;
        gap: 12px;
        padding: 18px 20px;
        border-bottom: 1px solid #e5eaf1;
    }

    .siswa-filter label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .siswa-filter input,
    .siswa-filter select {
        width: 100%;
        height: 40px;
        border: 1px solid #dce3ed;
        border-radius: 7px;
        padding: 0 11px;
        font-size: 13px;
        background: white;
    }

    .siswa-filter button,
    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 40px;
        padding: 0 17px;
        border-radius: 7px;
        border: none;
        background: #17365d;
        color: white;
        text-decoration: none;
        font-size: 13px;
        cursor: pointer;
    }

    .btn-reset {
        background: #edf1f6;
        color: #334155;
        margin-left: 5px;
    }

    .siswa-table-wrapper {
        overflow-x: auto;
    }

    .siswa-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .siswa-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        text-transform: uppercase;
        text-align: left;
        padding: 13px 18px;
        white-space: nowrap;
    }

    .siswa-table td {
        padding: 14px 18px;
        border-top: 1px solid #edf0f5;
        font-size: 13px;
        color: #334155;
    }

    .siswa-table tbody tr:hover {
        background: #fafcff;
    }

    .siswa-name {
        font-weight: 600;
        color: #17365d;
    }

    .kelas-badge {
        display: inline-block;
        background: #eaf2ff;
        color: #245b9e;
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 600;
    }

    .siswa-empty {
        text-align: center;
        padding: 45px 15px !important;
        color: #718096 !important;
    }

    .siswa-pagination {
        padding: 17px 20px;
        border-top: 1px solid #edf0f5;
    }

    .siswa-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 700px) {
        .siswa-stats {
            grid-template-columns: 1fr 1fr;
        }

        .siswa-filter {
            grid-template-columns: 1fr;
        }

        .siswa-filter-actions {
            display: flex;
        }
    }
</style>

<div class="siswa-page">

    <div class="siswa-heading">
        <h3>Manajemen Siswa</h3>
        <p>
            Kelola dan pantau seluruh data siswa yang terdaftar
            dalam sistem SCP.
        </p>
    </div>

    {{-- Statistik --}}
    <div class="siswa-stats">

        <div class="siswa-stat-card">
            <h4>{{ number_format($totalSiswa, 0, ',', '.') }}</h4>
            <span>Total Siswa Terdaftar</span>
        </div>

        <div class="siswa-stat-card">
            <h4>{{ number_format($totalKelas, 0, ',', '.') }}</h4>
            <span>Total Kelas Tersedia</span>
        </div>

    </div>

    {{-- Daftar siswa --}}
    <div class="siswa-card">

        <div class="siswa-card-header">
            <h4>Daftar Seluruh Siswa</h4>
            <p>
                Data siswa diambil langsung dari database SCP.
            </p>
        </div>

        {{-- Filter dan pencarian --}}
        <form
            action="{{ route('waka.master-data.siswa.index') }}"
            method="GET"
            class="siswa-filter"
        >

            <div>
                <label for="kelas_id">Filter Kelas</label>

                <select name="kelas_id" id="kelas_id">
                    <option value="">Semua Kelas</option>

                    @foreach ($daftarKelas as $kelas)
                        <option
                            value="{{ $kelas->id }}"
                            {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}
                        >
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label for="cari">Cari Nama atau NIS Siswa</label>

                <input
                    type="text"
                    name="cari"
                    id="cari"
                    value="{{ request('cari') }}"
                    placeholder="Masukkan nama atau NIS siswa..."
                >
            </div>

            <div class="siswa-filter-actions">
                <button type="submit">
                    Cari
                </button>

                <a
                    href="{{ route('waka.master-data.siswa.index') }}"
                    class="btn-reset"
                >
                    Reset
                </a>
            </div>

        </form>

        {{-- Tabel siswa --}}
        <div class="siswa-table-wrapper">

            <table class="siswa-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($siswa as $index => $item)

                        <tr>
                            <td>
                                {{ $siswa->firstItem() + $index }}
                            </td>

                            <td>
                                {{ $item->nis ?: '-' }}
                            </td>

                            <td>
                                <span class="siswa-name">
                                    {{ $item->nama_lengkap }}
                                </span>
                            </td>

                            <td>
                                {{ $item->jenis_kelamin ?: '-' }}
                            </td>

                            <td>
                                @if ($item->kelas)
                                    <span class="kelas-badge">
                                        {{ $item->kelas->nama_kelas }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="siswa-empty">
                                @if (request()->filled('cari') || request()->filled('kelas_id'))
                                    Tidak ditemukan siswa yang sesuai dengan pencarian atau filter.
                                @else
                                    Belum ada data siswa yang terdaftar.
                                @endif
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if ($siswa->hasPages())
            <div class="siswa-pagination">
                {{ $siswa->links() }}
            </div>
        @endif

    </div>

</div>

@endsection

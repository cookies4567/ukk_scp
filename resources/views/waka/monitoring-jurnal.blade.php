
@extends('layouts.app')

@section('content')
<style>
    .monitor-page {
        --monitor-primary: #2563eb;
        --monitor-text: #172b4d;
        --monitor-muted: #64748b;
        --monitor-border: #e2e8f0;
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
        padding: 28px;
        color: var(--monitor-text);
        font-family: inherit;
        box-sizing: border-box;
    }

    .monitor-page *,
    .monitor-page *::before,
    .monitor-page *::after {
        box-sizing: border-box;
    }

    .monitor-page .monitor-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .monitor-page .monitor-title {
        font-size: 26px;
        line-height: 1.3;
        font-weight: 750;
        margin: 0 0 7px;
        color: var(--monitor-text);
    }

    .monitor-page .monitor-subtitle {
        color: var(--monitor-muted);
        margin: 0;
        font-size: 14px;
        line-height: 1.6;
    }

    .monitor-page .monitor-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        min-height: 42px;
        padding: 10px 16px;
        border-radius: 9px;
        border: 1px solid transparent;
        font: inherit;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none !important;
        cursor: pointer;
        transition: background .15s, border-color .15s;
    }

    .monitor-page .monitor-btn-primary {
        background: var(--monitor-primary);
        color: #fff !important;
    }

    .monitor-page .monitor-btn-primary:hover {
        background: #1d4ed8;
    }

    .monitor-page .monitor-btn-outline {
        color: #334155 !important;
        background: #fff;
        border-color: #cbd5e1;
    }

    .monitor-page .monitor-btn-outline:hover {
        background: #f8fafc;
    }

    .monitor-page .monitor-btn-reset {
        color: #475569 !important;
        background: #f8fafc;
        border-color: var(--monitor-border);
    }

    .monitor-page .monitor-card {
        background: #fff;
        border: 1px solid var(--monitor-border);
        border-radius: 14px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .monitor-page .monitor-summary {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(160px, auto);
        align-items: center;
        gap: 20px;
        padding: 24px;
    }

    .monitor-page .monitor-label {
        font-size: 13px;
        color: var(--monitor-muted);
        margin-bottom: 8px;
    }

    .monitor-page .monitor-value {
        font-size: 19px;
        font-weight: 700;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .monitor-page .monitor-total {
        text-align: right;
        padding-left: 24px;
        border-left: 1px solid var(--monitor-border);
    }

    .monitor-page .monitor-section-heading {
        font-size: 17px;
        font-weight: 700;
        margin: 0 0 6px;
        color: var(--monitor-text);
    }

    .monitor-page .monitor-section-description {
        font-size: 13px;
        line-height: 1.6;
        color: var(--monitor-muted);
        margin: 0;
    }

    .monitor-page .monitor-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--monitor-border);
    }

    .monitor-page .monitor-filter-body {
        padding: 24px;
    }

    .monitor-page .monitor-filter-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) auto;
        align-items: end;
        gap: 18px;
    }

    .monitor-page .monitor-field {
        min-width: 0;
    }

    .monitor-page .monitor-field label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #334155;
    }

    .monitor-page .monitor-control {
        display: block;
        width: 100%;
        height: 44px;
        padding: 10px 12px;
        background: #fff;
        color: #1e293b;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font: inherit;
        font-size: 14px;
        outline: none;
    }

    .monitor-page .monitor-control:focus {
        border-color: var(--monitor-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    .monitor-page .monitor-filter-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .monitor-page .monitor-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .monitor-page .monitor-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
        border-spacing: 0;
        margin: 0;
    }

    .monitor-page .monitor-table th {
        padding: 15px 16px;
        text-align: left;
        background: #f8fafc;
        color: #475569;
        border-bottom: 1px solid var(--monitor-border);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .035em;
        white-space: nowrap;
    }

    .monitor-page .monitor-table td {
        padding: 16px;
        border-bottom: 1px solid #edf1f5;
        color: #334155;
        font-size: 13px;
        line-height: 1.65;
        vertical-align: top;
    }

    .monitor-page .monitor-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .monitor-page .monitor-table tbody tr:hover {
        background: #f8fbff;
    }

    .monitor-page .monitor-number {
        color: var(--monitor-muted);
        width: 55px;
    }

    .monitor-page .monitor-teacher {
        font-weight: 650;
        color: var(--monitor-text);
        min-width: 145px;
    }

    .monitor-page .monitor-nowrap {
        white-space: nowrap;
    }

    .monitor-page .monitor-badge {
        display: inline-block;
        padding: 5px 10px;
        background: #eff6ff;
        color: #1d4ed8;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 650;
        white-space: nowrap;
    }

    .monitor-page .monitor-muted {
        color: var(--monitor-muted);
    }

    .monitor-page .monitor-photo {
        color: var(--monitor-primary);
        text-decoration: none;
        font-weight: 650;
        white-space: nowrap;
    }

    .monitor-page .monitor-photo:hover {
        text-decoration: underline;
    }

    .monitor-page .monitor-empty {
        text-align: center;
        padding: 48px 20px !important;
        color: var(--monitor-muted) !important;
    }

    .monitor-page .monitor-empty strong {
        display: block;
        color: var(--monitor-text);
        font-size: 15px;
        margin-bottom: 6px;
    }

    .monitor-page .monitor-pagination {
        padding: 18px 24px;
        border-top: 1px solid var(--monitor-border);
    }

    .monitor-page .monitor-pagination nav p {
        font-size: 13px;
        color: var(--monitor-muted);
    }

    .monitor-page .monitor-alert {
        border-radius: 9px;
        padding: 13px 16px;
        margin-bottom: 18px;
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #bbf7d0;
        font-size: 14px;
    }

    @media (max-width: 900px) {
        .monitor-page {
            padding: 22px 18px;
        }

        .monitor-page .monitor-filter-grid {
            grid-template-columns: 1fr 1fr;
        }

        .monitor-page .monitor-filter-actions {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 560px) {
        .monitor-page {
            padding: 18px 12px;
        }

        .monitor-page .monitor-title {
            font-size: 22px;
        }

        .monitor-page .monitor-heading {
            align-items: flex-start;
        }

        .monitor-page .monitor-summary {
            grid-template-columns: 1fr;
            padding: 20px;
            gap: 16px;
        }

        .monitor-page .monitor-total {
            text-align: left;
            padding: 14px 0 0;
            border-left: 0;
            border-top: 1px solid var(--monitor-border);
        }

        .monitor-page .monitor-filter-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .monitor-page .monitor-filter-actions {
            grid-column: auto;
        }

        .monitor-page .monitor-card-header,
        .monitor-page .monitor-filter-body {
            padding: 18px;
        }
    }
</style>

<div class="monitor-page">

    <div class="monitor-heading">
        <div>
            <h1 class="monitor-title">Monitoring Jurnal Guru</h1>
            <p class="monitor-subtitle">
                Pantau dan periksa jurnal mengajar guru secara terstruktur.
            </p>
        </div>

        <a href="{{ route('waka.dashboard') }}"
           class="monitor-btn monitor-btn-outline">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @if (session('success'))
        <div class="monitor-alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="monitor-card">
        <div class="monitor-summary">
            <div>
                <div class="monitor-label">Siklus pembelajaran aktif</div>
                <div class="monitor-value">
                    {{ $siklusAktif ?? 'Belum diatur' }}
                </div>
            </div>

            <div class="monitor-total">
                <div class="monitor-label">Total jurnal sesuai filter</div>
                <div class="monitor-value">{{ $jurnal->total() }}</div>
            </div>
        </div>
    </div>

    <div class="monitor-card">
        <div class="monitor-card-header">
            <h2 class="monitor-section-heading">Filter Jurnal</h2>
            <p class="monitor-section-description">
                Pilih tanggal atau guru untuk mempersempit hasil pencarian.
            </p>
        </div>

        <div class="monitor-filter-body">
            <form method="GET" action="{{ route('waka.monitoring-jurnal') }}">
                <div class="monitor-filter-grid">
                    <div class="monitor-field">
                        <label for="tanggal">Tanggal jurnal</label>
                        <input
                            class="monitor-control"
                            type="date"
                            id="tanggal"
                            name="tanggal"
                            value="{{ request('tanggal') }}"
                        >
                    </div>

                    <div class="monitor-field">
                        <label for="guru_id">Nama guru</label>
                        <select
                            class="monitor-control"
                            id="guru_id"
                            name="guru_id"
                        >
                            <option value="">Semua guru</option>
                            @foreach ($guru as $itemGuru)
                                <option
                                    value="{{ $itemGuru->id }}"
                                    @selected((string) request('guru_id') === (string) $itemGuru->id)
                                >
                                    {{ $itemGuru->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="monitor-filter-actions">
                        <button type="submit"
                                class="monitor-btn monitor-btn-primary">
                            Terapkan
                        </button>

                        <a href="{{ route('waka.monitoring-jurnal') }}"
                           class="monitor-btn monitor-btn-reset">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="monitor-card">
        <div class="monitor-card-header">
            <h2 class="monitor-section-heading">Daftar Jurnal Mengajar</h2>
            <p class="monitor-section-description">
                Menampilkan jurnal terbaru pada siklus aktif.
            </p>
        </div>

        <div class="monitor-table-wrap">
            <table class="monitor-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Materi</th>
                        <th>Dokumentasi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jurnal as $item)
                        <tr>
                            <td class="monitor-number">
                                {{ $jurnal->firstItem() + $loop->index }}
                            </td>

                            <td class="monitor-nowrap">
                                {{ $item->tanggal }}
                            </td>

                            <td class="monitor-teacher">
                                {{ $item->jadwal?->guru?->nama_lengkap ?? '-' }}
                            </td>

                            <td>
                                {{ $item->jadwal?->mata_pelajaran ?? '-' }}
                            </td>

                            <td>
                                <span class="monitor-badge">
                                    {{ $item->jadwal?->kelas?->nama_kelas ?? '-' }}
                                </span>
                            </td>

                            <td style="min-width: 200px; max-width: 360px; overflow-wrap: anywhere;">
                                {{ $item->deskripsi_materi }}
                            </td>

                            <td>
                                @if ($item->path_foto)
                                    <a
                                        class="monitor-photo"
                                        href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->path_foto) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        Lihat foto &rarr;
                                    </a>
                                @else
                                    <span class="monitor-muted">Tidak ada foto</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="monitor-empty">
                                <strong>Belum ada jurnal mengajar</strong>
                                Belum ada jurnal yang sesuai dengan filter dan siklus aktif.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($jurnal->hasPages())
            <div class="monitor-pagination">
                {{ $jurnal->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

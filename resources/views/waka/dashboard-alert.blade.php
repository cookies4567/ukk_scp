
@extends('layouts.app')

@section('content')
<style>
    .alert-page {
        padding: 28px;
        max-width: 1400px;
        margin: auto;
        color: #172b4d;
    }

    .alert-page * {
        box-sizing: border-box;
    }

    .alert-page .alert-header {
        margin-bottom: 24px;
    }

    .alert-page .alert-title {
        font-size: 26px;
        font-weight: 750;
        margin: 0 0 8px;
    }

    .alert-page .alert-subtitle {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .alert-page .alert-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .alert-page .alert-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        padding: 24px;
    }

    .alert-page .alert-label {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .alert-page .alert-count {
        color: #b91c1c;
        font-size: 32px;
        font-weight: 750;
    }

    .alert-page .alert-cycle {
        font-size: 17px;
        font-weight: 700;
    }

    .alert-page .alert-section-title {
        font-size: 17px;
        font-weight: 700;
        margin: 0 0 6px;
    }

    .alert-page .alert-section-subtitle {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    .alert-page .alert-card-heading {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
    }

    .alert-page .alert-table-wrap {
        overflow-x: auto;
    }

    .alert-page .alert-table {
        width: 100%;
        min-width: 720px;
        border-collapse: collapse;
    }

    .alert-page .alert-table th {
        text-align: left;
        background: #f8fafc;
        color: #475569;
        padding: 14px 16px;
        font-size: 12px;
        text-transform: uppercase;
        border-bottom: 1px solid #e2e8f0;
    }

    .alert-page .alert-table td {
        padding: 16px;
        border-bottom: 1px solid #edf1f5;
        font-size: 13px;
        line-height: 1.6;
        vertical-align: top;
    }

    .alert-page .alert-table tr:last-child td {
        border-bottom: 0;
    }

    .alert-page .alert-danger {
        display: inline-block;
        background: #fef2f2;
        color: #b91c1c;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .alert-page .alert-empty {
        padding: 42px 20px !important;
        text-align: center;
        color: #64748b;
    }

    .alert-page .alert-empty strong {
        display: block;
        font-size: 16px;
        color: #166534;
        margin-bottom: 8px;
    }

    .alert-page .alert-muted {
        color: #64748b;
    }

    @media (max-width: 600px) {
        .alert-page {
            padding: 18px 12px;
        }

        .alert-page .alert-title {
            font-size: 22px;
        }

        .alert-page .alert-summary {
            padding: 20px;
        }
    }
</style>

<div class="alert-page">
    <div class="alert-header">
        <h1 class="alert-title">Dashboard Alert</h1>
        <div id="alert-notification"
     style="display:none; padding:12px 16px; margin:16px 0;
            background:#fff3cd; color:#856404;
            border:1px solid #ffe69c; border-radius:8px;"
     role="status"
     aria-live="polite">
</div>
        <p class="alert-subtitle">
            Pemantauan keterlambatan pengisian jurnal mengajar guru.
        </p>
    </div>

    <div class="alert-card">
        <div class="alert-summary">
            <div>
                <div class="alert-label">Jurnal terlambat lebih dari 30 menit</div>
                <div class="alert-count" id="alert-count">
                    {{ $alert->count() }}
                </div>
            </div>

            <div>
                <div class="alert-label">Siklus aktif</div>
                <div class="alert-cycle">{{ $siklusAktif }}</div>
                <div class="alert-label" style="margin-top: 8px;">
                    {{ $waktuSekarang->translatedFormat('l, d F Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <div class="alert-card">
        <div class="alert-card-heading">
            <h2 class="alert-section-title">Daftar Peringatan</h2>
            <p class="alert-section-subtitle">
                Jadwal yang telah melewati batas pengisian jurnal.
            </p>
        </div>

        <div class="alert-table-wrap">
            <table class="alert-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody id="alert-table-body">
                    @forelse ($alert as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>
                                    {{ $item->guru?->nama_lengkap ?? '-' }}
                                </strong>
                            </td>
                            <td>{{ $item->mata_pelajaran }}</td>
                            <td>{{ $item->kelas?->nama_kelas ?? '-' }}</td>
                            <td>{{ $item->jam_selesai }}</td>
                            <td>
                                <span class="alert-danger">
                                    Belum mengisi jurnal
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="alert-empty">
                                <strong>Tidak ada jurnal terlambat</strong>
                                Semua jadwal yang sudah melewati batas 30 menit
                                telah memiliki jurnal, atau belum ada jadwal
                                yang memenuhi kondisi alert hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const countElement = document.getElementById('alert-count');
    const tableBody = document.getElementById('alert-table-body');

    if (!countElement || !tableBody) {
        console.error('Elemen Dashboard Alert belum ditemukan.');
        return;
    }

    const escapeHtml = (value) => {
        const element = document.createElement('span');
        element.textContent = value ?? '-';
        return element.innerHTML;
    };

    let previousAlertIds = null;

    async function periksaAlert() {
        try {
            const response = await fetch(
                '{{ route("waka.dashboard-alert.data") }}',
                {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    cache: 'no-store'
                }
            );

            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }

            const data = await response.json();
            const alerts = data.alerts ?? [];

            // Perbarui jumlah alert.
            countElement.textContent = data.total;

            // Deteksi alert baru berdasarkan ID jadwal.
            const currentAlertIds = alerts
                .map(item => String(item.id))
                .sort();

            if (previousAlertIds !== null) {
                const newAlerts = alerts.filter(
                    item => !previousAlertIds.includes(String(item.id))
                );
                if (newAlerts.length > 0) {
                    const notification = document.getElementById('alert-notification');

                    notification.style.display = 'block';
                    notification.textContent =
                        `Ada ${newAlerts.length} peringatan baru: ` +
                        newAlerts.map(item =>
                            `${item.guru} — ${item.mata_pelajaran}`
                        ).join(', ');

                    console.info('Alert baru terdeteksi:', newAlerts.length);
                }
            }

            previousAlertIds = currentAlertIds;

            // Perbarui isi tabel.
            if (alerts.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align:center; padding:20px;">
                            Tidak ada jurnal yang terlambat.
                        </td>
                    </tr>
                `;
            } else {
                tableBody.innerHTML = alerts.map((item, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${escapeHtml(item.guru)}</td>
                        <td>${escapeHtml(item.mata_pelajaran)}</td>
                        <td>${escapeHtml(item.kelas)}</td>
                        <td>${escapeHtml(item.jam_selesai)}</td>
                        <td>
                            <span class="alert-danger">
                                Belum mengisi jurnal
                            </span>
                        </td>
                    </tr>
                `).join('');
            }

            console.log(
                'Pemeriksaan alert berhasil:',
                data.total,
                'alert pada',
                data.waktu
            );
        } catch (error) {
            console.error(
                'Gagal memeriksa Dashboard Alert:',
                error
            );
        }
    }

    // Pemeriksaan pertama dan selanjutnya setiap 30 detik.
    periksaAlert();
    setInterval(periksaAlert, 30000);
});
</script>

@endsection

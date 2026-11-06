
@extends('layouts.app')

@section('page-title', 'Verifikasi Izin')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 8px;">
            Verifikasi Izin Siswa
        </h2>
        <p style="font-size: 14px; color: #6b7280; margin: 0;">
            Periksa pengajuan izin siswa, lalu pilih terima atau tolak.
        </p>
    </div>

    @if (session('success'))
        <div style="padding: 12px 16px; margin-bottom: 18px; border-radius: 8px; background: #dcfce7; color: #166534;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="padding: 12px 16px; margin-bottom: 18px; border-radius: 8px; background: #fee2e2; color: #991b1b;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="padding: 12px 16px; margin-bottom: 18px; border-radius: 8px; background: #fee2e2; color: #991b1b;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">

        <div style="padding: 18px 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div>
                <h3 style="font-size: 16px; font-weight: 700; margin: 0; color: #1f2937;">
                    Daftar Pengajuan Menunggu
                </h3>
                <p style="font-size: 13px; color: #6b7280; margin: 5px 0 0;">
                    Pengajuan yang belum mendapatkan keputusan.
                </p>
            </div>

            <a href="{{ route('verifikasi.riwayat') }}"
               style="display: inline-block; padding: 9px 13px; border: 1px solid #d1d5db; border-radius: 7px; color: #374151; text-decoration: none; font-size: 13px;">
                Lihat Riwayat
            </a>
        </div>

        @if ($pengajuan->isEmpty())
            <div style="padding: 48px 20px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 12px;">📄</div>
                <h3 style="font-size: 16px; color: #374151; margin: 0 0 6px;">
                    Belum ada pengajuan izin
                </h3>
                <p style="font-size: 13px; color: #6b7280; margin: 0;">
                    Pengajuan baru dari siswa akan muncul di halaman ini.
                </p>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                    <thead>
                        <tr style="background: #f9fafb; color: #6b7280;">
                            <th style="padding: 13px 16px; white-space: nowrap;">Siswa</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Kelas</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Tanggal Izin</th>
                            <th style="padding: 13px 16px; min-width: 180px;">Alasan</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Dokumen</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Keputusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuan as $item)
                            <tr style="border-top: 1px solid #e5e7eb; color: #374151;">
                                <td style="padding: 16px; vertical-align: top;">
                                    <div style="font-weight: 600;">
                                        {{ $item->siswa->nama_lengkap ?? 'Nama tidak tersedia' }}
                                    </div>
                                    <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">
                                        Pengaju: {{ $item->pengaju->nama_lengkap ?? 'Tidak tersedia' }}
                                    </div>
                                </td>

                                <td style="padding: 16px; vertical-align: top; white-space: nowrap;">
                                     {{ $item->siswa->kelas->nama_kelas ?? 'Kelas belum ditentukan' }}
                                </td>

                                <td style="padding: 16px; vertical-align: top; white-space: nowrap;">
                                    {{ $item->tanggal_mulai }}
                                    @if ($item->tanggal_selesai && $item->tanggal_selesai !== $item->tanggal_mulai)
                                        <div style="margin-top: 4px; color: #6b7280;">
                                            s.d. {{ $item->tanggal_selesai }}
                                        </div>
                                    @endif
                                </td>

                                <td style="padding: 16px; vertical-align: top;">
                                    {{ $item->alasan }}
                                </td>

                                <td style="padding: 16px; vertical-align: top; white-space: nowrap;">
                                   @if ($item->path_dokumen)
                                    <a href="{{ route('verifikasi.izin.dokumen', ['pengajuan' => $item->id]) }}"
                                         target="_blank"
                                         rel="noopener noreferrer"
                                         style="display: inline-block; padding: 8px 12px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 7px; text-decoration: none; font-size: 13px; font-weight: 600;">
                                            Lihat Surat
                                    </a>
                                    @else
                                        <span style="color: #9ca3af;">Tidak ada dokumen</span>
                                    @endif
                                </td>

                                <td style="padding: 16px; vertical-align: top; min-width: 180px;">
                                    <div style="display: flex; flex-direction: column; gap: 8px;">

                                        <form method="POST"
                                              action="{{ route('verifikasi.izin.proses', ['pengajuan' => $item->id]) }}"
                                              onsubmit="return confirm('Yakin ingin MENYETUJUI pengajuan izin ini?')">
                                            @csrf

                                            <input type="hidden" name="status_persetujuan" value="Disetujui">

                                            <button type="submit"
                                                    style="width: 100%; padding: 9px 12px; background: #16a34a; color: #fff; border: none; border-radius: 7px; cursor: pointer; font-size: 13px; font-weight: 600;">
                                                ✓ Terima
                                            </button>
                                        </form>

                                        <button
                                            type="button"
                                            class="btn-reject-open"
                                            data-action="{{ route('verifikasi.izin.proses', ['pengajuan' => $item->id]) }}"
                                            data-student="{{ $item->siswa->nama_lengkap ?? 'Siswa' }}"
                                            data-class="{{ $item->siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}"
                                            data-date="{{ $item->tanggal_mulai }}"
                                            data-reason="{{ $item->alasan }}"
                                        >
                                            ✕ Tolak
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<style>
    .reject-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(3px);
    }

    .reject-modal.show {
        display: flex;
    }

    .reject-modal-content {
        width: 100%;
        max-width: 480px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18);
        overflow: hidden;
        animation: modalFadeIn .2s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .reject-modal-header {
        padding: 22px 24px;
        border-bottom: 1px solid #edf0f3;
    }

    .reject-modal-header h3 {
        margin: 0;
        color: #1f2937;
        font-size: 18px;
        font-weight: 700;
    }

    .reject-modal-header p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.5;
    }

    .reject-modal-body {
        padding: 22px 24px;
    }

    .reject-info {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 22px;
    }

    .reject-info-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 7px 0;
        font-size: 13px;
    }

    .reject-info-row:not(:last-child) {
        border-bottom: 1px solid #edf0f3;
    }

    .reject-info-label {
        color: #6b7280;
        flex-shrink: 0;
    }

    .reject-info-value {
        color: #1f2937;
        font-weight: 600;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .reject-reason-label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
    }

    .reject-reason-label span {
        color: #dc2626;
    }

    .reject-modal-content textarea {
        display: block;
        width: 100%;
        min-height: 115px;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        resize: vertical;
        box-sizing: border-box;
        font-family: inherit;
        font-size: 13px;
        line-height: 1.6;
        color: #1f2937;
        transition: border-color .2s, box-shadow .2s;
    }

    .reject-modal-content textarea:focus {
        border-color: #64748b;
        box-shadow: 0 0 0 3px rgba(100, 116, 139, .12);
    }

    .reject-modal-content textarea::placeholder {
        color: #9ca3af;
    }

    .reject-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 24px;
        border-top: 1px solid #edf0f3;
        background: #fafafa;
    }

    .reject-modal-footer button {
        min-height: 38px;
        padding: 9px 16px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s, border-color .2s;
    }

    .reject-cancel {
        color: #374151;
        background: #ffffff;
        border: 1px solid #d1d5db;
    }

    .reject-cancel:hover {
        background: #f3f4f6;
    }

    .reject-confirm {
        color: #ffffff;
        background: #b42318;
        border: 1px solid #b42318;
    }

    .reject-confirm:hover {
        background: #912018;
        border-color: #912018;
    }

    @media (max-width: 520px) {
        .reject-modal {
            padding: 12px;
        }

        .reject-modal-header,
        .reject-modal-body {
            padding: 18px;
        }

        .reject-modal-footer {
            padding: 14px 18px;
        }
    }
</style>

<div class="reject-modal" id="rejectModal">
    <div class="reject-modal-content">

        <div class="reject-modal-header">
            <h3>Penolakan Pengajuan Izin</h3>
            <p>
                Silakan periksa informasi pengajuan dan masukkan alasan
                penolakan sebelum melanjutkan.
            </p>
        </div>

        <form method="POST" id="rejectForm">
            @csrf

            <input type="hidden" name="status_persetujuan" value="Ditolak">

            <div class="reject-modal-body">

                <div class="reject-info">
                    <div class="reject-info-row">
                        <span class="reject-info-label">Nama Siswa</span>
                        <span class="reject-info-value" id="rejectStudent"></span>
                    </div>

                    <div class="reject-info-row">
                        <span class="reject-info-label">Kelas</span>
                        <span class="reject-info-value" id="rejectClass"></span>
                    </div>

                    <div class="reject-info-row">
                        <span class="reject-info-label">Tanggal</span>
                        <span class="reject-info-value" id="rejectDate"></span>
                    </div>

                    <div class="reject-info-row">
                        <span class="reject-info-label">Alasan Pengajuan</span>
                        <span class="reject-info-value" id="rejectRequestReason"></span>
                    </div>
                </div>

                <label for="alasan_penolakan" class="reject-reason-label">
                    Alasan Penolakan <span>*</span>
                </label>

                <textarea
                    name="alasan_penolakan"
                    id="alasan_penolakan"
                    maxlength="1000"
                    placeholder="Tuliskan alasan penolakan secara jelas..."
                    required
                ></textarea>

            </div>

            <div class="reject-modal-footer">
                <button
                    type="button"
                    class="reject-cancel"
                    id="closeRejectModal"
                >
                    Batal
                </button>

                <button type="submit" class="reject-confirm">
                    Konfirmasi Penolakan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    const rejectModal = document.getElementById('rejectModal');
    const rejectForm = document.getElementById('rejectForm');
    const rejectTextarea = document.getElementById('alasan_penolakan');

    document.querySelectorAll('.btn-reject-open').forEach(button => {
        button.addEventListener('click', function () {
            rejectForm.action = this.dataset.action;

            document.getElementById('rejectStudent').textContent =
                this.dataset.student;

            document.getElementById('rejectClass').textContent =
                this.dataset.class;

            document.getElementById('rejectDate').textContent =
                this.dataset.date;

            document.getElementById('rejectRequestReason').textContent =
                this.dataset.reason;

            rejectTextarea.value = '';
            rejectModal.classList.add('show');
            rejectTextarea.focus();
        });
    });

    document.getElementById('closeRejectModal').addEventListener('click', () => {
        rejectModal.classList.remove('show');
    });

    rejectModal.addEventListener('click', event => {
        if (event.target === rejectModal) {
            rejectModal.classList.remove('show');
        }
    });
</script>
@endsection

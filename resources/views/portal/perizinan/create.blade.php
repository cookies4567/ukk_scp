
@extends('layouts.app')

@section('title', 'Ajukan Izin')
@section('page-title', 'Form Pengajuan Izin')

@section('menu')
    <div class="menu-title">Menu Utama</div>

    <a href="{{ route('portal.dashboard') }}">Dashboard</a>
    <a href="#">Rekap Kehadiran</a>
    <a href="{{ route('portal.perizinan.index') }}" class="active">
        Pengajuan Izin
    </a>
@endsection

@section('content')
    <style>
        .izin-form-card {
            max-width: 100%;
            padding: 28px;
        }

        .izin-form-heading {
            margin: 0 0 8px;
            color: #172033;
            font-size: 21px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .izin-form-description {
            margin: 0 0 26px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .izin-field {
            margin-bottom: 22px;
        }

        .izin-label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 14px;
            font-weight: 600;
        }

        .izin-input {
            display: block;
            box-sizing: border-box;
            width: 100%;
            min-height: 46px;
            padding: 11px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #fff;
            color: #1e293b;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .izin-input:focus {
            border-color: #64748b;
            box-shadow: 0 0 0 3px rgba(100, 116, 139, .13);
        }

        textarea.izin-input {
            min-height: 130px;
            resize: vertical;
            line-height: 1.6;
        }

        .izin-help {
            display: block;
            margin-top: 7px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }

        .izin-error {
            display: block;
            margin-top: 6px;
            color: #b91c1c;
            font-size: 12px;
        }

        .izin-upload {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px;
            border: 1.5px dashed #cbd5e1;
            border-radius: 10px;
            background: #f8fafc;
            transition: border-color .2s, background .2s;
        }

        .izin-upload:hover {
            border-color: #64748b;
            background: #f1f5f9;
        }

        .izin-upload-icon {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: #e2e8f0;
            color: #334155;
            font-size: 22px;
        }

        .izin-file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            clip-path: inset(50%);
        }

        .izin-file-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: #fff;
            color: #334155;
            cursor: pointer;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
        }

        .izin-file-button:hover {
            background: #f1f5f9;
        }

        .izin-file-button:focus-within,
        .izin-file-input:focus-visible + .izin-file-button {
            outline: 2px solid #64748b;
            outline-offset: 3px;
        }

        .izin-file-name {
            margin-top: 8px;
            color: #475569;
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .izin-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
        }

        .izin-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 18px;
            border: 1px solid #1e293b;
            border-radius: 8px;
            background: #1e293b;
            color: #fff;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
        }

        .izin-submit:hover {
            background: #334155;
        }

        .izin-submit:disabled {
            cursor: not-allowed;
            opacity: .6;
        }

        .izin-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #fff;
            color: #334155;
            font-size: 14px;
            text-decoration: none;
        }

        .izin-back:hover {
            background: #f8fafc;
        }

        .izin-alert {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.6;
        }

        .izin-alert-error {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }

        .izin-alert-success {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
        }

        @media (max-width: 600px) {
            .izin-form-card {
                padding: 18px;
            }

            .izin-form-heading {
                font-size: 19px;
            }

            .izin-upload {
                align-items: flex-start;
                gap: 10px;
                padding: 13px;
            }

            .izin-upload-icon {
                width: 38px;
                height: 38px;
                font-size: 19px;
            }
        }
    </style>

    <div class="card izin-form-card">
        <h3 class="izin-form-heading">Form Pengajuan Izin</h3>

        <p class="izin-form-description">
            Lengkapi tanggal izin, alasan, dan dokumen pendukung
            untuk mengirim pengajuan kepada pihak sekolah.
        </p>

        @if (session('success'))
            <div class="izin-alert izin-alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="izin-alert izin-alert-error" role="alert">
                <strong>Pengajuan belum berhasil.</strong>
                <ul style="margin:8px 0 0; padding-left:20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            id="formPengajuanIzin"
            method="POST"
            action="{{ route('portal.perizinan.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="izin-field">
                <label class="izin-label" for="tanggal_mulai">
                    Tanggal Mulai Izin
                </label>

                <input
                    class="izin-input"
                    type="date"
                    id="tanggal_mulai"
                    name="tanggal_mulai"
                    value="{{ old('tanggal_mulai') }}"
                    min="{{ now()->toDateString() }}"
                    required
                >

                <small class="izin-help">
                    Tanggal yang dapat dipilih mulai hari ini.
                    Tanggal yang sudah lewat tidak dapat dipilih.
                </small>

                @error('tanggal_mulai')
                    <small class="izin-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="izin-field">
                <label class="izin-label" for="tanggal_selesai">
                    Tanggal Selesai Izin
                </label>

                <input
                    class="izin-input"
                    type="date"
                    id="tanggal_selesai"
                    name="tanggal_selesai"
                    value="{{ old('tanggal_selesai') }}"
                    min="{{ old('tanggal_mulai', now()->toDateString()) }}"
                    required
                >

                <small class="izin-help">
                    Tanggal selesai harus sama dengan atau setelah tanggal mulai.
                </small>

                @error('tanggal_selesai')
                    <small class="izin-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="izin-field">
                <label class="izin-label" for="alasan">
                    Alasan Izin
                </label>

                <textarea
                    class="izin-input"
                    id="alasan"
                    name="alasan"
                    rows="5"
                    maxlength="5000"
                    placeholder="Jelaskan alasan pengajuan izin secara lengkap..."
                    required
                >{{ old('alasan') }}</textarea>

                <small class="izin-help">
                    Tuliskan alasan yang jelas agar mudah diverifikasi.
                </small>

                @error('alasan')
                    <small class="izin-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="izin-field">
                <label class="izin-label" for="dokumen">
                    Dokumen Pendukung
                </label>

                <div class="izin-upload">
                    <div class="izin-upload-icon" aria-hidden="true">
                        &#128206;
                    </div>

                    <div style="min-width:0; flex:1;">
                        <div style="font-size:14px; font-weight:600; color:#334155;">
                            Unggah surat atau bukti izin
                        </div>

                        <small class="izin-help" style="margin-top:4px;">
                            PDF, JPG, JPEG, atau PNG. Maksimal 5 MB.
                        </small>

                        <input
                            class="izin-file-input"
                            type="file"
                            id="dokumen"
                            name="dokumen"
                            accept=".pdf,.jpg,.jpeg,.png"
                            data-kamera
                            data-kamera-max-mb="5"
                            data-kamera-target="#namaDokumen"
                            data-kamera-class="izin-file-button"
                            aria-describedby="namaDokumen"
                            required
                        >

                        <label class="izin-file-button" for="dokumen">
                            Pilih Dokumen
                        </label>

                        <div class="izin-file-name" id="namaDokumen" aria-live="polite">
                            Belum ada dokumen yang dipilih.
                        </div>
                    </div>
                </div>

                @error('dokumen')
                    <small class="izin-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="izin-actions">
                <button
                    type="submit"
                    class="izin-submit"
                    id="tombolAjukan"
                >
                    Ajukan Izin
                </button>

                <a
                    href="{{ route('portal.perizinan.index') }}"
                    class="izin-back"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tanggalMulai = document.getElementById('tanggal_mulai');
            const tanggalSelesai = document.getElementById('tanggal_selesai');
            const inputDokumen = document.getElementById('dokumen');
            const namaDokumen = document.getElementById('namaDokumen');
            const form = document.getElementById('formPengajuanIzin');
            const tombolAjukan = document.getElementById('tombolAjukan');

            // Gunakan tanggal lokal browser untuk batas minimum hari ini.
            const sekarang = new Date();
            const tahun = sekarang.getFullYear();
            const bulan = String(sekarang.getMonth() + 1).padStart(2, '0');
            const hari = String(sekarang.getDate()).padStart(2, '0');
            const hariIni = `${tahun}-${bulan}-${hari}`;

            tanggalMulai.min = hariIni;
            tanggalSelesai.min = tanggalMulai.value || hariIni;

            // Jika tanggal mulai berubah, sesuaikan batas tanggal selesai.
            tanggalMulai.addEventListener('change', function () {
                tanggalSelesai.min = tanggalMulai.value || hariIni;

                if (
                    tanggalSelesai.value &&
                    tanggalSelesai.value < tanggalSelesai.min
                ) {
                    tanggalSelesai.value = tanggalSelesai.min;
                }
            });

            // Tampilkan nama dokumen setelah pengguna memilih berkas.
            inputDokumen.addEventListener('change', function () {
                const file = inputDokumen.files[0];

                if (!file) {
                    namaDokumen.textContent =
                        'Belum ada dokumen yang dipilih.';
                    return;
                }

                const ukuranMaksimal = 5 * 1024 * 1024;
                const ekstensiValid = /\.(pdf|jpe?g|png)$/i.test(file.name);

                if (!ekstensiValid || file.size > ukuranMaksimal) {
                    inputDokumen.value = '';

                    namaDokumen.textContent = !ekstensiValid
                        ? 'Format tidak sesuai. Pilih PDF, JPG, JPEG, atau PNG.'
                        : 'Ukuran dokumen melebihi 5 MB.';

                    return;
                }

                namaDokumen.textContent =
                    file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
            });

            // Cegah pengiriman formulir dengan rentang tanggal yang tidak valid.
            form.addEventListener('submit', function (event) {
                if (
                    tanggalMulai.value < hariIni ||
                    tanggalSelesai.value < tanggalMulai.value
                ) {
                    event.preventDefault();

                    alert(
                        'Periksa kembali tanggal izin. Tanggal mulai tidak boleh lewat dan tanggal selesai tidak boleh sebelum tanggal mulai.'
                    );

                    return;
                }

                if (!inputDokumen.files.length) {
                    event.preventDefault();
                    alert('Silakan pilih dokumen pendukung terlebih dahulu.');
                    inputDokumen.focus();
                    return;
                }

                tombolAjukan.disabled = true;
                tombolAjukan.textContent = 'Mengirim Pengajuan...';
            });
        });
    </script>
@include('partials.kamera-foto')
@endsection

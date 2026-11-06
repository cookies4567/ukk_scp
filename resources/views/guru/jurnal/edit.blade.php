
@extends('layouts.app')

@section('title', 'Edit Jurnal Mengajar')
@section('page-title', 'Edit Jurnal Mengajar')

@section('content')

<style>
    .form-wrapper {
        max-width: 900px;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e1e5ea;
        border-radius: 10px;
        padding: 24px;
    }

    .form-title {
        margin: 0 0 5px;
        font-size: 20px;
        color: #172033;
    }

    .form-description {
        margin: 0 0 22px;
        color: #6b7280;
        font-size: 14px;
    }

    .jadwal-info {
        background: #f6f8fa;
        border: 1px solid #e2e6eb;
        border-radius: 8px;
        padding: 17px;
        margin-bottom: 22px;
    }

    .jadwal-mapel {
        font-weight: 700;
        color: #172033;
        font-size: 16px;
        margin-bottom: 12px;
    }

    .jadwal-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px 20px;
    }

    .jadwal-field {
        font-size: 13px;
    }

    .jadwal-label {
        color: #7b8491;
        margin-bottom: 3px;
    }

    .jadwal-value {
        color: #273244;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: #303b4d;
        font-size: 14px;
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d6dce3;
        border-radius: 7px;
        padding: 10px 12px;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        background: #ffffff;
    }

    .form-control:focus {
        border-color: #7d93aa;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .form-help {
        margin-top: 6px;
        color: #7b8491;
        font-size: 12px;
    }

    .error-message {
        color: #b42318;
        font-size: 12px;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-top: 25px;
        padding-top: 18px;
        border-top: 1px solid #edf0f3;
    }

    .btn-back {
        color: #596575;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-save {
        border: none;
        border-radius: 7px;
        background: #1f3a5f;
        color: #ffffff;
        padding: 10px 18px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-save:hover {
        background: #172f4d;
    }

    .presensi-section {
        margin-bottom: 22px;
    }

    .presensi-heading {
        color: #303b4d;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .presensi-description {
        color: #7b8491;
        font-size: 13px;
        margin-bottom: 14px;
    }

    .presensi-table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #e1e5ea;
        border-radius: 8px;
    }

    .presensi-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .presensi-table th,
    .presensi-table td {
        padding: 12px;
        border-bottom: 1px solid #edf0f3;
        text-align: left;
    }

    .presensi-table th {
        background: #f6f8fa;
        color: #596575;
        font-weight: 700;
    }

    .presensi-table tr:last-child td {
        border-bottom: none;
    }

    .presensi-number {
        width: 45px;
        color: #7b8491;
    }

    .presensi-status {
        min-width: 125px;
        padding: 8px 10px;
        border: 1px solid #d6dce3;
        border-radius: 6px;
        background: #ffffff;
        font-family: inherit;
        font-size: 13px;
    }

    .presensi-empty {
        padding: 18px;
        color: #b42318;
        background: #fff5f5;
        border: 1px solid #f5c2c7;
        border-radius: 7px;
        font-size: 13px;
    }

    .foto-lama {
        margin-top: 10px;
    }

    .foto-lama img {
        max-width: 220px;
        max-height: 180px;
        display: block;
        margin-top: 8px;
        border-radius: 8px;
        border: 1px solid #e1e5ea;
        object-fit: cover;
    }

    @media (max-width: 700px) {
        .jadwal-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            align-items: stretch;
            flex-direction: column;
        }
    }
</style>

<div class="form-wrapper">

    <div class="form-card">

        <h2 class="form-title">
            Edit Jurnal Mengajar
        </h2>

        <p class="form-description">
            Perbarui informasi jurnal dan status kehadiran siswa.
        </p>

        {{-- INFORMASI JADWAL --}}

        <div class="jadwal-info">

            <div class="jadwal-mapel">
                {{ $jadwal->mata_pelajaran }}
            </div>

            <div class="jadwal-grid">

                <div class="jadwal-field">
                    <div class="jadwal-label">Kelas</div>
                    <div class="jadwal-value">
                        {{ $jadwal->kelas->nama_kelas }}
                    </div>
                </div>

                <div class="jadwal-field">
                    <div class="jadwal-label">Ruangan</div>
                    <div class="jadwal-value">
                        {{ $jadwal->ruangan->nama_ruangan }}
                    </div>
                </div>

                <div class="jadwal-field">
                    <div class="jadwal-label">Hari</div>
                    <div class="jadwal-value">
                        {{ $jadwal->hari }}
                    </div>
                </div>

                <div class="jadwal-field">
                    <div class="jadwal-label">Jam</div>
                    <div class="jadwal-value">
                        {{ substr($jadwal->jam_mulai, 0, 5) }}
                        -
                        {{ substr($jadwal->jam_selesai, 0, 5) }}
                    </div>
                </div>

                <div class="jadwal-field">
                    <div class="jadwal-label">Siklus</div>
                    <div class="jadwal-value">
                        {{ $jadwal->tipe_siklus }}
                    </div>
                </div>

            </div>
        </div>

        {{-- FORM EDIT JURNAL --}}

        <form
            action="{{ route('guru.jurnal.update', [$jadwal->id, $jurnal->id]) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="tanggal" class="form-label">
                    Tanggal
                </label>

                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    class="form-control"
                    value="{{ old('tanggal', \Carbon\Carbon::parse($jurnal->tanggal)->format('Y-m-d')) }}"
                    required
                >

                @error('tanggal')
                    <div class="error-message">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">

                <label for="deskripsi_materi" class="form-label">
                    Materi / Kegiatan Pembelajaran
                </label>

                <textarea
                    id="deskripsi_materi"
                    name="deskripsi_materi"
                    class="form-control"
                    placeholder="Tuliskan materi atau kegiatan pembelajaran..."
                    required
                >{{ old('deskripsi_materi', $jurnal->deskripsi_materi) }}</textarea>

                <div class="form-help">
                    Jelaskan materi, kegiatan, atau pembahasan yang diberikan kepada siswa.
                </div>

                @error('deskripsi_materi')
                    <div class="error-message">{{ $message }}</div>
                @enderror

            </div>

            {{-- DAFTAR PRESENSI SISWA --}}

            <div class="presensi-section">

                <div class="presensi-heading">
                    Daftar Kehadiran Siswa
                </div>

                <div class="presensi-description">
                    Status kehadiran di bawah merupakan data yang sudah tersimpan.
                    Silakan ubah jika terdapat kesalahan.
                </div>

                @if($siswa->count() > 0)

                    <div class="presensi-table-wrapper">

                        <table class="presensi-table">

                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Siswa</th>
                                    <th>Status Kehadiran</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($siswa as $index => $item)

                                    @php
                                        $statusLama = optional($presensi->get($item->id))->status;
                                        $statusTerpilih = old(
                                            'presensi.'.$item->id,
                                            $statusLama ?? 'Hadir'
                                        );
                                    @endphp

                                    <tr>

                                        <td class="presensi-number">
                                            {{ $index + 1 }}
                                        </td>

                                        <td>
                                            {{ $item->nama_lengkap }}
                                        </td>

                                        <td>

                                            <select
                                                name="presensi[{{ $item->id }}]"
                                                class="presensi-status"
                                                required
                                            >

                                                <option value="Hadir"
                                                    {{ $statusTerpilih == 'Hadir' ? 'selected' : '' }}>
                                                    Hadir
                                                </option>

                                                <option value="Izin"
                                                    {{ $statusTerpilih == 'Izin' ? 'selected' : '' }}>
                                                    Izin
                                                </option>

                                                <option value="Sakit"
                                                    {{ $statusTerpilih == 'Sakit' ? 'selected' : '' }}>
                                                    Sakit
                                                </option>

                                                <option value="Alpa"
                                                    {{ $statusTerpilih == 'Alpa' ? 'selected' : '' }}>
                                                    Alpa
                                                </option>

                                            </select>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    <div class="form-help">
                        Total siswa: {{ $siswa->count() }} orang.
                        Periksa kembali status kehadiran sebelum menyimpan perubahan.
                    </div>

                @else

                    <div class="presensi-empty">
                        Belum ada siswa yang terdaftar pada kelas ini.
                        Silakan periksa data siswa dan kelas di database.
                    </div>

                @endif

                @error('presensi')
                    <div class="error-message">{{ $message }}</div>
                @enderror

            </div>

            {{-- FOTO DOKUMENTASI --}}

            <div class="form-group">

                <label for="path_foto" class="form-label">
                    Foto Dokumentasi
                </label>

                <input
                    type="file"
                    id="path_foto"
                    name="path_foto"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                    data-kamera
                    data-kamera-max-mb="2"
                >

                <div class="form-help">
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    Kosongkan jika tidak ingin mengganti foto.
                </div>

                @if($jurnal->path_foto)
                    <div class="foto-lama">
                        <div class="form-help">
                            Foto dokumentasi saat ini:
                        </div>

                        <img
                            src="{{ asset('storage/' . $jurnal->path_foto) }}"
                            alt="Foto dokumentasi jurnal"
                        >
                    </div>
                @endif

                @error('path_foto')
                    <div class="error-message">{{ $message }}</div>
                @enderror

            </div>

            {{-- TOMBOL AKSI --}}

            <div class="form-actions">

                <a
                    href="{{ route('guru.jurnal.index') }}"
                    class="btn-back"
                >
                    ← Kembali
                </a>

                <button type="submit" class="btn-save">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@include('partials.kamera-foto')

@endsection

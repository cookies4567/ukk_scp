
@extends('layouts.app')

@section('page-title', 'Riwayat Verifikasi')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 8px;">
            Riwayat Verifikasi Izin
        </h2>
        <p style="font-size: 14px; color: #6b7280; margin: 0;">
            Daftar pengajuan izin siswa yang sudah diputuskan oleh petugas.
        </p>
    </div>

    @if (session('success'))
        <div style="padding: 12px 16px; margin-bottom: 18px; border-radius: 8px; background: #dcfce7; color: #166534;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">

    
<form method="GET"
      action="{{ route('verifikasi.riwayat') }}"
      style="padding: 18px 20px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: end; gap: 12px; flex-wrap: wrap;">

    <div style="min-width: 220px;">
        <label for="kelas_id"
               style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 7px;">
            Filter Berdasarkan Kelas
        </label>

        <select name="kelas_id"
                id="kelas_id"
                style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 7px; background: #fff; font-size: 13px;">

            <option value="">Semua Kelas</option>

            @foreach ($daftarKelas as $kelas)
                <option value="{{ $kelas->id }}"
                    {{ (string) $kelasId === (string) $kelas->id ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
                </option>
            @endforeach

        </select>
    </div>

    <button type="submit"
            style="padding: 10px 16px; background: #1d4ed8; color: #fff; border: none; border-radius: 7px; cursor: pointer; font-size: 13px; font-weight: 600;">
        Terapkan Filter
    </button>

    <a href="{{ route('verifikasi.riwayat') }}"
       style="padding: 10px 16px; border: 1px solid #d1d5db; border-radius: 7px; color: #374151; text-decoration: none; font-size: 13px;">
        Reset
    </a>

</form>


        <div style="padding: 18px 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div>
                <h3 style="font-size: 16px; font-weight: 700; margin: 0; color: #1f2937;">
                    Daftar Riwayat
                </h3>
                <p style="font-size: 13px; color: #6b7280; margin: 5px 0 0;">
                    Total {{ $pengajuan->count() }} pengajuan telah diproses.
                </p>
            </div>

            <a href="{{ route('verifikasi.izin') }}"
               style="display: inline-block; padding: 9px 13px; border: 1px solid #d1d5db; border-radius: 7px; color: #374151; text-decoration: none; font-size: 13px;">
                Kembali ke Verifikasi Izin
            </a>
        </div>

        @if ($pengajuan->isEmpty())
            <div style="padding: 48px 20px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 12px;">📋</div>
                <h3 style="font-size: 16px; color: #374151; margin: 0 0 6px;">
                    Belum ada riwayat verifikasi
                </h3>
                <p style="font-size: 13px; color: #6b7280; margin: 0;">
                    Pengajuan yang diterima atau ditolak akan muncul di sini.
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
                            <th style="padding: 13px 16px; min-width: 150px;">Alasan</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Dokumen</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Status</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Diverifikasi Oleh</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pengajuan as $item)
                            <tr style="border-top: 1px solid #e5e7eb; color: #374151;">

                                {{-- Nama siswa --}}
                                <td style="padding: 16px; vertical-align: top;">
                                    <div style="font-weight: 600;">
                                        {{ $item->siswa->nama_lengkap ?? 'Nama tidak tersedia' }}
                                    </div>

                                    <div style="font-size: 12px; color: #9ca3af; margin-top: 4px;">
                                        Pengaju: {{ $item->pengaju->nama_lengkap ?? 'Tidak tersedia' }}
                                    </div>
                                </td>

                                {{-- Kelas --}}
                                <td style="padding: 16px; vertical-align: top; white-space: nowrap;">
                                    <div>
    {{ $item->siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}
</div>
                                </td>

                                {{-- Tanggal izin --}}
                                <td style="padding: 16px; vertical-align: top; white-space: nowrap;">
                                    {{ $item->tanggal_mulai }}

                                    @if ($item->tanggal_selesai && $item->tanggal_selesai !== $item->tanggal_mulai)
                                        <div style="margin-top: 4px; color: #6b7280;">
                                            s.d. {{ $item->tanggal_selesai }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Alasan --}}
                                <td style="padding: 16px; vertical-align: top;">
                                    {{ $item->alasan }}
                                </td>

                                {{-- Dokumen --}}
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

                                {{-- Status --}}
                                <td style="padding: 16px; vertical-align: top; white-space: nowrap;">
                                    @if ($item->status_persetujuan === 'Disetujui')
                                        <span style="display: inline-block; padding: 6px 10px; border-radius: 20px; background: #dcfce7; color: #166534; font-size: 12px; font-weight: 700;">
                                            Disetujui
                                        </span>
                                    @elseif ($item->status_persetujuan === 'Ditolak')
                                        <span style="display: inline-block; padding: 6px 10px; border-radius: 20px; background: #fee2e2; color: #991b1b; font-size: 12px; font-weight: 700;">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>

                                {{-- Diverifikasi oleh --}}
                                <td style="padding: 16px; vertical-align: top;">
                                    {{ $item->diverifikasiOleh->nama_lengkap ?? 'Tidak tersedia' }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

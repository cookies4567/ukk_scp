
@extends('layouts.app')

@section('title', 'Riwayat Perizinan')
@section('page-title', 'Riwayat Perizinan')

@section('menu')
    <div class="menu-title">Menu Utama</div>

    <a href="{{ route('portal.dashboard') }}">
        Dashboard
    </a>

    <a href="#">
        Rekap Kehadiran
    </a>

    <a href="{{ route('portal.perizinan.index') }}" class="active">
        Pengajuan Izin
    </a>
@endsection

@section('content')

<div class="card" style="padding: 22px 24px;">
    <h3 class="card-title" style="margin: 0 0 8px;">
        Riwayat Pengajuan Izin
    </h3>

    <p class="card-text" style="margin: 0 0 14px;">
        Lihat status pengajuan izin yang pernah dibuat.
    </p>

    <a href="{{ route('portal.perizinan.create') }}"
       class="btn btn-primary">
        + Ajukan Izin
    </a>
</div>

<div class="card" style="margin-top:20px;">
    <h3 class="card-title">Daftar Pengajuan</h3>

    @forelse ($pengajuan as $izin)

        <div style="padding:18px 0; border-top:1px solid #e5e7eb;">

            <h4 style="
                margin:0 0 16px;
                color:#172033;
                font-size:15px;
            ">
                {{ $izin->siswa->nama_lengkap ?? 'Siswa' }}
            </h4>

            <div style="
                display:grid;
                grid-template-columns:repeat(3, minmax(0, 1fr));
                gap:16px;
            ">

                {{-- Tanggal izin --}}
                <div>
                    <div style="font-size:12px; color:#64748b; margin-bottom:7px;">
                        Hari / Tanggal
                    </div>

                    <div style="
                        display:flex;
                        align-items:center;
                        flex-wrap:wrap;
                        gap:5px;
                        font-size:14px;
                        color:#334155;
                        font-weight:500;
                    ">
                        <span>
                            {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->translatedFormat('d M Y') }}
                        </span>

                        <span style="color:#64748b; font-size:12px;">
                            s.d.
                        </span>

                        <span>
                            {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->translatedFormat('d M Y') }}
                        </span>
                    </div>
                </div>

                {{-- Alasan izin --}}
                <div>
                    <div style="font-size:12px; color:#64748b; margin-bottom:7px;">
                        Alasan Izin
                    </div>

                    <div style="
                        font-size:14px;
                        color:#334155;
                        overflow-wrap:anywhere;
                    ">
                        {{ $izin->alasan }}
                    </div>
                </div>

                {{-- Status pengajuan --}}
                <div>
                    <div style="font-size:12px; color:#64748b; margin-bottom:7px;">
                        Status Pengajuan
                    </div>

                    @if ($izin->status_persetujuan === 'Menunggu')
                        <span style="
                            display:inline-block;
                            padding:6px 12px;
                            border-radius:20px;
                            background:#fef3c7;
                            color:#92400e;
                            font-size:12px;
                            font-weight:600;
                        ">
                            Menunggu
                        </span>

                    @elseif ($izin->status_persetujuan === 'Disetujui')
                        <span style="
                            display:inline-block;
                            padding:6px 12px;
                            border-radius:20px;
                            background:#dcfce7;
                            color:#166534;
                            font-size:12px;
                            font-weight:600;
                        ">
                            Disetujui
                        </span>

                    @elseif ($izin->status_persetujuan === 'Ditolak')
                        <span style="
                            display:inline-block;
                            padding:6px 12px;
                            border-radius:20px;
                            background:#fee2e2;
                            color:#991b1b;
                            font-size:12px;
                            font-weight:600;
                        ">
                            Ditolak
                        </span>

                        <div style="margin-top:12px;">
                            <a href="{{ route('portal.perizinan.create') }}"
                               class="btn btn-primary"
                               style="font-size:12px; padding:8px 13px;">
                                Ajukan Kembali
                            </a>
                        </div>

                    @else
                        <span style="
                            display:inline-block;
                            padding:6px 12px;
                            border-radius:20px;
                            background:#e2e8f0;
                            color:#334155;
                            font-size:12px;
                            font-weight:600;
                        ">
                            {{ $izin->status_persetujuan }}
                        </span>
                    @endif
                </div>

            </div>

            {{-- Alasan penolakan hanya tampil jika ditolak --}}
            @if ($izin->status_persetujuan === 'Ditolak')
                <div style="
                    margin-top:18px;
                    padding:16px 18px;
                    background:#fff7f7;
                    border:1px solid #fecaca;
                    border-radius:9px;
                ">
                    <div style="
                        font-size:13px;
                        font-weight:700;
                        color:#991b1b;
                        margin-bottom:8px;
                    ">
                        Alasan Penolakan Guru BK
                    </div>

                    <div style="
                        font-size:13px;
                        color:#7f1d1d;
                        line-height:1.7;
                        overflow-wrap:anywhere;
                    ">
                        {{ $izin->alasan_penolakan ?: 'Guru BK belum memberikan keterangan penolakan.' }}
                    </div>
                </div>
            @endif

        </div>

    @empty
        <p class="card-text">
            Belum ada pengajuan izin.
        </p>
    @endforelse
</div>

@endsection

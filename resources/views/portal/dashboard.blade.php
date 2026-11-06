
@extends('layouts.app')

@section('title', 'Portal SCP')
@section('page-title', 'Dashboard Portal')

@section('menu')
    <div class="menu-title">Menu Utama</div>

    <a
        href="{{ route('portal.perizinan.index') }}"
        class="{{ request()->routeIs('portal.perizinan.*') ? 'active' : '' }}"
    >
        Pengajuan Izin
    </a>
@endsection

@section('content')
    <style>
        .portal-welcome {
            margin-bottom: 20px;
        }

        .portal-student {
            padding: 12px 0;
            border-top: 1px solid #e5e7eb;
        }

        .portal-permit-summary {
            margin-top: 20px;
        }
    </style>

    {{-- INFORMASI SISWA --}}
    <div class="card portal-welcome">
        <h3 class="card-title">
            Selamat datang, {{ $pengguna->nama_lengkap }}
        </h3>

        <p class="card-text">
            Portal siswa untuk mengajukan izin.
        </p>

        <p class="card-text">
            Kelas: {{ $pengguna->kelas->nama_kelas ?? 'Belum ditentukan' }}
        </p>
    </div>

    {{-- RINGKASAN PERIZINAN --}}
    <div class="card portal-permit-summary">
        <h3 class="card-title">Ringkasan Perizinan</h3>

        <p class="card-text">
            Pengajuan menunggu:
            <strong>{{ $jumlahPengajuanMenunggu }}</strong>
        </p>

        <h4>Pengajuan Terbaru</h4>

        @forelse ($pengajuanTerbaru as $izin)
            <div class="portal-student">
                <strong>
                    {{ $izin->siswa->nama_lengkap ?? 'Siswa' }}
                </strong>

                <div class="card-text">
                    {{ $izin->tanggal_mulai }} sampai {{ $izin->tanggal_selesai }}
                </div>

                <div class="card-text">
                    Status: {{ $izin->status_persetujuan }}
                </div>
            </div>
        @empty
            <p class="card-text">
                Belum ada pengajuan izin.
            </p>
        @endforelse
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard Waka')

@section('page-title', 'Dashboard Waka Kurikulum')

@section('menu')

    <div class="menu-title">
        Menu Utama
    </div>

    <a href="{{ route('waka.monitoring-jurnal') }}"
   class="nav-link">
    Monitoring Jurnal Guru
    </a>

    <a
        href="{{ route('waka.dashboard') }}"
        class="active"
    >
        Dashboard
    </a>

    <a href="{{ route('waka.pengaturan') }}">
        Pengaturan Sistem
    </a>

    <a href="#">
        Data Guru
    </a>

    <a href="#">
        Data Kelas
    </a>

    <a href="#">
        Jadwal Pelajaran
    </a>

    <a href="#">
        Laporan
    </a>

@endsection

@section('content')

    <div class="card">

        <h3 class="card-title">
            Selamat datang,
            {{ $waka->nama_lengkap }}
        </h3>

        <p class="card-text">
            Kelola pengaturan akademik dan pantau keterlaksanaan jurnal guru
            melalui halaman ini.
        </p>

    </div>


    <div class="card" style="margin-top:20px;">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:15px;
            flex-wrap:wrap;
        ">

            <div>
                <h3 class="card-title" style="margin-bottom:5px;">
                    Pengaturan Sistem
                </h3>

                <p class="card-text">
                    Pengaturan jadwal dan putaran aktif sistem.
                </p>
            </div>

            <a
                href="{{ route('waka.pengaturan') }}"
                style="
                    display:inline-block;
                    padding:9px 14px;
                    background:#198754;
                    color:white;
                    text-decoration:none;
                    border-radius:6px;
                    font-size:13px;
                    font-weight:500;
                "
            >
                Kelola Pengaturan
            </a>

        </div>


        <div style="
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:15px;
            margin-top:20px;
        ">

            <div style="
                padding:16px;
                border:1px solid #e5e7eb;
                border-radius:8px;
                background:#f9fafb;
            ">

                <div style="
                    font-size:12px;
                    color:#6b7280;
                    margin-bottom:6px;
                ">
                    Status Jadwal
                </div>

                <div style="
                    font-size:16px;
                    font-weight:600;
                    color:#374151;
                ">

                    @if ($konfigurasi && $konfigurasi->jadwal_dikunci)

                        🔒 Jadwal Terkunci

                    @else

                        🔓 Jadwal Terbuka

                    @endif

                </div>

            </div>


            <div style="
                padding:16px;
                border:1px solid #e5e7eb;
                border-radius:8px;
                background:#f9fafb;
            ">

                <div style="
                    font-size:12px;
                    color:#6b7280;
                    margin-bottom:6px;
                ">
                    Putaran Aktif
                </div>

                <div style="
                    font-size:16px;
                    font-weight:600;
                    color:#374151;
                ">
                    {{ $konfigurasi->siklus_aktif ?? 'Belum ditentukan' }}
                </div>

            </div>

        </div>

    </div>


    <div class="card" style="margin-top:20px;">

        <h3 class="card-title">
            Ringkasan Jadwal
        </h3>

        <p class="card-text">
            Jumlah jadwal yang terdaftar dalam sistem.
        </p>

        <div style="
            margin-top:15px;
            font-size:24px;
            font-weight:600;
            color:#374151;
        ">
            {{ $jadwal->count() }}
        </div>

        <div style="
            font-size:12px;
            color:#6b7280;
            margin-top:3px;
        ">
            Total jadwal
        </div>

    </div>

@endsection
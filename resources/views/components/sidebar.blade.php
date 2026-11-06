
@php
    $u = auth()->user();

    // Multi peran: Wali Kelas otomatis juga Guru, dan Guru dengan kelas
    // perwalian otomatis juga Wali Kelas.
    $punyaGuru = $u->punyaPeran(2);
    $punyaWali = $u->punyaPeran(3);
    $ganda     = $punyaGuru && $punyaWali;
    $waliUtama = (int) $u->peran_id === 3;

    $labelPeran = $u->peran->nama_peran ?? 'Pengguna';

    if ($ganda) {
        $labelPeran = $waliUtama ? 'Wali Kelas & Guru' : 'Guru & Wali Kelas';
    }
@endphp

<aside class="sidebar">

    {{-- LOGO / BRAND --}}
    <div class="sidebar-header" style="display:flex;align-items:center;gap:10px;">
        <img
            class="brand-logo"
            src="{{ asset('SMK_Negeri_1_Bantul_logo.png') }}"
            alt="Logo SMK Negeri 1 Bantul"
            width="30"
            height="30"
            style="width:30px;height:30px;flex-shrink:0;object-fit:contain;"
        >

        <div>
            <h2>SCP</h2>
            <span>School Class Progress</span>
        </div>
    </div>

    {{-- MENU --}}
    <nav class="menu">

        {{-- WAKA KURIKULUM --}}
        @if ((int) $u->peran_id === 1)

            <div class="menu-title">Menu Utama</div>

            <a href="{{ route('waka.dashboard') }}"
               class="{{ request()->routeIs('waka.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('waka.master-data.index') }}"
               class="{{ request()->routeIs('waka.master-data.*') ? 'active' : '' }}">
                Manajemen Data
            </a>

            <a href="{{ route('waka.monitoring-jurnal') }}"
               class="{{ request()->routeIs('waka.monitoring-jurnal') ? 'active' : '' }}">
                Monitoring Jurnal Guru
            </a>

        @endif


        {{-- GURU DAN WALI KELAS (multi peran) --}}
        {{-- Akun Wali Kelas: menu Wali Kelas tampil lebih dulu. --}}
        {{-- Akun Guru: menu Guru tampil lebih dulu. --}}
        @foreach ($waliUtama ? ['wali', 'guru'] : ['guru', 'wali'] as $seksi)

            @if ($seksi === 'guru' && $punyaGuru)

                <div class="menu-title">Menu Guru</div>

                <a href="{{ route('guru.dashboard') }}"
                   class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                    {{ $ganda ? 'Dashboard Guru' : 'Dashboard' }}
                </a>

                <a href="{{ route('guru.jadwal.index') }}"
                   class="{{ request()->routeIs('guru.jadwal.*') ? 'active' : '' }}">
                    Jadwal Mengajar
                </a>

                <a href="{{ route('guru.jurnal.index') }}"
                   class="{{ request()->routeIs('guru.jurnal.*') ? 'active' : '' }}">
                    Jurnal Mengajar
                </a>

            @endif

            @if ($seksi === 'wali' && $punyaWali)

                <div class="menu-title">Menu Wali Kelas</div>

                @if ($waliUtama)
                    <a href="{{ route('kesiswaan.dashboard') }}"
                       class="{{ request()->routeIs('kesiswaan.dashboard') ? 'active' : '' }}">
                        {{ $ganda ? 'Dashboard Wali Kelas' : 'Dashboard' }}
                    </a>
                @endif

                {{-- Verifikasi izin hanya untuk wali yang sudah punya kelas perwalian --}}
                @if (!empty($u->kelas_id))

                    <a href="{{ route('verifikasi.izin') }}"
                       class="{{ request()->routeIs('verifikasi.izin', 'verifikasi.izin.proses') ? 'active' : '' }}">
                        Verifikasi Izin
                    </a>

                    <a href="{{ route('verifikasi.riwayat') }}"
                       class="{{ request()->routeIs('verifikasi.riwayat') ? 'active' : '' }}">
                        Riwayat Verifikasi
                    </a>

                @endif

            @endif

        @endforeach


        {{-- GURU BK --}}
        @if ((int) $u->peran_id === 4)

            <div class="menu-title">Menu Guru BK</div>

            <a href="{{ route('kesiswaan.dashboard') }}"
               class="{{ request()->routeIs('kesiswaan.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('verifikasi.izin') }}"
               class="{{ request()->routeIs('verifikasi.izin', 'verifikasi.izin.proses') ? 'active' : '' }}">
                Verifikasi Izin
            </a>

            <a href="{{ route('verifikasi.riwayat') }}"
               class="{{ request()->routeIs('verifikasi.riwayat') ? 'active' : '' }}">
                Riwayat Verifikasi
            </a>

            <a href="{{ route('bk.monitoring-presensi') }}"
               class="{{ request()->routeIs('bk.monitoring-presensi') ? 'active' : '' }}">
                Monitoring Presensi
            </a>

        @endif


        {{-- SISWA --}}
        @if ((int) $u->peran_id === 5)

            <div class="menu-title">Menu Siswa</div>

            <a href="{{ route('portal.dashboard') }}"
               class="{{ request()->routeIs('portal.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('portal.perizinan.index') }}"
               class="{{ request()->routeIs('portal.perizinan.*') ? 'active' : '' }}">
                Pengajuan Izin
            </a>

        @endif

    </nav>


    {{-- USER INFO --}}
    <div class="sidebar-footer">

        <a href="{{ route('profile.edit') }}" class="profile-sidebar-link">
            Profil Saya
        </a>

        <div class="user-info">

            <div class="user-name">
                {{ $u->nama_lengkap }}
            </div>

            <div class="user-role">
                {{ $labelPeran }}
            </div>

        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="logout-btn">
                Keluar
            </button>
        </form>

    </div>

</aside>

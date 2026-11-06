
<aside class="sidebar">
    <div class="sidebar-header">
        <h2>SCP</h2>
        <span>School Class Progress</span>
    </div>

    <nav class="menu">
        <div class="menu-title">Menu Verifikasi</div>

        <a
            href="{{ route('verifikasi.izin') }}"
            class="{{ request()->routeIs('verifikasi.izin') ? 'active' : '' }}"
        >
            Verifikasi Izin
        </a>

        <a
            href="{{ route('verifikasi.riwayat') }}"
            class="{{ request()->routeIs('verifikasi.riwayat') ? 'active' : '' }}"
        >
            Riwayat Verifikasi
        </a>

        <a
            href="{{ route('bk.monitoring-presensi') }}"
            class="{{ request()->routeIs('bk.monitoring-presensi') ? 'active' : '' }}"
        >
            Monitoring Presensi
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}" class="profile-sidebar-link">
            <i class="bi bi-person-circle"></i>
            <span>Profil Saya</span>
        </a>

        <div class="user-info">
            <div class="user-name">
                {{ auth()->user()->nama ?? auth()->user()->name ?? 'Pengguna' }}
            </div>

            <div class="user-role">Verifikasi Pengajuan Izin</div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Keluar</button>
        </form>
    </div>
</aside>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - SCP
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        /* =====================================================
           SCP - layout modern (v3)
           Font: Plus Jakarta Sans | Warna: navy institusional
           ===================================================== */

        :root {
            --scp-blue-950: #102b4e;
            --scp-blue-900: #15385f;
            --scp-blue-800: #1d4c7a;
            --scp-blue-700: #28628f;
            --scp-blue-100: #e6edf5;
            --scp-blue-50: #f3f6fa;
            --scp-accent: #a9c8e8;
            --scp-border: #e2e8f0;
            --scp-text: #1f2f45;
            --scp-muted: #6b7c93;
            --scp-white: #ffffff;
            --scp-canvas: #f4f6f9;
            --scp-font: "Plus Jakarta Sans", "Segoe UI", "Helvetica Neue", Roboto, Arial, sans-serif;
            --r-card: 10px;
            --r-ctl: 8px;
        }

        * { box-sizing: border-box; }

        html { min-height: 100%; }

        body,
        button,
        input,
        select,
        textarea {
            font-family: var(--scp-font);
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-size: 13px;
            line-height: 1.55;
            letter-spacing: -.003em;
            color: var(--scp-text);
            background: var(--scp-canvas);
            -webkit-font-smoothing: antialiased;
            font-variant-numeric: tabular-nums;
        }

        a { transition: color .12s ease, background-color .12s ease, border-color .12s ease; }

        /* ---------- SIDEBAR ---------- */

        .sidebar {
            position: fixed;
            z-index: 1030;
            inset: 0 auto 0 0;
            width: 244px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--scp-blue-950);
            color: #fff;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 20px 16px;
        }

        .brand-logo {
            width: 30px;
            height: 30px;
            flex-shrink: 0;
            padding: 2px;
            border-radius: 7px;
            background: #fff;
            object-fit: contain;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: .14em;
            line-height: 1.1;
            color: #fff;
        }

        .sidebar-header span {
            display: block;
            margin-top: 3px;
            font-size: 10.5px;
            letter-spacing: .02em;
            color: #9fb3cb;
        }

        .menu {
            flex: 1;
            padding: 6px 12px 12px;
            overflow-y: auto;
        }

        .menu-title {
            margin: 18px 10px 6px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #7f97b3;
        }

        .menu-title:first-child { margin-top: 10px; }

        .menu a {
            position: relative;
            display: block;
            margin: 2px 0;
            padding: 9px 12px;
            border-radius: var(--r-ctl);
            color: #cfdbe9;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, .06);
            color: #fff;
        }

        .menu a.active {
            background: rgba(255, 255, 255, .1);
            color: #fff;
            font-weight: 600;
        }

        .menu a.active::before {
            content: "";
            position: absolute;
            left: -12px;
            top: 8px;
            bottom: 8px;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: var(--scp-accent);
        }

        .menu a:focus-visible,
        .logout-btn:focus-visible,
        .profile-sidebar-link:focus-visible {
            outline: 2px solid #8fb8e0;
            outline-offset: 2px;
        }

        /* ---------- SIDEBAR FOOTER ---------- */

        .sidebar-footer {
            flex-shrink: 0;
            padding: 12px;
            border-top: 1px solid rgba(255, 255, 255, .08);
        }

        .profile-sidebar-link {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 8px 10px;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: var(--r-ctl);
            background: rgba(255, 255, 255, .05);
            color: #edf4fb;
            text-align: center;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 600;
        }

        .profile-sidebar-link:hover {
            background: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .24);
            color: #fff;
        }

        .user-info {
            min-width: 0;
            margin-bottom: 2px;
        }

        .user-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #fff;
            overflow-wrap: anywhere;
        }

        .user-role {
            margin-top: 1px;
            font-size: 11px;
            color: #9fb3cb;
        }

        .logout-btn {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 8px 10px;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: var(--r-ctl);
            background: transparent;
            color: #dbe6f2;
            cursor: pointer;
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 600;
            transition: background .12s ease, border-color .12s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, .08);
            border-color: rgba(255, 255, 255, .24);
            color: #fff;
        }

        /* ---------- KONTEN UTAMA ---------- */

        .main {
            margin-left: 244px;
            min-height: 100vh;
            background: var(--scp-canvas);
        }

        .topbar {
            min-height: 56px;
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: #fff;
            border-bottom: 1px solid var(--scp-border);
        }

        .page-title {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -.01em;
            color: var(--scp-blue-950);
        }

        .topbar-date {
            font-size: 12px;
            color: var(--scp-muted);
            white-space: nowrap;
        }

        .page-content { padding: 24px 28px; }

        /* ---------- CARD ---------- */

        .card {
            padding: 20px;
            background: #fff;
            border: 1px solid var(--scp-border);
            border-radius: var(--r-card);
            box-shadow: none;
        }

        .card-title {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: -.005em;
            color: var(--scp-blue-950);
        }

        .card-text {
            margin: 0;
            font-size: 13px;
            color: var(--scp-muted);
        }

        /* ---------- MASTER DATA ---------- */

        .master-data-container { padding: 0; }

        .master-data-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .master-data-header h2 {
            margin: 0 0 3px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -.015em;
            color: var(--scp-blue-950);
        }

        .master-data-header p {
            margin: 0;
            font-size: 13px;
            color: var(--scp-muted);
        }

        .master-data-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .master-data-card {
            display: block;
            padding: 18px 20px;
            background: #fff;
            border: 1px solid var(--scp-border);
            border-radius: var(--r-card);
            color: var(--scp-text);
            text-decoration: none;
            box-shadow: none;
        }

        .master-data-card:hover {
            border-color: var(--scp-blue-700);
            background: #fff;
        }

        .master-data-card-title {
            margin-bottom: 4px;
            font-size: 14px;
            font-weight: 700;
            color: var(--scp-blue-900);
        }

        .master-data-card-text {
            font-size: 12.5px;
            color: var(--scp-muted);
        }

        /* ---------- TOMBOL ---------- */

        .btn-primary,
        .main .btn-primary {
            display: inline-block;
            padding: 8px 16px;
            border: 1px solid var(--scp-blue-900);
            border-radius: var(--r-ctl);
            background: var(--scp-blue-900);
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            box-shadow: none;
        }

        .btn-primary:hover,
        .main .btn-primary:hover {
            background: var(--scp-blue-800);
            border-color: var(--scp-blue-800);
            color: #fff;
        }

        .btn-primary:focus-visible,
        .btn-secondary:focus-visible {
            outline: 3px solid rgba(40, 98, 143, .25);
            outline-offset: 1px;
        }

        .btn-secondary {
            display: inline-block;
            padding: 8px 16px;
            border: 1px solid #cdd6e1;
            border-radius: var(--r-ctl);
            background: #fff;
            color: #3d4f66;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: var(--scp-blue-50);
            border-color: #aebccc;
            color: var(--scp-blue-950);
        }

        .btn-edit,
        .btn-delete {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-edit {
            border: 1px solid #d3deea;
            background: var(--scp-blue-50);
            color: var(--scp-blue-800);
        }

        .btn-delete {
            border: 1px solid #f1d4d4;
            background: #fff5f5;
            color: #b42b2b;
        }

        /* ---------- ALERT ---------- */

        .alert-success {
            margin-bottom: 16px;
            padding: 10px 14px;
            border: 1px solid #bfe3cd;
            border-radius: var(--r-ctl);
            background: #f1faf5;
            color: #17633d;
            font-size: 13px;
        }

        /* ---------- TABEL ---------- */

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid var(--scp-border);
            border-radius: var(--r-card);
            background: #fff;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            padding: 11px 14px;
            text-align: left;
            border-bottom: 1px solid var(--scp-border);
            background: #f8fafc;
            color: var(--scp-muted);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #eef2f6;
            font-size: 13px;
            color: #2f4157;
        }

        .data-table tbody tr:hover { background: #f8fafc; }

        .data-table tbody tr:last-child td { border-bottom: none; }

        .empty-data {
            padding: 28px !important;
            text-align: center;
            color: #8696aa;
        }

        /* ---------- FORM ---------- */

        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #3d4f66;
        }

        .form-input {
            width: 100%;
            max-width: 500px;
            min-height: 40px;
            padding: 8px 12px;
            border: 1px solid #cdd6e1;
            border-radius: var(--r-ctl);
            background: #fff;
            color: var(--scp-text);
            font-size: 13px;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--scp-blue-700);
            box-shadow: 0 0 0 3px rgba(40, 98, 143, .14);
        }

        .form-error {
            margin-top: 5px;
            font-size: 12px;
            color: #c62828;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 22px;
        }

        /* ---------- PENYESUAIAN BOOTSTRAP ---------- */

        .main .container,
        .main .container-fluid { max-width: 100%; }

        .main .form-control,
        .main .form-select {
            min-height: 40px;
            border-color: #cdd6e1;
            border-radius: var(--r-ctl);
            color: var(--scp-text);
            font-size: 13px;
        }

        .main .form-control:focus,
        .main .form-select:focus {
            border-color: var(--scp-blue-700);
            box-shadow: 0 0 0 3px rgba(40, 98, 143, .14);
        }

        .main .btn {
            border-radius: var(--r-ctl);
            font-size: 13px;
            font-weight: 600;
        }

        .main .table {
            --bs-table-bg: #fff;
            --bs-table-color: var(--scp-text);
            --bs-table-border-color: #eaeff5;
            font-size: 13px;
        }

        .main .table thead th {
            background: #f8fafc;
            color: var(--scp-muted);
            border-color: var(--scp-border);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .alert,
        .alert-success { border-radius: var(--r-ctl); }

        .badge { font-weight: 600; }

        /* ---------- UKURAN JUDUL (berlaku untuk semua halaman) ----------
           Judul bawaan tiap halaman bervariasi 20-28px. Blok ini
           menyeragamkannya. Hapus blok ini jika ingin kembali ke ukuran
           masing-masing halaman. */

        .page-content h1 { font-size: 20px !important; font-weight: 700; letter-spacing: -.02em; }
        .page-content h2 { font-size: 18px !important; font-weight: 700; letter-spacing: -.015em; }
        .page-content h3 { font-size: 15px !important; font-weight: 700; letter-spacing: -.01em; }
        .page-content h4 { font-size: 14px !important; font-weight: 700; }
        .page-content h5,
        .page-content h6 { font-size: 13px !important; font-weight: 600; }

        .page-content .alert-page .alert-title,
        .page-content .monitor-page .monitor-title { font-size: 20px !important; }

        .page-content .alert-page .alert-count { font-size: 24px !important; }

        .page-content .alert-page .alert-cycle,
        .page-content .alert-page .alert-section-title,
        .page-content .monitor-page .monitor-section-heading,
        .page-content .monitor-page .monitor-value,
        .page-content .role-title,
        .page-content .jurnal-mapel { font-size: 15px !important; }

        .page-content .form-title,
        .page-content .izin-form-heading { font-size: 17px !important; }

        .page-content [style*="font-size: 28px"],
        .page-content [style*="font-size:24px"] { font-size: 22px !important; font-weight: 700 !important; letter-spacing: -.02em; }
        .page-content [style*="font-size: 32px"] { font-size: 26px !important; }

        /* ---------- PENYERAGAMAN ELEMEN DI SEMUA HALAMAN ---------- */

        .page-content div[class],
        .page-content section[class],
        .page-content article[class] { box-shadow: none !important; }

        .page-content a[style*="#198754"],
        .page-content button[style*="#198754"] {
            background: var(--scp-blue-900) !important;
            border-radius: var(--r-ctl) !important;
            font-weight: 600 !important;
        }

        /* ---------- RESPONSIF ---------- */

        @media (max-width: 900px) {
            .sidebar { width: 216px; }
            .main { margin-left: 216px; }
            .topbar { padding: 0 20px; }
            .page-content { padding: 20px; }
            .master-data-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 640px) {
            .sidebar { width: 0; overflow: hidden; border: 0; }
            .main { margin-left: 0; }
            .topbar { padding: 0 16px; }
            .topbar-date { display: none; }
            .page-content { padding: 14px; }
            .master-data-grid { grid-template-columns: 1fr; }
            .master-data-header { flex-direction: column; align-items: flex-start; }
        }

        @media (prefers-reduced-motion: reduce) {
            a, .logout-btn { transition: none; }
        }
    </style>

    @stack('styles')

</head>

<body>

    
{{-- SIDEBAR --}}
@include('components.sidebar')

{{-- MAIN CONTENT --}}
<main class="main">

    <header class="topbar">
        <div class="page-title">
            @yield('page-title')
        </div>

        <div class="topbar-date" id="topbar-date"></div>
    </header>

    <section class="page-content">
        @yield('content')
    </section>

</main>

    @stack('scripts')

    {{-- NOTIFIKASI JADWAL BENTROK --}}
    <div
        id="jadwal-bentrok-data"
        data-message="{{ session('error') }}"
        hidden>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dataNotifikasi = document.getElementById('jadwal-bentrok-data');

            if (!dataNotifikasi) return;

            const pesan = dataNotifikasi.dataset.message;

            if (pesan && typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian',
                    text: pesan,
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#15385f',
                    allowOutsideClick: false
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tgl = document.getElementById('topbar-date');

            if (tgl) {
                tgl.textContent = new Date().toLocaleDateString('id-ID', {
                    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                });
            }
        });
    </script>

</body>
</html>

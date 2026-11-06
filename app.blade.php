<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - SCP
    </title>

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
        @import url('https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap');

        /* =====================================================
           SCP - NAVY INSTITUSIONAL (versi ringkas)
           ===================================================== */

        :root {
            --scp-blue-950: #102b4e;
            --scp-blue-900: #15385f;
            --scp-blue-800: #1d4c7a;
            --scp-blue-700: #28628f;
            --scp-blue-100: #e6edf5;
            --scp-blue-50: #f3f6fa;
            --scp-border: #dce3eb;
            --scp-text: #25364a;
            --scp-muted: #718096;
            --scp-white: #ffffff;
            --scp-canvas: #f3f5f8;
        }

        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
        }

        body,
        button,
        input,
        select,
        textarea {
            font-family: "Work Sans", Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-size: 13px;
            line-height: 1.5;
            color: var(--scp-text);
            background: var(--scp-canvas);
        }

        a {
            transition: color .15s ease, background-color .15s ease, border-color .15s ease;
        }

        /* ---------- SIDEBAR ---------- */

        .sidebar {
            position: fixed;
            z-index: 1030;
            inset: 0 auto 0 0;
            width: 232px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--scp-blue-950);
            color: #fff;
        }

        .sidebar-header {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
        }

        .sidebar-header span {
            display: block;
            margin-top: 2px;
            font-size: 11px;
            color: #b9c9dc;
        }

        .menu {
            flex: 1;
            padding: 14px 10px;
            overflow-y: auto;
        }

        .menu-title {
            margin: 12px 10px 6px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: #91a8c2;
        }

        .menu-title:first-child {
            margin-top: 2px;
        }

        .menu a {
            display: block;
            margin: 1px 0;
            padding: 8px 12px;
            border-left: 3px solid transparent;
            border-radius: 4px;
            color: #dce6f1;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff;
        }

        .menu a.active {
            background: #1d3f68;
            border-left-color: #a9c8e8;
            color: #fff;
            font-weight: 600;
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
            border-top: 1px solid rgba(255, 255, 255, .12);
            background: #0d2543;
        }

        .user-info {
            margin-bottom: 10px;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            overflow-wrap: anywhere;
        }

        .user-role {
            margin-top: 1px;
            font-size: 11.5px;
            color: #aebfd2;
        }

        .profile-sidebar-link {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            margin-bottom: 8px;
            padding: 8px 10px;
            border: 1px solid rgba(255, 255, 255, .17);
            border-radius: 4px;
            background: rgba(255, 255, 255, .06);
            color: #edf4fb;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
        }

        .profile-sidebar-link i {
            font-size: 15px;
            color: #b8d2ed;
        }

        .profile-sidebar-link:hover {
            background: rgba(255, 255, 255, .13);
            border-color: rgba(255, 255, 255, .26);
            color: #fff;
        }

        .logout-btn {
            width: 100%;
            padding: 7px 10px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 4px;
            background: transparent;
            color: #f1f5f9;
            cursor: pointer;
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 600;
            transition: background .15s ease, border-color .15s ease;
        }

        .logout-btn:hover {
            background: #8f3540;
            border-color: #a94b56;
            color: #fff;
        }

        /* ---------- KONTEN UTAMA ---------- */

        .main {
            margin-left: 232px;
            min-height: 100vh;
            background: var(--scp-canvas);
        }

        .topbar {
            min-height: 52px;
            padding: 10px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-bottom: 1px solid var(--scp-border);
        }

        .page-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--scp-blue-950);
        }

        .page-content {
            padding: 22px 26px;
        }

        /* ---------- CARD ---------- */

        .card {
            padding: 18px;
            background: #fff;
            border: 1px solid var(--scp-border);
            border-radius: 6px;
            box-shadow: none;
        }

        .card-title {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 600;
            color: var(--scp-blue-950);
        }

        .card-text {
            margin: 0;
            font-size: 13px;
            color: var(--scp-muted);
        }

        /* ---------- MASTER DATA ---------- */

        .master-data-container {
            padding: 0;
        }

        .master-data-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }

        .master-data-header h2 {
            margin: 0 0 3px;
            font-size: 18px;
            font-weight: 600;
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
            padding: 16px 18px;
            background: #fff;
            border: 1px solid var(--scp-border);
            border-radius: 6px;
            color: var(--scp-text);
            text-decoration: none;
            box-shadow: none;
        }

        .master-data-card:hover {
            border-color: #aabdd1;
            background: #fbfcfe;
        }

        .master-data-card-title {
            margin-bottom: 4px;
            font-size: 14px;
            font-weight: 600;
            color: var(--scp-blue-800);
        }

        .master-data-card-text {
            font-size: 12.5px;
            color: var(--scp-muted);
        }

        /* ---------- TOMBOL ---------- */

        .btn-primary,
        .main .btn-primary {
            display: inline-block;
            padding: 7px 14px;
            border: 1px solid var(--scp-blue-900);
            border-radius: 5px;
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

        .btn-secondary {
            display: inline-block;
            padding: 7px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            background: #fff;
            color: #475569;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            border-color: #aab8c8;
            color: var(--scp-blue-950);
        }

        .btn-edit,
        .btn-delete {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 4px;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-edit {
            border: 1px solid #c9d8e8;
            background: #eef3f9;
            color: #1d4c7a;
        }

        .btn-delete {
            border: 1px solid #f1cccc;
            background: #fff3f3;
            color: #b42b2b;
        }

        /* ---------- ALERT ---------- */

        .alert-success {
            margin-bottom: 16px;
            padding: 10px 13px;
            border: 1px solid #b9e0c9;
            border-radius: 5px;
            background: #f0faf4;
            color: #17633d;
            font-size: 13px;
        }

        /* ---------- TABEL ---------- */

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid var(--scp-border);
            border-radius: 6px;
            background: #fff;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid var(--scp-border);
            background: #f1f4f8;
            color: #52657a;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .04em;
        }

        .data-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #edf0f4;
            font-size: 13px;
            color: #34465a;
        }

        .data-table tbody tr:hover {
            background: #f7f9fc;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .empty-data {
            padding: 24px !important;
            text-align: center;
            color: #7d8ea1;
        }

        /* ---------- FORM ---------- */

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 12.5px;
            font-weight: 600;
            color: #34465a;
        }

        .form-input {
            width: 100%;
            max-width: 500px;
            min-height: 38px;
            padding: 8px 11px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            background: #fff;
            color: var(--scp-text);
            font-size: 13px;
            outline: none;
        }

        .form-input:focus {
            border-color: #52799f;
            box-shadow: 0 0 0 3px rgba(40, 98, 143, .12);
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
            margin-top: 20px;
        }

        /* ---------- PENYESUAIAN BOOTSTRAP ---------- */

        .main .container,
        .main .container-fluid {
            max-width: 100%;
        }

        .main .form-control,
        .main .form-select {
            min-height: 38px;
            border-color: #cbd5e1;
            border-radius: 5px;
            color: var(--scp-text);
            font-size: 13px;
        }

        .main .form-control:focus,
        .main .form-select:focus {
            border-color: #52799f;
            box-shadow: 0 0 0 3px rgba(40, 98, 143, .12);
        }

        .main .btn {
            border-radius: 5px;
            font-size: 13px;
        }

        .main .table {
            --bs-table-bg: #fff;
            --bs-table-color: var(--scp-text);
            --bs-table-border-color: #e3e9f0;
            font-size: 13px;
        }

        .main .table thead th {
            background: #f1f4f8;
            color: #52657a;
            border-color: var(--scp-border);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .04em;
        }

        .alert,
        .alert-success {
            border-radius: 5px;
        }

        .badge {
            font-weight: 600;
        }

        /* ---------- UKURAN JUDUL (berlaku untuk semua halaman) ----------
           Judul bawaan tiap halaman bervariasi 20-28px. Blok ini
           menyeragamkannya. Hapus blok ini jika ingin kembali ke ukuran
           masing-masing halaman. */

        .page-content h1 { font-size: 20px !important; font-weight: 600; }
        .page-content h2 { font-size: 18px !important; font-weight: 600; }
        .page-content h3 { font-size: 15px !important; font-weight: 600; }
        .page-content h4 { font-size: 14px !important; font-weight: 600; }
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

        .page-content [style*="font-size: 28px"] { font-size: 22px !important; }
        .page-content [style*="font-size: 32px"] { font-size: 26px !important; }

        /* ---------- RESPONSIF ---------- */

        @media (max-width: 900px) {
            .sidebar {
                width: 212px;
            }

            .main {
                margin-left: 212px;
            }

            .topbar {
                padding: 10px 20px;
            }

            .page-content {
                padding: 18px 20px;
            }

            .master-data-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .sidebar {
                width: 0;
                overflow: hidden;
                border: 0;
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                padding: 10px 16px;
            }

            .page-content {
                padding: 14px;
            }

            .master-data-grid {
                grid-template-columns: 1fr;
            }

            .master-data-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .menu a,
            .logout-btn,
            .profile-sidebar-link {
                transition: none;
            }
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
                    title: 'Jadwal Bentrok!',
                    text: pesan,
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#15385f',
                    allowOutsideClick: false
                });
            }
        });
    </script>

</body>
</html>

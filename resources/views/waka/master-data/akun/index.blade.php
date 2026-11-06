@extends('layouts.app')

@section('title', 'Akun')
@section('page-title', 'Akun')

@section('content')

<style>
    .akun-container {
        display: grid;
        grid-template-columns: 330px 1fr;
        gap: 24px;
        align-items: start;
    }

    .akun-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 22px;
    }

    .akun-card h2 {
        margin: 0 0 6px;
        font-size: 20px;
        color: #1f2937;
    }

    .akun-card-description {
        margin: 0 0 20px;
        color: #6b7280;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        background: #fff;
        outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #6b7280;
    }

    .btn-primary {
        width: 100%;
        border: none;
        background: #374151;
        color: #fff;
        padding: 11px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: #1f2937;
    }

    /* Bagian kanan */
    .akun-list-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 22px;
    }

    .akun-list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 18px;
    }

    .akun-list-header h2 {
        margin: 0;
        font-size: 20px;
        color: #1f2937;
    }

    .akun-search {
        width: 240px;
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        font-size: 14px;
        box-sizing: border-box;
    }

    .akun-search:focus {
        border-color: #6b7280;
    }

    /* Tab role */
    .role-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .role-tab {
        border: 1px solid #d1d5db;
        background: #fff;
        color: #4b5563;
        padding: 9px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }

    .role-tab:hover {
        background: #f3f4f6;
    }

    .role-tab.active {
        background: #374151;
        border-color: #374151;
        color: #fff;
    }

    .role-count {
        margin-left: 4px;
        opacity: 0.8;
    }

    /* Tabel */
    .role-content {
        display: none;
    }

    .role-content.active {
        display: block;
    }

    .role-title {
        margin: 0 0 14px;
        font-size: 17px;
        font-weight: 700;
        color: #1f2937;
    }

    .akun-table-wrapper {
        overflow-x: auto;
    }

    .akun-table {
        width: 100%;
        border-collapse: collapse;
    }

    .akun-table th {
        text-align: left;
        padding: 12px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        color: #4b5563;
        font-size: 13px;
        font-weight: 600;
    }

    .akun-table td {
        padding: 13px 12px;
        border-bottom: 1px solid #f0f0f0;
        color: #374151;
        font-size: 14px;
    }

    .akun-table tbody tr:hover {
        background: #fafafa;
    }

    .role-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #f3f4f6;
        color: #4b5563;
        font-size: 12px;
        font-weight: 600;
    }

    .aksi {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        text-decoration: none;
        border: 1px solid #e5e7eb;
        background: #fff;
        cursor: pointer;
        font-size: 15px;
    }

    .btn-edit {
        color: #374151;
    }

    .btn-edit:hover {
        background: #f3f4f6;
    }

    .btn-delete {
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #fef2f2;
    }

    .empty-data {
        padding: 30px;
        text-align: center;
        color: #9ca3af;
        font-size: 14px;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
    }

    .alert-success {
        margin-bottom: 18px;
        padding: 11px 14px;
        border-radius: 8px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        font-size: 14px;
    }

    .error-message {
        margin-top: 5px;
        color: #dc2626;
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .akun-container {
            grid-template-columns: 1fr;
        }

        .akun-list-header {
            flex-direction: column;
            align-items: stretch;
        }

        .akun-search {
            width: 100%;
        }
    }

    @media (max-width: 600px) {
        .role-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .role-tab {
            width: 100%;
        }
    }
</style>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="akun-container">

    {{-- ============================= --}}
    {{-- FORM BUAT AKUN --}}
    {{-- ============================= --}}
    <div class="akun-card">

        <h2>+ Buat Akun Baru</h2>

        <p class="akun-card-description">
            Tambahkan akun pengguna baru ke dalam sistem.
        </p>

        <form action="{{ route('waka.master-data.akun.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    required
                >

                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>

                <input
                    type="text"
                    id="nama_lengkap"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                >

                @error('nama_lengkap')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 6 karakter"
                    required
                >

                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="peran_id">Role</label>

                <select id="peran_id" name="peran_id" required>
                    <option value="">-- Pilih Role --</option>

                    @foreach(\App\Models\Peran::orderBy('id')->get() as $role)
                        <option
                            value="{{ $role->id }}"
                            {{ old('peran_id') == $role->id ? 'selected' : '' }}
                        >
                            {{ $role->nama_peran }}
                        </option>
                    @endforeach
                </select>

                @error('peran_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary">
                Simpan Akun
            </button>
        </form>

    </div>


    {{-- ============================= --}}
    {{-- DAFTAR AKUN --}}
    {{-- ============================= --}}
    <div class="akun-list-card">

        <div class="akun-list-header">
            <h2>Daftar Akun</h2>

            <input
                type="text"
                id="searchAkun"
                class="akun-search"
                placeholder="Cari akun..."
            >
        </div>


        {{-- ============================= --}}
        {{-- TAB ROLE --}}
        {{-- ============================= --}}
        @php
            $roles = [
                1 => 'Waka Kurikulum',
                2 => 'Guru',
                3 => 'Wali Kelas',
                4 => 'Guru BK',
                5 => 'Siswa',
            ];
        @endphp

        <div class="role-tabs">

            @foreach($roles as $roleId => $roleName)

                @php
                    $jumlahAkun = $akun->where('peran_id', $roleId)->count();
                @endphp

                <button
                    type="button"
                    class="role-tab {{ $loop->first ? 'active' : '' }}"
                    data-role="{{ $roleId }}"
                >
                    {{ $roleName }}
                    <span class="role-count">
                        ({{ $jumlahAkun }})
                    </span>
                </button>

            @endforeach

        </div>


        {{-- ============================= --}}
        {{-- ISI MASING-MASING ROLE --}}
        {{-- ============================= --}}
        @foreach($roles as $roleId => $roleName)

            @php
                $akunRole = $akun->where('peran_id', $roleId);
            @endphp

            <div
                class="role-content {{ $loop->first ? 'active' : '' }}"
                data-role-content="{{ $roleId }}"
            >

                <h3 class="role-title">
                    Akun {{ $roleName }}
                </h3>

                @if($akunRole->count())

                    <div class="akun-table-wrapper">

                        <table class="akun-table">

                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Nama Lengkap</th>
                                    <th>Role</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($akunRole as $item)

                                    <tr class="akun-row">

                                        <td>
                                            {{ $item->username }}
                                        </td>

                                        <td>
                                            {{ $item->nama_lengkap }}
                                        </td>

                                        <td>
                                            <span class="role-badge">
                                                {{ $item->peran->nama_peran ?? $roleName }}
                                            </span>
                                        </td>

                                        <td>

                                            <div class="aksi">

                                                {{-- Edit --}}
                                                <a
                                                    href="{{ route('waka.master-data.akun.edit', $item->id) }}"
                                                    class="btn-icon btn-edit"
                                                    title="Edit akun"
                                                >
                                                    ✎
                                                </a>

                                                {{-- Hapus --}}
                                                <form
                                                    action="{{ route('waka.master-data.akun.destroy', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus akun ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn-icon btn-delete"
                                                        title="Hapus akun"
                                                    >
                                                        🗑
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="empty-data">
                        Belum ada akun untuk role {{ $roleName }}.
                    </div>

                @endif

            </div>

        @endforeach

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const roleTabs = document.querySelectorAll('.role-tab');
        const roleContents = document.querySelectorAll('.role-content');
        const searchInput = document.getElementById('searchAkun');

        let activeRole = '1';


        // =========================================
        // GANTI ROLE
        // =========================================
        roleTabs.forEach(function (tab) {

            tab.addEventListener('click', function () {

                activeRole = this.dataset.role;

                // Aktifkan tombol yang dipilih
                roleTabs.forEach(function (item) {
                    item.classList.remove('active');
                });

                this.classList.add('active');


                // Tampilkan isi role yang dipilih
                roleContents.forEach(function (content) {

                    if (content.dataset.roleContent === activeRole) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }

                });


                // Reset pencarian ketika pindah role
                searchInput.value = '';

                roleContents.forEach(function (content) {

                    content.querySelectorAll('.akun-row').forEach(function (row) {
                        row.style.display = '';
                    });

                });

            });

        });


        // =========================================
        // PENCARIAN
        // =========================================
        searchInput.addEventListener('input', function () {

            const keyword = this.value.toLowerCase().trim();

            roleContents.forEach(function (content) {

                if (content.dataset.roleContent !== activeRole) {
                    return;
                }

                const rows = content.querySelectorAll('.akun-row');

                rows.forEach(function (row) {

                    const text = row.textContent.toLowerCase();

                    if (text.includes(keyword)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }

                });

            });

        });

    });
</script>

@endsection

@extends('layouts.app')

@section('title', 'Edit Akun')
@section('page-title', 'Edit Akun')

@section('content')

<style>
    .edit-akun-wrapper {
        max-width: 850px;
        margin: 0 auto;
    }

    .edit-akun-card {
        background: #fff;
        border: 1px solid #dce5f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15, 42, 78, .05);
    }

    .edit-akun-header {
        padding: 25px 28px;
        background: #102c50;
        color: #fff;
    }

    .edit-akun-header h2 {
        margin: 0 0 7px;
        font-size: 21px;
        font-weight: 700;
    }

    .edit-akun-header p {
        margin: 0;
        color: #d3e0f1;
        font-size: 13px;
    }

    .edit-akun-body {
        padding: 28px;
    }

    .edit-akun-info {
        padding: 14px 16px;
        margin-bottom: 24px;
        border: 1px solid #d8e6f5;
        border-radius: 9px;
        background: #f2f6fc;
        color: #294768;
        font-size: 13px;
        line-height: 1.6;
    }

    .edit-form-group {
        margin-bottom: 20px;
    }

    .edit-form-group label {
        display: block;
        margin-bottom: 8px;
        color: #263d58;
        font-size: 14px;
        font-weight: 600;
    }

    .edit-form-group input,
    .edit-form-group select {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        border: 1px solid #cbd6e3;
        border-radius: 8px;
        background: #fff;
        color: #23364d;
        font-size: 14px;
        outline: none;
        transition: .2s;
    }

    .edit-form-group input:focus,
    .edit-form-group select:focus {
        border-color: #315d91;
        box-shadow: 0 0 0 3px rgba(49, 93, 145, .10);
    }

    .edit-form-group input::placeholder {
        color: #9aa9ba;
    }

    .edit-form-group small {
        display: block;
        margin-top: 6px;
        color: #78899d;
        font-size: 12px;
    }

    .edit-section-title {
        margin: 28px 0 16px;
        padding-bottom: 11px;
        border-bottom: 1px solid #e5ebf2;
        color: #183b63;
        font-size: 15px;
        font-weight: 700;
    }

    .edit-error {
        margin-top: 6px;
        color: #dc3545;
        font-size: 12px;
    }

    .edit-alert {
        padding: 13px 15px;
        margin-bottom: 20px;
        border: 1px solid #f2c5c5;
        border-radius: 8px;
        background: #fff5f5;
        color: #a52a2a;
        font-size: 13px;
    }

    .edit-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #e5ebf2;
    }

    .edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 19px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .edit-btn-back {
        border: 1px solid #cbd6e3;
        background: #fff;
        color: #40546d;
    }

    .edit-btn-back:hover {
        background: #f3f6fa;
    }

    .edit-btn-save {
        border: 1px solid #102c50;
        background: #102c50;
        color: #fff;
    }

    .edit-btn-save:hover {
        background: #1d4775;
    }

    /* Menyembunyikan pilihan kelas perwalian */
    .kelas-perwalian-hidden {
        display: none;
    }

    @media(max-width: 600px) {
        .edit-akun-body {
            padding: 20px;
        }

        .edit-akun-header {
            padding: 21px;
        }

        .edit-actions {
            flex-direction: column-reverse;
        }

        .edit-btn {
            width: 100%;
        }
    }
</style>

<div class="edit-akun-wrapper">

    <div class="edit-akun-card">

        <div class="edit-akun-header">
            <h2>Edit Akun Pengguna</h2>
            <p>Perbarui informasi akun pengguna SCP.</p>
        </div>

        <div class="edit-akun-body">

            <div class="edit-akun-info">
                <strong>Informasi:</strong>
                Password boleh dikosongkan apabila tidak ingin
                mengganti password akun.
            </div>

            @if($errors->any())
                <div class="edit-alert">
                    <strong>Periksa kembali data berikut:</strong>

                    <ul style="margin: 8px 0 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('waka.master-data.akun.update', $akun->id) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                {{-- NAMA LENGKAP --}}
                <div class="edit-form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>

                    <input
                        type="text"
                        id="nama_lengkap"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap', $akun->nama_lengkap) }}"
                        placeholder="Masukkan nama lengkap"
                        required
                    >

                    @error('nama_lengkap')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- USERNAME --}}
                <div class="edit-form-group">
                    <label for="username">Username</label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username', $akun->username) }}"
                        placeholder="Masukkan username"
                        required
                    >

                    @error('username')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ROLE PENGGUNA --}}
                <div class="edit-form-group">
                    <label for="peran_id">Role Pengguna</label>

                    <select id="peran_id" name="peran_id" required>
                        <option value="">-- Pilih Role --</option>

                        @foreach($roles as $role)
                            <option
                                value="{{ $role->id }}"
                                {{ old('peran_id', $akun->peran_id) == $role->id ? 'selected' : '' }}
                            >
                                {{ $role->nama_peran }}
                            </option>
                        @endforeach
                    </select>

                    @error('peran_id')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KELAS PERWALIAN (Guru dan Wali Kelas) --}}
                <div
                    class="edit-form-group {{ in_array((int) old('peran_id', $akun->peran_id), [2, 3], true) ? '' : 'kelas-perwalian-hidden' }}"
                    id="kelas-perwalian-group"
                >
                    <label for="kelas_id">
                        Kelas Perwalian (Wali Kelas)
                    </label>

                    <select id="kelas_id" name="kelas_id">
                        <option value="">
                            -- Tidak Menjadi Wali Kelas --
                        </option>

                        @foreach($kelas as $item)
                            <option
                                value="{{ $item->id }}"
                                {{ old('kelas_id', $akun->kelas_id) == $item->id ? 'selected' : '' }}
                            >
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>

                    <small>
                        Pilih kelas jika guru tersebut bertugas sebagai wali kelas.
                    </small>

                    @error('kelas_id')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PENGATURAN PASSWORD --}}
                <h3 class="edit-section-title">
                    Pengaturan Password
                </h3>

                <div class="edit-form-group">
                    <label for="password">Password Baru</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password baru"
                        autocomplete="new-password"
                    >

                    <small>
                        Kosongkan jika password tidak ingin diubah.
                        Minimal 6 karakter jika diisi.
                    </small>

                    @error('password')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TOMBOL --}}
                <div class="edit-actions">

                    <a
                        href="{{ route('waka.master-data.akun.index') }}"
                        class="edit-btn edit-btn-back"
                    >
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="edit-btn edit-btn-save"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

{{-- JAVASCRIPT KELAS PERWALIAN --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.getElementById('peran_id');
    const kelasGroup = document.getElementById('kelas-perwalian-group');
    const kelasSelect = document.getElementById('kelas_id');

    function aturKelasPerwalian() {

        if (roleSelect.value === '2' || roleSelect.value === '3') {

            // Tampilkan dropdown kelas untuk Role Guru
            kelasGroup.classList.remove('kelas-perwalian-hidden');

            // Aktifkan input kelas
            kelasSelect.disabled = false;

        } else {

            // Sembunyikan dropdown untuk role selain Guru
            kelasGroup.classList.add('kelas-perwalian-hidden');

            // Nonaktifkan input kelas
            kelasSelect.disabled = true;

            // Kosongkan pilihan kelas
            kelasSelect.value = '';
        }
    }

    // Ketika Role pengguna berubah
    roleSelect.addEventListener('change', aturKelasPerwalian);

    // Periksa Role ketika halaman pertama kali dibuka
    aturKelasPerwalian();

});
</script>

@endsection

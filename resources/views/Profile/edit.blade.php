
@extends('layouts.app')

@section('title', 'Update Profil')

@section('page-title', 'Update Profil')

@section('content')

<div class="profile-container">

    <div class="profile-card">

        <div class="profile-heading">
            <div class="profile-icon">
                <i class="bi bi-person-circle"></i>
            </div>

            <div>
                <h2>Update Profil</h2>
                <p>Kelola informasi akun SCP kamu.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="profile-alert-error">
                Periksa kembali data yang kamu masukkan.
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="profile-form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama_lengkap"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                    required
                >

                @error('nama_lengkap')
                    <small class="profile-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="profile-form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username', $user->username) }}"
                    required
                >

                @error('username')
                    <small class="profile-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="profile-form-group">
                <label>Role</label>
                <input
                    type="text"
                    value="{{ $user->peran->nama_peran ?? 'Pengguna' }}"
                    disabled
                >
                <small class="profile-hint">
                    Role akun tidak dapat diubah melalui halaman ini.
                </small>
            </div>

            <div class="profile-divider"></div>

            <h3>Ubah Password</h3>
            <p class="profile-description">
                Kosongkan bagian password jika tidak ingin menggantinya.
            </p>

            <div class="profile-form-group">
                <label for="password_saat_ini">Password Saat Ini</label>
                <input
                    type="password"
                    id="password_saat_ini"
                    name="password_saat_ini"
                    autocomplete="current-password"
                >

                @error('password_saat_ini')
                    <small class="profile-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="profile-form-group">
                <label for="password_baru">Password Baru</label>
                <input
                    type="password"
                    id="password_baru"
                    name="password_baru"
                    autocomplete="new-password"
                >

                @error('password_baru')
                    <small class="profile-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="profile-form-group">
                <label for="password_baru_confirmation">
                    Konfirmasi Password Baru
                </label>
                <input
                    type="password"
                    id="password_baru_confirmation"
                    name="password_baru_confirmation"
                    autocomplete="new-password"
                >
            </div>

            <div class="profile-actions">
                <a href="javascript:history.back()" class="profile-cancel">
                    Kembali
                </a>

                <button type="submit" class="profile-save">
                    <i class="bi bi-check-circle"></i>
                    Simpan Perubahan
                </button>
            </div>

        </form>

        @include('profile._email', ['user' => $user])

    </div>

</div>

@endsection

@push('styles')
<style>
    .profile-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .profile-card {
        padding: 28px;
        background: rgba(255,255,255,.96);
        border: 1px solid #d7e6f3;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(37,99,145,.07);
    }

    .profile-heading {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 28px;
    }

    .profile-icon {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: #e5f3ff;
        color: #176fb0;
        font-size: 27px;
    }

    .profile-heading h2 {
        margin: 0;
        font-size: 21px;
        font-weight: 800;
        color: #123b68;
    }

    .profile-heading p,
    .profile-description {
        margin: 5px 0 0;
        color: #66819a;
        font-size: 13px;
    }

    .profile-form-group {
        margin-bottom: 20px;
    }

    .profile-form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #193b5b;
    }

    .profile-form-group input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #cbddeb;
        border-radius: 9px;
        background: #fff;
        color: #193b5b;
        font-size: 14px;
        outline: none;
    }

    .profile-form-group input:focus {
        border-color: #70b8e8;
        box-shadow: 0 0 0 3px rgba(58,153,215,.13);
    }

    .profile-form-group input:disabled {
        background: #edf4fa;
        color: #66819a;
        cursor: not-allowed;
    }

    .profile-hint {
        display: block;
        margin-top: 6px;
        color: #66819a;
        font-size: 11px;
    }

    .profile-error {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-size: 12px;
    }

    .profile-divider {
        height: 1px;
        margin: 28px 0;
        background: #e2edf6;
    }

    .profile-card h3 {
        margin: 0;
        color: #123b68;
        font-size: 16px;
        font-weight: 800;
    }

    .profile-description {
        margin-bottom: 20px;
    }

    .profile-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 28px;
    }

    .profile-save,
    .profile-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 11px 17px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .profile-save {
        border: 1px solid #176fb0;
        background: linear-gradient(135deg,#2389ce,#1769aa);
        color: white;
    }

    .profile-save:hover {
        background: #145b95;
        color: white;
    }

    .profile-cancel {
        border: 1px solid #cfe0ee;
        background: white;
        color: #42627e;
    }

    .profile-alert-error {
        margin-bottom: 18px;
        padding: 12px 15px;
        border: 1px solid #fecaca;
        border-radius: 9px;
        background: #fef2f2;
        color: #b91c1c;
        font-size: 13px;
    }

    @media(max-width: 640px) {
        .profile-card {
            padding: 20px;
        }

        .profile-actions > * {
            width: 100%;
        }
    }
</style>
@endpush

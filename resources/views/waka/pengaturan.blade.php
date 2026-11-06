@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('page-title', 'Pengaturan Sistem')

@section('menu')

    <div class="menu-title">
        Menu Utama
    </div>

    <a href="{{ route('waka.dashboard') }}">
        Dashboard
    </a>

    <a href="{{ route('waka.pengaturan') }}" class="active">
        Pengaturan Sistem
    </a>

@endsection

@section('content')

    @if (session('success'))
        <div style="
            margin-bottom:20px;
            padding:12px 15px;
            background:#ecfdf5;
            border:1px solid #a7f3d0;
            color:#047857;
            border-radius:6px;
            font-size:13px;
        ">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="
            margin-bottom:20px;
            padding:12px 15px;
            background:#fef2f2;
            border:1px solid #fecaca;
            color:#b91c1c;
            border-radius:6px;
            font-size:13px;
        ">
            <strong>Terdapat kesalahan:</strong>

            <ul style="margin:8px 0 0 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">

        <h3 class="card-title">
            Pengaturan Sistem
        </h3>

        <p class="card-text">
            Atur status jadwal dan putaran pembelajaran yang aktif.
        </p>

        <form
            action="{{ route('waka.pengaturan.update') }}"
            method="POST"
            style="margin-top:25px;"
        >

            @csrf
            @method('PUT')

            {{-- Status Jadwal --}}
            <div style="margin-bottom:25px;">

                <label style="
                    display:block;
                    font-size:13px;
                    font-weight:600;
                    color:#374151;
                    margin-bottom:10px;
                ">
                    Status Jadwal
                </label>

                <div style="
                    border:1px solid #e5e7eb;
                    border-radius:8px;
                    padding:15px;
                    background:#f9fafb;
                ">

                    <label style="
                        display:flex;
                        align-items:center;
                        gap:10px;
                        margin-bottom:10px;
                        font-size:13px;
                        color:#374151;
                        cursor:pointer;
                    ">

                        <input
                            type="radio"
                            name="jadwal_dikunci"
                            value="0"
                            {{ old(
                                'jadwal_dikunci',
                                $konfigurasi && $konfigurasi->jadwal_dikunci ? '1' : '0'
                            ) == '0' ? 'checked' : '' }}
                        >

                        <span>
                            🔓 Jadwal Terbuka
                        </span>

                    </label>

                    <label style="
                        display:flex;
                        align-items:center;
                        gap:10px;
                        font-size:13px;
                        color:#374151;
                        cursor:pointer;
                    ">

                        <input
                            type="radio"
                            name="jadwal_dikunci"
                            value="1"
                            {{ old(
                                'jadwal_dikunci',
                                $konfigurasi && $konfigurasi->jadwal_dikunci ? '1' : '0'
                            ) == '1' ? 'checked' : '' }}
                        >

                        <span>
                            🔒 Jadwal Terkunci
                        </span>

                    </label>

                </div>

            </div>


            {{-- Putaran Aktif --}}
            <div style="margin-bottom:25px;">

                <label
                    for="siklus_aktif"
                    style="
                        display:block;
                        font-size:13px;
                        font-weight:600;
                        color:#374151;
                        margin-bottom:8px;
                    "
                >
                    Putaran Aktif
                </label>

                <select
                    id="siklus_aktif"
                    name="siklus_aktif"
                    style="
                        width:100%;
                        max-width:400px;
                        padding:10px 12px;
                        border:1px solid #d1d5db;
                        border-radius:6px;
                        background:white;
                        color:#374151;
                        font-size:13px;
                    "
                >

                    <option
                        value="Putaran 1"
                        {{ old(
                            'siklus_aktif',
                            $konfigurasi->siklus_aktif ?? 'Putaran 1'
                        ) == 'Putaran 1' ? 'selected' : '' }}
                    >
                        Putaran 1
                    </option>

                    <option
                        value="Putaran 2"
                        {{ old(
                            'siklus_aktif',
                            $konfigurasi->siklus_aktif ?? 'Putaran 1'
                        ) == 'Putaran 2' ? 'selected' : '' }}
                    >
                        Putaran 2
                    </option>

                </select>

            </div>


            {{-- Tombol --}}
            <div style="
                display:flex;
                gap:10px;
                align-items:center;
                flex-wrap:wrap;
            ">

                <button
                    type="submit"
                    style="
                        padding:9px 16px;
                        background:#198754;
                        color:white;
                        border:none;
                        border-radius:6px;
                        font-size:13px;
                        font-weight:500;
                        cursor:pointer;
                    "
                >
                    Simpan Pengaturan
                </button>

                <a
                    href="{{ route('waka.dashboard') }}"
                    style="
                        display:inline-block;
                        padding:9px 16px;
                        background:#f3f4f6;
                        color:#374151;
                        text-decoration:none;
                        border:1px solid #d1d5db;
                        border-radius:6px;
                        font-size:13px;
                    "
                >
                    Kembali
                </a>

            </div>

        </form>

    </div>

@endsection
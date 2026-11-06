@extends('layouts.app')

@section('title', 'Dashboard Kesiswaan')

@section('page-title', 'Dashboard Kesiswaan')

@section('menu')

    <div class="menu-title">
        Menu Utama
    </div>

    <a
        href="{{ route('kesiswaan.dashboard') }}"
        class="active"
    >
        Dashboard
    </a>

    <a href="#">
        Data Siswa
    </a>

    <a href="#">
        Presensi
    </a>

    <a href="#">
        Perizinan
    </a>

@endsection


@section('content')

    <div class="card">

        <h3 class="card-title">
            Selamat datang,
            {{ auth()->user()->nama_lengkap }}
        </h3>

        <p class="card-text">
            Halaman pengelolaan data kesiswaan.
        </p>

    </div>

    {{-- Peringatan Jurnal Mengajar (khusus akun yang juga mengajar) --}}
    @if ($punyaJadwalMengajar)
        @include('partials.peringatan-jurnal-live')
    @endif

@endsection
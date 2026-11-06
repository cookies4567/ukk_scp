
@extends('layouts.app')

@section('title', 'Manajemen Data')

@section('page-title', 'Manajemen Data')

@section('content')

<div class="master-data-container">

    <div class="master-data-header">
        <div>
            <h2>Manajamen Data</h2>

            <p>
                Kelola data dasar yang digunakan dalam sistem SCP.
            </p>
        </div>
    </div>

    <div class="master-data-grid">

        {{-- KELAS --}}
        <a
            href="{{ route('waka.master-data.kelas.index') }}"
            class="master-data-card"
        >
            <div class="master-data-card-title">
                Kelas
            </div>

            <div class="master-data-card-text">
                Kelola data kelas
            </div>
        </a>

        {{-- RUANG --}}
        <a
            href="{{ route('waka.master-data.ruangan.index') }}"
            class="master-data-card"
        >
            <div class="master-data-card-title">
                Ruang
            </div>

            <div class="master-data-card-text">
                Kelola data ruangan
            </div>
        </a>

        {{-- MATA PELAJARAN --}}
        <a
            href="{{ route('waka.master-data.mata-pelajaran.index') }}"
            class="master-data-card"
        >
            <div class="master-data-card-title">
                Mata Pelajaran
            </div>

            <div class="master-data-card-text">
                Kelola mata pelajaran
            </div>
        </a>

        {{-- AKUN --}}
        <a
            href="{{ route('waka.master-data.akun.index') }}"
            class="master-data-card"
        >
            <div class="master-data-card-title">
                Akun
            </div>

            <div class="master-data-card-text">
                Kelola akun pengguna sistem
            </div>
        </a>

        {{-- SISWA --}}
        <a
            href="{{ route('waka.master-data.siswa.index') }}"
            class="master-data-card"
        >
            <div class="master-data-card-title">
                Siswa
            </div>

            <div class="master-data-card-text">
                Kelola data siswa
            </div>
        </a>

    </div>

</div>

@endsection

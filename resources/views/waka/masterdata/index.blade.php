@extends('layouts.app')

@section('title', 'Manajemen Data')

@section('page-title', 'Manajemen Data')

@section('content')

<div class="master-data-container">

    <div class="master-data-header">
        <div>
            <h2>Manajemen Data</h2>
            <p>
                Kelola data dasar yang digunakan dalam sistem SCP.
            </p>
        </div>
    </div>

    <div class="master-data-grid">

        {{-- JURUSAN --}}
        <a href="#" class="master-data-card">

            <div class="master-data-card-title">
                Jurusan
            </div>

            <div class="master-data-card-text">
                Kelola data jurusan sekolah
            </div>

        </a>


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


        {{-- GURU --}}
        <a href="#" class="master-data-card">

            <div class="master-data-card-title">
                Guru
            </div>

            <div class="master-data-card-text">
                Kelola data guru
            </div>

        </a>


        {{-- SISWA --}}
<a href="{{ route('waka.master-data.siswa.index') }}">

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
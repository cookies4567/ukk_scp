@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('page-title', 'Edit Mata Pelajaran')

@section('content')

<div class="master-data-container">

    <div class="master-data-header">
        <div>
            <h2>Edit Mata Pelajaran</h2>
            <p>
                Perbarui kode dan nama mata pelajaran.
            </p>
        </div>

        <a
            href="{{ route('waka.master-data.mata-pelajaran.index') }}"
            class="btn-secondary"
        >
            Kembali
        </a>
    </div>


    <div class="card">

        <form
            action="{{ route('waka.master-data.mata-pelajaran.update', $mataPelajaran->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="kode_mata_pelajaran">
                    Kode Mata Pelajaran
                </label>

                <input
                    type="text"
                    id="kode_mata_pelajaran"
                    name="kode_mata_pelajaran"
                    value="{{ old('kode_mata_pelajaran', $mataPelajaran->kode_mata_pelajaran) }}"
                    maxlength="20"
                    class="form-input"
                    required
                >

                @error('kode_mata_pelajaran')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="nama_mata_pelajaran">
                    Nama Mata Pelajaran
                </label>

                <input
                    type="text"
                    id="nama_mata_pelajaran"
                    name="nama_mata_pelajaran"
                    value="{{ old('nama_mata_pelajaran', $mataPelajaran->nama_mata_pelajaran) }}"
                    maxlength="100"
                    class="form-input"
                    required
                >

                @error('nama_mata_pelajaran')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('waka.master-data.mata-pelajaran.index') }}"
                    class="btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-primary"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

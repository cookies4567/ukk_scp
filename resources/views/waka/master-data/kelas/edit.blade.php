@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('page-title', 'Edit Kelas')

@section('content')

<div class="master-data-container">

    <div class="master-data-header">
        <div>
            <h2>Edit Kelas</h2>
            <p>
                Perbarui data kelas yang sudah tersimpan.
            </p>
        </div>

        <a
            href="{{ route('waka.master-data.kelas.index') }}"
            class="btn-secondary"
        >
            Kembali
        </a>
    </div>


    <div class="card">

        <form
            action="{{ route('waka.master-data.kelas.update', $kelas->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="nama_kelas">
                    Nama Kelas
                </label>

                <input
                    type="text"
                    id="nama_kelas"
                    name="nama_kelas"
                    value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                    class="form-input"
                    required
                >

                @error('nama_kelas')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('waka.master-data.kelas.index') }}"
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
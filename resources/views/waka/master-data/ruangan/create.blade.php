@extends('layouts.app')

@section('title', 'Tambah Ruangan')

@section('page-title', 'Tambah Ruangan')

@section('content')

<div class="master-data-container">

    <div class="master-data-header">

        <div>
            <h2>Tambah Ruangan</h2>

            <p>
                Tambahkan data ruangan baru ke dalam sistem SCP.
            </p>
        </div>

        <a
            href="{{ route('waka.master-data.ruangan.index') }}"
            class="btn-secondary"
        >
            Kembali
        </a>

    </div>


    <div class="card">

        <form
            action="{{ route('waka.master-data.ruangan.store') }}"
            method="POST"
        >

            @csrf

            <div class="form-group">

                <label for="nama_ruangan">
                    Nama Ruangan
                </label>

                <input
                    type="text"
                    id="nama_ruangan"
                    name="nama_ruangan"
                    value="{{ old('nama_ruangan') }}"
                    placeholder="Contoh: Lab Komputer 3"
                    class="form-input"
                    required
                >

                @error('nama_ruangan')

                    <div class="form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-actions">

                <a
                    href="{{ route('waka.master-data.ruangan.index') }}"
                    class="btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-primary"
                >
                    Simpan Ruangan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
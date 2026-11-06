@extends('layouts.app')

@section('title', 'Edit Ruangan')

@section('page-title', 'Edit Ruangan')

@section('content')

<div class="master-data-container">

    <div class="master-data-header">
        <div>
            <h2>Edit Ruangan</h2>
            <p>
                Perbarui data ruangan yang sudah tersimpan.
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
            action="{{ route('waka.master-data.ruangan.update', $ruangan->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="nama_ruangan">
                    Nama Ruangan
                </label>

                <input
                    type="text"
                    id="nama_ruangan"
                    name="nama_ruangan"
                    value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
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
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

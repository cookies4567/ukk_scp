@extends('layouts.app')

@section('title', 'Data Kelas')

@section('page-title', 'Data Kelas')

@section('content')

<div class="master-data-container">

    <div class="master-data-header">
        <div>
            <h2>Data Kelas</h2>
            <p>
                Kelola data kelas yang digunakan dalam sistem SCP.
            </p>
        </div>

        <a href="{{ route('waka.master-data.kelas.create') }}" class="btn-primary">
            + Tambah Kelas
        </a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="table-wrapper">

            <table class="data-table">

                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Nama Kelas</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($kelas as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->nama_kelas }}
                            </td>

                            <td>

                                <a
                                    href="{{ route('waka.master-data.kelas.edit', $item->id) }}"
                                    class="btn-edit"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('waka.master-data.kelas.destroy', $item->id) }}"
                                    method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('Yakin ingin menghapus kelas ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn-delete"
                                    >
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="empty-data">
                                Belum ada data kelas.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
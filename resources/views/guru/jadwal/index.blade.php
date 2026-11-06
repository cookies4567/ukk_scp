@extends('layouts.app')

@section('title', 'Jadwal Mengajar')
@section('page-title', 'Jadwal Mengajar')

@section('content')

<div class="card">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:15px;
        flex-wrap:wrap;
    ">

        <div>
            <h3 class="card-title" style="margin-bottom:5px;">
                Jadwal Mengajar
            </h3>

            <p class="card-text">
                Daftar jadwal mengajar Anda.
            </p>
        </div>


        {{-- Tombol tambah hanya muncul jika jadwal terbuka --}}
        @if (!$konfigurasi || !$konfigurasi->jadwal_dikunci)

            <a
                href="{{ route('guru.jadwal.create') }}"
                style="
                    display:inline-flex;
                    align-items:center;
                    gap:6px;
                    padding:9px 14px;
                    background:#198754;
                    color:white;
                    text-decoration:none;
                    border-radius:6px;
                    font-size:13px;
                    font-weight:500;
                "
            >
                <span style="font-size:16px;line-height:1;">
                    +
                </span>

                Tambah Jadwal
            </a>

        @endif

    </div>


    {{-- Pesan hasil simpan / ubah / hapus jadwal --}}
    @if (session('success'))
        <div style="
            margin-top:20px;
            padding:12px 15px;
            background:#edf8f1;
            border:1px solid #ccebd7;
            color:#24643b;
            border-radius:6px;
            font-size:13px;
        ">
            {{ session('success') }}
        </div>
    @endif

    @if (session('warning'))
        <div style="
            margin-top:20px;
            padding:12px 15px;
            background:#fff7ed;
            border:1px solid #fed7aa;
            color:#9a3412;
            border-radius:6px;
            font-size:13px;
        ">
            {{ session('warning') }}
        </div>
    @endif


    {{-- Informasi ketika jadwal terkunci --}}
    @if ($konfigurasi && $konfigurasi->jadwal_dikunci)

        <div style="
            margin-top:20px;
            padding:12px 15px;
            background:#fff7ed;
            border:1px solid #fed7aa;
            color:#9a3412;
            border-radius:6px;
            font-size:13px;
        ">
            🔒 Jadwal sedang dikunci oleh Waka Kurikulum.
            Penambahan, perubahan, dan penghapusan jadwal tidak dapat dilakukan.
        </div>

    @endif


    @if ($jadwal->count() > 0)

        <div style="
            margin-top:20px;
            overflow-x:auto;
        ">

            <table style="
                width:100%;
                border-collapse:collapse;
                font-size:13px;
            ">

                <thead>

                    <tr style="
                        border-bottom:1px solid #d1d5db;
                        text-align:left;
                    ">

                        <th style="padding:12px 10px;">
                            No
                        </th>

                        <th style="padding:12px 10px;">
                            Hari
                        </th>

                        <th style="padding:12px 10px;">
                            Jam
                        </th>

                        <th style="padding:12px 10px;">
                            Mata Pelajaran
                        </th>

                        <th style="padding:12px 10px;">
                            Kelas
                        </th>

                        <th style="padding:12px 10px;">
                            Ruangan
                        </th>

                        <th style="padding:12px 10px;">
                            Siklus
                        </th>

                        {{-- Kolom aksi hanya muncul jika terbuka --}}
                        @if (!$konfigurasi || !$konfigurasi->jadwal_dikunci)

                            <th style="padding:12px 10px;">
                                Aksi
                            </th>

                        @endif

                    </tr>

                </thead>


                <tbody>

                    @foreach ($jadwal as $item)

                        <tr style="
                            border-bottom:1px solid #e5e7eb;
                        ">

                            <td style="padding:12px 10px;">
                                {{ $loop->iteration }}
                            </td>

                            <td style="padding:12px 10px;">
                                {{ $item->hari }}
                            </td>

                            <td style="
                                padding:12px 10px;
                                white-space:nowrap;
                            ">
                                {{ substr($item->jam_mulai, 0, 5) }}
                                -
                                {{ substr($item->jam_selesai, 0, 5) }}
                            </td>

                            <td style="padding:12px 10px;">
                                {{ $item->mata_pelajaran }}
                            </td>

                            <td style="padding:12px 10px;">
                                {{ $item->kelas->nama_kelas }}
                            </td>

                            <td style="padding:12px 10px;">
                                {{ $item->ruangan->nama_ruangan }}
                            </td>

                            <td style="padding:12px 10px;">
                                {{ $item->tipe_siklus }}
                            </td>


                            {{-- Tombol Edit dan Hapus hanya muncul jika terbuka --}}
                            @if (!$konfigurasi || !$konfigurasi->jadwal_dikunci)

                                <td style="
                                    padding:12px 10px;
                                    white-space:nowrap;
                                ">

                                    <a
                                        href="{{ route('guru.jadwal.edit', $item->id) }}"
                                        style="
                                            display:inline-block;
                                            padding:6px 10px;
                                            background:#f3f4f6;
                                            color:#374151;
                                            text-decoration:none;
                                            border:1px solid #d1d5db;
                                            border-radius:5px;
                                            font-size:12px;
                                        "
                                    >
                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('guru.jadwal.destroy', $item->id) }}"
                                        method="POST"
                                        style="
                                            display:inline-block;
                                            margin-left:4px;
                                        "
                                        onsubmit="
                                            return confirm(
                                                'Apakah Anda yakin ingin menghapus jadwal ini?'
                                            )
                                        "
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            style="
                                                padding:6px 10px;
                                                background:#fee2e2;
                                                color:#dc2626;
                                                border:1px solid #fecaca;
                                                border-radius:5px;
                                                font-size:12px;
                                                cursor:pointer;
                                            "
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            @endif

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div style="
            margin-top:20px;
            padding:20px;
            background:#f9fafb;
            border:1px solid #e5e7eb;
            border-radius:8px;
        ">

            <div style="
                font-size:14px;
                font-weight:600;
                color:#374151;
                margin-bottom:6px;
            ">
                Belum ada jadwal mengajar
            </div>

            <div style="
                font-size:13px;
                color:#6b7280;
            ">
                Jadwal mengajar Anda belum tersedia.
            </div>

        </div>

    @endif

</div>

@endsection
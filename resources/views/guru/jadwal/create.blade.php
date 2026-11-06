
@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('page-title', 'Tambah Jadwal Mengajar')

@section('content')

<div style="
    max-width: 800px;
    background: white;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
">

    <form action="{{ route('guru.jadwal.store') }}" method="POST">
        @csrf

        {{-- MATA PELAJARAN --}}
        <div style="margin-bottom: 18px;">

            <label for="mata_pelajaran" style="
                display: block;
                margin-bottom: 6px;
                font-size: 13px;
                font-weight: 600;
            ">
                Mata Pelajaran
            </label>

            <select
                id="mata_pelajaran"
                name="mata_pelajaran"
                required
                style="
                    width: 100%;
                    padding: 10px 12px;
                    border: 1px solid #ced4da;
                    border-radius: 6px;
                    font-size: 14px;
                    background: white;
                "
            >
                <option value="">-- Pilih Mata Pelajaran --</option>

                @foreach ($mataPelajaran as $mapel)
                    <option
                        value="{{ $mapel->nama_mata_pelajaran }}"
                        {{ old('mata_pelajaran') == $mapel->nama_mata_pelajaran ? 'selected' : '' }}
                    >
                        {{ $mapel->kode_mata_pelajaran }} - {{ $mapel->nama_mata_pelajaran }}
                    </option>
                @endforeach
            </select>

            @error('mata_pelajaran')
                <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- HARI --}}
        <div style="margin-bottom: 18px;">

            <label for="hari" style="
                display: block;
                margin-bottom: 6px;
                font-size: 13px;
                font-weight: 600;
            ">
                Hari
            </label>

            <select
                id="hari"
                name="hari"
                required
                style="
                    width: 100%;
                    padding: 10px 12px;
                    border: 1px solid #ced4da;
                    border-radius: 6px;
                    font-size: 14px;
                    background: white;
                "
            >
                <option value="">-- Pilih Hari --</option>

                @foreach ([
                    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu'
                ] as $hari)
                    <option
                        value="{{ $hari }}"
                        {{ old('hari') == $hari ? 'selected' : '' }}
                    >
                        {{ $hari }}
                    </option>
                @endforeach
            </select>

            @error('hari')
                <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- JAM PELAJARAN --}}
        <div style="
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 18px;
        ">

            {{-- JAM MULAI --}}
            <div>
                <label for="jam_mulai" style="
                    display: block;
                    margin-bottom: 6px;
                    font-size: 13px;
                    font-weight: 600;
                ">
                    Jam Mulai
                </label>

                <select
                    id="jam_mulai"
                    name="jam_mulai"
                    required
                    style="
                        width: 100%;
                        padding: 10px 12px;
                        border: 1px solid #ced4da;
                        border-radius: 6px;
                        font-size: 14px;
                        background: white;
                    "
                >
                    <option value="">-- Pilih Jam Mulai --</option>

                    @foreach ([
                        '07:15',
                        '07:55',
                        '08:35',
                        '09:30',
                        '10:10',
                        '10:50',
                        '12:30',
                        '13:10',
                        '13:50',
                        '14:30'
                    ] as $jam)
                        <option
                            value="{{ $jam }}"
                            {{ old('jam_mulai') == $jam ? 'selected' : '' }}
                        >
                            {{ $jam }}
                        </option>
                    @endforeach
                </select>

                @error('jam_mulai')
                    <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- JAM SELESAI --}}
            <div>
                <label for="jam_selesai" style="
                    display: block;
                    margin-bottom: 6px;
                    font-size: 13px;
                    font-weight: 600;
                ">
                    Jam Selesai
                </label>

                <select
                    id="jam_selesai"
                    name="jam_selesai"
                    required
                    style="
                        width: 100%;
                        padding: 10px 12px;
                        border: 1px solid #ced4da;
                        border-radius: 6px;
                        font-size: 14px;
                        background: white;
                    "
                >
                    <option value="">-- Pilih Jam Selesai --</option>

                    @foreach ([
                        '07:55',
                        '08:35',
                        '09:15',
                        '10:10',
                        '10:50',
                        '11:30',
                        '13:10',
                        '13:50',
                        '14:30',
                        '15:10'
                    ] as $jam)
                        <option
                            value="{{ $jam }}"
                            {{ old('jam_selesai') == $jam ? 'selected' : '' }}
                        >
                            {{ $jam }}
                        </option>
                    @endforeach
                </select>

                @error('jam_selesai')
                    <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>

        {{-- KELAS --}}
        <div style="margin-bottom: 18px;">

            <label for="kelas_id" style="
                display: block;
                margin-bottom: 6px;
                font-size: 13px;
                font-weight: 600;
            ">
                Kelas
            </label>

            <select
                id="kelas_id"
                name="kelas_id"
                required
                style="
                    width: 100%;
                    padding: 10px 12px;
                    border: 1px solid #ced4da;
                    border-radius: 6px;
                    font-size: 14px;
                    background: white;
                "
            >
                <option value="">-- Pilih Kelas --</option>

                @foreach ($kelas as $item)
                    <option
                        value="{{ $item->id }}"
                        {{ old('kelas_id') == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->nama_kelas }}
                    </option>
                @endforeach
            </select>

            @error('kelas_id')
                <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- RUANGAN --}}
        <div style="margin-bottom: 18px;">

            <label for="ruangan_id" style="
                display: block;
                margin-bottom: 6px;
                font-size: 13px;
                font-weight: 600;
            ">
                Ruangan
            </label>

            <select
                id="ruangan_id"
                name="ruangan_id"
                required
                style="
                    width: 100%;
                    padding: 10px 12px;
                    border: 1px solid #ced4da;
                    border-radius: 6px;
                    font-size: 14px;
                    background: white;
                "
            >
                <option value="">-- Pilih Ruangan --</option>

                @foreach ($ruangan as $item)
                    <option
                        value="{{ $item->id }}"
                        {{ old('ruangan_id') == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->nama_ruangan }}
                    </option>
                @endforeach
            </select>

            @error('ruangan_id')
                <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- SIKLUS --}}
        <div style="margin-bottom: 24px;">

            <label for="tipe_siklus" style="
                display: block;
                margin-bottom: 6px;
                font-size: 13px;
                font-weight: 600;
            ">
                Siklus
            </label>

            <select
                id="tipe_siklus"
                name="tipe_siklus"
                required
                style="
                    width: 100%;
                    padding: 10px 12px;
                    border: 1px solid #ced4da;
                    border-radius: 6px;
                    font-size: 14px;
                    background: white;
                "
            >
                <option value="">-- Pilih Siklus --</option>

                <option
                    value="Putaran 1"
                    {{ old('tipe_siklus', $siklusAktif ?? null) == 'Putaran 1' ? 'selected' : '' }}
                >
                    Putaran 1
                </option>

                <option
                    value="Putaran 2"
                    {{ old('tipe_siklus', $siklusAktif ?? null) == 'Putaran 2' ? 'selected' : '' }}
                >
                    Putaran 2
                </option>
            </select>

            <div style="font-size: 12px; color: #6b7280; margin-top: 5px;">
                Siklus aktif saat ini: <strong>{{ $siklusAktif ?? '-' }}</strong>.
                Jadwal hanya tampil di Dashboard dan Jurnal Mengajar
                bila siklusnya sama dengan siklus aktif.
            </div>

            @error('tipe_siklus')
                <div style="color: #dc3545; font-size: 12px; margin-top: 5px;">
                    {{ $message }}
                </div>
            @enderror

        </div>

        {{-- BUTTON --}}
        <div style="
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        ">

            <a
                href="{{ route('guru.jadwal.index') }}"
                style="
                    display: inline-flex;
                    align-items: center;
                    padding: 9px 14px;
                    background: #6c757d;
                    color: white;
                    text-decoration: none;
                    border-radius: 6px;
                    font-size: 13px;
                "
            >
                Kembali
            </a>

            <button
                type="submit"
                style="
                    padding: 9px 14px;
                    background: #198754;
                    color: white;
                    border: none;
                    border-radius: 6px;
                    font-size: 13px;
                    cursor: pointer;
                "
            >
                Simpan Jadwal
            </button>

        </div>

    </form>

</div>

@endsection

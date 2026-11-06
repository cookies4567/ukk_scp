@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('page-title', 'Edit Jadwal Mengajar')

@section('content')

    <div class="card">

        <div style="margin-bottom: 20px;">
            <h3 class="card-title" style="margin-bottom: 5px;">
                Edit Jadwal Mengajar
            </h3>

            <p class="card-text">
                Ubah informasi jadwal mengajar Anda.
            </p>
        </div>

        @if ($errors->any())
            <div style="
                margin-bottom: 20px;
                padding: 12px 15px;
                background: #fef2f2;
                border: 1px solid #fecaca;
                color: #991b1b;
                border-radius: 6px;
                font-size: 13px;
            ">
                <strong>Terdapat kesalahan:</strong>

                <ul style="margin: 8px 0 0 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div style="
                margin-bottom: 20px;
                padding: 12px 15px;
                background: #fef2f2;
                border: 1px solid #fecaca;
                color: #991b1b;
                border-radius: 6px;
                font-size: 13px;
            ">
                {{ session('error') }}
            </div>
        @endif

        <form
            action="{{ route('guru.jadwal.update', $jadwal->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            {{-- Mata Pelajaran --}}
            <div style="margin-bottom: 16px;">
                <label
                    for="mata_pelajaran"
                    style="
                        display: block;
                        margin-bottom: 6px;
                        font-size: 13px;
                        font-weight: 600;
                        color: #374151;
                    "
                >
                    Mata Pelajaran
                </label>

                <input
                    type="text"
                    id="mata_pelajaran"
                    name="mata_pelajaran"
                    value="{{ old('mata_pelajaran', $jadwal->mata_pelajaran) }}"
                    maxlength="100"
                    required
                    style="
                        width: 100%;
                        padding: 9px 10px;
                        border: 1px solid #d1d5db;
                        border-radius: 6px;
                        font-size: 13px;
                        box-sizing: border-box;
                    "
                >
            </div>

            {{-- Hari --}}
            <div style="margin-bottom: 16px;">
                <label
                    for="hari"
                    style="
                        display: block;
                        margin-bottom: 6px;
                        font-size: 13px;
                        font-weight: 600;
                        color: #374151;
                    "
                >
                    Hari
                </label>

                <select
                    id="hari"
                    name="hari"
                    required
                    style="
                        width: 100%;
                        padding: 9px 10px;
                        border: 1px solid #d1d5db;
                        border-radius: 6px;
                        font-size: 13px;
                        background: white;
                    "
                >
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                        <option
                            value="{{ $hari }}"
                            {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}
                        >
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>
            </div>

            
            
            {{-- Jam Pelajaran --}}
            <div style="
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
                margin-bottom: 16px;
            ">

                {{-- Jam Mulai --}}
                <div>
                    <label for="jam_mulai" style="
                        display: block;
                        margin-bottom: 6px;
                        font-size: 13px;
                        font-weight: 600;
                        color: #374151;
                    ">
                        Jam Mulai
                    </label>

                    <select
                        id="jam_mulai"
                        name="jam_mulai"
                        required
                        style="
                            width: 100%;
                            padding: 9px 10px;
                            border: 1px solid #d1d5db;
                            border-radius: 6px;
                            font-size: 13px;
                            background: white;
                            box-sizing: border-box;
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
                                {{ old('jam_mulai', substr($jadwal->jam_mulai, 0, 5)) == $jam ? 'selected' : '' }}
                            >
                                {{ $jam }}
                            </option>
                        @endforeach
                    </select>

                    @error('jam_mulai')
                        <small style="color:#dc3545;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Jam Selesai --}}
                <div>
                    <label for="jam_selesai" style="
                        display: block;
                        margin-bottom: 6px;
                        font-size: 13px;
                        font-weight: 600;
                        color: #374151;
                    ">
                        Jam Selesai
                    </label>

                    <select
                        id="jam_selesai"
                        name="jam_selesai"
                        required
                        style="
                            width: 100%;
                            padding: 9px 10px;
                            border: 1px solid #d1d5db;
                            border-radius: 6px;
                            font-size: 13px;
                            background: white;
                            box-sizing: border-box;
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
                                {{ old('jam_selesai', substr($jadwal->jam_selesai, 0, 5)) == $jam ? 'selected' : '' }}
                            >
                                {{ $jam }}
                            </option>
                        @endforeach
                    </select>

                    @error('jam_selesai')
                        <small style="color:#dc3545;">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const jamMulai = document.getElementById('jam_mulai');
                const jamSelesai = document.getElementById('jam_selesai');

                const jadwal = {
                    '07:15': '07:55',
                    '07:55': '08:35',
                    '08:35': '09:15',
                    '09:30': '10:10',
                    '10:10': '10:50',
                    '10:50': '11:30',
                    '12:30': '13:10',
                    '13:10': '13:50',
                    '13:50': '14:30',
                    '14:30': '15:10'
                };

                function perbaruiJamSelesai() {
                    const waktuSelesai = jadwal[jamMulai.value];
                    const nilaiLama = jamSelesai.value;

                    jamSelesai.innerHTML =
                        '<option value="">-- Pilih Jam Selesai --</option>';

                    if (!waktuSelesai) {
                        return;
                    }

                    const pilihan = document.createElement('option');
                    pilihan.value = waktuSelesai;
                    pilihan.textContent = waktuSelesai;

                    jamSelesai.appendChild(pilihan);
                    jamSelesai.value = waktuSelesai;
                }

                jamMulai.addEventListener('change', perbaruiJamSelesai);
            });
            </script>


            {{-- Kelas --}}
            <div style="margin-bottom: 16px;">
                <label
                    for="kelas_id"
                    style="
                        display: block;
                        margin-bottom: 6px;
                        font-size: 13px;
                        font-weight: 600;
                        color: #374151;
                    "
                >
                    Kelas
                </label>

                <select
                    id="kelas_id"
                    name="kelas_id"
                    required
                    style="
                        width: 100%;
                        padding: 9px 10px;
                        border: 1px solid #d1d5db;
                        border-radius: 6px;
                        font-size: 13px;
                        background: white;
                    "
                >
                    @foreach ($kelas as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ old('kelas_id', $jadwal->kelas_id) == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ruangan --}}
            <div style="margin-bottom: 16px;">
                <label
                    for="ruangan_id"
                    style="
                        display: block;
                        margin-bottom: 6px;
                        font-size: 13px;
                        font-weight: 600;
                        color: #374151;
                    "
                >
                    Ruangan
                </label>

                <select
                    id="ruangan_id"
                    name="ruangan_id"
                    required
                    style="
                        width: 100%;
                        padding: 9px 10px;
                        border: 1px solid #d1d5db;
                        border-radius: 6px;
                        font-size: 13px;
                        background: white;
                    "
                >
                    @foreach ($ruangan as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ old('ruangan_id', $jadwal->ruangan_id) == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Siklus --}}
            <div style="margin-bottom: 20px;">
                <label
                    for="tipe_siklus"
                    style="
                        display: block;
                        margin-bottom: 6px;
                        font-size: 13px;
                        font-weight: 600;
                        color: #374151;
                    "
                >
                    Tipe Siklus
                </label>

                <select
                    id="tipe_siklus"
                    name="tipe_siklus"
                    required
                    style="
                        width: 100%;
                        padding: 9px 10px;
                        border: 1px solid #d1d5db;
                        border-radius: 6px;
                        font-size: 13px;
                        background: white;
                    "
                >
                    <option
                        value="Putaran 1"
                        {{ old('tipe_siklus', $jadwal->tipe_siklus) == 'Putaran 1' ? 'selected' : '' }}
                    >
                        Putaran 1
                    </option>

                    <option
                        value="Putaran 2"
                        {{ old('tipe_siklus', $jadwal->tipe_siklus) == 'Putaran 2' ? 'selected' : '' }}
                    >
                        Putaran 2
                    </option>
                </select>
            </div>

            {{-- Tombol --}}
            <div
                style="
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                "
            >
                <a
                    href="{{ route('guru.jadwal.index') }}"
                    style="
                        display: inline-flex;
                        align-items: center;
                        padding: 9px 14px;
                        background: #f3f4f6;
                        color: #374151;
                        text-decoration: none;
                        border: 1px solid #d1d5db;
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
                        font-weight: 500;
                        cursor: pointer;
                    "
                >
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

@endsection
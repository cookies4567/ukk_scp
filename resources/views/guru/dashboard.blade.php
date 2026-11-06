@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('page-title', 'Dashboard Guru')

@section('content')

    {{-- Welcome Card --}}
    <div class="card">

        <h3 class="card-title">
            Selamat datang, {{ $guru->nama_lengkap }}
        </h3>

        <p class="card-text">
            Berikut informasi jadwal mengajar Anda hari ini.
        </p>

    </div>

    
{{-- Peringatan Jurnal Mengajar --}}
    @include('partials.peringatan-jurnal-live')

    {{-- Jadwal Hari Ini --}}
    <div class="card" style="margin-top: 20px;">

        <div style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        ">

            <div>
                <h3 class="card-title" style="margin-bottom: 5px;">
                    Jadwal Mengajar Hari Ini
                </h3>

                <p class="card-text">
                    {{ $hariIni }}
                </p>
            </div>

            <div style="
                padding: 6px 12px;
                background: #f3f4f6;
                border-radius: 6px;
                font-size: 12px;
                color: #4b5563;
            ">
                {{ $siklusAktif }}
            </div>

        </div>


        @if ($jadwalHariIni->count() > 0)

            <div style="margin-top: 20px;">

                @foreach ($jadwalHariIni as $jadwal)

                    <div style="
                        padding: 16px 0;
                        border-bottom: 1px solid #e5e7eb;
                    ">

                        <div style="
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-start;
                            gap: 20px;
                        ">

                            {{-- Informasi Jadwal --}}
                            <div>

                                <div style="
                                    font-size: 15px;
                                    font-weight: 600;
                                    color: #111827;
                                ">
                                    {{ $jadwal->mata_pelajaran }}
                                </div>

                                <div style="
                                    margin-top: 6px;
                                    font-size: 13px;
                                    color: #6b7280;
                                ">
                                    {{ $jadwal->kelas?->nama_kelas ?? '-' }}
                                    ·
                                    {{ $jadwal->ruangan?->nama_ruangan ?? '-' }}
                                </div>

                            </div>


                            {{-- Jam + status jurnal --}}
                            <div style="text-align: right;">
                                <div style="
                                    padding: 6px 10px;
                                    background: #f9fafb;
                                    border-radius: 6px;
                                    font-size: 13px;
                                    color: #374151;
                                    white-space: nowrap;
                                    display: inline-block;
                                ">
                                    {{ substr($jadwal->jam_mulai, 0, 5) }}
                                    -
                                    {{ substr($jadwal->jam_selesai, 0, 5) }}
                                </div>

                                @php
                                    $warna = match ($jadwal->status_jurnal) {
                                        'Sudah Diisi' => ['#edf8f1', '#267344'],
                                        'Terlambat'   => ['#fce7e7', '#b42323'],
                                        'Belum Diisi' => ['#fff5e8', '#9a5b00'],
                                        default       => ['#f3f4f6', '#6b7280'],
                                    };
                                @endphp

                                <div style="margin-top: 8px;">
                                    <span style="
                                        display: inline-block;
                                        padding: 4px 9px;
                                        border-radius: 6px;
                                        font-size: 12px;
                                        font-weight: 600;
                                        background: {{ $warna[0] }};
                                        color: {{ $warna[1] }};
                                    ">
                                        Jurnal: {{ $jadwal->status_jurnal }}
                                    </span>
                                </div>

                                <div style="margin-top: 8px;">
                                    @if ($jadwal->jurnal_hari_ini)
                                        <a href="{{ route('guru.jurnal.edit', [
                                                'jadwal' => $jadwal->id,
                                                'jurnal' => $jadwal->jurnal_hari_ini->id,
                                            ]) }}"
                                           style="font-size: 12px; font-weight: 600; color: #1f3a5f; text-decoration: none;">
                                            Edit Jurnal
                                        </a>
                                    @else
                                        <a href="{{ route('guru.jurnal.create', $jadwal->id) }}"
                                           style="font-size: 12px; font-weight: 600; color: #1f3a5f; text-decoration: none;">
                                            Isi Jurnal
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            {{-- Jika Tidak Ada Jadwal --}}
            <div style="
                margin-top: 20px;
                padding: 18px;
                background: #f9fafb;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                color: #6b7280;
                font-size: 13px;
            ">

                <div style="
                    font-weight: 600;
                    color: #374151;
                    margin-bottom: 5px;
                ">
                    Tidak ada jadwal hari ini
                </div>

                <div>
                    Belum terdapat jadwal mengajar untuk hari {{ $hariIni }}.
                </div>

            </div>

        @endif

    </div>


@endsection

@extends('layouts.app')

@section('page-title', 'Monitoring Presensi')

@section('content')

<div style="max-width: 1200px; margin: 0 auto;">

    {{-- HEADER --}}
    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 700; color: #1f2937; margin: 0 0 8px;">
            Monitoring Presensi Siswa
        </h2>

        <p style="font-size: 14px; color: #6b7280; margin: 0;">
            Pantau data kehadiran siswa berdasarkan jurnal mengajar guru.
        </p>
    </div>

    {{-- PESAN --}}
    @if (session('success'))
        <div style="padding: 12px 16px; margin-bottom: 18px; border-radius: 8px; background: #dcfce7; color: #166534;">
            {{ session('success') }}
        </div>
    @endif

    {{-- RINGKASAN --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 16px; margin-bottom: 24px;">

        <div style="background: #fff; border: 1px solid #e5e7eb; border-left: 4px solid #eab308; border-radius: 10px; padding: 18px;">
            <div style="font-size: 13px; color: #6b7280;">Sakit</div>
            <div style="font-size: 28px; font-weight: 700; color: #ca8a04; margin-top: 6px;">
                {{ $jumlahSakit }}
            </div>
            <div style="font-size: 12px; color: #9ca3af;">Jumlah siswa sakit</div>
        </div>

        <div style="background: #fff; border: 1px solid #e5e7eb; border-left: 4px solid #2563eb; border-radius: 10px; padding: 18px;">
            <div style="font-size: 13px; color: #6b7280;">Izin</div>
            <div style="font-size: 28px; font-weight: 700; color: #2563eb; margin-top: 6px;">
                {{ $jumlahIzin }}
            </div>
            <div style="font-size: 12px; color: #9ca3af;">Jumlah siswa izin</div>
        </div>

        <div style="background: #fff; border: 1px solid #e5e7eb; border-left: 4px solid #dc2626; border-radius: 10px; padding: 18px;">
            <div style="font-size: 13px; color: #6b7280;">Alpa</div>
            <div style="font-size: 28px; font-weight: 700; color: #dc2626; margin-top: 6px;">
                {{ $jumlahAlpa }}
            </div>
            <div style="font-size: 12px; color: #9ca3af;">Jumlah siswa tanpa keterangan</div>
        </div>

    </div>

    {{-- FILTER --}}
    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 20px;">

        <h3 style="font-size: 16px; font-weight: 700; color: #1f2937; margin: 0 0 16px;">
            Filter Presensi
        </h3>

        <form method="GET" action="{{ route('bk.monitoring-presensi') }}">

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px;">

                <div>
                    <label for="tanggal" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 7px;">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        value="{{ request('tanggal') }}"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 7px; box-sizing: border-box;"
                    >
                </div>

                <div>
                    <label for="kelas_id" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 7px;">
                        Kelas
                    </label>

                    <select
                        id="kelas_id"
                        name="kelas_id"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 7px; box-sizing: border-box;"
                    >
                        <option value="">Semua Kelas</option>

                        @foreach ($kelas as $itemKelas)
                            <option
                                value="{{ $itemKelas->id }}"
                                {{ request('kelas_id') == $itemKelas->id ? 'selected' : '' }}
                            >
                                {{ $itemKelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 7px;">
                        Status Kehadiran
                    </label>

                    <select
                        id="status"
                        name="status"
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 7px; box-sizing: border-box;"
                    >
                        <option value="">Semua Status</option>
                        <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Alpa" {{ request('status') == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                    </select>
                </div>

            </div>

            <div style="display: flex; gap: 10px; margin-top: 16px; flex-wrap: wrap;">

                <button
                    type="submit"
                    style="padding: 10px 18px; background: #2563eb; color: #fff; border: none; border-radius: 7px; cursor: pointer; font-size: 13px; font-weight: 600;"
                >
                    Terapkan Filter
                </button>

                <a
                    href="{{ route('bk.monitoring-presensi') }}"
                    style="padding: 10px 18px; background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; border-radius: 7px; text-decoration: none; font-size: 13px;"
                >
                    Reset
                </a>

            </div>

        </form>
    </div>

    {{-- TABEL PRESENSI --}}
    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">

        <div style="padding: 18px 20px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: 16px; font-weight: 700; margin: 0; color: #1f2937;">
                Daftar Monitoring Presensi
            </h3>

            <p style="font-size: 13px; color: #6b7280; margin: 5px 0 0;">
                Data siswa dengan status sakit, izin, dan alpa.
            </p>
        </div>

        @if ($presensi->isEmpty())

            <div style="padding: 48px 20px; text-align: center;">
                <div style="font-size: 32px; margin-bottom: 12px;">📋</div>

                <h3 style="font-size: 16px; color: #374151; margin: 0 0 6px;">
                    Belum ada data presensi
                </h3>

                <p style="font-size: 13px; color: #6b7280; margin: 0;">
                    Data presensi sakit, izin, atau alpa akan muncul setelah guru menyimpan jurnal mengajar.
                </p>
            </div>

        @else

            <div style="overflow-x: auto;">

                <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">

                    <thead>
                        <tr style="background: #f9fafb; color: #6b7280;">

                            <th style="padding: 13px 16px; white-space: nowrap;">No.</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Nama Siswa</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">NIS</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Kelas</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Tanggal</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Mata Pelajaran</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Guru</th>
                            <th style="padding: 13px 16px; white-space: nowrap;">Status</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($presensi as $index => $item)

                            <tr style="border-top: 1px solid #e5e7eb; color: #374151;">

                                <td style="padding: 15px 16px;">
                                    {{ $index + 1 }}
                                </td>

                                <td style="padding: 15px 16px; font-weight: 600;">
                                    {{ $item->siswa->nama_lengkap ?? 'Nama tidak tersedia' }}
                                </td>

                                <td style="padding: 15px 16px;">
                                    {{ $item->siswa->nis ?? '-' }}
                                </td>

                                <td style="padding: 15px 16px; white-space: nowrap;">
                                    {{ $item->siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}
                                </td>

                                <td style="padding: 15px 16px; white-space: nowrap;">
                                    {{ $item->tanggal }}
                                </td>

                                <td style="padding: 15px 16px;">
                                    {{ $item->jurnal->jadwal->mata_pelajaran ?? '-' }}
                                </td>

                                <td style="padding: 15px 16px;">
                                    {{ $item->jurnal->jadwal->guru->nama_lengkap ?? '-' }}
                                </td>

                                <td style="padding: 15px 16px;">

                                    @if ($item->status === 'Sakit')
                                        <span style="display: inline-block; padding: 5px 10px; background: #fef9c3; color: #854d0e; border-radius: 20px; font-weight: 600;">
                                            Sakit
                                        </span>

                                    @elseif ($item->status === 'Izin')
                                        <span style="display: inline-block; padding: 5px 10px; background: #dbeafe; color: #1d4ed8; border-radius: 20px; font-weight: 600;">
                                            Izin
                                        </span>

                                    @elseif ($item->status === 'Alpa')
                                        <span style="display: inline-block; padding: 5px 10px; background: #fee2e2; color: #b91c1c; border-radius: 20px; font-weight: 600;">
                                            Alpa
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>

@endsection

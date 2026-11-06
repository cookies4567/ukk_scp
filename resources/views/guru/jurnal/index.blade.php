@extends('layouts.app')

@section('title', 'Jurnal Mengajar')
@section('page-title', 'Jurnal Mengajar')

@section('content')

<style>
    .jurnal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .jurnal-header h2 {
        margin: 0 0 6px;
        font-size: 22px;
        color: #172033;
    }

    .jurnal-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .siklus-badge {
        padding: 8px 14px;
        border-radius: 8px;
        background: #eef3f8;
        color: #26384d;
        font-size: 13px;
        font-weight: 600;
    }

    .alert-success {
        background: #edf8f1;
        border: 1px solid #ccebd7;
        color: #24643b;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .jurnal-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .jurnal-item {
        background: #ffffff;
        border: 1px solid #e1e5ea;
        border-radius: 10px;
        padding: 20px;
    }

    .jurnal-item-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
    }

    .jurnal-mapel {
        font-size: 17px;
        font-weight: 700;
        color: #172033;
        margin-bottom: 10px;
    }

    .jurnal-info {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        color: #606b7a;
        font-size: 13px;
    }

    .jurnal-info span {
        display: inline-flex;
        align-items: center;
    }

    .status {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-belum {
        background: #fff5e8;
        color: #9a5b00;
    }

    .status-sudah {
        background: #edf8f1;
        color: #267344;
    }

    .status-terlambat {
        background: #fce7e7;
        color: #b42323;
    }

    .status-menunggu {
        background: #f3f4f6;
        color: #6b7280;
    }

    .badge-hari-ini {
        display: inline-block;
        margin-left: 8px;
        padding: 2px 8px;
        border-radius: 20px;
        background: #e6edf5;
        color: #1f3a5f;
        font-size: 11px;
        font-weight: 700;
        vertical-align: middle;
    }

    .jurnal-item.is-today {
        border-color: #9db6d3;
        box-shadow: 0 0 0 2px #e6edf5;
    }

    .btn-jurnal-outline {
        background: #ffffff;
        color: #1f3a5f;
        border: 1px solid #1f3a5f;
    }

    .btn-jurnal-outline:hover {
        background: #eef3f8;
    }

    .jurnal-aksi {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .jurnal-bottom {
        margin-top: 18px;
        padding-top: 15px;
        border-top: 1px solid #edf0f3;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .jurnal-terakhir {
        color: #6b7280;
        font-size: 13px;
    }

    .btn-jurnal {
        display: inline-block;
        padding: 9px 15px;
        border-radius: 7px;
        background: #1f3a5f;
        color: white;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-jurnal:hover {
        background: #172f4d;
    }

    .empty-state {
        background: #ffffff;
        border: 1px solid #e1e5ea;
        border-radius: 10px;
        padding: 45px 20px;
        text-align: center;
        color: #6b7280;
    }

    .empty-state strong {
        display: block;
        color: #374151;
        font-size: 16px;
        margin-bottom: 7px;
    }
</style>


<div class="jurnal-header">

    <div>
        <h2>Jurnal Mengajar</h2>

        <p>
            Isi jurnal pembelajaran berdasarkan jadwal mengajar Anda.
        </p>
    </div>

    <div class="siklus-badge">
        {{ $siklusAktif }}
    </div>

</div>


{{-- Peringatan jurnal hari ini --}}
@include('partials.peringatan-jurnal-live')

@if(session('success'))

    <div class="alert-success">
        {{ session('success') }}
    </div>

@endif

@if(session('error'))

    <div style="
        background:#fff3f3;
        border:1px solid #f0caca;
        color:#9b2c2c;
        padding:12px 15px;
        border-radius:8px;
        margin-bottom:20px;
        font-size:14px;
    ">
        {{ session('error') }}
    </div>

@endif


@if($jadwal->count() > 0)

    <div class="jurnal-list">

        @foreach($jadwal as $item)

            @php
                $jurnalTerakhir = $item->jurnal_terakhir;
            @endphp

            <div class="jurnal-item {{ $item->adalah_hari_ini ? 'is-today' : '' }}">

                <div class="jurnal-item-top">

                    <div>

                        <div class="jurnal-mapel">
                            {{ $item->mata_pelajaran }}

                            @if($item->adalah_hari_ini)
                                <span class="badge-hari-ini">Hari ini</span>
                            @endif
                        </div>

                        <div class="jurnal-info">

                            <span>
                                {{ $item->hari }}
                            </span>

                            <span>
                                {{ substr($item->jam_mulai, 0, 5) }}
                                -
                                {{ substr($item->jam_selesai, 0, 5) }}
                            </span>

                            <span>
                                {{ $item->kelas?->nama_kelas ?? '-' }}
                            </span>

                            <span>
                                {{ $item->ruangan?->nama_ruangan ?? '-' }}
                            </span>

                        </div>

                    </div>


                    @if($item->adalah_hari_ini)

                        @php
                            $kelasStatus = match ($item->status_jurnal) {
                                'Sudah Diisi' => 'status-sudah',
                                'Terlambat'   => 'status-terlambat',
                                'Belum Diisi' => 'status-belum',
                                default       => 'status-menunggu',
                            };
                        @endphp

                        <div class="status {{ $kelasStatus }}">
                            {{ $item->status_jurnal }}
                        </div>

                    @endif

                </div>


                <div class="jurnal-bottom">

                    <div class="jurnal-terakhir">

                        @if($item->jurnal_hari_ini)

                            Jurnal hari ini sudah diisi
                            ({{ \Carbon\Carbon::parse($item->jurnal_hari_ini->tanggal)->format('d/m/Y') }}).

                        @elseif($jurnalTerakhir)

                            Jurnal terakhir:
                            {{ \Carbon\Carbon::parse($jurnalTerakhir->tanggal)->format('d/m/Y') }}

                        @else

                            Belum ada jurnal yang diinput.

                        @endif

                    </div>


                    <div class="jurnal-aksi">

                        @if($item->jurnal_hari_ini)

                            <a
                                href="{{ route('guru.jurnal.edit', [
                                    'jadwal' => $item->id,
                                    'jurnal' => $item->jurnal_hari_ini->id
                                ]) }}"
                                class="btn-jurnal"
                            >
                                Edit Jurnal Hari Ini
                            </a>

                        @else

                            @if($jurnalTerakhir)
                                <a
                                    href="{{ route('guru.jurnal.edit', [
                                        'jadwal' => $item->id,
                                        'jurnal' => $jurnalTerakhir->id
                                    ]) }}"
                                    class="btn-jurnal btn-jurnal-outline"
                                >
                                    Edit Jurnal Terakhir
                                </a>
                            @endif

                            <a
                                href="{{ route('guru.jurnal.create', $item->id) }}"
                                class="btn-jurnal"
                            >
                                Isi Jurnal
                            </a>

                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="empty-state">

        <strong>Belum ada jadwal mengajar</strong>

        Tidak terdapat jadwal mengajar Anda pada
        {{ $siklusAktif }}.

    </div>

@endif

@endsection
{{-- Kartu peringatan jurnal mengajar (Guru & Wali Kelas) --}}
{{-- Variabel: $peringatanJurnal (koleksi jadwal dengan ->status_jurnal) --}}
@if ($peringatanJurnal->isNotEmpty())
    @php
        $jumlahTerlambat = $peringatanJurnal->where('status_jurnal', 'Terlambat')->count();
    @endphp

    <div class="card" style="
        margin-top: 20px;
        border: 1px solid #dc9999;
        background: #fffafa;
    ">

        <div style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        ">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="
                    width: 44px;
                    height: 44px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 8px;
                    background: #fce7e7;
                    color: #b42323;
                    font-size: 20px;
                ">
                    <i class="bi bi-journal-text"></i>
                </div>

                <div>
                    <h3 class="card-title" style="margin: 0;">
                        Peringatan Jurnal Mengajar
                    </h3>

                    <p class="card-text" style="margin-top: 4px;">
                        Terdapat {{ $peringatanJurnal->count() }}
                        jurnal hari ini yang belum diisi
                        @if ($jumlahTerlambat > 0)
                            ({{ $jumlahTerlambat }} sudah terlambat).
                        @else
                            .
                        @endif
                    </p>
                </div>
            </div>

            <span style="
                padding: 6px 12px;
                border-radius: 20px;
                background: #a92d37;
                color: white;
                font-size: 12px;
                font-weight: 600;
            ">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ $peringatanJurnal->count() }} Belum Diisi
            </span>
        </div>

        <p class="card-text" style="margin-top: 15px;">
            Lengkapi jurnal mengajar dan presensi siswa. Peringatan muncul
            30 menit sebelum jam pelajaran selesai dan hilang otomatis
            setelah jurnal diisi.
        </p>

        @foreach ($peringatanJurnal as $jadwal)
            @php $terlambat = $jadwal->status_jurnal === 'Terlambat'; @endphp

            <div style="
                margin-top: 12px;
                padding: 12px;
                background: white;
                border: 1px solid #eadada;
                border-radius: 8px;
            ">
                <div style="font-weight: 600; color: #374151;">
                    {{ $jadwal->mata_pelajaran }}
                    - {{ $jadwal->kelas?->nama_kelas ?? '-' }}
                </div>

                <div style="margin-top: 5px; font-size: 13px; color: #6b7280;">
                    Jam {{ substr($jadwal->jam_mulai, 0, 5) }}
                    - {{ substr($jadwal->jam_selesai, 0, 5) }}
                    @if ($jadwal->ruangan)
                        · {{ $jadwal->ruangan->nama_ruangan }}
                    @endif
                </div>

                <div style="
                    margin-top: 5px;
                    font-size: 12px;
                    font-weight: 600;
                    color: {{ $terlambat ? '#b42323' : '#9a5b00' }};
                ">
                    {{ $jadwal->status_jurnal }}
                </div>

                <a href="{{ route('guru.jurnal.create', $jadwal->id) }}"
                   class="btn btn-danger"
                   style="
                       display: inline-block;
                       margin-top: 10px;
                       padding: 9px 15px;
                       text-decoration: none;
                   ">
                    <i class="bi bi-pencil-square"></i>
                    Isi Jurnal Sekarang
                </a>
            </div>
        @endforeach
    </div>
@endif

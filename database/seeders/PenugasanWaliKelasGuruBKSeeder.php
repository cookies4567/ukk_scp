<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class PenugasanWaliKelasGuruBKSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['X AK1', 'ERIDHA DEWI SEPITASARI, S.Pd.', 'CANDRA RAHADIAN, S.Pd'],
            ['X AK 2', 'SULARDI, S.Pd', 'CANDRA RAHADIAN, S.Pd'],
            ['X AK 3', 'RISA RESTI AFRIANI, S. Pd.', 'CANDRA RAHADIAN, S.Pd'],
            ['X LPS1', 'SRI NUR ARAFAH, S.Pd', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['X LPS2', 'MUHAMMAD FURQON, S.Sos', 'RYAWIDYANINGTYAS, S.Pd.'],
            ['X MP 1', 'MENIK LESTARI, S.PD', 'AISYAH WULANDARI, S.Pd'],
            ['X MP 2', 'TENTREM YUNIATI LESTARI, S.Pd', 'AISYAH WULANDARI, S.Pd'],
            ['X BR 1', 'TATIK HERAWATI, S.Pd', 'ALIVI SAZKIA HAWIE, S.Pd'],
            ['X BR 2', 'AGATHA CHRISTIYANTI MANULLANG, SS', 'ALIVI SAZKIA HAWIE, S.Pd'],
            ['X BD', 'AHMAD MUHLASHIN, S.Pd.', 'ALIVI SAZKIA HAWIE, S.Pd'],
            ['X TKJ 1', 'TRI SUSILAWATI, S.T., M.Pd.', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['X TKJ 2', 'ANASTASIA RATNA SULISTIYANI, S.Pd', 'CANDRA RAHADIAN, S.Pd'],
            ['X DKV 1', 'YULI ARBIATININGSIH, S.Pd', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['X DKV  2', 'YULI ASTUTI, S.Pd.', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['X RPL 1', 'RUSDIYANTO, S.Pd', 'RYAWIDYANINGTYAS, S.Pd.'],
            ['X RPL 2', 'SURATIMAH, S. Pd. I', 'RYAWIDYANINGTYAS, S.Pd.'],
            ['XI  AK1', 'MARGIYATI, S.Pd., M.Pd.', 'AISYAH WULANDARI, S.Pd'],
            ['XI  AK2', 'YANU ISWANTARA, S.Pd.Kor.', 'AISYAH WULANDARI, S.Pd'],
            ['XI  AK3', 'AJENG FITRI SARASWATI, S.Pd.', 'CANDRA RAHADIAN, S.Pd'],
            ['XI LPS1', 'DIAN AWALIATI, S.Pd.,M.Pd.', 'AISYAH WULANDARI, S.Pd'],
            ['XI LPS2', 'NOVIA RAHMALINA, S.Pd', 'CANDRA RAHADIAN, S.Pd'],
            ['XI  MP1', 'HERMI CAHYAWATI, S.Pd. M.S.I', 'AISYAH WULANDARI, S.Pd'],
            ['XI  MP2', 'UMI KUNTARI, SS.,M.Pd.', 'AISYAH WULANDARI, S.Pd'],
            ['XI  BR 1', 'WAHYUNI, S.Pd.', 'ALIVI SAZKIA HAWIE, S.Pd'],
            ['XI  BR 2', 'SRI SUNARTINI, S.Pd', 'ALIVI SAZKIA HAWIE, S.Pd'],
            ['XI  BD', 'AGNES ENDANG MUDJI RAHAYU, S.Pd., M.Pd.', 'ALIVI SAZKIA HAWIE, S.Pd'],
            ['XI  TKJ1', 'AMAT SUKARDI, S.Pd.', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['XI TKJ2', 'MURDIASIH KADARWATI, S.Pd', 'CANDRA RAHADIAN, S.Pd'],
            ['XI  DKV 1', 'EVA YUNI ASTUTI, S.Pd', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['XI  DKV 2', 'JUNIA SARI, S. Pd.', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['XI  RPL1', 'RENY MURNI HIDAYATI, S.Pd.', 'RYAWIDYANINGTYAS, S.Pd.'],
            ['XI  RPL2', 'SUJAR HARTONO, S.Pd.', 'RYAWIDYANINGTYAS, S.Pd.'],
            ['XII  AK1', 'SRI WIDAYATI, S.Pd., M.Pd.', 'RYAWIDYANINGTYAS, S.Pd.'],
            ['XII  AK2', 'ISTI FITRIANA, S.Pd', 'RYAWIDYANINGTYAS, S.Pd.'],
            ['XII  AK3', 'RINI BHINTARTI, S.Pd', 'AISYAH WULANDARI, S.Pd'],
            ['XII  AK4', 'LAUHIN ILMI AGUSTIN, S.Pd.', 'CANDRA RAHADIAN, S.Pd'],
            ['XII  LPS', 'RIRIH DAMAYANTI WISNU GIYONO, S.E., M.Acc.', 'CANDRA RAHADIAN, S.Pd'],
            ['XII MP 1', 'FAILLA ROCHMAYANTI, S.Pd., M.Pd.', 'AISYAH WULANDARI, S.Pd'],
            ['XII MP 2', 'NINDA APRILIA, S.Pd.', 'AISYAH WULANDARI, S.Pd'],
            ['XII  BR 1', 'SRI SUNARSIH, S.Pd.', 'ALIVI SAZKIA HAWIE, S.Pd'],
            ['XII  BR 2', 'RADEN RARA BERNADETA SRI WIDYASTUTI, S.Pd.', 'ALIVI SAZKIA HAWIE, S.Pd'],
            ['XII  BD', 'PUTRI WULANJARI, S. Pd.', 'ALIVI SAZKIA HAWIE, S.Pd'],
            ['XII  TKJ1', 'KURNIA SAFITRI, S.Pd.', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['XII  TKJ2', 'YULITA EKAWINAJENG, S.Pd.', 'CANDRA RAHADIAN, S.Pd'],
            ['XII  DKV1', 'DWI LESMIYATI, S.Pd', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['XII  DKV2', 'TITI SARI, S.Kom.', 'NURHIDAYAT SULISTIAWAN, S.Pd'],
            ['XII  RPL1', 'DIAH UTAMININGSIH, S.T', 'RYAWIDYANINGTYAS, S.Pd.'],
            ['XII  RPL2', 'ROSYIDA RAMADHANI, S.Pd', 'RYAWIDYANINGTYAS, S.Pd.']
        ];

        DB::transaction(function () use ($data) {
            $kelasMap = DB::table('kelas')->get()->keyBy(
                fn ($kelas) => $this->normalisasi($kelas->nama_kelas)
            );

            $guruBKMap = [];

            foreach ($data as [$namaKelasExcel, $namaWali, $namaBK]) {
                $keyKelas = $this->normalisasi($namaKelasExcel);
                $kelas = $kelasMap->get($keyKelas);

                if (!$kelas) {
                    throw new RuntimeException("Kelas '{$namaKelasExcel}' dari Excel tidak ditemukan di tabel kelas. Tidak ada perubahan yang disimpan.");
                }

                $wali = $this->cariAtauBuatAkun($namaWali, 3);
                DB::table('pengguna')->where('id', $wali->id)->update([
                    'kelas_id' => $kelas->id,
                ]);

                if (!isset($guruBKMap[$namaBK])) {
                    $guruBKMap[$namaBK] = $this->cariAtauBuatAkun($namaBK, 4);
                }

                DB::table('guru_bk_kelas')->updateOrInsert(
                    [
                        'guru_bk_id' => $guruBKMap[$namaBK]->id,
                        'kelas_id' => $kelas->id,
                    ],
                    []
                );
            }
        });
    }

    private function cariAtauBuatAkun(string $nama, int $peranId): object
    {
        $akun = DB::table('pengguna')
            ->where('peran_id', $peranId)
            ->whereRaw('LOWER(TRIM(nama_lengkap)) = ?', [mb_strtolower(trim($nama))])
            ->first();

        if ($akun) {
            return $akun;
        }

        // Username dibuat dari nama sebelum gelar setelah tanda koma.
        $namaDasar = trim(explode(',', $nama)[0]);
        $usernameDasar = Str::slug($namaDasar, '.');
        $username = mb_substr($usernameDasar, 0, 50);
        $nomor = 1;

        while (DB::table('pengguna')->where('username', $username)->exists()) {
            $akhiran = '.' . $nomor++;
            $username = mb_substr($usernameDasar, 0, 50 - strlen($akhiran)) . $akhiran;
        }

        $id = DB::table('pengguna')->insertGetId([
            'peran_id' => $peranId,
            'username' => $username,
            'nama_lengkap' => $nama,
            'password' => Hash::make('1-8'),
            'kelas_id' => null,
            'email' => null,
            'email_verified_at' => null,
            'nis' => null,
            'jenis_kelamin' => null,
        ]);

        return DB::table('pengguna')->where('id', $id)->first();
    }

    private function normalisasi(string $nilai): string
    {
        return preg_replace('/[^A-Z0-9]/', '', mb_strtoupper(trim($nilai)));
    }
}

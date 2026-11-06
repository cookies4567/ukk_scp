<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportDataSiswa extends Command
{
    protected $signature = 'siswa:import';

    protected $description = 'Import data siswa dari CSV';

    public function handle()
    {
        $path = storage_path('app/data_siswa_scp_final.csv');

        if (!file_exists($path)) {
            $this->error('File CSV tidak ditemukan: ' . $path);
            return self::FAILURE;
        }

        $file = fopen($path, 'r');

        if (!$file) {
            $this->error('File CSV tidak dapat dibuka.');
            return self::FAILURE;
        }

        $header = fgetcsv($file);

        if (!$header) {
            fclose($file);
            $this->error('CSV kosong.');
            return self::FAILURE;
        }

        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

        $required = [
            'nama_kelas',
            'nomor_urut',
            'nis',
            'nama_lengkap',
            'jenis_kelamin'
        ];

        if ($header !== $required) {
            fclose($file);
            $this->error('Format kolom CSV tidak sesuai.');
            $this->line('Kolom yang dibutuhkan: ' . implode(', ', $required));
            return self::FAILURE;
        }

        $classes = DB::table('kelas')
            ->pluck('id', 'nama_kelas')
            ->all();

        $students = [];
        $seenNis = [];
        $missingClasses = [];
        $line = 1;

        while (($row = fgetcsv($file)) !== false) {
            $line++;

            if (count($row) !== 5) {
                $this->error("Format baris CSV tidak valid pada baris {$line}.");
                fclose($file);
                return self::FAILURE;
            }

            [$className, $number, $nis, $name, $gender] = $row;

            $className = trim($className);
            $nis = trim($nis);
            $name = trim($name);
            $gender = strtoupper(trim($gender));

            if (
                $className === '' ||
                $nis === '' ||
                $name === '' ||
                !in_array($gender, ['L', 'P'])
            ) {
                $this->error("Data tidak lengkap pada baris {$line}.");
                fclose($file);
                return self::FAILURE;
            }

            if (!isset($classes[$className])) {
                $missingClasses[] = $className;
                continue;
            }

            if (isset($seenNis[$nis])) {
                $this->error("NIS duplikat dalam CSV: {$nis}");
                fclose($file);
                return self::FAILURE;
            }

            $seenNis[$nis] = true;

            $students[] = [
                'nis' => $nis,
                'username' => $nis,
                'nama_lengkap' => $name,
                'jenis_kelamin' => $gender,
                'peran_id' => 5,
                'kelas_id' => $classes[$className],
            ];
        }

        fclose($file);

        if (!empty($missingClasses)) {
            $missingClasses = array_unique($missingClasses);

            $this->error('Ada nama kelas yang belum cocok dengan database:');

            foreach ($missingClasses as $class) {
                $this->line('- ' . $class);
            }

            return self::FAILURE;
        }

        if (count($students) !== 1711) {
            $this->error(
                'Jumlah siswa tidak sesuai. Ditemukan: ' .
                count($students) . ', seharusnya 1711.'
            );

            return self::FAILURE;
        }

        $this->info('Validasi CSV berhasil.');
        $this->info('Jumlah siswa: ' . count($students));
        $this->info('Jumlah kelas: ' . count($classes));

        if (!$this->confirm('Lanjutkan impor siswa ke database?')) {
            $this->warn('Impor dibatalkan.');
            return self::SUCCESS;
        }

        try {
            $result = DB::transaction(function () use ($students) {
                $inserted = 0;
                $skipped = 0;

                foreach ($students as $student) {
                    $exists = DB::table('pengguna')
                        ->where('nis', $student['nis'])
                        ->orWhere('username', $student['username'])
                        ->exists();

                    if ($exists) {
                        $skipped++;
                        continue;
                    }

                    $student['password'] = Hash::make(
                        $student['nis']
                    );

                    DB::table('pengguna')->insert([
                        ...$student,
                        'dibuat_pada' => now(),
                    ]);

                    $inserted++;
                }

                return [
                    'inserted' => $inserted,
                    'skipped' => $skipped,
                ];
            });

            $this->newLine();
            $this->info('IMPOR SELESAI!');
            $this->info('Siswa baru: ' . $result['inserted']);
            $this->info('Dilewati: ' . $result['skipped']);

            return self::SUCCESS;

        } catch (\Throwable $e) {
            $this->error('Impor gagal: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}

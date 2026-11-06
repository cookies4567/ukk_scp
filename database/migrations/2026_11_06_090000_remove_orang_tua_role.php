<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menghapus peran Orang Tua (ID 6). Seluruh fungsinya sudah
     * ditangani oleh peran Siswa (ID 5).
     */
    public function up(): void
    {
        // Hapus kolom relasi orang tua pada tabel pengguna.
        if (Schema::hasColumn('pengguna', 'orang_tua_id')) {
            // Cari nama foreign key yang sebenarnya di database
            // (bisa berupa pengguna_ibfk_2, dsb., bukan nama bawaan Laravel).
            $foreignKeys = DB::select(
                'SELECT CONSTRAINT_NAME AS nama
                 FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = ?
                   AND COLUMN_NAME = ?
                   AND REFERENCED_TABLE_NAME IS NOT NULL',
                ['pengguna', 'orang_tua_id']
            );

            foreach ($foreignKeys as $fk) {
                DB::statement(
                    'ALTER TABLE `pengguna` DROP FOREIGN KEY `' . $fk->nama . '`'
                );
            }

            Schema::table('pengguna', function ($table) {
                $table->dropColumn('orang_tua_id');
            });
        }

        // Hapus baris peran Orang Tua hanya jika tidak ada akun yang memakainya,
        // agar tidak ada akun yang kehilangan peran secara diam-diam.
        $masihDipakai = DB::table('pengguna')->where('peran_id', 6)->exists();

        if (! $masihDipakai) {
            DB::table('peran')->where('id', 6)->delete();
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('pengguna', 'orang_tua_id')) {
            Schema::table('pengguna', function ($table) {
                $table->unsignedBigInteger('orang_tua_id')->nullable();
            });
        }
    }
};
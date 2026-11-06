<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->string('nis', 20)
                ->nullable()
                ->unique()
                ->after('nama_lengkap');

            $table->string('jenis_kelamin', 1)
                ->nullable()
                ->after('nis');
        });
    }

    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropUnique(['nis']);
            $table->dropColumn(['nis', 'jenis_kelamin']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('guru_bk_kelas')) {
            return;
        }

        Schema::create('guru_bk_kelas', function (Blueprint $table) {
            $table->id();

            $table->integer('guru_bk_id');
            $table->integer('kelas_id');

            $table->foreign('guru_bk_id')
                ->references('id')
                ->on('pengguna')
                ->cascadeOnDelete();

            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->cascadeOnDelete();

            $table->unique(['guru_bk_id', 'kelas_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru_bk_kelas');
    }
};

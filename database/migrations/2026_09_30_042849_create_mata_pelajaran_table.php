<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_pelajaran', function (Blueprint $table) {

            $table->id();

            $table->string('kode_mata_pelajaran', 20)->unique();

            $table->string('nama_mata_pelajaran', 100);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};
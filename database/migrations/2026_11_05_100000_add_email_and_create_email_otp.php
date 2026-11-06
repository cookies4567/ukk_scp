<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Aman dijalankan walau kolom/tabel sudah dibuat manual lewat phpMyAdmin
        if (! Schema::hasColumn('pengguna', 'email')) {
            Schema::table('pengguna', function (Blueprint $table) {
                $table->string('email', 100)->nullable()->unique()->after('username');
            });
        }

        if (! Schema::hasColumn('pengguna', 'email_verified_at')) {
            Schema::table('pengguna', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            });
        }

        if (! Schema::hasTable('email_otp')) {
            Schema::create('email_otp', function (Blueprint $table) {
                $table->id();
                $table->integer('pengguna_id');
                $table->string('email', 100);
                $table->enum('tujuan', ['verifikasi_email', 'reset_password']);
                $table->string('kode_hash');
                $table->unsignedTinyInteger('percobaan')->default(0);
                $table->dateTime('kedaluwarsa_pada');
                $table->dateTime('digunakan_pada')->nullable();
                $table->dateTime('dibuat_pada')->useCurrent();

                $table->index(['pengguna_id', 'tujuan']);
                $table->foreign('pengguna_id')->references('id')->on('pengguna')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('email_otp');

        if (Schema::hasColumn('pengguna', 'email')) {
            Schema::table('pengguna', function (Blueprint $table) {
                $table->dropUnique(['email']);
                $table->dropColumn(['email', 'email_verified_at']);
            });
        }
    }
};

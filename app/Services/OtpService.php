<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\EmailOtp;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public const MASA_BERLAKU_MENIT = 5;
    public const MAKS_PERCOBAAN     = 5;
    public const JEDA_KIRIM_ULANG   = 60; // detik

    /**
     * Buat & kirim OTP. Return null jika sukses, atau string pesan error.
     */
    public function kirim(Pengguna $user, string $email, string $tujuan): ?string
    {
        $terakhir = EmailOtp::where('pengguna_id', $user->id)
            ->where('tujuan', $tujuan)
            ->latest('id')
            ->first();

        if ($terakhir && $terakhir->dibuat_pada->gt(now()->subSeconds(self::JEDA_KIRIM_ULANG))) {
            return 'Tunggu ' . self::JEDA_KIRIM_ULANG . ' detik sebelum meminta kode baru.';
        }

        // Hanya satu OTP aktif per pengguna per tujuan.
        EmailOtp::where('pengguna_id', $user->id)
            ->where('tujuan', $tujuan)
            ->whereNull('digunakan_pada')
            ->delete();

        $kode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailOtp::create([
            'pengguna_id'      => $user->id,
            'email'            => $email,
            'tujuan'           => $tujuan,
            'kode_hash'        => Hash::make($kode),
            'percobaan'        => 0,
            'kedaluwarsa_pada' => now()->addMinutes(self::MASA_BERLAKU_MENIT),
            'dibuat_pada'      => now(),
        ]);

        try {
            // send() (bukan queue) supaya tidak bergantung pada queue:work
            Mail::to($email)->send(new OtpMail($user, $kode, $tujuan));
        } catch (\Throwable $e) {
            Log::error('Gagal kirim OTP: ' . $e->getMessage());
            return 'Email gagal dikirim. Coba lagi beberapa saat.';
        }

        return null;
    }

    /**
     * Cek OTP. Return null jika benar, atau string pesan error.
     */
    public function verifikasi(Pengguna $user, string $email, string $tujuan, string $kode): ?string
    {
        $otp = EmailOtp::where('pengguna_id', $user->id)
            ->where('email', $email)
            ->where('tujuan', $tujuan)
            ->whereNull('digunakan_pada')
            ->latest('id')
            ->first();

        if (! $otp || $otp->kedaluwarsa_pada->isPast()) {
            return 'Kode tidak valid atau sudah kedaluwarsa. Minta kode baru.';
        }

        if ($otp->percobaan >= self::MAKS_PERCOBAAN) {
            return 'Terlalu banyak percobaan salah. Minta kode baru.';
        }

        if (! Hash::check($kode, $otp->kode_hash)) {
            $otp->increment('percobaan');
            return 'Kode OTP salah.';
        }

        $otp->update(['digunakan_pada' => now()]);

        return null;
    }
}

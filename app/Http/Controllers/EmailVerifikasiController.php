<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmailVerifikasiController extends Controller
{
    private const TUJUAN = 'verifikasi_email';

    // Kirim OTP ke email yang ingin dihubungkan ke akun
    public function kirim(Request $request, OtpService $otp)
    {
        /** @var Pengguna $user */
        $user = Auth::user();

        $data = $request->validate([
            'email' => [
                'required',
                'email:rfc',
                'max:100',
                Rule::unique('pengguna', 'email')->ignore($user->id),
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah dipakai akun lain.',
        ]);

        $error = $otp->kirim($user, $data['email'], self::TUJUAN);

        if ($error) {
            return back()->withErrors(['email' => $error])->withInput();
        }

        // Email baru disimpan ke DB hanya setelah OTP benar
        session(['pending_email' => $data['email']]);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Kode OTP dikirim ke ' . $data['email'] . '.');
    }

    // Cek OTP lalu tandai email terverifikasi
    public function verifikasi(Request $request, OtpService $otp)
    {
        /** @var Pengguna $user */
        $user = Auth::user();

        $request->validate([
            'kode' => ['required', 'digits:6'],
        ], [
            'kode.required' => 'Kode OTP wajib diisi.',
            'kode.digits'   => 'Kode OTP terdiri dari 6 angka.',
        ]);

        $email = session('pending_email');

        if (! $email) {
            return redirect()
                ->route('profile.edit')
                ->withErrors(['email' => 'Masukkan email terlebih dahulu.']);
        }

        $error = $otp->verifikasi($user, $email, self::TUJUAN, $request->kode);

        if ($error) {
            return back()->withErrors(['kode' => $error]);
        }

        $user->email = $email;
        $user->email_verified_at = now();
        $user->save();

        session()->forget('pending_email');

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Email berhasil diverifikasi.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    private const TUJUAN = 'reset_password';

    // Langkah 1: form input email
    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request, OtpService $otp)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Hanya email yang SUDAH terverifikasi ke akun SCP
        $user = Pengguna::where('email', $data['email'])
            ->whereNotNull('email_verified_at')
            ->first();

        if ($user) {
            $otp->kirim($user, $user->email, self::TUJUAN);
        }

        // Respons sama baik email terdaftar maupun tidak (mencegah enumerasi akun)
        session(['reset_email' => $data['email']]);

        return redirect()
            ->route('password.otp')
            ->with('status', 'Jika email terdaftar dan terverifikasi, kode OTP sudah dikirim.');
    }

    // Langkah 2: input OTP
    public function showOtp()
    {
        if (! session('reset_email')) {
            return redirect()->route('password.forgot');
        }

        return view('auth.verify-otp', ['email' => session('reset_email')]);
    }

    public function verifyOtp(Request $request, OtpService $otp)
    {
        $request->validate([
            'kode' => ['required', 'digits:6'],
        ], [
            'kode.required' => 'Kode OTP wajib diisi.',
            'kode.digits'   => 'Kode OTP terdiri dari 6 angka.',
        ]);

        $email = session('reset_email');

        if (! $email) {
            return redirect()->route('password.forgot');
        }

        $user = Pengguna::where('email', $email)
            ->whereNotNull('email_verified_at')
            ->first();

        $error = $user
            ? $otp->verifikasi($user, $email, self::TUJUAN, $request->kode)
            : 'Kode tidak valid atau sudah kedaluwarsa. Minta kode baru.';

        if ($error) {
            return back()->withErrors(['kode' => $error]);
        }

        session()->forget('reset_email');
        session([
            'reset_pengguna_id'    => $user->id,
            'reset_berlaku_hingga' => now()->addMinutes(10)->timestamp,
        ]);

        return redirect()->route('password.reset');
    }

    public function resendOtp(OtpService $otp)
    {
        $email = session('reset_email');

        if (! $email) {
            return redirect()->route('password.forgot');
        }

        $user = Pengguna::where('email', $email)
            ->whereNotNull('email_verified_at')
            ->first();

        $error = $user ? $otp->kirim($user, $email, self::TUJUAN) : null;

        if ($error) {
            return back()->withErrors(['kode' => $error]);
        }

        return back()->with('status', 'Kode OTP baru sudah dikirim jika email terdaftar.');
    }

    // Langkah 3: password baru
    public function showReset()
    {
        if (! $this->bolehReset()) {
            return redirect()->route('password.forgot');
        }

        return view('auth.reset-password');
    }

    public function reset(Request $request)
    {
        if (! $this->bolehReset()) {
            return redirect()->route('password.forgot');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Pengguna::findOrFail(session('reset_pengguna_id'));
        $user->password = Hash::make($request->password);
        $user->save();

        // Keluarkan semua sesi aktif akun ini (SESSION_DRIVER=database)
        DB::table('sessions')->where('user_id', $user->id)->delete();

        session()->forget(['reset_pengguna_id', 'reset_berlaku_hingga']);

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil diubah. Silakan masuk dengan password baru.');
    }

    private function bolehReset(): bool
    {
        return session('reset_pengguna_id')
            && session('reset_berlaku_hingga', 0) >= now()->timestamp;
    }
}

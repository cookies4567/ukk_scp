<div style="font-family:Arial,sans-serif;max-width:480px;margin:auto;color:#243449">
    <h2 style="color:#102b4e">SCP - SMK Negeri 1 Bantul</h2>

    <p>Halo, {{ $user->nama_lengkap }}.</p>

    <p>
        @if ($tujuan === 'reset_password')
            Gunakan kode berikut untuk mengatur ulang password akun SCP kamu:
        @else
            Gunakan kode berikut untuk memverifikasi email akun SCP kamu:
        @endif
    </p>

    <p style="font-size:32px;font-weight:700;letter-spacing:8px;background:#f3f5f8;
              padding:14px 0;text-align:center;border-radius:8px;color:#102b4e">
        {{ $kode }}
    </p>

    <p>Kode berlaku selama {{ \App\Services\OtpService::MASA_BERLAKU_MENIT }} menit dan hanya bisa dipakai sekali.</p>
    <p style="color:#748195;font-size:13px">
        Jangan berikan kode ini kepada siapa pun. Jika kamu tidak merasa memintanya, abaikan email ini.
    </p>
</div>

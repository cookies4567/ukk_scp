{{-- Sisipkan di edit.blade.php, setelah </form> utama dan sebelum </div> penutup .profile-card --}}
<div class="profile-divider"></div>

<h3>Email Akun</h3>

@if ($user->email && $user->email_verified_at)
    <p class="profile-description">
        Email terverifikasi: <strong>{{ $user->email }}</strong>.
        Email ini dipakai untuk fitur lupa password.
    </p>
@else
    <p class="profile-description">
        Belum ada email terverifikasi. Hubungkan email agar kamu bisa mengatur ulang password lewat OTP.
    </p>
@endif

@if (session('pending_email'))
    <p class="profile-description">
        Masukkan kode 6 angka yang dikirim ke <strong>{{ session('pending_email') }}</strong>.
    </p>

    <form action="{{ route('profile.email.verify') }}" method="POST">
        @csrf

        <div class="profile-form-group">
            <label for="kode">Kode OTP</label>
            <input type="text" id="kode" name="kode" inputmode="numeric"
                   maxlength="6" autocomplete="one-time-code" required>

            @error('kode')
                <small class="profile-error">{{ $message }}</small>
            @enderror
        </div>

        <div class="profile-actions">
            <button type="submit" class="profile-save">Verifikasi Email</button>
        </div>
    </form>
@endif

<form action="{{ route('profile.email.send') }}" method="POST">
    @csrf

    <div class="profile-form-group">
        <label for="email">{{ $user->email ? 'Ganti Email' : 'Email' }}</label>
        <input type="email" id="email" name="email"
               value="{{ old('email', session('pending_email')) }}" required>

        @error('email')
            <small class="profile-error">{{ $message }}</small>
        @enderror
    </div>

    <div class="profile-actions">
        <button type="submit" class="profile-save">Kirim Kode OTP</button>
    </div>
</form>

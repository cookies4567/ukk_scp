@extends('auth.layout-sederhana')

@section('title', 'Verifikasi OTP')
@section('heading', 'Masukkan kode OTP')
@section('subheading', 'Kode 6 angka dikirim ke ' . $email . '. Berlaku 5 menit.')

@section('content')
    <form action="{{ route('password.otp.verify') }}" method="POST">
        @csrf

        <label for="kode">Kode OTP</label>
        <input type="text" id="kode" name="kode" class="otp" inputmode="numeric"
               maxlength="6" autocomplete="one-time-code" required autofocus>

        <button type="submit">Verifikasi</button>
    </form>

    <div class="links">
        <form action="{{ route('password.otp.resend') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="link">Kirim ulang kode</button>
        </form>
        &nbsp;·&nbsp;
        <a href="{{ route('password.forgot') }}">Ganti email</a>
    </div>
@endsection

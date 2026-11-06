@extends('auth.layout-sederhana')

@section('title', 'Lupa Password')
@section('heading', 'Lupa password')
@section('subheading', 'Masukkan email yang sudah terverifikasi di akun SCP. Kami akan mengirim kode OTP 6 angka.')

@section('content')
    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}"
               placeholder="nama@email.com" required autofocus>

        <button type="submit">Kirim Kode OTP</button>
    </form>

    <div class="links"><a href="{{ route('login') }}">Kembali ke halaman masuk</a></div>
@endsection

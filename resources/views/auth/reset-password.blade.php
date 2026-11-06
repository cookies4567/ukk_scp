@extends('auth.layout-sederhana')

@section('title', 'Password Baru')
@section('heading', 'Buat password baru')
@section('subheading', 'Minimal 8 karakter.')

@section('content')
    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        <label for="password">Password Baru</label>
        <input type="password" id="password" name="password" autocomplete="new-password" required autofocus>

        <label for="password_confirmation">Konfirmasi Password Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               autocomplete="new-password" required>

        <button type="submit">Simpan Password</button>
    </form>
@endsection

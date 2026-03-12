@extends('layouts.app')
@section('title', 'Masuk Admin')

@section('content')
{{-- Halaman login mandiri (non-SPA) untuk URL /admin/login --}}
<div id="page-login" class="page active">
    <div class="login-page">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <rect width="24" height="24" rx="3" fill="#0d2859"/>
                        <path d="M12 3L4 8v2h16V8L12 3z" fill="#2563eb"/>
                        <rect x="5" y="10" width="3" height="8" fill="#2563eb"/>
                        <rect x="10.5" y="10" width="3" height="8" fill="#2563eb"/>
                        <rect x="16" y="10" width="3" height="8" fill="#2563eb"/>
                        <rect x="3" y="18" width="18" height="2" fill="#1e5bb5"/>
                    </svg>
                </div>
                <h2>Masuk ke Dashboard Admin</h2>
                <p>SIJAMU — Sistem Informasi Jadwal Tamu</p>
            </div>

            <div class="login-body">
                @if(session('error'))
                    <div class="alert alert-danger mb-16">
                        <span class="alert-icon">&#10005;</span>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger mb-16">
                        <span class="alert-icon">&#10005;</span>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <input type="text"
                               class="form-control @error('username') is-invalid @enderror"
                               id="username" name="username"
                               value="{{ old('username') }}"
                               placeholder="Masukkan username"
                               autocomplete="username"
                               required autofocus>
                        @error('username')
                            <div class="invalid-feedback" style="display:block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Kata Sandi</label>
                        <input type="password"
                               class="form-control"
                               id="password" name="password"
                               placeholder="Masukkan kata sandi"
                               autocomplete="current-password"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full btn-lg mt-8">
                        Masuk ke Sistem
                    </button>
                </form>
            </div>

            <div class="login-footer">
                Lupa kata sandi? Hubungi Administrator &nbsp;&bull;&nbsp;
                <a href="{{ route('home') }}">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection

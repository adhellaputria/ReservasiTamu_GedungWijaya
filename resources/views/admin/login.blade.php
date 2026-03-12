<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Login Admin — SIJAMU</title>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=Source+Sans+3:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--blue-900:#0d2859;--blue-800:#103370;--blue-700:#1a4a9c;--blue-600:#1e5bb5;--blue-300:#93c5fd;--white:#fff;--gray-50:#f8fafc;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-500:#64748b;--gray-700:#334155;--red:#b91c1c;--red-bg:#fef2f2;--r-sm:4px;--r-md:8px;--font-d:'Merriweather',Georgia,serif;--font-b:'Source Sans 3',sans-serif}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font-b);background:var(--blue-900);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;position:relative;overflow:hidden}
body::before{content:'';position:absolute;inset:0;opacity:.04;background-image:repeating-linear-gradient(45deg,white 0,white 1px,transparent 0,transparent 50%);background-size:28px 28px}
.card{background:var(--white);border-radius:var(--r-md);box-shadow:0 25px 60px rgba(0,0,0,.3);width:100%;max-width:400px;overflow:hidden;position:relative;z-index:1}
.hdr{background:var(--blue-900);padding:28px 24px 20px;text-align:center;border-bottom:3px solid var(--blue-600)}
.logo{width:52px;height:52px;background:var(--white);border-radius:var(--r-md);display:flex;align-items:center;justify-content:center;margin:0 auto 12px}
.hdr h2{color:var(--white);font-size:1.1rem;margin-bottom:4px;font-family:var(--font-d)}.hdr p{color:var(--blue-300);font-size:.78rem}
.body{padding:24px}
.ftr{padding:14px 24px;background:var(--gray-50);border-top:1px solid var(--gray-200);text-align:center;font-size:.78rem;color:var(--gray-500)}
.form-group{margin-bottom:18px}
.form-label{display:block;font-size:.82rem;font-weight:600;color:var(--gray-700);margin-bottom:5px}
.fc{width:100%;padding:9px 12px;font-size:.85rem;color:var(--gray-700);background:var(--white);border:1.5px solid var(--gray-200);border-radius:var(--r-sm);outline:none;transition:border-color .15s,box-shadow .15s;font-family:var(--font-b)}
.fc:focus{border-color:var(--blue-600);box-shadow:0 0 0 3px rgba(37,99,235,.12)}
.btn{width:100%;padding:11px;font-size:.9rem;font-weight:600;background:var(--blue-700);color:var(--white);border:none;border-radius:var(--r-sm);cursor:pointer;transition:background .15s;font-family:var(--font-b)}
.btn:hover{background:var(--blue-800)}
.alert{padding:10px 14px;border-radius:var(--r-sm);border-left:4px solid var(--red);background:var(--red-bg);color:#7f1d1d;font-size:.83rem;margin-bottom:14px;display:flex;align-items:flex-start;gap:9px}
.hint{background:var(--gray-50);border:1px solid var(--gray-200);border-radius:var(--r-sm);padding:10px 12px;font-size:.76rem;color:var(--gray-500);margin-top:12px;line-height:1.8}
code{font-size:.75rem;background:var(--gray-200);padding:1px 5px;border-radius:3px}
</style>
</head>
<body>
<div class="card">
  <div class="hdr">
    <div class="logo">
      <img src="{{ asset('images/logo-sukoharjo.png') }}" width="32">
  </div>
    <h2>Masuk ke Dashboard Admin</h2>
    <p>SIJAMU — Sistem Informasi Jadwal Tamu</p>
  </div>
  <div class="body">
    @if($errors->has('login'))
      <div class="alert"><span>✕</span>{{ $errors->first('login') }}</div>
    @endif
    @if(session('success'))
      <div style="padding:10px 14px;border-radius:4px;border-left:4px solid #22c55e;background:#f0fdf4;color:#14532d;font-size:.83rem;margin-bottom:14px;display:flex;align-items:center;gap:9px"><span>✓</span>{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.login.post') }}" method="POST">
      @csrf
      <div class="form-group">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="fc" placeholder="Username admin" value="{{ old('username') }}" autocomplete="username" autofocus>
      </div>
      <div class="form-group">
        <label class="form-label">Kata Sandi</label>
        <input type="password" name="password" class="fc" placeholder="Kata sandi" autocomplete="current-password">
      </div>
      <button type="submit" class="btn">Masuk ke Sistem</button>
    </form>
    <div class="hint">
      <strong style="color:#0d2859">Akun Demo</strong> (<code>admin.dispernaker</code> / <code>pass123</code>)<br>
    </div>
  </div>
  <div class="ftr"><a href="{{ route('home') }}" style="color:var(--blue-600)">&larr; Kembali ke Beranda</a></div>
</div>
</body>
</html>

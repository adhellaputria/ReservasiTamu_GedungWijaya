<!DOCTYPE html>
<html lang="id">

<head>
  <title>@yield('title','Dashboard') — SIJAMU Admin</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo-sukoharjo.png') }}">
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <title>@yield('title','Dashboard') — SIJAMU Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root {
      --blue-900: #0d2859;
      --blue-800: #103370;
      --blue-700: #1a4a9c;
      --blue-600: #1e5bb5;
      --blue-500: #2563eb;
      --blue-400: #3b82f6;
      --blue-300: #93c5fd;
      --blue-100: #dbeafe;
      --blue-50: #eff6ff;
      --white: #fff;
      --gray-50: #f8fafc;
      --gray-100: #f1f5f9;
      --gray-200: #e2e8f0;
      --gray-300: #cbd5e1;
      --gray-400: #94a3b8;
      --gray-500: #64748b;
      --gray-600: #475569;
      --gray-700: #334155;
      --gray-900: #0f172a;
      --red: #b91c1c;
      --red-bg: #fef2f2;
      --green: #15803d;
      --green-bg: #f0fdf4;
      --amber: #b45309;
      --amber-bg: #fffbeb;
      --font-d: 'Merriweather', Georgia, serif;
      --font-b: 'Source Sans 3', 'Segoe UI', sans-serif;
      --sh-sm: 0 1px 3px rgba(0, 0, 0, .08);
      --sh-md: 0 4px 6px -1px rgba(0, 0, 0, .08);
      --sh-lg: 0 10px 15px -3px rgba(0, 0, 0, .08);
      --r-sm: 4px;
      --r: 6px;
      --r-md: 8px;
      --sw: 248px;
      --th: 60px;
      --bh: 30px;
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }

    html {
      scroll-behavior: smooth
    }

    body {
      font-family: var(--font-b);
      font-size: 14px;
      line-height: 1.6;
      color: var(--gray-700);
      background: var(--gray-50);
      -webkit-font-smoothing: antialiased
    }

    a {
      color: var(--blue-600);
      text-decoration: none
    }

    button {
      cursor: pointer;
      font-family: var(--font-b)
    }

    input,
    select,
    textarea {
      font-family: var(--font-b)
    }

    h1,
    h2,
    h3 {
      font-family: var(--font-d);
      color: var(--gray-900)
    }

    h4 {
      font-size: .95rem;
      font-weight: 600;
      color: var(--gray-800)
    }

    p {
      font-size: .9rem;
      color: var(--gray-600);
      line-height: 1.7
    }

    .gov-banner {
      background: var(--blue-800);
      padding: 0 24px;
      height: var(--bh);
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: .7rem;
      color: var(--blue-300);
      border-bottom: 1px solid rgba(255, 255, 255, .08);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 101
    }

    .gov-banner strong {
      color: rgba(255, 255, 255, .9)
    }

    .topbar {
      position: fixed;
      top: var(--bh);
      left: 0;
      right: 0;
      z-index: 100;
      height: var(--th);
      background: var(--blue-900);
      border-bottom: 3px solid var(--blue-600);
      display: flex;
      align-items: center;
      padding: 0 24px;
      gap: 16px
    }

    .topbar-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      flex: 1
    }

    .topbar-logo {
      width: 36px;
      height: 36px;
      background: var(--white);
      border-radius: var(--r-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0
    }

    .topbar-title {
      font-family: var(--font-d);
      font-size: .88rem;
      font-weight: 900;
      color: var(--white);
      letter-spacing: .01em;
      line-height: 1.2
    }

    .topbar-sub {
      font-size: .68rem;
      color: var(--blue-300);
      font-weight: 400;
      letter-spacing: .03em;
      margin-top: 1px
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 8px 18px;
      font-size: .82rem;
      font-weight: 600;
      border: none;
      border-radius: var(--r-sm);
      cursor: pointer;
      transition: all .15s;
      text-decoration: none;
      white-space: nowrap;
      font-family: var(--font-b)
    }

    .btn-primary {
      background: var(--blue-700);
      color: var(--white)
    }

    .btn-primary:hover {
      background: var(--blue-800);
      color: var(--white);
      text-decoration: none
    }

    .btn-secondary {
      background: var(--white);
      color: var(--blue-700);
      border: 1.5px solid var(--blue-300)
    }

    .btn-secondary:hover {
      background: var(--blue-50);
      text-decoration: none
    }

    .btn-outline {
      background: transparent;
      color: var(--gray-600);
      border: 1.5px solid var(--gray-300)
    }

    .btn-outline:hover {
      background: var(--gray-50);
      text-decoration: none
    }

    .btn-danger {
      background: var(--red);
      color: var(--white)
    }

    .btn-danger:hover {
      background: #991b1b;
      text-decoration: none
    }

    .btn-danger-soft {
      background: var(--red-bg);
      color: var(--red)
    }

    .btn-success-soft {
      background: var(--green-bg);
      color: var(--green)
    }

    .btn-sm {
      padding: 5px 12px;
      font-size: .78rem
    }

    .btn-lg {
      padding: 11px 28px;
      font-size: .9rem
    }

    .btn-full {
      width: 100%;
      justify-content: center
    }

    .fc,
    .fsel,
    .fta {
      width: 100%;
      padding: 8px 12px;
      font-size: .85rem;
      color: var(--gray-700);
      background: var(--white);
      border: 1.5px solid var(--gray-300);
      border-radius: var(--r-sm);
      outline: none;
      transition: border-color .15s, box-shadow .15s;
      -webkit-appearance: none
    }

    .fc:focus,
    .fsel:focus,
    .fta:focus {
      border-color: var(--blue-500);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, .12)
    }

    .fsel {
      cursor: pointer;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 10px center;
      padding-right: 28px
    }

    .fta {
      resize: vertical;
      min-height: 80px
    }

    .form-group {
      margin-bottom: 18px
    }

    .form-label {
      display: block;
      font-size: .82rem;
      font-weight: 600;
      color: var(--gray-700);
      margin-bottom: 5px
    }

    .card {
      background: var(--white);
      border: 1px solid var(--gray-200);
      border-radius: var(--r-md);
      box-shadow: var(--sh-sm);
      overflow: hidden
    }

    .card-header {
      padding: 14px 20px;
      background: var(--white);
      border-bottom: 1px solid var(--gray-200);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px
    }

    .card-htitle {
      font-size: .88rem;
      font-weight: 700;
      color: var(--gray-900);
      display: flex;
      align-items: center;
      gap: 8px
    }

    .ico {
      width: 26px;
      height: 26px;
      background: var(--blue-100);
      color: var(--blue-700);
      border-radius: var(--r-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .8rem;
      flex-shrink: 0
    }

    .card-body {
      padding: 20px
    }

    .card-footer {
      padding: 12px 20px;
      border-top: 1px solid var(--gray-200);
      background: var(--gray-50);
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 8px
    }

    .badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 3px 9px;
      border-radius: 3px;
      font-size: .74rem;
      font-weight: 600;
      white-space: nowrap
    }

    .bdot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: currentColor;
      flex-shrink: 0
    }

    .bw {
      background: var(--amber-bg);
      color: var(--amber)
    }

    .ba {
      background: var(--green-bg);
      color: var(--green)
    }

    .br {
      background: var(--red-bg);
      color: var(--red)
    }

    .bh {
      background: var(--blue-50);
      color: var(--blue-700)
    }

    .bt {
      background: var(--gray-200);
      color: var(--gray-600)
    }

    .tbl-wrap {
      overflow-x: auto
    }

    .dtbl {
      width: 100%;
      border-collapse: collapse;
      font-size: .83rem
    }

    .dtbl thead tr {
      background: var(--gray-50);
      border-bottom: 2px solid var(--gray-200)
    }

    .dtbl th {
      padding: 10px 14px;
      font-size: .72rem;
      font-weight: 700;
      color: var(--gray-500);
      text-transform: uppercase;
      letter-spacing: .06em;
      text-align: left;
      white-space: nowrap
    }

    .dtbl td {
      padding: 11px 14px;
      color: var(--gray-700);
      border-bottom: 1px solid var(--gray-100);
      vertical-align: middle
    }

    .dtbl tbody tr:hover td {
      background: var(--blue-50)
    }

    .dtbl tbody tr:last-child td {
      border-bottom: none
    }

    .tcode {
      font-family: 'Courier New', monospace;
      font-size: .78rem;
      font-weight: 700;
      color: var(--blue-700)
    }

    .alert {
      padding: 10px 14px;
      border-radius: var(--r-sm);
      border-left: 4px solid;
      font-size: .83rem;
      margin-bottom: 14px;
      display: flex;
      align-items: flex-start;
      gap: 9px
    }

    .alert-warn {
      background: var(--amber-bg);
      border-color: #f59e0b;
      color: #92400e
    }

    .alert-info {
      background: var(--blue-50);
      border-color: var(--blue-500);
      color: var(--blue-800)
    }

    .alert-ok {
      background: var(--green-bg);
      border-color: #22c55e;
      color: #14532d
    }

    .alert-err {
      background: var(--red-bg);
      border-color: var(--red);
      color: #7f1d1d
    }

    .ai {
      flex-shrink: 0
    }

    .irow {
      display: flex;
      padding: 8px 0;
      border-bottom: 1px solid var(--gray-100);
      font-size: .83rem;
      gap: 12px
    }

    .irow:last-child {
      border-bottom: none
    }

    .ikey {
      width: 160px;
      flex-shrink: 0;
      color: var(--gray-500);
      font-weight: 600
    }

    .ival {
      flex: 1;
      color: var(--gray-800);
      word-break: break-word
    }

    .kpi-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px
    }

    .kpi-card {
      background: var(--white);
      border: 1px solid var(--gray-200);
      border-radius: var(--r-md);
      padding: 16px 18px;
      box-shadow: var(--sh-sm);
      display: flex;
      align-items: flex-start;
      gap: 14px;
      position: relative;
      overflow: hidden
    }

    .kpi-card::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px
    }

    .kpi-card.kamber::before {
      background: #f59e0b
    }

    .kpi-card.kgreen::before {
      background: #16a34a
    }

    .kpi-card.kred::before {
      background: var(--red)
    }

    .kpi-card.kblue::before {
      background: var(--blue-600)
    }

    .kpi-ico {
      width: 40px;
      height: 40px;
      border-radius: var(--r-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      flex-shrink: 0
    }

    .kamber .kpi-ico {
      background: #fef3c7;
      color: #d97706
    }

    .kgreen .kpi-ico {
      background: var(--green-bg);
      color: var(--green)
    }

    .kred .kpi-ico {
      background: var(--red-bg);
      color: var(--red)
    }

    .kblue .kpi-ico {
      background: var(--blue-100);
      color: var(--blue-700)
    }

    .kpi-num {
      font-family: var(--font-d);
      font-size: 1.9rem;
      font-weight: 900;
      color: var(--gray-900);
      line-height: 1
    }

    .kpi-lbl {
      font-size: .77rem;
      color: var(--gray-500);
      margin-top: 3px;
      font-weight: 500
    }

    .sidebar {
      width: var(--sw);
      flex-shrink: 0;
      background: var(--blue-900);
      position: fixed;
      top: calc(var(--th) + var(--bh));
      left: 0;
      bottom: 0;
      overflow-y: auto;
      z-index: 50
    }

    .sl-sec {
      padding: 16px 18px 6px;
      font-size: .65rem;
      font-weight: 700;
      color: rgba(255, 255, 255, .3);
      text-transform: uppercase;
      letter-spacing: .1em
    }

    .sl {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 9px 18px;
      font-size: .83rem;
      font-weight: 500;
      color: rgba(255, 255, 255, .6);
      border-left: 3px solid transparent;
      cursor: pointer;
      transition: all .15s;
      text-decoration: none
    }

    .sl:hover {
      color: var(--white);
      background: rgba(255, 255, 255, .06);
      text-decoration: none
    }

    .sl.active {
      color: var(--white);
      background: rgba(255, 255, 255, .1);
      border-left-color: var(--blue-400);
      font-weight: 600
    }

    .sl-div {
      height: 1px;
      background: rgba(255, 255, 255, .08);
      margin: 10px 0
    }

    .dash-main {
      margin-left: var(--sw);
      padding: 28px;
      min-height: calc(100vh - var(--th) - var(--bh));
      margin-top: calc(var(--th) + var(--bh))
    }

    .modal-bd {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, .5);
      z-index: 200;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 20px
    }

    .modal-bd.show {
      display: flex
    }

    .modal {
      background: var(--white);
      border-radius: var(--r-md);
      box-shadow: var(--sh-lg);
      width: 100%;
      max-width: 540px;
      max-height: 92vh;
      overflow-y: auto
    }

    .modal-hdr {
      padding: 16px 20px;
      background: var(--blue-900);
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-radius: var(--r-md) var(--r-md) 0 0
    }

    .modal-ttl {
      font-family: var(--font-d);
      font-size: .95rem;
      font-weight: 700;
      color: var(--white)
    }

    .modal-cls {
      background: none;
      border: none;
      color: rgba(255, 255, 255, .7);
      font-size: 1.2rem;
      line-height: 1;
      padding: 4px
    }

    .modal-body {
      padding: 20px
    }

    .modal-ftr {
      padding: 14px 20px;
      border-top: 1px solid var(--gray-200);
      display: flex;
      gap: 8px;
      justify-content: flex-end;
      background: var(--gray-50);
      border-radius: 0 0 var(--r-md) var(--r-md)
    }

    .flash {
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 999;
      max-width: 380px;
      animation: slideIn .3s ease
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(20px)
      }

      to {
        opacity: 1;
        transform: translateX(0)
      }
    }

    .mt4 {
      margin-top: 4px
    }

    .mt8 {
      margin-top: 8px
    }

    .mt12 {
      margin-top: 12px
    }

    .mt16 {
      margin-top: 16px
    }

    .mt20 {
      margin-top: 20px
    }

    .mt24 {
      margin-top: 24px
    }

    .mb16 {
      margin-bottom: 16px
    }

    .mb20 {
      margin-bottom: 20px
    }

    .mb24 {
      margin-bottom: 24px
    }

    hr.div {
      border: none;
      border-top: 1px solid var(--gray-200);
      margin: 20px 0
    }

    .empty-st {
      text-align: center;
      padding: 48px 20px;
      color: var(--gray-400)
    }

    .fchip {
      padding: 5px 12px;
      border-radius: 3px;
      font-size: .76rem;
      font-weight: 600;
      cursor: pointer;
      border: 1.5px solid var(--gray-300);
      background: var(--white);
      color: var(--gray-500);
      transition: all .15s;
      text-decoration: none
    }

    .fchip:hover {
      border-color: var(--blue-400);
      color: var(--blue-600);
      text-decoration: none
    }

    .fchip.active {
      background: var(--blue-900);
      color: var(--white);
      border-color: var(--blue-900)
    }

    @media(max-width:768px) {

    .sidebar {
      transform: translateX(-100%);
      transition: transform 0.3s ease;
      position: fixed;
      z-index: 200;
    }

    .sidebar.show {
      transform: translateX(0);
    }

    .sidebar-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.35);
      z-index: 150;
      display: none;
    }

    .sidebar-overlay.show {
      display: block;
    }

    .dash-main {
      margin-left: 0;
    }
  }

    @media(max-width:480px) {
      .kpi-grid {
        grid-template-columns: 1fr
      }
    }
    .chart-bars {
      display: flex;
      align-items: flex-end;
      justify-content: center;
      gap: 14px;
      height: 120px;
      padding: 6px 0;
  }

  .chart-bar-wrap {
      flex: 0 0 42px;
}

  .chart-bar-fill {
      width: 100%;
      border-radius: 4px;
      background: var(--blue-600);
  }
  </style>
  @stack('styles')
</head>

<body>
  <div class="gov-banner">
    <span><strong>Pemerintah Kabupaten Sukoharjo</strong> &nbsp;|&nbsp; Panel Admin SIJAMU</span>
    <span id="clockBanner"></span>
  </div>
<header class="topbar">
  <button class="topbar-hamburger" onclick="toggleAdminSidebar()">☰</button>
  <div class="topbar-brand">
      <div class="topbar-logo">
        <img src="{{ asset('images/logo-sukoharjo.png') }}" width="26">
      </div>
      <div>
        <div class="topbar-title">SIJAMU — Admin</div>
        <div class="topbar-sub">
          @if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN)
            Admin Umum (Superadmin)
          @else
            {{ session('admin_opd_nama','—') }}
          @endif
        </div>
      </div>
    </div>
    <div style="margin-left:auto;display:flex;align-items:center;gap:12px">
      <span style="font-size:.78rem;color:var(--blue-300)">{{ session('admin_nama') }}</span>
      <button onclick="document.getElementById('logoutModal').classList.add('show')" class="btn btn-outline btn-sm"
        style="color:rgba(255,255,255,.7);border-color:rgba(255,255,255,.2)">Keluar</button>
    </div>
  </header>

<aside class="sidebar-overlay" onclick="toggleAdminSidebar()"></aside>
<aside class="sidebar">
    <div style="padding:16px 0 40px">
      @if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN)
      {{-- 'admin_utama' MENU --}}
      <div class="sl-sec">Menu Utama</div>
      <a href="{{ route('admin.dashboard') }}" class="sl {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span>&#9632;</span>Overview</a>
      <div class="sl-div"></div>
      
      <div class="sl-sec">Kelola Data</div>
      <a href="{{ route('admin.reservasi.index') }}" class="sl {{ request()->routeIs('admin.reservasi.index') ? 'active' : '' }}"><span>&#9632;</span>Semua Reservasi</a>
      <a href="{{ route('admin.ruangan.index') }}" class="sl {{ request()->routeIs('admin.ruangan.*') ? 'active' : '' }}"><span>&#9632;</span>Kelola Ruangan/OPD</a>
      <div class="sl-div"></div>
      
      <div class="sl-sec">Kelola Admin</div>
      <a href="{{ route('admin.opd-admin.index') }}" class="sl {{ request()->routeIs('admin.opd-admin.*') ? 'active' : '' }}"><span>&#9632;</span>Admin OPD</a>
      <div class="sl-div"></div>
      
      <div class="sl-sec">Laporan</div>
      <a href="{{ route('admin.laporan') }}" class="sl {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}"><span>&#9632;</span>Laporan Global</a>
      
      @else
      {{-- ADMIN OPD MENU --}}
      <div class="sl-sec">Menu Utama</div>
      <a href="{{ route('admin.dashboard') }}" class="sl {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span>&#9632;</span>Overview</a>
      <a href="{{ route('admin.reservasi.index') }}" class="sl {{ request()->routeIs('admin.reservasi.index') ? 'active' : '' }}"><span>&#9632;</span>Reservasi Tamu</a>
      <div class="sl-div"></div>
      <div class="sl-sec">Petugas</div>
      <a href="{{ route('admin.verifikasi.index') }}" class="sl {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}"><span>&#9632;</span>Verifikasi Kehadiran</a>
      <div class="sl-div"></div>
      <div class="sl-sec">Laporan</div>
      <a href="{{ route('admin.laporan') }}" class="sl {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}"><span>&#9632;</span>Laporan OPD</a>
      @endif
      
      <div class="sl-div"></div>
      <div style="padding:12px 18px">
        <div style="background:rgba(255,255,255,.07);border-radius:var(--r-sm);padding:10px 12px">
          <div style="font-size:.68rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px">
            Login sebagai
          </div>
          <div style="font-size:.82rem;font-weight:600;color:var(--white)">{{ session('admin_nama') }}</div>
          <div style="font-size:.72rem;color:var(--blue-300);margin-top:2px">
            @if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN)
              Admin Umum (Superadmin)
            @else
              {{ session('admin_opd_nama') }}
            @endif
          </div>
        </div>
      </div>
    </div>
  </aside>

  <main class="dash-main">
    @if(session('success'))
    <div class="flash">
      <div class="alert alert-ok"><span class="ai">✓</span>{{ session('success') }}</div>
    </div>
    @endif
    @if(session('error'))
    <div class="flash">
      <div class="alert alert-err"><span class="ai">✕</span>{{ session('error') }}</div>
    </div>
    @endif

    @yield('content')
  </main>

  {{-- LOGOUT CONFIRM MODAL --}}
  <div class="modal-bd" id="logoutModal">
    <div class="modal" style="max-width:400px">
      <div class="modal-hdr"><span class="modal-ttl">Konfirmasi Keluar</span><button class="modal-cls"
          onclick="document.getElementById('logoutModal').classList.remove('show')">&times;</button></div>
      <div class="modal-body" style="text-align:center;padding:28px 24px">
        <div style="font-size:2.5rem;margin-bottom:12px">&#128274;</div>
        <h3 style="margin-bottom:8px;font-family:var(--font-d)">Yakin ingin keluar?</h3>
        <p style="font-size:.85rem;color:var(--gray-500)">Sesi Anda akan diakhiri dan Anda diarahkan kembali ke halaman
          login.</p>
      </div>
      <div class="modal-ftr" style="justify-content:center;gap:12px">
        <button class="btn btn-outline" onclick="document.getElementById('logoutModal').classList.remove('show')"
          style="min-width:100px">Batal</button>
        <form action="{{ route('admin.logout') }}" method="POST" style="margin:0">
          @csrf
          <button type="submit" class="btn btn-danger" style="min-width:100px">Ya, Keluar</button>
        </form>
      </div>
    </div>
  </div>

<script>
    (function () {
      function tick() { var d = new Date(); var el = document.getElementById('clockBanner'); if (el) el.textContent = d.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) + ' · ' + d.toLocaleTimeString('id-ID'); }
      tick(); setInterval(tick, 1000);
      setTimeout(function () { var f = document.querySelector('.flash'); if (f) f.style.display = 'none'; }, 4000);
      // Close modal on backdrop click
      document.getElementById('logoutModal').addEventListener('click', function (e) { if (e.target === this) this.classList.remove('show'); });
      
      // Admin Sidebar Toggle
      window.toggleAdminSidebar = function() {
        var sidebar = document.querySelector('.sidebar');
        var overlay = document.querySelector('.sidebar-overlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
      };
      
      // Close sidebar when clicking overlay
      document.querySelector('.sidebar-overlay').addEventListener('click', function() {
        this.classList.remove('show');
        document.querySelector('.sidebar').classList.remove('show');
      });
    })();
  </script>
  @stack('scripts')
</body>

</html>

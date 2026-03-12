@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- ============================================================
PAGE: HOME
============================================================ --}}
<div id="page-home" class="page active content-wrapper">

    {{-- ── Hero ── --}}
    <section class="hero-section">
        <div class="hero-bg-pattern"></div>
        <div class="hero-container">
            <div class="hero-eyebrow">
                Sistem Informasi Resmi
            </div>
            <h1 class="hero-title">
                Sistem Reservasi Tamu<br>
                <span>Gedung Wijaya</span>
            </h1>
            <p class="hero-subtitle">
                Layanan penjadwalan kunjungan tamu ke Organisasi Perangkat Daerah (OPD)
                secara digital, transparan, dan terorganisir.
            </p>
            <div class="hero-cta">
                <button class="btn btn-primary btn-lg" onclick="showPage('form')">
                    Buat Reservasi Kunjungan
                </button>
                <button class="btn btn-secondary btn-lg" onclick="showPage('check')">
                    Cek Status Reservasi
                </button>
            </div>
            <div class="hero-stat-bar">
                <div class="hero-stat">
                    <div class="hero-stat-num" id="statTotal">0</div>
                    <div class="hero-stat-label">Total Reservasi</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-num" id="statApproved">0</div>
                    <div class="hero-stat-label">Selesai</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-num" id="statOPD">0</div>
                    <div class="hero-stat-label">OPD Terdaftar</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Cara Penggunaan ── --}}
    <section class="features-section">
        <div class="section-header">
            <div class="section-eyebrow">Panduan Penggunaan</div>
            <h2 class="section-title">Cara Membuat Reservasi</h2>
            <p class="section-subtitle">Ikuti empat langkah berikut untuk menjadwalkan kunjungan Anda</p>
        </div>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-step">1</div>
                <h4>Isi Formulir Data Diri</h4>
                <p>Lengkapi identitas diri, nomor kontak, dan alamat email aktif.</p>
            </div>
            <div class="feature-card">
                <div class="feature-step">2</div>
                <h4>Pilih OPD &amp; Jadwal</h4>
                <p>Tentukan OPD yang dituju, tanggal kunjungan, dan jam yang tersedia sesuai kebutuhan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-step">3</div>
                <h4>Lampirkan Dokumen</h4>
                <p>Upload surat pendukung atau berkas terkait bila diperlukan untuk memperkuat pengajuan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-step">4</div>
                <h4>Terima Konfirmasi</h4>
                <p>Kode reservasi akan ditampilkan setelah permohonan berhasil dikirim.</p>
            </div>
        </div>
    </section>

    {{-- ── Informasi Penting ── --}}
    <section
        style="background:var(--blue-50);border-top:1px solid var(--blue-100);border-bottom:1px solid var(--blue-100);padding:40px 24px">
        <div style="max-width:880px;margin:0 auto">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
                @if(false) {{-- In real app, use actual data --}} @endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            <div class="icon">&#9432;</div>
                            Ketentuan Kunjungan
                        </div>
                    </div>
                    <div class="card-body" style="font-size:0.82rem;color:var(--gray-600)">
                        <ul style="padding-left:16px;line-height:2">
                            <li>Reservasi dibuka setiap hari kerja (Senin–Jumat)</li>
                            <li>Jam pelayanan: 08.00 – 16.00 WIB</li>
                            <li>Status reservasi dapat dicek secara online</li>
                            <li>Hadir tepat waktu sesuai jadwal yang disetujui</li>
                            <li>Tunjukkan kode reservasi kepada petugas di lobi</li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            <div class="icon">&#128222;</div>
                            Kontak &amp; Bantuan
                        </div>
                    </div>
                    <div class="card-body" style="font-size:0.82rem;color:var(--gray-600)">
                        <div style="line-height:2.2">
                            <div><strong>Telepon:</strong> (0271) 593 111</div>
                            <div><strong>Email:</strong> pelayanan@sukoharjokab.go.id</div>
                            <div><strong>Alamat:</strong> Jl. Jenderal Sudirman No. 199, Sukoharjo</div>
                            <div><strong>Jam Layanan:</strong> 08.00 – 16.00 WIB</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

{{-- ============================================================
PAGE: FORM RESERVASI
============================================================ --}}
<div id="page-form" class="page content-wrapper">
    <div class="form-page-container">

        {{-- Breadcrumb --}}
        <div class="page-breadcrumb">
            <button onclick="showPage('home')"
                style="background:none;border:none;color:var(--blue-600);cursor:pointer;padding:0;font-size:0.78rem">Beranda</button>
            <span class="sep">/</span>
            <span>Buat Reservasi</span>
        </div>

        {{-- Page Header --}}
        <div class="page-title-bar">
            <h2>Formulir Permohonan Reservasi Tamu</h2>
            <p>Isi seluruh data dengan benar dan lengkap. Bidang bertanda (<span style="color:var(--red)">*</span>)
                wajib diisi.</p>
        </div>

        {{-- Step Wizard --}}
        <div class="step-wizard">
            <div class="step-item active" id="stepItem1">
                <div class="step-num" id="stepNum1">1</div>
                <div class="step-label" id="stepLabel1">Data Tamu</div>
            </div>
            <div class="step-item" id="stepItem2">
                <div class="step-num" id="stepNum2">2</div>
                <div class="step-label" id="stepLabel2">Tujuan &amp; Jadwal</div>
            </div>
            <div class="step-item" id="stepItem3">
                <div class="step-num" id="stepNum3">3</div>
                <div class="step-label" id="stepLabel3">Dokumen &amp; Konfirmasi</div>
            </div>
        </div>

        {{-- ── Step 1: Data Diri ── --}}
        <div id="formStep1" class="card">
            <div class="card-header">
                <div class="card-header-title">
                    <div class="icon">1</div>
                    Data Identitas Tamu
                </div>
            </div>
            <div class="card-body">
                <div class="form-section-title">Informasi Pribadi</div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="fNama">Nama Lengkap (Beserta Gelar) <span
                                class="required">*</span></label>
                        <input type="text" class="form-control" id="fNama" placeholder="Masukkan nama lengkap Anda"
                            autocomplete="name">
                        <div class="invalid-feedback" id="errFNama"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="fHp">Nomor HP / WhatsApp <span class="required">*</span></label>
                        <input type="tel" class="form-control" id="fHp" placeholder="Contoh: 08123456789"
                            autocomplete="tel">
                        <div class="invalid-feedback" id="errFHp"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="fEmail">Alamat Email Aktif <span class="required">*</span></label>
                    <input type="email" class="form-control" id="fEmail" name="email_tamu" placeholder="Contoh: nama@instansi.go.id"
                        autocomplete="email">
                    <div class="form-hint">Email disimpan sebagai data tamu untuk keperluan reservasi.</div>
                    <div class="invalid-feedback" id="errFEmail"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="fInstansi">Instansi / Lembaga / Asal</label>
                    <input type="text" class="form-control" id="fInstansi"
                        placeholder="Nama instansi atau lembaga (opsional)" autocomplete="organization">
                </div>
                <hr class="form-divider">
                <div class="form-section-title">Keperluan</div>
                <div class="form-group">
                    <label class="form-label" for="fTujuanSingkat">Ringkasan Tujuan Kunjungan <span
                            class="required">*</span></label>
                    <input type="text" class="form-control" id="fTujuanSingkat"
                        placeholder="Contoh: Konsultasi perizinan usaha bidang perdagangan">
                    <div class="invalid-feedback" id="errFTujuanSingkat"></div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-outline" onclick="showPage('home')">Kembali</button>
                <button class="btn btn-primary" onclick="goNextStep(2)">
                    Selanjutnya &rarr;
                </button>
            </div>
        </div>

        {{-- ── Step 2: Tujuan & Jadwal ── --}}
        <div id="formStep2" class="card" style="display:none">
            <div class="card-header">
                <div class="card-header-title">
                    <div class="icon">2</div>
                    Tujuan &amp; Jadwal Kunjungan
                </div>
            </div>
            <div class="card-body">
                <div class="form-section-title">Pemilihan OPD</div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="fOpd">OPD yang Dituju <span class="required">*</span></label>
                        <select class="form-select" id="fOpd">
                            <option value="">— Pilih OPD Tujuan —</option>
                            <option>Dinas Pendidikan</option>
                            <option>Dinas Kesehatan</option>
                            <option>Dinas Pekerjaan Umum</option>
                            <option>Dinas Perhubungan</option>
                            <option>Dinas Komunikasi dan Informatika</option>
                            <option>Dinas Sosial</option>
                            <option>Dinas Tenaga Kerja</option>
                            <option>Dinas Lingkungan Hidup</option>
                            <option>Badan Perencanaan Pembangunan Daerah</option>
                            <option>Badan Kepegawaian Daerah</option>
                            <option>Badan Keuangan Daerah</option>
                            <option>Sekretariat Daerah</option>
                        </select>
                        <div class="invalid-feedback" id="errFOpd"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="fPetugas">Pejabat / Staf yang Dituju</label>
                        <input type="text" class="form-control" id="fPetugas"
                            placeholder="Nama atau jabatan (opsional)">
                    </div>
                </div>

                <hr class="form-divider">
                <div class="form-section-title">Jadwal Kunjungan</div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="fTanggal">Tanggal Kunjungan <span
                                class="required">*</span></label>
                        <input type="date" class="form-control" id="fTanggal">
                        <div class="invalid-feedback" id="errFTanggal"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="fJam">Waktu Kunjungan <span class="required">*</span></label>
                        <select class="form-select" id="fJam">
                            <option value="">— Pilih Sesi Waktu —</option>
                            <option>08:00 – 09:00</option>
                            <option>09:00 – 10:00</option>
                            <option>10:00 – 11:00</option>
                            <option>11:00 – 12:00</option>
                            <option>13:00 – 14:00</option>
                            <option>14:00 – 15:00</option>
                            <option>15:00 – 16:00</option>
                        </select>
                        <div class="invalid-feedback" id="errFJam"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="fKeterangan">Keterangan Tambahan</label>
                    <textarea class="form-textarea" id="fKeterangan"
                        placeholder="Informasi pendukung yang perlu diketahui admin OPD..."></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-outline" onclick="goPrevStep(1)">&larr; Kembali</button>
                <button class="btn btn-primary" onclick="goNextStep(3)">
                    Selanjutnya &rarr;
                </button>
            </div>
        </div>

        {{-- ── Step 3: Dokumen & Review ── --}}
        <div id="formStep3" class="card" style="display:none">
            <div class="card-header">
                <div class="card-header-title">
                    <div class="icon">3</div>
                    Dokumen Pendukung &amp; Konfirmasi
                </div>
            </div>
            <div class="card-body">
                <div class="form-section-title">Unggah Berkas (Opsional)</div>
                <p style="font-size:0.82rem;color:var(--gray-500);margin-bottom:14px">
                    Lampirkan surat permohonan, surat tugas, atau dokumen pendukung lain jika diperlukan.
                </p>

                <div class="upload-area" id="uploadArea">
                    <input type="file" id="fileInput" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        onchange="handleFileChange(event)">
                    <div class="upload-area-icon">&#128196;</div>
                    <div class="upload-area-text">
                        <strong>Klik untuk pilih berkas</strong> atau seret dan lepaskan ke sini
                    </div>
                    <div class="upload-area-hint">Format: PDF, Word, atau gambar (maks. 5 MB)</div>
                </div>

                <div class="upload-file-preview" id="uploadPreview" style="display:none">
                    <span>&#128206;</span>
                    <span class="upload-file-name" id="uploadFileName"></span>
                    <button class="upload-remove" onclick="clearUpload()" title="Hapus berkas">&times;</button>
                </div>

                <hr class="form-divider">
                <div class="form-section-title">Ringkasan Permohonan</div>
                <div class="review-box">
                    <div class="review-box-title">Periksa kembali data sebelum mengirim</div>
                    <div class="info-list">
                        <div class="info-row">
                            <span class="info-key">Nama Lengkap</span>
                            <span class="info-val" id="revNama">—</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Alamat Email</span>
                            <span class="info-val" id="revEmail">—</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">OPD Tujuan</span>
                            <span class="info-val" id="revOpd">—</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Tanggal Kunjungan</span>
                            <span class="info-val" id="revTanggal">—</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Jam Kunjungan</span>
                            <span class="info-val" id="revJam">—</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">Tujuan</span>
                            <span class="info-val" id="revTujuan">—</span>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-12">
                    <span class="alert-icon">&#9432;</span>
                    Dengan mengirim formulir ini, Anda menyatakan bahwa data yang diisikan adalah benar
                    dan dapat dipertanggungjawabkan.
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-outline" onclick="goPrevStep(2)">&larr; Kembali</button>
                <button class="btn btn-primary btn-lg" id="btnSubmit" onclick="submitReservasi()">
                    <span>Kirim Permohonan Reservasi</span>
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ============================================================
PAGE: SUCCESS
============================================================ --}}
<div id="page-success" class="page">
    <div class="status-page" style="padding-top:90px;align-items:flex-start;padding-bottom:60px">
        <div class="status-card">
            <div class="status-card-header">
                <div
                    style="font-family:var(--font-display);font-weight:700;font-size:0.88rem;color:rgba(255,255,255,0.7);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">
                    Permohonan Diterima</div>
                <div style="color:white;font-size:0.82rem">Reservasi Anda telah berhasil diajukan ke sistem</div>
            </div>
            <div class="status-card-body">
                <div class="success-icon">&#10003;</div>
                <h2 style="font-size:1.15rem;margin-bottom:6px">Reservasi Berhasil Dikirim</h2>
                <p style="font-size:0.85rem">Kode Reservasi Anda:</p>
                <div class="reservation-code-box" id="successCode">WJY-0000</div>
                <span class="badge badge-waiting mt-12">
                    <span class="badge-dot"></span>
                    Menunggu Persetujuan Admin
                </span>
                <p style="font-size:0.82rem;margin-top:16px;line-height:1.8">
                    Simpan atau screenshot kode reservasi Anda untuk pengecekan status.
                </p>
                <div class="flex gap-8 mt-20" style="justify-content:center;flex-wrap:wrap">
                    <button class="btn btn-primary" onclick="showPage('check')">Cek Status Reservasi</button>
                    <button class="btn btn-outline" onclick="showPage('home')">Kembali ke Beranda</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
PAGE: CEK STATUS
============================================================ --}}
<div id="page-check" class="page content-wrapper">
    <div class="check-container">

        <div class="page-breadcrumb">
            <button onclick="showPage('home')"
                style="background:none;border:none;color:var(--blue-600);cursor:pointer;padding:0;font-size:0.78rem">Beranda</button>
            <span class="sep">/</span>
            <span>Cek Status Reservasi</span>
        </div>

        <div class="page-title-bar">
            <h2>Cek Status Permohonan Reservasi</h2>
            <p>Masukkan kode reservasi yang Anda terima untuk melihat status terkini pengajuan.</p>
        </div>

        <div class="card mb-20">
            <div class="card-body">
                <div class="form-group" style="margin-bottom:10px">
                    <label class="form-label" for="checkCode">Kode Reservasi</label>
                    <div style="display:flex;gap:10px;flex-wrap:wrap">
                        <input type="text" class="form-control" id="checkCode" placeholder="Contoh: WJY-0001"
                            style="flex:1;text-transform:uppercase;font-family:monospace;font-size:1rem;letter-spacing:0.06em"
                            oninput="this.value=this.value.toUpperCase()"
                            onkeydown="if(event.key==='Enter')checkStatus()">
                        <button class="btn btn-primary" onclick="checkStatus()" style="flex-shrink:0">Periksa
                            Status</button>
                    </div>
                    <div class="form-hint">
                        Kode reservasi terdiri dari format WJY-XXXX &nbsp;&bull;&nbsp;
                        Demo: coba kode <strong>WJY-0001</strong>, <strong>WJY-0002</strong>, <strong>WJY-0003</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- Not Found --}}
        <div id="statusNotFound" style="display:none">
            <div class="alert alert-danger">
                <span class="alert-icon">&#10005;</span>
                Kode reservasi tidak ditemukan. Pastikan kode yang dimasukkan sudah benar.
            </div>
        </div>

        {{-- Result --}}
        <div id="statusResult" style="display:none">
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-header-title" style="font-size:1rem" id="srNama">—</div>
                        <div style="font-size:0.76rem;color:var(--gray-400);margin-top:3px" id="srKodeOpd">—</div>
                    </div>
                    <div id="srBadge"></div>
                </div>
                <div class="card-body">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">

                        {{-- Info --}}
                        <div>
                            <div class="panel-label">Detail Reservasi</div>
                            <div class="info-list">
                                <div class="info-row"><span class="info-key">OPD Tujuan</span><span class="info-val"
                                        id="srOpd">—</span></div>
                                <div class="info-row"><span class="info-key">Petugas</span><span class="info-val"
                                        id="srPetugas">—</span></div>
                                <div class="info-row"><span class="info-key">Tanggal</span><span class="info-val"
                                        id="srTanggal">—</span></div>
                                <div class="info-row"><span class="info-key">Jam</span><span class="info-val"
                                        id="srJam">—</span></div>
                                <div class="info-row"><span class="info-key">Keperluan</span><span class="info-val"
                                        id="srTujuan">—</span></div>
                            </div>
                        </div>

                        {{-- Timeline --}}
                        <div>
                            <div class="panel-label">Riwayat Status</div>
                            <div class="timeline" id="srTimeline"></div>
                        </div>
                    </div>

                    {{-- Alasan Penolakan --}}
                    <div id="srAlasanBox" style="display:none;margin-top:16px">
                        <div class="alert alert-danger">
                            <span class="alert-icon">&#9888;</span>
                            <div>
                                <strong style="display:block;margin-bottom:4px">Alasan Penolakan</strong>
                                <span id="srAlasan"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ============================================================
PAGE: LOGIN
============================================================ --}}
<div id="page-login" class="page">
    <div class="login-page">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                        <rect width="24" height="24" rx="3" fill="#0d2859" />
                        <path d="M12 3L4 8v2h16V8L12 3z" fill="#2563eb" />
                        <rect x="5" y="10" width="3" height="8" fill="#2563eb" />
                        <rect x="10.5" y="10" width="3" height="8" fill="#2563eb" />
                        <rect x="16" y="10" width="3" height="8" fill="#2563eb" />
                        <rect x="3" y="18" width="18" height="2" fill="#1e5bb5" />
                    </svg>
                </div>
                <h2>Masuk ke Dashboard Admin</h2>
                <p>SIJAMU — Sistem Informasi Jadwal Tamu</p>
            </div>
            <div class="login-body">
                <div class="alert alert-danger" id="loginError" style="display:none">
                    <span class="alert-icon">&#10005;</span>
                    Username atau kata sandi tidak sesuai.
                </div>
                <div class="form-group">
                    <label class="form-label" for="loginUser">Username</label>
                    <input type="text" class="form-control" id="loginUser" placeholder="Masukkan username" value="admin"
                        autocomplete="username">
                </div>
                <div class="form-group">
                    <label class="form-label" for="loginPass">Kata Sandi</label>
                    <input type="password" class="form-control" id="loginPass" placeholder="Masukkan kata sandi"
                        value="admin123" autocomplete="current-password" onkeydown="if(event.key==='Enter')doLogin()">
                </div>
                <button class="btn btn-primary btn-full btn-lg mt-8" id="btnLogin" onclick="doLogin()">
                    Masuk ke Sistem
                </button>
            </div>
            <div class="login-footer">
                Demo login: <strong>admin</strong> / <strong>admin123</strong>
                &nbsp;&bull;&nbsp;
                <button onclick="showPage('home')"
                    style="background:none;border:none;color:var(--blue-600);cursor:pointer;font-size:0.78rem">Kembali
                    ke Beranda</button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
PAGE: DASHBOARD
============================================================ --}}
<div id="page-dashboard" class="page">
    <div class="dashboard-layout" style="padding-top:0">

        {{-- Sidebar --}}
        <aside class="sidebar" id="dashSidebar">
            <div class="sidebar-inner">
                <div class="sidebar-section-label">Menu Utama</div>
                <div class="sidebar-link active" id="sl-overview" onclick="showDashTab('overview')">
                    <span class="link-icon">&#9632;</span> Overview
                </div>
                <div class="sidebar-link" id="sl-reservasi" onclick="showDashTab('reservasi')">
                    <span class="link-icon">&#9632;</span> Reservasi Tamu
                </div>
                <div class="sidebar-divider"></div>
                <div class="sidebar-section-label">Laporan</div>
                <div class="sidebar-link" id="sl-laporan" onclick="showDashTab('laporan')">
                    <span class="link-icon">&#9632;</span> Laporan OPD
                </div>
                <div class="sidebar-divider"></div>
                <div class="sidebar-section-label">Petugas</div>
                <div class="sidebar-link" id="sl-verifikasi" onclick="showDashTab('verifikasi')">
                    <span class="link-icon">&#9632;</span> Verifikasi Kehadiran
                </div>
                <div class="sidebar-divider"></div>
                <div class="sidebar-section-label">Akun</div>
                <div class="sidebar-link" onclick="doLogout()">
                    <span class="link-icon">&#9632;</span> Keluar dari Sistem
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="dashboard-main">

            {{-- ── TAB: OVERVIEW ── --}}
            <div class="dash-tab-pane" id="tab-overview">
                <div class="flex justify-between items-center mb-24">
                    <div>
                        <h1 style="font-size:1.3rem">Dashboard Overview</h1>
                        <p class="mt-4">Ringkasan aktivitas reservasi tamu hari ini</p>
                    </div>
                    <div style="font-size:0.78rem;color:var(--gray-400)" id="dashDate"></div>
                </div>

                <div class="kpi-grid">
                    <div class="kpi-card amber">
                        <div class="kpi-icon">&#9203;</div>
                        <div class="kpi-content">
                            <div class="kpi-num" id="kpiMenunggu">0</div>
                            <div class="kpi-label">Menunggu Persetujuan</div>
                        </div>
                    </div>
                    <div class="kpi-card green">
                        <div class="kpi-icon">&#10003;</div>
                        <div class="kpi-content">
                            <div class="kpi-num" id="kpiDisetujui">0</div>
                            <div class="kpi-label">Disetujui</div>
                        </div>
                    </div>
                    <div class="kpi-card red">
                        <div class="kpi-icon">&#10005;</div>
                        <div class="kpi-content">
                            <div class="kpi-num" id="kpiDitolak">0</div>
                            <div class="kpi-label">Ditolak</div>
                        </div>
                    </div>
                    <div class="kpi-card blue">
                        <div class="kpi-icon">&#128100;</div>
                        <div class="kpi-content">
                            <div class="kpi-num" id="kpiHadir">0</div>
                            <div class="kpi-label">Tamu Hadir</div>
                        </div>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:20px">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                <div class="icon">&#9642;</div>
                                Grafik Reservasi 7 Hari Terakhir
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <div class="chart-bars" id="chartBars"></div>
                                <div class="chart-labels" id="chartLabels" style="display:flex;gap:8px;margin-top:6px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                <div class="icon">&#9642;</div>
                                Ringkasan Status
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="statusSummary" style="display:flex;flex-direction:column;gap:10px"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            <div class="icon">&#9642;</div>
                            Reservasi Terbaru
                        </div>
                        <button class="btn btn-secondary btn-sm" onclick="showDashTab('reservasi')">Lihat Semua
                            &rarr;</button>
                    </div>
                    <div class="table-wrapper">
                        <table class="data-table" id="recentTable"></table>
                    </div>
                </div>
            </div>

            {{-- ── TAB: RESERVASI ── --}}
            <div class="dash-tab-pane" id="tab-reservasi" style="display:none">
                <div class="flex justify-between items-center mb-24">
                    <div>
                        <h1 style="font-size:1.3rem">Kelola Reservasi Tamu</h1>
                        <p class="mt-4">Tinjau, setujui, atau tolak permohonan reservasi tamu</p>
                    </div>
                </div>

                <div class="flex justify-between items-center flex-wrap gap-12 mb-16">
                    <div class="filter-bar">
                        <button class="filter-chip active" onclick="setFilter('all', this)">Semua</button>
                        <button class="filter-chip" onclick="setFilter('Menunggu', this)">Menunggu</button>
                        <button class="filter-chip" onclick="setFilter('Disetujui', this)">Disetujui</button>
                        <button class="filter-chip" onclick="setFilter('Ditolak', this)">Ditolak</button>
                        <button class="filter-chip" onclick="setFilter('Hadir', this)">Hadir</button>
                    </div>
                    <div class="flex gap-8 items-center">
                        <div class="search-group">
                            <span class="search-icon">&#128269;</span>
                            <input type="text" placeholder="Cari nama, kode, OPD..." oninput="onSearch(this.value)">
                        </div>
                        <span class="text-sm text-muted" id="reservasiCount" style="white-space:nowrap">— Data</span>
                    </div>
                </div>

                <div class="card">
                    <div class="table-wrapper">
                        <table class="data-table" id="mainTable"></table>
                    </div>
                </div>
            </div>

            {{-- ── TAB: LAPORAN ── --}}
            <div class="dash-tab-pane" id="tab-laporan" style="display:none">
                <div class="mb-24">
                    <h1 style="font-size:1.3rem">Laporan Reservasi OPD</h1>
                    <p class="mt-4">Generate laporan rekap reservasi tamu berdasarkan OPD dan periode waktu</p>
                </div>

                <div class="card mb-20">
                    <div class="card-header">
                        <div class="card-header-title">
                            <div class="icon">&#9642;</div>
                            Parameter Laporan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-row form-row-3">
                            <div class="form-group">
                                <label class="form-label">OPD</label>
                                <select class="form-select" id="laporanOpd">
                                    <option value="">Semua OPD</option>
                                    <option>Dinas Pendidikan</option>
                                    <option>Dinas Kesehatan</option>
                                    <option>Dinas Pekerjaan Umum</option>
                                    <option>Dinas Perhubungan</option>
                                    <option>Dinas Komunikasi dan Informatika</option>
                                    <option>Dinas Sosial</option>
                                    <option>Dinas Tenaga Kerja</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Periode</label>
                                <select class="form-select" id="laporanPeriode">
                                    <option>Bulan Ini</option>
                                    <option>3 Bulan Terakhir</option>
                                    <option>6 Bulan Terakhir</option>
                                    <option>Tahun Ini</option>
                                </select>
                            </div>
                            <div class="form-group" style="display:flex;align-items:flex-end">
                                <button class="btn btn-primary btn-full" id="btnGenerate" onclick="generateLaporan()">
                                    Generate Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="laporanResult"></div>
            </div>

            {{-- ── TAB: VERIFIKASI ── --}}
            <div class="dash-tab-pane" id="tab-verifikasi" style="display:none">
                <div class="mb-24">
                    <h1 style="font-size:1.3rem">Verifikasi Kehadiran Tamu</h1>
                    <p class="mt-4">Konfirmasi kehadiran tamu yang telah mendapat persetujuan reservasi</p>
                </div>

                <div class="card mb-20">
                    <div class="card-header">
                        <div class="card-header-title">
                            <div class="icon">&#9642;</div>
                            Pindai / Input Kode Reservasi
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="display:flex;gap:10px;flex-wrap:wrap;max-width:500px">
                            <input type="text" class="form-control" id="verifyCode"
                                placeholder="Masukkan kode reservasi (WJY-XXXX)"
                                style="flex:1;text-transform:uppercase;font-family:monospace;letter-spacing:0.06em"
                                oninput="this.value=this.value.toUpperCase()"
                                onkeydown="if(event.key==='Enter')doVerify()">
                            <button class="btn btn-primary" onclick="doVerify()"
                                style="flex-shrink:0">Verifikasi</button>
                        </div>
                    </div>
                </div>

                <div id="verifyResult" class="mb-20"></div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            <div class="icon">&#9642;</div>
                            Daftar Tamu dengan Reservasi Disetujui
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <table class="data-table" id="verifyScheduleTable"></table>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Set dashboard date
    document.addEventListener('DOMContentLoaded', function () {
        const dateEl = document.getElementById('dashDate');
        if (dateEl) {
            dateEl.textContent = new Date().toLocaleDateString('id-ID', {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
            });
        }

        // Status summary in overview
        function renderStatusSummary() {
            const statuses = [
                { label: 'Menunggu', color: '#b45309', get: () => DB.reservasi.filter(r => r.status === 'Menunggu').length },
                { label: 'Disetujui', color: '#15803d', get: () => DB.reservasi.filter(r => r.status === 'Disetujui').length },
                { label: 'Ditolak', color: '#b91c1c', get: () => DB.reservasi.filter(r => r.status === 'Ditolak').length },
                { label: 'Hadir', color: '#1e5bb5', get: () => DB.reservasi.filter(r => r.status === 'Hadir').length },
                { label: 'Tidak Hadir', color: '#6b7280', get: () => DB.reservasi.filter(r => r.status === 'Tidak Hadir').length },
            ];
            const total = DB.reservasi.length;
            const el = document.getElementById('statusSummary');
            if (!el) return;
            el.innerHTML = statuses.map(s => {
                const count = s.get();
                const pct = total ? Math.round(count / total * 100) : 0;
                return `
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:0.78rem;margin-bottom:4px">
                            <span style="font-weight:600;color:var(--gray-700)">${s.label}</span>
                            <span style="color:var(--gray-500)">${count} (${pct}%)</span>
                        </div>
                        <div style="height:6px;background:var(--gray-200);border-radius:3px;overflow:hidden">
                            <div style="height:100%;width:${pct}%;background:${s.color};border-radius:3px;transition:width 0.4s ease"></div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Override renderOverview to also render summary
        const origRender = window.renderOverview;
        window.renderOverview = function () {
            origRender();
            renderStatusSummary();
        };
    });
</script>
@endpush
@extends('layouts.app')
@section('title','Beranda')
@push('styles')
<style>
  .hero {
    background: var(--blue-900);
    padding: calc(var(--th) + var(--bh) + 52px) 0 52px;
    position: relative;
    overflow: hidden
  }

  .hero::before {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 44px;
    background: var(--gray-50);
    clip-path: ellipse(55% 100% at 50% 100%)
  }

  .hero-pat {
    position: absolute;
    inset: 0;
    opacity: .04;
    background-image: repeating-linear-gradient(0deg, transparent, transparent 47px, rgba(255, 255, 255, .5) 47px, rgba(255, 255, 255, .5) 48px), repeating-linear-gradient(90deg, transparent, transparent 47px, rgba(255, 255, 255, .5) 47px, rgba(255, 255, 255, .5) 48px)
  }

  .hero-c {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 24px;
    text-align: center;
    position: relative;
    z-index: 1
  }

  .hero-ey {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, .1);
    border: 1px solid rgba(255, 255, 255, .15);
    color: var(--blue-300);
    font-size: .76rem;
    font-weight: 600;
    padding: 4px 14px;
    border-radius: 2px;
    letter-spacing: .06em;
    text-transform: uppercase;
    margin-bottom: 20px
  }

  .hero-ttl {
    font-family: var(--font-d);
    font-size: clamp(1.7rem, 4vw, 2.8rem);
    font-weight: 900;
    color: var(--white);
    line-height: 1.25;
    margin-bottom: 14px
  }

  .hero-ttl span {
    color: var(--blue-300)
  }

  .hero-sub {
    font-size: .95rem;
    color: rgba(255, 255, 255, .65);
    max-width: 560px;
    margin: 0 auto 32px;
    line-height: 1.8
  }

  .hero-cta {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap
  }

  .hero-stats {
    max-width: 560px;
    margin: 48px auto 0;
    display: flex;
    background: rgba(255, 255, 255, .06);
    border: 1px solid rgba(255, 255, 255, .1);
    border-radius: var(--r-sm);
    overflow: hidden
  }

  .hst {
    flex: 1;
    padding: 18px 16px;
    text-align: center;
    border-right: 1px solid rgba(255, 255, 255, .08)
  }

  .hst:last-child {
    border-right: none
  }

  .hst-n {
    font-family: var(--font-d);
    font-size: 1.8rem;
    font-weight: 900;
    color: var(--white);
    line-height: 1
  }

  .hst-l {
    font-size: .7rem;
    color: var(--blue-300);
    margin-top: 3px;
    font-weight: 500;
    letter-spacing: .04em
  }

  .feat-sec {
    max-width: 1040px;
    margin: 0 auto;
    padding: 56px 24px
  }

  .sec-hdr {
    text-align: center;
    margin-bottom: 36px
  }

  .sec-ey {
    display: inline-block;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--blue-600);
    border-bottom: 2px solid var(--blue-600);
    padding-bottom: 3px;
    margin-bottom: 10px
  }

  .feat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px
  }

  .feat-card {
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: var(--r-md);
    padding: 22px 20px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
    transition: all .2s;
    display: flex;
    flex-direction: column;
    gap: 10px
  }

  .feat-card:hover {
    box-shadow: var(--sh-md);
    transform: translateY(-2px)
  }

  .feat-step {
    width: 32px;
    height: 32px;
    border-radius: var(--r-sm);
    background: var(--blue-900);
    color: var(--white);
    font-family: var(--font-d);
    font-size: .9rem;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center
  }

  .info-sec {
    background: var(--blue-50);
    border-top: 1px solid var(--blue-100);
    border-bottom: 1px solid var(--blue-100);
    padding: 40px 24px
  }

  .info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    max-width: 880px;
    margin: 0 auto
  }

  /* Responsive styles */
  @media(max-width:640px) {
    .hero {
      padding: calc(var(--th) + var(--bh) + 32px) 0 32px
    }
    
    .hero-cta {
      flex-direction: column;
      align-items: center;
    }
    
    .hero-cta .btn {
      width: 100%;
      max-width: 260px;
    }
    
    .hero-stats {
      flex-direction: column;
      max-width: 260px;
    }
    
    .hst {
      border-right: none !important;
      border-bottom: 1px solid rgba(255, 255, 255, .08);
      padding: 14px 16px;
    }
    
    .hst:last-child {
      border-bottom: none;
    }
    
    .info-grid {
      grid-template-columns: 1fr
    }
    
    .feat-sec {
      padding: 40px 16px
    }
    
    .info-sec {
      padding: 32px 16px
    }
  }
  
  @media(max-width:480px) {
    .hero-ttl {
      font-size: 1.5rem;
    }
    
    .hero-sub {
      font-size: 0.85rem;
    }
    
    .hst-n {
      font-size: 1.5rem;
    }
  }
</style>
@endpush
@section('content')
{{-- HERO --}}
<div style="margin-top:calc(-1*(var(--th) + var(--bh)))">
  <section class="hero">
    <div class="hero-pat"></div>
    <div class="hero-c">
      <div class="hero-ey">Sistem Informasi Resmi Pemerintah Daerah</div>
      <h1 class="hero-ttl">Sistem Reservasi Tamu<br><span>Gedung Wijaya</span></h1>
      <p class="hero-sub">Layanan penjadwalan kunjungan tamu ke Organisasi Perangkat Daerah (OPD) secara digital,
        transparan, dan terorganisir.</p>
      <div class="hero-cta">
        <a href="{{ route('reservasi.form') }}" class="btn btn-primary btn-lg">Buat Reservasi Kunjungan</a>
        <a href="{{ route('cek.form') }}" class="btn btn-secondary btn-lg">Cek Status Reservasi</a>
      </div>
      <div class="hero-stats">
        <div class="hst">
          <div class="hst-n" id="stTotal">{{ $totalReservasi }}</div>
          <div class="hst-l">Total Reservasi</div>
        </div>
        <div class="hst">
          <div class="hst-n" id="stDisetujui">{{ $selesai }}</div>
          <div class="hst-l">Selesai</div>
        </div>
        <div class="hst">
          <div class="hst-n" id="stOpd">{{ $totalOpd }}</div>
          <div class="hst-l">OPD Terdaftar</div>
        </div>
      </div>
    </div>
  </section>
</div>

{{-- CARA RESERVASI --}}
<section class="feat-sec">
  <div class="sec-hdr">
    <div class="sec-ey">Panduan Penggunaan</div>
    <h2 style="font-family:var(--font-d);font-size:1.4rem;color:var(--gray-900);margin-bottom:8px">Cara Membuat
      Reservasi</h2>
    <p style="font-size:.88rem;color:var(--gray-500)">Ikuti empat langkah berikut untuk menjadwalkan kunjungan Anda</p>
  </div>
  <div class="feat-grid">
    <div class="feat-card">
      <div class="feat-step">1</div>
      <h4>Isi Formulir Data Diri</h4>
      <p>Lengkapi identitas diri, nomor kontak, dan email aktif.</p>
    </div>
    <div class="feat-card">
      <div class="feat-step">2</div>
      <h4>Pilih OPD &amp; Jadwal</h4>
      <p>Tentukan OPD yang dituju, tanggal kunjungan, dan sesi waktu yang tersedia.</p>
    </div>
    <div class="feat-card">
      <div class="feat-step">3</div>
      <h4>Lampirkan Dokumen</h4>
      <p>Upload surat pendukung atau berkas terkait bila diperlukan untuk memperkuat pengajuan.</p>
    </div>
    <div class="feat-card">
      <div class="feat-step">4</div>
      <h4>Terima Konfirmasi</h4>
      <p>Kode reservasi akan ditampilkan setelah permohonan berhasil dikirim.</p>
    </div>
  </div>
</section>

{{-- INFO --}}
<div class="info-sec">
  <div class="info-grid">
    <div class="card">
      <div class="card-header">
        <div class="card-htitle">
          <div class="ico">i</div>Ketentuan Kunjungan
        </div>
      </div>
      <div class="card-body" style="font-size:.82rem;color:var(--gray-600)">
        <ul style="padding-left:16px;line-height:2.5">
          <li>Reservasi dibuka setiap hari kerja <strong>(Senin–Jumat)</strong></li>
          <li>Jam pelayanan: <strong>07.00 – 15.30 WIB</strong> &nbsp;|&nbsp; Jumat sampai <strong>14.00 WIB</strong>
          </li>
          <li>Konfirmasi status reservasi dapat dicek secara online</li>
          <li>Hadir tepat waktu sesuai jadwal yang telah disetujui</li>
          <li>Setiap OPD berlokasi <strong>per lantai</strong> di Gedung Wijaya</li>
          <li>Tunjukkan kode reservasi kepada <strong>admin lobi dinas</strong> sesuai OPD tujuan</li>
        </ul>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <div class="card-htitle">
          <div class="ico">@</div>Kontak &amp; Bantuan
        </div>
      </div>
      <div class="card-body" style="font-size:.82rem;color:var(--gray-600)">
        <div style="display:flex;flex-direction:column;gap:12px">
          <div style="display:flex;gap:10px;align-items:flex-start">
            <span style="flex-shrink:0;font-size:1rem">&#128222;</span>
            <div>
              <div style="font-weight:600;color:var(--gray-800);margin-bottom:1px">Telepon</div>
              <div>(0271) 593068</div>
            </div>
          </div>
          <div style="display:flex;gap:10px;align-items:flex-start">
            <span style="flex-shrink:0;font-size:1rem">&#9993;</span>
            <div>
              <div style="font-weight:600;color:var(--gray-800);margin-bottom:1px">Email</div>
              <div>pemkab@sukoharjokab.go.id</div>
            </div>
          </div>
          <div style="display:flex;gap:10px;align-items:flex-start">
            <span style="flex-shrink:0;font-size:1rem">&#128205;</span>
            <div>
              <div style="font-weight:600;color:var(--gray-800);margin-bottom:1px">Alamat</div>
              <div>Gedung Wijaya, Jl. Jenderal Sudirman No. 199, Sukoharjo 57511</div>
            </div>
          </div>
          <div style="display:flex;gap:10px;align-items:flex-start">
            <span style="flex-shrink:0;font-size:1rem">&#128336;</span>
            <div>
              <div style="font-weight:600;color:var(--gray-800);margin-bottom:1px">Jam Layanan</div>
              <div>Senin–Kamis: <strong>07.00 – 15.30 WIB</strong><br>Jumat: <strong>07.00 – 14.00 WIB</strong></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
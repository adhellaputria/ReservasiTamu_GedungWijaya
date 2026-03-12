@extends('layouts.admin')
@section('title','Verifikasi Kehadiran')
@push('styles')
<style>
/* Responsive verification page */
@media (max-width: 768px) {
    .verif-form {
        flex-direction: column;
    }
    
    .verif-form .fc {
        width: 100%;
    }
    
    .verif-form .btn {
        width: 100%;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}

@media (max-width: 640px) {
    .verif-detail {
        flex-direction: column;
    }
    
    .verif-detail > div:first-child {
        text-align: left;
    }
    
    .verif-detail .btn {
        width: 100%;
    }
}
</style>
@endpush
@section('content')
<div class="mb24"><h1 style="font-size:1.3rem">Verifikasi Kehadiran Tamu</h1><p class="mt4">Konfirmasi kehadiran tamu yang telah mendapat persetujuan reservasi</p></div>

<div class="card mb20">
  <div class="card-header"><div class="card-htitle"><div class="ico">&#9642;</div>Input Kode Reservasi</div></div>
  <div class="card-body">
    <form method="GET" action="{{ route('admin.verifikasi.index') }}" class="verif-form" style="display:flex;gap:10px;flex-wrap:wrap;max-width:500px">
      <input type="text" name="kode" class="fc" placeholder="WJY-XXXXXX" style="flex:1;text-transform:uppercase;font-family:'Courier New',monospace;letter-spacing:.06em" value="{{ $verifyCode }}" oninput="this.value=this.value.toUpperCase()">
      <button type="submit" class="btn btn-primary" style="flex-shrink:0">Verifikasi</button>
    </form>
  </div>
</div>

@if($error)
  <div class="alert alert-err mb16"><span class="ai">✕</span><span>{!! $error !!}</span></div>
@endif

@if($found)
<div class="card mb20 verif-detail" style="border-left:4px solid var(--green)">
  <div class="card-body">
    <div class="verif-detail" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
      <div>
        <div style="font-weight:700;font-size:.95rem;color:var(--gray-900)">{{ $found->nama_tamu }}</div>
        <div style="font-size:.78rem;color:var(--gray-400);margin-top:2px">{{ $found->kode }} &middot; {{ $found->opd->nama }}</div>
        <div style="font-size:.82rem;color:var(--gray-600);margin-top:6px">{{ $found->tujuan }}</div>
        <div style="font-size:.78rem;color:var(--gray-400);margin-top:3px">
          {{ \Carbon\Carbon::parse($found->tanggal)->translatedFormat('l, d F Y') }} · {{ $found->jam_kunjungan }} WIB
      </div>
      <form action="{{ route('admin.verifikasi.hadir', $found->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary btn-lg">&#10003; Konfirmasi Hadir</button>
      </form>
    </div>
  </div>
</div>
@endif

<div class="card">
  <div class="card-header"><div class="card-htitle"><div class="ico">&#9642;</div>Tamu Terjadwal — Disetujui ({{ $terjadwal->count() }})</div></div>
<div class="tbl-wrap table-responsive">
    <table class="dtbl">
      <thead><tr><th>Kode</th><th>Nama Tamu</th><th>Tanggal</th><th>Jam</th><th>Aksi</th></tr></thead>
      <tbody>
      @forelse($terjadwal as $r)
      <tr>
        <td><span class="tcode">{{ $r->kode }}</span></td>
        <td><strong style="font-size:.83rem">{{ $r->nama_tamu }}</strong><br><span style="font-size:.76rem;color:var(--gray-400)">{{ $r->instansi ?: $r->email_tamu }}</span></td>
        <td style="font-size:.8rem;white-space:nowrap">{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}</td>
        <td style="font-size:.78rem">{{ $r->jam_kunjungan }} WIB</td>
        <td>
          <form action="{{ route('admin.verifikasi.hadir', $r->id) }}" method="POST" style="margin:0">
            @csrf
            <button type="submit" class="btn btn-success-soft btn-sm">&#10003; Konfirmasi Hadir</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5"><div class="empty-st"><span style="font-size:2rem;display:block;margin-bottom:8px">📋</span><p>Tidak ada tamu terjadwal saat ini.</p></div></td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

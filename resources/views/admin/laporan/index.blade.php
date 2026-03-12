@extends('layouts.admin')
@section('title','Laporan Reservasi')

<?php use Illuminate\Support\Str; ?>
@section('content')
<div class="mb24">
  <h1 style="font-size:1.3rem">Laporan Reservasi</h1>
  <p class="mt4">Laporan rekap kunjungan tamu <strong>{{ $opdNama }}</strong></p>
</div>

<div class="card mb20">
  <div class="card-header">
    <div class="card-htitle">
      <div class="ico">&#9642;</div>Filter Laporan
    </div>
  </div>
  <div class="card-body">
    <form method="GET" action="{{ route('admin.laporan') }}"
      style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:16px;align-items:end">
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Dari Tanggal</label>
        <input type="date" name="dari" class="fc" value="{{ $dari }}">
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Sampai Tanggal</label>
        <input type="date" name="sampai" class="fc" value="{{ $sampai }}">
      </div>
      @if(session('admin_role') === 'admin_utama')
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">OPD</label>
        <select name="opd_id" class="fsel">
          <option value="">Semua OPD</option>
          @foreach($opdList as $opd)
            <option value="{{ $opd->id }}" {{ $opdFilter == $opd->id ? 'selected' : '' }}>
              {{ $opd->nama }}
            </option>
          @endforeach
        </select>
      </div>
      @endif
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Status</label>
        <select name="status" class="fsel">
          <option value="">Semua Status</option>
          <option value="Menunggu" {{ $statusFilter == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
          <option value="Disetujui" {{ $statusFilter == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
          <option value="Ditolak" {{ $statusFilter == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
          <option value="Hadir" {{ $statusFilter == 'Hadir' ? 'selected' : '' }}>Hadir</option>
          <option value="Tidak Hadir" {{ $statusFilter == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
        </select>
      </div>
      <div class="form-group" style="margin-bottom:0">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.laporan') }}" class="btn btn-outline btn-sm">Reset</a>
      </div>
    </form>
  </div>
</div>

@if($data->count() > 0)
<div class="card">
  <div
    style="background:var(--blue-900);color:var(--white);padding:16px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
    <div>
      <div style="font-family:var(--font-d);font-weight:700;font-size:1rem">{{ $opdNama }}</div>
      <div style="font-size:.78rem;color:var(--blue-300);margin-top:4px">
        {{ \Carbon\Carbon::parse($dari)->translatedFormat('d F Y') }} s/d {{
        \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }} &middot; {{ $kpi['total'] }} reservasi
      </div>
    </div>
    <a href="{{ route('admin.laporan.cetak', array_merge(request()->query())) }}" target="_blank"
      class="btn btn-secondary btn-sm">&#11015; Cetak / Unduh PDF</a>
  </div>
  <div class="card-body">
    <div class="kpi-grid" style="grid-template-columns:repeat(5,1fr);margin-bottom:20px">
      <div class="kpi-card kamber">
        <div class="kpi-ico">&#9203;</div>
        <div>
          <div class="kpi-num">{{ $kpi['menunggu'] }}</div>
          <div class="kpi-lbl">Menunggu</div>
        </div>
      </div>
      <div class="kpi-card kgreen">
        <div class="kpi-ico">&#10003;</div>
        <div>
          <div class="kpi-num">{{ $kpi['disetujui'] }}</div>
          <div class="kpi-lbl">Disetujui</div>
        </div>
      </div>
      <div class="kpi-card kred">
        <div class="kpi-ico">&#10007;</div>
        <div>
          <div class="kpi-num">{{ $kpi['ditolak'] }}</div>
          <div class="kpi-lbl">Ditolak</div>
        </div>
      </div>
      <div class="kpi-card kblue">
        <div class="kpi-ico">&#128100;</div>
        <div>
          <div class="kpi-num">{{ $kpi['hadir'] }}</div>
          <div class="kpi-lbl">Hadir</div>
        </div>
      </div>
      <div class="kpi-card" style="background:#f3f4f6;border-color:#9ca3af">
        <div class="kpi-ico" style="background:#e5e7eb;color:#4b5563">&#10145;</div>
        <div>
          <div class="kpi-num" style="color:#374151">{{ $kpi['tidak_hadir'] }}</div>
          <div class="kpi-lbl" style="color:#6b7280">Tidak Hadir</div>
        </div>
      </div>
    </div>
    <div class="tbl-wrap">
      <table class="dtbl">
        <thead>
          <tr>
            <th>Kode</th>
            @if(session('admin_role') === 'admin_utama')
            <th>OPD</th>
            @endif
            <th>Nama Tamu</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Tujuan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $r)
          <tr>
            <td><span class="tcode">{{ $r->kode }}</span></td>
            @if(session('admin_role') === 'admin_utama')
            <td style="font-size:.78rem">{{ $r->opd->nama ?? '—' }}</td>
            @endif
            <td><strong style="font-size:.82rem">{{ $r->nama_tamu }}</strong><br><span
                style="font-size:.74rem;color:var(--gray-400)">{{ $r->instansi }}</span></td>
            <td style="white-space:nowrap;font-size:.8rem">{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}</td>
            <td style="font-size:.78rem">{{ $r->jam_kunjungan }}</td>
            <td style="font-size:.78rem;max-width:180px">{{ Str::limit($r->tujuan, 40) }}</td>
            <td>{!! $r->status_badge !!}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@else
<div class="card">
  <div class="card-body">
    <div class="empty-st"><span style="font-size:2rem;display:block;margin-bottom:8px">&#128202;</span>
      <p>Tidak ada data untuk filter yang dipilih.</p>
    </div>
  </div>
</div>
@endif
@endsection


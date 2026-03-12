@extends('layouts.admin')
@section('title','Dashboard')
@push('styles')
<style>
/* Responsive dashboard header */
@media (max-width: 768px) {
    .dash-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .dash-header .btn {
        width: 100%;
    }
}
</style>
@endpush
@section('content')
<div class="dash-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
  <div>
    <h1 style="font-size:1.3rem">Dashboard Overview</h1>
    <p class="mt4">
      @if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN)
          Ringkasan seluruh aktivitas reservasi dari semua OPD.
      @else
          Ringkasan aktivitas reservasi tamu {{ session('admin_opd_nama') }}.
      @endif
      </p>
  </div>
  <div style="font-size:.78rem;color:var(--gray-400)">{{ now()->translatedFormat('l, d F Y') }}</div>
</div>

<div class="kpi-grid">
  <div class="kpi-card kamber">
    <div class="kpi-ico">⏳</div>
    <div>
      <div class="kpi-num">{{ $kpi['menunggu'] }}</div>
      <div class="kpi-lbl">Menunggu</div>
    </div>
  </div>
  <div class="kpi-card kgreen">
    <div class="kpi-ico">✔</div>
    <div>
      <div class="kpi-num">{{ $kpi['disetujui'] }}</div>
      <div class="kpi-lbl">Disetujui</div>
    </div>
  </div>
  <div class="kpi-card kred">
    <div class="kpi-ico">✕</div>
    <div>
      <div class="kpi-num">{{ $kpi['ditolak'] }}</div>
      <div class="kpi-lbl">Ditolak</div>
    </div>
  </div>
  <div class="kpi-card kblue">
    <div class="kpi-ico">👤</div>
    <div>
      <div class="kpi-num">{{ $kpi['hadir'] }}</div>
      <div class="kpi-lbl">Hadir</div>
    </div>
  </div>
  <div class="kpi-card gray">
    <div class="kpi-ico">➖</div>
    <div>
      <div class="kpi-num">{{ $kpi['tidak_hadir'] }}</div>
      <div class="kpi-lbl">Tidak Hadir</div>
    </div>
  </div>
</div>

<div class="dashboard-charts-grid">
  <div class="card">
    <div class="card-header">
      <div class="card-htitle">
        <div class="ico">&#9642;</div>Reservasi 7 Hari Terakhir
      </div>
    </div>
    <div class="card-body">
      @php $max = max(array_column($grafik,'nilai') ?: [1]); if($max===0)$max=1; @endphp
      <div class="chart-bars">
        @foreach($grafik as $g)
        <div class="chart-bar-wrap">
          <div class="chart-bar-val">{{ $g['nilai'] }}</div>
          <div class="chart-bar-fill" style="height:{{ round(($g['nilai']/$max)*88) }}px;min-height:3px"></div>
          <div class="chart-label">{{ $g['label'] }}</div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <div class="card-htitle">
        <div class="ico">&#9642;</div>Status Ringkas
      </div>
    </div>
    <div class="card-body">
      @php $total = array_sum($kpi); if($total===0)$total=1; @endphp
      @foreach([['Menunggu','menunggu','#d97706'],['Disetujui','disetujui','#15803d'],['Ditolak','ditolak','#b91c1c'],['Hadir','hadir','#1e5bb5'],['Tidak Hadir','tidak_hadir','#6b7280']] as $s)
      @php $pct = round($kpi[$s[1]]/$total*100); @endphp
      <div class="mb12">
        <div class="flex justify-between mb4" style="font-size:.78rem">
          <span style="font-weight:600;color:var(--gray-700)">{{ $s[0] }}</span>
          <span style="color:var(--gray-500)">{{ $kpi[$s[1]] }} ({{ $pct }}%)</span>
        </div>
        <div style="height:6px;background:var(--gray-200);border-radius:3px;overflow:hidden">
          <div style="height:100%;width:{{ $pct }}%;background:{{ $s[2] }};border-radius:3px;transition:width .4s ease"></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-htitle">
      <div class="ico">&#9642;</div>Reservasi Terbaru
    </div>
    <a href="{{ route('admin.reservasi.index') }}" class="btn btn-secondary btn-sm">Lihat Semua &rarr;</a>
  </div>
<div class="tbl-wrap table-responsive">
    <table class="dtbl">
      <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Tamu</th>

            @if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN)
                <th>OPD Tujuan</th>
            @endif

            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
      <tbody>
        @forelse($terbaru as $r)
        <tr>
    <td><span class="tcode">{{ $r->kode }}</span></td>

    <td>
        <strong style="font-size:.83rem">{{ $r->nama_tamu }}</strong><br>
        <span style="font-size:.76rem;color:var(--gray-400)">
            {{ $r->instansi ?: $r->email_tamu }}
        </span>
    </td>

    <td>{{ $r->opd?->nama ?? '-' }}

    <td style="font-size:.8rem;white-space:nowrap">
        {{ $r->tanggal?->translatedFormat('d M Y') }}
    </td>

    <td style="font-size:.78rem">{{ $r->sesi_jam }}</td>

    <td>{!! $r->status_badge !!}</td>

    <td>
        <a href="{{ route('admin.reservasi.detail', $r->id) }}"
           class="btn btn-secondary btn-sm">
           Detail
        </a>
    </td>
</tr>
        @empty
        <tr>
          <td colspan="6">
            <div class="empty-st"><span style="font-size:2rem;display:block;margin-bottom:8px">📋</span>
              <p>Belum ada reservasi.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
@extends('layouts.admin')
@section('title','Detail Reservasi')
@section('content')
<div style="display:flex;align-items:center;gap:12px;margin-bottom:24px">
  <a href="{{ route('admin.reservasi.index') }}" class="btn btn-outline btn-sm">&larr; Kembali</a>
  <h1 style="font-size:1.2rem">Detail Reservasi — <span style="font-family:'Courier New',monospace;color:var(--blue-700)">{{ $reservasi->kode }}</span></h1>
</div>

<div style="display:grid;grid-template-columns:1fr 380px;gap:20px">
  <div>
    <div class="card mb20">
      <div class="card-header">
        <div class="card-htitle"><div class="ico">&#128100;</div>Data Tamu</div>
        <div>{!! $reservasi->status_badge !!}</div>
      </div>
      <div class="card-body">
        <div class="irow"><span class="ikey">Nama Lengkap</span><span class="ival">{{ $reservasi->nama_tamu }}</span></div>
        <div class="irow"><span class="ikey">Nomor HP</span><span class="ival">{{ $reservasi->no_hp }}</span></div>
        <div class="irow"><span class="ikey">Alamat Email</span><span class="ival">{{ $reservasi->email_tamu }}</span></div>
        <div class="irow"><span class="ikey">Instansi</span><span class="ival">{{ $reservasi->instansi ?: '—' }}</span></div>
        <hr class="div">
        <div class="irow"><span class="ikey">OPD Tujuan</span><span class="ival">{{ $reservasi->opd->nama }} (Lantai {{ $reservasi->opd->lantai }})</span></div>
        <div class="irow"><span class="ikey">Petugas Dituju</span><span class="ival">{{ $reservasi->petugas_dituju ?: '—' }}</span></div>
        <div class="irow"><span class="ikey">Tanggal</span><span class="ival">{{ \Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('l, d F Y') }}</span></div>
        <div class="irow"><span class="ikey">Sesi Jam</span><span class="ival">{{ $reservasi->jam_kunjungan }}</span></div>
        @if($reservasi->status === 'Hadir')

        <div class="irow">
        <span class="ikey">Jam Hadir</span>
        <span class="ival">
          {{ $reservasi->jam_hadir ? $reservasi->jam_hadir.' WIB' : '—' }}
        </span>
        </div>

        <div class="irow">
        <span class="ikey">Status Kehadiran</span>
        <span class="ival">

@if(!$reservasi->status_kehadiran)

—

@elseif(str_contains($reservasi->status_kehadiran,'Tepat'))

<span style="color:#16a34a;font-weight:600">
🟢 {{ $reservasi->status_kehadiran }}
</span>

@else

<span style="color:#f59e0b;font-weight:600">
🟠 {{ $reservasi->status_kehadiran }}
</span>

@endif

</span>
        </div>

        @endif
        <div class="irow"><span class="ikey">Tujuan Kunjungan</span><span class="ival">{{ $reservasi->tujuan }}</span></div>
        <div class="irow"><span class="ikey">Keterangan</span><span class="ival">{{ $reservasi->keterangan ?: '—' }}</span></div>
        <div class="irow">
          <span class="ikey">Dokumen</span>
          <span class="ival">
            @if($reservasi->dokumen_path)
              <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                <span>&#128206; {{ $reservasi->dokumen_nama_asli }}</span>
                <a href="{{ route('admin.reservasi.dokumen', $reservasi->id) }}" target="_blank" class="btn btn-secondary btn-sm">&#128065; Buka File</a>
              </div>
            @else
              <span style="color:var(--gray-400)">Tidak ada dokumen terlampir</span>
            @endif
          </span>
        </div>
        <div class="irow"><span class="ikey">Waktu Pengajuan</span><span class="ival">{{ $reservasi->created_at->translatedFormat('d F Y, H:i') }} WIB</span></div>
        @if($reservasi->alasan_tolak)
        <div class="irow"><span class="ikey">Alasan Tolak</span><span class="ival" style="color:var(--red)">{{ $reservasi->alasan_tolak }}</span></div>
        @endif
      </div>
      @if(session('admin_role') == 'admin_opd' && $reservasi->status === 'Menunggu')
      <div class="card-footer" style="justify-content:space-between">
        <span style="font-size:.78rem;color:var(--gray-400)">Permohonan menunggu tindakan</span>
        <div style="display:flex;gap:8px">
          <button type="button" class="btn btn-danger-soft" onclick="document.getElementById('rejectModal').classList.add('show')">Tolak</button>
          <form action="{{ route('admin.reservasi.setujui', $reservasi->id) }}" method="POST" style="margin:0">
            @csrf<button type="submit" class="btn btn-primary">&#10003; Setujui Reservasi</button>
          </form>
        </div>
      </div>
      @endif
    </div>
  </div>

  <div>
    <div class="card">
      <div class="card-header"><div class="card-htitle"><div class="ico">&#9642;</div>Riwayat Status</div></div>
      <div class="card-body">
        @forelse($reservasi->riwayat as $rw)
        <div style="display:flex;gap:10px;margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid var(--gray-100)">
          <div style="width:8px;height:8px;border-radius:50%;background:var(--blue-600);flex-shrink:0;margin-top:6px"></div>
          <div>
            <div style="font-size:.82rem;font-weight:600;color:var(--gray-800)">{{ $rw->status_lama }} → {{ $rw->status_baru }}</div>
            @if($rw->keterangan)<div style="font-size:.78rem;color:var(--gray-500);margin-top:2px">{{ $rw->keterangan }}</div>@endif
            <div style="font-size:.74rem;color:var(--gray-400);margin-top:3px">{{ $rw->created_at->translatedFormat('d M Y, H:i') }} WIB{{ $rw->admin ? ' — '.$rw->admin->nama_lengkap : '' }}</div>
          </div>
        </div>
        @empty
        <p style="font-size:.82rem;color:var(--gray-400)">Belum ada perubahan status.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

{{-- REJECT MODAL --}}
<div class="modal-bd" id="rejectModal">
  <div class="modal">
    <div class="modal-hdr"><span class="modal-ttl">Tolak Reservasi</span><button class="modal-cls" onclick="document.getElementById('rejectModal').classList.remove('show')">&times;</button></div>
    <div class="modal-body">
      <div class="alert alert-warn" style="margin-bottom:14px"><span class="ai">!</span>Tindakan ini akan menolak permohonan. Status akan diperbarui dan tamu dapat cek status secara online.</div>
      <form action="{{ route('admin.reservasi.tolak', $reservasi->id) }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">Alasan Penolakan</label>
          <textarea name="alasan" class="fta" placeholder="Contoh: Jadwal penuh, mohon reschedule..."></textarea>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('rejectModal').classList.remove('show')">Batal</button>
          <button type="submit" class="btn btn-danger">Tolak Reservasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('rejectModal').addEventListener('click',function(e){if(e.target===this)this.classList.remove('show');});
</script>
@endpush

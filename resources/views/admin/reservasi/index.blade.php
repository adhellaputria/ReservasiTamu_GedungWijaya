@extends('layouts.admin')
@section('title','Kelola Reservasi')
@push('styles')
<style>
/* Responsive filter bar */
.filter-bar {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.search-group {
    display: flex;
    align-items: center;
    background: var(--white);
    border: 1.5px solid var(--gray-300);
    border-radius: var(--radius-sm);
    overflow: hidden;
    transition: border-color 0.15s;
}

.search-group:focus-within {
    border-color: var(--blue-500);
}

.search-group input {
    border: none;
    padding: 7px 12px;
    font-size: 0.83rem;
    flex: 1;
    outline: none;
    background: transparent;
    font-family: var(--font-body);
    color: var(--gray-700);
    min-width: 160px;
}

.search-icon {
    padding: 0 10px 0 12px;
    color: var(--gray-400);
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-bar {
        flex-direction: column;
    }
    
    .filter-bar > div {
        width: 100%;
    }
    
    .search-group {
        width: 100%;
    }
    
    .search-group input {
        width: 100%;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .card-header .btn {
        width: 100%;
    }
}

@media (max-width: 640px) {
    .fchip {
        flex: 1;
        text-align: center;
        min-width: 70px;
    }
}
</style>
@endpush
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-size:1.3rem">
  @if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN)
      Semua Reservasi Tamu
  @else
      Kelola Reservasi Tamu
  @endif
  </h1>

  <p class="mt4">
  @if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN)
      Lihat seluruh data reservasi dari semua OPD.
  @else
      Tinjau, setujui, atau tolak permohonan reservasi OPD Anda.
  @endif
  </p>
</div>

<form method="GET" action="{{ route('admin.reservasi.index') }}" class="filter-bar">

    <div class="filter-chips">
        <a href="{{ route('admin.reservasi.index') }}" 
           class="fchip {{ !request('status') ? 'active' : '' }}">
           Semua
        </a>

        @foreach(['Menunggu','Disetujui','Ditolak','Hadir','Tidak Hadir'] as $st)
            <a href="{{ route('admin.reservasi.index', ['status'=>$st, 'q'=>request('q')]) }}" 
               class="fchip {{ request('status')===$st ? 'active' : '' }}">
               {{ $st }}
            </a>
        @endforeach
    </div>

    <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" name="q" placeholder="Cari nama, kode..." value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    </div>

</form>

<div class="card">
<div class="tbl-wrap table-responsive">
    <table class="dtbl">
      <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Tamu / Instansi</th>

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

    @forelse($reservasi as $r)
    <tr>
        <td><span class="tcode">{{ $r->kode }}</span></td>

        <td>
            <strong style="font-size:.83rem">{{ $r->nama_tamu }}</strong><br>
            <span style="font-size:.76rem;color:var(--gray-400)">
                {{ $r->instansi ?: $r->email_tamu }}
            </span>
        </td>

        @if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN)
            <td style="font-size:.8rem">
                {{ $r->opd->nama ?? '-' }}
            </td>
        @endif

        <td style="font-size:.8rem;white-space:nowrap">
            {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}
        </td>

        <td style="font-size:.78rem">{{ $r->sesi_jam }}</td>

        <td>{!! $r->status_badge !!}</td>

        <td>
          <div style="display:flex;gap:5px">

            <a href="{{ route('admin.reservasi.detail', $r->id) }}"
              class="btn btn-secondary btn-sm">
              Detail
            </a>

            @if(
                session('admin_role') === \App\Models\Admin::ROLE_ADMIN_OPD
                && $r->status === 'Menunggu'
            )

                <form action="{{ route('admin.reservasi.setujui', $r->id) }}"
                      method="POST" style="margin:0">
                    @csrf
                    <button type="submit"
                            class="btn btn-success-soft btn-sm">
                        Setujui
                    </button>
                </form>

                <button type="button"
                        class="btn btn-danger-soft btn-sm"
                        onclick="openRejectModal({{ $r->id }})">
                    Tolak
                </button>

            @endif

          </div>
        </td>
    </tr>

    @empty
    <tr>
    <td colspan="{{ session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN ? 7 : 6 }}">
        <div class="empty-st">
            <span style="font-size:2rem;display:block;margin-bottom:8px">📋</span>
            <p>Tidak ada data reservasi.</p>
        </div>
    </td>
    </tr>
    @endforelse
  </tbody>
    </table>
  </div>
  @if($reservasi->hasPages())
  <div style="padding:12px 20px;border-top:1px solid var(--gray-200)">{{ $reservasi->links() }}</div>
  @endif
</div>

{{-- REJECT MODAL --}}
<div class="modal-bd" id="rejectModal">
  <div class="modal">
    <div class="modal-hdr"><span class="modal-ttl">Tolak Reservasi</span><button class="modal-cls" onclick="closeModal()">&times;</button></div>
    <div class="modal-body">
      <div class="alert alert-warn" style="margin-bottom:14px"><span class="ai">!</span>Tindakan ini akan menolak pengajuan reservasi. Status akan diperbarui dan tamu dapat cek status secara online.</div>
      <form id="rejectForm" action="" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">Alasan Penolakan <span style="color:var(--gray-400);font-weight:400">(opsional)</span></label>
          <textarea name="alasan" class="fta" placeholder="Contoh: Jadwal pejabat penuh hingga akhir bulan..." rows="3"></textarea>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
          <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
          <button type="submit" class="btn btn-danger">Tolak Reservasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function openRejectModal(id){
  document.getElementById('rejectForm').action='/admin/reservasi/'+id+'/tolak';
  document.getElementById('rejectModal').classList.add('show');
}
function closeModal(){document.getElementById('rejectModal').classList.remove('show');}
document.getElementById('rejectModal').addEventListener('click',function(e){if(e.target===this)closeModal();});
</script>
@endpush

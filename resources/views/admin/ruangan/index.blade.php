@extends('layouts.admin')
@section('title','Kelola Ruangan / OPD')
@section('content')
<div class="page-header">
  <div class="mb20">
    <h2>Kelola Ruangan / OPD</h2>
    <p>Kelola data ruangan atau OPD yang dapat menerima reservasi.</p>
  </div>
</div>

<div class="card">
      <div class="card-header" style="display:flex;justify-content:space-between;align-items:center">
        
        <div class="card-htitle">
            <div class="ico">&#127968;</div>
            Daftar Ruangan / OPD
        </div>

        <a href="{{ route('admin.ruangan.create') }}" 
          class="btn btn-primary btn-sm">
          + Tambah OPD
        </a>
  </div>
  <div class="card-body">
    <form method="GET" class="mb20" style="display:flex;gap:12px">
      <input type="text" name="q" class="fc" placeholder="Cari nama atau kode..." value="{{ request('q') }}" style="max-width:280px">
      <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    </form>

    <div class="tbl-wrap">
      <table class="dtbl">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama OPD</th>
            <th>Lantai</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($ruangan as $opd)
          <tr>
            <td class="tcode">{{ $opd->kode }}</td>
            <td><strong>{{ $opd->nama }}</strong></td>
            <td>{{ $opd->lantai }}</td>
            <td>{{ $opd->telepon ?? '—' }}</td>
            <td>{{ $opd->email_opd ?? '—' }}</td>
            <td>
              @if($opd->is_aktif)
                <span class="badge ba"><span class="bdot"></span>Aktif</span>
              @else
                <span class="badge br"><span class="bdot"></span>Nonaktif</span>
              @endif
            </td>
            <td>
              <div style="display:flex;gap:6px">
                  <a href="{{ route('admin.ruangan.edit', $opd->id) }}" 
                    class="btn btn-secondary btn-sm">
                    Edit
                  </a>

                  <form action="{{ route('admin.ruangan.destroy', $opd->id) }}" 
                        method="POST" 
                        onsubmit="return confirm('Yakin ingin menghapus OPD ini?')"
                        style="margin:0">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">
                          Hapus
                      </button>
                  </form>
              </div>
          </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="empty-st">Belum ada ruangan/OPD.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection


@extends('layouts.admin')
@section('title','Kelola Admin OPD')
@section('content')
<div class="page-header">
  <div class="mb20">
    <h2>Kelola Admin OPD</h2>
    <p>Tambah, edit, atau hapus akun admin untuk setiap OPD.</p>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-htitle">
      <div class="ico">&#128100;</div>
      Daftar Admin OPD
    </div>
    <a href="{{ route('admin.opd-admin.create') }}" class="btn btn-primary btn-sm">
      + Tambah Admin
    </a>
  </div>
  <div class="card-body">
    <form method="GET" class="mb20" style="display:flex;flex-direction:column;gap:12px;max-width:300px">

      <input type="text" 
            name="q" 
            class="fc" 
            placeholder="Cari nama, username, email..." 
            value="{{ request('q') }}">

      <select name="opd_id" class="fsel">
          <option value="">Semua OPD</option>
          @foreach($opdList as $opd)
              <option value="{{ $opd->id }}" 
                  {{ request('opd_id') == $opd->id ? 'selected' : '' }}>
                  {{ $opd->nama }}
              </option>
          @endforeach
      </select>

      <button type="submit" class="btn btn-primary btn-sm">
          Cari
      </button>

    </form>

    <div class="tbl-wrap">
      <table class="dtbl">
        <thead>
          <tr>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Email</th>
            <th>OPD</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($admins as $admin)
          <tr>
            <td><strong>{{ $admin->nama_lengkap }}</strong></td>
            <td class="tcode">{{ $admin->username }}</td>
            <td>{{ $admin->email ?? '—' }}</td>
            <td>{{ $admin->opd->nama ?? '—' }}</td>
            <td>
              @if($admin->is_aktif)
                <span class="badge ba"><span class="bdot"></span>Aktif</span>
              @else
                <span class="badge br"><span class="bdot"></span>Nonaktif</span>
              @endif
            </td>
            <td>
              <div style="display:flex;gap:6px">
                <a href="{{ route('admin.opd-admin.edit', $admin->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form action="{{ route('admin.opd-admin.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin hapus admin ini?')" style="margin:0">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger-soft btn-sm">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="empty-st">Belum ada admin OPD.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection


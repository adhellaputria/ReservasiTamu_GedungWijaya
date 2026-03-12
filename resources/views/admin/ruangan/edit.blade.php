@extends('layouts.admin')
@section('title','Edit Ruangan / OPD')
@section('content')
<div class="page-header">
  <div class="mb20">
    <a href="{{ route('admin.ruangan.index') }}" class="btn btn-outline btn-sm">&larr; Kembali</a>
    <h2 class="mt12">Edit Ruangan / OPD</h2>
  </div>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    <form action="{{ route('admin.ruangan.update', $opd->id) }}" method="POST">
      @csrf
      @method('PUT')
      
      <div class="form-group">
        <label class="form-label">Nama OPD <span class="req">*</span></label>
        <input type="text" name="nama" class="fc @error('nama') is-invalid @enderror" value="{{ old('nama', $opd->nama) }}" required>
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Lantai <span class="req">*</span></label>
        <input type="number" name="lantai" class="fc @error('lantai') is-invalid @enderror" value="{{ old('lantai', $opd->lantai) }}" required min="1" max="20">
        @error('lantai')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Telepon</label>
        <input type="text" name="telepon" class="fc @error('telepon') is-invalid @enderror" value="{{ old('telepon', $opd->telepon) }}">
        @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Email OPD</label>
        <input type="email" name="email_opd" class="fc @error('email_opd') is-invalid @enderror" value="{{ old('email_opd', $opd->email_opd) }}">
        @error('email_opd')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_aktif" class="fsel">
          <option value="1" {{ old('is_aktif', $opd->is_aktif) == 1 ? 'selected' : '' }}>Aktif</option>
          <option value="0" {{ old('is_aktif', $opd->is_aktif) == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>

      <hr class="div">

      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('admin.ruangan.index') }}" class="btn btn-outline">Batal</a>
    </form>
  </div>
</div>
@endsection


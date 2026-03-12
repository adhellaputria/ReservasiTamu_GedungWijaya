@extends('layouts.admin')
@section('title','Edit Admin OPD')
@section('content')
<div class="page-header">
  <div class="mb20">
    <a href="{{ route('admin.opd-admin.index') }}" class="btn btn-outline btn-sm">&larr; Kembali</a>
    <h2 class="mt12">Edit Admin OPD</h2>
  </div>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    <form action="{{ route('admin.opd-admin.update', $admin->id) }}" method="POST">
      @csrf
      @method('PUT')
      
      <div class="form-group">
        <label class="form-label">Nama Lengkap <span class="req">*</span></label>
        <input type="text" name="nama_lengkap" class="fc @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $admin->nama_lengkap) }}" required>
        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Username <span class="req">*</span></label>
        <input type="text" name="username" class="fc @error('username') is-invalid @enderror" value="{{ old('username', $admin->username) }}" required>
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="fc @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ingin mengubah">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="fc @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">OPD <span class="req">*</span></label>
        <select name="opd_id" class="fsel @error('opd_id') is-invalid @enderror" required>
          <option value="">— Pilih OPD —</option>
          @foreach($opdList as $opd)
            <option value="{{ $opd->id }}" {{ old('opd_id', $admin->opd_id) == $opd->id ? 'selected' : '' }}>
              {{ $opd->nama }}
            </option>
          @endforeach
        </select>
        @error('opd_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_aktif" class="fsel">
          <option value="1" {{ old('is_aktif', $admin->is_aktif) == 1 ? 'selected' : '' }}>Aktif</option>
          <option value="0" {{ old('is_aktif', $admin->is_aktif) == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
      </div>

      <hr class="div">

      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('admin.opd-admin.index') }}" class="btn btn-outline">Batal</a>
    </form>
  </div>
</div>
@endsection


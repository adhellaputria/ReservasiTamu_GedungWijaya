@extends('layouts.admin')
@section('title','Tambah Admin OPD')
@section('content')
<div class="page-header">
  <div class="mb20">
    <a href="{{ route('admin.opd-admin.index') }}" class="btn btn-outline btn-sm">&larr; Kembali</a>
    <h2 class="mt12">Tambah Admin OPD</h2>
  </div>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    <form action="{{ route('admin.opd-admin.store') }}" method="POST">
      @csrf
      
      <div class="form-group">
        <label class="form-label">Nama Lengkap <span class="req">*</span></label>
        <input type="text" name="nama_lengkap" class="fc @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Username <span class="req">*</span></label>
        <input type="text" name="username" class="fc @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Password <span class="req">*</span></label>
        <input type="password" name="password" class="fc @error('password') is-invalid @enderror" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="fc @error('email') is-invalid @enderror" value="{{ old('email') }}">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">OPD <span class="req">*</span></label>
        <select name="opd_id" class="fsel @error('opd_id') is-invalid @enderror" required>
          <option value="">— Pilih OPD —</option>
          @foreach($opdList as $opd)
            <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
              {{ $opd->nama }}
            </option>
          @endforeach
        </select>
        @error('opd_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <hr class="div">

      <button type="submit" class="btn btn-primary">Simpan Admin</button>
      <a href="{{ route('admin.opd-admin.index') }}" class="btn btn-outline">Batal</a>
    </form>
  </div>
</div>
@endsection


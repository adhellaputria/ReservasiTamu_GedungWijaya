@extends('layouts.admin')
@section('title','Tambah Ruangan / OPD')
@section('content')

<div class="mb20">
  <a href="{{ route('admin.ruangan.index') }}" class="btn btn-outline btn-sm">&larr; Kembali</a>
  <h2 class="mt12">Tambah Ruangan / OPD</h2>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    <form action="{{ route('admin.ruangan.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label class="form-label">Kode OPD *</label>
        <input type="text" name="kode" class="fc" required>
      </div>

      <div class="form-group">
        <label class="form-label">Nama OPD *</label>
        <input type="text" name="nama" class="fc" required>
      </div>

      <div class="form-group">
        <label class="form-label">Lantai *</label>
        <input type="number" name="lantai" class="fc" required min="1">
      </div>

      <div class="form-group">
        <label class="form-label">Telepon</label>
        <input type="text" name="telepon" class="fc">
      </div>

      <div class="form-group">
        <label class="form-label">Email OPD</label>
        <input type="email" name="email_opd" class="fc">
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection
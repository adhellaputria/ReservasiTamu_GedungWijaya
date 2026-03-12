<?php $__env->startSection('title','Tambah Ruangan / OPD'); ?>
<?php $__env->startSection('content'); ?>

<div class="mb20">
  <a href="<?php echo e(route('admin.ruangan.index')); ?>" class="btn btn-outline btn-sm">&larr; Kembali</a>
  <h2 class="mt12">Tambah Ruangan / OPD</h2>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    <form action="<?php echo e(route('admin.ruangan.store')); ?>" method="POST">
      <?php echo csrf_field(); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/admin/ruangan/create.blade.php ENDPATH**/ ?>
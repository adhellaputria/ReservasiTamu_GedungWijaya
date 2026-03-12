<?php $__env->startSection('title','Edit Ruangan / OPD'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
  <div class="mb20">
    <a href="<?php echo e(route('admin.ruangan.index')); ?>" class="btn btn-outline btn-sm">&larr; Kembali</a>
    <h2 class="mt12">Edit Ruangan / OPD</h2>
  </div>
</div>

<div class="card" style="max-width:600px">
  <div class="card-body">
    <form action="<?php echo e(route('admin.ruangan.update', $opd->id)); ?>" method="POST">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>
      
      <div class="form-group">
        <label class="form-label">Nama OPD <span class="req">*</span></label>
        <input type="text" name="nama" class="fc <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama', $opd->nama)); ?>" required>
        <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-group">
        <label class="form-label">Lantai <span class="req">*</span></label>
        <input type="number" name="lantai" class="fc <?php $__errorArgs = ['lantai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('lantai', $opd->lantai)); ?>" required min="1" max="20">
        <?php $__errorArgs = ['lantai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-group">
        <label class="form-label">Telepon</label>
        <input type="text" name="telepon" class="fc <?php $__errorArgs = ['telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('telepon', $opd->telepon)); ?>">
        <?php $__errorArgs = ['telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-group">
        <label class="form-label">Email OPD</label>
        <input type="email" name="email_opd" class="fc <?php $__errorArgs = ['email_opd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email_opd', $opd->email_opd)); ?>">
        <?php $__errorArgs = ['email_opd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="is_aktif" class="fsel">
          <option value="1" <?php echo e(old('is_aktif', $opd->is_aktif) == 1 ? 'selected' : ''); ?>>Aktif</option>
          <option value="0" <?php echo e(old('is_aktif', $opd->is_aktif) == 0 ? 'selected' : ''); ?>>Nonaktif</option>
        </select>
      </div>

      <hr class="div">

      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="<?php echo e(route('admin.ruangan.index')); ?>" class="btn btn-outline">Batal</a>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/admin/ruangan/edit.blade.php ENDPATH**/ ?>
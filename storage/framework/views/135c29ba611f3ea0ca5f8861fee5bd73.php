<?php $__env->startSection('title','Kelola Admin OPD'); ?>
<?php $__env->startSection('content'); ?>
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
    <a href="<?php echo e(route('admin.opd-admin.create')); ?>" class="btn btn-primary btn-sm">
      + Tambah Admin
    </a>
  </div>
  <div class="card-body">
    <form method="GET" class="mb20" style="display:flex;flex-direction:column;gap:12px;max-width:300px">

      <input type="text" 
            name="q" 
            class="fc" 
            placeholder="Cari nama, username, email..." 
            value="<?php echo e(request('q')); ?>">

      <select name="opd_id" class="fsel">
          <option value="">Semua OPD</option>
          <?php $__currentLoopData = $opdList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($opd->id); ?>" 
                  <?php echo e(request('opd_id') == $opd->id ? 'selected' : ''); ?>>
                  <?php echo e($opd->nama); ?>

              </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
          <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><strong><?php echo e($admin->nama_lengkap); ?></strong></td>
            <td class="tcode"><?php echo e($admin->username); ?></td>
            <td><?php echo e($admin->email ?? '—'); ?></td>
            <td><?php echo e($admin->opd->nama ?? '—'); ?></td>
            <td>
              <?php if($admin->is_aktif): ?>
                <span class="badge ba"><span class="bdot"></span>Aktif</span>
              <?php else: ?>
                <span class="badge br"><span class="bdot"></span>Nonaktif</span>
              <?php endif; ?>
            </td>
            <td>
              <div style="display:flex;gap:6px">
                <a href="<?php echo e(route('admin.opd-admin.edit', $admin->id)); ?>" class="btn btn-secondary btn-sm">Edit</a>
                <form action="<?php echo e(route('admin.opd-admin.destroy', $admin->id)); ?>" method="POST" onsubmit="return confirm('Yakin hapus admin ini?')" style="margin:0">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn btn-danger-soft btn-sm">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="6" class="empty-st">Belum ada admin OPD.</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/admin/opd-admin/index.blade.php ENDPATH**/ ?>
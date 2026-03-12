<?php $__env->startSection('title','Kelola Ruangan / OPD'); ?>
<?php $__env->startSection('content'); ?>
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

        <a href="<?php echo e(route('admin.ruangan.create')); ?>" 
          class="btn btn-primary btn-sm">
          + Tambah OPD
        </a>
  </div>
  <div class="card-body">
    <form method="GET" class="mb20" style="display:flex;gap:12px">
      <input type="text" name="q" class="fc" placeholder="Cari nama atau kode..." value="<?php echo e(request('q')); ?>" style="max-width:280px">
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
          <?php $__empty_1 = true; $__currentLoopData = $ruangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td class="tcode"><?php echo e($opd->kode); ?></td>
            <td><strong><?php echo e($opd->nama); ?></strong></td>
            <td><?php echo e($opd->lantai); ?></td>
            <td><?php echo e($opd->telepon ?? '—'); ?></td>
            <td><?php echo e($opd->email_opd ?? '—'); ?></td>
            <td>
              <?php if($opd->is_aktif): ?>
                <span class="badge ba"><span class="bdot"></span>Aktif</span>
              <?php else: ?>
                <span class="badge br"><span class="bdot"></span>Nonaktif</span>
              <?php endif; ?>
            </td>
            <td>
              <div style="display:flex;gap:6px">
                  <a href="<?php echo e(route('admin.ruangan.edit', $opd->id)); ?>" 
                    class="btn btn-secondary btn-sm">
                    Edit
                  </a>

                  <form action="<?php echo e(route('admin.ruangan.destroy', $opd->id)); ?>" 
                        method="POST" 
                        onsubmit="return confirm('Yakin ingin menghapus OPD ini?')"
                        style="margin:0">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="btn btn-danger btn-sm">
                          Hapus
                      </button>
                  </form>
              </div>
          </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="7" class="empty-st">Belum ada ruangan/OPD.</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/admin/ruangan/index.blade.php ENDPATH**/ ?>
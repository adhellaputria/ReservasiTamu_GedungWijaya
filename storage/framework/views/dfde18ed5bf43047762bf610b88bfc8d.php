<?php $__env->startSection('title','Verifikasi Kehadiran'); ?>
<?php $__env->startPush('styles'); ?>
<style>
/* Responsive verification page */
@media (max-width: 768px) {
    .verif-form {
        flex-direction: column;
    }
    
    .verif-form .fc {
        width: 100%;
    }
    
    .verif-form .btn {
        width: 100%;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}

@media (max-width: 640px) {
    .verif-detail {
        flex-direction: column;
    }
    
    .verif-detail > div:first-child {
        text-align: left;
    }
    
    .verif-detail .btn {
        width: 100%;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="mb24"><h1 style="font-size:1.3rem">Verifikasi Kehadiran Tamu</h1><p class="mt4">Konfirmasi kehadiran tamu yang telah mendapat persetujuan reservasi</p></div>

<div class="card mb20">
  <div class="card-header"><div class="card-htitle"><div class="ico">&#9642;</div>Input Kode Reservasi</div></div>
  <div class="card-body">
    <form method="GET" action="<?php echo e(route('admin.verifikasi.index')); ?>" class="verif-form" style="display:flex;gap:10px;flex-wrap:wrap;max-width:500px">
      <input type="text" name="kode" class="fc" placeholder="WJY-XXXXXX" style="flex:1;text-transform:uppercase;font-family:'Courier New',monospace;letter-spacing:.06em" value="<?php echo e($verifyCode); ?>" oninput="this.value=this.value.toUpperCase()">
      <button type="submit" class="btn btn-primary" style="flex-shrink:0">Verifikasi</button>
    </form>
  </div>
</div>

<?php if($error): ?>
  <div class="alert alert-err mb16"><span class="ai">✕</span><span><?php echo $error; ?></span></div>
<?php endif; ?>

<?php if($found): ?>
<div class="card mb20 verif-detail" style="border-left:4px solid var(--green)">
  <div class="card-body">
    <div class="verif-detail" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
      <div>
        <div style="font-weight:700;font-size:.95rem;color:var(--gray-900)"><?php echo e($found->nama_tamu); ?></div>
        <div style="font-size:.78rem;color:var(--gray-400);margin-top:2px"><?php echo e($found->kode); ?> &middot; <?php echo e($found->opd->nama); ?></div>
        <div style="font-size:.82rem;color:var(--gray-600);margin-top:6px"><?php echo e($found->tujuan); ?></div>
        <div style="font-size:.78rem;color:var(--gray-400);margin-top:3px">
          <?php echo e(\Carbon\Carbon::parse($found->tanggal)->translatedFormat('l, d F Y')); ?> · <?php echo e($found->jam_kunjungan); ?> WIB
      </div>
      <form action="<?php echo e(route('admin.verifikasi.hadir', $found->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-primary btn-lg">&#10003; Konfirmasi Hadir</button>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="card">
  <div class="card-header"><div class="card-htitle"><div class="ico">&#9642;</div>Tamu Terjadwal — Disetujui (<?php echo e($terjadwal->count()); ?>)</div></div>
<div class="tbl-wrap table-responsive">
    <table class="dtbl">
      <thead><tr><th>Kode</th><th>Nama Tamu</th><th>Tanggal</th><th>Jam</th><th>Aksi</th></tr></thead>
      <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $terjadwal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr>
        <td><span class="tcode"><?php echo e($r->kode); ?></span></td>
        <td><strong style="font-size:.83rem"><?php echo e($r->nama_tamu); ?></strong><br><span style="font-size:.76rem;color:var(--gray-400)"><?php echo e($r->instansi ?: $r->email_tamu); ?></span></td>
        <td style="font-size:.8rem;white-space:nowrap"><?php echo e(\Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y')); ?></td>
        <td style="font-size:.78rem"><?php echo e($r->jam_kunjungan); ?> WIB</td>
        <td>
          <form action="<?php echo e(route('admin.verifikasi.hadir', $r->id)); ?>" method="POST" style="margin:0">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-success-soft btn-sm">&#10003; Konfirmasi Hadir</button>
          </form>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr><td colspan="5"><div class="empty-st"><span style="font-size:2rem;display:block;margin-bottom:8px">📋</span><p>Tidak ada tamu terjadwal saat ini.</p></div></td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/admin/verifikasi/index.blade.php ENDPATH**/ ?>
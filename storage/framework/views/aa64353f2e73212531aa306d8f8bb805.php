<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startPush('styles'); ?>
<style>
/* Responsive dashboard header */
@media (max-width: 768px) {
    .dash-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .dash-header .btn {
        width: 100%;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="dash-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
  <div>
    <h1 style="font-size:1.3rem">Dashboard Overview</h1>
    <p class="mt4">
      <?php if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN): ?>
          Ringkasan seluruh aktivitas reservasi dari semua OPD.
      <?php else: ?>
          Ringkasan aktivitas reservasi tamu <?php echo e(session('admin_opd_nama')); ?>.
      <?php endif; ?>
      </p>
  </div>
  <div style="font-size:.78rem;color:var(--gray-400)"><?php echo e(now()->translatedFormat('l, d F Y')); ?></div>
</div>

<div class="kpi-grid">
  <div class="kpi-card kamber">
    <div class="kpi-ico">⏳</div>
    <div>
      <div class="kpi-num"><?php echo e($kpi['menunggu']); ?></div>
      <div class="kpi-lbl">Menunggu</div>
    </div>
  </div>
  <div class="kpi-card kgreen">
    <div class="kpi-ico">✔</div>
    <div>
      <div class="kpi-num"><?php echo e($kpi['disetujui']); ?></div>
      <div class="kpi-lbl">Disetujui</div>
    </div>
  </div>
  <div class="kpi-card kred">
    <div class="kpi-ico">✕</div>
    <div>
      <div class="kpi-num"><?php echo e($kpi['ditolak']); ?></div>
      <div class="kpi-lbl">Ditolak</div>
    </div>
  </div>
  <div class="kpi-card kblue">
    <div class="kpi-ico">👤</div>
    <div>
      <div class="kpi-num"><?php echo e($kpi['hadir']); ?></div>
      <div class="kpi-lbl">Hadir</div>
    </div>
  </div>
  <div class="kpi-card gray">
    <div class="kpi-ico">➖</div>
    <div>
      <div class="kpi-num"><?php echo e($kpi['tidak_hadir']); ?></div>
      <div class="kpi-lbl">Tidak Hadir</div>
    </div>
  </div>
</div>

<div class="dashboard-charts-grid">
  <div class="card">
    <div class="card-header">
      <div class="card-htitle">
        <div class="ico">&#9642;</div>Reservasi 7 Hari Terakhir
      </div>
    </div>
    <div class="card-body">
      <?php $max = max(array_column($grafik,'nilai') ?: [1]); if($max===0)$max=1; ?>
      <div class="chart-bars">
        <?php $__currentLoopData = $grafik; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="chart-bar-wrap">
          <div class="chart-bar-val"><?php echo e($g['nilai']); ?></div>
          <div class="chart-bar-fill" style="height:<?php echo e(round(($g['nilai']/$max)*88)); ?>px;min-height:3px"></div>
          <div class="chart-label"><?php echo e($g['label']); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <div class="card-htitle">
        <div class="ico">&#9642;</div>Status Ringkas
      </div>
    </div>
    <div class="card-body">
      <?php $total = array_sum($kpi); if($total===0)$total=1; ?>
      <?php $__currentLoopData = [['Menunggu','menunggu','#d97706'],['Disetujui','disetujui','#15803d'],['Ditolak','ditolak','#b91c1c'],['Hadir','hadir','#1e5bb5'],['Tidak Hadir','tidak_hadir','#6b7280']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php $pct = round($kpi[$s[1]]/$total*100); ?>
      <div class="mb12">
        <div class="flex justify-between mb4" style="font-size:.78rem">
          <span style="font-weight:600;color:var(--gray-700)"><?php echo e($s[0]); ?></span>
          <span style="color:var(--gray-500)"><?php echo e($kpi[$s[1]]); ?> (<?php echo e($pct); ?>%)</span>
        </div>
        <div style="height:6px;background:var(--gray-200);border-radius:3px;overflow:hidden">
          <div style="height:100%;width:<?php echo e($pct); ?>%;background:<?php echo e($s[2]); ?>;border-radius:3px;transition:width .4s ease"></div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-htitle">
      <div class="ico">&#9642;</div>Reservasi Terbaru
    </div>
    <a href="<?php echo e(route('admin.reservasi.index')); ?>" class="btn btn-secondary btn-sm">Lihat Semua &rarr;</a>
  </div>
<div class="tbl-wrap table-responsive">
    <table class="dtbl">
      <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Tamu</th>

            <?php if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN): ?>
                <th>OPD Tujuan</th>
            <?php endif; ?>

            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $terbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
    <td><span class="tcode"><?php echo e($r->kode); ?></span></td>

    <td>
        <strong style="font-size:.83rem"><?php echo e($r->nama_tamu); ?></strong><br>
        <span style="font-size:.76rem;color:var(--gray-400)">
            <?php echo e($r->instansi ?: $r->email_tamu); ?>

        </span>
    </td>

    <td><?php echo e($r->opd?->nama ?? '-'); ?>


    <td style="font-size:.8rem;white-space:nowrap">
        <?php echo e($r->tanggal?->translatedFormat('d M Y')); ?>

    </td>

    <td style="font-size:.78rem"><?php echo e($r->sesi_jam); ?></td>

    <td><?php echo $r->status_badge; ?></td>

    <td>
        <a href="<?php echo e(route('admin.reservasi.detail', $r->id)); ?>"
           class="btn btn-secondary btn-sm">
           Detail
        </a>
    </td>
</tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="6">
            <div class="empty-st"><span style="font-size:2rem;display:block;margin-bottom:8px">📋</span>
              <p>Belum ada reservasi.</p>
            </div>
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>
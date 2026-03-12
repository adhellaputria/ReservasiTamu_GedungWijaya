<?php $__env->startSection('title','Laporan Reservasi'); ?>

<?php use Illuminate\Support\Str; ?>
<?php $__env->startSection('content'); ?>
<div class="mb24">
  <h1 style="font-size:1.3rem">Laporan Reservasi</h1>
  <p class="mt4">Laporan rekap kunjungan tamu <strong><?php echo e($opdNama); ?></strong></p>
</div>

<div class="card mb20">
  <div class="card-header">
    <div class="card-htitle">
      <div class="ico">&#9642;</div>Filter Laporan
    </div>
  </div>
  <div class="card-body">
    <form method="GET" action="<?php echo e(route('admin.laporan')); ?>"
      style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:16px;align-items:end">
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Dari Tanggal</label>
        <input type="date" name="dari" class="fc" value="<?php echo e($dari); ?>">
      </div>
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Sampai Tanggal</label>
        <input type="date" name="sampai" class="fc" value="<?php echo e($sampai); ?>">
      </div>
      <?php if(session('admin_role') === 'admin_utama'): ?>
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">OPD</label>
        <select name="opd_id" class="fsel">
          <option value="">Semua OPD</option>
          <?php $__currentLoopData = $opdList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($opd->id); ?>" <?php echo e($opdFilter == $opd->id ? 'selected' : ''); ?>>
              <?php echo e($opd->nama); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <?php endif; ?>
      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">Status</label>
        <select name="status" class="fsel">
          <option value="">Semua Status</option>
          <option value="Menunggu" <?php echo e($statusFilter == 'Menunggu' ? 'selected' : ''); ?>>Menunggu</option>
          <option value="Disetujui" <?php echo e($statusFilter == 'Disetujui' ? 'selected' : ''); ?>>Disetujui</option>
          <option value="Ditolak" <?php echo e($statusFilter == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
          <option value="Hadir" <?php echo e($statusFilter == 'Hadir' ? 'selected' : ''); ?>>Hadir</option>
          <option value="Tidak Hadir" <?php echo e($statusFilter == 'Tidak Hadir' ? 'selected' : ''); ?>>Tidak Hadir</option>
        </select>
      </div>
      <div class="form-group" style="margin-bottom:0">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="<?php echo e(route('admin.laporan')); ?>" class="btn btn-outline btn-sm">Reset</a>
      </div>
    </form>
  </div>
</div>

<?php if($data->count() > 0): ?>
<div class="card">
  <div
    style="background:var(--blue-900);color:var(--white);padding:16px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
    <div>
      <div style="font-family:var(--font-d);font-weight:700;font-size:1rem"><?php echo e($opdNama); ?></div>
      <div style="font-size:.78rem;color:var(--blue-300);margin-top:4px">
        <?php echo e(\Carbon\Carbon::parse($dari)->translatedFormat('d F Y')); ?> s/d <?php echo e(\Carbon\Carbon::parse($sampai)->translatedFormat('d F Y')); ?> &middot; <?php echo e($kpi['total']); ?> reservasi
      </div>
    </div>
    <a href="<?php echo e(route('admin.laporan.cetak', array_merge(request()->query()))); ?>" target="_blank"
      class="btn btn-secondary btn-sm">&#11015; Cetak / Unduh PDF</a>
  </div>
  <div class="card-body">
    <div class="kpi-grid" style="grid-template-columns:repeat(5,1fr);margin-bottom:20px">
      <div class="kpi-card kamber">
        <div class="kpi-ico">&#9203;</div>
        <div>
          <div class="kpi-num"><?php echo e($kpi['menunggu']); ?></div>
          <div class="kpi-lbl">Menunggu</div>
        </div>
      </div>
      <div class="kpi-card kgreen">
        <div class="kpi-ico">&#10003;</div>
        <div>
          <div class="kpi-num"><?php echo e($kpi['disetujui']); ?></div>
          <div class="kpi-lbl">Disetujui</div>
        </div>
      </div>
      <div class="kpi-card kred">
        <div class="kpi-ico">&#10007;</div>
        <div>
          <div class="kpi-num"><?php echo e($kpi['ditolak']); ?></div>
          <div class="kpi-lbl">Ditolak</div>
        </div>
      </div>
      <div class="kpi-card kblue">
        <div class="kpi-ico">&#128100;</div>
        <div>
          <div class="kpi-num"><?php echo e($kpi['hadir']); ?></div>
          <div class="kpi-lbl">Hadir</div>
        </div>
      </div>
      <div class="kpi-card" style="background:#f3f4f6;border-color:#9ca3af">
        <div class="kpi-ico" style="background:#e5e7eb;color:#4b5563">&#10145;</div>
        <div>
          <div class="kpi-num" style="color:#374151"><?php echo e($kpi['tidak_hadir']); ?></div>
          <div class="kpi-lbl" style="color:#6b7280">Tidak Hadir</div>
        </div>
      </div>
    </div>
    <div class="tbl-wrap">
      <table class="dtbl">
        <thead>
          <tr>
            <th>Kode</th>
            <?php if(session('admin_role') === 'admin_utama'): ?>
            <th>OPD</th>
            <?php endif; ?>
            <th>Nama Tamu</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Tujuan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><span class="tcode"><?php echo e($r->kode); ?></span></td>
            <?php if(session('admin_role') === 'admin_utama'): ?>
            <td style="font-size:.78rem"><?php echo e($r->opd->nama ?? '—'); ?></td>
            <?php endif; ?>
            <td><strong style="font-size:.82rem"><?php echo e($r->nama_tamu); ?></strong><br><span
                style="font-size:.74rem;color:var(--gray-400)"><?php echo e($r->instansi); ?></span></td>
            <td style="white-space:nowrap;font-size:.8rem"><?php echo e(\Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y')); ?></td>
            <td style="font-size:.78rem"><?php echo e($r->jam_kunjungan); ?></td>
            <td style="font-size:.78rem;max-width:180px"><?php echo e(Str::limit($r->tujuan, 40)); ?></td>
            <td><?php echo $r->status_badge; ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php else: ?>
<div class="card">
  <div class="card-body">
    <div class="empty-st"><span style="font-size:2rem;display:block;margin-bottom:8px">&#128202;</span>
      <p>Tidak ada data untuk filter yang dipilih.</p>
    </div>
  </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/admin/laporan/index.blade.php ENDPATH**/ ?>
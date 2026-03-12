<?php $__env->startSection('title','Cek Status Reservasi'); ?>
<?php $__env->startPush('styles'); ?>
<style>
/* Check status page styles */
.check-page {
    max-width:640px;
    margin:0 auto;
    padding:36px 24px 80px
}

.irow {
    display: flex;
    padding: 8px 0;
    border-bottom: 1px solid var(--gray-100);
    font-size: .83rem;
    gap: 12px
}

.irow:last-child {
    border-bottom: none
}

.ikey {
    width: 150px;
    flex-shrink: 0;
    color: var(--gray-500);
    font-weight: 600
}

.ival {
    flex: 1;
    color: var(--gray-800);
    word-break: break-word
}
.tl-dot.rej{
    background:#9ca3af;
    border-color:#9ca3af;
}

/* Detail grid for cek status page */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.detail-label {
    font-size: .72rem;
    font-weight: 700;
    color: var(--gray-400);
    text-transform: uppercase;
    letter-spacing: .07em;
    margin-bottom: 8px;
}

.detail-section {
    min-width: 0;
}

@media (max-width: 640px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
}

/* Responsive styles */
@media(max-width:768px) {
    .check-page {
        padding: 24px 16px 60px;
    }
}

@media(max-width:640px) {
    .card-body {
        padding: 16px;
    }
    
    .irow {
        flex-direction: column;
        gap: 4px;
    }
    
    .ikey {
        width: 100%;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .status-card-body {
        padding: 16px;
    }
}

@media(max-width:480px) {
    .check-page .breadcrumb {
        flex-wrap: wrap;
    }
    
    h2 {
        font-size: 1.2rem;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="check-page">
  <div style="font-size:.78rem;color:var(--gray-400);margin-bottom:20px;display:flex;align-items:center;gap:6px">
    <a href="<?php echo e(route('home')); ?>" style="color:var(--blue-600)">Beranda</a>
    <span style="color:var(--gray-300)">/</span><span>Cek Status</span>
  </div>
  <div class="mb24"><h2>Cek Status Permohonan Reservasi</h2><p class="mt4">Masukkan kode reservasi yang Anda terima untuk melihat status terkini.</p></div>

  <div class="card mb20">
    <div class="card-body">
      <form action="<?php echo e(route('cek.status')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group" style="margin-bottom:10px">
          <label class="form-label">Kode Reservasi</label>
          <div style="display:flex;gap:10px;flex-wrap:wrap">
            <input type="text" name="kode" class="fc" placeholder="WJY-XXXXXX" style="flex:1;text-transform:uppercase;font-family:'Courier New',monospace;font-size:1rem;letter-spacing:.06em" value="<?php echo e(request('kode') ?? old('kode')); ?>" oninput="this.value=this.value.toUpperCase()">
            <button type="submit" class="btn btn-primary" style="flex-shrink:0">Periksa Status</button>
          </div>
          <div class="form-hint">Format kode: <strong>WJY-XXXXXX</strong></div>
        </div>
      </form>
    </div>
  </div>

  <?php if(session('error_kode')): ?>
    <div class="alert alert-err"><span class="ai">&#10005;</span>Kode <strong><?php echo e(session('error_kode')); ?></strong> tidak ditemukan. Pastikan kode sudah benar.</div>
  <?php endif; ?>

  <?php if(isset($reservasi)): ?>
  <div class="card">
    <div class="card-header">
      <div>
        <div style="font-size:1rem;font-weight:700;font-family:var(--font-d);color:var(--gray-900)"><?php echo e($reservasi->nama_tamu); ?></div>
        <div style="font-size:.76rem;color:var(--gray-400);margin-top:3px"><?php echo e($reservasi->kode); ?> &middot; <?php echo e($reservasi->opd->nama); ?></div>
      </div>
      <div><?php echo $reservasi->status_badge; ?></div>
    </div>
    <div class="card-body">
      <div class="detail-grid">
        <div class="detail-section">
          <div class="detail-label">Detail Reservasi</div>
          <div class="irow"><span class="ikey">OPD Tujuan</span><span class="ival"><?php echo e($reservasi->opd->nama); ?></span></div>
          <div class="irow"><span class="ikey">Lantai</span><span class="ival">Lantai <?php echo e($reservasi->opd->lantai); ?></span></div>
          <div class="irow"><span class="ikey">Petugas</span><span class="ival"><?php echo e($reservasi->petugas_dituju ?: '—'); ?></span></div>
          <div class="irow"><span class="ikey">Tanggal</span><span class="ival"><?php echo e(\Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('l, d F Y')); ?></span></div>
          <div class="irow"><span class="ikey">Jam</span><span class="ival"><?php echo e($reservasi->jam_kunjungan); ?></span></div>
          <div class="irow"><span class="ikey">Keperluan</span><span class="ival"><?php echo e($reservasi->tujuan); ?></span></div>
        </div>
        <div class="detail-section">
          <?php
            $isDitolak = $reservasi->status === 'Ditolak';
            $steps = [
              ['label'=>'Reservasi Diajukan','sub'=>'Formulir diterima sistem','done'=>true,'rej'=>false,'skip'=>false],
              ['label'=>'Ditinjau Admin OPD','sub'=>'Dalam proses peninjauan','done'=>$reservasi->status!=='Menunggu','rej'=>false,'skip'=>false],
              ['label'=>$isDitolak?'Pengajuan Ditolak':'Reservasi Disetujui','sub'=>$isDitolak?'Tidak dapat dikabulkan':'Kode reservasi telah diberikan','done'=>in_array($reservasi->status,['Disetujui','Hadir','Tidak Hadir','Ditolak']),'rej'=>$isDitolak,'skip'=>false],
              ['label'=>'Verifikasi Kehadiran',
              'sub'=>$isDitolak
              ? 'Tidak berlaku (ditolak)'
              : ($reservasi->status === 'Tidak Hadir'
              ? 'Tamu tidak hadir'
              : 'Verifikasi oleh admin lobi dinas'),
              'done'=>in_array($reservasi->status,['Hadir','Tidak Hadir']),
              'rej'=>$reservasi->status === 'Tidak Hadir',
              'skip'=>$isDitolak,
              ],
            ];
          ?>
          <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="tl-item" style="<?php echo e($s['skip'] ? 'opacity:.4' : ''); ?>">
            <div class="tl-track">
              <div class="tl-dot <?php echo e($s['skip'] ? 'skip' : ($s['rej'] ? 'rej' : ($s['done'] ? 'done' : ($loop->index === collect($steps)->search(fn($x) => !$x['done'] && !$x['skip']) ? 'active' : '')))); ?>"></div>
              <?php if(!$loop->last): ?><div class="tl-line"></div><?php endif; ?>
            </div>
            <div class="tl-content mt4">
              <h4 style="<?php echo e($s['skip'] ? 'text-decoration:line-through;color:var(--gray-400)' : ''); ?>"><?php echo e($s['label']); ?></h4>
              <p><?php echo e($s['sub']); ?></p>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
      <?php if($isDitolak && $reservasi->alasan_tolak): ?>
      <div class="mt16">
        <div class="alert alert-err"><span class="ai">&#9888;</span><div><strong style="display:block;margin-bottom:4px">Alasan Penolakan</strong><?php echo e($reservasi->alasan_tolak); ?></div></div>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/reservasi/cek.blade.php ENDPATH**/ ?>
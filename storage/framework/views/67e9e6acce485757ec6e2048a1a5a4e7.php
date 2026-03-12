<?php $__env->startSection('title','Kelola Reservasi'); ?>
<?php $__env->startPush('styles'); ?>
<style>
/* Responsive filter bar */
.filter-bar {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.search-group {
    display: flex;
    align-items: center;
    background: var(--white);
    border: 1.5px solid var(--gray-300);
    border-radius: var(--radius-sm);
    overflow: hidden;
    transition: border-color 0.15s;
}

.search-group:focus-within {
    border-color: var(--blue-500);
}

.search-group input {
    border: none;
    padding: 7px 12px;
    font-size: 0.83rem;
    flex: 1;
    outline: none;
    background: transparent;
    font-family: var(--font-body);
    color: var(--gray-700);
    min-width: 160px;
}

.search-icon {
    padding: 0 10px 0 12px;
    color: var(--gray-400);
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 768px) {
    .filter-bar {
        flex-direction: column;
    }
    
    .filter-bar > div {
        width: 100%;
    }
    
    .search-group {
        width: 100%;
    }
    
    .search-group input {
        width: 100%;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .card-header .btn {
        width: 100%;
    }
}

@media (max-width: 640px) {
    .fchip {
        flex: 1;
        text-align: center;
        min-width: 70px;
    }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-size:1.3rem">
  <?php if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN): ?>
      Semua Reservasi Tamu
  <?php else: ?>
      Kelola Reservasi Tamu
  <?php endif; ?>
  </h1>

  <p class="mt4">
  <?php if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN): ?>
      Lihat seluruh data reservasi dari semua OPD.
  <?php else: ?>
      Tinjau, setujui, atau tolak permohonan reservasi OPD Anda.
  <?php endif; ?>
  </p>
</div>

<form method="GET" action="<?php echo e(route('admin.reservasi.index')); ?>" class="filter-bar">

    <div class="filter-chips">
        <a href="<?php echo e(route('admin.reservasi.index')); ?>" 
           class="fchip <?php echo e(!request('status') ? 'active' : ''); ?>">
           Semua
        </a>

        <?php $__currentLoopData = ['Menunggu','Disetujui','Ditolak','Hadir','Tidak Hadir']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.reservasi.index', ['status'=>$st, 'q'=>request('q')])); ?>" 
               class="fchip <?php echo e(request('status')===$st ? 'active' : ''); ?>">
               <?php echo e($st); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" name="q" placeholder="Cari nama, kode..." value="<?php echo e(request('q')); ?>">
        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
    </div>

</form>

<div class="card">
<div class="tbl-wrap table-responsive">
    <table class="dtbl">
      <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Tamu / Instansi</th>

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

    <?php $__empty_1 = true; $__currentLoopData = $reservasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><span class="tcode"><?php echo e($r->kode); ?></span></td>

        <td>
            <strong style="font-size:.83rem"><?php echo e($r->nama_tamu); ?></strong><br>
            <span style="font-size:.76rem;color:var(--gray-400)">
                <?php echo e($r->instansi ?: $r->email_tamu); ?>

            </span>
        </td>

        <?php if(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN): ?>
            <td style="font-size:.8rem">
                <?php echo e($r->opd->nama ?? '-'); ?>

            </td>
        <?php endif; ?>

        <td style="font-size:.8rem;white-space:nowrap">
            <?php echo e(\Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y')); ?>

        </td>

        <td style="font-size:.78rem"><?php echo e($r->sesi_jam); ?></td>

        <td><?php echo $r->status_badge; ?></td>

        <td>
          <div style="display:flex;gap:5px">

            <a href="<?php echo e(route('admin.reservasi.detail', $r->id)); ?>"
              class="btn btn-secondary btn-sm">
              Detail
            </a>

            <?php if(
                session('admin_role') === \App\Models\Admin::ROLE_ADMIN_OPD
                && $r->status === 'Menunggu'
            ): ?>

                <form action="<?php echo e(route('admin.reservasi.setujui', $r->id)); ?>"
                      method="POST" style="margin:0">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="btn btn-success-soft btn-sm">
                        Setujui
                    </button>
                </form>

                <button type="button"
                        class="btn btn-danger-soft btn-sm"
                        onclick="openRejectModal(<?php echo e($r->id); ?>)">
                    Tolak
                </button>

            <?php endif; ?>

          </div>
        </td>
    </tr>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
    <td colspan="<?php echo e(session('admin_role') === \App\Models\Admin::ROLE_SUPERADMIN ? 7 : 6); ?>">
        <div class="empty-st">
            <span style="font-size:2rem;display:block;margin-bottom:8px">📋</span>
            <p>Tidak ada data reservasi.</p>
        </div>
    </td>
    </tr>
    <?php endif; ?>
  </tbody>
    </table>
  </div>
  <?php if($reservasi->hasPages()): ?>
  <div style="padding:12px 20px;border-top:1px solid var(--gray-200)"><?php echo e($reservasi->links()); ?></div>
  <?php endif; ?>
</div>


<div class="modal-bd" id="rejectModal">
  <div class="modal">
    <div class="modal-hdr"><span class="modal-ttl">Tolak Reservasi</span><button class="modal-cls" onclick="closeModal()">&times;</button></div>
    <div class="modal-body">
      <div class="alert alert-warn" style="margin-bottom:14px"><span class="ai">!</span>Tindakan ini akan menolak pengajuan reservasi. Status akan diperbarui dan tamu dapat cek status secara online.</div>
      <form id="rejectForm" action="" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
          <label class="form-label">Alasan Penolakan <span style="color:var(--gray-400);font-weight:400">(opsional)</span></label>
          <textarea name="alasan" class="fta" placeholder="Contoh: Jadwal pejabat penuh hingga akhir bulan..." rows="3"></textarea>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
          <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
          <button type="submit" class="btn btn-danger">Tolak Reservasi</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function openRejectModal(id){
  document.getElementById('rejectForm').action='/admin/reservasi/'+id+'/tolak';
  document.getElementById('rejectModal').classList.add('show');
}
function closeModal(){document.getElementById('rejectModal').classList.remove('show');}
document.getElementById('rejectModal').addEventListener('click',function(e){if(e.target===this)closeModal();});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/admin/reservasi/index.blade.php ENDPATH**/ ?>
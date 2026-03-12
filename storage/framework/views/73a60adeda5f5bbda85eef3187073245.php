<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Laporan <?php echo e($opdNama); ?></title>
  <?php use Illuminate\Support\Str; ?>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      font-size: 12px;
      color: #1e293b;
      margin: 0;
      padding: 24px
    }

    .hdr {
      background: #0d2859;
      color: #fff;
      padding: 14px 18px;
      border-radius: 6px;
      margin-bottom: 18px
    }

    .hdr h1 {
      font-size: 15px;
      margin: 0 0 4px
    }

    .hdr p {
      font-size: 11px;
      color: #93c5fd;
      margin: 0
    }

    .kpi-row {
      display: flex;
      gap: 12px;
      margin-bottom: 20px
    }

    .kpi {
      flex: 1;
      padding: 10px 14px;
      border-radius: 4px;
      border-left: 4px solid
    }

    .km { background: #fffbeb; border-color: #f59e0b }
    .kd { background: #f0fdf4; border-color: #16a34a }
    .kt { background: #fef2f2; border-color: #b91c1c }
    .kh { background: #eff6ff; border-color: #1e5bb5 }
    .kth { background: #f3f4f6; border-color: #9ca3af }

    .kpi-n { font-size: 24px; font-weight: 900; line-height: 1 }
    .kpi-l { font-size: 10px; color: #64748b; margin-top: 2px }

    table { width: 100%; border-collapse: collapse }
    th { background: #f1f5f9; padding: 8px 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; text-align: left; border-bottom: 2px solid #e2e8f0 }
    td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; vertical-align: top }

    .footer { margin-top: 24px; padding-top: 12px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #94a3b8; text-align: center }

    @media print { body { padding: 16px } }
  </style>
</head>

<body>
  <div class="hdr">
    <h1>Laporan Reservasi Tamu — <?php echo e($opdNama); ?></h1>
    <p><?php echo e(\Carbon\Carbon::parse($dari)->translatedFormat('d F Y')); ?> s/d <?php echo e(\Carbon\Carbon::parse($sampai)->translatedFormat('d F Y')); ?> &bull; Dicetak: <?php echo e(now()->translatedFormat('d F Y, H:i')); ?> WIB &bull; Total: <?php echo e($kpi['total']); ?> data</p>
  </div>

  <div class="kpi-row">
    <div class="kpi km"><div class="kpi-n"><?php echo e($kpi['menunggu']); ?></div><div class="kpi-l">Menunggu</div></div>
    <div class="kpi kd"><div class="kpi-n"><?php echo e($kpi['disetujui']); ?></div><div class="kpi-l">Disetujui</div></div>
    <div class="kpi kt"><div class="kpi-n"><?php echo e($kpi['ditolak']); ?></div><div class="kpi-l">Ditolak</div></div>
    <div class="kpi kh"><div class="kpi-n"><?php echo e($kpi['hadir']); ?></div><div class="kpi-l">Hadir</div></div>
    <div class="kpi kth"><div class="kpi-n"><?php echo e($kpi['tidak_hadir']); ?></div><div class="kpi-l">Tidak Hadir</div></div>
  </div>

  <table>
    <thead>
      <tr>
        <th>Kode</th>
        <?php if($opdNama === 'Semua OPD' || isset($data->first()->opd)): ?>
        <th>OPD</th>
        <?php endif; ?>
        <th>Nama Tamu / Instansi</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Tujuan</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td style="font-family:monospace;font-weight:700;color:#1e5bb5"><?php echo e($r->kode); ?></td>
        <?php if($opdNama === 'Semua OPD'): ?>
        <td><?php echo e($r->opd->nama ?? '—'); ?></td>
        <?php endif; ?>
        <td><strong><?php echo e($r->nama_tamu); ?></strong><br><small style="color:#64748b"><?php echo e($r->instansi); ?></small></td>
        <td style="white-space:nowrap"><?php echo e(\Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y')); ?></td>
        <td><?php echo e($r->jam_kunjungan); ?></td>
        <td style="max-width:150px"><?php echo e(Str::limit($r->tujuan, 30)); ?></td>
        <td><strong><?php echo e($r->status); ?></strong></td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>

  <div class="footer">Dokumen digenerate oleh SIJAMU — Gedung Wijaya, Pemerintah Kabupaten Sukoharjo</div>
  <script>window.onload = function () { window.print(); };</script>
</body>
</html>

<?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/admin/laporan/cetak.blade.php ENDPATH**/ ?>
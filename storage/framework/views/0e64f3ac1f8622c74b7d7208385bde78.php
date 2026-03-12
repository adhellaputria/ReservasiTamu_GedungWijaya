<?php $__env->startSection('title','Reservasi Berhasil'); ?>
<?php $__env->startSection('content'); ?>
<div
  style="background:var(--gray-50);min-height:80vh;display:flex;align-items:center;justify-content:center;padding:40px 20px">
  <div
    style="background:var(--white);border:1px solid var(--gray-200);border-radius:var(--r-md);box-shadow:var(--sh-md);max-width:520px;width:100%;overflow:hidden">
    <div style="background:var(--blue-900);padding:20px 24px;text-align:center">
      <div
        style="font-family:var(--font-d);font-weight:700;font-size:.86rem;color:rgba(255,255,255,.7);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">
        Permohonan Diterima</div>
      <div style="color:white;font-size:.82rem">Reservasi Anda telah berhasil diajukan ke sistem</div>
    </div>
    <div style="padding:28px 24px;text-align:center">
      <div
        style="width:64px;height:64px;border-radius:50%;background:var(--green-bg);border:3px solid #22c55e;display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 16px">
        &#10003;</div>
      <h2 style="font-size:1.15rem;margin-bottom:6px">Simpan Kode Reservasi </h2>
      <p style="font-size:.85rem;margin-bottom:4px">Kode Reservasi Anda:</p>

      
      <div style="margin:12px 0">
        <div id="kodeBox"
          style="background:var(--blue-900);color:var(--white);padding:10px 24px;border-radius:var(--r-sm) var(--r-sm) 0 0;display:block;font-family:'Courier New',monospace;font-size:1.5rem;font-weight:700;letter-spacing:.14em">
          <?php echo e($reservasi->kode); ?></div>
        <button id="salinBtn" onclick="salinKode('<?php echo e($reservasi->kode); ?>')"
          style="display:flex;align-items:center;justify-content:center;gap:8px;background:var(--blue-800);border-radius:0 0 var(--r-sm) var(--r-sm);padding:7px 16px;cursor:pointer;border:none;width:100%;transition:background .15s"
          onmouseover="this.style.background='var(--blue-700)'" onmouseout="this.style.background='var(--blue-800)'">
          <span style="font-size:.8rem;color:var(--blue-300)">&#9112;</span>
          <span id="salinTxt" style="font-size:.75rem;color:var(--blue-300);font-weight:500;letter-spacing:.03em">
            Klik - Untuk Salin Kode Diatas </span>
        </button>
      </div>
      
      <div style="
  margin: 16px 0 4px;
  border: 1.5px solid var(--blue-800);
  border-left: 4px solid var(--blue-900);
  border-radius: var(--r-sm);
  background: var(--gray-50);
  padding: 14px 16px;
  text-align: left;
">
        <div style="
    display: flex;
    align-items: flex-start;
    gap: 10px;
  ">
          <span style="
      font-size: 1.1rem;
      line-height: 1;
      margin-top: 2px;
      flex-shrink: 0;
    ">&#9888;</span>
          <div>
            <p style="
        margin: 0 0 5px;
        font-size: .82rem;
        font-weight: 800;
        color: var(--blue-900);
        text-transform: uppercase;
        letter-spacing: .05em;
        line-height: 1.4;
      ">Simpan atau Screenshot Halaman Ini</p>
            <p style="
        margin: 0;
        font-size: .80rem;
        font-weight: 400;
        color: var(--gray-600);
        line-height: 1.65;
      ">
              Kode reservasi di atas <strong style="color:var(--blue-900);font-weight:700">hanya ditampilkan
                sekali</strong>
              dan <strong style="color:var(--blue-900);font-weight:700">wajib ditunjukkan saat kedatangan</strong>
              sebagai bukti reservasi. Halaman ini tidak dapat dibuka kembali setelah Anda meninggalkannya.
            </p>
          </div>
        </div>
      </div>

      <span class="badge bw mt12"><span class="bdot"></span>Menunggu Persetujuan Admin</span>
      <p style="font-size:.82rem;margin-top:16px;line-height:1.8">

      <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap;margin-top:20px">
        <a href="<?php echo e(route('cek.form')); ?>?kode=<?php echo e($reservasi->kode); ?>" class="btn btn-primary">Cek Status Reservasi</a>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline">Kembali ke Beranda</a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
  function salinKode(kode) {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(kode).then(function () {
        var btn = document.getElementById('salinBtn');
        var txt = document.getElementById('salinTxt');
        btn.style.background = '#14532d'; txt.style.color = '#86efac';
        txt.textContent = 'Kode berhasil disalin!';
        setTimeout(function () { btn.style.background = 'var(--blue-800)'; txt.style.color = 'var(--blue-300)'; txt.textContent = 'klik untuk salin kode'; }, 2500);
      });
    } else {
      var el = document.getElementById('kodeBox');
      var range = document.createRange(); range.selectNodeContents(el);
      window.getSelection().removeAllRanges(); window.getSelection().addRange(range);
      document.execCommand('copy'); window.getSelection().removeAllRanges();
      alert('Kode berhasil disalin: ' + kode);
    }
  }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/reservasi/sukses.blade.php ENDPATH**/ ?>
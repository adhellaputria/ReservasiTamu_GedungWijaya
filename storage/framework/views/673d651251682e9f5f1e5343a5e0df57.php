<?php $__env->startSection('title','Buat Reservasi'); ?>
<?php $__env->startPush('styles'); ?>
<style>
.form-pg{max-width:760px;margin:0 auto;padding:36px 24px 80px}
.breadcrumb{font-size:.78rem;color:var(--gray-400);margin-bottom:20px;display:flex;align-items:center;gap:6px}
.step-wizard{display:flex;align-items:center;margin-bottom:28px;padding:16px 20px;background:var(--white);border:1px solid var(--gray-200);border-radius:var(--r-md)}
.step-item{flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;position:relative}
.step-item:not(:last-child)::after{content:'';position:absolute;top:14px;left:50%;right:-50%;height:2px;background:var(--gray-200);z-index:0}
.step-item.done:not(:last-child)::after,.step-item.active:not(:last-child)::after{background:var(--blue-600)}
.step-num{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:700;z-index:1;border:2px solid var(--gray-300);background:var(--white);color:var(--gray-400);transition:all .2s}
.step-item.active .step-num{border-color:var(--blue-600);background:var(--blue-700);color:var(--white)}
.step-item.done .step-num{border-color:var(--blue-600);background:var(--blue-600);color:var(--white)}
.step-lbl{font-size:.7rem;font-weight:600;color:var(--gray-400);text-align:center}
.step-item.active .step-lbl{color:var(--blue-700)}.step-item.done .step-lbl{color:var(--blue-600)}
.fsec-ttl{font-size:.76rem;font-weight:700;color:var(--blue-700);text-transform:uppercase;letter-spacing:.07em;padding-bottom:6px;border-bottom:2px solid var(--blue-100);margin-bottom:16px}
.review-box{background:var(--blue-50);border:1px solid var(--blue-200);border-radius:var(--r-md);padding:16px 18px;margin:16px 0}
.review-ttl{font-size:.74rem;font-weight:700;color:var(--blue-700);text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px}
.upload-area{border:2px dashed var(--gray-300);border-radius:var(--r-md);padding:28px 20px;text-align:center;cursor:pointer;transition:all .15s;background:var(--gray-50);position:relative}
.upload-area:hover,.upload-area.dragover{border-color:var(--blue-500);background:var(--blue-50)}
.upload-area input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}

/* Responsive styles for form */
@media(max-width:768px) {
  .form-pg {
    padding: 24px 16px 60px;
  }
  
  .step-wizard {
    flex-direction: column;
    gap: 12px;
    padding: 16px;
  }
  
  .step-item {
    flex-direction: row;
    gap: 12px;
  }
  
  .step-item:not(:last-child)::after {
    display: none;
  }
  
  .card-footer {
    flex-direction: column;
    gap: 8px;
  }
  
  .card-footer .btn {
    width: 100%;
  }
  
  .card-footer .btn-outline {
    order: 1;
  }
}

@media(max-width:480px) {
  .breadcrumb {
    flex-wrap: wrap;
  }
  
  .page-title h2 {
    font-size: 1.2rem;
  }
  
  .fsec-ttl {
    font-size: 0.7rem;
  }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="form-pg">
  <div class="breadcrumb">
    <a href="<?php echo e(route('home')); ?>">Beranda</a>
    <span style="color:var(--gray-300)">/</span><span>Buat Reservasi</span>
  </div>
  <div class="mb24">
    <h2>Formulir Permohonan Reservasi Tamu</h2>
    <p class="mt4">Isi seluruh data dengan benar. Bidang bertanda <span class="req">*</span> wajib diisi.</p>
  </div>

  
  <div class="step-wizard" id="stepWizard">
    <div class="step-item active" id="si1"><div class="step-num" id="sn1">1</div><div class="step-lbl">Data Tamu</div></div>
    <div class="step-item" id="si2"><div class="step-num" id="sn2">2</div><div class="step-lbl">Tujuan &amp; Jadwal</div></div>
    <div class="step-item" id="si3"><div class="step-num" id="sn3">3</div><div class="step-lbl">Konfirmasi</div></div>
  </div>

  <form action="<?php echo e(route('reservasi.store')); ?>" method="POST" enctype="multipart/form-data" id="formReservasi" novalidate>
    <?php echo csrf_field(); ?>

    
    <div id="step1" class="card">
      <div class="card-header"><div class="card-htitle"><div class="ico">1</div>Data Identitas Tamu</div></div>
      <div class="card-body">
        <div class="fsec-ttl">Informasi Pribadi</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Lengkap (Beserta Gelar) <span class="req">*</span></label>
            <input type="text" name="nama_tamu" id="nama_tamu" class="fc <?php echo e($errors->has('nama_tamu') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('nama_tamu')); ?>" placeholder="Masukkan nama lengkap Anda">
            <div class="invalid-feedback"><?php echo e($errors->first('nama_tamu')); ?></div>
          </div>
          <div class="form-group">
            <label class="form-label">Nomor HP / WhatsApp <span class="req">*</span></label>
            <input type="tel" name="no_hp" id="no_hp" class="fc <?php echo e($errors->has('no_hp') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('no_hp')); ?>" placeholder="08123456789">
            <div class="invalid-feedback"><?php echo e($errors->first('no_hp')); ?></div>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Alamat Email <span class="req">*</span></label>
          <input type="email" name="email_tamu" id="email_tamu" class="fc <?php echo e($errors->has('email_tamu') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('email_tamu')); ?>" placeholder="nama@email.com">
          <div class="invalid-feedback"><?php echo e($errors->first('email_tamu')); ?></div>
        </div>
        <div class="form-group">
          <label class="form-label">Instansi / Lembaga / Asal</label>
          <input type="text" name="instansi" class="fc" value="<?php echo e(old('instansi')); ?>" placeholder="Nama instansi atau lembaga (opsional)">
        </div>
        <hr class="div">
        <div class="fsec-ttl">Keperluan</div>
        <div class="form-group">
          <label class="form-label">Ringkasan Tujuan Kunjungan <span class="req">*</span></label>
          <input type="text" name="tujuan" id="tujuan" class="fc <?php echo e($errors->has('tujuan') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('tujuan')); ?>" placeholder="Contoh: Konsultasi perizinan usaha bidang perdagangan">
          <div class="invalid-feedback"><?php echo e($errors->first('tujuan')); ?></div>
        </div>
      </div>
      <div class="card-footer">
        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline">Batal</a>
        <button type="button" class="btn btn-primary" onclick="goStep(2)">Selanjutnya &rarr;</button>
      </div>
    </div>

    
    <div id="step2" class="card" style="display:none">
      <div class="card-header"><div class="card-htitle"><div class="ico">2</div>Tujuan &amp; Jadwal Kunjungan</div></div>
      <div class="card-body">
        <div class="fsec-ttl">Pemilihan OPD</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">OPD yang Dituju <span class="req">*</span></label>
            <select name="opd_id" id="opd_id" class="fsel <?php echo e($errors->has('opd_id') ? 'is-invalid' : ''); ?>">
              <option value="">— Pilih OPD Tujuan —</option>
              <?php $__currentLoopData = $opdList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($opd->id); ?>" <?php echo e(old('opd_id') == $opd->id ? 'selected' : ''); ?>>
                  <?php echo e($opd->nama); ?> (Lantai <?php echo e($opd->lantai); ?>)
                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <div class="invalid-feedback"><?php echo e($errors->first('opd_id')); ?></div>
          </div>
          <div class="form-group">
            <label class="form-label">Pejabat / Staf yang Dituju</label>
            <input type="text" name="petugas_dituju" class="fc" value="<?php echo e(old('petugas_dituju')); ?>" placeholder="Nama atau jabatan (opsional)">
          </div>
        </div>
        <hr class="div">
        <div class="fsec-ttl">Jadwal Kunjungan</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tanggal Kunjungan <span class="req">*</span></label>
            <input type="date" name="tanggal" id="tanggal" class="fc <?php echo e($errors->has('tanggal') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('tanggal')); ?>" min="<?php echo e(date('Y-m-d')); ?>">
            <div class="invalid-feedback"><?php echo e($errors->first('tanggal')); ?></div>
          </div>
          <div class="form-group">
            <label class="form-label">Sesi Waktu <span class="req">*</span></label>
            <input type="time" 
                name="jam_kunjungan" 
                id="jam_kunjungan"
                class="fc <?php echo e($errors->has('jam_kunjungan') ? 'is-invalid' : ''); ?>"
                value="<?php echo e(old('jam_kunjungan')); ?>"
                step="3600"
                required>

          <div class="invalid-feedback"><?php echo e($errors->first('jam_kunjungan')); ?></div>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Keterangan Tambahan</label>
          <textarea name="keterangan" class="fta" placeholder="Informasi pendukung yang perlu diketahui admin OPD..."><?php echo e(old('keterangan')); ?></textarea>
        </div>
      </div>
      <div class="card-footer">
        <button type="button" class="btn btn-outline" onclick="goStep(1)">&larr; Kembali</button>
        <button type="button" class="btn btn-primary" onclick="goStep(3)">Selanjutnya &rarr;</button>
      </div>
    </div>

    
    <div id="step3" class="card" style="display:none">
      <div class="card-header"><div class="card-htitle"><div class="ico">3</div>Dokumen &amp; Konfirmasi</div></div>
      <div class="card-body">
        <div class="fsec-ttl">Unggah Berkas (Opsional)</div>
        <p style="font-size:.82rem;color:var(--gray-500);margin-bottom:14px">Lampirkan surat permohonan, surat tugas, atau berkas pendukung jika diperlukan.</p>
        <div class="upload-area" id="uploadArea">
          <input type="file" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="handleFile(this)">
          <div class="upload-area-icon" style="font-size:1.8rem;color:var(--gray-400);margin-bottom:8px">&#128196;</div>
          <div style="font-size:.82rem;color:var(--gray-500)"><strong style="color:var(--blue-600)">Klik untuk pilih berkas</strong> atau seret ke sini</div>
          <div style="font-size:.72rem;color:var(--gray-400);margin-top:4px">Format: PDF, Word, JPG, PNG (maks. 5 MB)</div>
        </div>
        <div id="uploadPreview" style="display:none;align-items:center;gap:10px;padding:10px 14px;background:var(--green-bg);border:1px solid #bbf7d0;border-radius:var(--r-sm);margin-top:10px">
          <span>&#128206;</span>
          <span id="uploadFName" style="font-size:.82rem;flex:1;color:var(--green);font-weight:500"></span>
          <button type="button" onclick="clearUpload()" style="background:none;border:none;color:var(--red);padding:2px 6px;font-size:1rem;cursor:pointer">&times;</button>
        </div>
        <?php $__errorArgs = ['dokumen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="alert alert-err mt8"><span class="ai">✕</span><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <hr class="div">
        <div class="fsec-ttl">Ringkasan Permohonan</div>
        <div class="review-box">
          <div class="review-ttl">Periksa kembali data sebelum mengirim</div>
          <div class="irow"><span class="ikey">Nama Lengkap</span><span class="ival" id="rev-nama">—</span></div>
          <div class="irow"><span class="ikey">No. HP</span><span class="ival" id="rev-hp">—</span></div>
          <div class="irow"><span class="ikey">Email</span><span class="ival" id="rev-email">—</span></div>
          <div class="irow"><span class="ikey">Instansi</span><span class="ival" id="rev-instansi">—</span></div>
          <div class="irow"><span class="ikey">OPD Tujuan</span><span class="ival" id="rev-opd">—</span></div>
          <div class="irow"><span class="ikey">Tanggal</span><span class="ival" id="rev-tanggal">—</span></div>
          <div class="irow"><span class="ikey">Jam</span><span class="ival" id="rev-jam">—</span></div>
          <div class="irow"><span class="ikey">Tujuan</span><span class="ival" id="rev-tujuan">—</span></div>
        </div>
        <div class="alert alert-info"><span class="ai">i</span>Dengan mengirim formulir ini, Anda menyatakan data yang diisikan adalah benar dan dapat dipertanggungjawabkan.</div>
      </div>
      <div class="card-footer">
        <button type="button" class="btn btn-outline" onclick="goStep(2)">&larr; Kembali</button>
        <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit">Kirim Permohonan Reservasi</button>
      </div>
    </div>

  </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
var curStep = <?php echo e($errors->any() ? 1 : 1); ?>;

function showStep(n){
  [1,2,3].forEach(function(i){
    var el=document.getElementById('step'+i);
    if(el) el.style.display=i===n?'':'none';
  });
  // Wizard
  [1,2,3].forEach(function(i){
    var it=document.getElementById('si'+i);
    var nm=document.getElementById('sn'+i);
    if(!it) return;
    it.className='step-item';
    if(i<n){it.classList.add('done');nm.textContent='✓';}
    else if(i===n){it.classList.add('active');nm.textContent=i;}
    else{nm.textContent=i;}
  });
  curStep=n;
  window.scrollTo({top:0,behavior:'auto'});
}

function validateStep1(){
  var ok=true;
  var nama=document.getElementById('nama_tamu').value.trim();
  var hp=document.getElementById('no_hp').value.trim();
  var email=document.getElementById('email_tamu').value.trim();
  var tujuan=document.getElementById('tujuan').value.trim();
  clearErrors(['nama_tamu','no_hp','email_tamu','tujuan']);
  if(nama.length<3){setError('nama_tamu','Nama minimal 3 karakter.');ok=false;}
  if(!/^0[0-9]{8,12}$/.test(hp)){setError('no_hp','Format HP tidak valid (awali 0, 9-13 digit).');ok=false;}
  if(email.length<1){setError('email_tamu','Email wajib diisi.');ok=false;}
  else if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)){setError('email_tamu','Format email tidak valid.');ok=false;}
  if(tujuan.length<5){setError('tujuan','Tujuan kunjungan wajib diisi.');ok=false;}
  return ok;
}

function validateStep2(){
  var ok=true;
  var opd=document.getElementById('opd_id').value;
  var tgl=document.getElementById('tanggal').value;
  var jam=document.getElementById('jam_kunjungan').value;

  clearErrors(['opd_id','tanggal','jam_kunjungan']);

  if(!opd){setError('opd_id','Pilih OPD tujuan.');ok=false;}
  if(!tgl){setError('tanggal','Pilih tanggal kunjungan.');ok=false;}
  if(!jam){setError('jam_kunjungan','Pilih jam kunjungan.');ok=false;}

  return ok;
}

function goStep(n){
  if(n===2 && !validateStep1()) return;
  if(n===3 && !validateStep2()) return;
  if(n===3) fillReview();
  showStep(n);
}

function fillReview(){
  var opdSel=document.getElementById('opd_id');
  document.getElementById('rev-nama').textContent=document.getElementById('nama_tamu').value||'—';
  document.getElementById('rev-hp').textContent=document.getElementById('no_hp').value||'—';
  document.getElementById('rev-email').textContent=document.getElementById('email_tamu').value||'—';
  document.getElementById('rev-instansi').textContent=document.getElementById('instansi')?.value||'—';
  document.getElementById('rev-opd').textContent=opdSel.options[opdSel.selectedIndex]?.text||'—';
  var tgl=document.getElementById('tanggal').value;
  document.getElementById('rev-tanggal').textContent=tgl?new Date(tgl+'T00:00:00').toLocaleDateString('id-ID',{weekday:'long',day:'numeric',month:'long',year:'numeric'}):'—';
  document.getElementById('rev-jam').textContent=document.getElementById('jam_kunjungan').value||'—';
  document.getElementById('rev-tujuan').textContent=document.getElementById('tujuan').value||'—';
}

function setError(id,msg){
  var el=document.getElementById(id);
  if(el){el.classList.add('is-invalid');}
  var fb=el?el.nextElementSibling:null;
  if(fb&&fb.classList.contains('invalid-feedback')){fb.textContent=msg;fb.style.display='block';}
}
function clearErrors(ids){
  ids.forEach(function(id){
    var el=document.getElementById(id);
    if(el){el.classList.remove('is-invalid');}
    var fb=el?el.nextElementSibling:null;
    if(fb&&fb.classList.contains('invalid-feedback')){fb.style.display='none';}
  });
}

function handleFile(input){
  if(input.files&&input.files[0]){
    var f=input.files[0];
    if(f.size>5*1024*1024){alert('Ukuran file melebihi 5 MB.');input.value='';return;}
    document.getElementById('uploadFName').textContent=f.name;
    document.getElementById('uploadArea').style.display='none';
    document.getElementById('uploadPreview').style.display='flex';
  }
}
function clearUpload(){
  document.getElementById('dokumen').value='';
  document.getElementById('uploadArea').style.display='';
  document.getElementById('uploadPreview').style.display='none';
}

document.getElementById('formReservasi').addEventListener('submit',function(){
  var btn=document.getElementById('btnSubmit');
  btn.disabled=true;btn.textContent='Mengirim...';
});

var zone=document.getElementById('uploadArea');
if(zone){
  zone.addEventListener('dragover',function(e){e.preventDefault();zone.classList.add('dragover');});
  zone.addEventListener('dragleave',function(){zone.classList.remove('dragover');});
  zone.addEventListener('drop',function(e){
    e.preventDefault();zone.classList.remove('dragover');
    var f=e.dataTransfer.files[0];
    if(f){var inp=document.getElementById('dokumen');
      try{var dt=new DataTransfer();dt.items.add(f);inp.files=dt.files;handleFile(inp);}catch(err){}
    }
  });
}

<?php if($errors->any()): ?>
showStep(1);
<?php endif; ?>
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/reservasi/form.blade.php ENDPATH**/ ?>
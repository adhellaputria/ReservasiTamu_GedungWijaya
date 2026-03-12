<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
<title><?php echo $__env->yieldContent('title','SIJAMU'); ?> — Sistem Informasi Jadwal Tamu | Gedung Wijaya</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<style>
:root{
  --blue-900:#0d2859;--blue-800:#103370;--blue-700:#1a4a9c;--blue-600:#1e5bb5;
  --blue-500:#2563eb;--blue-400:#3b82f6;--blue-300:#93c5fd;--blue-100:#dbeafe;--blue-50:#eff6ff;
  --white:#fff;--gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-300:#cbd5e1;
  --gray-400:#94a3b8;--gray-500:#64748b;--gray-600:#475569;--gray-700:#334155;--gray-900:#0f172a;
  --red:#b91c1c;--red-bg:#fef2f2;--green:#15803d;--green-bg:#f0fdf4;--amber:#b45309;--amber-bg:#fffbeb;
  --font-d:'Merriweather',Georgia,serif;--font-b:'Source Sans 3','Segoe UI',sans-serif;
  --sh-sm:0 1px 3px rgba(0,0,0,.08);--sh-md:0 4px 6px -1px rgba(0,0,0,.08);--sh-lg:0 10px 15px -3px rgba(0,0,0,.08);
  --r-sm:4px;--r:6px;--r-md:8px;--th:60px;--bh:30px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body {
    font-family: var(--font-b);
    font-size: 14px;
    line-height: 1.6;
    color: var(--gray-700);
    background: var(--gray-50);
    -webkit-font-smoothing: antialiased;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

main {
    flex: 1;
}
a{color:var(--blue-600);text-decoration:none}a:hover{text-decoration:underline}
button{cursor:pointer;font-family:var(--font-b)}input,select,textarea{font-family:var(--font-b)}
h1,h2,h3{font-family:var(--font-d);color:var(--gray-900)}
h1{font-size:1.6rem;font-weight:700;line-height:1.3}h2{font-size:1.3rem;font-weight:700}
h3{font-size:1.05rem;font-weight:700}h4{font-size:.95rem;font-weight:600;color:var(--gray-800)}
p{font-size:.9rem;color:var(--gray-600);line-height:1.7}

/* GOV BANNER */
.gov-banner{background:var(--blue-800);padding:0 24px;height:var(--bh);display:flex;align-items:center;justify-content:space-between;font-size:.7rem;color:var(--blue-300);border-bottom:1px solid rgba(255,255,255,.08);position:fixed;top:0;left:0;right:0;z-index:101}
.gov-banner strong{color:rgba(255,255,255,.9)}
/* TOPBAR */
.topbar{position:fixed;top:var(--bh);left:0;right:0;z-index:100;height:var(--th);background:var(--blue-900);border-bottom:3px solid var(--blue-600);display:flex;align-items:center;padding:0 24px;gap:16px}
.topbar-brand{display:flex;align-items:center;gap:10px;flex:1}
.topbar-logo{width:36px;height:36px;background:var(--white);border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.topbar-title{font-family:var(--font-d);font-size:.88rem;font-weight:900;color:var(--white);letter-spacing:.01em;line-height:1.2}
.topbar-sub{font-size:.68rem;color:var(--blue-300);font-weight:400;letter-spacing:.03em;margin-top:1px}
.topbar-div{width:1px;height:28px;background:rgba(255,255,255,.15)}
.tnl{padding:6px 14px;font-size:.82rem;font-weight:500;color:rgba(255,255,255,.75);border-radius:var(--r-sm);border:none;background:none;transition:all .15s;cursor:pointer;text-decoration:none;display:inline-block}
.tnl:hover{color:var(--white);background:rgba(255,255,255,.1);text-decoration:none}
.tnl.active{color:var(--white);background:var(--blue-700)}
.cw{padding-top:calc(var(--th) + var(--bh))}
/* BUTTONS */
.btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 18px;font-size:.82rem;font-weight:600;border:none;border-radius:var(--r-sm);cursor:pointer;transition:all .15s;text-decoration:none;white-space:nowrap;font-family:var(--font-b);letter-spacing:.02em}
.btn-primary{background:var(--blue-700);color:var(--white)}.btn-primary:hover{background:var(--blue-800);color:var(--white);text-decoration:none}
.btn-secondary{background:var(--white);color:var(--blue-700);border:1.5px solid var(--blue-300)}.btn-secondary:hover{background:var(--blue-50);text-decoration:none}
.btn-outline{background:transparent;color:var(--gray-600);border:1.5px solid var(--gray-300)}.btn-outline:hover{background:var(--gray-50);text-decoration:none}
.btn-danger{background:var(--red);color:var(--white)}.btn-danger:hover{background:#991b1b;text-decoration:none}
.btn-danger-soft{background:var(--red-bg);color:var(--red)}.btn-success-soft{background:var(--green-bg);color:var(--green)}
.btn-sm{padding:5px 12px;font-size:.78rem}.btn-lg{padding:11px 28px;font-size:.9rem}.btn-full{width:100%;justify-content:center}
/* FORMS */
.form-group{margin-bottom:18px}
.form-label{display:block;font-size:.82rem;font-weight:600;color:var(--gray-700);margin-bottom:5px}
.req{color:var(--red)}
.form-hint{font-size:.76rem;color:var(--gray-400);margin-top:4px}
.fc,.fsel,.fta{width:100%;padding:8px 12px;font-size:.85rem;color:var(--gray-700);background:var(--white);border:1.5px solid var(--gray-300);border-radius:var(--r-sm);outline:none;transition:border-color .15s,box-shadow .15s;-webkit-appearance:none}
.fc:focus,.fsel:focus,.fta:focus{border-color:var(--blue-500);box-shadow:0 0 0 3px rgba(37,99,235,.12)}
.fc.is-invalid,.fsel.is-invalid{border-color:var(--red)}
.fsel{cursor:pointer;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;padding-right:28px}
.fta{resize:vertical;min-height:90px}
.invalid-feedback{font-size:.76rem;color:var(--red);margin-top:4px;display:none}
.is-invalid~.invalid-feedback,.is-invalid+.invalid-feedback{display:block}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:18px}
/* CARDS */
.card{background:var(--white);border:1px solid var(--gray-200);border-radius:var(--r-md);box-shadow:var(--sh-sm);overflow:hidden}
.card-header{padding:14px 20px;background:var(--white);border-bottom:1px solid var(--gray-200);display:flex;align-items:center;justify-content:space-between;gap:12px}
.card-htitle{font-size:.88rem;font-weight:700;color:var(--gray-900);display:flex;align-items:center;gap:8px}
.ico{width:26px;height:26px;background:var(--blue-100);color:var(--blue-700);border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:.8rem;flex-shrink:0}
.card-body{padding:20px}.card-footer{padding:12px 20px;border-top:1px solid var(--gray-200);background:var(--gray-50);display:flex;align-items:center;justify-content:flex-end;gap:8px}
/* BADGES */
.badge{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:3px;font-size:.74rem;font-weight:600;white-space:nowrap}
.bdot{width:6px;height:6px;border-radius:50%;background:currentColor;flex-shrink:0}
.bw{background:var(--amber-bg);color:var(--amber)}.ba{background:var(--green-bg);color:var(--green)}
.br{background:var(--red-bg);color:var(--red)}.bh{background:var(--blue-50);color:var(--blue-700)}.bt{background:var(--gray-200);color:var(--gray-600)}
/* TABLE */
.tbl-wrap{overflow-x:auto}
.dtbl{width:100%;border-collapse:collapse;font-size:.83rem}
.dtbl thead tr{background:var(--gray-50);border-bottom:2px solid var(--gray-200)}
.dtbl th{padding:10px 14px;font-size:.72rem;font-weight:700;color:var(--gray-500);text-transform:uppercase;letter-spacing:.06em;text-align:left;white-space:nowrap}
.dtbl td{padding:11px 14px;color:var(--gray-700);border-bottom:1px solid var(--gray-100);vertical-align:middle}
.dtbl tbody tr:hover td{background:var(--blue-50)}
.dtbl tbody tr:last-child td{border-bottom:none}
.tcode{font-family:'Courier New',monospace;font-size:.78rem;font-weight:700;color:var(--blue-700)}
/* ALERTS */
.alert{padding:10px 14px;border-radius:var(--r-sm);border-left:4px solid;font-size:.83rem;margin-bottom:14px;display:flex;align-items:flex-start;gap:9px}
.alert-warn{background:var(--amber-bg);border-color:#f59e0b;color:#92400e}
.alert-info{background:var(--blue-50);border-color:var(--blue-500);color:var(--blue-800)}
.alert-ok{background:var(--green-bg);border-color:#22c55e;color:#14532d}
.alert-err{background:var(--red-bg);border-color:var(--red);color:#7f1d1d}
.ai{flex-shrink:0}
/* INFO LIST */
.irow{display:flex;padding:8px 0;border-bottom:1px solid var(--gray-100);font-size:.83rem;gap:12px}
.irow:last-child{border-bottom:none}.ikey{width:150px;flex-shrink:0;color:var(--gray-500);font-weight:600}.ival{flex:1;color:var(--gray-800);word-break:break-word}
/* TIMELINE */
.tl-item{display:flex;gap:12px;margin-bottom:16px}.tl-item:last-child{margin-bottom:0}
.tl-track{display:flex;flex-direction:column;align-items:center;width:24px;flex-shrink:0}
.tl-dot{width:20px;height:20px;border-radius:50%;border:2.5px solid var(--gray-300);background:var(--white);z-index:1;flex-shrink:0;transition:all .2s}
.tl-dot.done{background:var(--blue-600);border-color:var(--blue-600)}.tl-dot.active{background:var(--amber-bg);border-color:#f59e0b}.tl-dot.rej{background:var(--red);border-color:var(--red)}.tl-dot.skip{background:var(--gray-200);border-color:var(--gray-300)}
.tl-line{width:2px;flex:1;background:var(--gray-200);margin-top:3px;min-height:20px}
.tl-content h4{font-size:.83rem;font-weight:600;color:var(--gray-800);margin-bottom:2px}.tl-content p{font-size:.76rem;color:var(--gray-400)}
/* FLASH */
.flash{position:fixed;bottom:24px;right:24px;z-index:999;max-width:360px;animation:slideIn .3s ease}
@keyframes slideIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}
/* MODAL */
.modal-bd{position:fixed;inset:0;background:rgba(15,23,42,.5);z-index:200;display:none;align-items:center;justify-content:center;padding:20px}
.modal-bd.show{display:flex}
.modal{background:var(--white);border-radius:var(--r-md);box-shadow:var(--sh-lg);width:100%;max-width:540px;max-height:92vh;overflow-y:auto}
.modal-hdr{padding:16px 20px;background:var(--blue-900);display:flex;align-items:center;justify-content:space-between;border-radius:var(--r-md) var(--r-md) 0 0}
.modal-ttl{font-family:var(--font-d);font-size:.95rem;font-weight:700;color:var(--white)}
.modal-cls{background:none;border:none;color:rgba(255,255,255,.7);font-size:1.2rem;line-height:1;padding:4px}
.modal-body{padding:20px}.modal-ftr{padding:14px 20px;border-top:1px solid var(--gray-200);display:flex;gap:8px;justify-content:flex-end;background:var(--gray-50);border-radius:0 0 var(--r-md) var(--r-md)}
/* UTILS */
.mt4{margin-top:4px}.mt8{margin-top:8px}.mt12{margin-top:12px}.mt16{margin-top:16px}.mt20{margin-top:20px}.mt24{margin-top:24px}
.mb16{margin-bottom:16px}.mb20{margin-bottom:20px}.mb24{margin-bottom:24px}
.flex{display:flex}.ic{align-items:center}.jb{justify-content:space-between}.gap8{gap:8px}.gap12{gap:12px}
.tsm{font-size:.78rem}.tmuted{color:var(--gray-400)}.bold{font-weight:700}
hr.div{border:none;border-top:1px solid var(--gray-200);margin:20px 0}
.empty-st{text-align:center;padding:48px 20px;color:var(--gray-400)}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.45}}
@media(max-width:768px){.form-row{grid-template-columns:1fr}}
</style>
<?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<div class="gov-banner">
  <span><strong>Pemerintah Kabupaten Sukoharjo</strong> &nbsp;|&nbsp; Gedung Wijaya — Pusat Pemerintahan</span>
  <span id="clockBanner"></span>
</div>
<header class="topbar">
  <button class="topbar-hamburger" onclick="toggleMobileNav()">☰</button>
  <div class="topbar-brand">
    <div class="topbar-logo">
      <img src="<?php echo e(asset('images/logo-sukoharjo.png')); ?>" width="26">
  </div>
    <div>
      <div class="topbar-title">SIJAMU</div>
      <div class="topbar-sub">Sistem Informasi Jadwal Tamu</div>
    </div>
  </div>
  <div class="topbar-div"></div>
  <nav class="topbar-nav">
    <a href="<?php echo e(route('home')); ?>" class="tnl <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Beranda</a>
    <a href="<?php echo e(route('reservasi.form')); ?>" class="tnl <?php echo e(request()->routeIs('reservasi.*') ? 'active' : ''); ?>">Buat Reservasi</a>
    <a href="<?php echo e(route('cek.form')); ?>" class="tnl <?php echo e(request()->routeIs('cek.*') ? 'active' : ''); ?>">Cek Status</a>
  </nav>
  <div class="topbar-actions">
    <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-secondary btn-sm">Masuk Admin</a>
  </div>
</header>

<!-- Mobile Navigation -->
<div class="mobile-nav-overlay" onclick="toggleMobileNav()"></div>
<nav class="mobile-nav">
  <div class="mobile-nav-list">
    <a href="<?php echo e(route('home')); ?>" class="mobile-nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">🏠 Beranda</a>
    <a href="<?php echo e(route('reservasi.form')); ?>" class="mobile-nav-link <?php echo e(request()->routeIs('reservasi.*') ? 'active' : ''); ?>">📝 Buat Reservasi</a>
    <a href="<?php echo e(route('cek.form')); ?>" class="mobile-nav-link <?php echo e(request()->routeIs('cek.*') ? 'active' : ''); ?>">🔍 Cek Status</a>
    <div class="mobile-nav-divider"></div>
    <a href="<?php echo e(route('admin.login')); ?>" class="mobile-nav-link">⚙️ Masuk Admin</a>
  </div>
  <div class="mobile-nav-footer">
    <div style="font-size:0.7rem;color:var(--gray-400)">SIJAMU v2.0</div>
    <div style="font-size:0.75rem;font-weight:600;color:var(--gray-700)">Pemerintah Kabupaten Sukoharjo</div>
  </div>
</nav>

<main class="cw">
  <?php if(session('success')): ?>
    <div class="flash"><div class="alert alert-ok"><span class="ai">✓</span><?php echo e(session('success')); ?></div></div>
  <?php endif; ?>
  <?php if(session('error')): ?>
    <div class="flash"><div class="alert alert-err"><span class="ai">✕</span><?php echo e(session('error')); ?></div></div>
  <?php endif; ?>

  <?php echo $__env->yieldContent('content'); ?>
</main>

<footer class="site-footer">
  <p>&copy; <?php echo e(date('Y')); ?> <strong>Pemerintah Kabupaten Sukoharjo</strong> &mdash; SIJAMU v2.0 &nbsp;|&nbsp; Gedung Wijaya, Jl. Jenderal Sudirman No. 199, Sukoharjo 57511</p>
</footer>

<script>
(function(){
  function tick(){
    var d=new Date();
    var el=document.getElementById('clockBanner');
    if(el) el.textContent=d.toLocaleDateString('id-ID',{weekday:'long',day:'numeric',month:'long',year:'numeric'})+' · '+d.toLocaleTimeString('id-ID');
  }
  tick(); setInterval(tick,1000);
  // Auto-dismiss flash
  setTimeout(function(){ var f=document.querySelector('.flash'); if(f) f.style.display='none'; },4000);
})();

// Mobile Navigation Toggle
function toggleMobileNav() {
  var overlay = document.querySelector('.mobile-nav-overlay');
  var nav = document.querySelector('.mobile-nav');
  overlay.classList.toggle('show');
  nav.classList.toggle('show');
}

// Close mobile nav when clicking a link
document.querySelectorAll('.mobile-nav-link').forEach(function(link) {
  link.addEventListener('click', function() {
    document.querySelector('.mobile-nav-overlay').classList.remove('show');
    document.querySelector('.mobile-nav').classList.remove('show');
  });
});
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Users/bellaaprilliaputriayu/Downloads/cb 1/resources/views/layouts/app.blade.php ENDPATH**/ ?>
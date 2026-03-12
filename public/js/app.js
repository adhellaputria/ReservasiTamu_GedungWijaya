/**
 * SIJAMU — Sistem Informasi Jadwal Tamu
 * app.js — Application Logic
 */

// ================================================================
// DEMO DATA STORE
// ================================================================
const DB = {
    reservasi: [
        { id:'WJY-0001', nama:'Drs. Budi Santoso, M.Si', hp:'081234567890', email:'budi.santoso@pemda.go.id', instansi:'Dinas Pendidikan Kab. Wonogiri', opd:'Dinas Pendidikan', petugas:'Kepala Dinas', tanggal:'2025-02-20', jam:'09:00 – 10:00', tujuan:'Koordinasi program beasiswa daerah tahun anggaran 2025', keterangan:'Membawa berkas RAB dan SK tim', status:'Menunggu', dokumen:'surat-permohonan.pdf', alasan:'', createdAt:'2025-02-18 08:30' },
        { id:'WJY-0002', nama:'Siti Rahayu, S.Farm., Apt.', hp:'087654321098', email:'siti.rahayu@puskesmas.id', instansi:'Puskesmas Ceria Sehat', opd:'Dinas Kesehatan', petugas:'Kasi Kefarmasian', tanggal:'2025-02-19', jam:'10:00 – 11:00', tujuan:'Pengajuan perizinan penambahan apotek unit', keterangan:'Dokumen perizinan lengkap', status:'Disetujui', dokumen:'berkas-izin-apotek.pdf', alasan:'', createdAt:'2025-02-17 14:15' },
        { id:'WJY-0003', nama:'Ahmad Fauzi, S.Pd.', hp:'082111222333', email:'ahmad.fauzi@smkn2.sch.id', instansi:'SMK Negeri 2 Sukoharjo', opd:'Dinas Pendidikan', petugas:'Staf Bidang Kurikulum', tanggal:'2025-02-19', jam:'13:00 – 14:00', tujuan:'Verifikasi data peserta didik untuk program beasiswa prestasi', keterangan:'', status:'Ditolak', dokumen:null, alasan:'Jadwal pejabat penuh hingga akhir bulan. Mohon reschedule ke minggu pertama Maret 2025.', createdAt:'2025-02-16 10:00' },
        { id:'WJY-0004', nama:'Ir. Dewi Kusuma Wati', hp:'089988776655', email:'dewi@cvmandiri.co.id', instansi:'PT Sumber Makmur Konstruksi', opd:'Dinas Pekerjaan Umum', petugas:'Kepala Bidang Jalan', tanggal:'2025-02-18', jam:'08:00 – 09:00', tujuan:'Konsultasi izin galian jalan untuk proyek jaringan fiber optik', keterangan:'Sudah membawa rencana lokasi galian', status:'Hadir', dokumen:'rencana-galian.pdf', alasan:'', createdAt:'2025-02-15 09:00' },
        { id:'WJY-0005', nama:'Hendra Wijaya', hp:'081999888777', email:'hendra.angkot@gmail.com', instansi:'Koperasi Angkutan Kota Maju', opd:'Dinas Perhubungan', petugas:'Kasi Angkutan Darat', tanggal:'2025-02-21', jam:'14:00 – 15:00', tujuan:'Perpanjangan izin trayek angkutan kota jalur 04B', keterangan:'Membawa berkas perpanjangan dan uji KIR terbaru', status:'Menunggu', dokumen:'berkas-trayek.pdf', alasan:'', createdAt:'2025-02-18 11:45' },
        { id:'WJY-0006', nama:'dr. Linda Puspitasari', hp:'082333444555', email:'linda.puspita@puskesmas.id', instansi:'Puskesmas Rawat Inap Bulu', opd:'Dinas Kesehatan', petugas:'Kepala Seksi Yankes', tanggal:'2025-02-20', jam:'11:00 – 12:00', tujuan:'Pelaporan capaian vaksinasi dan imunisasi bulan Januari 2025', keterangan:'', status:'Disetujui', dokumen:null, alasan:'', createdAt:'2025-02-17 13:00' },
        { id:'WJY-0007', nama:'Rudi Hermawan', hp:'085666777888', email:'rudi.hermawan@gmail.com', instansi:'', opd:'Dinas Sosial', petugas:'', tanggal:'2025-02-22', jam:'09:00 – 10:00', tujuan:'Pengajuan permohonan bantuan sosial keluarga tidak mampu', keterangan:'Membawa KTP, KK, dan SKTM dari Kelurahan', status:'Menunggu', dokumen:'sktm-kelurahan.pdf', alasan:'', createdAt:'2025-02-18 15:20' },
        { id:'WJY-0008', nama:'Maya Sari, S.Kom.', hp:'087111000999', email:'maya@digitalnusa.co.id', instansi:'CV Digital Nusantara Teknologi', opd:'Dinas Komunikasi dan Informatika', petugas:'Kepala Dinas', tanggal:'2025-02-19', jam:'15:00 – 16:00', tujuan:'Presentasi proposal digitalisasi layanan publik e-government', keterangan:'Sudah memiliki proposal lengkap dan demo aplikasi', status:'Disetujui', dokumen:'proposal-digitalisasi.pdf', alasan:'', createdAt:'2025-02-16 08:00' },
    ],
    opdList: [
        'Dinas Pendidikan',
        'Dinas Kesehatan',
        'Dinas Pekerjaan Umum',
        'Dinas Perhubungan',
        'Dinas Komunikasi dan Informatika',
        'Dinas Sosial',
        'Dinas Tenaga Kerja',
        'Dinas Lingkungan Hidup',
        'Badan Perencanaan Pembangunan Daerah',
        'Badan Kepegawaian Daerah',
        'Badan Keuangan Daerah',
        'Sekretariat Daerah',
    ]
};

let state = {
    currentFilter: 'all',
    searchQuery: '',
    pendingRejectId: null,
    uploadedFile: null,
    dashTab: 'overview',
    formStep: 1,
};

// ================================================================
// PAGE NAVIGATION
// ================================================================
function showPage(name) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    const page = document.getElementById('page-' + name);
    if (page) {
        page.classList.add('active');
        window.scrollTo({ top: 0, behavior: 'auto' });
    }

    const hamburger = document.getElementById('topbarHamburger');
    if (hamburger) hamburger.style.display = name === 'dashboard' ? 'flex' : 'none';

    if (name === 'form')      initFormPage();
    if (name === 'dashboard') initDashboard();
    if (name === 'check')     document.getElementById('checkCode').focus();

    // Update active nav links
    document.querySelectorAll('.topbar-nav-link').forEach(l => {
        l.classList.toggle('active', l.dataset.page === name);
    });
}

// ================================================================
// TOAST
// ================================================================
function toast(msg, type = 'info') {
    const icons = { info: 'ℹ', success: '✓', error: '✕', warning: '!' };
    const c = document.getElementById('toastContainer');
    const t = document.createElement('div');
    t.className = `toast ${type}`;
    t.innerHTML = `<span style="font-weight:800;font-size:0.9rem">${icons[type]||'ℹ'}</span> ${msg}`;
    c.appendChild(t);
    setTimeout(() => {
        t.classList.add('fade-out');
        setTimeout(() => t.remove(), 280);
    }, 3200);
}

// ================================================================
// HELPERS
// ================================================================

/**
 * Normalize status string for defensive comparison
 * Handles trim and case-insensitive matching
 * @param {string|null|undefined} status - Raw status string
 * @returns {string} Normalized status (lowercase, trimmed)
 */
function normalizeStatus(status) {
    if (!status || typeof status !== 'string') return '';
    return status.trim().toLowerCase();
}

/**
 * Safe DOM element getter - returns null if element not found
 * @param {string} id - Element ID
 * @returns {HTMLElement|null}
 */
function safeGetElementById(id) {
    return document.getElementById(id);
}

/**
 * Safe text content setter - avoids error if element not found
 * @param {string} id - Element ID
 * @param {string} text - Text content to set
 */
function safeSetText(id, text) {
    const el = document.getElementById(id);
    if (el) el.textContent = text;
}

/**
 * Safe inner HTML setter - avoids error if element not found
 * @param {string} id - Element ID
 * @param {string} html - HTML content to set
 */
function safeSetHtml(id, html) {
    const el = document.getElementById(id);
    if (el) el.innerHTML = html;
}

function formatDate(d) {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('id-ID', { weekday:'short', day:'numeric', month:'long', year:'numeric' });
}
function formatDateShort(d) {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
}
function genId() {
    return 'WJY-' + String(DB.reservasi.length + 1).padStart(4, '0');
}
function badgeHtml(status) {
    const map = {
        'Menunggu'   : ['badge-waiting',  'Menunggu'],
        'Disetujui'  : ['badge-approved', 'Disetujui'],
        'Ditolak'    : ['badge-rejected', 'Ditolak'],
        'Hadir'      : ['badge-present',  'Hadir'],
        'Tidak Hadir': ['badge-absent',   'Tidak Hadir'],
    };
    const [cls, lbl] = map[status] || ['', status];
    return `<span class="badge ${cls}"><span class="badge-dot"></span>${lbl}</span>`;
}

// ================================================================
// FORM — STEP WIZARD
// ================================================================
function initFormPage() {
    state.formStep = 1;
    state.uploadedFile = null;
    updateStepWizard(1);
    showFormStep(1);
    // Set min date to today
    const today = new Date().toISOString().split('T')[0];
    const tanggalInput = document.getElementById('fTanggal');
    if (tanggalInput) {
        tanggalInput.min = today;
        tanggalInput.value = '';
    }
    // Clear inputs
    ['fNama','fHp','fEmail','fInstansi','fTujuanSingkat','fOpd','fPetugas','fJam','fKeterangan']
        .forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
    clearUpload();
    clearAllErrors();
}

function showFormStep(step) {
    [1,2,3].forEach(i => {
        const el = document.getElementById('formStep' + i);
        if (el) el.style.display = (i === step) ? '' : 'none';
    });
}

function updateStepWizard(active) {
    [1,2,3].forEach(i => {
        const item  = document.getElementById('stepItem'  + i);
        const num   = document.getElementById('stepNum'   + i);
        const label = document.getElementById('stepLabel' + i);
        if (!item) return;
        item.className = 'step-item';
        if (i < active)      { item.classList.add('done');   num.textContent = '✓'; }
        else if (i === active){ item.classList.add('active'); num.textContent = i; }
        else                 { num.textContent = i; }
    });
}

function goNextStep(to) {
    if (to === 2 && !validateStep1()) return;
    if (to === 3 && !validateStep2()) return;
    if (to === 3) populateReview();
    state.formStep = to;
    updateStepWizard(to);
    showFormStep(to);
    window.scrollTo({ top: 0 });
}

function goPrevStep(to) {
    state.formStep = to;
    updateStepWizard(to);
    showFormStep(to);
}

function validateStep1() {
    let ok = true;
    const rules = [
        { id: 'fNama',          check: v => v.trim().length >= 3,               msg: 'Nama lengkap wajib diisi (min. 3 karakter)' },
        { id: 'fHp',            check: v => /^0[0-9]{8,12}$/.test(v.trim()),    msg: 'Nomor HP tidak valid (awali 0, 9-13 digit)' },
        { id: 'fEmail',         check: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()), msg: 'Format email tidak valid' },
        { id: 'fTujuanSingkat', check: v => v.trim().length >= 5,               msg: 'Tujuan kunjungan wajib diisi' },
    ];
    clearAllErrors();
    rules.forEach(r => {
        const el = document.getElementById(r.id);
        if (!el || !r.check(el.value)) { showError(r.id, r.msg); ok = false; }
    });
    if (!ok) toast('Harap lengkapi semua data yang wajib diisi.', 'error');
    return ok;
}

function validateStep2() {
    let ok = true;
    const rules = [
        { id: 'fOpd',    check: v => v !== '',              msg: 'Pilih OPD tujuan' },
        { id: 'fTanggal',check: v => v !== '',              msg: 'Pilih tanggal kunjungan' },
        { id: 'fJam',    check: v => v !== '',              msg: 'Pilih jam kunjungan' },
    ];
    rules.forEach(r => {
        const el = document.getElementById(r.id);
        if (!el || !r.check(el.value)) { showError(r.id, r.msg); ok = false; }
    });
    
    // Validasi: Tanggal tidak boleh sebelum hari ini
    const tanggalInput = document.getElementById('fTanggal');
    if (tanggalInput && tanggalInput.value) {
        const selectedDate = new Date(tanggalInput.value + 'T00:00:00');
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate < today) {
            showError('fTanggal', 'Tanggal reservasi tidak boleh sebelum hari ini.');
            ok = false;
        }
        
        // Jika tanggal = hari ini, cek jam
        if (selectedDate.getTime() === today.getTime()) {
            const jamSelect = document.getElementById('fJam');
            if (jamSelect && jamSelect.value) {
                // Parse jam yang dipilih (contoh: "08:00 – 09:00" -> "08:00")
                const jamValue = jamSelect.value.split(' – ')[0];
                const [hours, minutes] = jamValue.split(':').map(Number);
                const selectedTime = new Date();
                selectedTime.setHours(hours, minutes, 0, 0);
                const now = new Date();
                
                if (selectedTime < now) {
                    showError('fJam', 'Sesi jam yang dipilih sudah terlewat. Pilih sesi waktu lain yang masih tersedia.');
                    ok = false;
                }
            }
        }
    }
    
    if (!ok) toast('Harap lengkapi semua data yang wajib diisi.', 'error');
    return ok;
}

function showError(id, msg) {
    const el  = document.getElementById(id);
    const err = document.getElementById('err' + id.charAt(0).toUpperCase() + id.slice(1));
    if (el)  el.classList.add('is-invalid');
    if (err) { err.textContent = msg; err.style.display = 'block'; }
}
function clearError(id) {
    const el  = document.getElementById(id);
    const errId = 'err' + id.charAt(0).toUpperCase() + id.slice(1);
    const err = document.getElementById(errId);
    if (el)  el.classList.remove('is-invalid');
    if (err) err.style.display = 'none';
}
function clearAllErrors() {
    document.querySelectorAll('.form-control.is-invalid, .form-select.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');
}

function populateReview() {
    const get = id => document.getElementById(id)?.value || '—';
    document.getElementById('revNama').textContent    = get('fNama');
    document.getElementById('revEmail').textContent   = get('fEmail');
    document.getElementById('revOpd').textContent     = get('fOpd');
    document.getElementById('revTanggal').textContent = formatDate(get('fTanggal'));
    document.getElementById('revJam').textContent     = get('fJam');
    document.getElementById('revTujuan').textContent  = get('fTujuanSingkat');
}

// File upload
function handleFileChange(e) {
    const file = e.target.files[0];
    if (!file) return;
    if (file.size > 5 * 1024 * 1024) { toast('Ukuran file melebihi batas 5 MB.', 'error'); return; }
    state.uploadedFile = file;
    document.getElementById('uploadFileName').textContent = file.name;
    document.getElementById('uploadArea').style.display = 'none';
    document.getElementById('uploadPreview').style.display = 'flex';
    toast('Berkas berhasil diunggah.', 'success');
}
function clearUpload() {
    state.uploadedFile = null;
    const area = document.getElementById('uploadArea');
    const prev = document.getElementById('uploadPreview');
    const inp  = document.getElementById('fileInput');
    if (area) area.style.display = '';
    if (prev) prev.style.display = 'none';
    if (inp)  inp.value = '';
}

// Drag-drop
function initUploadDrag() {
    const area = document.getElementById('uploadArea');
    if (!area) return;
    area.addEventListener('dragover', e => { e.preventDefault(); area.classList.add('dragover'); });
    area.addEventListener('dragleave', () => area.classList.remove('dragover'));
    area.addEventListener('drop', e => {
        e.preventDefault(); area.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) handleFileChange({ target: { files: [file] } });
    });
}

// Submit form
function submitReservasi() {
    const btn = document.getElementById('btnSubmit');
    btn.classList.add('btn-loading');
    btn.disabled = true;

    setTimeout(() => {
        const id = genId();
        DB.reservasi.unshift({
            id,
            nama:     document.getElementById('fNama').value,
            hp:       document.getElementById('fHp').value,
            email:    document.getElementById('fEmail').value,
            instansi: document.getElementById('fInstansi').value,
            opd:      document.getElementById('fOpd').value,
            petugas:  document.getElementById('fPetugas').value,
            tanggal:  document.getElementById('fTanggal').value,
            jam:      document.getElementById('fJam').value,
            tujuan:   document.getElementById('fTujuanSingkat').value,
            keterangan: document.getElementById('fKeterangan').value,
            status:   'Menunggu',
            dokumen:  state.uploadedFile ? state.uploadedFile.name : null,
            alasan:   '',
            createdAt: new Date().toLocaleString('id-ID'),
        });
        btn.classList.remove('btn-loading');
        btn.disabled = false;

        document.getElementById('successCode').textContent  = id;
        document.getElementById('successEmail').textContent = document.getElementById('fEmail').value;
        showPage('success');
        toast('Reservasi berhasil dikirim!', 'success');
    }, 1800);
}

// ================================================================
// CHECK STATUS
// ================================================================
function checkStatus() {
    const code = document.getElementById('checkCode').value.trim().toUpperCase();
    const resultEl  = document.getElementById('statusResult');
    const notFoundEl = document.getElementById('statusNotFound');
    resultEl.style.display = 'none';
    notFoundEl.style.display = 'none';

    if (!code) { toast('Masukkan kode reservasi terlebih dahulu.', 'error'); return; }
    const item = DB.reservasi.find(r => r.id === code);
    if (!item) { notFoundEl.style.display = 'block'; return; }

    renderStatusResult(item);
    resultEl.style.display = 'block';
    resultEl.classList.add('anim-fade');
}

function renderStatusResult(r) {
    document.getElementById('srNama').textContent      = r.nama;
    document.getElementById('srKodeOpd').textContent   = r.id + ' · ' + r.opd;
    document.getElementById('srBadge').innerHTML       = badgeHtml(r.status);
    document.getElementById('srTanggal').textContent   = formatDate(r.tanggal);
    document.getElementById('srJam').textContent       = r.jam;
    document.getElementById('srTujuan').textContent    = r.tujuan;
    document.getElementById('srOpd').textContent       = r.opd;
    document.getElementById('srPetugas').textContent   = r.petugas || '—';

    // Timeline
    const steps = [
        { label:'Reservasi Diajukan',      sub:'Formulir berhasil diterima sistem',       done: true,  reject: false },
        { label:'Ditinjau Admin OPD',      sub:'Dalam proses peninjauan',                done: r.status !== 'Menunggu', reject: false },
        { label: r.status === 'Ditolak' ? 'Pengajuan Ditolak' : 'Reservasi Disetujui',
                                           sub: r.status === 'Ditolak' ? 'Pengajuan tidak dapat dikabulkan' : 'Email konfirmasi telah dikirim',
                                                                                          done: ['Disetujui','Hadir','Ditolak'].includes(r.status), reject: r.status === 'Ditolak' },
        { label:'Tamu Hadir & Terverifikasi', sub:'Verifikasi kehadiran oleh petugas',   done: r.status === 'Hadir', reject: false },
    ];
    const tlEl = document.getElementById('srTimeline');
    tlEl.innerHTML = steps.map((s, i) => `
        <div class="tl-item">
            <div class="tl-track">
                <div class="tl-dot ${s.reject ? 'reject' : s.done ? 'done' : i === steps.findIndex(x => !x.done) ? 'active' : ''}"></div>
                ${i < steps.length - 1 ? '<div class="tl-line"></div>' : ''}
            </div>
            <div class="tl-content mt-4">
                <h4>${s.label}</h4>
                <p>${s.sub}</p>
            </div>
        </div>
    `).join('');

    const alasanBox = document.getElementById('srAlasanBox');
    if (r.status === 'Ditolak' && r.alasan) {
        document.getElementById('srAlasan').textContent = r.alasan;
        alasanBox.style.display = 'block';
    } else {
        alasanBox.style.display = 'none';
    }
}

// ================================================================
// LOGIN
// ================================================================
function doLogin() {
    const btn  = document.getElementById('btnLogin');
    const user = document.getElementById('loginUser').value;
    const pass = document.getElementById('loginPass').value;
    const err  = document.getElementById('loginError');
    err.style.display = 'none';
    btn.classList.add('btn-loading');
    btn.disabled = true;

    setTimeout(() => {
        btn.classList.remove('btn-loading');
        btn.disabled = false;
        if (user === 'admin' && pass === 'admin123') {
            showPage('dashboard');
            toast('Selamat datang kembali, Administrator.', 'success');
        } else {
            err.style.display = 'flex';
            toast('Username atau kata sandi salah.', 'error');
        }
    }, 1200);
}

function doLogout() {
    showPage('home');
    toast('Anda telah keluar dari sistem.', 'info');
}

// ================================================================
// DASHBOARD
// ================================================================
function initDashboard() {
    showDashTab(state.dashTab);
}

function showDashTab(tab) {
    state.dashTab = tab;
    document.querySelectorAll('.dash-tab-pane').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));

    const pane = document.getElementById('tab-' + tab);
    const link = document.getElementById('sl-' + tab);
    if (pane) { pane.style.display = ''; pane.classList.add('anim-fade'); }
    if (link) link.classList.add('active');

    if (tab === 'overview')    renderOverview();
    if (tab === 'reservasi')   renderReservasiTab();
    if (tab === 'laporan')     renderLaporanEmpty();
    if (tab === 'verifikasi')  renderVerifikasiTab();
}

function toggleSidebar() {
    document.getElementById('dashSidebar').classList.toggle('open');
}

// KPIs
function getKpis() {
    return {
        menunggu:    DB.reservasi.filter(r => normalizeStatus(r.status) === 'menunggu').length,
        disetujui:   DB.reservasi.filter(r => normalizeStatus(r.status) === 'disetujui').length,
        ditolak:     DB.reservasi.filter(r => normalizeStatus(r.status) === 'ditolak').length,
        hadir:       DB.reservasi.filter(r => normalizeStatus(r.status) === 'hadir').length,
        tidak_hadir: DB.reservasi.filter(r => normalizeStatus(r.status) === 'tidak hadir').length,
    };
}

function renderKpis() {
    const k = getKpis();
    
    // Safe element updates with null checks
    const elMenunggu = document.getElementById('kpiMenunggu');
    const elDisetujui = document.getElementById('kpiDisetujui');
    const elDitolak = document.getElementById('kpiDitolak');
    const elHadir = document.getElementById('kpiHadir');
    const elTidakHadir = document.getElementById('kpiTidakHadir');
    
    if (elMenunggu) elMenunggu.textContent = k.menunggu;
    if (elDisetujui) elDisetujui.textContent = k.disetujui;
    if (elDitolak) elDitolak.textContent = k.ditolak;
    if (elHadir) elHadir.textContent = k.hadir;
    if (elTidakHadir) elTidakHadir.textContent = k.tidak_hadir;
}

function renderOverview() {
    renderKpis();
    renderMiniChart();
    
    // Safe DOM element access for renderTable
    const recentTableEl = document.getElementById('recentTable');
    if (recentTableEl) {
        renderTable(recentTableEl, DB.reservasi.slice(0, 5), false);
    }
    
    // Also call renderStatusSummary for dashboard status overview
    renderStatusSummary();
}

/**
 * Render status summary for dashboard
 * Displays status breakdown with defensive checks
 */
function renderStatusSummary() {
    const k = getKpis();
    const total = k.menunggu + k.disetujui + k.ditolak + k.hadir + k.tidak_hadir;
    
    // Update status summary elements if they exist
    const statusSummaryElements = {
        'statusMenunggu': k.menunggu,
        'statusDisetujui': k.disetujui,
        'statusDitolak': k.ditolak,
        'statusHadir': k.hadir,
        'statusTidakHadir': k.tidak_hadir,
    };
    
    Object.entries(statusSummaryElements).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    });
}

function renderMiniChart() {
    const days = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
    const vals = [3, 5, 4, 7, 6, 2, 4];
    const max  = Math.max(...vals);
    const container = document.getElementById('chartBars');
    const labels    = document.getElementById('chartLabels');
    if (!container) return;
    container.innerHTML = vals.map((v, i) => `
        <div class="chart-bar-wrap">
            <div class="chart-bar-val">${v}</div>
            <div class="chart-bar-fill" style="height:${Math.round((v/max)*88)}px"></div>
        </div>
    `).join('');
    labels.innerHTML = days.map(d => `<div class="chart-label" style="flex:1;text-align:center">${d}</div>`).join('');
}

// ================================================================
// TABLE RENDERER
// ================================================================
function renderTable(el, data, showActions) {
    if (!el) return;
    const thead = `
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Tamu / Instansi</th>
                <th>OPD Tujuan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
    `;
    const rows = data.length === 0
        ? `<tr><td colspan="7"><div class="empty-state"><div class="empty-icon">📋</div><p>Tidak ada data reservasi.</p></div></td></tr>`
        : data.map(r => `
            <tr>
                <td><span class="table-code">${r.id}</span></td>
                <td class="table-name">
                    <strong>${r.nama}</strong>
                    <span>${r.instansi || r.email}</span>
                </td>
                <td style="font-size:0.8rem">${r.opd}</td>
                <td style="white-space:nowrap;font-size:0.8rem">${formatDateShort(r.tanggal)}</td>
                <td style="white-space:nowrap;font-size:0.78rem">${r.jam}</td>
                <td>${badgeHtml(r.status)}</td>
                <td>
                    <div class="table-actions">
                        <button class="btn btn-sm btn-secondary" onclick="openDetailModal('${r.id}')">Detail</button>
                        ${showActions && r.status === 'Menunggu' ? `
                            <button class="btn btn-sm btn-success-soft" onclick="approveReservasi('${r.id}')">Setujui</button>
                            <button class="btn btn-sm btn-danger-soft" onclick="openRejectModal('${r.id}')">Tolak</button>
                        ` : ''}
                    </div>
                </td>
            </tr>
        `).join('');
    el.innerHTML = thead + '<tbody>' + rows + '</tbody>';
}

// ================================================================
// RESERVASI TAB
// ================================================================
function renderReservasiTab() {
    renderKpis();
    applyFilter();
}

function applyFilter() {
    let data = DB.reservasi;
    if (state.currentFilter !== 'all') {
        // Use defensive filter with normalizeStatus for case-insensitive comparison
        const normalizedFilter = normalizeStatus(state.currentFilter);
        data = data.filter(r => normalizeStatus(r.status) === normalizedFilter);
    }
    if (state.searchQuery) {
        const q = state.searchQuery.toLowerCase();
        data = data.filter(r =>
            r.nama.toLowerCase().includes(q) ||
            r.id.toLowerCase().includes(q) ||
            r.opd.toLowerCase().includes(q)
        );
    }
    const countEl = document.getElementById('reservasiCount');
    if (countEl) countEl.textContent = data.length + ' Data';
    renderTable(document.getElementById('mainTable'), data, true);
}

function setFilter(status, el) {
    state.currentFilter = status;
    document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    applyFilter();
}

function onSearch(val) {
    state.searchQuery = val;
    applyFilter();
}

// ================================================================
// APPROVE / REJECT
// ================================================================
function approveReservasi(id) {
    const r = DB.reservasi.find(x => x.id === id);
    if (!r) return;
    r.status = 'Disetujui';
    renderReservasiTab();
    renderKpis();
    toast(`Reservasi ${id} telah disetujui. Email konfirmasi terkirim.`, 'success');
}

function openRejectModal(id) {
    state.pendingRejectId = id;
    document.getElementById('rejectReason').value = '';
    showModal('rejectModal');
}

function confirmReject() {
    const r = DB.reservasi.find(x => x.id === state.pendingRejectId);
    if (!r) return;
    r.status = 'Ditolak';
    r.alasan = document.getElementById('rejectReason').value.trim() || 'Tidak ada keterangan.';
    hideModal('rejectModal');
    renderReservasiTab();
    renderKpis();
    toast(`Reservasi ${state.pendingRejectId} ditolak. Email pemberitahuan terkirim.`, 'error');
}

// ================================================================
// DETAIL MODAL
// ================================================================
function openDetailModal(id) {
    const r = DB.reservasi.find(x => x.id === id);
    if (!r) return;

    document.getElementById('modalDetailTitle').textContent = 'Detail Reservasi — ' + r.id;
    document.getElementById('modalDetailBody').innerHTML = `
        <div class="info-list">
            <div class="info-row"><span class="info-key">Nama Lengkap</span><span class="info-val">${r.nama}</span></div>
            <div class="info-row"><span class="info-key">Nomor HP</span><span class="info-val">${r.hp}</span></div>
            <div class="info-row"><span class="info-key">Alamat Email</span><span class="info-val">${r.email}</span></div>
            <div class="info-row"><span class="info-key">Instansi</span><span class="info-val">${r.instansi || '—'}</span></div>
            <hr class="divider">
            <div class="info-row"><span class="info-key">OPD Tujuan</span><span class="info-val">${r.opd}</span></div>
            <div class="info-row"><span class="info-key">Petugas Dituju</span><span class="info-val">${r.petugas || '—'}</span></div>
            <div class="info-row"><span class="info-key">Tanggal</span><span class="info-val">${formatDate(r.tanggal)}</span></div>
            <div class="info-row"><span class="info-key">Jam</span><span class="info-val">${r.jam}</span></div>
            <div class="info-row"><span class="info-key">Tujuan Kunjungan</span><span class="info-val">${r.tujuan}</span></div>
            <div class="info-row"><span class="info-key">Keterangan</span><span class="info-val">${r.keterangan || '—'}</span></div>
            <div class="info-row"><span class="info-key">Berkas Dokumen</span><span class="info-val">${r.dokumen ? '📎 ' + r.dokumen : '—'}</span></div>
            <div class="info-row"><span class="info-key">Status</span><span class="info-val">${badgeHtml(r.status)}</span></div>
            <div class="info-row"><span class="info-key">Waktu Pengajuan</span><span class="info-val">${r.createdAt}</span></div>
            ${r.alasan ? `<div class="info-row"><span class="info-key">Alasan Penolakan</span><span class="info-val" style="color:var(--red)">${r.alasan}</span></div>` : ''}
        </div>
    `;

    let footer = `<button class="btn btn-outline" onclick="hideModal('detailModal')">Tutup</button>`;
    if (r.status === 'Menunggu') {
        footer += `
            <button class="btn btn-danger-soft" onclick="openRejectModal('${r.id}'); hideModal('detailModal')">Tolak</button>
            <button class="btn btn-primary" onclick="approveReservasi('${r.id}'); hideModal('detailModal')">Setujui</button>
        `;
    }
    document.getElementById('modalDetailFooter').innerHTML = footer;
    showModal('detailModal');
}

// ================================================================
// LAPORAN
// ================================================================
function renderLaporanEmpty() {}

function generateLaporan() {
    const btn = document.getElementById('btnGenerate');
    btn.classList.add('btn-loading'); btn.disabled = true;

    setTimeout(() => {
        btn.classList.remove('btn-loading'); btn.disabled = false;
        const opd     = document.getElementById('laporanOpd').value || 'Semua OPD';
        const periode = document.getElementById('laporanPeriode').value;
        const data    = opd === 'Semua OPD' ? DB.reservasi : DB.reservasi.filter(r => r.opd === opd);
        const k       = { m: data.filter(r=>r.status==='Menunggu').length, d: data.filter(r=>r.status==='Disetujui').length, t: data.filter(r=>r.status==='Ditolak').length, h: data.filter(r=>r.status==='Hadir').length };

        document.getElementById('laporanResult').innerHTML = `
            <div class="card anim-fade">
                <div class="report-header">
                    <div>
                        <div style="font-family:var(--font-display);font-weight:700;font-size:1rem">${opd}</div>
                        <div class="report-meta">Laporan Reservasi Tamu · ${periode} · Total ${data.length} data</div>
                    </div>
                    <button class="btn btn-secondary btn-sm" onclick="toast('Fitur cetak PDF tersedia di produksi.','info')">Cetak / Unduh</button>
                </div>
                <div class="card-body">
                    <div class="kpi-grid" style="grid-template-columns:repeat(4,1fr);margin-bottom:20px">
                        <div class="kpi-card amber"><div class="kpi-icon">⏳</div><div class="kpi-content"><div class="kpi-num">${k.m}</div><div class="kpi-label">Menunggu</div></div></div>
                        <div class="kpi-card green"><div class="kpi-icon">✔</div><div class="kpi-content"><div class="kpi-num">${k.d}</div><div class="kpi-label">Disetujui</div></div></div>
                        <div class="kpi-card red"  ><div class="kpi-icon">✕</div><div class="kpi-content"><div class="kpi-num">${k.t}</div><div class="kpi-label">Ditolak</div></div></div>
                        <div class="kpi-card blue" ><div class="kpi-icon">👤</div><div class="kpi-content"><div class="kpi-num">${k.h}</div><div class="kpi-label">Hadir</div></div></div>
                    </div>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead><tr><th>Kode</th><th>Nama Tamu</th><th>OPD</th><th>Tanggal</th><th>Tujuan</th><th>Status</th></tr></thead>
                            <tbody>
                                ${data.map(r=>`
                                    <tr>
                                        <td><span class="table-code">${r.id}</span></td>
                                        <td><strong style="font-size:0.82rem">${r.nama}</strong></td>
                                        <td style="font-size:0.78rem">${r.opd}</td>
                                        <td style="white-space:nowrap;font-size:0.78rem">${formatDateShort(r.tanggal)}</td>
                                        <td style="font-size:0.78rem;max-width:200px">${r.tujuan}</td>
                                        <td>${badgeHtml(r.status)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
        toast('Laporan berhasil digenerate.', 'success');
    }, 1400);
}

// ================================================================
// VERIFIKASI KEHADIRAN
// ================================================================
function renderVerifikasiTab() {
    const approved = DB.reservasi.filter(r => r.status === 'Disetujui');
    const el = document.getElementById('verifyScheduleTable');
    if (!el) return;
    const thead = `<thead><tr><th>Kode</th><th>Nama Tamu</th><th>OPD</th><th>Jam</th><th>Aksi</th></tr></thead>`;
    const rows = approved.length === 0
        ? `<tr><td colspan="5"><div class="empty-state"><div class="empty-icon">📋</div><p>Tidak ada tamu terjadwal.</p></div></td></tr>`
        : approved.map(r => `
            <tr>
                <td><span class="table-code">${r.id}</span></td>
                <td class="table-name"><strong>${r.nama}</strong><span>${r.instansi || r.email}</span></td>
                <td style="font-size:0.8rem">${r.opd}</td>
                <td style="font-size:0.8rem">${r.jam}</td>
                <td><button class="btn btn-sm btn-success-soft" onclick="markHadir('${r.id}')">Konfirmasi Hadir</button></td>
            </tr>
        `).join('');
    el.innerHTML = thead + '<tbody>' + rows + '</tbody>';
}

function doVerify() {
    const code   = document.getElementById('verifyCode').value.trim().toUpperCase();
    const result = document.getElementById('verifyResult');
    const today  = new Date().toISOString().split('T')[0];
    
    result.innerHTML = '';

    if (!code) { toast('Masukkan kode reservasi.', 'error'); return; }
    const r = DB.reservasi.find(x => x.id === code);

    if (!r) {
        result.innerHTML = `<div class="alert alert-danger"><span class="alert-icon">✕</span> Kode reservasi <strong>${code}</strong> tidak ditemukan dalam sistem.</div>`;
        return;
    }
    if (r.status === 'Hadir') {
        result.innerHTML = `<div class="alert alert-info"><span class="alert-icon">ℹ</span> Tamu <strong>${r.nama}</strong> sudah tercatat hadir.</div>`;
        return;
    }
    if (r.status === 'Tidak Hadir') {
        result.innerHTML = `<div class="alert alert-warning"><span class="alert-icon">!</span> Tamu <strong>${r.nama}</strong> berstatus <strong>Tidak Hadir</strong> (tidak hadir pada tanggal reservasi).</div>`;
        return;
    }
    if (r.status === 'Ditolak') {
        result.innerHTML = `<div class="alert alert-warning"><span class="alert-icon">!</span> Reservasi berstatus <strong>Ditolak</strong>. Hanya reservasi yang disetujui dapat diverifikasi.</div>`;
        return;
    }
    if (r.status === 'Menunggu') {
        result.innerHTML = `<div class="alert alert-warning"><span class="alert-icon">!</span> Reservasi berstatus <strong>Menunggu</strong>. Harap tunggu persetujuan terlebih dahulu.</div>`;
        return;
    }
    
    // Validasi tanggal: hanya bisa konfirmasi di hari-H
    if (r.tanggal < today) {
        result.innerHTML = `<div class="alert alert-warning"><span class="alert-icon">!</span> Tanggal reservasi (${formatDate(r.tanggal)}) sudah terlewati. Tamu tidak hadir pada hari-H.</div>`;
        return;
    }
    if (r.tanggal > today) {
        result.innerHTML = `<div class="alert alert-warning"><span class="alert-icon">!</span> Tanggal reservasi (${formatDate(r.tanggal)}) belum tiba. Konfirmasi hadir hanya dapat dilakukan pada hari-H.</div>`;
        return;
    }

    result.innerHTML = `
        <div class="card anim-fade" style="border-left:4px solid var(--green)">
            <div class="card-body">
                <div class="flex justify-between items-center flex-wrap gap-12">
                    <div>
                        <div style="font-weight:700;font-size:0.95rem;color:var(--gray-900)">${r.nama}</div>
                        <div style="font-size:0.78rem;color:var(--gray-400);margin-top:2px">${r.id} · ${r.opd}</div>
                        <div style="font-size:0.82rem;color:var(--gray-600);margin-top:6px">${r.tujuan}</div>
                        <div style="font-size:0.78rem;color:var(--gray-400);margin-top:3px">${formatDate(r.tanggal)} · ${r.jam}</div>
                    </div>
                    <button class="btn btn-primary" onclick="markHadir('${r.id}')">Konfirmasi Hadir</button>
                </div>
            </div>
        </div>
    `;
}

function markHadir(id) {
    const r = DB.reservasi.find(x => x.id === id);
    if (!r) return;
    
    const today = new Date().toISOString().split('T')[0];
    
    // Validasi: Konfirmasi hadir hanya bisa dilakukan pada tanggal reservasi (hari-H)
    if (r.tanggal < today) {
        toast('Tanggal reservasi sudah terlewati. Tidak dapat mengkonfirmasi kehadiran.', 'error');
        return;
    }
    
    if (r.tanggal > today) {
        toast('Tanggal reservasi belum tiba. Konfirmasi hadir hanya dapat dilakukan pada hari-H.', 'error');
        return;
    }
    
    r.status = 'Hadir';
    renderVerifikasiTab();
    renderKpis();
    document.getElementById('verifyResult').innerHTML = `<div class="alert alert-success"><span class="alert-icon">✔</span> Kehadiran <strong>${r.nama}</strong> (${id}) berhasil dicatat.</div>`;
    document.getElementById('verifyCode').value = '';
    toast(`Kehadiran ${r.nama} berhasil dikonfirmasi.`, 'success');
}

// ================================================================
// MODAL HELPERS
// ================================================================
function showModal(id) { document.getElementById(id).classList.add('show'); }
function hideModal(id) { document.getElementById(id).classList.remove('show'); }

// Close on backdrop click
document.addEventListener('click', e => {
    if (e.target.classList.contains('modal-backdrop')) {
        e.target.classList.remove('show');
    }
});

// ================================================================
// ANIMATE COUNTER
// ================================================================
function animCounter(el, target) {
    let n = 0;
    const step = () => {
        n = Math.min(n + Math.ceil(target / 25), target);
        el.textContent = n;
        if (n < target) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
}

// ================================================================
// INIT
// ================================================================
window.addEventListener('DOMContentLoaded', () => {
    // Counters on home
    setTimeout(() => {
        animCounter(document.getElementById('statTotal'),    248);
        animCounter(document.getElementById('statApproved'), 184);
        animCounter(document.getElementById('statOPD'),       12);
    }, 200);

    initUploadDrag();

    // Live input clearing
    document.querySelectorAll('.form-control, .form-select').forEach(el => {
        el.addEventListener('input', () => { el.classList.remove('is-invalid'); });
    });
});

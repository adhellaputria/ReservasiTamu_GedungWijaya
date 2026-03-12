<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Reservasi;
use App\Models\Opd;
use App\Models\RiwayatStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ============================================================
    // AUTH METHODS
    // ============================================================

    public function loginForm()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::with('opd')
            ->where('username', $request->username)
            ->where('is_aktif', true)
            ->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['login' => 'Username atau kata sandi tidak sesuai.'])->withInput();
        }

        $sessionData = [
            'admin_id' => $admin->id,
            'admin_nama' => $admin->nama_lengkap,
            'admin_username' => $admin->username,
            'admin_role' => $admin->role,
        ];

        // Add OPD-specific session data only for admin_opd
        if ($admin->role === Admin::ROLE_ADMIN_OPD) {
            $sessionData['admin_opd_id'] = $admin->opd_id;
            $sessionData['admin_opd_nama'] = $admin->opd->nama ?? '';
        }

        session($sessionData);
        $admin->update(['last_login' => now()]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'admin_id', 'admin_nama', 'admin_username', 
            'admin_opd_id', 'admin_opd_nama', 'admin_role'
        ]);
        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar.');
    }

    // ============================================================
    // DASHBOARD
    // ============================================================

    public function dashboard()
    {
        $role = session('admin_role');
        
        if ($role === Admin::ROLE_SUPERADMIN) {
            return $this->superadminDashboard();
        }

        return $this->adminOpdDashboard();
    }

    private function superadminDashboard()
    {
        $kpi = [
            'total_opd' => Opd::where('is_aktif', true)->count(),
            'total_admin' => Admin::where('role', Admin::ROLE_ADMIN_OPD)->count(),
            'total_reservasi' => Reservasi::count(),
            'menunggu' => Reservasi::where('status', 'Menunggu')->count(),
            'disetujui' => Reservasi::where('status', 'Disetujui')->count(),
            'ditolak' => Reservasi::where('status', 'Ditolak')->count(),
            'hadir' => Reservasi::where('status', 'Hadir')->count(),
            'tidak_hadir' => Reservasi::where('status', 'Tidak Hadir')->count(),
        ];

        $grafik = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::today()->subDays($i);
            $grafik[] = [
                'label' => $tgl->translatedFormat('D'),
                'nilai' => Reservasi::whereDate('created_at', $tgl)->count(),
            ];
        }

        $terbaru = Reservasi::with('opd')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('kpi', 'grafik', 'terbaru'));
    }

    private function adminOpdDashboard()
    {
        $opdId = session('admin_opd_id');

        $kpi = [
            'menunggu' => Reservasi::where('opd_id', $opdId)->where('status', 'Menunggu')->count(),
            'disetujui' => Reservasi::where('opd_id', $opdId)->where('status', 'Disetujui')->count(),
            'ditolak' => Reservasi::where('opd_id', $opdId)->where('status', 'Ditolak')->count(),
            'hadir' => Reservasi::where('opd_id', $opdId)->where('status', 'Hadir')->count(),
            'tidak_hadir' => Reservasi::where('opd_id', $opdId)->where('status', 'Tidak Hadir')->count(),
        ];

        $grafik = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::today()->subDays($i);
            $grafik[] = [
                'label' => $tgl->translatedFormat('D'),
                'nilai' => Reservasi::where('opd_id', $opdId)->whereDate('created_at', $tgl)->count(),
            ];
        }

        $terbaru = Reservasi::with('opd')
            ->where('opd_id', $opdId)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('kpi', 'grafik', 'terbaru'));
    }

    // ============================================================
    // RUANGAN/OPD MANAGEMENT (Superadmin Only)
    // ============================================================

    public function ruanganIndex(Request $request)
    {
        $query = Opd::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('nama', 'like', "%$q%")
                    ->orWhere('kode', 'like', "%$q%");
            });
        }

        $ruangan = $query->orderBy('nama')->paginate(20)->withQueryString();
        return view('admin.ruangan.index', compact('ruangan'));
    }

    public function ruanganCreate()
    {
        return view('admin.ruangan.create');
    }

    public function ruanganStore(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:opd,kode',
            'nama' => 'required|string|max:150',
            'lantai' => 'required|integer|min:1|max:20',
            'telepon' => 'nullable|string|max:20',
            'email_opd' => 'nullable|email|max:100',
            'kepala' => 'nullable|string|max:100',
            'is_aktif' => 'required|boolean',
        ]);

        Opd::create($validated);

        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan/OPD berhasil ditambahkan.');
    }

    public function ruanganEdit($id)
    {
        $opd = Opd::findOrFail($id);
        return view('admin.ruangan.edit', compact('opd'));
    }

    public function ruanganUpdate(Request $request, $id)
    {
        $opd = Opd::findOrFail($id);

        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:opd,kode,' . $id,
            'nama' => 'required|string|max:150',
            'lantai' => 'required|integer|min:1|max:20',
            'telepon' => 'nullable|string|max:20',
            'email_opd' => 'nullable|email|max:100',
            'kepala' => 'nullable|string|max:100',
            'is_aktif' => 'required|boolean',
        ]);

        $opd->update($validated);

        // ✅ REDIRECT TO INDEX AFTER EDIT (per request)
        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan/OPD berhasil diperbarui.');
    }

    public function ruanganDestroy($id)
    {
        $opd = Opd::findOrFail($id);
        
        // Check if there are any active reservations
        $reservasiCount = Reservasi::where('opd_id', $id)->count();
        
        if ($reservasiCount > 0) {
            return back()->with('error', 'Tidak dapat menghapus Ruangan/OPD karena masih ada data reservasi terkait.');
        }

        // Check if there are admin OPD assigned
        $adminCount = Admin::where('opd_id', $id)->count();
        
        if ($adminCount > 0) {
            return back()->with('error', 'Tidak dapat menghapus Ruangan/OPD karena masih ada Admin OPD terkait.');
        }

        // Hard delete (permanent delete)
        $opd->forceDelete();

        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan/OPD berhasil dihapus permanen.');
    }

    // ============================================================
    // ADMIN OPD MANAGEMENT (Superadmin Only)
    // ============================================================

    public function adminOpdIndex(Request $request)
    {
        $query = Admin::with('opd')->where('role', Admin::ROLE_ADMIN_OPD);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('nama_lengkap', 'like', "%$q%")
                    ->orWhere('username', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }

        if ($request->filled('opd_id')) {
            $query->where('opd_id', $request->opd_id);
        }

        $admins = $query->orderBy('nama_lengkap')->paginate(20)->withQueryString();
        $opdList = Opd::where('is_aktif', true)->orderBy('nama')->get();

        return view('admin.opd-admin.index', compact('admins', 'opdList'));
    }

    public function adminOpdCreate()
    {
        $opdList = Opd::where('is_aktif', true)->orderBy('nama')->get();
        return view('admin.opd-admin.create', compact('opdList'));
    }

    public function adminOpdStore(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|min:3|max:150',
            'username' => 'required|string|min:3|max:60|unique:admins,username',
            'password' => 'required|string|min:6|max:100',
            'email' => 'nullable|email|max:100',
            'opd_id' => 'required|exists:opd,id',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'opd_id.required' => 'Pilih OPD.',
        ]);

        // Check if OPD already has admin
        $existingAdmin = Admin::where('opd_id', $validated['opd_id'])
            ->where('role', Admin::ROLE_ADMIN_OPD)
            ->first();
            
        if ($existingAdmin) {
            return back()->withErrors(['opd_id' => 'OPD tersebut sudah memiliki admin.'])->withInput();
        }

        Admin::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'email' => $validated['email'] ?? null,
            'opd_id' => $validated['opd_id'],
            'role' => Admin::ROLE_ADMIN_OPD,
            'is_aktif' => true,
        ]);

        return redirect()->route('admin.opd-admin.index')->with('success', 'Admin OPD berhasil ditambahkan.');
    }

    public function adminOpdEdit($id)
    {
        $admin = Admin::where('id', $id)->where('role', Admin::ROLE_ADMIN_OPD)->firstOrFail();
        $opdList = Opd::where('is_aktif', true)->orderBy('nama')->get();
        return view('admin.opd-admin.edit', compact('admin', 'opdList'));
    }

    public function adminOpdUpdate(Request $request, $id)
    {
        $admin = Admin::where('id', $id)->where('role', Admin::ROLE_ADMIN_OPD)->firstOrFail();

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|min:3|max:150',
            'username' => 'required|string|min:3|max:60|unique:admins,username,' . $id,
            'password' => 'nullable|string|min:6|max:100',
            'email' => 'nullable|email|max:100',
            'opd_id' => 'required|exists:opd,id',
            'is_aktif' => 'required|boolean',
        ]);

        $updateData = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'opd_id' => $validated['opd_id'],
            'is_aktif' => $validated['is_aktif'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $admin->update($updateData);

        // ✅ REDIRECT TO INDEX AFTER EDIT (per request)
        return redirect()->route('admin.opd-admin.index')->with('success', 'Admin OPD berhasil diperbarui.');
    }

    public function adminOpdDestroy($id)
    {
        $admin = Admin::where('id', $id)->where('role', Admin::ROLE_ADMIN_OPD)->firstOrFail();
        
        // Force delete (hard delete) - per request
        $admin->forceDelete();

        return redirect()->route('admin.opd-admin.index')->with('success', 'Admin OPD berhasil dihapus permanen.');
    }

    // ============================================================
    // RESERVASI - VIEW (Both Superadmin & Admin OPD)
    // ============================================================

    public function reservasiIndex(Request $request)
    {
        $role = session('admin_role');
        
        // Superadmin: see all reservations
        if ($role === Admin::ROLE_SUPERADMIN) {
            $query = Reservasi::with('opd');
        } else {
            // Admin OPD: see only their OPD's reservations
            $query = Reservasi::with('opd')->where('opd_id', session('admin_opd_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qb) use ($q) {
                $qb->where('nama_tamu', 'like', "%$q%")
                    ->orWhere('kode', 'like', "%$q%")
                    ->orWhere('instansi', 'like', "%$q%");
            });
        }
        
        // Only superadmin can filter by OPD
        if ($request->filled('opd_id') && $role === Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $request->opd_id);
        }

        $reservasi = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $opdList = Opd::where('is_aktif', true)->orderBy('nama')->get();

        return view('admin.reservasi.index', compact('reservasi', 'opdList'));
    }

    public function reservasiDetail($id)
    {
        $role = session('admin_role');
        $opdId = session('admin_opd_id');
        
        $query = Reservasi::with(['opd', 'riwayat.admin']);
        
        // Filter by OPD for admin_opd
        if ($role !== Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $opdId);
        }
        
        $reservasi = $query->findOrFail($id);
        return view('admin.reservasi.detail', compact('reservasi'));
    }

    public function bukaDokumen($id)
    {
        $role = session('admin_role');
        $opdId = session('admin_opd_id');

        $query = Reservasi::query();
        
        if ($role !== Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $opdId);
        }

        $reservasi = $query->findOrFail($id);

        if (!$reservasi->dokumen_path) {
            abort(404, 'Tidak ada dokumen yang dilampirkan.');
        }

        if (!Storage::disk('public')->exists($reservasi->dokumen_path)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        $path = Storage::disk('public')->path($reservasi->dokumen_path);
        $mime = mime_content_type($path);
        $filename = $reservasi->dokumen_nama_asli ?? basename($reservasi->dokumen_path);

        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    // ============================================================
    // APPROVE/REJECT (Admin OPD Only)
    // ============================================================

    public function setujui(Request $request, $id)
    {
        // ✅ EXTRA SECURITY CHECK: Superadmin cannot approve
        if (session('admin_role') === Admin::ROLE_SUPERADMIN) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin Umum (Superadmin) tidak dapat menyetujui reservasi. Hubungi Admin OPD terkait.');
        }

        $role = session('admin_role');
        $opdId = session('admin_opd_id');
        $adminId = session('admin_id');

        $query = Reservasi::where('status', 'Menunggu');
        
        if ($role !== Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $opdId);
        }

        $reservasi = $query->findOrFail($id);
        $statusLama = $reservasi->status;

        $reservasi->update([
            'status' => 'Disetujui',
            'diproses_oleh' => $adminId,
            'waktu_diproses' => now(),
        ]);

        RiwayatStatus::create([
            'reservasi_id' => $reservasi->id,
            'status_lama' => $statusLama,
            'status_baru' => 'Disetujui',
            'oleh_admin' => $adminId,
        ]);

        return back()->with('success', "Reservasi {$reservasi->kode} berhasil disetujui.");
    }

    public function tolak(Request $request, $id)
    {
        $request->validate(['alasan' => 'nullable|string|max:500']);

        // ✅ EXTRA SECURITY CHECK: Superadmin cannot reject
        if (session('admin_role') === Admin::ROLE_SUPERADMIN) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin Umum (Superadmin) tidak dapat menolak reservasi. Hubungi Admin OPD terkait.');
        }

        $role = session('admin_role');
        $opdId = session('admin_opd_id');
        $adminId = session('admin_id');

        $query = Reservasi::where('status', 'Menunggu');
        
        if ($role !== Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $opdId);
        }

        $reservasi = $query->findOrFail($id);
        $statusLama = $reservasi->status;

        $reservasi->update([
            'status' => 'Ditolak',
            'alasan_tolak' => $request->alasan ?: 'Tidak ada keterangan.',
            'diproses_oleh' => $adminId,
            'waktu_diproses' => now(),
        ]);

        RiwayatStatus::create([
            'reservasi_id' => $reservasi->id,
            'status_lama' => $statusLama,
            'status_baru' => 'Ditolak',
            'keterangan' => $request->alasan,
            'oleh_admin' => $adminId,
        ]);

        return back()->with('success', "Reservasi {$reservasi->kode} ditolak.");
    }

    // ============================================================
    // VERIFIKASI (Admin OPD Only)
    // ============================================================

    public function verifikasiIndex(Request $request)
    {
        $role = session('admin_role');
        $opdId = session('admin_opd_id');
        $verifyCode = $request->kode ? strtoupper(trim($request->kode)) : null;
        $found = null;
        $error = null;
        $today = Carbon::today();

        if ($verifyCode) {
            $query = Reservasi::where('kode', $verifyCode);
            if ($role !== Admin::ROLE_SUPERADMIN) {
                $query->where('opd_id', $opdId);
            }
            $r = $query->first();
            
            if (!$r) {
                $error = "Kode $verifyCode tidak ditemukan.";
            }
            elseif ($r->status === 'Hadir') {
                $error = "Tamu {$r->nama_tamu} sudah tercatat hadir sebelumnya.";
            }
            elseif ($r->status === 'Tidak Hadir') {
                $error = "Tamu {$r->nama_tamu} berstatus <strong>Tidak Hadir</strong>.";
            }
            elseif ($r->status === 'Ditolak') {
                $error = "Reservasi berstatus <strong>Ditolak</strong>.";
            }
            elseif ($r->status === 'Menunggu') {
                $error = "Reservasi berstatus <strong>Menunggu</strong>.";
            }
            elseif ($r->tanggal->lt($today)) {
                $error = "Tanggal reservasi ({$r->tanggal->translatedFormat('d F Y')}) sudah terlewati.";
            }
            elseif ($r->tanggal->gt($today)) {
                $error = "Tanggal reservasi ({$r->tanggal->translatedFormat('d F Y')}) belum tiba.";
            }
            else {
                $found = $r;
            }
        }

        $query = Reservasi::where('status', 'Disetujui')->whereDate('tanggal', '<=', $today);
        if ($role !== Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $opdId);
        }
        $terjadwal = $query->orderBy('tanggal')->get();

        return view('admin.verifikasi.index', compact('terjadwal', 'found', 'error', 'verifyCode'));
    }

public function markHadir($id)
{
    if (session('admin_role') === Admin::ROLE_SUPERADMIN) {
        return redirect()->route('admin.dashboard')
            ->with('error', 'Admin Umum tidak dapat memverifikasi kehadiran.');
    }

    $role = session('admin_role');
    $opdId = session('admin_opd_id');
    $adminId = session('admin_id');

    $query = Reservasi::where('status', 'Disetujui');

    if ($role !== Admin::ROLE_SUPERADMIN) {
        $query->where('opd_id', $opdId);
    }

    $r = $query->findOrFail($id);

    $today = Carbon::today();

    if ($r->tanggal->lt($today)) {
        return back()->with('error', "Tanggal reservasi sudah terlewati.");
    }

    if ($r->tanggal->gt($today)) {
        return back()->with('error', "Tanggal reservasi belum tiba.");
    }

    $jamDatang = now();

    $jamReservasi = Carbon::parse($r->tanggal)
        ->setTimeFromTimeString($r->jam_kunjungan);

    $selisihMenit = round($jamReservasi->diffInMinutes($jamDatang, false));

    if ($selisihMenit <= 15) {
        $statusKehadiran = 'Tepat Waktu';
    } else {
        $statusKehadiran = 'Terlambat '.$selisihMenit.' menit';
    }

    // UPDATE RESERVASI
    $r->update([
        'status' => 'Hadir',
        'jam_hadir' => $jamDatang->format('H:i'),
        'status_kehadiran' => $statusKehadiran,
        'diverifikasi_oleh' => $adminId
    ]);

    // RIWAYAT
    RiwayatStatus::create([
        'reservasi_id' => $r->id,
        'status_lama' => 'Disetujui',
        'status_baru' => 'Hadir',
        'keterangan' => 'Tamu hadir (' . $statusKehadiran . ')',
        'oleh_admin' => $adminId,
    ]);

    return redirect()->route('admin.verifikasi.index')
        ->with('success', "Kehadiran {$r->nama_tamu} ({$r->kode}) berhasil dikonfirmasi.");
}

    // ============================================================
    // LAPORAN (Both Superadmin & Admin OPD)
    // ============================================================

    public function laporan(Request $request)
    {
        $role = session('admin_role');
        $opdId = session('admin_opd_id');

        $dari = $request->dari ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $sampai = $request->sampai ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        $statusFilter = $request->status ?? '';
        $opdFilter = $request->opd_id ?? '';

        $query = Reservasi::query();

        if ($role !== Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $opdId);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($opdFilter && $role === Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $opdFilter);
        }

        $data = $query->whereBetween('tanggal', [$dari, $sampai])->orderBy('tanggal')->get();

        $kpi = [
            'total' => $data->count(),
            'menunggu' => $data->where('status', 'Menunggu')->count(),
            'disetujui' => $data->where('status', 'Disetujui')->count(),
            'ditolak' => $data->where('status', 'Ditolak')->count(),
            'hadir' => $data->where('status', 'Hadir')->count(),
            'tidak_hadir' => $data->where('status', 'Tidak Hadir')->count(),
        ];

        $opdList = Opd::where('is_aktif', true)->orderBy('nama')->get();
        $opdNama = $role === Admin::ROLE_SUPERADMIN ? 'Semua OPD' : session('admin_opd_nama');

        return view('admin.laporan.index', compact('data', 'kpi', 'dari', 'sampai', 'statusFilter', 'opdFilter', 'opdList', 'opdNama'));
    }

    public function laporanCetak(Request $request)
    {
        $role = session('admin_role');
        $opdId = session('admin_opd_id');

        $dari = $request->dari ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $sampai = $request->sampai ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        $statusFilter = $request->status ?? '';
        $opdFilter = $request->opd_id ?? '';

        $query = Reservasi::query();

        if ($role !== Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $opdId);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($opdFilter && $role === Admin::ROLE_SUPERADMIN) {
            $query->where('opd_id', $opdFilter);
        }

        $data = $query->whereBetween('tanggal', [$dari, $sampai])->orderBy('tanggal')->get();

        $kpi = [
            'total' => $data->count(),
            'menunggu' => $data->where('status', 'Menunggu')->count(),
            'disetujui' => $data->where('status', 'Disetujui')->count(),
            'ditolak' => $data->where('status', 'Ditolak')->count(),
            'hadir' => $data->where('status', 'Hadir')->count(),
            'tidak_hadir' => $data->where('status', 'Tidak Hadir')->count(),
        ];

        $opdNama = $role === Admin::ROLE_SUPERADMIN ? 'Semua OPD' : session('admin_opd_nama');

        return view('admin.laporan.cetak', compact('data', 'kpi', 'dari', 'sampai', 'statusFilter', 'opdFilter', 'opdNama'));
    }
}

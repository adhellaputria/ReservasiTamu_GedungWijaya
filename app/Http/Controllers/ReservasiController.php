<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Opd;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function form()
    {
        $opdList = Opd::where('is_aktif', 1)->orderBy('nama')->get();
        return view('reservasi.form', compact('opdList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tamu' => 'required|string|min:3|max:150',
            'no_hp' => 'required|regex:/^0[0-9]{8,12}$/',
            'email_tamu' => 'required|email',
            'instansi' => 'nullable|string|max:150',
            'opd_id' => 'required|exists:opd,id',
            'petugas_dituju' => 'nullable|string|max:100',
            'tujuan' => 'required|string|min:5',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_kunjungan' => 'required|date_format:H:i',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ], [
            'nama_tamu.required' => 'Nama lengkap wajib diisi.',
            'nama_tamu.min' => 'Nama minimal 3 karakter.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Format nomor HP tidak valid (awali 0, 9-13 digit).',
            'email_tamu.required' => 'Email wajib diisi.',
            'email_tamu.email' => 'Format email tidak valid.',
            'opd_id.required' => 'Pilih OPD yang dituju.',
            'opd_id.exists' => 'OPD tidak ditemukan.',
            'tujuan.required' => 'Tujuan kunjungan wajib diisi.',
            'tujuan.min' => 'Tujuan minimal 5 karakter.',
            'tanggal.required' => 'Tanggal kunjungan wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.',
            'jam_kunjungan.required' => 'Pilih jam kunjungan.',
            'jam_kunjungan.date_format' => 'Format jam tidak valid.',
            'dokumen.mimes' => 'Format dokumen tidak valid (PDF, Word, JPG, PNG).',
            'dokumen.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        // Validasi: Tanggal tidak boleh sebelum hari ini
        $today = Carbon::today();
        $tanggalReservasi = Carbon::parse($validated['tanggal']);

        if ($tanggalReservasi->lt($today)) {
            return back()->withErrors([
                'tanggal' => 'Tanggal reservasi tidak boleh sebelum hari ini.'
            ])->withInput();
        }

        // Validasi: Jika tanggal = hari ini, jam reservasi harus >= jam saat ini
        if ($tanggalReservasi->isSameDay($today)) {

            $jamInput = Carbon::createFromFormat('H:i', $validated['jam_kunjungan']);
            $jamBatas = $jamInput->copy()->addHour(); // batas 1 jam
            $sekarang = now();

            if ($sekarang->gte($jamBatas)) {
                return back()->withErrors([
                    'jam_kunjungan' => 'Jam yang dipilih sudah terlewat.'
                ])->withInput();
            }
        }

        // Generate kode unik
        $kode = $this->generateKode();

        // Handle upload dokumen
        $dokumenPath = null;
        $dokumenNamaAsli = null;
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $dokumenNamaAsli = $file->getClientOriginalName();
            $namaFile = $kode . '_' . Str::slug(pathinfo($dokumenNamaAsli, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $dokumenPath = $file->storeAs('dokumen', $namaFile, 'public');
        }

        $reservasi = Reservasi::create([
            'kode' => $kode,
            'nama_tamu' => $validated['nama_tamu'],
            'no_hp' => $validated['no_hp'],
            'email_tamu' => $validated['email_tamu'],
            'instansi' => $validated['instansi'] ?? null,
            'opd_id' => $validated['opd_id'],
            'petugas_dituju' => $validated['petugas_dituju'] ?? null,
            'tujuan' => $validated['tujuan'],
            'keterangan' => $validated['keterangan'] ?? null,
            'tanggal' => $validated['tanggal'],
            'jam_kunjungan' => $validated['jam_kunjungan'],
            'dokumen_path' => $dokumenPath,
            'dokumen_nama_asli' => $dokumenNamaAsli,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('reservasi.sukses', $kode);
    }

    public function sukses($kode)
    {
        $reservasi = Reservasi::with('opd')->where('kode', $kode)->firstOrFail();
        return view('reservasi.sukses', compact('reservasi'));
    }

    public function cekForm()
    {
        return view('reservasi.cek');
    }

    public function cekStatus(Request $request)
{
    $request->validate(['kode' => 'required|string']);

    $kode = strtoupper(trim($request->kode));
    $reservasi = Reservasi::with('opd')->where('kode', $kode)->first();

    if (!$reservasi) {
        return back()->with('error_kode', $kode)->withInput();
    }

    return view('reservasi.cek', compact('reservasi'));
}

    private function generateKode(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        do {
            $random = '';
            for ($i = 0; $i < 6; $i++) {
                $random .= $chars[random_int(0, strlen($chars) - 1)];
            }
            $kode = 'WJY-' . $random;
        } while (Reservasi::where('kode', $kode)->exists());

        return $kode;
    }
}
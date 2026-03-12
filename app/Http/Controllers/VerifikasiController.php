<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Reservasi;

class VerifikasiController extends Controller
{
    /**
     * Daftar tamu yang perlu diverifikasi (status Disetujui).
     * GET /admin/verifikasi
     */
    public function index()
    {
        /*
        $tamu = Reservasi::where('status', 'Disetujui')
            ->whereDate('tanggal', today())
            ->orderBy('jam')
            ->get();
        */

        $tamu = collect([]);

        return response()->json(['data' => $tamu]);
    }

    /**
     * Konfirmasi kehadiran tamu.
     * POST /admin/verifikasi/konfirmasi
     */
    public function konfirmasi(Request $request)
    {
        $request->validate([
            'kode' => ['required', 'string'],
        ]);

        $kode = strtoupper($request->kode);

        /*
        $reservasi = Reservasi::where('kode', $kode)->first();

        if (!$reservasi) {
            return response()->json([
                'success' => false,
                'message' => "Kode reservasi {$kode} tidak ditemukan.",
            ], 404);
        }

        if ($reservasi->status === 'Hadir') {
            return response()->json([
                'success' => false,
                'message' => "Tamu {$reservasi->nama} sudah tercatat hadir.",
            ]);
        }

        if ($reservasi->status !== 'Disetujui') {
            return response()->json([
                'success' => false,
                'message' => "Reservasi berstatus {$reservasi->status}. Hanya yang Disetujui dapat dikonfirmasi.",
            ], 422);
        }

        $reservasi->update([
            'status'         => 'Hadir',
            'waktu_kehadiran' => now(),
        ]);
        */

        return response()->json([
            'success' => true,
            'message' => "Kehadiran tamu dengan kode {$kode} berhasil dikonfirmasi.",
            // 'data'    => $reservasi,
        ]);
    }
}

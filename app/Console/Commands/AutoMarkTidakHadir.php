<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservasi;
use App\Models\RiwayatStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AutoMarkTidakHadir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservasi:auto-tidak-hadir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis mengubah status reservasi menjadi Tidak Hadir jika tanggal reservasi sudah terlewati';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        
        $this->info('Memulai proses auto-mark Tidak Hadir...');
        
        // Cari reservasi yang berstatus Disetujui, tanggal sudah lewat, dan belum hadir
        $reservasiList = Reservasi::where('status', 'Disetujui')
            ->whereDate('tanggal', '<', $today)
            ->get();
        
        $count = 0;
        
        foreach ($reservasiList as $reservasi) {
            // Update status ke Tidak Hadir
            $statusLama = $reservasi->status;
            $reservasi->update([
                'status' => 'Tidak Hadir',
            ]);
            
            // Catat riwayat status
            RiwayatStatus::create([
                'reservasi_id' => $reservasi->id,
                'status_lama'  => $statusLama,
                'status_baru'  => 'Tidak Hadir',
                'keterangan'   => 'Otomatis: Tamu tidak hadir hingga tanggal reservasi terlewati.',
            ]);
            
            $count++;
            $this->line("✓ Reservasi {$reservasi->kode} ({$reservasi->nama_tamu}) diubah ke status Tidak Hadir");
            
            Log::info("Auto-markTidakHadir: Reservasi {$reservasi->kode} diubah ke Tidak Hadir");
        }
        
        if ($count > 0) {
            $this->info("Selesai. {$count} reservasi diubah ke status Tidak Hadir.");
        } else {
            $this->info('Tidak ada reservasi yang perlu diubah ke status Tidak Hadir.');
        }
        
        return Command::SUCCESS;
    }
}


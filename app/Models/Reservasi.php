<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    protected $fillable = [
    'kode','nama_tamu','no_hp','email_tamu','instansi',
    'opd_id','petugas_dituju','tujuan','keterangan',
    'tanggal','jam_kunjungan','dokumen_path','dokumen_nama_asli',
    'status','alasan_tolak','diproses_oleh','waktu_diproses',

    'waktu_hadir',
    'jam_hadir',
    'status_kehadiran',
    'diverifikasi_oleh'
    ];
    protected $casts = [
    'tanggal'        => 'date',
    'waktu_diproses' => 'datetime',
    'waktu_hadir'    => 'datetime',
    'jam_hadir'      => 'string'
    ];

    public function opd()     { return $this->belongsTo(Opd::class, 'opd_id'); }
    public function riwayat() { return $this->hasMany(RiwayatStatus::class, 'reservasi_id'); }

    public function getDokumenUrlAttribute(): ?string
    {
        if (!$this->dokumen_path) return null;
        return Storage::disk('public')->exists($this->dokumen_path)
            ? Storage::disk('public')->url($this->dokumen_path)
            : null;
    }

    public function getStatusBadgeAttribute(): string
    {
        $map = [
            'Menunggu'     => '<span class="badge bw"><span class="bdot"></span>Menunggu</span>',
            'Disetujui'    => '<span class="badge ba"><span class="bdot"></span>Disetujui</span>',
            'Ditolak'      => '<span class="badge br"><span class="bdot"></span>Ditolak</span>',
            'Hadir'        => '<span class="badge bh"><span class="bdot"></span>Hadir</span>',
            'Tidak Hadir'  => '<span class="badge bt"><span class="bdot"></span>Tidak Hadir</span>',
        ];

        return $map[$this->status] 
            ?? '<span class="badge">'.$this->status.'</span>';
    }
}
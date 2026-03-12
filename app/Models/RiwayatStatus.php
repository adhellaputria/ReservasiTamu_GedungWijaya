<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatus extends Model
{
    public $timestamps = false;
    protected $fillable = ['reservasi_id','status_lama','status_baru','keterangan','oleh_admin','created_at'];
    protected $casts    = ['created_at' => 'datetime'];
    protected $table = 'riwayat_status';
    
    public function reservasi() { return $this->belongsTo(Reservasi::class); }
    public function admin()     { return $this->belongsTo(Admin::class, 'oleh_admin'); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SesiJam extends Model
{
    protected $table    = 'sesi_jam';
    protected $fillable = ['label','jam_mulai','jam_selesai','hanya_senin_kamis','is_aktif'];
}

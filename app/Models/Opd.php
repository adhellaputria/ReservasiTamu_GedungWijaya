<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    protected $table = 'opd';

    protected $fillable = [
        'kode',
        'nama',
        'lantai',
        'email_opd',
        'telepon',
        'kepala',
        'is_aktif'
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
        'lantai' => 'integer',
    ];

    /**
     * Relationship: Admins (one-to-many)
     */
    public function admins()
    {
        return $this->hasMany(Admin::class, 'opd_id');
    }

    /**
     * Relationship: Reservasi (one-to-many)
     */
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'opd_id');
    }

    /**
     * Scope: Get only active OPDs
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    /**
     * Scope: Get OPDs ordered by name
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('nama');
    }

    /**
     * Check if OPD is active
     */
    public function isAktif(): bool
    {
        return $this->is_aktif === true;
    }

    /**
     * Get count of active reservations
     */
    public function getReservasiAktifCount(): int
    {
        return $this->reservasi()
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->count();
    }

    /**
     * Get count of admins
     */
    public function getAdminCount(): int
    {
        return $this->admins()->count();
    }
}

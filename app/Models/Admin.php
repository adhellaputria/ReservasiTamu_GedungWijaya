<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    // Role constants - consistent naming
    public const ROLE_SUPERADMIN = 'admin_utama';
    public const ROLE_ADMIN_OPD = 'admin_opd';

    // All roles
    public const ROLES = [
        self::ROLE_SUPERADMIN,
        self::ROLE_ADMIN_OPD,
    ];

    protected $fillable = [
        'opd_id',
        'username',
        'password',
        'nama_lengkap',
        'email',
        'role',
        'is_aktif',
        'last_login'
    ];

    protected $hidden = ['password'];

    protected $casts = ['last_login' => 'datetime'];

    /**
     * Relationship: OPD (many-to-one)
     */
    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    /**
     * Relationship: Riwayat Status (one-to-many)
     */
    public function riwayat()
    {
        return $this->hasMany(RiwayatStatus::class, 'oleh_admin');
    }

    /**
     * Scope: Get only superadmin users
     */
    public function scopeSuperadmin($query)
    {
        return $query->where('role', self::ROLE_SUPERADMIN);
    }

    /**
     * Scope: Get only Admin OPD users
     */
    public function scopeAdminOpd($query)
    {
        return $query->where('role', self::ROLE_ADMIN_OPD);
    }

    /**
     * Scope: Get only active users
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    /**
     * Check if user is superadmin
     */
    public function isSuperadmin(): bool
    {
        return $this->role === self::ROLE_SUPERADMIN;
    }

    /**
     * Check if user is Admin OPD
     */
    public function isAdminOpd(): bool
    {
        return $this->role === self::ROLE_ADMIN_OPD;
    }

    /**
     * Check if user has access to specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Set password with hashing
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    /**
     * Get the formatted role name
     */
    public function getRoleNameAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_SUPERADMIN => 'Admin Umum (Superadmin)',
            self::ROLE_ADMIN_OPD => 'Admin OPD',
            default => ucfirst($this->role),
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password'      => 'hashed',
        'is_active'     => 'boolean',
        'last_login_at' => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────────

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    // ─── Role Helpers ─────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    public function isViewer(): bool
    {
        return $this->role === 'viewer';
    }

    /**
     * Apakah user boleh melakukan aksi write (create/update/delete).
     */
    public function canWrite(): bool
    {
        return in_array($this->role, ['admin', 'kasir']);
    }

    /**
     * Hanya admin yang boleh menghapus data.
     */
    public function canDelete(): bool
    {
        return $this->role === 'admin';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin'  => 'Administrator',
            'kasir'  => 'Kasir',
            'viewer' => 'Viewer (Read-only)',
            default  => $this->role,
        };
    }
}

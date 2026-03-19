<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'action', 'model', 'model_id',
        'before', 'after', 'ip_address', 'user_agent', 'description',
    ];

    protected $casts = [
        'before'     => 'array',
        'after'      => 'array',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Catat aksi ke audit log dengan mudah dari mana saja.
     */
    public static function catat(
        string  $action,
        string  $description = '',
        ?Model  $model = null,
        ?array  $before = null,
        ?array  $after  = null,
    ): self {
        return static::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model'       => $model ? get_class($model) : null,
            'model_id'    => $model?->getKey(),
            'before'      => $before,
            'after'       => $after,
            'ip_address'  => request()->ip(),
            'user_agent'  => substr(request()->userAgent() ?? '', 0, 255),
            'description' => $description,
            'created_at'  => now(),
        ]);
    }
}

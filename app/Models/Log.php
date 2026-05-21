<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'user_id',
        'role',
        'modul',
        'aksi',
        'target',
        'keterangan',
        'status',
    ];

    /**
     * Relasi ke user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'user_id', 'id');
    }

    /**
     * Badge color helper.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'success' => 'bg-green-100 text-green-600',
            'warning' => 'bg-yellow-100 text-yellow-600',
            'error' => 'bg-red-100 text-red-600',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    /**
     * Label aksi helper.
     */
    public function getFormattedAksiAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->aksi));
    }
}

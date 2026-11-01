<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogStatusLaporan extends Model
{
    protected $table = 'log_status_laporan';

    public $timestamps = false;

    protected $fillable = [
        'laporan_id',
        'status_lama',
        'status_baru',
        'user_id',
    ];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

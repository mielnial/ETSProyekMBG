<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distribusi extends Model
{
    protected $table = 'distribusi';

    protected $fillable = [
        'sekolah_id',
        'tanggal_distribusi',
        'menu',
        'jumlah_porsi',
    ];

    protected function casts(): array
    {
        return ['tanggal_distribusi' => 'date'];
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'distribusi_id');
    }
}

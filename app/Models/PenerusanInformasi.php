<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenerusanInformasi extends Model
{
    protected $table = 'penerusan_informasi';

    protected $fillable = [
        'laporan_id',
        'koordinator_id',
        'pihak_tujuan',
        'keterangan',
        'tanggal_diteruskan',
    ];

    protected function casts(): array
    {
        return ['tanggal_diteruskan' => 'date'];
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function koordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'koordinator_id');
    }
}

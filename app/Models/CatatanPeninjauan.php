<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanPeninjauan extends Model
{
    protected $table = 'catatan_peninjauan';

    protected $fillable = [
        'laporan_id',
        'pemantau_id',
        'isi_catatan',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function pemantau(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemantau_id');
    }
}

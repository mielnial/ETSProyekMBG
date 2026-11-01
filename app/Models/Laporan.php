<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    public const STATUS_DIKIRIM = 'dikirim';

    public const STATUS_SEDANG_DITINJAU = 'sedang_ditinjau';

    public const STATUS_PERLU_DILENGKAPI = 'perlu_dilengkapi';

    public const STATUS_DITANDAI_UNTUK_DITERUSKAN = 'ditandai_untuk_diteruskan';

    public const STATUS_INFORMASI_DITERUSKAN = 'informasi_diteruskan';

    public const STATUS_DITUTUP = 'ditutup';

    public const STATUSES_EDITABLE_BY_PELAPOR = [
        self::STATUS_DIKIRIM,
        self::STATUS_PERLU_DILENGKAPI,
    ];

    protected $table = 'laporan';

    protected $fillable = [
        'distribusi_id',
        'waktu_kejadian',
        'jumlah_terdampak',
        'gejala',
        'uraian',
    ];

    protected function casts(): array
    {
        return ['waktu_kejadian' => 'datetime'];
    }

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    public function distribusi(): BelongsTo
    {
        return $this->belongsTo(Distribusi::class, 'distribusi_id');
    }

    public function catatanPeninjauan(): HasMany
    {
        return $this->hasMany(CatatanPeninjauan::class, 'laporan_id');
    }

    public function penerusanInformasi(): HasMany
    {
        return $this->hasMany(PenerusanInformasi::class, 'laporan_id');
    }

    public function logStatusLaporan(): HasMany
    {
        return $this->hasMany(LogStatusLaporan::class, 'laporan_id');
    }
}

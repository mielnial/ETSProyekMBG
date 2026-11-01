<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public const ROLE_PELAPOR = 'pelapor';

    public const ROLE_PEMANTAU = 'pemantau';

    public const ROLE_KOORDINATOR = 'koordinator';

    protected $fillable = [
        'username',
        'nama_lengkap',
        'password',
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public function isPelapor(): bool
    {
        return $this->role === self::ROLE_PELAPOR;
    }

    public function isPemantau(): bool
    {
        return $this->role === self::ROLE_PEMANTAU;
    }

    public function isKoordinator(): bool
    {
        return $this->role === self::ROLE_KOORDINATOR;
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'pelapor_id');
    }
}

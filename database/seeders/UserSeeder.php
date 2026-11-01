<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private const DEMO_PASSWORD = 'mbg-demo-2026';

    public function run(): void
    {
        $accounts = [
            [
                'username' => 'rina',
                'nama_lengkap' => 'Rina Puspita',
                'role' => 'pelapor',
            ],
            [
                'username' => 'budi',
                'nama_lengkap' => 'Budi Pratama',
                'role' => 'pelapor',
            ],
            [
                'username' => 'dedi',
                'nama_lengkap' => 'Dedi Wiratama',
                'role' => 'pemantau',
            ],
            [
                'username' => 'sari',
                'nama_lengkap' => 'Sari Nirmala',
                'role' => 'koordinator',
            ],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrNew([
                'username' => $account['username'],
            ]);

            $user->nama_lengkap = $account['nama_lengkap'];
            $user->password = self::DEMO_PASSWORD;
            $user->role = $account['role'];
            $user->save();
        }
    }
}

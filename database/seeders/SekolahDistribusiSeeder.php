<?php

namespace Database\Seeders;

use App\Models\Distribusi;
use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class SekolahDistribusiSeeder extends Seeder
{
    public function run(): void
    {
        $distribusi = [
            [
                'sekolah' => 'SMP Harapan',
                'alamat' => 'Alamat fiktif SMP Harapan, Bandung',
                'kecamatan' => 'Coblong',
                'tanggal' => now()->subDays(10)->toDateString(),
                'menu' => 'Nasi ayam sayur',
                'porsi' => 300,
            ],
            [
                'sekolah' => 'SMP Harapan',
                'alamat' => 'Alamat fiktif SMP Harapan, Bandung',
                'kecamatan' => 'Coblong',
                'tanggal' => now()->subDays(5)->toDateString(),
                'menu' => 'Nasi telur tahu',
                'porsi' => 300,
            ],
            [
                'sekolah' => 'SDN Mekar Jaya',
                'alamat' => 'Alamat fiktif SDN Mekar Jaya, Bandung',
                'kecamatan' => 'Cicendo',
                'tanggal' => now()->subDays(8)->toDateString(),
                'menu' => 'Nasi ikan sayur',
                'porsi' => 200,
            ],
            [
                'sekolah' => 'SDN Mekar Jaya',
                'alamat' => 'Alamat fiktif SDN Mekar Jaya, Bandung',
                'kecamatan' => 'Cicendo',
                'tanggal' => now()->subDays(3)->toDateString(),
                'menu' => 'Nasi daging',
                'porsi' => 200,
            ],
            [
                'sekolah' => 'SMP Nusantara',
                'alamat' => 'Alamat fiktif SMP Nusantara, Bandung',
                'kecamatan' => 'Lengkong',
                'tanggal' => now()->subDays(6)->toDateString(),
                'menu' => 'Nasi ayam',
                'porsi' => 250,
            ],
            [
                'sekolah' => 'SMP Nusantara',
                'alamat' => 'Alamat fiktif SMP Nusantara, Bandung',
                'kecamatan' => 'Lengkong',
                'tanggal' => now()->subDays(2)->toDateString(),
                'menu' => 'Nasi tempe',
                'porsi' => 250,
            ],
        ];

        foreach ($distribusi as $item) {
            $sekolah = Sekolah::firstOrCreate(
                [
                    'nama' => $item['sekolah'],
                    'kecamatan' => $item['kecamatan'],
                ],
                [
                    'alamat' => $item['alamat'],
                ],
            );

            Distribusi::firstOrCreate(
                [
                    'sekolah_id' => $sekolah->id,
                    'tanggal_distribusi' => $item['tanggal'],
                    'menu' => $item['menu'],
                ],
                [
                    'jumlah_porsi' => $item['porsi'],
                ],
            );
        }
    }
}

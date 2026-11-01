<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_user'      => 'USR001',
            'nama_lengkap' => 'Budi Santoso',
            'email'        => 'budi@example.com',
            'username'     => 'budi',
            'password'     => 'rahasia123',
            'no_hp'        => '081234567890',
            'alamat'       => 'Jl. Merdeka No. 10, Bandung',
        ]);

        User::create([
            'id_user'      => 'USR002',
            'nama_lengkap' => 'Siti Aminah',
            'email'        => 'siti@example.com',
            'username'     => 'siti',
            'password'     => 'rahasia456',
            'no_hp'        => '081298765432',
            'alamat'       => 'Jl. Asia Afrika No. 5, Bandung',
        ]);

        $produk = [
            ['BRG001', 'Buku Tulis 38 Lembar', 'Buku tulis bergaris isi 38 lembar.', 5000, 50, 'buku-tulis.jpg'],
            ['BRG002', 'Pulpen Gel Hitam', 'Pulpen gel tinta hitam, tulisan halus.', 3500, 100, 'pulpen.jpg'],
            ['BRG003', 'Penggaris 30 cm', 'Penggaris plastik bening 30 cm.', 4000, 40, 'penggaris.jpg'],
            ['BRG004', 'Pensil 2B', 'Pensil kayu 2B untuk menulis dan menggambar.', 2500, 80, 'pensil.jpg'],
            ['BRG005', 'Penghapus Putih', 'Penghapus putih bersih tanpa meninggalkan noda.', 1500, 120, 'penghapus.jpg'],
            ['BRG006', 'Rautan Pensil', 'Rautan pensil logam dengan wadah serutan.', 3000, 60, 'rautan.jpg'],
            ['BRG007', 'Spidol Whiteboard', 'Spidol whiteboard hitam mudah dihapus.', 8000, 30, 'spidol.jpg'],
            ['BRG008', 'Penanda Teks Kuning', 'Penanda teks warna kuning untuk menandai catatan.', 6500, 0, 'penanda-teks.jpg'],
            ['BRG009', 'Map Plastik', 'Map plastik penyimpan dokumen ukuran A4.', 2000, 70, 'map-plastik.jpg'],
            ['BRG010', 'Kalkulator Saku', 'Kalkulator saku 12 digit.', 45000, 15, 'kalkulator.jpg'],
        ];

        foreach ($produk as [$id, $nama, $deskripsi, $harga, $stok, $gambar]) {
            Product::create([
                'id_barang'   => $id,
                'nama_barang' => $nama,
                'deskripsi'   => $deskripsi,
                'harga'       => $harga,
                'stok'        => $stok,
                'gambar'      => $gambar,
            ]);
        }
    }
}
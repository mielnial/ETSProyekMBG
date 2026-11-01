<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
         // 1. Admin Utama
    $admin = new User([
        'id_user' => 'USR004',
        'nama_lengkap' => 'Admin Utama',
        'email' => 'admin@example.com',
        'username' => 'admin',
        'password' => Hash::make('admin12345'), // Menggunakan Hash demi keamanan
        'no_hp' => '081200000004',
        'alamat' => 'Bandung',
    ]);
    $admin->role = 'admin'; 
    $admin->save();

    // 2. Staff (Rina)
    $staff = new User([
        'id_user' => 'USR003',
        'nama_lengkap' => 'Rina Permata',
        'email' => 'rina@example.com',
        'username' => 'rina',
        'password' => Hash::make('staff12345'),
        'no_hp' => '081200000003',
        'alamat' => 'Jakarta',
    ]);
    $staff->role = 'staff'; 
    $staff->save();

    // 3. Admin 2 (Untuk tes admin lain)
    $admin2 = new User([
        'id_user' => 'USR005',
        'nama_lengkap' => 'Admin Sekunder',
        'email' => 'admin2@example.com',
        'username' => 'admin2',
        'password' => Hash::make('admin23456'),
        'no_hp' => '081200000005',
        'alamat' => 'Surabaya',
    ]);
    $admin2->role = 'admin'; 
    $admin2->save();
    }
}

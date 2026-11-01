# MBG Monitor

Aplikasi mini project untuk mencatat dan memantau laporan terkait pelaksanaan distribusi makanan MBG di sekolah. Aplikasi ini dibuat dengan Laravel 13 dan menggunakan tiga peran: Pelapor, Pemantau, dan Koordinator.

Repo: [mielnial/ETSProyekMBG](https://github.com/mielnial/ETSProyekMBG)

## Fitur

- Login dengan akun yang memiliki peran Pelapor, Pemantau, atau Koordinator.
- Pelapor membuat laporan, melihat laporan miliknya, dan memperbarui laporan saat statusnya masih `dikirim` atau `perlu_dilengkapi`.
- Pemilihan sekolah dan distribusi yang saling terhubung; daftar distribusi dimuat tanpa memuat ulang halaman.
- Validasi aturan laporan: satu laporan aktif per Pelapor pada distribusi yang sama, waktu kejadian tidak mendahului tanggal distribusi dan tidak berada di masa depan.
- Unggah bukti JPG, JPEG, PNG, atau PDF maksimal 2 MB. Berkas disimpan privat dan hanya dapat diunduh setelah melewati pemeriksaan akses.
- Pencarian, filter status, dan pagination pada daftar laporan Pelapor.
- Rekap jumlah laporan per status untuk Pemantau dan Koordinator. Akses Koordinator hanya mencakup laporan yang ditandai atau sudah diteruskan, termasuk laporan tertutup yang memiliki catatan penerusan.
- Observer mencatat perubahan status ke `log_status_laporan` ketika status laporan berubah melalui Eloquent.

## Teknologi dan prasyarat

- PHP 8.3 atau lebih baru, dengan ekstensi `pdo_mysql`, `mbstring`, dan `openssl` aktif.
- Composer.
- MySQL atau MariaDB.
- Browser web modern.

## Menjalankan di Windows

1. Clone repo dan masuk ke folder proyek:

   ```powershell
   git clone https://github.com/mielnial/ETSProyekMBG.git
   Set-Location ETSProyekMBG
   ```

2. Pasang dependency PHP:

   ```powershell
   composer install
   ```

3. Buat berkas konfigurasi lokal dan kunci aplikasi:

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

   Jika `.env` sudah ada, jangan menimpanya. Sesuaikan konfigurasi database pada `.env` dengan MySQL lokalmu:

   ```dotenv
   APP_NAME="MBG Monitor"
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mbg_db
   DB_USERNAME=root
   DB_PASSWORD=
   SESSION_DRIVER=file
   ```

   Ganti nama pengguna dan password database jika konfigurasi MySQL-mu berbeda. Jangan masukkan `.env` ke Git.

   Zona waktu aplikasi sudah diatur ke `Asia/Jakarta` pada `config/app.php`. Setelah mengubah `.env`, bersihkan cache konfigurasi:

   ```powershell
   php artisan config:clear
   ```

4. Buat database kosong di MySQL atau phpMyAdmin:

   ```sql
   CREATE DATABASE mbg_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

5. Buat tabel dan data demo:

   ```powershell
   php artisan migrate:fresh --seed
   ```

   **Perhatian:** perintah ini menghapus tabel dan data pada database yang dikonfigurasi, lalu membuatnya ulang. Gunakan hanya pada database pengembangan yang boleh direset.

6. Jalankan aplikasi:

   ```powershell
   php artisan serve
   ```

7. Buka [http://127.0.0.1:8000](http://127.0.0.1:8000) di browser.

## Akun demo

Semua akun menggunakan password `mbg-demo-2026`. Password ini hanya untuk demonstrasi lokal, bukan untuk penggunaan nyata.

| Username | Nama | Peran |
| --- | --- | --- |
| `rina` | Rina Puspita | Pelapor |
| `budi` | Budi Pratama | Pelapor |
| `dedi` | Dedi Wiratama | Pemantau |
| `sari` | Sari Nirmala | Koordinator |

Data sekolah, distribusi, laporan, dan nama pada seeder adalah data fiktif. Tanggal distribusi dibuat relatif terhadap waktu seeder dijalankan.

## Halaman utama

| URL | Akses | Keterangan |
| --- | --- | --- |
| `/` | Semua pengguna yang sudah login | Beranda sesuai akun |
| `/laporan` | Pelapor | Daftar laporan milik sendiri, pencarian, filter status, dan pagination |
| `/laporan/create` | Pelapor | Form membuat laporan |
| `/laporan/{id}` | Sesuai Policy | Detail laporan sesuai peran dan kepemilikan |
| `/laporan/{id}/edit` | Pemilik laporan | Form edit saat status mengizinkan |
| `/rekap` | Pemantau dan Koordinator | Ringkasan dan daftar laporan sesuai hak akses |

Endpoint unduh bukti juga memeriksa Policy sebelum mengirim berkas. Berkas bukti tidak disajikan langsung dari folder publik.

## Data dan log status

Tabel inti aplikasi adalah `users`, `sekolah`, `distribusi`, `laporan`, `catatan_peninjauan`, `penerusan_informasi`, dan `log_status_laporan`. Relasi dan kebijakan penghapusan foreign key dibuat melalui migration.

`LaporanObserver` mencatat status lama, status baru, pengguna yang melakukan perubahan (bisa kosong untuk proses tanpa pengguna login), dan waktu perubahan. Membuat laporan baru dengan status awal `dikirim` tidak membuat entri perubahan status.

## Riwayat pengerjaan

Perubahan dikirim melalui commit bertahap berdasarkan bagian pekerjaan. Riwayat dapat dilihat dengan:

```powershell
git log --oneline
```

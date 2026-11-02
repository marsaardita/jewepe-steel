# PANDUAN KOMPATIBILITAS & PENYESUAIAN VERSI LARAVEL (PASCA UPDATE)

Dokumen ini berisi panduan untuk menyesuaikan kode proyek **KoKo Petshop** jika komputer yang Anda gunakan saat ujian memiliki versi Laravel, PHP, atau Bootstrap yang **berbeda (lebih lama)** dari versi proyek saat ini.

---

## STATUS VERSI PROYEK SAAT INI (AKTIF)
* **Framework Backend**: Laravel 12.61.1
* **Versi PHP Minimum**: PHP 8.2.12 (Menggunakan XAMPP CGI-FCGI)
* **Framework CSS**: Bootstrap 5.3.3 (Responsive Layout, Tanpa jQuery)

---

## SKENARIO 1: JIKA KOMPUTER UJIAN MENGGUNAKAN LARAVEL 11 ATAU 12
Jika komputer ujian sudah menggunakan Laravel 11 atau 12, proyek ini dapat berjalan langsung **tanpa perubahan kode**.
* **Registrasi Middleware**: Terletak di file [bootstrap/app.php](file:///c:/xampp/htdocs/kokopetshop/bootstrap/app.php) dalam blok `->withMiddleware()`.
* **Routing**: Menggunakan Class-based array syntax di [routes/web.php](file:///c:/xampp/htdocs/kokopetshop/routes/web.php).
* **Model**: Terletak di folder `app/Models/`.
* **Seeder**: Terletak di folder `database/seeders/`.

---

## SKENARIO 2: JIKA KOMPUTER UJIAN MENGGUNAKAN LARAVEL 8, 9, ATAU 10
Pada versi ini, Laravel masih menggunakan file `Kernel.php` untuk mendaftarkan middleware, bukan `bootstrap/app.php`.

### Penyesuaian yang Harus Dilakukan:
1. **Registrasi Middleware (Pindah ke Kernel)**:
   * Buka file **`app/Http/Kernel.php`**.
   * Cari properti `$routeMiddleware` atau `$middlewareAliases`, lalu daftarkan middleware `'checklogin'`:
     ```php
     protected $routeMiddleware = [
         // ...
         'checklogin' => \App\Http\Middleware\CheckLogin::class,
     ];
     ```
2. **Routing & Seeder**: Tetap sama menggunakan Class-based routing dan folder `database/seeders/`.

---

## SKENARIO 3: JIKA KOMPUTER UJIAN MENGGUNAKAN LARAVEL 5.4 - 7.x (VERSI LAMA)
Ini adalah skenario di mana kode program saat ini harus diturunkan (*downgrade*) cukup banyak agar kompatibel.

### Penyesuaian yang Harus Dilakukan:
1. **Ubah Sintaks Routing (Gunakan Format String)**:
   Di Laravel 7 ke bawah, routing tidak bisa menggunakan array class langsung tanpa konfigurasi tambahan. Ubah cara penulisan di `routes/web.php`:
   * **Sintaks Baru (Laravel 12 - Hapus ini jika versi lama)**:
     ```php
     Route::get('/login', [AdminController::class, 'login']);
     ```
   * **Sintaks Lama (Laravel 5.4 - 7.x - Gunakan ini)**:
     ```php
     Route::get('/login', 'AdminController@login');
     ```
     *(Catatan: Anda tidak perlu menuliskan `use App\Http\Controllers\AdminController;` di baris atas jika memakai sintaks lama).*

2. **Registrasi Middleware di Kernel**:
   * Daftarkan middleware `'checklogin'` di file **`app/Http/Kernel.php`** pada array `$routeMiddleware` (sama seperti Skenario 2).

3. **Pindahkan Folder Seeder**:
   * Ubah nama folder seeder dari `database/seeders/` menjadi **`database/seeds/`** (tanpa huruf **r**).
   * Hapus deklarasi `namespace Database\Seeders;` di baris paling atas file `DatabaseSeeder.php`.

4. **Pindahkan Model ke Root `app/`**:
   * Pindahkan file model (seperti `Barang.php`, `Category.php`, dll.) dari folder `app/Models/` ke folder root **`app/`**.
   * Ubah namespace di setiap model dari `namespace App\Models;` menjadi **`namespace App;`**.
   * Di dalam Controller, ubah import model dari `use App\Models\Barang;` menjadi **`use App\Barang;`**.

---

## TROUBLESHOOTING ERROR VERSI PHP DI RUANG UJIAN

> [!WARNING]
> **Gejala**: Muncul error merah saat menjalankan perintah terminal `php artisan ...` atau browser menampilkan pesan error ketidakcocokan versi PHP (*PHP Version Mismatch*).

### **Solusi Cepat Saat Ujian**:
1. **Gunakan Akses URL Langsung**:
   Jika server lokal / `php artisan serve` gagal karena PHP tidak mendukung Laravel 12, pastikan folder proyek berada di dalam folder `htdocs` XAMPP dan Apache + MySQL menyala. Akses lewat browser dengan URL:
   👉 **`http://localhost/kokopetshop/public`**
2. **Gunakan PHP CGI Mode (Bypass Crash)**:
   Jika Apache di komputer ujian mati mendadak saat Anda mencoba menyalakannya (karena crash DLL/bitness), lakukan trik CGI yang kita gunakan:
   * Buka file konfigurasi Apache `httpd-xampp.conf`.
   * Matikan / beri tanda pagar `#` pada semua baris pemuatan `php_module` (seperti `LoadModule php_module ...`).
   * Aktifkan blok `PHP-CGI setup` di bawahnya dengan menghapus tanda pagar `#`:
     ```apache
     <FilesMatch "\.php$">
         SetHandler application/x-httpd-php-cgi
     </FilesMatch>
     <IfModule actions_module>
         Action application/x-httpd-php-cgi "/php-cgi/php-cgi.exe"
     </IfModule>
     ```
   * Restart Apache di XAMPP Control Panel.


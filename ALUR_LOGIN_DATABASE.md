# ALUR LOGIN DATABASE (LARAVEL) - DENGAN KODE LENGKAP PER LANGKAH

### Diagram Alur Data Login:
```text
Form Login (HTML) ➔ Route POST (/login) ➔ AdminController@authenticate ➔ Cek Model User & Hash Password ➔ Simpan Session ➔ Redirect ke Dashboard
```

---

### **LANGKAH DEMI LANGKAH:**

#### **Langkah 1: File `.env` (Koneksi Database)**
* **Tindakan**: Hubungkan Laravel dengan database MySQL.
* **Isi Lengkap File `.env` (Bagian Database)**:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=koko_petshop
  DB_USERNAME=root
  DB_PASSWORD=
  ```

---

#### **Langkah 2: Terminal (Migrasi Tabel)**
* **Tindakan**: Jalankan command artisan untuk membuat tabel-tabel bawaan Laravel.
* **Command**:
  ```bash
  php artisan migrate
  ```
* **CATATAN PENTING MIGRASI:**
  1. **Jika tabel sudah ada di phpMyAdmin**: Anda **TIDAK PERLU** menjalankan command ini lagi. Lewati saja langkah ini.
  2. **Apakah aman dijalankan kembali?**: Aman. Menjalankan `php artisan migrate` saat tabel sudah ada **tidak akan menduplikasi tabel**, Laravel hanya akan menampilkan pesan `"Nothing to migrate"`.
  3. **PERINGATAN**: Jangan jalankan `php artisan migrate:fresh` karena akan menghapus (drop) semua tabel dan seluruh data Anda terlebih dahulu sebelum membuatnya kembali kosong.
#### **Langkah 3: Atur Akun Admin**
* **Tindakan**: Isi `ADMIN_NAME`, `ADMIN_EMAIL`, dan `ADMIN_PASSWORD` di file `.env` dengan nama, email, dan password kuat pilihan Anda.
* Seeder tidak membuat akun admin jika variabel tersebut kosong. Password otomatis di-hash oleh model `User`.

---

#### **Langkah 4: Terminal (Eksekusi Input Data Admin)**
* **Tindakan**: Jalankan command berikut di terminal untuk membuat akun admin dari nilai `.env`.
* **Command**:
  ```bash
  php artisan db:seed
  ```

---

#### **Langkah 5: File `app/Http/Controllers/AdminController.php` (Proses Validasi Login)**
* **Tindakan**: Buka file ini dan ganti kodenya untuk mengecek kecocokan email dan hash password di database.
* **Isi Lengkap File**:
  ```php
  <?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use App\Models\User;
  use Illuminate\Support\Facades\Hash;

  class AdminController extends Controller
  {
      public function login()
      {
          return view('login');
      }

      public function authenticate(Request $request)
      {
          $username = $request->username;
          $password = $request->password;

          $user = User::where('email', $username)->first();

          if ($user && Hash::check($password, $user->password)) {
              session(['login' => true, 'username' => $user->email]);
              return redirect('/dashboard');
          }

          return back()->with('error', 'Username atau password salah');
      }

      public function dashboard()
      {
          if (!session('login')) {
              return redirect('/login');
          }

          return view('dashboard.index');
      }

      public function logout()
      {
          session()->forget('login');
          return redirect('/login');
      }
  }
  ```

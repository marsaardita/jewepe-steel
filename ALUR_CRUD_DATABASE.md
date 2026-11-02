# ALUR CRUD DATABASE (LARAVEL) - DENGAN KODE LENGKAP PER LANGKAH

### Diagram Alur Data CRUD Laravel:
```text
Form Input (Blade View) ➔ Request POST/PUT/DELETE ➔ Route (web.php) ➔ Controller (Menyimpan/Mengubah/Menghapus di DB) ➔ Redirect kembali ke View (Mengambil data terbaru via Eloquent Model)
```

---

## **BAGIAN 1: CRUD KATEGORI BARANG**

#### **Langkah 1: Membuat Model & Migration Kategori**
* **Tindakan**: Jalankan command artisan di terminal untuk membuat file model `Category` dan file migration tabel `categories` sekaligus.
* **Command**:
  ```bash
  php artisan make:model Category -m
  ```
* **Catatan**: Jika tabel `categories` sudah terbuat secara manual/dari SQL di phpMyAdmin, Anda hanya perlu membuat modelnya saja dengan `php artisan make:model Category` (tanpa `-m`), lalu langsung lompat ke **Langkah 4**.

---

#### **Langkah 2: Mengisi Skema Migrasi Tabel Kategori**
* **Tindakan**: Buka file migration baru yang terbuat di folder `database/migrations/xxxx_create_categories_table.php` dan ubah seluruh kodenya menjadi anonymous class seperti ini:
* **Isi Lengkap File**:
  ```php
  <?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration
  {
      public function up()
      {
          Schema::create('categories', function (Blueprint $table) {
              $table->id();
              $table->string('nama');
              $table->text('deskripsi')->nullable();
              $table->timestamps();
          });
      }

      public function down()
      {
          Schema::dropIfExists('categories');
      }
  };
  ```
* **Catatan**: Jika tabel sudah terbuat di phpMyAdmin, lewati langkah ini.

---

#### **Langkah 3: Menjalankan Migrasi ke Database**
* **Tindakan**: Jalankan perintah berikut di terminal agar tabel `categories` terbuat di database MySQL Anda.
* **Command**:
  ```bash
  php artisan migrate
  ```
* **CATATAN PENTING MIGRASI:**
  1. **Jika tabel sudah ada di phpMyAdmin**: Anda **TIDAK PERLU** menjalankan command ini lagi. Lewati saja langkah ini.
  2. **Apakah aman dijalankan kembali?**: Aman. Menjalankan `php artisan migrate` saat tabel sudah ada **tidak akan menduplikasi tabel**, Laravel hanya akan menampilkan pesan `"Nothing to migrate"`.
  3. **PERINGATAN**: Jangan jalankan `php artisan migrate:fresh` karena akan menghapus (drop) semua tabel dan seluruh data Anda terlebih dahulu sebelum membuatnya kembali kosong.

---

#### **Langkah 4: Konfigurasi Model Kategori**
* **Tindakan**: Buka file **`app/Models/Category.php`** dan ganti seluruh kodenya menjadi seperti ini untuk mengizinkan input data massal dengan namespace `App\Models`:
* **Isi Lengkap File**:
  ```php
  <?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Category extends Model
  {
      protected $fillable = ['nama', 'deskripsi'];
  }
  ```

---

#### **Langkah 5: Konfigurasi Controller Kategori**
* **Tindakan**: Buka file **`app/Http/Controllers/CategoryController.php`** dan ganti seluruh kodenya menjadi seperti ini untuk menggunakan model `App\Models\Category`:
* **Isi Lengkap File**:
  ```php
  <?php

  namespace App\Http\Controllers;

  use App\Models\Category;
  use Illuminate\Http\Request;

  class CategoryController extends Controller
  {
      public function index()
      {
          if (!session('login')) {
              return redirect('/login');
          }
          $categories = Category::all();
          return view('categories.index', compact('categories'));
      }

      public function store(Request $request)
      {
          Category::create($request->all());
          return redirect('/master/kategori')->with('success', 'Kategori berhasil ditambahkan');
      }

      public function update(Request $request, $id)
      {
          Category::find($id)->update($request->all());
          return redirect('/master/kategori')->with('success', 'Kategori berhasil diubah');
      }

      public function destroy($id)
      {
          Category::destroy($id);
          return redirect('/master/kategori')->with('success', 'Kategori berhasil dihapus');
      }
  }
  ```

---

## **BAGIAN 2: CRUD DAFTAR BARANG**

*Catatan: Tabel `barangs` dan Model `Barang` diasumsikan sudah ada di database Anda.*

#### **Langkah 6: Konfigurasi Model Barang**
* **Tindakan**: Buka file **`app/Models/Barang.php`** dan ganti seluruh kodenya menjadi seperti ini dengan namespace `App\Models`:
* **Isi Lengkap File**:
  ```php
  <?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Barang extends Model
  {
      protected $fillable = ['kode', 'nama', 'kategori', 'masuk', 'keluar', 'stok'];
  }
  ```

---

#### **Langkah 7: Konfigurasi Controller Barang**
* **Tindakan**: Buka file **`app/Http/Controllers/BarangController.php`** dan ganti seluruh kodenya menjadi seperti ini untuk mengimpor `App\Models\Barang` dan `App\Models\Category`:
* **Isi Lengkap File**:
  ```php
  <?php

  namespace App\Http\Controllers;

  use App\Models\Barang;
  use App\Models\Category;
  use Illuminate\Http\Request;

  class BarangController extends Controller
  {
      public function index()
      {
          if (!session('login')) {
              return redirect('/login');
          }

          $barang = Barang::all();
          $categories = Category::all();
          return view('barang.index', compact('barang', 'categories'));
      }

      public function store(Request $request)
      {
          $stok = $request->masuk - $request->keluar;
          Barang::create(array_merge($request->all(), ['stok' => $stok]));
          return redirect('/master/barang')->with('success', 'Barang berhasil ditambahkan');
      }

      public function update(Request $request, $id)
      {
          $stok = $request->masuk - $request->keluar;
          Barang::find($id)->update(array_merge($request->all(), ['stok' => $stok]));
          return redirect('/master/barang')->with('success', 'Barang berhasil diubah');
      }

      public function destroy($id)
      {
          Barang::destroy($id);
          return redirect('/master/barang')->with('success', 'Barang berhasil dihapus');
      }
  }
  ```

---

## **PANDUAN ROUTING UTAMA**

#### **Langkah 8: Update File Route Aplikasi**
* **Tindakan**: Buka file **`routes/web.php`** dan ganti seluruh kodenya menjadi seperti ini menggunakan class-based routing array syntax Laravel 12 agar semua URL CRUD terdaftar:
* **Isi Lengkap File**:
  ```php
  <?php

  use Illuminate\Support\Facades\Route;
  use App\Http\Controllers\ProductController;
  use App\Http\Controllers\AdminController;
  use App\Http\Controllers\CategoryController;
  use App\Http\Controllers\BarangController;
  use App\Http\Controllers\LaporanController;

  Route::get('/', function () {
      return view('welcome');
  });

  Route::get('/products', [ProductController::class, 'index']);
  Route::get('/login', [AdminController::class, 'login']);
  Route::post('/login', [AdminController::class, 'authenticate']);
  Route::get('/logout', [AdminController::class, 'logout']);

  Route::middleware(['checklogin'])->group(function () {
      Route::get('/dashboard', [AdminController::class, 'dashboard']);
      
      // CRUD Kategori
      Route::get('/master/kategori', [CategoryController::class, 'index']);
      Route::post('/master/kategori', [CategoryController::class, 'store']);
      Route::put('/master/kategori/{id}', [CategoryController::class, 'update']);
      Route::delete('/master/kategori/{id}', [CategoryController::class, 'destroy']);
      
      // CRUD Barang
      Route::get('/master/barang', [BarangController::class, 'index']);
      Route::post('/master/barang', [BarangController::class, 'store']);
      Route::put('/master/barang/{id}', [BarangController::class, 'update']);
      Route::delete('/master/barang/{id}', [BarangController::class, 'destroy']);

      Route::get('/laporan', [LaporanController::class, 'index']);
  });
  ```

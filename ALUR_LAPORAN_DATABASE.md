# ALUR LAPORAN DATABASE (LARAVEL) - DENGAN KODE UTUH PER LANGKAH

Berikut adalah alur langkah demi langkah untuk memigrasikan sistem Laporan (filter pencarian berdasarkan rentang tanggal) dari LocalStorage ke database MySQL. Setiap langkah edit file backend langsung menyajikan **kode lengkap satu file utuh**.

---

### **Langkah 1: Update File Route Aplikasi**
* **Tindakan**: Buka file **`routes/web.php`** dan ganti seluruh kodenya menjadi seperti ini agar route laporan terdaftar di dalam grup middleware login menggunakan class array syntax:
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
      Route::get('/master/kategori', [CategoryController::class, 'index']);
      Route::get('/master/barang', [BarangController::class, 'index']);
      Route::get('/laporan', [LaporanController::class, 'index']);
  });
  ```

---

### **Langkah 2: Konfigurasi Laporan Controller**
* **Tindakan**: Buka file **`app/Http/Controllers/LaporanController.php`** dan ganti seluruh kodenya dengan kode utuh di bawah ini untuk memproses parameter tanggal dari request menggunakan model dengan namespace `App\Models\Barang`:
* **Isi Lengkap File**:
  ```php
  <?php

  namespace App\Http\Controllers;

  use App\Models\Barang;
  use Illuminate\Http\Request;

  class LaporanController extends Controller
  {
      public function index(Request $request)
      {
          if (!session('login')) {
              return redirect('/login');
          }

          $from = $request->input('dateFrom');
          $to = $request->input('dateTo');

          if ($from && $to) {
              // Mengambil data barang yang dibuat di antara tanggal $from dan $to
              $barang = Barang::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
          } else {
              // Jika rentang tanggal belum dipilih, tampilkan seluruh barang
              $barang = Barang::all();
          }

          return view('laporan.index', compact('barang', 'from', 'to'));
      }
  }
  ```

---

### **Langkah 3: Menghubungkan Form Laporan (Blade View)**
* **Tindakan**: Buka file **`resources/views/laporan/index.blade.php`** dan cari bagian tag `<div class="filter-bar">`. Ganti atau bungkus kolom input tanggal dengan form HTML seperti di bawah ini agar data dikirim melalui GET request:
* **Bagian HTML Form yang Diganti**:
  ```html
  <form method="GET" action="/laporan">
      <div class="filter-bar">
          <span class="filter-label">Rentang Waktu</span>
          <div class="date-range">
              <input type="date" id="dateFrom" name="dateFrom" value="{{ $from ?? '' }}" />
              <span>—</span>
              <input type="date" id="dateTo" name="dateTo" value="{{ $to ?? '' }}" />
          </div>
          <button type="submit" class="btn-filter">Filter</button>
          <a href="/laporan" class="btn-reset">Reset</a>
      </div>
  </form>
  ```

---

### **Langkah 4: Merender Hasil Filter Database ke Tabel**
* **Tindakan**: Masih di dalam file **`resources/views/laporan/index.blade.php`**, cari bagian tag `<tbody>` dengan id `tableBody`. Hapus data statis atau script javascript rendering table di dalamnya, lalu ganti menggunakan perulangan Blade PHP seperti di bawah ini:
* **Bagian HTML Tabel yang Diganti**:
  ```html
  <tbody id="tableBody">
      @forelse($barang as $index => $row)
      <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $row->created_at->format('d-m-Y') }}</td>
          <td>{{ $row->kode }}</td>
          <td class="bold">{{ $row->nama }}</td>
          <td>{{ $row->kategori }}</td>
          <td>{{ $row->stok }}</td>
      </tr>
      @empty
      <tr>
          <td colspan="6" style="text-align: center; color: #aaa; padding: 2rem;">
              Belum ada data laporan dalam rentang tanggal ini.
          </td>
      </tr>
      @endforelse
  </tbody>
  ```

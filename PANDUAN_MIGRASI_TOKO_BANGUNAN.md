# PANDUAN MIGRASI APLIKASI: TOKO BANGUNAN JEWEPE

Dokumen ini berisi panduan langkah demi langkah beserta **kode lengkap satu file utuh** untuk memigrasikan atau mengubah aplikasi dari **KoKo Petshop** menjadi **Toko Bangunan JeWePe** sesuai kebutuhan ujian baru.

---

## 🛠️ LANGKAH 1: KONFIGURASI DATABASE & APLIKASI

### File: [.env](file:///c:/xampp/htdocs/kokopetshop/.env)
Ganti nama aplikasi menjadi `Toko Bangunan JeWePe` dan pastikan nama database sesuai.
```env
APP_NAME="Toko Bangunan JeWePe"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=koko_petshop
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🛣️ LANGKAH 2: SISTEM ROUTING APLIKASI

### File: [routes/web.php](file:///c:/xampp/htdocs/kokopetshop/routes/web.php)
Ganti seluruh isi file routes dengan kode di bawah ini untuk mendaftarkan rute dashboard, master kategori, master barang, manajemen pengguna, dan laporan.
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
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
    
    // Master Kategori
    Route::get('/master/kategori', [CategoryController::class, 'index']);
    Route::post('/master/kategori', [CategoryController::class, 'store']);
    Route::put('/master/kategori/{id}', [CategoryController::class, 'update']);
    Route::delete('/master/kategori/{id}', [CategoryController::class, 'destroy']);
    
    // Master Barang
    Route::get('/master/barang', [BarangController::class, 'index']);
    Route::post('/master/barang', [BarangController::class, 'store']);
    Route::put('/master/barang/{id}', [BarangController::class, 'update']);
    Route::delete('/master/barang/{id}', [BarangController::class, 'destroy']);

    // Master Pengguna (Manajemen Pengguna)
    Route::get('/master/pengguna', [UserController::class, 'index']);
    Route::post('/master/pengguna', [UserController::class, 'store']);
    Route::put('/master/pengguna/{id}', [UserController::class, 'update']);
    Route::delete('/master/pengguna/{id}', [UserController::class, 'destroy']);

    // Halaman Laporan
    Route::get('/laporan', [LaporanController::class, 'index']);
});
```

---

## 💾 LANGKAH 3: MODEL DATABASE (ELOQUENT)

### File: [app/Models/Category.php](file:///c:/xampp/htdocs/kokopetshop/app/Models/Category.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nama', 'deskripsi'];
}
```

### File: [app/Models/Barang.php](file:///c:/xampp/htdocs/kokopetshop/app/Models/Barang.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = ['kode', 'nama', 'kategori', 'masuk', 'keluar', 'stok'];
}
```

### File: [app/Models/User.php](file:///c:/xampp/htdocs/kokopetshop/app/Models/User.php)
```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
```

---

## 🎮 LANGKAH 4: BACKEND CONTROLLERS

### File: [app/Http/Controllers/AdminController.php](file:///c:/xampp/htdocs/kokopetshop/app/Http/Controllers/AdminController.php)
Berisi otentikasi login admin dan kalkulasi data dashboard (Total Barang, Total Masuk, Total Keluar, Stok Terendah < 10, dan Stok Tertinggi).
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barang;
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
            session(['login' => true, 'username' => $user->email, 'name' => $user->name]);
            return redirect('/dashboard');
        }

        return back()->with('error', 'Username atau password salah');
    }

    public function dashboard()
    {
        if (!session('login')) {
            return redirect('/login');
        }

        // Kalkulasi data statistik Toko Bangunan JeWePe
        $totalBarang = Barang::count();
        $totalMasuk = Barang::sum('masuk');
        $totalKeluar = Barang::sum('keluar');
        $stokTerendah = Barang::where('stok', '<', 10)->count();
        $stokTertinggi = Barang::max('stok') ?? 0;

        return view('dashboard.index', compact('totalBarang', 'totalMasuk', 'totalKeluar', 'stokTerendah', 'stokTertinggi'));
    }

    public function logout()
    {
        session()->forget(['login', 'username', 'name']);
        return redirect('/login');
    }
}
```

### File: [app/Http/Controllers/CategoryController.php](file:///c:/xampp/htdocs/kokopetshop/app/Http/Controllers/CategoryController.php)
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
        return redirect('/master/kategori')->with('success', 'Kategori barang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        Category::find($id)->update($request->all());
        return redirect('/master/kategori')->with('success', 'Kategori barang berhasil diubah');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect('/master/kategori')->with('success', 'Kategori barang berhasil dihapus');
    }
}
```

### File: [app/Http/Controllers/BarangController.php](file:///c:/xampp/htdocs/kokopetshop/app/Http/Controllers/BarangController.php)
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

### File: [app/Http/Controllers/UserController.php](file:///c:/xampp/htdocs/kokopetshop/app/Http/Controllers/UserController.php)
```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!session('login')) {
            return redirect('/login');
        }
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/master/pengguna')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect('/master/pengguna')->with('success', 'Pengguna berhasil diubah');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/master/pengguna')->with('success', 'Pengguna berhasil dihapus');
    }
}
```

### File: [app/Http/Controllers/LaporanController.php](file:///c:/xampp/htdocs/kokopetshop/app/Http/Controllers/LaporanController.php)
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
            $barang = Barang::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
        } else {
            $barang = Barang::all();
        }

        return view('laporan.index', compact('barang', 'from', 'to'));
    }
}
```

### File: [app/Http/Controllers/ProductController.php](file:///c:/xampp/htdocs/kokopetshop/app/Http/Controllers/ProductController.php)
```php
<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class ProductController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('products.index', compact('barang'));
    }
}
```

---

## 🖥️ LANGKAH 5: TAMPILAN VIEW (BLADE TEMPLATES)

### File: [resources/views/welcome.blade.php](file:///c:/xampp/htdocs/kokopetshop/resources/views/welcome.blade.php)
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Bangunan JeWePe · Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #fafafa; color: #1e293b; }
        .hero-section { padding: 6rem 0; }
        .hero-title { font-size: 3rem; font-weight: 800; line-height: 1.2; color: #0f172a; }
        .hero-title span { color: #f97316; }
        .hero-desc { font-size: 1.15rem; color: #64748b; margin: 1.5rem 0 2.5rem 0; }
        .btn-primary-custom { background-color: #f97316; color: #fff; padding: 0.8rem 2rem; font-weight: 600; border-radius: 50px; border: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2); transition: all 0.2s ease; text-decoration: none;}
        .btn-primary-custom:hover { background-color: #ea580c; color: #fff; transform: translateY(-2px); }
        .btn-secondary-custom { background-color: #fff; color: #0f172a; padding: 0.8rem 2rem; font-weight: 600; border-radius: 50px; border: 1px solid #e2e8f0; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease; text-decoration: none; }
        .btn-secondary-custom:hover { background-color: #f8fafc; transform: translateY(-2px); }
        .feature-card { background: #fff; border: 1px solid #f1f5f9; padding: 2.5rem; border-radius: 24px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01); height: 100%; transition: all 0.3s ease; }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05); }
        .feature-icon { width: 48px; height: 48px; border-radius: 12px; background-color: #ffedd5; color: #f97316; display: flex; align-items: center; justify-center; font-size: 1.5rem; margin-bottom: 1.25rem; justify-content: center; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark d-flex align-items-center gap-2" href="/">
                <i class="ti ti-building-arch fs-3 text-warning"></i>
                <span>Toko Bangunan JeWePe</span>
            </a>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center justify-content-between g-5">
                <div class="col-lg-6">
                    <h1 class="hero-title">
                        Kelola Persediaan Bahan <span>Bangunan</span> Secara Akurat.
                    </h1>
                    <p class="hero-desc">
                        Aplikasi Management Information System terintegrasi untuk melacak persediaan keluar masuk barang bangunan, kategori, dan laporan secara akurat.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/login" class="btn btn-primary-custom">
                            <span>Mulai Sekarang</span>
                            <i class="ti ti-arrow-right"></i>
                        </a>
                        <a href="/products" class="btn btn-secondary-custom">
                            <i class="ti ti-box"></i> Lihat Persediaan Publik
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="feature-card p-4 border border-2 border-warning">
                        <h4 class="fw-bold mb-4">Sistem Aktif</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent py-3 px-0">
                                <span>Aplikasi</span>
                                <span class="badge bg-dark rounded-pill">Toko Bangunan JeWePe</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent py-3 px-0">
                                <span>Framework Backend</span>
                                <span class="badge bg-dark rounded-pill">Laravel 12.61.1</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent py-3 px-0">
                                <span>Framework CSS</span>
                                <span class="badge bg-dark rounded-pill">Bootstrap 5.3.3</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
```

### File: [resources/views/login.blade.php](file:///c:/xampp/htdocs/kokopetshop/resources/views/login.blade.php)
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toko Bangunan JeWePe · Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #fafaf9; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background-color: #ffffff; border: 1px solid #f1f5f9; border-radius: 24px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04); padding: 3rem 2.5rem; width: 100%; max-width: 420px; }
        .logo-box { width: 56px; height: 56px; background-color: #ffedd5; color: #ea580c; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 1rem; }
        .form-control { border-radius: 12px; padding: 0.75rem 1rem; border: 1px solid #cbd5e1; font-size: 0.95rem; }
        .form-control:focus { border-color: #f97316; box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.15); }
        .input-group-text { background-color: transparent; border-color: #cbd5e1; border-top-left-radius: 12px; border-bottom-left-radius: 12px; color: #64748b; }
        .btn-masuk { background-color: #0f172a; color: #fff; border: none; padding: 0.8rem; border-radius: 12px; font-weight: 600; width: 100%; transition: all 0.2s ease; }
        .btn-masuk:hover { background-color: #1e293b; transform: translateY(-1px); }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="login-card">
            <div class="text-center mb-4">
                <div class="logo-box shadow-sm">
                    <i class="ti ti-building-arch"></i>
                </div>
                <h1 class="h3 fw-bold text-dark m-0">Toko Bangunan JeWePe</h1>
                <p class="text-muted small mt-1">Management Information System</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-3 text-center mb-3">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary fw-semibold small" for="username">Username / Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-user"></i></span>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan email" required />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-semibold small" for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required />
                    </div>
                </div>

                <button type="submit" class="btn-masuk">
                    <span>Masuk</span>
                    <i class="ti ti-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
```

### File: [resources/views/dashboard/index.blade.php](file:///c:/xampp/htdocs/kokopetshop/resources/views/dashboard/index.blade.php)
Menampilkan 5 informasi utama: total barang, total masuk, total keluar, stock terendah < 10, dan stock tertinggi.
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard · Toko Bangunan JeWePe</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .sidebar { background-color: #0f172a; min-height: 100vh; color: #fff; padding: 2rem 1.5rem; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #1e293b; color: #fff; }
        .content-area { padding: 3rem; }
        .stat-card { background: #fff; border-radius: 20px; padding: 2rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01); }
        .stat-card .icon-box { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <i class="ti ti-building-arch text-warning"></i>
                    <span>Toko Bangunan</span>
                </h5>
                <hr>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="/dashboard"><i class="ti ti-smart-home"></i> Dashboard</a>
                    <a class="nav-link" href="/master/kategori"><i class="ti ti-category"></i> Kategori Barang</a>
                    <a class="nav-link" href="/master/barang"><i class="ti ti-box"></i> Daftar Barang</a>
                    <a class="nav-link" href="/master/pengguna"><i class="ti ti-users"></i> Manajemen Pengguna</a>
                    <a class="nav-link" href="/laporan"><i class="ti ti-file-text"></i> Halaman Laporan</a>
                    <a class="nav-link mt-5 text-danger" href="/logout"><i class="ti ti-logout"></i> Logout</a>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="col-lg-10 content-area">
                <h2 class="fw-bold mb-1">Dashboard</h2>
                <p class="text-secondary mb-5">Selamat datang kembali, Admin Perusahaan.</p>

                <div class="row g-4">
                    <!-- Total Barang -->
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="text-muted small fw-semibold">TOTAL BARANG</span>
                                    <h2 class="fw-bold mt-1 mb-0">{{ $totalBarang }}</h2>
                                </div>
                                <div class="icon-box bg-primary-subtle text-primary"><i class="ti ti-box"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Stok Masuk -->
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="text-muted small fw-semibold">TOTAL STOK MASUK</span>
                                    <h2 class="fw-bold mt-1 mb-0">{{ $totalMasuk }}</h2>
                                </div>
                                <div class="icon-box bg-success-subtle text-success"><i class="ti ti-arrow-down-left"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Stok Keluar -->
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="text-muted small fw-semibold">TOTAL STOK KELUAR</span>
                                    <h2 class="fw-bold mt-1 mb-0">{{ $totalKeluar }}</h2>
                                </div>
                                <div class="icon-box bg-danger-subtle text-danger"><i class="ti ti-arrow-up-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Stok Terendah < 10 -->
                    <div class="col-md-6">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="text-muted small fw-semibold">STOK TERENDAH (< 10)</span>
                                    <h2 class="fw-bold text-danger mt-1 mb-0">{{ $stokTerendah }} item</h2>
                                </div>
                                <div class="icon-box bg-warning-subtle text-warning"><i class="ti ti-alert-triangle"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Stok Tertinggi -->
                    <div class="col-md-6">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="text-muted small fw-semibold">STOK TERTINGGI</span>
                                    <h2 class="fw-bold text-success mt-1 mb-0">{{ $stokTertinggi }}</h2>
                                </div>
                                <div class="icon-box bg-success-subtle text-success"><i class="ti ti-arrow-up"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
```

### File: [resources/views/barang/index.blade.php](file:///c:/xampp/htdocs/kokopetshop/resources/views/barang/index.blade.php)
Daftar Barang (Master Data + Persediaan) dengan status ketersediaan barang.
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Barang · Toko Bangunan JeWePe</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .sidebar { background-color: #0f172a; min-height: 100vh; color: #fff; padding: 2rem 1.5rem; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #1e293b; color: #fff; }
        .content-area { padding: 3rem; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <i class="ti ti-building-arch text-warning"></i>
                    <span>Toko Bangunan</span>
                </h5>
                <hr>
                <nav class="nav flex-column">
                    <a class="nav-link" href="/dashboard"><i class="ti ti-smart-home"></i> Dashboard</a>
                    <a class="nav-link" href="/master/kategori"><i class="ti ti-category"></i> Kategori Barang</a>
                    <a class="nav-link active" href="/master/barang"><i class="ti ti-box"></i> Daftar Barang</a>
                    <a class="nav-link" href="/master/pengguna"><i class="ti ti-users"></i> Manajemen Pengguna</a>
                    <a class="nav-link" href="/laporan"><i class="ti ti-file-text"></i> Halaman Laporan</a>
                    <a class="nav-link mt-5 text-danger" href="/logout"><i class="ti ti-logout"></i> Logout</a>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="col-lg-10 content-area">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Daftar Barang</h2>
                        <p class="text-secondary">Kelola daftar barang masuk dan keluar toko bangunan.</p>
                    </div>
                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="ti ti-plus"></i> Tambah Barang
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-3 mb-3">{{ session('success') }}</div>
                @endif

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok Masuk</th>
                                    <th>Stok Keluar</th>
                                    <th>Stok Akhir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="font-monospace fw-bold">{{ $row->kode }}</td>
                                        <td>{{ $row->nama }}</td>
                                        <td>{{ $row->kategori }}</td>
                                        <td><span class="text-success">+{{ $row->masuk }}</span></td>
                                        <td><span class="text-danger">-{{ $row->keluar }}</span></td>
                                        <td class="fw-bold">{{ $row->stok }}</td>
                                        <td>
                                            @if($row->stok > 0)
                                                <span class="badge bg-success-subtle text-success">Tersedia</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger">Tidak Tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $row->id }}">Detail</button>
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">Edit</button>
                                            <form action="/master/barang/{{ $row->id }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Detail Modal -->
                                    <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-4">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Detail Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Kode:</strong> {{ $row->kode }}</p>
                                                    <p><strong>Nama:</strong> {{ $row->nama }}</p>
                                                    <p><strong>Kategori:</strong> {{ $row->kategori }}</p>
                                                    <p><strong>Stok Masuk:</strong> {{ $row->masuk }}</p>
                                                    <p><strong>Stok Keluar:</strong> {{ $row->keluar }}</p>
                                                    <p><strong>Stok Saat Ini:</strong> {{ $row->stok }}</p>
                                                    <p><strong>Waktu Update:</strong> {{ $row->updated_at }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-4">
                                                <form action="/master/barang/{{ $row->id }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Edit Barang</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Kode Barang</label>
                                                            <input type="text" name="kode" class="form-control" value="{{ $row->kode }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Barang</label>
                                                            <input type="text" name="nama" class="form-control" value="{{ $row->nama }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Kategori</label>
                                                            <select name="kategori" class="form-select">
                                                                @foreach($categories as $cat)
                                                                    <option value="{{ $cat->nama }}" {{ $row->kategori == $cat->nama ? 'selected' : '' }}>{{ $cat->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Stok Masuk</label>
                                                            <input type="number" name="masuk" class="form-control" value="{{ $row->masuk }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Stok Keluar</label>
                                                            <input type="number" name="keluar" class="form-control" value="{{ $row->keluar }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">Belum ada data barang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-4">
                <form action="/master/barang" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" name="kode" class="form-control" placeholder="Contoh: SEM-01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: Semen Gresik 50kg" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->nama }}">{{ $cat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok Masuk</label>
                            <input type="number" name="masuk" class="form-control" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok Keluar</label>
                            <input type="number" name="keluar" class="form-control" value="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

### File: [resources/views/categories/index.blade.php](file:///c:/xampp/htdocs/kokopetshop/resources/views/categories/index.blade.php)
Manajemen Kategori Barang (Menu Kategori).
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Barang · Toko Bangunan JeWePe</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .sidebar { background-color: #0f172a; min-height: 100vh; color: #fff; padding: 2rem 1.5rem; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #1e293b; color: #fff; }
        .content-area { padding: 3rem; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <i class="ti ti-building-arch text-warning"></i>
                    <span>Toko Bangunan</span>
                </h5>
                <hr>
                <nav class="nav flex-column">
                    <a class="nav-link" href="/dashboard"><i class="ti ti-smart-home"></i> Dashboard</a>
                    <a class="nav-link active" href="/master/kategori"><i class="ti ti-category"></i> Kategori Barang</a>
                    <a class="nav-link" href="/master/barang"><i class="ti ti-box"></i> Daftar Barang</a>
                    <a class="nav-link" href="/master/pengguna"><i class="ti ti-users"></i> Manajemen Pengguna</a>
                    <a class="nav-link" href="/laporan"><i class="ti ti-file-text"></i> Halaman Laporan</a>
                    <a class="nav-link mt-5 text-danger" href="/logout"><i class="ti ti-logout"></i> Logout</a>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="col-lg-10 content-area">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Kategori Barang</h2>
                        <p class="text-secondary">Kelola kategori persediaan barang bangunan.</p>
                    </div>
                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="ti ti-plus"></i> Tambah Kategori
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-3 mb-3">{{ session('success') }}</div>
                @endif

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-bold text-dark">{{ $row->nama }}</td>
                                        <td>{{ $row->deskripsi }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $row->id }}">Detail</button>
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">Edit</button>
                                            <form action="/master/kategori/{{ $row->id }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Detail Modal -->
                                    <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-4">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Detail Kategori</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nama:</strong> {{ $row->nama }}</p>
                                                    <p><strong>Deskripsi:</strong> {{ $row->deskripsi }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-4">
                                                <form action="/master/kategori/{{ $row->id }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Edit Kategori</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Kategori</label>
                                                            <input type="text" name="nama" class="form-control" value="{{ $row->nama }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control" rows="3">{{ $row->deskripsi }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-4">
                <form action="/master/kategori" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: Bahan Semen" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi mengenai kategori..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

### File: [resources/views/users/index.blade.php](file:///c:/xampp/htdocs/kokopetshop/resources/views/users/index.blade.php)
Manajemen Pengguna (Menu Manajemen Pengguna).
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna · Toko Bangunan JeWePe</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .sidebar { background-color: #0f172a; min-height: 100vh; color: #fff; padding: 2rem 1.5rem; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #1e293b; color: #fff; }
        .content-area { padding: 3rem; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <i class="ti ti-building-arch text-warning"></i>
                    <span>Toko Bangunan</span>
                </h5>
                <hr>
                <nav class="nav flex-column">
                    <a class="nav-link" href="/dashboard"><i class="ti ti-smart-home"></i> Dashboard</a>
                    <a class="nav-link" href="/master/kategori"><i class="ti ti-category"></i> Kategori Barang</a>
                    <a class="nav-link" href="/master/barang"><i class="ti ti-box"></i> Daftar Barang</a>
                    <a class="nav-link active" href="/master/pengguna"><i class="ti ti-users"></i> Manajemen Pengguna</a>
                    <a class="nav-link" href="/laporan"><i class="ti ti-file-text"></i> Halaman Laporan</a>
                    <a class="nav-link mt-5 text-danger" href="/logout"><i class="ti ti-logout"></i> Logout</a>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="col-lg-10 content-area">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Manajemen Pengguna</h2>
                        <p class="text-secondary">Kelola daftar admin perusahaan Toko Bangunan JeWePe.</p>
                    </div>
                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="ti ti-plus"></i> Tambah Pengguna
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-3 mb-3">{{ session('success') }}</div>
                @endif

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email / Username</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-bold text-dark">{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $row->id }}">Detail</button>
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">Edit</button>
                                            <form action="/master/pengguna/{{ $row->id }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Detail Modal -->
                                    <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-4">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Detail Pengguna</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nama:</strong> {{ $row->name }}</p>
                                                    <p><strong>Email:</strong> {{ $row->email }}</p>
                                                    <p><strong>Waktu Terdaftar:</strong> {{ $row->created_at }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-4">
                                                <form action="/master/pengguna/{{ $row->id }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Edit Pengguna</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Lengkap</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $row->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Email / Username</label>
                                                            <input type="email" name="email" class="form-control" value="{{ $row->email }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Password Baru (Kosongkan jika tidak diganti)</label>
                                                            <input type="password" name="password" class="form-control" placeholder="Masukkan password baru">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data pengguna.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-4">
                <form action="/master/pengguna" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Admin JeWePe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email / Username</label>
                            <input type="email" name="email" class="form-control" placeholder="admin@jewepe.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password akun" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

### File: [resources/views/laporan/index.blade.php](file:///c:/xampp/htdocs/kokopetshop/resources/views/laporan/index.blade.php)
Halaman Laporan dengan filter tanggal pencarian.
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Persediaan · Toko Bangunan JeWePe</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .sidebar { background-color: #0f172a; min-height: 100vh; color: #fff; padding: 2rem 1.5rem; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #1e293b; color: #fff; }
        .content-area { padding: 3rem; }
        @media print {
            .sidebar, .btn, form { display: none !important; }
            .content-area { width: 100% !important; padding: 0 !important; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <i class="ti ti-building-arch text-warning"></i>
                    <span>Toko Bangunan</span>
                </h5>
                <hr>
                <nav class="nav flex-column">
                    <a class="nav-link" href="/dashboard"><i class="ti ti-smart-home"></i> Dashboard</a>
                    <a class="nav-link" href="/master/kategori"><i class="ti ti-category"></i> Kategori Barang</a>
                    <a class="nav-link" href="/master/barang"><i class="ti ti-box"></i> Daftar Barang</a>
                    <a class="nav-link" href="/master/pengguna"><i class="ti ti-users"></i> Manajemen Pengguna</a>
                    <a class="nav-link active" href="/laporan"><i class="ti ti-file-text"></i> Halaman Laporan</a>
                    <a class="nav-link mt-5 text-danger" href="/logout"><i class="ti ti-logout"></i> Logout</a>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="col-lg-10 content-area">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Laporan Persediaan</h2>
                        <p class="text-secondary">Cetak dan filter laporan keluar masuk barang bangunan.</p>
                    </div>
                    <button class="btn btn-secondary px-4 rounded-pill" onclick="window.print()">
                        <i class="ti ti-printer"></i> Cetak Laporan
                    </button>
                </div>

                <!-- Date Filter Form -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <form method="GET" action="/laporan">
                        <div class="row align-items-end g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-secondary">Tanggal Mulai</label>
                                <input type="date" name="dateFrom" class="form-control" value="{{ $from ?? '' }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-secondary">Tanggal Selesai</label>
                                <input type="date" name="dateTo" class="form-control" value="{{ $to ?? '' }}" required>
                            </div>
                            <div class="col-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                                <a href="/laporan" class="btn btn-outline-secondary w-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok Masuk</th>
                                    <th>Stok Keluar</th>
                                    <th>Stok Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                        <td class="font-monospace fw-bold">{{ $row->kode }}</td>
                                        <td>{{ $row->nama }}</td>
                                        <td>{{ $row->kategori }}</td>
                                        <td><span class="text-success">+{{ $row->masuk }}</span></td>
                                        <td><span class="text-danger">-{{ $row->keluar }}</span></td>
                                        <td class="fw-bold">{{ $row->stok }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Tidak ada data transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
```

### File: [resources/views/products/index.blade.php](file:///c:/xampp/htdocs/kokopetshop/resources/views/products/index.blade.php)
Halaman Persediaan Barang Publik.
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Persediaan · Toko Bangunan JeWePe</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .header-bar { background-color: #0f172a; color: #fff; padding: 2rem 0; }
    </style>
</head>
<body>
    <div class="header-bar shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0 d-flex align-items-center gap-2">
                <i class="ti ti-building-arch text-warning"></i>
                <span>Toko Bangunan JeWePe</span>
            </h4>
            <a href="/" class="btn btn-sm btn-outline-light rounded-pill px-3">Kembali ke Home</a>
        </div>
    </div>

    <div class="container py-5">
        <h2 class="fw-bold mb-4">Persediaan Barang Aktif</h2>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok Akhir</th>
                            <th>Status Ketersediaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-monospace fw-bold">{{ $row->kode }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->kategori }}</td>
                                <td class="fw-bold">{{ $row->stok }}</td>
                                <td>
                                    @if($row->stok > 0)
                                        <span class="badge bg-success text-white">Tersedia</span>
                                    @else
                                        <span class="badge bg-danger text-white">Tidak Tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data persediaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
```

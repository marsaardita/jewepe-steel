<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PT JeWePe Steel · Sistem Manajemen</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

    <style>
        :root {
            --bs-body-font-family: 'Outfit', sans-serif;
            --primary-color: #f59e0b;
            --primary-hover: #d97706;
            --dark-color: #0f172a;
        }
        body {
            background-color: #fafaf9;
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--dark-color) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand i {
            color: var(--primary-color);
        }
        .hero-section {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 4rem 0;
        }
        .hero-title {
            font-weight: 800;
            font-size: 3.5rem;
            line-height: 1.15;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
        }
        .hero-title span {
            color: var(--primary-color);
            background: linear-gradient(120deg, #f59e0b 0%, #ef4444 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-desc {
            font-size: 1.125rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn-primary-custom {
            background-color: var(--dark-color);
            color: #fff;
            padding: 0.8rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }
        .btn-primary-custom:hover {
            background-color: #1e293b;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.25);
        }
        .btn-secondary-custom {
            background-color: #fff;
            color: var(--dark-color);
            padding: 0.8rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-secondary-custom:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }
        .features-grid {
            margin-top: 3rem;
        }
        .feature-card {
            background: #fff;
            border: 1px solid #f1f5f9;
            padding: 2rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);
            border-color: #e2e8f0;
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background-color: #fef3c7;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }
        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        .feature-card p {
            font-size: 0.95rem;
            color: #64748b;
            margin-bottom: 0;
            line-height: 1.5;
        }
        .footer {
            border-top: 1px solid #f1f5f9;
            background-color: #fff;
            padding: 1.5rem 0;
            font-size: 0.9rem;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-3">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="ti ti-building-factory-2 fs-3"></i>
                <span>PT JeWePe Steel</span>
            </a>
            <div class="ms-auto d-flex gap-2">
                @if (Route::has('login'))
                    @if (Auth::check())
                        <a href="{{ url('/dashboard') }}" class="btn btn-secondary-custom">Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}" class="btn btn-primary-custom">
                            <i class="ti ti-login"></i> Masuk Admin
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center justify-content-between g-5">
                <div class="col-lg-6">
                    <h1 class="hero-title">
                        Kelola Persediaan <span>PT JeWePe Steel</span> Secara Cerdas & Real-time.
                    </h1>
                    <p class="hero-desc">
                        Aplikasi Management Information System terintegrasi untuk melacak stok masuk, stok keluar, manajemen kategori, serta laporan mutasi barang secara akurat.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ url('/login') }}" class="btn btn-primary-custom">
                            <span>Mulai Sekarang</span>
                            <i class="ti ti-arrow-right"></i>
                        </a>
                        <a href="https://laravel.com/docs" target="_blank" class="btn btn-secondary-custom">
                            <i class="ti ti-book-2"></i> Dokumentasi Laravel
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 position-relative">
                    <div class="feature-card border border-2 border-warning p-4 shadow-sm">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="feature-icon bg-warning text-white"><i class="ti ti-info-circle"></i></div>
                            <div>
                                <h4 class="m-0 fw-bold">Sistem Aktif</h4>
                                <small class="text-muted">Status Informasi Sistem</small>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent py-3 px-0">
                                <span>Framework Backend</span>
                                <span class="badge bg-dark rounded-pill">Laravel 12.61.0</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent py-3 px-0">
                                <span>Versi PHP Minimum</span>
                                <span class="badge bg-dark rounded-pill">PHP 8.2.12</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent py-3 px-0">
                                <span>Framework CSS</span>
                                <span class="badge bg-dark rounded-pill">Bootstrap 5.3.3</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="row row-cols-1 row-cols-md-3 g-4 features-grid">
                <div class="col">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="ti ti-package"></i>
                        </div>
                        <h3>Manajemen Barang</h3>
                        <p>Kelola data persediaan barang secara komprehensif, hitung mutasi masuk dan keluar, serta update stok instan.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="feature-card">
                        <div class="feature-icon" style="background-color: #dbeafe; color: #3b82f6;">
                            <i class="ti ti-category"></i>
                        </div>
                        <h3>Kategori Produk</h3>
                        <p>Pengelompokan barang berdasarkan kategori (Makanan Basah, Kering, Susu, dll.) guna mempermudah pencarian.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="feature-card">
                        <div class="feature-icon" style="background-color: #dcfce7; color: #22c55e;">
                            <i class="ti ti-file-text"></i>
                        </div>
                        <h3>Laporan Mutasi</h3>
                        <p>Hasilkan laporan mutasi transaksi lengkap dengan filter tanggal dan kemudahan cetak langsung via browser.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="m-0">© 2026 PT JeWePe Steel · Dikembangkan dengan Laravel 12 & Bootstrap 5</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

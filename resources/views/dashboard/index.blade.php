<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PT JeWePe Steel · Dashboard</title>

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
            --sidebar-width: 260px;
            --primary-amber: #f59e0b;
            --primary-amber-dark: #d97706;
            --bg-slate: #f8fafc;
            --dark-slate: #0f172a;
        }
        body {
            background-color: var(--bg-slate);
            color: #334155;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--dark-slate);
            color: #94a3b8;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 24px rgba(15, 23, 42, 0.05);
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid #1e293b;
        }
        .sidebar-brand a {
            font-weight: 800;
            font-size: 1.35rem;
            color: #fff !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-brand a i {
            color: var(--primary-amber);
        }
        .sidebar-nav {
            padding: 1.5rem 0;
            flex: 1;
        }
        .nav-link-custom {
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-left: 4px solid transparent;
            transition: all 0.15s ease;
        }
        .nav-link-custom:hover {
            background-color: #1e293b;
            color: #f8fafc;
        }
        .nav-link-custom.active {
            background-color: #1e293b;
            color: #fff;
            border-left-color: var(--primary-amber);
            font-weight: 600;
        }
        .nav-link-custom i {
            font-size: 1.25rem;
        }
        .sidebar-footer {
            border-top: 1px solid #1e293b;
            padding: 1rem 0;
        }
        .nav-link-logout {
            color: #ef4444;
        }
        .nav-link-logout:hover {
            background-color: #450a0a;
            color: #fee2e2;
        }
        
        /* ── MAIN CONTENT ── */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem 2.5rem;
            min-height: 100vh;
        }
        
        /* ── TOPBAR ── */
        .topbar-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.5rem;
        }
        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .profile-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: #fff;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: var(--dark-slate);
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }
        
        /* ── STAT CARDS ── */
        .card-stat {
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 1.5rem;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.01);
            transition: all 0.2s ease;
        }
        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.03);
            border-color: #cbd5e1;
        }
        .stat-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }
        .stat-icon-blue { background-color: #dbeafe; color: #2563eb; }
        .stat-icon-amber { background-color: #fef3c7; color: #d97706; }
        .stat-icon-green { background-color: #dcfce7; color: #16a34a; }
        .stat-icon-rose { background-color: #ffe4e6; color: #e11d48; }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 0.25rem;
        }
        .stat-value {
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--dark-slate);
            margin: 0;
        }
        
        /* ── DATA CARDS ── */
        .card-data {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 1.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.01);
            height: 100%;
        }
        .card-data-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--dark-slate);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .table thead th {
            font-weight: 600;
            font-size: 0.775rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            border-bottom: 2px solid #f1f5f9;
            padding: 0.85rem 1rem;
        }
        .table tbody td {
            padding: 0.95rem 1rem;
            font-size: 0.925rem;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .badge-status {
            font-weight: 600;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 6px;
        }
        .badge-kritis {
            background-color: #fee2e2;
            color: #dc2626;
        }
        .badge-rendah {
            background-color: #ffedd5;
            color: #ea580c;
        }

        .tbl-empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: #94a3b8;
        }
        .tbl-empty-state i {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
            display: block;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <a href="/">
                <i class="ti ti-building-factory-2"></i>
                <span>PT JeWePe Steel</span>
            </a>
        </div>
        <div class="sidebar-nav">
            <a href="{{ url('/dashboard') }}" class="nav-link-custom active">
                <i class="ti ti-layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ url('/products') }}" class="nav-link-custom">
                <i class="ti ti-package"></i>
                <span>Persediaan Barang</span>
            </a>
            <a href="{{ url('/master/kategori') }}" class="nav-link-custom">
                <i class="ti ti-database"></i>
                <span>Master Data</span>
            </a>
            <a href="{{ url('/laporan') }}" class="nav-link-custom">
                <i class="ti ti-report-analytics"></i>
                <span>Laporan</span>
            </a>
        </div>
        <div class="sidebar-footer">
            <a href="{{ url('/logout') }}" class="nav-link-custom nav-link-logout">
                <i class="ti ti-logout"></i>
                <span>Keluar</span>
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        
        <!-- TOPBAR -->
        <div class="topbar-custom">
            <div>
                <h1 class="h3 fw-bold text-dark m-0">Dashboard</h1>
                <p class="text-secondary small m-0">Ringkasan status persediaan barang dan mutasi terbaru.</p>
            </div>
            <div class="topbar-profile">
                <div class="text-end">
                    <span class="d-block fw-bold text-dark small">Admin JeWePe Steel</span>
                    <span class="text-muted small" style="font-size: 0.775rem;">Administrator</span>
                </div>
                <div class="profile-avatar">
                    <i class="ti ti-user-filled"></i>
                </div>
            </div>
        </div>

        <!-- STAT CARDS -->
        <div class="row g-4 mb-5">
            <div class="col-sm-6 col-lg-3">
                <div class="card-stat">
                    <div class="stat-icon-wrap stat-icon-blue shadow-sm">
                        <i class="ti ti-package"></i>
                    </div>
                    <p class="stat-label">Total Barang</p>
                    <p class="stat-value" id="statTotalBarang">0</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card-stat">
                    <div class="stat-icon-wrap stat-icon-amber shadow-sm">
                        <i class="ti ti-layers-difference"></i>
                    </div>
                    <p class="stat-label">Total Stok</p>
                    <p class="stat-value" id="statTotalStok">0</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card-stat">
                    <div class="stat-icon-wrap stat-icon-green shadow-sm">
                        <i class="ti ti-arrow-bar-to-down"></i>
                    </div>
                    <p class="stat-label">Barang Masuk</p>
                    <p class="stat-value" id="statMasuk">0</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card-stat">
                    <div class="stat-icon-wrap stat-icon-rose shadow-sm">
                        <i class="ti ti-arrow-bar-up"></i>
                    </div>
                    <p class="stat-label">Barang Keluar</p>
                    <p class="stat-value" id="statKeluar">0</p>
                </div>
            </div>
        </div>

        <!-- TABLES SECTION -->
        <div class="row g-4">
            <!-- Stok Terendah -->
            <div class="col-lg-6">
                <div class="card-data">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="card-data-title text-danger">
                            <i class="ti ti-alert-triangle-filled"></i>
                            <span>Stok Terendah / Kritis</span>
                        </h2>
                        <span class="badge bg-danger rounded-pill px-2 py-1" style="font-size: 0.775rem;">Perlu Restok</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-end">Stok</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyRendah"></tbody>
                        </table>
                    </div>
                    <div id="emptyRendah" class="tbl-empty-state" style="display:none">
                        <i class="ti ti-circle-check text-success"></i>
                        <span>Semua stok barang aman dan terpenuhi.</span>
                    </div>
                </div>
            </div>

            <!-- Stok Tertinggi -->
            <div class="col-lg-6">
                <div class="card-data">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="card-data-title text-dark">
                            <i class="ti ti-chart-bar"></i>
                            <span>Stok Tertinggi (Top 5)</span>
                        </h2>
                        <span class="badge bg-dark rounded-pill px-2 py-1" style="font-size: 0.775rem;">Persediaan Terbanyak</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-end">Stok</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyTinggi"></tbody>
                        </table>
                    </div>
                    <div id="emptyTinggi" class="tbl-empty-state" style="display:none">
                        <i class="ti ti-package-off"></i>
                        <span>Belum ada data barang.</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap Bundle with Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- State management script -->
    <script>
        function loadBarang() {
            try {
                return JSON.parse(localStorage.getItem('koko_barang') || '[]');
            } catch { return []; }
        }

        function getStatus(stok) {
            if (stok <= 0)  return { label: 'Kritis', cls: 'badge-kritis' };
            if (stok <= 10) return { label: 'Rendah', cls: 'badge-rendah' };
            return null;
        }

        function fmt(n) {
            return Number(n).toLocaleString('id-ID');
        }

        function renderDashboard() {
            const data = loadBarang();

            /* ── Stat values calculation ── */
            const totalBarang = data.length;
            const totalStok   = data.reduce((s, r) => s + (parseInt(r.stok) || 0), 0);
            const totalMasuk  = data.reduce((s, r) => s + (parseInt(r.masuk) || 0), 0);
            const totalKeluar = data.reduce((s, r) => s + (parseInt(r.keluar) || 0), 0);

            document.getElementById('statTotalBarang').textContent = fmt(totalBarang);
            document.getElementById('statTotalStok').textContent   = fmt(totalStok);
            document.getElementById('statMasuk').textContent       = fmt(totalMasuk);
            document.getElementById('statKeluar').textContent      = fmt(totalKeluar);

            /* ── Render Stok Terendah ── */
            const sortedLow = [...data]
                .filter(r => (parseInt(r.stok) || 0) < 10)
                .sort((a, b) => (parseInt(a.stok) || 0) - (parseInt(b.stok) || 0));

            const tbodyRendah = document.getElementById('tbodyRendah');
            const emptyRendah = document.getElementById('emptyRendah');

            if (sortedLow.length === 0) {
                tbodyRendah.innerHTML = '';
                emptyRendah.style.display = 'block';
            } else {
                emptyRendah.style.display = 'none';
                tbodyRendah.innerHTML = sortedLow.map(row => {
                    const st = getStatus(parseInt(row.stok) || 0);
                    const badge = st
                        ? `<span class="badge-status ${st.cls}">${st.label}</span>`
                        : `<span class="text-success small fw-bold">OK</span>`;
                    return `
                        <tr>
                            <td class="fw-semibold text-dark">${row.nama}</td>
                            <td>${row.kategori}</td>
                            <td class="text-end fw-bold">${row.stok}</td>
                            <td class="text-end">${badge}</td>
                        </tr>`;
                }).join('');
            }

            /* ── Render Stok Tertinggi ── */
            const sorted5High = [...data]
                .sort((a, b) => (parseInt(b.stok) || 0) - (parseInt(a.stok) || 0))
                .slice(0, 5);

            const tbodyTinggi = document.getElementById('tbodyTinggi');
            const emptyTinggi = document.getElementById('emptyTinggi');

            if (sorted5High.length === 0) {
                tbodyTinggi.innerHTML = '';
                emptyTinggi.style.display = 'block';
            } else {
                emptyTinggi.style.display = 'none';
                tbodyTinggi.innerHTML = sorted5High.map(row => `
                    <tr>
                        <td class="fw-semibold text-dark">${row.nama}</td>
                        <td>${row.kategori}</td>
                        <td class="text-end fw-bold text-success">${row.stok}</td>
                    </tr>`).join('');
            }
        }

        renderDashboard();

        // Sync with changes from other pages
        window.addEventListener('storage', e => {
            if (e.key === 'koko_barang' || e.key === null) renderDashboard();
        });
    </script>
</body>
</html>
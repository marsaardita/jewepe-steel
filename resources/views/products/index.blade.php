<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PT JeWePe Steel · Persediaan Barang</title>
  
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
    
    /* ── DATA CARDS ── */
    .card-data {
      background-color: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 24px;
      padding: 1.75rem;
      box-shadow: 0 4px 6px rgba(0,0,0,0.01);
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
    
    .badge-status-custom {
      font-weight: 600;
      font-size: 0.75rem;
      padding: 4px 8px;
      border-radius: 6px;
    }
    .badge-tersedia-custom { background-color: #dcfce7; color: #16a34a; }
    .badge-habis-custom { background-color: #fee2e2; color: #dc2626; }
    
    .tbl-empty-state {
      padding: 3.5rem 1rem;
      text-align: center;
      color: #94a3b8;
    }
    .tbl-empty-state i {
      font-size: 2.5rem;
      margin-bottom: 0.75rem;
      display: block;
    }
    
    .filter-btn-custom {
      padding: 0.5rem 1rem;
      border-radius: 10px;
      font-size: 0.85rem;
      font-weight: 600;
      transition: all 0.15s ease;
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
      <a href="{{ url('/dashboard') }}" class="nav-link-custom">
        <i class="ti ti-layout-dashboard"></i>
        <span>Dashboard</span>
      </a>
      <a href="{{ url('/products') }}" class="nav-link-custom active">
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
        <h1 class="h3 fw-bold text-dark m-0">Persediaan Barang</h1>
        <p class="text-secondary small m-0">Kelola stok produk secara real-time.</p>
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

    <!-- MAIN DATA CARD -->
    <div class="card-data shadow-sm">
      
      <!-- HEADER ROW -->
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div class="d-flex align-items-center gap-2">
          <!-- Filter buttons -->
          <div class="btn-group border rounded-3 p-1 bg-light">
            <button class="btn btn-sm filter-btn-custom btn-dark" id="filterAll" onclick="setFilter('all')">Semua</button>
            <button class="btn btn-sm filter-btn-custom btn-light text-success" id="filterTersedia" onclick="setFilter('tersedia')">
              <i class="ti ti-circle-check"></i> Tersedia
            </button>
            <button class="btn btn-sm filter-btn-custom btn-light text-danger" id="filterHabis" onclick="setFilter('habis')">
              <i class="ti ti-alert-triangle"></i> Habis
            </button>
          </div>
        </div>
        
        <div class="d-flex align-items-center gap-3">
          <!-- Search input -->
          <div class="position-relative" style="width: 280px;">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
              <i class="ti ti-search"></i>
            </span>
            <input 
              type="text" 
              class="form-control ps-5" 
              id="searchBar" 
              placeholder="Cari barang..." 
              oninput="handleSearch()" />
          </div>
        </div>
      </div>

      <!-- DATA TABLE -->
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th style="width: 60px;">No</th>
              <th>Tanggal</th>
              <th>Nama Barang</th>
              <th>Kategori</th>
              <th>Kode</th>
              <th>Masuk</th>
              <th>Keluar</th>
              <th>Stok Saat Ini</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>

      <!-- EMPTY STATE -->
      <div id="emptyState" class="tbl-empty-state" style="display:none;">
        <i class="ti ti-package-off fs-1 text-muted d-block mb-2"></i>
        <span>Tidak ada data persediaan barang ditemukan.</span>
      </div>

    </div>
  </div>

  <!-- Bootstrap Bundle with Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    let allData      = [];
    let searchQuery  = '';
    let statusFilter = 'all'; // 'all' | 'tersedia' | 'habis'

    /* ── DATA ── */
    function loadBarangData() {
      try { allData = JSON.parse(localStorage.getItem('koko_barang') || '[]'); }
      catch { allData = []; }
    }

    window.addEventListener('storage', e => {
      if (e.key === 'koko_barang' || e.key === null) {
        loadBarangData(); render();
      }
    });

    /* ── HELPERS ── */
    function getStatus(stok)  { return stok > 0 ? 'TERSEDIA' : 'TIDAK TERSEDIA'; }
    function badgeClass(s)    { return s === 'TIDAK TERSEDIA' ? 'badge-habis-custom' : 'badge-tersedia-custom'; }
    function stokClass(stok)  { return stok <= 0 ? 'text-danger fw-bold' : 'text-success fw-bold'; }
    function escapeHtml(s) {
      return String(s).replace(/[&<>"']/g, m =>
        ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
    }

    /* ── FILTER & SEARCH ── */
    function getFilteredData() {
      let result = allData;

      if (statusFilter === 'tersedia') result = result.filter(r => r.stok > 0);
      else if (statusFilter === 'habis') result = result.filter(r => r.stok <= 0);

      if (searchQuery) {
        const q = searchQuery.toLowerCase();
        result = result.filter(r =>
          (r.nama||'').toLowerCase().includes(q) ||
          (r.kode||'').toLowerCase().includes(q) ||
          (r.kategori||'').toLowerCase().includes(q) ||
          (r.tanggal||'').includes(q)
        );
      }
      return result;
    }

    function handleSearch() {
      searchQuery = document.getElementById('searchBar').value.trim();
      render();
    }

    function setFilter(filter) {
      statusFilter = filter;
      updateFilterBtns();
      render();
    }

    function updateFilterBtns() {
      const btnAll = document.getElementById('filterAll');
      const btnAv = document.getElementById('filterTersedia');
      const btnOut = document.getElementById('filterHabis');
      
      btnAll.className = 'btn btn-sm filter-btn-custom btn-light';
      btnAv.className = 'btn btn-sm filter-btn-custom btn-light text-success';
      btnOut.className = 'btn btn-sm filter-btn-custom btn-light text-danger';

      if (statusFilter === 'all') {
        btnAll.classList.replace('btn-light', 'btn-dark');
      } else if (statusFilter === 'tersedia') {
        btnAv.classList.replace('btn-light', 'btn-success');
        btnAv.classList.remove('text-success');
        btnAv.classList.add('text-white');
      } else if (statusFilter === 'habis') {
        btnOut.classList.replace('btn-light', 'btn-danger');
        btnOut.classList.remove('text-danger');
        btnOut.classList.add('text-white');
      }
    }

    function render() {
      const data       = getFilteredData();
      const tbody = document.getElementById('tableBody');
      const empty = document.getElementById('emptyState');

      if (data.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
      }
      empty.style.display = 'none';

      tbody.innerHTML = data.map((row, i) => {
        const status = getStatus(row.stok);
        return `
          <tr>
            <td>${i + 1}</td>
            <td>${row.tanggal || '-'}</td>
            <td class="fw-bold text-dark">${escapeHtml(row.nama)}</td>
            <td>${escapeHtml(row.kategori || '-')}</td>
            <td class="fw-semibold">${escapeHtml(row.kode || '-')}</td>
            <td class="text-success fw-bold">${row.masuk ?? 0}</td>
            <td class="text-danger fw-bold">${row.keluar ?? 0}</td>
            <td class="${stokClass(row.stok)}">${row.stok}</td>
            <td><span class="badge-status-custom ${badgeClass(status)}">${status}</span></td>
          </tr>`;
      }).join('');
    }

    /* ── INIT ── */
    loadBarangData();
    render();
  </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PT JeWePe Steel · Master Data – Daftar Barang</title>
  
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
    
    .nav-tabs-custom {
      display: flex;
      border-bottom: 2px solid #f1f5f9;
      margin-bottom: 1.5rem;
      gap: 20px;
    }
    .nav-tab-item {
      padding: 0.75rem 0.5rem;
      font-weight: 600;
      font-size: 0.95rem;
      color: #64748b;
      text-decoration: none;
      border-bottom: 3px solid transparent;
      margin-bottom: -2px;
      transition: all 0.15s ease;
    }
    .nav-tab-item:hover {
      color: var(--primary-amber);
    }
    .nav-tab-item.active {
      color: var(--dark-slate);
      border-bottom-color: var(--primary-amber);
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
    
    /* action buttons */
    .btn-action-custom {
      padding: 0.35rem 0.75rem;
      font-size: 0.8rem;
      font-weight: 600;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.15s ease;
    }
    .btn-detail-custom { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .btn-detail-custom:hover { background-color: #e2e8f0; }
    .btn-edit-custom { background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .btn-edit-custom:hover { background-color: #fef3c7; }
    .btn-delete-custom { background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .btn-delete-custom:hover { background-color: #fee2e2; }
    
    .badge-status-custom {
      font-weight: 600;
      font-size: 0.75rem;
      padding: 4px 8px;
      border-radius: 6px;
    }
    .badge-tersedia-custom { background-color: #dcfce7; color: #16a34a; }
    .badge-habis-custom { background-color: #fee2e2; color: #dc2626; }
    
    /* ── CUSTOM MODAL OVERLAYS ── */
    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.4);
      backdrop-filter: blur(4px);
      z-index: 2000;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      transition: all 0.3s ease;
    }
    .modal-overlay.open {
      display: flex;
    }
    .modal-custom-card {
      background: #fff;
      border-radius: 24px;
      padding: 2.25rem 2rem;
      width: 100%;
      max-width: 540px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
      border: 1px solid #f1f5f9;
      position: relative;
    }
    .modal-custom-card.wide {
      max-width: 680px;
    }
    
    /* autocomplete list */
    .autocomplete-wrap {
      position: relative;
    }
    .autocomplete-list {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: #fff;
      border: 1px solid #e2e8f0;
      border-top: none;
      border-radius: 0 0 12px 12px;
      max-height: 180px;
      overflow-y: auto;
      z-index: 1000;
      box-shadow: 0 10px 15px rgba(0,0,0,0.05);
    }
    .autocomplete-item {
      padding: 10px 14px;
      cursor: pointer;
      border-bottom: 1px solid #f1f5f9;
      display: flex;
      flex-direction: column;
      gap: 2px;
      transition: background 0.15s ease;
    }
    .autocomplete-item:hover {
      background-color: #f8fafc;
    }
    .autocomplete-item .ac-name {
      font-weight: 600;
      color: var(--dark-slate);
      font-size: 0.9rem;
    }
    .autocomplete-item .ac-meta {
      font-size: 0.775rem;
      color: #64748b;
    }
    
    .field-linked {
      border-color: #16a34a !important;
      background-color: #f0fdf4 !important;
      color: #16a34a !important;
    }
    .linked-banner {
      display: none;
      margin-bottom: 1rem;
      padding: 10px 14px;
      background-color: #f0fdf4;
      border: 1px solid #bbf7d0;
      border-radius: 12px;
      font-size: 0.85rem;
      color: #16a34a;
      align-items: center;
      gap: 10px;
    }
    .linked-banner.show {
      display: flex;
    }
    
    .error-msg {
      font-size: 0.775rem;
      color: #ef4444;
      margin-top: 4px;
      display: none;
    }
    .error-msg.show {
      display: block;
    }
    
    /* Toast */
    .toast-custom {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      background-color: var(--dark-slate);
      color: #fff;
      padding: 12px 24px;
      border-radius: 14px;
      font-weight: 500;
      font-size: 0.9rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      z-index: 3000;
      opacity: 0;
      transform: translateY(10px);
      transition: all 0.25s ease;
      pointer-events: none;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .toast-custom.show {
      opacity: 1;
      transform: translateY(0);
    }
    
    .btn-tambah {
      background-color: var(--dark-slate);
      color: #fff;
      font-weight: 600;
      padding: 0.65rem 1.25rem;
      border-radius: 12px;
      border: none;
      box-shadow: 0 4px 12px rgba(15,23,42,0.1);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s ease;
    }
    .btn-tambah:hover {
      background-color: #1e293b;
      transform: translateY(-1px);
      box-shadow: 0 6px 15px rgba(15,23,42,0.15);
      color: #fff;
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
      <a href="{{ url('/products') }}" class="nav-link-custom">
        <i class="ti ti-package"></i>
        <span>Persediaan Barang</span>
      </a>
      <a href="{{ url('/master/kategori') }}" class="nav-link-custom active">
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
        <h1 class="h3 fw-bold text-dark m-0">Master Data</h1>
        <p class="text-secondary small m-0">Kelola data master masuk dan keluar barang di PT JeWePe Steel.</p>
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
      
      <!-- NAV TABS -->
      <div class="nav-tabs-custom">
        <a class="nav-tab-item" href="{{ url('/master/kategori') }}">Kategori Barang</a>
        <a class="nav-tab-item active" href="{{ url('/master/barang') }}">Daftar Barang</a>
        <a class="nav-tab-item" href="{{ url('/master/pengguna') }}">Manajemen Pengguna</a>
      </div>

      <!-- HEADER ROW -->
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div class="d-flex align-items-center gap-2">
          <!-- Filter buttons -->
          <div class="btn-group border rounded-3 p-1 bg-light">
            <button class="btn btn-sm filter-btn-custom btn-dark" id="filterAll" onclick="setStatusFilter('all')">Semua</button>
            <button class="btn btn-sm filter-btn-custom btn-light text-success" id="filterTersedia" onclick="setStatusFilter('tersedia')">
              <i class="ti ti-circle-check"></i> Tersedia
            </button>
            <button class="btn btn-sm filter-btn-custom btn-light text-danger" id="filterHabis" onclick="setStatusFilter('habis')">
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
              id="searchBarang" 
              placeholder="Cari barang..." 
              oninput="onSearch()" />
          </div>

          <!-- Add Button -->
          <button class="btn btn-tambah" onclick="openAddModal()">
            <i class="ti ti-plus"></i> Tambah Barang
          </button>
        </div>
      </div>

      <!-- DATA TABLE -->
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th style="width: 60px;">No</th>
              <th>Tanggal</th>
              <th>Kode</th>
              <th>Nama Barang</th>
              <th>Kategori</th>
              <th>Masuk</th>
              <th>Keluar</th>
              <th>Stok</th>
              <th>Status</th>
              <th style="width: 260px;" class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>

      <!-- EMPTY STATE -->
      <div id="emptyState" class="tbl-empty-state" style="display:none;">
        <i class="ti ti-package-off fs-1 text-muted d-block mb-2"></i>
        <span>Tidak ada data barang ditemukan.</span>
      </div>

    </div>
  </div>

  <!-- ADD / EDIT MODAL OVERLAY -->
  <div class="modal-overlay" id="formModal">
    <div class="modal-custom-card">
      <h3 class="fw-bold mb-1 text-dark" id="modalTitle">Tambah Barang</h3>
      <p class="text-secondary small mb-4">Lengkapi form berikut dengan data barang.</p>

      <!-- Linked banner -->
      <div class="linked-banner mb-3" id="linkedBanner">
        <i class="ti ti-link-ok"></i>
        <span id="linkedBannerText">Barang dikenali — kode otomatis terisi.</span>
      </div>

      <div class="row g-3">
        <!-- Tanggal -->
        <div class="col-md-6">
          <label class="form-label fw-semibold small text-secondary">Tanggal <span class="text-danger">*</span></label>
          <input type="date" class="form-control" id="inputTanggal" oninput="clearErr('errTanggal','inputTanggal')" />
          <p class="error-msg" id="errTanggal">Tanggal wajib diisi.</p>
        </div>

        <!-- Nama Barang -->
        <div class="col-md-6 autocomplete-wrap">
          <label class="form-label fw-semibold small text-secondary">Nama Barang <span class="text-danger">*</span></label>
          <input 
            type="text" 
            class="form-control" 
            id="inputNama" 
            placeholder="Nama barang..."
            autocomplete="off"
            oninput="onNamaInput(); clearErr('errNama','inputNama')" />
          <div class="autocomplete-list" id="acNamaList" style="display:none;"></div>
          <p class="error-msg" id="errNama">Nama barang tidak boleh kosong.</p>
        </div>

        <!-- Kode Barang -->
        <div class="col-md-6 autocomplete-wrap">
          <label class="form-label fw-semibold small text-secondary">Kode Barang <span class="text-danger">*</span></label>
          <input 
            type="text" 
            class="form-control" 
            id="inputKode" 
            placeholder="Contoh: DF-001"
            autocomplete="off"
            oninput="onKodeInput(); clearErr('errKode','inputKode')" />
          <div class="autocomplete-list" id="acKodeList" style="display:none;"></div>
          <p class="error-msg" id="errKode">Kode barang tidak boleh kosong.</p>
        </div>

        <!-- Kategori -->
        <div class="col-md-6">
          <label class="form-label fw-semibold small text-secondary">Kategori <span class="text-danger">*</span></label>
          <select class="form-select" id="inputKategori">
            <option value="">-- Pilih Kategori --</option>
          </select>
          <p class="error-msg" id="errKategori">Pilih kategori terlebih dahulu.</p>
        </div>

        <!-- Stok Masuk -->
        <div class="col-md-6">
          <label class="form-label fw-semibold small text-secondary">Stok Masuk</label>
          <input type="number" class="form-control" id="inputMasuk" placeholder="0" min="0" value="0" oninput="hitungStok()" />
        </div>

        <!-- Stok Keluar -->
        <div class="col-md-6">
          <label class="form-label fw-semibold small text-secondary">Stok Keluar</label>
          <input type="number" class="form-control" id="inputKeluar" placeholder="0" min="0" value="0" oninput="hitungStok()" />
        </div>

        <!-- Stok Akhir -->
        <div class="col-12">
          <label class="form-label fw-semibold small text-secondary">Stok Akhir</label>
          <input type="number" class="form-control bg-light text-dark fw-bold" id="inputStok" placeholder="Otomatis dihitung" readonly />
          <small class="text-muted d-block mt-1" id="hintStok" style="font-size: 0.775rem;">Dihitung otomatis: Masuk - Keluar</small>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <button class="btn btn-light px-4 py-2 rounded-3 text-secondary border fw-semibold small" onclick="closeModal('formModal')">Batal</button>
        <button class="btn btn-warning px-4 py-2 rounded-3 fw-semibold small text-dark" onclick="saveBarang()">Simpan</button>
      </div>
    </div>
  </div>

  <!-- DELETE MODAL OVERLAY -->
  <div class="modal-overlay" id="deleteModal">
    <div class="modal-custom-card">
      <h3 class="fw-bold mb-2 text-dark">Hapus Barang</h3>
      <p class="text-secondary small mb-4" id="deleteText">Apakah Anda yakin ingin menghapus barang ini?</p>
      
      <div class="d-flex justify-content-end gap-2">
        <button class="btn btn-light px-4 py-2 rounded-3 text-secondary border fw-semibold small" onclick="closeModal('deleteModal')">Batal</button>
        <button class="btn btn-danger px-4 py-2 rounded-3 fw-semibold small" onclick="confirmDelete()">Hapus</button>
      </div>
    </div>
  </div>

  <!-- DETAIL MODAL OVERLAY (WIDE) -->
  <div class="modal-overlay" id="detailModal">
    <div class="modal-custom-card wide">
      <h3 class="fw-bold mb-1 text-dark">Detail Barang</h3>
      <p class="text-secondary small mb-4">Informasi lengkap barang.</p>

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold small text-secondary">Kode Barang</label>
          <input type="text" class="form-control bg-light" id="detailKode" readonly />
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold small text-secondary">Nama Barang</label>
          <input type="text" class="form-control bg-light" id="detailNama" readonly />
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold small text-secondary">Kategori</label>
          <input type="text" class="form-control bg-light" id="detailKategori" readonly />
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold small text-secondary">Status</label>
          <div id="detailStatusBadge" class="mt-1"></div>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold small text-secondary">Total Masuk</label>
          <input type="number" class="form-control bg-light" id="detailMasuk" readonly />
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold small text-secondary">Total Keluar</label>
          <input type="number" class="form-control bg-light" id="detailKeluar" readonly />
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold small text-secondary">Stok Saat Ini</label>
          <input type="number" class="form-control bg-light fw-bold" id="detailStok" readonly />
        </div>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <button class="btn btn-light px-4 py-2 rounded-3 text-secondary border fw-semibold small" onclick="closeModal('detailModal')">Tutup</button>
      </div>
    </div>
  </div>

  <!-- TOAST -->
  <div class="toast-custom shadow-sm" id="toast">
    <i class="ti ti-info-circle-filled text-warning"></i>
    <span id="toastMessage">Barang berhasil diperbarui</span>
  </div>

  <!-- Bootstrap Bundle with Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // ══════════════════════════════════════════════════
    //  DATA & STATE
    // ══════════════════════════════════════════════════
    let data        = (function(){ try { return JSON.parse(localStorage.getItem('koko_barang')||'[]'); } catch { return []; } })();
    let nextId      = (data.length ? Math.max(...data.map(d=>d.id)) + 1 : 1);
    let editId      = null;
    let deleteId    = null;
    let searchQuery = '';
    let statusFilter = 'all'; // 'all' | 'tersedia' | 'habis'

    function saveToStorage(items) { localStorage.setItem('koko_barang', JSON.stringify(items)); try { window.dispatchEvent(new Event('storage')); } catch(e){} }
    function loadFromStorage() { try { return JSON.parse(localStorage.getItem('koko_barang') || '[]'); } catch { return []; } }

    // Riwayat Stok
    function loadMovements() { try { return JSON.parse(localStorage.getItem('koko_movements') || '[]'); } catch { return []; } }
    function saveMovements(mv) { localStorage.setItem('koko_movements', JSON.stringify(mv)); }
    function addMovement(barangId, tanggal, tipe, jumlah, catatan) {
      const mv = loadMovements();
      mv.push({ barangId, tanggal, tipe, jumlah: parseInt(jumlah)||0, catatan: catatan||'' });
      saveMovements(mv);
    }

    // Category Select
    function loadCategories() { try { return JSON.parse(localStorage.getItem('koko_kategori') || '[]'); } catch { return []; } }
    function populateCategorySelect() {
      const sel = document.getElementById('inputKategori');
      const cats = loadCategories();
      sel.innerHTML = '<option value="">-- Pilih Kategori --</option>' + cats.map(c => `<option value="${escapeHtml(c.nama||c)}">${escapeHtml(c.nama||c)}</option>`).join('');
      try { if (editId) sel.value = (data.find(r=>r.id===editId)||{}).kategori || ''; } catch(e){}
    }
    function escapeHtml(s) { return String(s).replace(/[&<>"']/g, function(m){ const map = {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}; return map[m]; }); }

    // auto-generate kode berdasarkan kategori
    function getCodePrefix(kategori) {
      if (!kategori) return '';
      const lower = kategori.toLowerCase();
      if (lower.includes('dry')) return 'DF';
      if (lower.includes('wet')) return 'WF';
      if (lower.includes('susu')) return 'S';
      if (lower.includes('treats')) return 'T';
      return 'GNL';
    }

    function generateKodeBarang(kategori) {
      const prefix = getCodePrefix(kategori);
      if (!prefix) return '';
      const existing = data.filter(r => (r.kode||'').startsWith(prefix + '-'));
      const nums = existing.map(r => {
        const m = (r.kode||'').match(/-?(\d+)$/);
        return m ? parseInt(m[1]) : 0;
      }).filter(n => n > 0);
      const nextNum = (nums.length ? Math.max(...nums) + 1 : 1);
      return prefix + '-' + String(nextNum).padStart(3, '0');
    }

    window.addEventListener('storage', e => {
      if (e.key === 'koko_barang' || e.key === null) {
        data = loadFromStorage(); render();
      }
      if (e.key === 'koko_kategori' || e.key === null) {
        populateCategorySelect();
      }
    });

    // status & badges
    function getStatus(stok) { return stok > 0 ? 'TERSEDIA' : 'TIDAK TERSEDIA'; }
    function badgeClass(s) { return s === 'TIDAK TERSEDIA' ? 'badge-habis-custom' : 'badge-tersedia-custom'; }
    function showToast(msg) { 
      const t = document.getElementById('toast'); 
      document.getElementById('toastMessage').textContent = msg;
      t.classList.add('show'); 
      setTimeout(() => t.classList.remove('show'), 2500); 
    }

    // autocomplete & autofill
    let linkedBarangId = null;

    function getLatestByKode(kode) {
      const entries = data.filter(r => (r.kode||'').toLowerCase() === kode.toLowerCase());
      if(!entries.length) return null;
      return entries.reduce((a, b) => (b.id > a.id ? b : a));
    }

    function getUniqueBarang() {
      const seen = {};
      data.forEach(r => {
        const k = (r.kode||'').toLowerCase();
        if(!seen[k] || r.id > seen[k].id) seen[k] = r;
      });
      return Object.values(seen);
    }

    function onNamaInput() {
      if(editId !== null) return;
      const q = document.getElementById('inputNama').value.trim().toLowerCase();
      unlinkBarang();
      if(q.length < 1) { hideAcList('acNamaList'); return; }
      const matches = getUniqueBarang().filter(r => (r.nama||'').toLowerCase().includes(q));
      renderAcList('acNamaList', matches, r => `<span class="ac-name">${escapeHtml(r.nama)}</span><span class="ac-meta">${escapeHtml(r.kode)} &middot; ${escapeHtml(r.kategori)}</span>`);
    }

    function onKodeInput() {
      if(editId !== null) return;
      const q = document.getElementById('inputKode').value.trim().toLowerCase();
      unlinkBarang();
      if(q.length < 1) { hideAcList('acKodeList'); return; }
      const matches = getUniqueBarang().filter(r => (r.kode||'').toLowerCase().includes(q));
      renderAcList('acKodeList', matches, r => `<span class="ac-name">${escapeHtml(r.kode)}</span><span class="ac-meta">${escapeHtml(r.nama)} &middot; ${escapeHtml(r.kategori)}</span>`);
    }

    function renderAcList(listId, items, renderFn) {
      const list = document.getElementById(listId);
      if(!items.length) { list.style.display = 'none'; return; }
      list.innerHTML = items.slice(0, 8).map(r =>
        `<div class="autocomplete-item" onmousedown="selectBarang(${r.id})">${renderFn(r)}</div>`
      ).join('');
      list.style.display = 'block';
    }

    function hideAcList(listId) {
      const el = document.getElementById(listId);
      if(el) el.style.display = 'none';
    }

    function selectBarang(id) {
      const entries = data.filter(r => r.id === id);
      if(!entries.length) return;
      const row = entries[0];
      const latest = getLatestByKode(row.kode);
      const prevStok = latest ? latest.stok : 0;

      linkedBarangId = id;

      document.getElementById('inputNama').value = row.nama;
      document.getElementById('inputKode').value = row.kode;

      const sel = document.getElementById('inputKategori');
      let found = false;
      for(let opt of sel.options) { if(opt.value === row.kategori) { found = true; break; } }
      if(!found) {
        const opt = document.createElement('option');
        opt.value = row.kategori; opt.textContent = row.kategori;
        sel.appendChild(opt);
      }
      sel.value = row.kategori;

      document.getElementById('inputKode').readOnly = true;
      document.getElementById('inputKode').classList.add('field-linked');
      sel.disabled = true;
      sel.classList.add('field-linked');

      document.getElementById('linkedBannerText').innerHTML =
        `<strong>${escapeHtml(row.nama)}</strong> ditemukan &mdash; Kode: <strong>${escapeHtml(row.kode)}</strong> &middot; Stok saat ini: <strong>${prevStok}</strong>`;
      document.getElementById('linkedBanner').classList.add('show');

      hideAcList('acNamaList');
      hideAcList('acKodeList');
      hitungStok();

      ['errNama','errKode','errKategori'].forEach(id => {
        const el = document.getElementById(id);
        if(el) el.classList.remove('show');
      });
    }

    function unlinkBarang() {
      if(!linkedBarangId) return;
      linkedBarangId = null;
      const kodeEl = document.getElementById('inputKode');
      const selEl  = document.getElementById('inputKategori');
      kodeEl.readOnly = false;
      kodeEl.classList.remove('field-linked');
      selEl.disabled = false;
      selEl.classList.remove('field-linked');
      document.getElementById('linkedBanner').classList.remove('show');
    }

    function hitungStok() {
      const masuk  = parseInt(document.getElementById('inputMasuk').value)  || 0;
      const keluar = parseInt(document.getElementById('inputKeluar').value) || 0;

      if(editId === null && linkedBarangId) {
        const kode     = document.getElementById('inputKode').value;
        const latest   = getLatestByKode(kode);
        const prevStok = latest ? latest.stok : 0;
        document.getElementById('inputStok').value = prevStok + masuk - keluar;
        document.getElementById('hintStok').textContent =
          `Stok lama: ${prevStok} + Masuk: ${masuk} − Keluar: ${keluar} = ${prevStok + masuk - keluar}`;
        return;
      }
      document.getElementById('inputStok').value = masuk - keluar;
      document.getElementById('hintStok').textContent = 'Dihitung otomatis: Masuk − Keluar';
    }

    function clearErr(errId, inputId) {
      const errEl = document.getElementById(errId);
      const inEl  = document.getElementById(inputId);
      if(errEl) errEl.classList.remove('show');
      if(inEl)  inEl.classList.remove('field-error');
    }

    // search & filter
    function filteredData() {
      let result = data;

      if (statusFilter === 'tersedia') {
        result = result.filter(r => r.stok > 0);
      } else if (statusFilter === 'habis') {
        result = result.filter(r => r.stok <= 0);
      }

      if (searchQuery) {
        const q = searchQuery.toLowerCase();
        result = result.filter(r =>
          r.nama.toLowerCase().includes(q) ||
          (r.kode||'').toLowerCase().includes(q) ||
          (r.kategori||'').toLowerCase().includes(q) ||
          (r.tanggal||'').includes(q)
        );
      }

      result = [...result].sort((a, b) => {
        const dateA = a.tanggal || '';
        const dateB = b.tanggal || '';
        if (dateA !== dateB) {
          return dateB.localeCompare(dateA);
        }
        return b.id - a.id;
      });

      return result;
    }

    function onSearch() {
      searchQuery = document.getElementById('searchBarang').value.trim();
      render();
    }

    function setStatusFilter(filter) {
      statusFilter = filter;
      updateFilterButtons();
      render();
    }

    function updateFilterButtons() {
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

    // render table
    function render() {
      const source = filteredData();
      const tbody = document.getElementById('tableBody');
      const empty = document.getElementById('emptyState');

      if (source.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
      }
      empty.style.display = 'none';

      tbody.innerHTML = source.map((row, i) => `
        <tr>
          <td>${i + 1}</td>
          <td>${row.tanggal||'-'}</td>
          <td class="fw-semibold">${row.kode}</td>
          <td class="fw-bold text-dark">${escapeHtml(row.nama)}</td>
          <td>${escapeHtml(row.kategori)}</td>
          <td class="text-success fw-bold">${row.masuk}</td>
          <td class="text-danger fw-bold">${row.keluar}</td>
          <td class="fw-bold ${row.stok <= 0 ? 'text-danger' : 'text-success'}">${row.stok}</td>
          <td><span class="badge-status-custom ${badgeClass(getStatus(row.stok))}">${getStatus(row.stok)}</span></td>
          <td class="text-end">
            <div class="d-inline-flex gap-1">
              <button class="btn-action-custom btn-detail-custom" onclick="openDetailModal(${row.id})"><i class="ti ti-eye"></i> Detail</button>
              <button class="btn-action-custom btn-edit-custom" onclick="openEditModal(${row.id})"><i class="ti ti-pencil"></i> Edit</button>
              <button class="btn-action-custom btn-delete-custom" onclick="openDeleteModal(${row.id})"><i class="ti ti-trash"></i> Hapus</button>
            </div>
          </td>
        </tr>
      `).join('');
    }

    // modals
    function openModal(id){ document.getElementById(id).classList.add('open'); }
    function closeModal(id){ document.getElementById(id).classList.remove('open'); }
    function resetForm(){
      ['inputTanggal','inputKode','inputNama','inputMasuk','inputKeluar','inputStok'].forEach(id => {
        const el = document.getElementById(id);
        if(!el) return;
        el.value = (id.includes('Masuk')||id.includes('Keluar')||id.includes('Stok')) ? '0' : '';
        el.classList.remove('field-error','field-linked');
        el.readOnly = false;
      });
      const selKat = document.getElementById('inputKategori');
      selKat.value = ''; selKat.disabled = false;
      selKat.classList.remove('field-linked');
      ['errTanggal','errKode','errNama','errKategori'].forEach(id => {
        const el = document.getElementById(id); if(el) el.classList.remove('show');
      });
      const hintEl = document.getElementById('hintStok');
      if(hintEl) hintEl.textContent = 'Dihitung otomatis: Masuk - Keluar';
      
      linkedBarangId = null;
      hideAcList('acNamaList');
      hideAcList('acKodeList');
      const banner = document.getElementById('linkedBanner');
      if(banner) banner.classList.remove('show');
    }

    // add
    function openAddModal(){
      editId = null;
      document.getElementById('modalTitle').textContent = 'Tambah Barang';
      resetForm();
      populateCategorySelect();
      document.getElementById('inputKode').readOnly = false;
      openModal('formModal');
    }

    // edit
    function openEditModal(id){
      const row = data.find(r=>r.id===id);
      if(!row) return;
      editId = id;
      document.getElementById('modalTitle').textContent = 'Edit Barang';
      resetForm();
      populateCategorySelect();
      document.getElementById('inputTanggal').value = row.tanggal||'';
      document.getElementById('inputKode').value = row.kode;
      document.getElementById('inputKode').readOnly = true;
      document.getElementById('inputNama').value = row.nama;
      document.getElementById('inputKategori').value = row.kategori;
      document.getElementById('inputMasuk').value = row.masuk;
      document.getElementById('inputKeluar').value = row.keluar;
      document.getElementById('inputStok').value = row.stok;
      openModal('formModal');
    }

    // detail
    function openDetailModal(id){
      const row = data.find(r=>r.id===id);
      if(!row) return;
      document.getElementById('detailKode').value      = row.kode || '-';
      document.getElementById('detailNama').value      = row.nama || '-';
      document.getElementById('detailKategori').value  = row.kategori || '-';
      document.getElementById('detailMasuk').value     = row.masuk || 0;
      document.getElementById('detailKeluar').value    = row.keluar || 0;
      document.getElementById('detailStok').value      = row.stok || 0;

      const status = getStatus(row.stok);
      const cls = status === 'TIDAK TERSEDIA' ? 'badge-habis-custom' : 'badge-tersedia-custom';
      document.getElementById('detailStatusBadge').innerHTML = `<span class="badge-status-custom ${cls}">${status}</span>`;
      openModal('detailModal');
    }

    // validate & save
    function validate(){
      let ok = true;
      const tanggal  = document.getElementById('inputTanggal').value.trim();
      const kode     = document.getElementById('inputKode').value.trim();
      const nama     = document.getElementById('inputNama').value.trim();
      const kategori = document.getElementById('inputKategori').value;
      if(!tanggal){ document.getElementById('errTanggal').classList.add('show'); document.getElementById('inputTanggal').classList.add('field-error'); ok=false; }
      if(!kode){ document.getElementById('errKode').classList.add('show'); document.getElementById('inputKode').classList.add('field-error'); ok=false; }
      if(!nama){ document.getElementById('errNama').classList.add('show'); document.getElementById('inputNama').classList.add('field-error'); ok=false; }
      if(!kategori){ document.getElementById('errKategori').classList.add('show'); document.getElementById('inputKategori').classList.add('field-error'); ok=false; }
      return ok;
    }

    function saveBarang(){
      if(!validate()) return;
      const tanggal  = document.getElementById('inputTanggal').value.trim();
      const kode     = document.getElementById('inputKode').value.trim();
      const nama     = document.getElementById('inputNama').value.trim();
      const kategori = document.getElementById('inputKategori').value;
      const masuk    = Math.max(0, parseInt(document.getElementById('inputMasuk').value)||0);
      const keluar   = Math.max(0, parseInt(document.getElementById('inputKeluar').value)||0);

      if(editId !== null){
        const row = data.find(r=>r.id===editId);
        if(row){
          const selisihMasuk  = masuk  - (row.masuk  || 0);
          const selisihKeluar = keluar - (row.keluar || 0);
          if(selisihMasuk  > 0) addMovement(row.id, tanggal, 'masuk',  selisihMasuk,  'Update via Edit');
          if(selisihKeluar > 0) addMovement(row.id, tanggal, 'keluar', selisihKeluar, 'Update via Edit');
          
          const oldKode = row.kode;
          row.tanggal = tanggal;
          row.masuk = masuk;
          row.keluar = keluar;

          const codeEntries = data.filter(r => (r.kode || '').toLowerCase() === oldKode.toLowerCase());
          codeEntries.sort((a, b) => {
            const dateA = a.tanggal || '';
            const dateB = b.tanggal || '';
            if (dateA !== dateB) return dateA.localeCompare(dateB);
            return a.id - b.id;
          });

          let runningStok = 0;
          codeEntries.forEach(r => {
            r.nama = nama;
            r.kategori = kategori;
            runningStok = runningStok + (r.masuk || 0) - (r.keluar || 0);
            r.stok = runningStok;
          });
        }
        showToast('Barang berhasil diperbarui.');

      } else {
        const prevEntries = data.filter(r => (r.kode||'').toLowerCase() === kode.toLowerCase());
        const prevStok = prevEntries.length > 0
          ? prevEntries.reduce((latest, r) => (!latest || r.id > latest.id ? r : latest), null)?.stok ?? 0
          : 0;

        const stok  = prevStok + masuk - keluar;
        const newId = nextId++;
        const catatan = prevEntries.length > 0
          ? `Stok lanjutan (sebelumnya: ${prevStok})`
          : 'Stok awal (tambah barang)';

        const record = {id: newId, tanggal, kode, nama, kategori, masuk, keluar, stok};
        data.unshift(record);

        if(masuk  > 0) addMovement(newId, tanggal, 'masuk',  masuk,  catatan);
        if(keluar > 0) addMovement(newId, tanggal, 'keluar', keluar, catatan);

        const pesanToast = prevEntries.length > 0
          ? `Stok ${nama} ditambahkan. Stok baru: ${stok}`
          : 'Barang berhasil ditambahkan.';
        showToast(pesanToast);
      }

      saveToStorage(data);
      closeModal('formModal');
      render();
    }

    // delete
    function openDeleteModal(id){
      deleteId = id;
      const row = data.find(r=>r.id===id);
      document.getElementById('deleteText').textContent = `Apakah Anda yakin ingin menghapus barang "${row?.nama}"? Tindakan ini tidak dapat dibatalkan.`;
      openModal('deleteModal');
    }
    function confirmDelete(){
      data = data.filter(r=>r.id!==deleteId);
      deleteId = null;
      saveToStorage(data);
      closeModal('deleteModal');
      showToast('Barang berhasil dihapus.');
      render();
    }

    // close on overlay click
    document.querySelectorAll('.modal-overlay').forEach(o=>{
      o.addEventListener('click', e=>{ if(e.target===o) o.classList.remove('open'); });
    });

    document.getElementById('inputKategori').addEventListener('change', function() {
      if (editId === null) {
        const kode = generateKodeBarang(this.value);
        if (kode) {
          document.getElementById('inputKode').value = kode;
          hitungStok();
        }
      }
    });

    document.getElementById('inputKode').addEventListener('input', function() {
      if (editId === null) hitungStok();
    });

    // init
    populateCategorySelect();
    render();
  </script>
</body>
</html>
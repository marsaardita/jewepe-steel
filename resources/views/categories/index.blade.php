<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PT JeWePe Steel · Master Data – Kategori Barang</title>
  
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
      max-width: 440px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
      border: 1px solid #f1f5f9;
      position: relative;
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
        <h1 class="h3 fw-bold text-dark m-0">Master Kategori</h1>
        <p class="text-secondary small m-0">Kelola kategori barang untuk pengelompokan produk di PT JeWePe Steel.</p>
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
        <a class="nav-tab-item active" href="{{ url('/master/kategori') }}">Kategori Barang</a>
        <a class="nav-tab-item" href="{{ url('/master/barang') }}">Daftar Barang</a>
        <a class="nav-tab-item" href="{{ url('/master/pengguna') }}">Manajemen Pengguna</a>
      </div>

      <!-- HEADER ROW -->
      <div class="d-flex justify-content-end mb-4">
        <!-- Add Button -->
        <button class="btn btn-tambah" onclick="openAddModal()">
          <i class="ti ti-plus"></i> Tambah Kategori
        </button>
      </div>

      <!-- DATA TABLE -->
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th style="width: 60px;">No</th>
              <th>Nama Kategori</th>
              <th>Deskripsi</th>
              <th>Tanggal Dibuat</th>
              <th style="width: 260px;" class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>

    </div>
  </div>

  <!-- ADD / EDIT MODAL OVERLAY -->
  <div class="modal-overlay" id="formModal">
    <div class="modal-custom-card">
      <h3 class="fw-bold mb-1 text-dark" id="modalTitle">Tambah Kategori</h3>
      <p class="text-secondary small mb-4" id="modalSub">Isi data kategori baru.</p>

      <div class="row g-3">
        <!-- Nama Kategori -->
        <div class="col-12">
          <label class="form-label fw-semibold small text-secondary">Nama Kategori <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="inputNama" placeholder="Contoh: Dry Food" />
        </div>

        <!-- Deskripsi -->
        <div class="col-12">
          <label class="form-label fw-semibold small text-secondary">Deskripsi</label>
          <textarea class="form-control" id="inputDesk" rows="3" placeholder="Deskripsi singkat kategori..."></textarea>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <button class="btn btn-light px-4 py-2 rounded-3 text-secondary border fw-semibold small" onclick="closeModal('formModal')">Batal</button>
        <button class="btn btn-warning px-4 py-2 rounded-3 fw-semibold small text-dark" onclick="saveKategori()">Simpan</button>
      </div>
    </div>
  </div>

  <!-- DELETE CONFIRM OVERLAY -->
  <div class="modal-overlay" id="deleteModal">
    <div class="modal-custom-card">
      <h3 class="fw-bold mb-2 text-dark">Hapus Kategori</h3>
      <p class="text-secondary small mb-4" id="deleteText">Apakah Anda yakin ingin menghapus kategori ini?</p>
      
      <div class="d-flex justify-content-end gap-2">
        <button class="btn btn-light px-4 py-2 rounded-3 text-secondary border fw-semibold small" onclick="closeModal('deleteModal')">Batal</button>
        <button class="btn btn-danger px-4 py-2 rounded-3 fw-semibold small" onclick="confirmDelete()">Hapus</button>
      </div>
    </div>
  </div>

  <!-- DETAIL MODAL OVERLAY -->
  <div class="modal-overlay" id="detailModal">
    <div class="modal-custom-card">
      <h3 class="fw-bold mb-1 text-dark">Detail Kategori</h3>
      <p class="text-secondary small mb-4">Informasi lengkap kategori.</p>

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label fw-semibold small text-secondary">Nama Kategori</label>
          <input type="text" class="form-control bg-light" id="detailNama" readonly />
        </div>
        <div class="col-12">
          <label class="form-label fw-semibold small text-secondary">Deskripsi</label>
          <textarea class="form-control bg-light" id="detailDesk" rows="3" readonly></textarea>
        </div>
        <div class="col-12">
          <label class="form-label fw-semibold small text-secondary">Tanggal Dibuat</label>
          <input type="text" class="form-control bg-light" id="detailTanggal" readonly />
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
    <span id="toastMessage">Kategori berhasil disimpan</span>
  </div>

  <!-- Bootstrap Bundle with Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Categories persistence script -->
  <script>
    function saveCategories(items) {
      localStorage.setItem('koko_kategori', JSON.stringify(items));
      try { window.dispatchEvent(new Event('storage')); } catch(e){}
    }
    function loadCategories() {
      try { return JSON.parse(localStorage.getItem('koko_kategori') || '[]'); } catch { return []; }
    }

    let items = loadCategories();
    if (!items || items.length === 0) {
      items = [
        { id: 1, nama: 'Dry Food',  deskripsi: 'Berbagai jenis dry food kucing dan anjing.',  tanggal: '12 Okt 2023' },
        { id: 2, nama: 'Wet Food',  deskripsi: 'Berbagai jenis wet food kucing dan anjing',   tanggal: '15 Okt 2023' },
        { id: 3, nama: 'Treats',    deskripsi: 'Berbagai jenis khusus treats kucing',         tanggal: '18 Okt 2023' },
        { id: 4, nama: 'Susu',      deskripsi: 'Berbagai jenis khusus susu kucing',            tanggal: '20 Okt 2023' }
      ];
      saveCategories(items);
    }

    let nextId      = (items.length ? Math.max(...items.map(i=>i.id)) + 1 : 1);
    let editId      = null;
    let deleteId    = null;

    function showToast(msg) {
      const t = document.getElementById('toast');
      document.getElementById('toastMessage').textContent = msg;
      if (t) {
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2500);
      }
    }

    function formatDate(d) {
      const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
      const now = new Date(d || Date.now());
      return `${String(now.getDate()).padStart(2,'0')} ${months[now.getMonth()]} ${now.getFullYear()}`;
    }

    function render() {
      document.getElementById('tableBody').innerHTML = items.map((row, i) => `
        <tr>
          <td>${i + 1}</td>
          <td class="fw-bold text-dark">${row.nama}</td>
          <td>${row.deskripsi || '-'}</td>
          <td>${row.tanggal}</td>
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

    function openDetailModal(id) {
      const row = items.find(r => r.id === id);
      if (!row) return;
      document.getElementById('detailNama').value = row.nama;
      document.getElementById('detailDesk').value = row.deskripsi;
      document.getElementById('detailTanggal').value = row.tanggal;
      openModal('detailModal');
    }

    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    function openAddModal() {
      editId = null;
      document.getElementById('modalTitle').textContent = 'Tambah Kategori';
      document.getElementById('modalSub').textContent   = 'Isi data kategori baru.';
      document.getElementById('inputNama').value = '';
      document.getElementById('inputDesk').value = '';
      openModal('formModal');
    }

    function openEditModal(id) {
      const row = items.find(r => r.id === id);
      if (!row) return;
      editId = id;
      document.getElementById('modalTitle').textContent = 'Edit Kategori';
      document.getElementById('modalSub').textContent   = 'Ubah data kategori.';
      document.getElementById('inputNama').value = row.nama;
      document.getElementById('inputDesk').value = row.deskripsi;
      openModal('formModal');
    }

    function saveKategori() {
      const nama = document.getElementById('inputNama').value.trim();
      const desk = document.getElementById('inputDesk').value.trim();
      if (!nama) { alert('Nama kategori tidak boleh kosong.'); return; }

      if (editId !== null) {
        const row = items.find(r => r.id === editId);
        if (row) {
          const oldNama = row.nama;
          row.nama = nama;
          row.deskripsi = desk;

          if (oldNama !== nama) {
            try {
              let barangData = JSON.parse(localStorage.getItem('koko_barang') || '[]');
              let changed = false;
              barangData.forEach(b => {
                if (b.kategori === oldNama) {
                  b.kategori = nama;
                  changed = true;
                }
              });
              if (changed) {
                localStorage.setItem('koko_barang', JSON.stringify(barangData));
              }
            } catch (e) {
              console.error('Failed to sync kategori changes to barang:', e);
            }
          }
        }
        showToast('Perubahan disimpan');
      } else {
        items.push({ id: nextId++, nama, deskripsi: desk, tanggal: formatDate() });
        showToast('Kategori ditambahkan');
      }
      saveCategories(items);
      closeModal('formModal');
      render();
    }

    function openDeleteModal(id) {
      deleteId = id;
      const row = items.find(r => r.id === id);
      document.getElementById('deleteText').textContent =
        `Apakah Anda yakin ingin menghapus kategori "${row?.nama}"? Tindakan ini tidak dapat dibatalkan.`;
      openModal('deleteModal');
    }

    function confirmDelete() {
      const row = items.find(r => r.id === deleteId);
      const namaKategori = row ? row.nama : '';
      items = items.filter(r => r.id !== deleteId);
      deleteId = null;
      saveCategories(items);
      closeModal('deleteModal');
      render();
      if (namaKategori) {
        showToast(`Kategori "${namaKategori}" berhasil dihapus.`);
      } else {
        showToast('Kategori berhasil dihapus.');
      }
    }

    // close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
      overlay.addEventListener('click', e => {
        if (overlay === e.target) overlay.classList.remove('open');
      });
    });

    // sync across pages
    window.addEventListener('storage', e => {
      if (e.key === 'koko_kategori' || e.key === null) { items = loadCategories(); render(); }
    });

    render();
  </script>
</body>
</html>
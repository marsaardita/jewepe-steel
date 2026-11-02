<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PT JeWePe Steel · Laporan Persediaan</title>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tabler Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <!-- html2pdf JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

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
    }
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

    /* Print styling */
    @media print {
      .sidebar, .topbar-custom, .filter-section, .btn, .topbar-profile, .toast-custom {
        display: none !important;
      }
      .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
        width: 100% !important;
      }
      .card-data {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
      }
      .table {
        width: 100% !important;
        border-collapse: collapse !important;
      }
      .table th, .table td {
        border: 1px solid #000 !important;
        padding: 8px !important;
        color: #000 !important;
      }
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
      <a href="{{ url('/master/kategori') }}" class="nav-link-custom">
        <i class="ti ti-database"></i>
        <span>Master Data</span>
      </a>
      <a href="{{ url('/laporan') }}" class="nav-link-custom active">
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
        <h1 class="h3 fw-bold text-dark m-0">Laporan Persediaan</h1>
        <p class="text-secondary small m-0">Lihat laporan transaksi barang masuk dan barang keluar berdasarkan rentang tanggal.</p>
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
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="card-stat">
          <p class="stat-label">Total Transaksi</p>
          <p class="stat-value" id="statTransaksi">0</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-stat">
          <p class="stat-label">Total Barang Masuk</p>
          <p class="stat-value text-success" id="statMasuk">0</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-stat">
          <p class="stat-label">Total Barang Keluar</p>
          <p class="stat-value text-danger" id="statKeluar">0</p>
        </div>
      </div>
    </div>

    <!-- MAIN DATA CARD -->
    <div class="card-data shadow-sm">
      
      <!-- FILTER BAR -->
      <div class="row g-3 align-items-end mb-4 filter-section">
        <div class="col-md-6 col-lg-4">
          <label class="form-label fw-semibold small text-secondary">Rentang Waktu</label>
          <div class="input-group">
            <input type="date" class="form-control" id="dateFrom" />
            <span class="input-group-text bg-light text-muted">s/d</span>
            <input type="date" class="form-control" id="dateTo" />
          </div>
        </div>
        
        <div class="col-md-6 col-lg-8 d-flex flex-wrap gap-2 justify-content-md-start justify-content-lg-end">
          <button class="btn btn-dark fw-semibold px-4" onclick="applyFilter()">
            <i class="ti ti-filter"></i> Filter
          </button>
          <button class="btn btn-outline-secondary fw-semibold px-4" onclick="resetFilter()">
            <i class="ti ti-rotate"></i> Reset
          </button>
          <button class="btn btn-warning fw-semibold px-4 text-dark" onclick="downloadExcel()">
            <i class="ti ti-file-spreadsheet"></i> Unduh Excel
          </button>
          <button class="btn btn-danger fw-semibold px-4" onclick="downloadPDF()">
            <i class="ti ti-file-type-pdf"></i> Unduh PDF
          </button>
          <button class="btn btn-success fw-semibold px-4" onclick="window.print()">
            <i class="ti ti-printer"></i> Cetak Laporan
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
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>

      <!-- EMPTY STATE -->
      <div id="emptyState" class="tbl-empty-state">
        <i class="ti ti-file-analytics fs-1 text-muted d-block mb-2"></i>
        <span>Belum ada data laporan. Gunakan filter rentang tanggal di atas untuk menampilkan.</span>
      </div>

    </div>
  </div>

  <!-- TOAST -->
  <div class="toast-custom shadow-sm" id="toast">
    <i class="ti ti-info-circle-filled text-warning"></i>
    <span id="toastMessage">Laporan berhasil difilter</span>
  </div>

  <!-- Bootstrap Bundle with Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Laporan scripts -->
  <script>
    const STORAGE_KEY = 'koko_barang';
    const MUTASI_KEY = 'koko_mutasi';
    let data = loadBarangData();
    let mutasi = loadMutasi();
    let mutasiFiltered = [...mutasi];
    let reportSource = null; // 'mutasi' or 'barang'
    let reportRows = [];
    let filtered = [...data];

    /* ── helpers ── */
    function loadBarangData() {
      try {
        const items = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
        return items.map(item => {
          const tanggal = item.tanggal || '';
          let ts = null;
          if (item.ts !== undefined && item.ts !== null) {
            ts = typeof item.ts === 'number' ? item.ts : Number(item.ts);
            if (isNaN(ts)) ts = new Date(item.ts).getTime();
          }
          if (!ts && tanggal) ts = new Date(tanggal).getTime();
          if (isNaN(ts)) ts = 0;
          return {
            ...item,
            ts,
            tanggal
          };
        });
      } catch (error) {
        console.error('Could not load laporan data', error);
        return [];
      }
    }

    function parseTimestamp(value) {
      if (value === undefined || value === null || value === '') return 0;
      if (typeof value === 'number') return value;
      const numeric = Number(value);
      if (!Number.isNaN(numeric)) return numeric;
      const parsed = Date.parse(value);
      return Number.isNaN(parsed) ? 0 : parsed;
    }

    function loadMutasi() {
      try {
        const items = JSON.parse(localStorage.getItem(MUTASI_KEY) || '[]');
        return items.map(r => {
          let ts = parseTimestamp(r.ts || r.tanggal || r.waktuLabel);
          if (!ts && r.tanggal) ts = parseTimestamp(r.tanggal);
          if (!ts && r.waktuLabel) ts = parseTimestamp(r.waktuLabel);
          return {
            ...r,
            ts,
            waktuLabel: r.waktuLabel || (ts ? formatDate(new Date(ts)) : '')
          };
        });
      } catch (e) {
        return [];
      }
    }

    function formatDate(dateStr) {
      if (!dateStr) return '-';
      const d = new Date(dateStr);
      if (isNaN(d)) return dateStr;
      const day = String(d.getDate()).padStart(2, '0');
      const month = String(d.getMonth() + 1).padStart(2, '0');
      const year = d.getFullYear();
      return `${day}-${month}-${year}`;
    }

    function showToast(msg) {
      const t = document.getElementById('toast');
      document.getElementById('toastMessage').textContent = msg;
      t.classList.add('show');
      setTimeout(() => t.classList.remove('show'), 2500);
    }

    function updateStatsForMutasi(sourceMut) {
      const totalTrans = sourceMut.length;
      const totalMasuk = sourceMut.filter(r => r.tipe === 'Masuk').reduce((s, r) => s + Math.abs(Number(r.jumlah) || 0), 0);
      const totalKeluar = sourceMut.filter(r => r.tipe !== 'Masuk').reduce((s, r) => s + Math.abs(Number(r.jumlah) || 0), 0);
      document.getElementById('statTransaksi').textContent = totalTrans;
      document.getElementById('statMasuk').textContent = totalMasuk;
      document.getElementById('statKeluar').textContent = totalKeluar;
    }

    function updateStatsForBarang(sourceBarang) {
      const totalTrans = sourceBarang.length;
      const totalMasuk = sourceBarang.reduce((s, r) => s + Math.abs(Number(r.masuk) || 0), 0);
      const totalKeluar = sourceBarang.reduce((s, r) => s + Math.abs(Number(r.keluar) || 0), 0);
      document.getElementById('statTransaksi').textContent = totalTrans;
      document.getElementById('statMasuk').textContent = totalMasuk;
      document.getElementById('statKeluar').textContent = totalKeluar;
    }

    /* ── render ── */
    function render() {
      const tbody = document.getElementById('tableBody');
      const empty = document.getElementById('emptyState');
      const thead = document.querySelector('.table-responsive table thead');

      if (reportSource) {
        const total = reportRows.length;

        thead.innerHTML = `
          <tr>
            <th style="width: 60px;">No</th>
            <th>Tanggal</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Stok</th>
          </tr>`;

        if (total === 0) {
          tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted py-4">Tidak ada transaksi dalam rentang tanggal ini.</td></tr>';
          empty.style.display = 'none';
          return;
        }

        tbody.innerHTML = reportRows.map((row, index) => {
          if (reportSource === 'mutasi') {
            const master = data.find(b => b.kode === row.kode) || {};
            const tanggal = row.waktuLabel || (row.ts ? formatDate(new Date(row.ts)) : '');
            const masuk = row.tipe === 'Masuk' ? Math.abs(Number(row.jumlah) || 0) : 0;
            const keluar = row.tipe === 'Masuk' ? 0 : Math.abs(Number(row.jumlah) || 0);
            const stok = row.sisa !== undefined ? row.sisa : (master.stok !== undefined ? master.stok : 0);
            return `
              <tr>
                <td>${index + 1}</td>
                <td>${tanggal}</td>
                <td class="fw-semibold">${row.kode || master.kode || '-'}</td>
                <td class="fw-bold text-dark">${row.barang || master.nama || '-'}</td>
                <td>${master.kategori || '-'}</td>
                <td class="text-success fw-bold">${masuk}</td>
                <td class="text-danger fw-bold">${keluar}</td>
                <td class="fw-bold">${stok}</td>
              </tr>`;
          }

          return `
            <tr>
              <td>${index + 1}</td>
              <td>${formatDate(row.tanggal)}</td>
              <td class="fw-semibold">${row.kode || '-'}</td>
              <td class="fw-bold text-dark">${row.nama || '-'}</td>
              <td>${row.kategori || '-'}</td>
              <td class="text-success fw-bold">${Number(row.masuk) || 0}</td>
              <td class="text-danger fw-bold">${Number(row.keluar) || 0}</td>
              <td class="fw-bold">${Number(row.stok) || 0}</td>
            </tr>`;
        }).join('');

        empty.style.display = 'none';
        return;
      }

      // render default master barang
      const total = filtered.length;

      if (total === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
      }

      thead.innerHTML = `
        <tr>
          <th style="width: 60px;">No</th>
          <th>Tanggal</th>
          <th>Kode</th>
          <th>Nama Barang</th>
          <th>Kategori</th>
          <th>Stok Saat Ini</th>
        </tr>`;

      empty.style.display = 'none';
      tbody.innerHTML = filtered.map((row, index) => `
        <tr>
          <td>${index + 1}</td>
          <td>${formatDate(row.tanggal)}</td>
          <td class="fw-semibold">${row.kode || '-'}</td>
          <td class="fw-bold text-dark">${row.nama || '-'}</td>
          <td>${row.kategori || '-'}</td>
          <td class="fw-bold">${Number(row.stok) || 0}</td>
        </tr>
      `).join('');
    }

    function applyFilter() {
      const from = document.getElementById('dateFrom').value;
      const to = document.getElementById('dateTo').value;
      const fromTs = from ? new Date(from).getTime() : null;
      const toTs = to ? new Date(to + 'T23:59:59').getTime() : null;

      mutasiFiltered = mutasi.filter(r => {
        const rts = r.ts || 0;
        if (fromTs && rts < fromTs) return false;
        if (toTs && rts > toTs) return false;
        return true;
      });

      const barangFiltered = data.filter(b => {
        const bts = b.ts || 0;
        if (fromTs && bts < fromTs) return false;
        if (toTs && bts > toTs) return false;
        return true;
      });

      reportRows = [];

      if (mutasiFiltered.length > 0) {
        reportSource = 'mutasi';
        reportRows = mutasiFiltered;
        updateStatsForMutasi(reportRows);
        showToast(`Ditemukan ${reportRows.length} transaksi.`);
      } else if (barangFiltered.length > 0) {
        reportSource = 'barang';
        reportRows = barangFiltered;
        updateStatsForBarang(reportRows);
        showToast(`Ditemukan ${reportRows.length} data barang.`);
      } else {
        reportSource = 'mutasi';
        reportRows = [];
        updateStatsForMutasi(reportRows);
        showToast(`Tidak ada transaksi dalam rentang tanggal tersebut.`);
      }
      render();
    }

    function resetFilter() {
      document.getElementById('dateFrom').value = '';
      document.getElementById('dateTo').value = '';
      mutasiFiltered = [...mutasi];
      reportSource = null;
      reportRows = [];
      updateStatsForMutasi(mutasiFiltered);
      render();
    }

    window.addEventListener('storage', event => {
      if (!event.key || event.key === STORAGE_KEY) {
        data = loadBarangData();
        filtered = [...data];
        render();
      }
      if (!event.key || event.key === MUTASI_KEY) {
        mutasi = loadMutasi();
        mutasiFiltered = [...mutasi];
        updateStatsForMutasi(mutasiFiltered);
      }
    });

    function downloadExcel() {
      const tbody = document.getElementById('tableBody');
      const rows = Array.from(tbody.querySelectorAll('tr'));
      if (rows.length === 0 || (rows[0] && rows[0].cells.length === 1 && rows[0].cells[0].colSpan > 1)) {
        alert('Tidak ada data untuk diunduh.');
        return;
      }

      const thead = document.querySelector('.table-responsive table thead');
      const headers = Array.from(thead.querySelectorAll('th')).map(th => th.innerText.trim());

      let csv = [];
      csv.push(headers.map(h => `"${h.replace(/"/g, '""')}"`).join(','));

      rows.forEach(row => {
        const cols = Array.from(row.querySelectorAll('td')).map(td => {
          let val = td.innerText.trim();
          return `"${val.replace(/"/g, '""')}"`;
        });
        csv.push(cols.join(','));
      });

      const csvContent = "data:text/csv;charset=utf-8,\uFEFF" + csv.join("\n");
      const encodedUri = encodeURI(csvContent);
      const link = document.createElement("a");
      link.setAttribute("href", encodedUri);
      link.setAttribute("download", `Laporan_Persediaan_JeWePe_Steel_${Date.now()}.csv`);
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      showToast("Laporan berhasil diunduh sebagai Excel (CSV).");
    }

    function downloadPDF() {
      const tbody = document.getElementById('tableBody');
      const rows = Array.from(tbody.querySelectorAll('tr'));
      if (rows.length === 0 || (rows[0] && rows[0].cells.length === 1 && rows[0].cells[0].colSpan > 1)) {
        alert('Tidak ada data untuk diunduh.');
        return;
      }

      if (typeof html2pdf !== 'undefined') {
        const element = document.querySelector(".card-data");
        const filters = document.querySelector(".filter-section");
        if (filters) filters.style.display = 'none';

        const opt = {
          margin:       0.5,
          filename:     `Laporan_Persediaan_JeWePe_Steel_${Date.now()}.pdf`,
          image:        { type: 'jpeg', quality: 0.98 },
          html2canvas:  { scale: 2 },
          jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).save().then(() => {
          if (filters) filters.style.display = 'flex';
          showToast("Laporan berhasil diunduh sebagai PDF.");
        }).catch(err => {
          console.error(err);
          if (filters) filters.style.display = 'flex';
          window.print();
        });
      } else {
        window.print();
      }
    }

    render();
  </script>
</body>
</html>
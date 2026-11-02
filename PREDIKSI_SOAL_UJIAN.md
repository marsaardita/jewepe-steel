# MATERI TAMBAHAN & PREDIKSI SOAL UJIAN (LARAVEL)

Berikut adalah panduan langkah demi langkah beserta kode lengkap untuk materi tambahan yang berpotensi besar diujikan pada ujian BNSP besok:

---

## TUGAS 1: VALIDASI INPUT FORM & PENANGANAN ERROR

Asesor akan menilai keamanan inputan Anda (Error Handling). Jangan biarkan input kosong lolos ke database yang menyebabkan crash.

### A. Kode Lengkap Validasi di Controller (`BarangController.php`)
* **Tindakan**: Modifikasi method `store` di Controller untuk menyaring data sebelum disimpan. Jika validasi gagal, Laravel otomatis mengembalikan user ke halaman form dengan pesan error.
* **Contoh Isi Controller Lengkap dengan Validasi**:
  ```php
  <?php

  namespace App\Http\Controllers;

  use App\Barang;
  use App\Category;
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
          // Proses Validasi (Error Handling)
          $request->validate([
              'kode' => 'required|unique:barangs,kode',
              'nama' => 'required|min:3',
              'kategori' => 'required',
              'masuk' => 'required|numeric|min:0',
              'keluar' => 'required|numeric|min:0',
          ]);

          $stok = $request->masuk - $request->keluar;
          Barang::create(array_merge($request->all(), ['stok' => $stok]));
          return redirect('/master/barang')->with('success', 'Barang berhasil ditambahkan');
      }

      public function update(Request $request, $id)
      {
          // Proses Validasi Edit
          $request->validate([
              'kode' => 'required|unique:barangs,kode,' . $id,
              'nama' => 'required|min:3',
              'kategori' => 'required',
              'masuk' => 'required|numeric|min:0',
              'keluar' => 'required|numeric|min:0',
          ]);

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

### B. Menampilkan Pesan Error di Form HTML (`index.blade.php`)
* **Tindakan**: Buka file Blade View, lalu tambahkan pengecekan error `@error('field_name')` di bawah kolom input untuk memunculkan pesan error berwarna merah.
* **Contoh Potongan Form dengan Notifikasi Error**:
  ```html
  <div class="form-field">
      <label>Kode Barang</label>
      <input type="text" name="kode" value="{{ old('kode') }}" />
      
      <!-- Menampilkan Error jika Kode Kosong atau Duplikat -->
      @error('kode')
          <span style="color: red; font-size: 11px;">{{ $message }}</span>
      @enderror
  </div>
  ```

---

## TUGAS 2: CETAK LAPORAN (PRINT REPORT)

Asesor biasanya meminta laporan bisa dicetak langsung. Cara terbaik dan tercepat adalah menggunakan fitur Print Window dari browser.

### A. Tambahkan Tombol Cetak di Blade View (`laporan/index.blade.php`)
* **Tindakan**: Letakkan tombol cetak ini di samping tombol filter laporan pada file `laporan/index.blade.php`.
* **Kode Tombol**:
  ```html
  <button onclick="window.print()" class="btn-tambah" style="background: #059669;">
      <i class="ti ti-printer"></i> Cetak Laporan
  </button>
  ```

### B. Sembunyikan Sidebar & Topbar saat Dicetak (CSS @media print)
* **Tindakan**: Ketika dicetak ke kertas/PDF, kita hanya ingin tabel laporannya saja yang muncul. Sidebar, Topbar, dan Tombol Filter harus disembunyikan.
* **Kode CSS yang Ditambahkan** (letakkan di dalam tag `<style>` pada file `laporan/index.blade.php`):
  ```css
  @media print {
      /* Sembunyikan elemen navigasi dan tombol */
      .topbar, .sidebar, .filter-bar, .btn-tambah, header, aside {
          display: none !important;
      }
      
      /* Lebarkan konten utama agar penuh satu lembar kertas */
      .main {
          margin-left: 0 !important;
          padding: 0 !important;
          width: 100% !important;
      }
      
      /* Rapikan garis tabel saat dicetak */
      table {
          border: 1px solid #000 !important;
      }
      th, td {
          border: 1px solid #000 !important;
      }
  }
  ```

---

## TUGAS 3: FORMAT PENGUJIAN UNIT (UNIT TESTING TEST CASE)

Di lembar kertas jawaban atau laporan akhir ujian, Anda sering kali diminta membuat tabel pengujian unit program. 

### Contoh Format Tabel Pengujian (Tinggal Salin untuk Kertas Jawaban Ujian):

| No | Modul / Fitur | Skenario Uji | Hasil yang Diharapkan | Hasil Aktual | Kesimpulan |
| :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | Autentikasi | Melakukan login dengan email dan password kosong | Sistem menolak dan form meminta data wajib diisi | Sesuai | KOMPETEN |
| 2 | Autentikasi | Login menggunakan data salah (email/password keliru) | Sistem menampilkan pesan error "Username atau password salah" | Sesuai | KOMPETEN |
| 3 | Autentikasi | Login menggunakan data yang benar dari database | Sistem membuat session login dan mengarahkan ke dashboard | Sesuai | KOMPETEN |
| 4 | CRUD Kategori | Menambahkan kategori baru tanpa mengisi nama | Validasi sistem memblokir penyimpanan dan memunculkan error | Sesuai | KOMPETEN |
| 5 | CRUD Barang | Menambahkan data barang baru ke database | Data tersimpan di tabel `barangs` dan stok terhitung otomatis | Sesuai | KOMPETEN |
| 6 | Laporan | Memfilter laporan transaksi dengan memilih rentang tanggal | Tabel hanya merender data barang yang sesuai rentang tanggal | Sesuai | KOMPETEN |
| 7 | Laporan | Menekan tombol "Cetak Laporan" | Browser memunculkan jendela dialog print layout cetak kertas | Sesuai | KOMPETEN |

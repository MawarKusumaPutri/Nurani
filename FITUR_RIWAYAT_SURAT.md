# Fitur Riwayat Surat - Dokumentasi

## Perubahan yang Dilakukan

### 1. Model Surat (`app/Models/Surat.php`)
- ✅ Menambahkan field `sumber_surat` ke dalam `$fillable` array
- Field ini digunakan untuk membedakan surat dari Yayasan atau Sekolah

### 2. Sidebar TU (`resources/views/partials/tu-sidebar.blade.php`)
- ✅ Sudah ada submenu dropdown untuk Surat dengan 2 pilihan:
  - **Surat dari Yayasan** (dengan icon building)
  - **Surat dari Sekolah** (dengan icon school)

### 3. View Index Surat (`resources/views/tu/surat/index.blade.php`)
- ✅ Mengubah judul halaman dari "Surat Menyurat" menjadi "Riwayat Surat"
- ✅ Menambahkan badge indicator di header untuk menunjukkan filter aktif (Yayasan/Sekolah)
- ✅ Menambahkan kolom "Sumber" di tabel untuk menampilkan badge sumber surat
- ✅ Menambahkan filter dropdown "Sumber Surat" di bagian filter
- ✅ Menambahkan hidden input untuk mempertahankan parameter `jenis` saat filter

### 4. Controller (`app/Http/Controllers/TuController.php`)
- ✅ Method `suratIndex`: Sudah ada filter berdasarkan parameter `jenis` dari submenu
- ✅ Method `suratIndex`: Menambahkan filter tambahan berdasarkan dropdown `sumber_surat`
- ✅ Method `suratSend`: Sudah menyimpan field `sumber_surat` saat membuat surat baru

### 5. Form Create Surat (`resources/views/tu/surat/create.blade.php`)
- ✅ Sudah ada field dropdown "Sumber Surat" dengan pilihan:
  - Surat dari Sekolah (Internal)
  - Surat dari Yayasan (Eksternal)
- ✅ Field ini sudah terintegrasi dengan JavaScript untuk toggle field lainnya

## Cara Menggunakan

### Dari Sidebar:
1. Klik menu "Surat" di sidebar TU
2. Pilih submenu:
   - **Surat dari Yayasan** - untuk melihat surat dari pihak eksternal/yayasan
   - **Surat dari Sekolah** - untuk melihat surat internal sekolah

### Filter di Halaman Riwayat Surat:
1. Gunakan dropdown "Sumber Surat" untuk filter:
   - Semua Sumber
   - Yayasan
   - Sekolah
2. Kombinasikan dengan filter lain (Tipe Surat, Jenis Surat, Status, Pencarian)
3. Klik tombol "Filter" untuk menerapkan

### Membuat Surat Baru:
1. Klik tombol "Buat Surat"
2. Pilih "Sumber Surat":
   - **Sekolah**: Untuk surat yang dibuat/dikirim oleh sekolah
   - **Yayasan**: Untuk surat yang diterima dari pihak luar/yayasan
3. Isi form lainnya dan simpan

## Badge Warna:
- 🟢 **Hijau (bg-success)**: Surat dari Sekolah
- 🟡 **Kuning (bg-warning)**: Surat dari Yayasan

## Sinkronisasi:
Semua fitur sudah saling sinkron:
- Sidebar submenu → Filter otomatis di halaman index
- Dropdown filter → Bisa dikombinasikan dengan submenu
- Form create → Menyimpan sumber_surat ke database
- Tabel → Menampilkan badge sumber surat

## Database:
Field `sumber_surat` sudah ada di tabel `surats` dengan:
- Type: ENUM('yayasan', 'sekolah')
- Default: 'sekolah'
- Index: Ya (untuk performa query)

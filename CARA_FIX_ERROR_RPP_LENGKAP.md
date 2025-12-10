# Cara Memperbaiki Error Tabel RPP - Panduan Lengkap

## ❌ Error yang Terjadi
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'nurani.rpp' doesn't exist
```

## ✅ Solusi (Pilih Salah Satu)

### 🚀 SOLUSI 1: Double-Click File Batch (PALING MUDAH)

1. **Double-click file:** `JALANKAN_INI_UNTUK_FIX_RPP.bat`
2. Script akan mencoba 3 metode secara otomatis
3. Tunggu sampai muncul pesan "SUKSES!"
4. Refresh halaman RPP di browser (Ctrl+F5)

---

### 🔧 SOLUSI 2: Via phpMyAdmin (Manual - Paling Aman)

1. Buka **phpMyAdmin**: http://localhost/phpmyadmin
2. Pilih database **`nurani`** di sidebar kiri
3. Klik tab **"SQL"** di bagian atas
4. Buka file **`CREATE_RPP_TABLE.sql`** di folder project
5. **Copy-paste** semua isinya ke textarea SQL di phpMyAdmin
6. Klik tombol **"Go"** atau **"Jalankan"**
7. Pastikan muncul pesan sukses
8. Refresh halaman RPP di browser

---

### 💻 SOLUSI 3: Via Command Line

Buka Command Prompt atau PowerShell di folder project, lalu jalankan:

```bash
cd "d:\Praktikum DWBI\xampp\htdocs\nurani"
php fix_rpp_simple.php
```

Atau:

```bash
php artisan migrate --path=database/migrations/2025_12_10_000000_create_rpp_table.php --force
```

---

### 📝 SOLUSI 4: Copy-Paste SQL Langsung

1. Buka **phpMyAdmin**: http://localhost/phpmyadmin
2. Pilih database **`nurani`**
3. Klik tab **"SQL"**
4. Copy-paste SQL berikut:

```sql
USE nurani;

CREATE TABLE IF NOT EXISTS `rpp` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `mata_pelajaran` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `pertemuan_ke` int(11) NOT NULL,
  `alokasi_waktu` int(11) NOT NULL,
  `sekolah` varchar(255) DEFAULT NULL,
  `mata_pelajaran_detail` varchar(255) DEFAULT NULL,
  `kelas_detail` varchar(255) DEFAULT NULL,
  `semester_detail` varchar(255) DEFAULT NULL,
  `tahun_pelajaran` varchar(255) DEFAULT NULL,
  `ki_1` text DEFAULT NULL,
  `ki_2` text DEFAULT NULL,
  `ki_3` text DEFAULT NULL,
  `ki_4` text DEFAULT NULL,
  `kd_pengetahuan` text DEFAULT NULL,
  `kd_keterampilan` text DEFAULT NULL,
  `indikator_pencapaian_kompetensi` text DEFAULT NULL,
  `tujuan_pembelajaran` text DEFAULT NULL,
  `materi_pembelajaran` text DEFAULT NULL,
  `materi_pembelajaran_reguler` text DEFAULT NULL,
  `materi_pembelajaran_pengayaan` text DEFAULT NULL,
  `materi_pembelajaran_remedial` text DEFAULT NULL,
  `metode_pembelajaran` text DEFAULT NULL,
  `kegiatan_pendahuluan` text DEFAULT NULL,
  `kegiatan_inti` text DEFAULT NULL,
  `kegiatan_penutup` text DEFAULT NULL,
  `media_pembelajaran` text DEFAULT NULL,
  `sumber_belajar` text DEFAULT NULL,
  `teknik_penilaian` text DEFAULT NULL,
  `bentuk_instrumen` text DEFAULT NULL,
  `rubrik_penilaian` text DEFAULT NULL,
  `kriteria_ketuntasan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rpp_guru_id_index` (`guru_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

5. Klik **"Go"**
6. Refresh halaman RPP

---

## ✅ Verifikasi

Setelah menjalankan salah satu solusi, verifikasi dengan:

1. Buka **phpMyAdmin**: http://localhost/phpmyadmin
2. Pilih database **`nurani`**
3. Lihat daftar tabel di sidebar kiri
4. Pastikan tabel **`rpp`** ada di daftar
5. Jika ada, refresh halaman RPP di aplikasi (Ctrl+F5)

---

## 📁 File-file yang Tersedia

| File | Keterangan |
|------|------------|
| `JALANKAN_INI_UNTUK_FIX_RPP.bat` | ⭐ **PALING MUDAH** - Double-click untuk fix otomatis |
| `fix_rpp_simple.php` | Script PHP sederhana untuk membuat tabel |
| `fix_rpp_direct.php` | Script PHP dengan error handling lengkap |
| `CREATE_RPP_TABLE.sql` | SQL script untuk phpMyAdmin |
| `create_rpp_table.php` | Script PHP alternatif |
| `FIX_RPP_ERROR.bat` | Batch file alternatif |
| `SOLUSI_RPP_ERROR.bat` | Batch file dengan metode simple |

---

## 🔍 Troubleshooting

### Jika semua solusi gagal:

1. **Cek MySQL/MariaDB sudah running:**
   - Buka XAMPP Control Panel
   - Pastikan MySQL status "Running" (hijau)

2. **Cek koneksi database:**
   - Buka file `.env`
   - Pastikan:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=nurani
     DB_USERNAME=root
     DB_PASSWORD=
     ```

3. **Cek tabel `gurus` sudah ada:**
   - Buka phpMyAdmin
   - Pastikan tabel `gurus` ada di database `nurani`

4. **Cek permission database:**
   - Pastikan user database memiliki permission CREATE TABLE

---

## 📞 Jika Masih Error

Jika semua solusi di atas masih tidak berhasil, kemungkinan ada masalah dengan:
- Koneksi database
- Permission database user
- Konfigurasi Laravel

Silakan screenshot error yang muncul dan kirimkan untuk troubleshooting lebih lanjut.

---

**PENTING:** Setelah tabel berhasil dibuat, **refresh halaman RPP di browser** dengan menekan **Ctrl+F5** (hard refresh) untuk memastikan cache browser ter-clear.

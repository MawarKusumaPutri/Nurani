# 🚀 CARA FIX ERROR TABEL RPP - VIA PHPMYADMIN

## ❌ Error yang Terjadi
```
Table 'nurani.rpp' doesn't exist
```

## ✅ SOLUSI: Buat Tabel via phpMyAdmin

### Langkah-langkah:

1. **Buka phpMyAdmin**
   - URL: http://localhost/phpmyadmin
   - Atau: http://127.0.0.1/phpmyadmin

2. **Pilih Database**
   - Di sidebar kiri, klik database **`nurani`**

3. **Buka Tab SQL**
   - Klik tab **"SQL"** di bagian atas halaman

4. **Copy-Paste SQL Script**
   - Buka file **`SQL_RPP_LANGSUNG.txt`** di folder project
   - **Copy SEMUA isinya** (dari `USE nurani;` sampai akhir)
   - **Paste** ke textarea SQL di phpMyAdmin

5. **Jalankan SQL**
   - Klik tombol **"Go"** atau **"Jalankan"** di bagian bawah

6. **Verifikasi**
   - Pastikan muncul pesan: **"Table 'rpp' created successfully"**
   - Atau: **"Query OK, 0 rows affected"**

7. **Refresh Browser**
   - Kembali ke aplikasi
   - Refresh halaman RPP (Ctrl+F5)
   - Atau tutup dan buka kembali browser

---

## 📋 SQL Script (Copy-Paste Langsung)

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

---

## ✅ Verifikasi Setelah Membuat Tabel

1. Di phpMyAdmin, pastikan tabel **`rpp`** muncul di daftar tabel database `nurani`
2. Klik tabel **`rpp`** untuk melihat strukturnya
3. Pastikan semua kolom sudah ada

---

## 🔄 Setelah Tabel Dibuat

1. **Refresh halaman RPP di browser** (Ctrl+F5)
2. Atau **tutup dan buka kembali browser**
3. Coba akses fitur RPP lagi

---

## ⚠️ Troubleshooting

### Jika masih error setelah membuat tabel:

1. **Cek MySQL sudah running:**
   - Buka XAMPP Control Panel
   - Pastikan MySQL status "Running" (hijau)

2. **Clear cache Laravel:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

3. **Cek koneksi database:**
   - Pastikan file `.env` memiliki konfigurasi database yang benar

---

**PENTING:** Setelah tabel dibuat, **WAJIB refresh browser** dengan **Ctrl+F5** (hard refresh) untuk menghapus cache browser.

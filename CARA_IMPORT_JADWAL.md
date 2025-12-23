# Cara Import Data Jadwal Lengkap

Saya telah membuat **3 cara** untuk mengimport data jadwal dari gambar yang Anda berikan:

## ✅ Cara 1: Import via Web Interface (RECOMMENDED)

Ini adalah cara termudah dan paling user-friendly:

### Langkah-langkah:

1. **Jalankan server Laravel**
   ```bash
   php artisan serve
   ```

2. **Login sebagai TU** di browser
   - Buka: http://localhost:8000/login
   - Login dengan akun TU

3. **Buka halaman Jadwal Pelajaran**
   - Klik menu "Jadwal" di sidebar

4. **Klik tombol "Import Excel"** (tombol hijau)

5. **Download template Excel**
   - Di modal yang muncul, klik "Download Template Excel"

6. **Upload file CSV yang sudah saya buat**
   - File: `jadwal_lengkap_import.csv` (sudah ada di folder project)
   - Atau buat file Excel baru dengan format template
   - Pilih Semester: 1
   - Tahun Ajaran: 2025/2026
   - Klik "Import Jadwal"

7. **Selesai!** Jadwal akan otomatis muncul di tabel

---

## ✅ Cara 2: Import via Artisan Command

Jika web interface bermasalah, gunakan command line:

### Langkah-langkah:

1. **Pastikan MySQL/XAMPP sedang berjalan**

2. **Jalankan command**
   ```bash
   php artisan jadwal:import-lengkap
   ```

3. **Tunggu proses selesai**
   - Command akan menampilkan progress import
   - Akan muncul jumlah jadwal yang berhasil diimport

---

## ✅ Cara 3: Import via Database Seeder

Cara ini paling cepat untuk testing:

### Langkah-langkah:

1. **Jalankan seeder**
   ```bash
   php artisan db:seed --class=JadwalLengkapSeeder
   ```

2. **Selesai!**
   - Data jadwal (sample) akan langsung masuk ke database

---

## 📋 File yang Sudah Dibuat

1. **jadwal_lengkap_import.csv** - File CSV berisi SEMUA data jadwal dari gambar
2. **import_jadwal_lengkap.php** - Script PHP standalone untuk import
3. **ImportJadwalLengkap.php** - Artisan command untuk import
4. **JadwalLengkapSeeder.php** - Database seeder (sample data)

---

## 🎯 Data Jadwal yang Akan Diimport

Dari gambar yang Anda berikan, saya sudah extract **SEMUA jadwal** untuk:

### Kelas 7, 8, dan 9
- **Hari**: Senin, Selasa, Rabu, Kamis, Jumat, Sabtu
- **Mata Pelajaran**: 
  - Matematika
  - Bahasa Indonesia
  - Bahasa Inggris
  - IPA
  - IPS
  - Pendidikan Agama
  - PKN
  - Pendidikan Jasmani (di Lapangan)
  - Seni Budaya
  - Bahasa Sunda
  - Bahasa Arab
  - Tahsin
  - Prakarya
  - Informatika
  - Baca Tulis Al Quran
  - Akidah Akhlak

### Guru yang Terdaftar:
- Maman Suparman, A.K.S
- Nurhadi, S.Pd
- Lola Nurlaelis, S.Pd.I
- Siti Mundari, S.Ag
- Fadli
- Tintin Martini

---

## ⚠️ Catatan Penting

### Sebelum Import, Pastikan:

1. **Guru sudah terdaftar di database**
   - Nama guru di CSV harus sama dengan nama di database
   - Cek di menu "Data Guru" untuk memastikan

2. **MySQL/XAMPP sedang berjalan**
   - Pastikan Apache dan MySQL hijau di XAMPP Control Panel

3. **Format waktu benar**
   - Format: HH:MM - HH:MM
   - Contoh: 07:00 - 08:20

### Jika Ada Error:

1. **"Guru tidak ditemukan"**
   - Tambahkan guru terlebih dahulu di menu Data Guru
   - Atau edit nama guru di file CSV agar sesuai dengan database

2. **"Database connection error"**
   - Pastikan MySQL di XAMPP sudah running
   - Cek file `.env` untuk konfigurasi database

3. **"File not found"**
   - Pastikan file `jadwal_lengkap_import.csv` ada di folder project

---

## 🚀 Hasil Setelah Import

Setelah import berhasil:

1. **Jadwal muncul di halaman TU** → Jadwal Pelajaran
2. **Guru bisa melihat jadwal mereka** di menu Jadwal Mengajar
3. **Jadwal otomatis diset sebagai berulang** setiap minggu
4. **Status jadwal**: Aktif
5. **Semester**: 1
6. **Tahun Ajaran**: 2025/2026

---

## 📞 Troubleshooting

Jika mengalami masalah, coba langkah berikut:

1. **Cek log Laravel**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Clear cache**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

3. **Restart server**
   ```bash
   php artisan serve
   ```

---

## 💡 Tips

- Gunakan **Cara 1 (Web Interface)** untuk import yang lebih mudah dan visual
- Gunakan **Cara 2 (Artisan Command)** jika ingin melihat detail progress
- Gunakan **Cara 3 (Seeder)** untuk testing cepat dengan sample data

---

Semoga berhasil! 🎉

# 🚀 PANDUAN LENGKAP: Import Jadwal dari Excel

## ✅ **Fitur yang Sudah Dibuat:**

1. ✅ Import class untuk baca Excel
2. ✅ Controller untuk handle upload
3. ✅ Route sudah diupdate
4. ✅ Validasi data otomatis
5. ✅ Error handling lengkap

---

## ⏰ **LANGKAH 1: Tunggu Railway Deploy Selesai**

1. Buka Railway Dashboard: https://railway.app
2. Pilih project "TMS Nurani"
3. Klik tab "Deployments"
4. Tunggu sampai deployment terbaru status: **"Deployment successful"** ✅
5. Biasanya 5-15 menit

---

## 📋 **LANGKAH 2: Siapkan File Excel dengan Format yang BENAR**

### **Format Excel:**

**Baris 1 (Header) - WAJIB ADA:**
```
mata_pelajaran | guru | kelas | hari | jam_mulai | jam_selesai | ruang
```

**Baris 2 dst (Data):**
```
Bahasa Arab | Fadli | 7 | jumat | 08:15 | 11:30 | Ruang 7
Matematika | Nurhadi, S.Pd | 7 | selasa | 07:00 | 07:45 | Ruang 7
Bahasa Indonesia | Maman Suparman, A.K.S | 8 | senin | 07:00 | 07:40 | Ruang 8
```

### **⚠️ ATURAN PENTING:**

1. **Nama Guru:**
   - Harus **SAMA PERSIS** dengan nama di database
   - Termasuk gelar (S.Pd, A.K.S, dll)
   - Contoh: "Nurhadi, S.Pd" BUKAN "Nurhadi" atau "nurhadi"

2. **Hari:**
   - Huruf kecil semua
   - Pilihan: senin, selasa, rabu, kamis, jumat, sabtu
   - BUKAN: Senin, SENIN, Sen

3. **Waktu:**
   - Format: HH:MM (contoh: 07:00, 08:15, 11:30)
   - Atau: HH:MM:SS (contoh: 07:00:00)

4. **Kelas:**
   - Angka saja: 7, 8, 9
   - Atau dengan huruf: 7A, 8B

5. **Ruang:**
   - Opsional (boleh kosong)
   - Jika kosong, otomatis jadi "Ruang [kelas]"

---

## 🎯 **LANGKAH 3: Import Excel**

1. **Hard Refresh Browser:**
   - Windows: Ctrl + Shift + R
   - Mac: Cmd + Shift + R

2. **Buka Halaman Jadwal:**
   - Login sebagai TU
   - Klik menu "Jadwal"

3. **Klik "Import Excel"**

4. **Isi Form:**
   - Semester: Pilih 1 atau 2
   - Tahun Ajaran: Isi (contoh: 2025/2026)
   - Upload File Excel: Pilih file yang sudah disiapkan

5. **Klik "Import Jadwal"**

6. **Tunggu Proses:**
   - Sistem akan baca Excel
   - Validasi data
   - Insert ke database
   - Redirect ke halaman jadwal

7. **Lihat Hasilnya:**
   - Data jadwal langsung muncul di tabel
   - Guru otomatis bisa lihat jadwal mereka

---

## ✅ **LANGKAH 4: Verifikasi**

### **Di Halaman TU (Jadwal Pelajaran):**
- Semua jadwal dari Excel muncul
- Bisa edit/hapus jika ada yang salah

### **Di Halaman Guru (Jadwal Mengajar):**
- Guru login
- Klik menu "Jadwal Mengajar"
- Jadwal mereka otomatis muncul

---

## 🆘 **Troubleshooting:**

### **Problem 1: "Guru tidak ditemukan"**
**Penyebab:** Nama guru di Excel tidak sama dengan database

**Solusi:**
1. Cek nama guru di database (menu Data Guru)
2. Pastikan nama di Excel PERSIS SAMA
3. Termasuk spasi, koma, gelar

### **Problem 2: "Hari tidak valid"**
**Penyebab:** Hari tidak huruf kecil atau salah ketik

**Solusi:**
- Gunakan: senin, selasa, rabu, kamis, jumat, sabtu
- Semua huruf kecil

### **Problem 3: "Format waktu tidak valid"**
**Penyebab:** Format waktu salah

**Solusi:**
- Gunakan format: HH:MM (contoh: 07:00, 08:15)
- Atau: HH:MM:SS (contoh: 07:00:00)

### **Problem 4: "File tidak bisa dibaca"**
**Penyebab:** File bukan Excel atau corrupt

**Solusi:**
- Pastikan file .xlsx atau .xls
- Buka file di Excel, pastikan bisa dibuka
- Save ulang jika perlu

---

## 📊 **Contoh File Excel yang Benar:**

### **Sheet 1:**

| mata_pelajaran | guru | kelas | hari | jam_mulai | jam_selesai | ruang |
|---|---|---|---|---|---|---|
| Bahasa Arab | Fadli | 7 | jumat | 08:15 | 11:30 | Ruang 7 |
| Matematika | Nurhadi, S.Pd | 7 | selasa | 07:00 | 07:45 | Ruang 7 |
| Matematika | Nurhadi, S.Pd | 8 | selasa | 07:00 | 07:45 | Ruang 8 |
| Bahasa Indonesia | Maman Suparman, A.K.S | 7 | senin | 07:00 | 07:40 | Ruang 7 |
| Bahasa Indonesia | Maman Suparman, A.K.S | 8 | senin | 07:00 | 07:40 | Ruang 8 |
| Bahasa Sunda | Lola Nurlaelis, S.Pd.I | 7 | rabu | 10:00 | 10:40 | Ruang 7 |

---

## 💡 **Tips:**

1. **Cek Nama Guru Dulu:**
   - Buka menu "Data Guru"
   - Catat nama guru yang PERSIS
   - Copy-paste ke Excel agar tidak salah

2. **Test dengan Data Sedikit Dulu:**
   - Upload 5-10 baris dulu
   - Jika berhasil, baru upload semua

3. **Backup Data:**
   - Simpan file Excel asli
   - Jika ada error, bisa edit dan upload ulang

---

## 🎉 **Setelah Berhasil:**

1. ✅ Jadwal langsung muncul di halaman TU
2. ✅ Guru otomatis bisa lihat jadwal mereka
3. ✅ Tidak perlu input manual satu-satu
4. ✅ Bisa edit/hapus jika ada yang salah

---

**Selamat mencoba! Jika masih ada masalah, screenshot error yang muncul dan hubungi developer.** 🚀

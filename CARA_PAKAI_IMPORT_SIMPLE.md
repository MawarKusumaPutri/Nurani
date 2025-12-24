# 🚀 SOLUSI ALTERNATIF: Import Jadwal Simple

## ✅ Cara Pakai (TANPA TUNGGU RAILWAY!)

### **LANGKAH 1: Akses Script**

Buka browser dan akses:
```
http://localhost/nurani/public/import-jadwal-simple.php
```

### **LANGKAH 2: Isi Form**

1. **Semester:** Pilih Seluruhnya, Semester 1, atau Semester 2
2. **Tahun Ajaran:** Isi (contoh: 2025/2026)
3. **Upload File Excel:** Pilih file Excel Anda

### **LANGKAH 3: Klik "Import Jadwal"**

Data akan langsung masuk ke database dan muncul di halaman jadwal!

---

## 📋 Format Excel yang Harus Diikuti

**Baris 1 (Header):**
```
mata_pelajaran | guru | kelas | hari | jam_mulai | jam_selesai | ruang
```

**Baris 2 dst (Data):**
```
Matematika | Nurhadi | 7 | senin | 07:00 | 07:45 | Ruang 7
Bahasa Indonesia | Maman | 8 | selasa | 08:00 | 08:45 | Ruang 8
```

**Aturan:**
- Nama guru tidak harus sama persis (sistem akan cari otomatis)
- Hari: senin, selasa, rabu, kamis, jumat, sabtu (huruf kecil)
- Waktu: HH:MM (contoh: 07:00, 08:15)

---

## ✅ Keuntungan Solusi Ini

1. ✅ **Langsung bisa dipakai** - Tidak perlu tunggu Railway deploy
2. ✅ **Akses via browser** - Mudah digunakan
3. ✅ **Import otomatis** - Upload Excel, langsung masuk database
4. ✅ **Error handling** - Tampilkan error yang jelas
5. ✅ **Bisa dipakai lokal** - Di localhost

---

## 🎯 Setelah Railway Deploy Selesai

Setelah Railway deploy selesai, Anda bisa pakai fitur import di dashboard TU yang lebih lengkap:
- Akses: Dashboard TU → Jadwal → Import Excel
- Fitur lebih lengkap
- Terintegrasi dengan sistem

---

## 📊 Cara Cek Hasil Import

1. Buka: http://localhost/nurani/public/tu/jadwal
2. Login sebagai TU
3. Lihat tabel jadwal - data yang diimport akan muncul!

---

## 🆘 Troubleshooting

### **Error: "Guru tidak ditemukan"**
**Solusi:** Pastikan nama guru di Excel mirip dengan database

### **Error: "Format waktu tidak valid"**
**Solusi:** Gunakan format HH:MM (contoh: 07:00, 08:15)

### **Error: "Hari tidak valid"**
**Solusi:** Gunakan: senin, selasa, rabu, kamis, jumat, sabtu (huruf kecil)

---

**Selamat mencoba! Script ini bisa langsung dipakai SEKARANG tanpa tunggu Railway!** 🚀

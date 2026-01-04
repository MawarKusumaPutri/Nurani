# 🔧 SOLUSI MASALAH TANGGAL TIDAK SINKRON

## ❌ **MASALAH:**

**Di TU:** Rabu, 31 Desember 2025  
**Di Guru:** Rabu (30 Dec 2025)  

**Perbedaan 1 hari!** ❌

---

## 🔍 **PENYEBAB:**

### **Timezone Issue:**
- **Lokal (Anda):** WIB (UTC+7)
- **Server Railway:** UTC (UTC+0)
- **Perbedaan:** 7 jam

### **Yang Terjadi:**
1. TU input tanggal: **31 Desember 2025 00:00 WIB**
2. JavaScript kirim ke server: **31 Desember 2025 00:00**
3. Server Railway (UTC) terima: **30 Desember 2025 17:00 UTC** (mundur 7 jam)
4. Database simpan: **30 Desember 2025**
5. Guru lihat: **30 Desember 2025** ❌

---

## ✅ **SOLUSI SEMENTARA (MANUAL):**

### **Cara 1: Edit Tanggal di TU**

Saat input jadwal, **tambahkan 1 hari** dari tanggal yang diinginkan:

**Contoh:**
- Ingin jadwal: **Rabu, 31 Desember 2025**
- Input di TU: **Kamis, 1 Januari 2026**
- Hasil di Guru: **Rabu, 31 Desember 2025** ✅

### **Cara 2: Edit Data yang Sudah Ada**

1. Login sebagai TU
2. Buka **Jadwal** → **Edit** jadwal Bahasa Indonesia (Desi Nurfatah)
3. Ubah tanggal dari "Rabu, 31 Desember" ke **"Kamis, 1 Januari 2026"**
4. Klik **Simpan**
5. Login sebagai Guru (Desi Nurfatah)
6. Lihat jadwal → Tanggal sudah benar: **"Rabu, 31 Desember 2025"** ✅

---

## 🔧 **SOLUSI PERMANEN (KODE):**

Saya perlu update JavaScript di file `edit.blade.php` dan `create.blade.php` untuk menambahkan offset timezone:

### **File yang Perlu Diupdate:**
1. `resources/views/tu/jadwal/create.blade.php`
2. `resources/views/tu/jadwal/edit.blade.php`

### **Perubahan:**

**Sebelum:**
```javascript
document.getElementById('tanggal').value = selectedDate.toISOString().split('T')[0];
```

**Sesudah:**
```javascript
// Adjust for timezone offset (WIB = UTC+7)
const offset = selectedDate.getTimezoneOffset();
const adjustedDate = new Date(selectedDate.getTime() - (offset * 60 * 1000));
document.getElementById('tanggal').value = adjustedDate.toISOString().split('T')[0];
```

---

## ⏰ **UNTUK SEKARANG:**

### **Langkah Cepat:**

1. **Login sebagai TU**
2. **Edit Jadwal** Bahasa Indonesia untuk Desi Nurfatah
3. **Ubah tanggal** dari "Rabu, 31 Desember" ke **"Kamis, 1 Januari 2026"**
4. **Klik Simpan**
5. **Login sebagai Guru** (Desi Nurfatah)
6. **Cek Jadwal Mengajar** → Tanggal sudah benar! ✅

---

## 📝 **CATATAN:**

- Masalah ini hanya terjadi karena perbedaan timezone antara lokal (WIB) dan server (UTC)
- Solusi permanen memerlukan update kode JavaScript
- Untuk sekarang, gunakan solusi manual (tambah 1 hari saat input)

---

## 🎯 **KESIMPULAN:**

**Masalah:** Timezone UTC vs WIB  
**Dampak:** Tanggal mundur 1 hari  
**Solusi Cepat:** Edit tanggal di TU, tambah 1 hari  
**Solusi Permanen:** Update JavaScript (akan saya lakukan)

---

**Apakah Anda ingin saya update kode JavaScript sekarang untuk solusi permanen?**

Atau gunakan solusi manual dulu (edit tanggal + 1 hari)?

---

**Dibuat:** 2025-12-31 16:35  
**Status:** ⚠️ Timezone Issue  
**Solusi:** Manual (edit +1 hari) atau Update Kode

# 📋 SPESIFIKASI HOSTING - TMS NURANI
## Jawaban untuk Pertanyaan Dosen

---

## 1️⃣ **Kebutuhannya untuk apa?**

**Jawaban:** 
- ✅ **Production (Operation)** - Aplikasi untuk operasional sekolah MTs Nurul Aiman
- ✅ Sistem digunakan oleh Guru, Kepala Sekolah, dan Tenaga Usaha untuk aktivitas harian
- ✅ Perlu **stabilitas tinggi** dan **uptime 24/7**

**Rekomendasi:** Pilih hosting **Production** dengan SLA tinggi

---

## 2️⃣ **Butuh Storage Berapa?**

**Jawaban:** 
- **Minimum:** 5 GB
- **Recommended:** 10-20 GB  
- **Ideal:** 20-50 GB (untuk pertumbuhan jangka panjang)

**Perhitungan:**
- Aplikasi Laravel: ~300 MB
- Database: ~300 MB (awal), bisa tumbuh hingga 1-2 GB
- Foto Profil: ~50 MB (13 guru + 2 admin)
- File Materi: ~100-600 MB
- Logs & Cache: ~300 MB
- Backup: ~700 MB

**Total:** ~2.5 GB (minimum), **Recommended: 10-20 GB**

**Rekomendasi Hosting:**
- Hostinger: 100 GB ✅
- Niagahoster: 5-10 GB ✅
- Rumahweb: 10 GB ✅

---

## 3️⃣ **Coding/Framework Webnya Pakai Apa?**

**Jawaban:**

### ✅ **Yang Digunakan:**
- **Backend:** Laravel 12.0 (PHP Framework)
- **PHP:** PHP 8.2 atau lebih tinggi (WAJIB!)
- **Frontend:** JavaScript + TailwindCSS 4.0 + Vite 7.0
- **Database:** MySQL atau MariaDB
- **Server:** Apache atau Nginx
- **Build Tool:** Vite (menggunakan Node.js untuk build)

### ❌ **TIDAK Menggunakan:**
- ❌ Python
- ❌ Java
- ❌ AI/ML (tidak ada fitur AI/ML)
- ❌ Node.js Backend (hanya untuk build tool)

**RINGKASAN:**
```
Backend:     Laravel 12.0 (PHP 8.2+)
Frontend:    JavaScript + TailwindCSS + Vite
Database:    MySQL/MariaDB
Server:      Apache/Nginx
```

**Hosting yang Cocok:**
- ✅ Shared Hosting dengan PHP 8.2+ support
- ✅ VPS dengan akses root
- ✅ Cloud Hosting (AWS, DigitalOcean)

**Hosting yang TIDAK Cocok:**
- ❌ Hosting yang hanya support PHP 7.x
- ❌ Hosting yang tidak support Composer
- ❌ Hosting yang tidak support MySQL/MariaDB

---

## 4️⃣ **Butuh Komputasi Berapa?**

**Jawaban:**
- **Minimum:** 1 CPU Core, 512 MB RAM
- **Recommended:** 2 CPU Cores, 1-2 GB RAM
- **Ideal:** 2-4 CPU Cores, 2-4 GB RAM

**Perhitungan:**
- Aplikasi Laravel: ~100-500 MB RAM (tergantung traffic)
- Database MySQL: ~100-300 MB RAM
- Web Server: ~50-100 MB RAM
- **Total:** ~512 MB (minimum), **Recommended: 1-2 GB RAM**

**Traffic Estimasi:**
- User Concurrent: 10-50 user (guru + admin)
- Page Views: ~100-500 per hari
- Traffic: Rendah-Menengah

**Rekomendasi Hosting:**

### **Untuk Testing/Staging:**
- Shared Hosting Basic: 1 CPU, 512 MB RAM ✅
- Hostinger Single: 1 CPU, 1 GB RAM ✅

### **Untuk Production:**
- Shared Hosting Premium: 2 CPU, 1-2 GB RAM ✅
- Hostinger Premium: 2 CPU, 2 GB RAM ✅
- VPS Basic: 2 CPU, 2 GB RAM ✅

---

## 📊 RINGKASAN SPESIFIKASI

| Aspek | Minimum | Recommended | Ideal |
|-------|---------|-------------|-------|
| **Storage** | 5 GB | 10-20 GB | 20-50 GB |
| **RAM** | 512 MB | 1-2 GB | 2-4 GB |
| **CPU** | 1 Core | 2 Cores | 2-4 Cores |
| **PHP** | 8.2+ | 8.2+ | 8.3+ |
| **Database** | MySQL 5.7+ | MySQL 8.0+ | MySQL 8.0+ |
| **Bandwidth** | 10 GB/bulan | 50 GB/bulan | Unlimited |

---

## 🎯 REKOMENDASI HOSTING

### ✅ **OPSI 1: Hostinger (DISARANKAN)**

**Paket:** Business Web Hosting
- Storage: 100 GB
- RAM: 2 GB
- CPU: 2 Cores
- PHP: 8.2+ ✅
- MySQL: ✅
- Harga: ~Rp 15.000-25.000/bulan

**Keuntungan:**
- ✅ Spesifikasi lebih dari cukup
- ✅ Support Laravel dengan baik
- ✅ Harga terjangkau

---

### ✅ **OPSI 2: Niagahoster**

**Paket:** Business Hosting
- Storage: 10 GB
- RAM: 1-2 GB
- CPU: 1-2 Cores
- PHP: 8.2+ ✅
- MySQL: ✅
- Harga: ~Rp 10.000-20.000/bulan

**Keuntungan:**
- ✅ Harga murah
- ✅ Support lokal (Indonesia)

---

### ✅ **OPSI 3: Rumahweb**

**Paket:** Paket Bisnis
- Storage: 10 GB
- RAM: 1-2 GB
- CPU: 1-2 Cores
- PHP: 8.2+ ✅
- MySQL: ✅
- Harga: ~Rp 12.000-18.000/bulan

---

## ✅ CHECKLIST HOSTING

### **WAJIB ADA:**
- [ ] PHP 8.2 atau lebih tinggi
- [ ] MySQL 5.7+ atau MariaDB 10.3+
- [ ] Composer support
- [ ] SSH access
- [ ] Apache atau Nginx
- [ ] SSL Certificate

### **SANGAT DISARANKAN:**
- [ ] Node.js & NPM (untuk build frontend)
- [ ] Git support
- [ ] Cron jobs
- [ ] Email support
- [ ] Backup otomatis

---

## 🎯 KESIMPULAN UNTUK DOSEN

**1. Kebutuhannya untuk apa?**
→ **Production (Operation)** - Sistem operasional sekolah

**2. Butuh Storage Berapa?**
→ **Minimum 5 GB, Recommended 10-20 GB**

**3. Coding/Framework Webnya Pakai Apa?**
→ **Laravel 12.0 (PHP 8.2+), JavaScript + TailwindCSS, MySQL/MariaDB**
→ **TIDAK pakai Python, Java, atau AI/ML**

**4. Butuh Komputasi Berapa?**
→ **Minimum: 1 CPU, 512 MB RAM**
→ **Recommended: 2 CPU, 1-2 GB RAM**

**Rekomendasi Hosting:**
→ **Hostinger Business** atau **Niagahoster Business**

---

**💡 Catatan:** Spesifikasi di atas sudah disesuaikan dengan kebutuhan aplikasi TMS NURANI yang sebenarnya.



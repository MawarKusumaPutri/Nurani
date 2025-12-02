# 🔐 Panduan Login Otomatis dan Sinkronisasi Data

## ✅ PERBAIKAN YANG SUDAH DILAKUKAN

### 1. **Remember Me (Auto-Login)**
- ✅ Checkbox "Ingat saya" ditambahkan di form login
- ✅ Jika dicentang, kredensial akan tersimpan di browser
- ✅ Login otomatis saat membuka halaman login berikutnya

### 2. **Auto-Fill Email Berdasarkan Role**
- ✅ Saat memilih role (Guru/TU/Kepala Sekolah), email akan otomatis terisi
- ✅ Email diambil dari database berdasarkan role yang dipilih
- ✅ Memudahkan login tanpa harus mengetik email manual

### 3. **Sinkronisasi Data User**
- ✅ Script `SINKRONISASI_DATA_USER.bat` untuk sinkronisasi data
- ✅ Menjalankan `UserSeeder` dan `GuruSeeder` secara otomatis
- ✅ Memastikan semua data user (Guru, TU, Kepala Sekolah) tersinkron

### 4. **Security Warning Fix**
- ✅ Meta tag `upgrade-insecure-requests` ditambahkan
- ✅ Mengurangi warning keamanan saat login melalui Ngrok

---

## 📋 CARA MENGGUNAKAN

### Langkah 1: Sinkronisasi Data User

**Jalankan script sinkronisasi:**
1. Double-click: `SINKRONISASI_DATA_USER.bat`
2. Tunggu hingga selesai
3. Data user akan tersinkron dengan database

**Atau manual:**
```bash
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=GuruSeeder
```

---

### Langkah 2: Login dengan Auto-Fill

**Cara menggunakan auto-fill:**
1. Buka halaman login
2. Pilih **Role** (Guru/TU/Kepala Sekolah)
3. **Email akan otomatis terisi** dari database
4. Masukkan password
5. Centang **"Ingat saya"** (opsional, untuk auto-login)
6. Klik **"Masuk ke TMS"**

**Jika muncul security warning:**
- Klik **"Send anyway"** (ini normal untuk Ngrok free)
- Atau klik **"Go back"** dan coba lagi

---

### Langkah 3: Remember Me (Auto-Login)

**Cara menggunakan Remember Me:**
1. Saat login, centang **"Ingat saya"**
2. Login seperti biasa
3. **Kredensial akan tersimpan** di browser
4. **Saat membuka halaman login berikutnya**, email dan role akan otomatis terisi
5. Tinggal masukkan password dan login

**Catatan:**
- Kredensial tersimpan di **localStorage** browser
- Hanya tersimpan di browser yang sama
- Bisa dihapus dengan clear browser data

---

## 🔧 TROUBLESHOOTING

### 1. Email Tidak Auto-Fill

**Penyebab:**
- Data user belum tersinkron
- Role tidak dipilih
- API endpoint tidak bisa diakses

**Solusi:**
1. Jalankan `SINKRONISASI_DATA_USER.bat`
2. Pastikan role dipilih terlebih dahulu
3. Cek console browser untuk error
4. Pastikan Apache dan Laravel berjalan

---

### 2. Remember Me Tidak Berfungsi

**Penyebab:**
- Browser memblokir localStorage
- Browser dalam mode incognito/private
- Data localStorage terhapus

**Solusi:**
1. Pastikan browser tidak dalam mode incognito
2. Cek pengaturan browser (allow localStorage)
3. Clear browser cache dan coba lagi
4. Gunakan browser lain untuk test

---

### 3. Security Warning Masih Muncul

**Penyebab:**
- Normal untuk Ngrok free tier
- Form dikirim melalui HTTP (tidak secure)

**Solusi:**
- **Klik "Send anyway"** (aman untuk testing)
- Atau upgrade ke Ngrok paid plan (HTTPS)
- Atau gunakan hosting dengan SSL

---

## 📊 DATA USER YANG TERSINKRON

### Guru
- Email dari `UserSeeder` dan `GuruSeeder`
- Password sesuai dengan yang di-set di seeder
- Mata pelajaran otomatis terisi

### TU (Tenaga Usaha)
- Email: `internal.nurulaiman@gmail.com`
- Password: `AdminTU@2024`
- Atau email dari `GuruSeeder` (siti.tu@nurani.com, ahmad.tu@nurani.com)

### Kepala Sekolah
- Email: `mamansuparmanaks07@gmail.com`
- Password: `AdminKS@2024`

---

## ✅ CHECKLIST

- [ ] Jalankan `SINKRONISASI_DATA_USER.bat`
- [ ] Data user tersinkron dengan database
- [ ] Test auto-fill email berdasarkan role
- [ ] Test remember me (auto-login)
- [ ] Test login dengan kredensial yang benar
- [ ] Jika muncul security warning, klik "Send anyway"

---

## 🎯 RINGKASAN

**Fitur yang sudah ditambahkan:**
1. ✅ **Remember Me** - Auto-login dengan checkbox
2. ✅ **Auto-Fill Email** - Email otomatis terisi berdasarkan role
3. ✅ **Sinkronisasi Data** - Script otomatis untuk sinkron data user
4. ✅ **Security Warning Fix** - Meta tag untuk mengurangi warning

**Cara pakai:**
1. Jalankan `SINKRONISASI_DATA_USER.bat` untuk sinkron data
2. Pilih role → Email otomatis terisi
3. Masukkan password
4. Centang "Ingat saya" untuk auto-login
5. Klik "Masuk ke TMS"

**Selesai!** ✅

---

**Intinya: Login sekarang lebih mudah dengan auto-fill email dan remember me!** 🎯


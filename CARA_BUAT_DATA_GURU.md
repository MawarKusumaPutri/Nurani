# ✅ Cara Buat Data Guru untuk Login

## 🎯 TUJUAN

**Membuat data guru di database agar bisa login ke aplikasi.**

---

## ✅ CARA 1: Menggunakan Script Otomatis (TERMUDAH!)

**Jalankan script yang sudah saya buat:**

1. **Pastikan MySQL sudah berjalan di XAMPP** (Start MySQL di XAMPP Control Panel)
2. **Double-click file:** `BUAT_DATA_GURU.bat`
3. **Script akan otomatis:**
   - Jalankan migrations (jika belum)
   - Buat data guru dengan email dan password

**Atau jalankan manual:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
.\BUAT_DATA_GURU.bat
```

---

## ✅ CARA 2: Manual via Command Line

### Langkah 1: Jalankan Migrations

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

### Langkah 2: Jalankan Seeder

```powershell
php artisan db:seed --class=UserSeeder
```

---

## 📋 DATA GURU YANG AKAN DIBUAT

**Berikut data guru yang akan dibuat:**

1. **Syifa Restu R**
   - Email: `syifarestu81@gmail.com`
   - Mata Pelajaran: TU & Seni Budaya
   - Password: `password123`

2. **Keysa Anjani**
   - Email: `keysa8406@gmail.com`
   - Mata Pelajaran: Bahasa Inggris
   - Password: `password123`

3. **Desi Nurfalah**
   - Email: `desinurfalah24@gmail.com`
   - Mata Pelajaran: Bahasa Indonesia
   - Password: `password123`

4. **Sopyan**
   - Email: `sopyanikhsananda@gmail.com`
   - Mata Pelajaran: PKN
   - Password: `password123`

5. **Weni Azmi**
   - Email: `wenibustamin27@gmail.com`
   - Mata Pelajaran: Tahsin
   - Password: `password123`

6. **Tintin Martini**
   - Email: `tintinmartini184@gmail.com`
   - Mata Pelajaran: BTQ
   - Password: `password123`

7. **Fadli**
   - Email: `fadliziyad123@gmail.com`
   - Mata Pelajaran: Bahasa Arab
   - Password: `password123`

8. **Siti Mundari**
   - Email: `sitimundari54@gmail.com`
   - Mata Pelajaran: IPA, Prakarya
   - Password: `password123`

9. **Nurhadi**
   - Email: `mundarinurhadi@gmail.com`
   - Mata Pelajaran: Matematika
   - Password: `password123`

10. **Hamzah Najmudin**
    - Email: `zahnajmudin10@gmail.com`
    - Mata Pelajaran: PJOK, IPS
    - Password: `password123`

11. **Rizmal**
    - Email: `rizmalmaulana25@gmail.com`
    - Mata Pelajaran: QH, FIQIH
    - Password: `password123`

---

## 🔐 PASSWORD DEFAULT

**Password default untuk semua guru:** `password123`

**Guru bisa ubah password sendiri setelah login:**
1. Login dengan password default
2. Buka menu Profile/Profil
3. Ubah password sesuai keinginan

---

## 🆘 JIKA MASIH ERROR

### Error: "MySQL belum berjalan"

**Solusi:**
- Buka XAMPP Control Panel
- Klik "Start" pada MySQL
- Tunggu sampai MySQL benar-benar start (hijau)

### Error: "Migrations gagal"

**Solusi:**
- Cek apakah database 'nurani' sudah ada
- Jika belum, buat database di phpMyAdmin
- Atau jalankan script fix migrations

### Error: "Seeder gagal"

**Solusi:**
- Pastikan migrations sudah jalan
- Cek apakah tabel `users` dan `gurus` sudah ada
- Cek error message untuk detail

---

## 📋 CHECKLIST

### ✅ Sebelum Buat Data:
- [ ] MySQL sudah berjalan di XAMPP
- [ ] Database 'nurani' sudah ada
- [ ] Migrations sudah jalan

### ✅ Buat Data:
- [ ] Jalankan script `BUAT_DATA_GURU.bat`
- [ ] Atau jalankan seeder manual
- [ ] Cek data sudah terbuat di database

### ✅ Test Login:
- [ ] Buka aplikasi → `http://localhost/nurani/public/`
- [ ] Klik "LOGIN" → Pilih role "GURU"
- [ ] Test login dengan email dan password default
- [ ] Pastikan bisa masuk ke dashboard

---

## 💡 TIPS

1. **Gunakan script otomatis** - Paling mudah dan cepat
2. **Password default:** `password123` - Guru bisa ubah sendiri
3. **Test login setelah data dibuat** - Pastikan semua guru bisa login
4. **Jika ada guru yang tidak bisa login** - Cek email dan password di database

---

## 🎯 REKOMENDASI

**Gunakan Cara 1 (Script Otomatis) dulu!**

**Ini paling mudah dan pasti bekerja.**

**Setelah data dibuat, test login untuk memastikan semua guru bisa masuk!**

---

**Jalankan script `BUAT_DATA_GURU.bat` untuk membuat data guru! 🚀**

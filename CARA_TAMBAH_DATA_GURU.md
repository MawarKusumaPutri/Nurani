# ✅ Cara Tambah Data Guru ke Database

## 🎯 TUJUAN

**Menambahkan data guru ke database dengan password yang benar dari LOGIN_CREDENTIALS.md**

---

## ✅ CARA TERMUDAH: Script Otomatis

### Langkah 1: Jalankan Script

**Double-click file:** `TAMBAH_DATA_GURU_LENGKAP.bat`

**Script akan otomatis:**
1. ✅ Cek apakah tabel sudah ada
2. ✅ Jika belum ada, jalankan migrations dulu
3. ✅ Update/tambah data guru dengan password yang benar
4. ✅ Tambah guru baru (Lola Nurlaela dan Mawar)

---

## ⚠️ JIKA MASIH ADA ERROR TABLESPACE

### Solusi: Fix Manual di phpMyAdmin (Sekali Saja)

**Jika script masih error karena tablespace, ikuti langkah ini:**

#### Langkah 1: Buka phpMyAdmin

1. **Buka browser** → `http://localhost/phpmyadmin`
2. **Klik tab "SQL"** di bagian atas (tidak perlu pilih database dulu)

#### Langkah 2: Jalankan SQL

**Copy dan paste SQL berikut:**

```sql
DROP DATABASE IF EXISTS nurani;
CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. **Klik "Go"** untuk menjalankan

#### Langkah 3: Jalankan Script Lagi

**Setelah fix di phpMyAdmin, jalankan script lagi:**

- **Double-click:** `TAMBAH_DATA_GURU_LENGKAP.bat`

**Atau jalankan manual di terminal:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
php artisan db:seed --class=UserSeeder
```

---

## 📋 DATA GURU YANG AKAN DITAMBAH/UPDATE

### Guru yang Diupdate Password:

1. **Nurhadi, S.Pd** - `mundarinurhadi@gmail.com` / `Nurhadi2024!` - Matematika
2. **Keysa Anjani** - `keysa8406@gmail.com` / `Keysha2024!` - Bahasa Inggris
3. **Fadli** - `fadliziyad123@gmail.com` / `Fadli2024!` - Bahasa Arab
4. **Siti Mundari, S.Ag** - `sitimundari54@gmail.com` / `SitiMundari2024!` - IPA, Prakarya
5. **Desi Nurfalah** - `desinurfalah24@gmail.com` / `DesyNurfalah2024!` - Bahasa Indonesia
6. **M. Rizmal Maulana** - `rizmalmaulana25@gmail.com` / `RizmalMaulana2024!` - QH, FIQIH
7. **Hamzah Najmudin** - `zahnajmudin10@gmail.com` / `HamzahNazmudin2024!` - PJOK, IPS
8. **Sopyan** - `sopyanikhsananda@gmail.com` / `Sopyan2024!` - PKN
9. **Syifa Restu R** - `syifarestu81@gmail.com` / `SyifaRestu2024!` - Seni Budaya
10. **Weni Azmi** - `wenibustamin27@gmail.com` / `Weny2024!` - Tahsin
11. **Tintin Martini** - `tintinmartini184@gmail.com` / `TintinMartini2024!` - BTQ

### Guru Baru yang Ditambahkan:

12. **Lola Nurlaela, S.Pd.I.** - `lola.nurlaela@mtssnuraiman.sch.id` / `LolaNurlaela2024!` - SKI, Akidah Akhlak
13. **Mawar** - `mawarkusuma694@gmail.com` / `Mawar2024!` - Belum ditentukan

---

## ✅ CEK HASIL

### Cara 1: Cek dengan Script

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php cek_data_guru.php
```

### Cara 2: Cek di phpMyAdmin

1. **Buka phpMyAdmin** → `http://localhost/phpmyadmin`
2. **Klik database "nurani"** di sidebar kiri
3. **Klik tabel "users"**
4. **Cek apakah ada 13 guru dengan email dan password yang benar**

### Cara 3: Test Login

1. **Buka aplikasi** → `http://localhost/nurani/public/`
2. **Klik "LOGIN"** → Pilih role "GURU"
3. **Test login dengan password baru:**
   - Email: `mundarinurhadi@gmail.com`
   - Password: `Nurhadi2024!`
4. **Jika berhasil masuk** = Password sudah diupdate! ✅

---

## 🆘 TROUBLESHOOTING

### Error: "Table 'users' doesn't exist"

**Solusi:**
- Migrations belum jalan
- Jalankan: `php artisan migrate --force`

### Error: "Tablespace for table 'migrations' exists"

**Solusi:**
1. Fix manual di phpMyAdmin (lihat "Solusi: Fix Manual" di atas)
2. Setelah itu, jalankan script lagi

### Error: "Data guru belum terupdate"

**Solusi:**
- Seeder belum jalan
- Jalankan: `php artisan db:seed --class=UserSeeder`

---

## 📋 CHECKLIST

### ✅ Setup:
- [ ] MySQL sudah berjalan di XAMPP
- [ ] Script `TAMBAH_DATA_GURU_LENGKAP.bat` sudah ada
- [ ] File `UserSeeder.php` sudah diupdate

### ✅ Jalankan:
- [ ] Double-click `TAMBAH_DATA_GURU_LENGKAP.bat`
- [ ] Jika error tablespace, fix manual di phpMyAdmin
- [ ] Jalankan script lagi setelah fix

### ✅ Verifikasi:
- [ ] Cek data guru dengan `php cek_data_guru.php`
- [ ] Test login dengan password baru
- [ ] Pastikan bisa masuk ke dashboard
- [ ] Pastikan ada 13 guru (termasuk Lola dan Mawar)

---

## 💡 TIPS

1. **Gunakan script otomatis** - Paling mudah dan cepat
2. **Jika error tablespace** - Fix manual di phpMyAdmin sekali, lalu script otomatis bisa jalan
3. **Cek hasil dengan script** - `php cek_data_guru.php`
4. **Test login setelah data dibuat** - Pastikan password baru berfungsi

---

## 🎯 REKOMENDASI

**Gunakan `TAMBAH_DATA_GURU_LENGKAP.bat` untuk menambahkan data guru!**

**Setelah data ditambahkan, test login untuk memastikan password baru berfungsi!**

---

**Jalankan script untuk menambahkan data guru! 🚀**

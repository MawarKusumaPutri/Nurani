# ✅ Cara Masukkan Data Guru ke Database

## 🎯 TUJUAN

**Memasukkan data guru dari LOGIN_CREDENTIALS.md ke database.**

---

## ⚠️ PENTING: Pastikan Migrations Sudah Dijalankan!

**Sebelum memasukkan data guru, pastikan:**
1. ✅ Migrations sudah dijalankan (tabel sudah dibuat)
2. ✅ Database sudah ada
3. ✅ Tidak ada error tablespace

---

## ✅ CARA TERMUDAH: Script Otomatis

### Langkah 1: Pastikan Migrations Sudah Dijalankan

**Jika tabel belum ada, jalankan migrations dulu:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan migrate --force
```

**Jika masih error tablespace, fix dulu di phpMyAdmin:**
1. Buka `http://localhost/phpmyadmin`
2. Tab SQL - Jalankan:
   ```sql
   DROP DATABASE IF EXISTS nurani;
   CREATE DATABASE nurani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. Setelah itu, jalankan migrations lagi

### Langkah 2: Masukkan Data Guru

**Double-click file:** `MASUKKAN_DATA_GURU.bat`

**Atau jalankan manual:**

```powershell
cd "D:\Praktikum DWBI\xampp\htdocs\nurani"
php artisan db:seed --class=UserSeeder
```

---

## 📋 DATA GURU YANG AKAN DIMASUKKAN

### 13 Guru dengan Email dan Password:

1. **Nurhadi, S.Pd** - `mundarinurhadi@gmail.com` / `Nurhadi2024!` - Matematika
2. **Keysa Anjani** - `keysa8406@gmail.com` / `Keysha2024!` - Bahasa Inggris
3. **Fadli** - `fadliziyad123@gmail.com` / `Fadli2024!` - Bahasa Arab
4. **Siti Mundari, S.Ag** - `sitimundari54@gmail.com` / `SitiMundari2024!` - IPA, Prakarya
5. **Lola Nurlaela, S.Pd.I.** - `lola.nurlaela@mtssnuraiman.sch.id` / `LolaNurlaela2024!` - SKI, Akidah Akhlak
6. **Desi Nurfalah** - `desinurfalah24@gmail.com` / `DesyNurfalah2024!` - Bahasa Indonesia
7. **M. Rizmal Maulana** - `rizmalmaulana25@gmail.com` / `RizmalMaulana2024!` - QH, FIQIH
8. **Hamzah Najmudin** - `zahnajmudin10@gmail.com` / `HamzahNazmudin2024!` - PJOK, IPS
9. **Sopyan** - `sopyanikhsananda@gmail.com` / `Sopyan2024!` - PKN
10. **Syifa Restu R** - `syifarestu81@gmail.com` / `SyifaRestu2024!` - Seni Budaya
11. **Weni Azmi** - `wenibustamin27@gmail.com` / `Weny2024!` - Tahsin
12. **Tintin Martini** - `tintinmartini184@gmail.com` / `TintinMartini2024!` - BTQ
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
3. **Test login dengan salah satu email guru:**
   - Email: `mundarinurhadi@gmail.com`
   - Password: `Nurhadi2024!`
4. **Jika berhasil masuk** = Data sudah dimasukkan! ✅

---

## 🆘 TROUBLESHOOTING

### Error: "Table 'users' doesn't exist"

**Solusi:**
- Migrations belum jalan
- Jalankan: `php artisan migrate --force`

### Error: "Tablespace for table 'migrations' exists"

**Solusi:**
1. Fix manual di phpMyAdmin (lihat "Langkah 1" di atas)
2. Setelah itu, jalankan migrations dan seeder lagi

### Error: "Data guru belum masuk"

**Solusi:**
- Seeder belum jalan
- Jalankan: `php artisan db:seed --class=UserSeeder`

---

## 📋 CHECKLIST

### ✅ Sebelum Masukkan Data:
- [ ] Migrations sudah dijalankan
- [ ] Tabel sudah dibuat (cek di phpMyAdmin)
- [ ] Tidak ada error tablespace

### ✅ Masukkan Data:
- [ ] Jalankan script `MASUKKAN_DATA_GURU.bat`
- [ ] Atau jalankan: `php artisan db:seed --class=UserSeeder`

### ✅ Verifikasi:
- [ ] Cek data guru dengan `php cek_data_guru.php`
- [ ] Cek di phpMyAdmin apakah ada 13 guru
- [ ] Test login dengan email guru
- [ ] Pastikan bisa masuk ke dashboard

---

## 💡 TIPS

1. **Pastikan migrations sudah jalan** - Paling penting!
2. **Gunakan script otomatis** - Paling mudah dan cepat
3. **Cek hasil dengan script** - `php cek_data_guru.php`
4. **Test login setelah data dimasukkan** - Pastikan email dan password berfungsi

---

## 🎯 REKOMENDASI

**Gunakan `MASUKKAN_DATA_GURU.bat` untuk memasukkan data guru!**

**Pastikan migrations sudah dijalankan dulu sebelum memasukkan data!**

---

**Jalankan script untuk memasukkan data guru! 🚀**
